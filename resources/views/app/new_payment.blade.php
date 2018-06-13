@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder">
                <div class="safeArea">
                    <div class="rental-tabs-top">
                        <a href="javascript:" class="rental-history-btn">{{ __('Rental History') }}</a>
                        <ul>
                           <li><a href="agreement">{{ __('Rental') }}</a></li>
                            <li><a href="invoice">{{ __('Invoice') }}</a></li>
                            <li class="active"><a href="payment">{{ __('Payment') }}</a></li>
                            <li><a href="reservation">{{ __('Reservation') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <div class="white-bg">
                            <div class="from-end-date-rental">
                                <input type="text" placeholder="{{ __('Filter by date range') }}" id="daterangepicker" />
                            </div>
                        @if (isset($result->Payments) && isset($result->Payments->Payment))
                            @if (is_object($result->Payments->Payment))
                                @php($result->Payments->Payment = [$result->Payments->Payment])
                            @endif
                            @php($row_count = count($result->Payments->Payment))
                            @for ($i = 0; $i < $row_count; $i++)
                                @php ($payment = $result->Payments->Payment[$i])
                                
                                <div class="address-table padding-all-10 floatLeft">
                                        
                                    <span class="download_link" data-paymentno="{{ $i }}" style="color: #1269a0; cursor: pointer;">Download PDF</span>
                                    <form action="{{ url('/download_rental_history_pdf') }}" method="post" name="download_pdf_{{ $i }}">
                                        <input type="hidden" name="for" value="P">
                                        <input type="hidden" name="payment" value="{{ json_encode($payment) }}">
                                        <input type="hidden" name="h1" value="{{ $result->Payments->H1 }}">
                                        <input type="hidden" name="h2" value="{{ $result->Payments->H2 }}">
                                    </form>
                                    <div class="clearBoth"></div>
                                </div>

                                @include('app.single_payment', ['payment' => $payment, 'h1' => $result->Payments->H1, 'h2' => $result->Payments->H2])
                            @endfor
                            <div class="clearBoth"></div>
                        @else
                        <div style="
                            color:  grey;
                            border-top: 1px grey solid;
                            padding-top: 40px;
                            margin-top: 20px;
                        ">{{ __('Record not found') }}</div>
                        @endif
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>

@stop
@include('app.daterangepicker')
@section('custom_script_new')
<script type="text/javascript">
    jQuery(function() {
        jQuery('.download_link').click(function() {
            var paymentno = jQuery(this).data('paymentno');
            jQuery('form[name="download_pdf_' + paymentno + '"]').submit();
        });
    });
</script>
@stop