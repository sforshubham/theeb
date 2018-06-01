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
                                <img src="{{url('/')}}/images/edit-icon.png" align="absmiddle" class="edit-icon edit_net_payable">
                                <span style="display: inline;font-size: 16px;color: #444;">{{ $booking_data->Price->Currency}} </span>
                                <a href="javascript:" class="payment-pickup-location edit_net_payable" style="width: 25%" id="label_for_net_payable">{{ $booking_data->Price->CarGroupPrice->TotalAmount }}</a>
                                <input type="text" name="payment_amount" value="{{ $booking_data->Price->CarGroupPrice->TotalAmount }}" id="input_for_net_payable">
                            </div>
                            <div class="clearBoth"></div>

                            <div class="payment-credit-card-detail floatRight align-left">
                                <div class="payment-master-card"><span>{{ __('Select Payment Method') }}</span>
                                    <br/>
                                    <img src="{{url('/')}}/images/master_card.png" />
                                </div>
                                <label class="payment-label">
                                    <input type="radio" name="payment_option" value="creditcard">{{ __('Credit Card') }}</label>
                                <label class="payment-label">
                                    <input type="radio" name="payment_option" value="cashondelivery">{{ __('Cash On Delivery') }}</label>
                            </div>
                            <input type="submit" value="Proceed to Pay" class="proceed-btn" id="btn_continue">
                            <div class="clearBoth"></div>
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>
@stop

@section('custom_script')
<script type="text/javascript" src="{{ url('/js/checkout.js') }}"></script>
<script type="text/javascript">
    jQuery(function() {
        jQuery('#btn_continue').click(function () {
            var paymentMethod = jQuery('input:radio[name=payment_option]:checked').val();
            var paymentAmount = jQuery('input:text[name=payment_amount]').val();

            if(paymentMethod == '' || paymentMethod === undefined || paymentMethod === null) {
                alert('Pelase Select Payment Method!');
                return;
            }
            if(paymentMethod == 'cc_merchantpage' || paymentMethod == 'installments_merchantpage') {
                window.location.href = 'confirm-order.php?payment_method='+paymentMethod;
            }
            if(paymentMethod == 'cashondelivery') {
                window.location.href = "{{ url('/payment_result') }}?status=1";
                return;
            }
            if(paymentMethod == 'cc_merchantpage2') {
                var isValid = payfortFortMerchantPage2.validateCcForm();
                if(isValid) {
                    getPaymentPage(paymentMethod, "{{ url('/payment_request_route') }}", paymentAmount);
                }
            }
            else{
                getPaymentPage(paymentMethod, "{{ url('/payment_request_route') }}", paymentAmount);
            }
        });

        jQuery('.edit_net_payable').click(function (){
            jQuery('#label_for_net_payable').hide();
            jQuery('#input_for_net_payable').show();
        });
    });
</script>
@stop