@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder">
                <div class="safeArea">
                    <div class="rental-tabs-top">
                        <a href="javascript:" class="rental-history-btn">{{ __('Rental History') }}</a>
                        <ul>
                            <li><a href="agreement">{{ __('Rental') }}</a></li>
                            <li class="active"><a href="invoice">{{ __('Invoice') }}</a></li>
                            <li><a href="payment">{{ __('Payment') }}</a></li>
                            <li><a href="reservation">{{ __('Reservation') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <div class="white-bg">
                            @if (app('request')->input('status') === '1')
                            <div class="payment-pickup-details floatRight" style="width: 97%;background-color: #DFF0D8;border-color: #D6E9C6;">
                                <span style="color: #468847;">{{ __('Your payment has been processed successfully') }}</span>
                            </div>
                            @elseif (app('request')->input('status') === '0')

                            <div class="payment-pickup-details floatRight" style="width: 97%; background-color: #F2DEDE; border-color: #EED3D7;">
                                <span style="color: #B94A48;">{{ __('Dear Customer payment has been declined. Please contact your bank.') }}</span>
                            </div>
                            @endif 
                            <div class="from-end-date-rental">
                                <input type="text" readonly="readonly" placeholder="{{ __('Filter by date range') }}" id="daterangepicker" />
                            </div>
                            @if (isset($result->Invoices) && isset($result->Invoices->Invoice))
                                @if (is_object($result->Invoices->Invoice))
                                    @php($result->Invoices->Invoice = [$result->Invoices->Invoice])
                                @endif
                                @php($row_count = count($result->Invoices->Invoice))
                                @for ($i = 0; $i < $row_count; $i++)
                                    @php ($invoice = $result->Invoices->Invoice[$i])
                                    
                                    <div class="address-table padding-all-10 floatLeft">
                                        
                                        <span class="download_link" data-invoiceno="{{ $invoice->InvoiceNo }}" style="color: #1269a0; cursor: pointer;">Download PDF</span>
                                        <form action="{{ url('/download_rental_history_pdf') }}" method="post" name="download_pdf_{{ $invoice->InvoiceNo }}">
                                            <input type="hidden" name="for" value="I">
                                            <input type="hidden" name="invoice" value="{{ json_encode($invoice) }}">
                                            <input type="hidden" name="h1" value="{{ $result->Invoices->H1 }}">
                                            <input type="hidden" name="h2" value="{{ $result->Invoices->H2 }}">
                                        </form>
                                        <div class="clearBoth"></div>
                                    </div>

                                    @include('app.single_invoice', ['invoice' => $invoice, 'h1' => $result->Invoices->H1, 'h2' => $result->Invoices->H2])
                                    
                                @endfor
                                
                            @else
                            <div style="
                                color:  grey;
                                border-top: 1px grey solid;
                                padding-top: 40px;
                                margin-top: 20px;
                            ">{{ __('Record not found') }}</div>
                            @endif
                            
                            <div class="clearBoth"></div>
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>

@stop

@include('app.daterangepicker')
@section('custom_script_new')
<script type="text/javascript" src="{{ url('/js/checkout.js') }}"></script>
<script type="text/javascript">
    jQuery(function() {
        jQuery('.download_link').click(function() {
            var invoiceno = jQuery(this).data('invoiceno');
            jQuery('form[name="download_pdf_' + invoiceno + '"]').submit();
        });

        jQuery('.bln_pay').click(function () {
            var paymentMethod = 'creditcard';
            var paymentAmount = jQuery(this).data('amount');
            var invoiceNo = jQuery(this).data('invoice');

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
                getPaymentPage(
                    paymentMethod,
                    "{{ url('/payment_request_route') }}",
                    paymentAmount,
                    invoiceNo
                );
            }
        });
    });
</script>
@stop