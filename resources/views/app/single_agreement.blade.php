
                            <table cellpadding="0" cellspacing="0" width="100%" class="table-rental table-invoice" style="border-top: 1px solid #ccc; border-bottom: none;">
                                <tr>
                                    <td style="border: none; width: 10%;"><img src="http://www.theeb.com.sa/images/logo.png" alt="شركة ذيب لتأجير السيارات" title="شركة ذيب لتأجير السيارات"></td>
                                    <td style="border: none; width: 80%; vertical-align: middle;"><strong>Theeb Rent A Car Co</strong><br>{{ $h1 }}<br/>{{ $h2 }}</td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0" width="100%" class="table-rental table-invoice">
                                <tr>
                                    <th>{{ __('Agreement No') }}</th>
                                    <th colspan="3">{{ $agreement->AgreementNo }}</th>
                                    <th colspan="2">{{ __('Branch') }}: {{ $agreement->CheckInBranch }}</th>
                                    <th colspan="2">{{ __('Contact No') }}: {{ $agreement->DriverContactNo }}</th>
                                </tr>
                                <tr>
                                    <td>{{ __('Driver ID') }}</td>
                                    <td>{{ $agreement->DriverId }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ __('Agreement days') }}</td>
                                    <td>{{ $agreement->AgreementDays }}</td>
                                    <td>{{ __('Date') }}</td>
                                    <td>{{ $agreement->CheckInDate }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Driver Name') }}</td>
                                    <td>{{ $agreement->DriverName }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ __('Rental Package') }}</td>
                                    <td>{{ $agreement->AgreementPackage}}</td>
                                    <td>{{ __('Time') }}</td>
                                    <td>{{ $agreement->CheckInDate }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('License No') }}</td>
                                    <td>{{ $agreement->DriverLicenseNo }}</td>
                                    <td>{{ __('Expiry') }}</td>
                                    <td>{{ $agreement->DriverLicenseExpiryDate }}</td>
                                    <td>{{ __('Package Price') }}</td>
                                    <td>{{ number_format($agreement->AgreementPackagePrice,2) }}</td>
                                    <td>{{ __('Extras') }}</td>
                                    <td>{{ $agreement->AgreementExtras }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Nationality') }}</td>
                                    <td>{{ $agreement->DriverNationality }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ __('Charge Group') }}</td>
                                    <td>{{ $agreement->AgreementChargeGroup }}</td>
                                    <td>{{ __('Discount') }}</td>
                                    <td>{{ $agreement->AgreementDiscount }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Membership No') }}</td>
                                    <td>{{ $agreement->DriverMembershipNo }}</td>
                                    <td>{{ __('Type') }}</td>
                                    <td>{{ $agreement->DriverMembershipType }}</td>
                                    <td>{{ __('Free KM') }}</td>
                                    <td>{{ $agreement->AgreementFreeKm }}</td>
                                    <td>{{ __('Free Hr') }}</td>
                                    <td>{{ $agreement->AgreementFreeHr }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Mobile No') }}</td>
                                    <td>{{ $agreement->DriverContactNo }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ __('Insurance (CDW)') }}</td>
                                    <td>{{ $agreement->AgreementInsurance }}</td>
                                    <td>{{ __('KM Out') }}</td>
                                    <td>{{ $agreement->AgreementOutKm }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Work Tel') }}</td>
                                    <td></td>
                                    <td>{{ __('Home Tel') }}</td>
                                    <td></td>
                                    <td>{{ __('Extra Hr Charge') }}</td>
                                    <td>{{ $agreement->AgreementExtraHourCharge }}</td>
                                    <td>{{ __('Extra KM Charge') }}</td>
                                    <td>{{ $agreement->AgreementExtraKmCharge }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Debitor No') }}</td>
                                    <td>{{ $agreement->DebitorCode }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ __('Vehicle No') }}</td>
                                    <td>{{ $agreement->LicenseNo }}</td>
                                    <td>{{ __('Model') }}</td>
                                    <td>{{ $agreement->AgreementModelName }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">{{ __('Debitor Name') }}</td>
                                    <td colspan="2">{{ $agreement->DebitorName }}</td>
                                    <td colspan="2">{{ __('Total Rental Amount') }}</td>
                                    <td colspan="2">{{ number_format($agreement->AgreementTotalRental,2) }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{ __('Created User') }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>