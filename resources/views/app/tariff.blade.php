@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="javascript:void();" class="my-booking-btn">{{ __('Tariffs') }}</a>
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
                            <div class="tariff-car-section">
                                <img src="{{$car['ImageUrl']}}" onerror="this.src='{!!$setting['car_img']!!}'"/>
                                <h4 class="truncate-text">{{$car['VehTypeDesc'].' - '.$car['VTHType']}}</h4>
                                <div class="car-price truncate-text">
                                    {{$car['VTHDesc']}}
                                </div>
                                <div class="buttons-all">
                                    <a href="{{ url('/book?g='.$car['Group']) }}" class="view-booking-btn buttons floatLeft">Book now</a>
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
        '<h4 class="truncate-text">{typedesc} - {type}</h4>'+
        '<div class="car-price">'+
            '{desc}'+
        '</div>'+
        '<div class="buttons-all">'+
            '<a rel="{group}" href="javascript:void();" class="view-booking-btn buttons floatLeft">View Booking</a>'+
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