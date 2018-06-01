@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="javascript:" class="my-booking-btn">{{ __('Thank You') }}</a>
                    </div>
                    <div>
                        <div class="white-bg">
                            @if ($status == 1)
                            <div class="payment-pickup-details floatRight" style="width: 97%;background-color: #DFF0D8;border-color: #D6E9C6;">
                                <span style="color: #468847;">{{ __('Your reservation request has been received') }}</span>
                            </div>
                            @else
                            <div class="payment-pickup-details floatRight" style="width: 97%; background-color: #F2DEDE; border-color: #EED3D7;">
                                <span style="color: #B94A48;">{{ __('Something went wrong. Try after some time.') }}</span>
                            </div>
                            @endif 
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
                                <span style="display: inline;font-size: 16px;color: #444;">{{ $booking_data->Price->Currency}} </span>
                                <a href="javascript:" class="payment-pickup-location" style="width: 30%">{{ $booking_data->Price->CarGroupPrice->TotalAmount }}</a>
                            </div>
                            <div class="clearBoth"></div>
                            <input type="submit" value="{{ __('OK') }}" class="proceed-btn" onclick="window.location='{{url('/book')}}';">
                            <div class="clearBoth"></div>
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>
@stop
