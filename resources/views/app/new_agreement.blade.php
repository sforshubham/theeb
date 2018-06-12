@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder">
                <div class="safeArea">
                    <div class="rental-tabs-top">
                        <a href="javascript:" class="rental-history-btn">{{ __('Rental History') }}</a>
                        <ul>
                            <li class="active"><a href="agreement">{{ __('Rental') }}</a></li>
                            <li><a href="invoice">{{ __('Invoice') }}</a></li>
                            <li><a href="payment">{{ __('Payment') }}</a></li>
                            <li><a href="reservation">{{ __('Reservation') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <div class="white-bg">
                            <div class="from-end-date-rental">
                                <input type="text" placeholder="{{ __('Filter by date range') }}" id="daterangepicker" />
                            </div>
                            @if (isset($result->Agreements) && isset($result->Agreements->Agreement))
                                @if (is_object($result->Agreements->Agreement))
                                    @php($result->Agreements->Agreement = [$result->Agreements->Agreement])
                                @endif
                                @php($row_count = count($result->Agreements->Agreement))
                                @for ($i = 0; $i < $row_count; $i++)
                                @php ($agreement = $result->Agreements->Agreement[$i])
                            <div class="address-table border-all padding-all-10" style="margin-bottom:0">
                                <div class="floatRight mg-rt-30 theeb-logo"><img src="{{url('/images/logo.png')}}" alt="شركة ذيب لتأجير السيارات" title="شركة ذيب لتأجير السيارات"></div>
                                <div class="floatRight pd-top-15"><strong>Theeb Rent A Car Co</strong>
                                    <br>{{ $result->Agreements->H1 }}
                                    <br/>{{ $result->Agreements->H2 }}
                                </div>
                                <div class="clearBoth"></div>
                            </div>
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