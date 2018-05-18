@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="#" class="my-booking-btn">Tariff</a>
                        <select id="filter_cat" class="floatLeft filter-category">
                            <option>Filter by Category</option>
                            @foreach ($veh_type as $type)
                            <option value="{{ $type['VTHCode'] }}">{{ $type['VTHDesc'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <div class="white-bg">
                            @php ($str_data = [])
                            @foreach ($data as $key => $car)
                                @php ($str_data[$car['VTHCode']][$key] = $key)
                                @if (!@getimagesize($car['ImageUrl']))
                                    @php ($data[$key]['ImageUrl'] = $car['ImageUrl'] =  $setting['car_img'])
                                @endif
                            <div class="tariff-car-section">
                                <img src="{{$car['ImageUrl']}}" />
                                <h4>{{$car['VehTypeDesc'].' - '.$car['VTHType']}}</h4>
                                <div class="car-price">
                                    {{$car['VTHDesc']}}
                                </div>
                                <div class="buttons-all">
                                    <a rel="{{$car['Group']}}" href="javascript:void(0)" class="view-booking-btn buttons floatLeft">View Booking</a>
                                    <div class="clearBoth"></div>
                                </div>
                            </div>
                            @endforeach
                            <div class="clearBoth"></div>
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>
<script>
    var str_data = <?php echo json_encode($str_data)?>;
    var data = <?php echo json_encode($data) ?>;
    var div_html = '<div class="tariff-car-section">'+
        '<img src="{img}">'+
        '<h4>{typedesc} - {type}</h4>'+
        '<div class="car-price">'+
            '{desc}'+
        '</div>'+
        '<div class="buttons-all">'+
            '<a rel="{group}" href="#" class="view-booking-btn buttons floatLeft">View Booking</a>'+
            '<div class="clearBoth"></div>'+
        '</div>'+
    '</div>';

    $('#filter_cat').on('change', function() {
        var selected = $(this).val().trim();
        if (selected in str_data) {
            groups = str_data[selected];
        } else {
            groups = data;
        }
        showGroups(groups, div_html);
    });

    function showGroups(groups, html)
    {
        var detail_html = '';
        $.each(groups , function(index, value) {
            var shtml = html;
            var img = data[index]['ImageUrl'];
            var typedesc = data[index]['VehTypeDesc'];
            var type = data[index]['VTHType'];
            var desc = data[index]['VTHDesc'];
            var group = data[index]['Group'];
            var mapObj = {
                '{img}': img,
                '{typedesc}': typedesc,
                '{type}': type,
                '{desc}': desc,
                '{group}': group
            };
            var content = shtml.replace(/{img}|{typedesc}|{type}|{desc}|{group}/g, function(matched) {
                return mapObj[matched];
            });


            detail_html += content;
        });
        detail_html += '<div class="clearBoth"></div>';
        $('.white-bg').html(detail_html);
        return;
    }
</script>
@stop