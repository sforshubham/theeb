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
                                <span>Pick up Details</span>
                                <a href="#" class="payment-pickup-date"><img src="../images/calender-icon.png" align="absmiddle" /> 01/05/2018, 06:30 PM</a>
                                <a href="#" class="payment-pickup-location"><img src="../images/map-icon.png" align="absmiddle" /> Riyadh</a>
                            </div>
                            <div class="payment-pickup-details floatLeft">
                                <span>Drop Details</span>
                                <a href="#" class="payment-pickup-date"><img src="../images/calender-icon.png" align="absmiddle" /> 01/05/2018, 06:30 PM</a>
                                <a href="#" class="payment-pickup-location"><img src="../images/map-icon.png" align="absmiddle" /> Riyadh</a>
                            </div>
                            <div class="payment-pickup-details floatRight">
                                <span>Fare Details</span>
                                <div>
                                    <a href="#" class="payment-fare-details">Charge Group </a>
                                    <a href="#" class="payment-fare-details">VAT Amount</a>
                                </div>
                                <div>
                                    <a href="#" class="payment-fare-details">Total without VAT</a>
                                    <a href="#" class="payment-fare-details">Total including VAT</a>
                                </div>
                            </div>
                            <div class="payment-pickup-details-btn floatLeft">
                                <input type="button" Value="Proceed to Pay SAR 262.50" class="proceed-btn" />
                            </div>
                            <div class="clearBoth"></div>
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>
@stop