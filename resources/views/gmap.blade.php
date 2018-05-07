<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Google Maps APIs</title>
</head>

<body>

	<style type="text/css">
		html,
		body {
			height: 100%;
			margin: 0;
			padding: 0;
		}
		#map {
			height: 100%;
			width:300px;
			float:left;
		}
	</style>
	<?php

        $data['cities'] = $data['states'] = $data['branchname'] = $data['branchcode'] = [];

        foreach ($allbranches as $branch) {
            $state = trim($branch['State']);
            $city = trim($branch['City']);
            $code = (int) $branch['BranchCode'];
            $branchname = trim($branch['BranchName']);
            $data['cities'][$city] = $city;
            $data['states'][$state][$city] = $city;
            $data['statebranches'][$state][$code] = $branchname;
            $data['citybranches'][$city][$code] = $branchname;
            $data['branchname'][$code] = $branchname;
            $data['branchcode'][$code] = $branch;
        }

		$jsondata = json_encode($data);
	?>
    <label>State</label>
    <select name="state" id="state">
        <option selected="selected" value="">Select State</option>
        <?php foreach ($data['states'] as $state => $cities) {
            echo '<option value="'.$state.'">'.$state.'</option>';
        }?>
    </select>
    <label>City</label>
    <select name="city" id="city">
        <option selected="selected" value="">Select City</option>
        <?php foreach ($data['cities'] as $city) {
            echo '<option value="'.$city.'">'.$city.'</option>';
        }?>
    </select>
    <label>Branch</label>
    <select name="branchcode" id="branchcode">
        <option selected="selected" value="">Select Branch</option>
        <?php foreach ($data['branchname'] as $key => $branch) {
            echo '<option value="'.$key.'">'.$branch.'</option>';
        }?>
    </select>

	<div id="map"></div>
	<div class="allBranches"></div>

	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBv-cwgKjyE3NNfgTHyHNc2Q9GKu8TkHa4&callback=initMap"></script>
	<script type='text/javascript' src='http://localhost/theeb/wp-includes/js/jquery/jquery.js?ver=1.12.4'></script>

</body>

<script type="text/javascript">
	var branches = <?php echo $jsondata ?>;
    var branch_detail_html = '<div class="eachBranch"><div class="brancheTitle">{branchname}</div><div class="brancheInfo">{branchname}<br>Phone Number : {telephone}<br>Fax : {fax}<br> Mobile : {telephone1}   <br>CustomerService : ?  <br>Address : {address} <br></div></div>';
    var citylist = '<option selected="selected" value="">Select City</option>';
    var branchlist = '<option selected="selected" value="">Select Branch</option>';

</script>
<script>
    var $ = jQuery;
    var sidebarbranches = [];

    function initMap()
    {
        showBranchesDetailandMap(branches['branchname'], branch_detail_html);
    }

    function renderDropdownMenu(element_id, somehtml='', data)
    {
        optnlist = somehtml;
        $.each(data , function(index, value) {
            optnlist = optnlist+'<option value="'+index+'">'+value+'</option>';
        });
        $(element_id).html(optnlist);
        return;
    }

    function showBranchesDetailandMap(data, somehtml = '')
    {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var bounds = new google.maps.LatLngBounds();

        var infowindow = new google.maps.InfoWindow({});

        var marker;
        var i = 0;
        var detail_html = '';
        $.each(data , function(index, val) {
        	var lat = branches['branchcode'][index]['BranchLat'];
        	var lng = branches['branchcode'][index]['BranchLong'];
        	var info = branches['branchcode'][index]['DistAreaName'];
        	var name = branches['branchcode'][index]['BranchName'];
        	var tel = branches['branchcode'][index]['Telephone'];
        	var tel1 = branches['branchcode'][index]['Telephone1'];
        	var fax = branches['branchcode'][index]['Fax'];
        	var addr = branches['branchcode'][index]['DistAreaName'] +', '+branches['branchcode'][index]['City']+', '+branches['branchcode'][index]['OpAreaName'];
        	var mapObj = {
        		'{branchname}': name,
				'{telephone}': tel,
				'{fax}': fax,
				'{telephone1}': tel1,
				'{address}': addr
        	};
			var content = somehtml.replace(/{branchname}|{telephone}|{fax}|{telephone1}|{address}/g, function(matched) {
				return mapObj[matched];
			});
			detail_html += content+'<br><br>';
            if (!lat || !lng) {
                return true;
            }
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                map: map
            });
            bounds.extend(marker.position);
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(info);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            google.maps.event.trigger(map, 'resize');
            i++;
        });
        map.fitBounds(bounds);
        $('.allBranches').html(detail_html);
        //return;
    }

    $('#state').on('change', function() {
        var selected_state = $(this).val().trim();
        /*===========Populate cities=============*/
        if (selected_state in branches['states']) {
            showcities = branches['states'][selected_state];
            sidebarbranches = branches['statebranches'][selected_state];
        } else {
            showcities = branches['cities'];
            sidebarbranches = branches['branchcode'];
        }
        renderDropdownMenu('#city', citylist, showcities);
        showBranchesDetailandMap(sidebarbranches, branch_detail_html);
        /*===========Populate cities=============*/

        /*===========Populate branches=============*/
        if (selected_state in branches['statebranches']) {
            showbranches = branches['statebranches'][selected_state];
        } else {
            showbranches = branches['branchname'];
        }
        renderDropdownMenu('#branchcode', branchlist, showbranches);
        /*===========Populate branches=============*/

    });

    $('#city').on('change', function() {
        var selected_city = $(this).val().trim();
        var selected_state = $('#state').val().trim();

        /*===========Populate branches=============*/
        if (selected_city in branches['citybranches']) {
            sidebarbranches = showbranches = branches['citybranches'][selected_city];
        } else if (selected_state in branches['statebranches']) {
            sidebarbranches = showbranches = branches['statebranches'][selected_state];
        } else {
            sidebarbranches = showbranches = branches['branchname'];
        }
        renderDropdownMenu('#branchcode', branchlist, showbranches);
        showBranchesDetailandMap(sidebarbranches, branch_detail_html);
        /*===========Populate branches=============*/
    });

    $('#branchcode').on('change', function() {
    	var code = $(this).val().trim();
        var selected_city = $('#city').val().trim();
        var selected_state = $('#state').val().trim();

        if (code in branches['branchname']) {
        	sidebarbranches = showbranches = {[code]: branches['branchname'][code]};
        } else if (selected_city in branches['citybranches']) {
            sidebarbranches = showbranches = branches['citybranches'][selected_city];
        } else if (selected_state in branches['statebranches']) {
            sidebarbranches = showbranches = branches['statebranches'][selected_state];
        } else {
            sidebarbranches = showbranches = branches['branchname'];
        }
        showBranchesDetailandMap(sidebarbranches, branch_detail_html);
    });


</script>

</html>