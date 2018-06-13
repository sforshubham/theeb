
                            <table cellpadding="0" cellspacing="0" width="100%" class="table-rental table-invoice" style="border-top: 1px solid #ccc; border-bottom: none;">
                                <tr>
                                    <td style="border: none; width: 10%;"><img src="{{url('/images/logo.png')}}" alt="شركة ذيب لتأجير السيارات" title="شركة ذيب لتأجير السيارات"></td>
                                    <td style="border: none; width: 80%; vertical-align: middle;"><strong>Theeb Rent A Car Co</strong><br>{{ $h1 }}<br/>{{ $h2 }}</td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0" width="100%" class="table-rental">
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Receipt No') }}</td>
                                    <td>{{ $payment->ReceiptNo }}</td>
                                    <td>{{ __('Invoice No') }}</td>
                                    <td>{{ $payment->InvoiceNo }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Receipt Date') }}</td>
                                    <td>{{ $payment->ReceiptDate }}</td>
                                    <td>{{ __('Agreement No') }}</td>
                                    <td>{{ $payment->AgreementNo }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Customer Name') }}</td>
                                    <td>{{ $payment->CustomerName }}</td>
                                    <td>{{ __('Address') }}</td>
                                    <td>{{ $payment->CustomerAddress }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Payment Mode') }}</td>
                                    <td>{{ $payment->PaymentMode }}</td>
                                    <td>{{ __('Amount/SR') }}</td>
                                    <td>{{ number_format($payment->ReceiptAmount,2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="1">{{ __('Created User') }}</td>
                                    <td colspan="3">{{ $payment->PaymentUser }}</td>
                                </tr>
                            </table>