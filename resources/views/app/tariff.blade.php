@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="javascript:" class="my-booking-btn">{{ __('Tariffs') }}</a>
                        <select id="filter_cat" class="floatLeft filter-category">
                            <option value="">Filter by Category</option>
                            @foreach ($veh_type as $type)
                            <option value="{{ $type['VTHCode'] }}">{{ $type['VTHDesc'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <div class="white-bg">
                            @foreach ($data as $key => $car)
                            <div class="tariff-car-section vthcode{{$car['VTHCode']}} ">
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
        $('#filter_cat').on('change', function() {
            var selected = $(this).val().trim();
            if (selected != '') {
                $('.tariff-car-section').hide();
                $('.vthcode'+selected).show();
            } else {
                $('.tariff-car-section').show();
            }
        });
    </script>
@stop
