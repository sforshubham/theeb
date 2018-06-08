@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
            <div class="bodyPageHolder">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="javascript:" class="my-booking-btn">{{ __('Payment') }}</a>
                    </div>
                    <div>
                        <div class="white-bg">
                            <div class="payment-pickup-details payment-pickup-details-section-first floatRight">
                                <div class="payment-pickup-details">
                                    <img src="{{ $more_detail->ImageUrl }}" onerror="this.src='{!!$setting['car_img']!!}'"/>
                                    <div class="car-description">
                                        <h4 class="border-none">{{ $more_detail->VehTypeDesc.' - '.$more_detail->VTHDesc }}</h4>
                                    </div>
                                </div>
                                <div class="payment-pickup-details">
                                    <span>{{ __('Pickup Details') }}</span>
                                    <p class="payment-pickup-date"><img src="{{url('/')}}/images/calender-icon.png" align="absmiddle" style="vertical-align: bottom;" /> {{$data->Price->OutDate.', '.convert24hrto12hr($data->Price->OutTime)}}</p>
                                    <p class="payment-pickup-location"><img src="{{url('/')}}/images/map-icon.png" align="absmiddle" style="vertical-align: bottom;" /> {{$selected_branches[$data->Price->OutBranch]}}</p>
                                </div>
                                <div class="payment-pickup-details">
                                    <span>{{ __('Drop Details') }}</span>
                                    <p class="payment-pickup-date"><img src="{{url('/')}}/images/calender-icon.png" align="absmiddle" style="vertical-align: bottom;" /> {{$data->Price->InDate.', '.convert24hrto12hr($data->Price->InTime)}}</p>
                                    <p class="payment-pickup-location"><img src="{{url('/')}}/images/map-icon.png" align="absmiddle" style="vertical-align: bottom;" /> {{$selected_branches[$data->Price->InBranch]}}</p>
                                </div>
                            </div>
                            <div class="payment-pickup-details payment-pickup-details-section-second floatRight">
                                <div class="payment-pickup-details">
                                    <span>{{ __('Fare Details') }}</span>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;Vehicle Description </div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->CarGroupPrice[$index]->VTHDesc[0].' '.$data->Price->CarGroupPrice[$index]->VTHDesc[1] }}</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;Package Days </div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->CarGroupPrice[$index]->RatePackageDays }} day(s)</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;Package Price </div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->Currency}}&nbsp;{{ $data->Price->CarGroupPrice[$index]->RatePackagePrice }}</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;Days Booking for</div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->CarGroupPrice[$index]->SoldDays }}</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;Rental </div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->Currency}}&nbsp;{{ $data->Price->CarGroupPrice[$index]->RentalSum }}</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;Insurance charges </div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->Currency}}&nbsp;{{ $data->Price->CarGroupPrice[$index]->InsuranceSum }}</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;Extra charges </div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->Currency}}&nbsp;{{ $data->Price->CarGroupPrice[$index]->ExtrasSum }}</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;Airport Fee </div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->Currency}}&nbsp;{{ $data->Price->CarGroupPrice[$index]->AirportFee }}</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;Drop off charges </div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->Currency}}&nbsp;{{ $data->Price->CarGroupPrice[$index]->DropOffSum }}</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;VAT % </div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->CarGroupPrice[$index]->VATPerc }}</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;VAT Amount </div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->Currency}}&nbsp;{{ $data->Price->CarGroupPrice[$index]->VATAmount }}</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;Total without VAT </div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->Currency}}&nbsp;{{ $data->Price->CarGroupPrice[$index]->TotalAmount - $data->Price->CarGroupPrice[$index]->VATAmount }}</div>
                                    </div>
                                    <div>
                                        <div class="payment-fare-details">&nbsp;Total including VAT</div>
                                        <div class="payment-fare-details">&nbsp;{{ $data->Price->Currency}}&nbsp;{{ $data->Price->CarGroupPrice[$index]->TotalAmount }}</div>
                                    </div>
                                </div>
                                <div class="payment-pickup-details-btn">
                                    <form action="{{ url('/new_reservation')}}" method="POST">
                                        <input type="hidden" name="index" value="{{$index}}" />
                                        <input type="submit" Value="Proceed to Pay {{ $data->Price->Currency}}&nbsp;{{ $data->Price->CarGroupPrice[$index]->TotalAmount }}" class="proceed-btn" />
                                    </form>
                                </div>
                            </div>
                            <div class="clearBoth"></div>
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>
@stop