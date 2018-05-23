@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="#" class="my-booking-btn">Payment</a>
                    </div>
                    <div>
                        <div class="white-bg">
                            <div class="payment-pickup-details floatRight">
                                <span>Hyundai Sonata or Similar</span>
                                <a href="#" class="payment-pickup-date"><img src="{{url('/')}}/images/calender-icon.png" align="absmiddle" /> Pickup Time
                                    <br/>
                                    <label>01/05/2018, 06:30 PM</label>
                                </a>
                                <a href="#" class="payment-pickup-location"><img src="{{url('/')}}/images/calender-icon.png" align="absmiddle" /> Drop Time
                                    <br/>
                                    <label> 01/05/2018, 06:30 PM</label>
                                </a>
                            </div>
                            <div class="payment-pickup-details floatLeft payment-net-amount">

                                <a href="#" class="payment-pickup-date"> Net Payable Amount</a>
                                <a href="#" class="payment-pickup-location">SAR 450.0</a>
                            </div>
                            <div class="clearBoth"></div>

                            <div class="payment-credit-card-detail floatRight align-left">
                                <div class="payment-master-card"><span>Select Payment Method</span>
                                    <br/>
                                    <img src="{{url('/')}}/images/master_card.png" />
                                </div>
                                <label class="payment-label">
                                    <input type="radio" name="card">Credit Card</label>
                                <label class="payment-label">
                                    <input type="radio" name="card">Cash on Delivery</label>
                            </div>
                            <div class="clearBoth"></div>
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>

@stop