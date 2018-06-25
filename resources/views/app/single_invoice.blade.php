
                                    <table cellpadding="0" cellspacing="0" width="100%" class="table-rental table-invoice" style="border-top: 1px solid #ccc; border-bottom: none;">
                                        <tr>
                                            <td style="border: none; width: 10%;"><img src="http://www.theeb.com.sa/images/logo.png" alt="شركة ذيب لتأجير السيارات" title="شركة ذيب لتأجير السيارات"></td>
                                            <td style="border: none; width: 80%; vertical-align: middle;">
                                                <center><h3>{{ __('Invoice') }}</h3></center><br>
                                                <strong>Theeb Rent A Car Co</strong><br>{{ $h1 }}<br/>{{ $h2 }}<br><br><br>
                                            </td>
                                        </tr>
                                    </table>
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
                                            <th colspan="8">{{ __('Renter Information') }}</th>
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
                                            <th colspan="8">{{ __('Rental Charges') }}</th>
                                        </tr>
                                        <tr>
                                            <td colspan="8">{{ __('Tariff') }} {{ $invoice->AgreementTariff }} {{ __('Rate No') }} {{ $invoice->AgreementRateNo }} {{ __('Currency') }} {{ $invoice->AgreementCurrency }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="font-weight: bold;">{{ __('Rental Details') }}</td>
                                            <td style="font-weight: bold;">Qty</td>
                                            <td style="font-weight: bold;">Price</td>
                                            <td style="font-weight: bold;">Total SAR</td>
                                            <td style="font-weight: bold;">SAR</td>
                                            <td style="font-weight: bold;">Service%</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">{{ __('Rental Package') }}</td>
                                            <td style="font-weight: normal;">{{ $invoice->SoldDays }}</td>
                                            <td style="font-weight: normal;">{{ $invoice->InvoiceRental / $invoice->SoldDays }}</td>
                                            <td style="font-weight: normal;">{{ $invoice->InvoiceRental }}</td>
                                            <td style="font-weight: normal;"></td>
                                            <td style="font-weight: normal;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">{{ __('KM:') }}</td>
                                            <td style="font-weight: bold;">{{ __('Driven:') }} {{ $invoice->AgreementFreeKm + $invoice->AgreementChargableKm }}</td>
                                            <td style="font-weight: bold;">{{ __('Free:') }} {{ $invoice->AgreementFreeKm }}</td>
                                            <td style="font-weight: bold;">{{ __('Charged:') }} {{ $invoice->AgreementChargableKm }}</td>
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
                                            <td>{{ __('Insurance') }} / {{ __('CDW') }}</td>
                                            <td colspan="4"></td>
                                            @if (isset($invoice->InvoiceInsurances))
                                            <td style="font-weight: normal;">{{ $invoice->InvoiceInsurances->Amount }}</td>
                                            @else
                                            <td></td>
                                            @endif
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
                                            <td colspan="5">{{ __('VAT') }} @ 5%</td>
                                             <td>{{ $invoice->InvoiceVat }}</td>
                                             <td></td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">{{ __('Paid Amount') }}</td>
                                            <td>{{ $invoice->InvoiceAmountPaid }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                {{ __('Balance') }} 
                                                @if ($invoice->InvoiceBalance > 0)
                                                <span class="bln_pay" data-amount="{{ $invoice->InvoiceBalance }}" data-invoice="{{ $invoice->InvoiceNo }}" style="font-weight: normal;color: #1269a0;text-decoration: underline; cursor: pointer;">{{ __('Pay Balance') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $invoice->InvoiceBalance }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="font-size: small;font-weight: normal;">{{ __('Invoiced By') }}</td>
                                        </tr>
                                    </table>
