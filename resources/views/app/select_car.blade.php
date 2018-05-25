@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="javascript:" class="my-booking-btn">Select Car</a>

                    </div>
                    <div>
                        <div class="white-bg">
                        @if (!empty($data->Price->CarGroupPrice))
                            @foreach ($data->Price->CarGroupPrice as $key => $price_est)
                                @if (!$price_est->TotalAmount || !isset($car_groups[$price_est->CarGrop]))
                                    @continue;
                                @endif
                            <div class="tariff-car-section select-car">
                                <span class="price-tag">{{$data->Price->Currency}} {{ $price_est->TotalAmount }}</span>
                                <img src="{{ $car_groups[$price_est->CarGrop]['ImageUrl'] }}" onerror="this.src='{!!$setting['car_img']!!}'"/>
                                <h4 class="border-none">{{ str_limit($car_groups[$price_est->CarGrop]['VehTypeDesc'], $limit = 22, $end = '...') }} <a href="car_detail/{{$key}}" class="proceed-btn-select-car">Proceed</a></h4>
                                <div class="clearBoth"></div>
                            </div>
                            @endforeach
                        @else
                        <div style="
                            color:  grey;
                            border-top: 1px grey solid;
                            padding-top: 40px;
                            margin-top: 20px;
                        ">{{$setting['no_data']}}</div>
                        @endif
                            <div class="clearBoth"></div>
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>
@stop