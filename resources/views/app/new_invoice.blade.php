@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
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
                            <div class="from-end-date-rental">
                                <input type="text" placeholder="Filter by date range" id="daterangepicker" />
                            </div>
                            @if (isset($result->Invoices) && isset($result->Invoices->Invoice))
                                @if (is_object($result->Invoices->Invoice))
                                    @php($result->Invoices->Invoice = [$result->Invoices->Invoice])
                                @endif
                                @php($row_count = count($result->Invoices->Invoice))
                                @for ($i = 0; $i < $row_count; $i++)
                                    @php ($invoice = $result->Invoices->Invoice[$i])
                                    <div class="address-table border-all padding-all-10" style="border-bottom: none;">
                                        <div class="floatRight mg-rt-30 theeb-logo"><img src="{{url('/images/logo.png')}}" alt="شركة ذيب لتأجير السيارات" title="شركة ذيب لتأجير السيارات"></div>
                                        <div class="floatRight pd-top-15"><strong>Theeb Rent A Car Co</strong>
                                            <br>{{ $result->Invoices->H1 }}
                                            <br/>{{ $result->Invoices->H2 }}
                                        </div>
                                        <div class="clearBoth"></div>
                                    </div>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="table-rental table-invoice">
                                        <tr>
                                            <td>{{ __('Invoice No') }}</td>
                                            <td>{{ $invoice->InvoiceNo }}</td>
                                            <td>{{ __('Invoice Date') }}</td>
                                            <td>{{ $invoice->InvoiceDate }}</td>
                                            <td>{{ __('Invoice Time') }}</td>
                                            <td>{{ $invoice->InvoiceTime }}</td>
                                            <td>{{ __('Invoice Branch') }}</td>
                                            <td>{{ $invoice->InvoiceBranchName }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Agreement No') }}</td>
                                            <td>{{ $invoice->AgreementNo }}</td>
                                            <td>{{ __('Check Out Date/Time') }}</td>
                                            <td>{{ $invoice->InvoiceAgrOutDate }} {{ $invoice->InvoiceAgrOutTime }}</td>
                                            <td>{{ __('Check In Date/Time') }}</td>
                                            <td>{{ $invoice->InvoiceAgrInDate }} {{ $invoice->InvoiceAgrInTime }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Check-Out Branch') }}</td>
                                            <td>{{ $invoice->InvoiceAgrOutBranch }}</td>
                                            <td>{{ __('Check-Out Branch') }}</td>
                                            <td>{{ $invoice->InvoiceAgrOutBranch }}</td>
                                            <td>{{ __('Out KM') }}</td>
                                            <td>{{ $invoice->InvoiceAgrOutKm }}</td>
                                            <td>{{ __('In KM') }}</td>
                                            <td>{{ $invoice->InvoiceAgrInKm }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Charge Group') }}</td>
                                            <td>{{ $invoice->InvoiceAgrChargeGroup }}</td>
                                            <td>{{ __('Car Model') }}</td>
                                            <td>{{ $invoice->InvoiceAgrCarModel }}</td>
                                            <td>{{ __('Vehicle No') }}</td>
                                            <td>{{ $invoice->InvoiceAgrVehicleNo }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </table>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="table-rental table-invoice mg-top-30">
                                        <tr>
                                            <th colspan="8">Renter Information</th>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Billing Name') }}</td>
                                            <td>{{ $invoice->DriverBillingName }}</td>
                                            <td>{{ __('Date Of Birth') }}</td>
                                            <td>{{ $invoice->DriverDOB }}</td>
                                            <td>{{ __('Membership No') }}</td>
                                            <td>{{ $invoice->DriverMembershipNo }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('ID No') }}</td>
                                            <td>{{ $invoice->DriverPassportNo }}</td>
                                            <td>{{ __('Nationality') }}</td>
                                            <td>{{ $invoice->DriverNationality }}</td>
                                            <td>{{ __('License No') }}</td>
                                            <td>{{ $invoice->DriverLicenseNo }}</td>
                                            <td>{{ __('Expiry') }}</td>
                                            <td>{{ $invoice->DriverLicenseExpiryDate }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Address') }}</td>
                                            <td>{{ $invoice->DriverAddress }}</td>
                                            <td>{{ __('City') }}</td>
                                            <td>{{ $invoice->DriverCity }}</td>
                                            <td>{{ __('Mobile') }}</td>
                                            <td>{{ $invoice->DriverContactNo }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </table>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="table-rental table-invoice mg-top-30">
                                        <tr>
                                            <th colspan="8">Rental Charges</th>
                                        </tr>
                                        <tr>
                                            <td colspan="8">{{ __('Tariff') }} {{ $invoice->AgreementTariff }} {{ __('Rate No') }} {{ $invoice->AgreementRateNo }} {{ __('Currency') }} {{ $invoice->AgreementCurrency }}</td>
                                        </tr>
                                        <tr style="font-weight: bold;">
                                            <td colspan="3">{{ __('Rental Details') }}</td>
                                            <td>Qty</td>
                                            <td>Price</td>
                                            <td>Total SAR</td>
                                            <td>SAR</td>
                                            <td>Service%</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">{{ __('Rental Package') }}</td>
                                            <td style="font-weight: normal;">{{ $invoice->SoldDays }}</td>
                                            <td style="font-weight: normal;">{{ $invoice->InvoiceRental / $invoice->SoldDays }}</td>
                                            <td style="font-weight: normal;">{{ $invoice->InvoiceRental }}</td>
                                            <td style="font-weight: normal;"></td>
                                            <td style="font-weight: normal;"></td>
                                        </tr>
                                        <tr style="font-weight: bold;">
                                            <td>{{ __('KM:') }}</td>
                                            <td>{{ __('Driven:') }} {{ $invoice->AgreementFreeKm + $invoice->AgreementChargableKm }}</td>
                                            <td>{{ __('Free:') }} {{ $invoice->AgreementFreeKm }}</td>
                                            <td>{{ __('Charged:') }} {{ $invoice->AgreementChargableKm }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr style="font-weight: bold;">
                                            <td>{{ __('Discount') }}</td>
                                            <td colspan="4">{{ __('Discount % :') }} {{ str_replace('%', '', $invoice->AgreementDiscountPercent) }}</td>
                                            <td style="font-weight: normal;">-{{ $invoice->InvoiceDiscountAmount }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Others') }}</td>
                                            <td colspan="4"></td>
                                            <td style="font-weight: normal;">{{ $invoice->InvoiceOther }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Extras') }}</td>
                                            <td colspan="4"></td>
                                            @if (isset($invoice->InvoiceExtras))
                                            <td style="font-weight: normal;">{{ $invoice->InvoiceExtras->Amount }}</td>
                                            @else
                                            <td></td>
                                            @endif
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Drop Off') }}</td>
                                            <td colspan="4"></td>
                                            <td style="font-weight: normal;">{{ $invoice->InvoiceDropOff }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">{{ __('Total Charges') }}</td>
                                            <td>{{ $invoice->InvoiceTotal }}</td>
                                            <td style="font-weight: normal;">{{ $invoice->InvoiceTotal }}</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">{{ __('VAT') }} @ 5%</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">{{ __('Paid Amount') }}</td>
                                            <td>{{ $invoice->InvoiceAmountPaid }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">{{ __('Balance') }} <span class="bln_pay" data-amount="57" style="float: right;font-weight: normal;color: #1269a0;text-decoration: underline; cursor: pointer;">{{ __('Pay Balance') }}</span></td>
                                            <td>{{ $invoice->InvoiceBalance }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="font-size: small;font-weight: normal;">{{ __('Invoiced By') }}</td>
                                        </tr>
                                    </table>
                                    
                                @endfor
                                
                            @else
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
        jQuery('.bln_pay').click(function () {
            var paymentMethod = 'creditcard';
            var paymentAmount = jQuery(this).data('amount');

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
                    "{{ url()->full() }}"
                );
            }
        });
    });
</script>
@stop