@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="javascript:" class="my-booking-btn">{{ __('Payment') }}</a>
                    </div>
                    <div>
                        <div class="white-bg">
                            <div class="payment-pickup-details floatRight" style="width: 45%;">
                                <span>{{$group_detail->VehTypeDesc}}</span>
                                <a href="javascript:" class="payment-pickup-date"><img src="{{url('/')}}/images/calender-icon.png" align="absmiddle" /> {{ __('Pickup Details') }}
                                    <br/>
                                    <label> {{$booking_data->Price->OutDate.', '.convert24hrto12hr($booking_data->Price->OutTime)}}</label>
                                </a>
                                <a href="javascript:" class="payment-pickup-location"><img src="{{url('/')}}/images/calender-icon.png" align="absmiddle" /> {{ __('Drop Details') }}
                                    <br/>
                                    <label> {{$booking_data->Price->InDate.', '.convert24hrto12hr($booking_data->Price->InTime)}}</label>
                                </a>
                            </div>
                            <div class="payment-pickup-details floatLeft payment-net-amount" style="width: 45%;">
                                <a href="javascript:" class="payment-pickup-date"> {{ __('Reservation No') }}</a>
                                <a href="javascript:" class="payment-pickup-location">{{ session('ReservationNo') }}</a>

                                <a href="javascript:" class="payment-pickup-date"> {{ __('Net Payable Amount') }}</a>
                                <a href="javascript:" class="payment-pickup-location">{{ $booking_data->Price->Currency}}&nbsp;{{ $booking_data->Price->CarGroupPrice->TotalAmount }}</a>
                            </div>
                            <div class="clearBoth"></div>

                            <div class="payment-credit-card-detail floatRight align-left">
                                <div class="payment-master-card"><span>{{ __('Select Payment Method') }}</span>
                                    <br/>
                                    <img src="{{url('/')}}/images/master_card.png" />
                                </div>
                                <label class="payment-label">
                                    <input type="radio" name="card">{{ __('Credit Card') }}</label>
                                <label class="payment-label">
                                    <input type="radio" name="card">{{ __('Cash On Delivery') }}</label>
                            </div>
                            <div class="clearBoth"></div>
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>

@stop
