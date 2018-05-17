@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="#" class="my-booking-btn">Select Car</a>

                    </div>
                    <div>
                        <div class="white-bg">
                        @if (!empty($data->Price->CarGroupPrice))
                            @if (is_object($data->Price->CarGroupPrice))
                                @php ($data->Price->CarGroupPrice = [$data->Price->CarGroupPrice])
                            @endif
                            @foreach ($data->Price->CarGroupPrice as $price_est)
                            <div class="tariff-car-section select-car">
                                <span class="price-tag">{{$data->Price->Currency}} {{ $price_est->TotalAmount }}</span>
                                @if (@getimagesize($car_groups[$price_est->CarGrop]['ImageUrl']))
                                <img src="{{ $car_groups[$price_est->CarGrop]['ImageUrl'] }}" />
                                @else
                                <img src="{{ $setting['car_img'] }}" />
                                @endif
                                <h4 class="border-none">{{$car_groups[$price_est->CarGrop]['VehTypeDesc']}} <a href="" class="proceed-btn-select-car">Proceed</a></h4>
                                <div class="clearBoth"></div>
                            </div>
                            @endforeach
                        @else
                        <span>{{$setting['no_data'] }}</span>
                        @endif
                            <div class="clearBoth"></div>
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>
@stop