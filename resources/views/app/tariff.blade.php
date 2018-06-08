@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
            <div class="bodyPageHolder">
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
                            @php ($count = 0)
                            @if (!empty($prices->Price->CarGroupPrice))
                                @foreach ($prices->Price->CarGroupPrice as $price)
                                    @if(!isset($data[$price->CarGrop]) || !$price->RatePackagePrice)
                                        @continue;
                                    @endif
                                <div class="tariff-car-section vthcode{{$data[$price->CarGrop]['VTHCode']}} ">
                                    <span class="price-tag">{{$prices->Price->Currency}} {{ $price->RatePackagePrice }}</span>
                                    <img src="{{$data[$price->CarGrop]['ImageUrl']}}" onerror="this.src='{!!$setting['car_img']!!}'"/>
                                    <h4 class="truncate-text">{{$data[$price->CarGrop]['VehTypeDesc'].' - '.$data[$price->CarGrop]['VTHType']}}</h4>
                                    <div class="car-price truncate-text">
                                        {{$data[$price->CarGrop]['VTHDesc']}}
                                    </div>
                                    <div class="buttons-all">
                                        <a href="{{ url('/book?g='.$data[$price->CarGrop]['Group']) }}" class="view-booking-btn buttons floatLeft">Book now</a>
                                        <div class="clearBoth"></div>
                                    </div>
                                </div>
                                    @php ($count++)
                                @endforeach
                            @endif
                            <div class="no-data-div" style="
                                display: {!! ($count == 0) ? 'block' : 'none' !!};
                                color: grey;
                                border-top: 1px grey solid;
                                padding-top: 40px;
                                margin-top: 20px;
                            ">{{$setting['no_data']}}</div>
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
                if ($('.vthcode'+selected).length) {
                    $('.no-data-div').hide();
                    $('.tariff-car-section').hide();
                    $('.vthcode'+selected).show();
                } else {
                    $('.no-data-div').show();
                    $('.tariff-car-section').hide();
                }

            } else {
                $('.no-data-div').hide();
                $('.tariff-car-section').show();
            }
        });
    </script>
@stop
