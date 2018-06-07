@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
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
                                <input type="text" placeholder="Filter by date range" id="daterangepicker" />
                            </div>
                        @if (isset($result->Payments) && isset($result->Payments->Payment))
                            @if (is_object($result->Payments->Payment))
                                @php($result->Payments->Payment = [$result->Payments->Payment])
                            @endif
                            @php($row_count = count($result->Payments->Payment))
                            @for ($i = 0; $i < $row_count; $i++)
                                @php ($payment = $result->Payments->Payment[$i])
                            <div class="address-table border-all padding-all-10" style="margin-bottom:0">
                                <div class="floatRight mg-rt-30 theeb-logo"><img src="{{url('/images/logo.png')}}" alt="شركة ذيب لتأجير السيارات" title="شركة ذيب لتأجير السيارات"></div>
                                <div class="floatRight pd-top-15"><strong>Theeb Rent A Car Co</strong>
                                    <br>{{ $result->Payments->H1 }}
                                    <br/>{{ $result->Payments->H2 }}
                                </div>
                                <div class="clearBoth"></div>
                            </div>

                            <table cellpadding="0" cellspacing="0" width="100%" class="table-rental">
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Receipt No :</td>
                                    <td>{{ $payment->ReceiptNo }}</td>
                                    <td>Invoice No :</td>
                                    <td>{{ $payment->InvoiceNo }}</td>
                                </tr>
                                <tr>
                                    <td>Receipt Date</td>
                                    <td>{{ $payment->ReceiptDate }}</td>
                                    <td>Agreement No.</td>
                                    <td>{{ $payment->AgreementNo }}</td>
                                </tr>
                                <tr>
                                    <td>Customer Name</td>
                                    <td>{{ $payment->CustomerName }}</td>
                                    <td>Address</td>
                                    <td>{{ $payment->CustomerAddress }}</td>
                                </tr>
                                <tr>
                                    <td>Payment Mode</td>
                                    <td>{{ $payment->PaymentMode }}</td>
                                    <td>Amount/SR</td>
                                    <td>{{ number_format($payment->ReceiptAmount,2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="1">Created User : </td>
                                    <td colspan="3">{{ $payment->PaymentUser }}</td>
                                </tr>
                            </table>
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