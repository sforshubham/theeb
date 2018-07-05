@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
@php ($mimetypes = Config::get('settings.mimetypes'))
@php ($image_mime = $mimetypes[strtolower($data->DriverImageExt)] ?? 'image/gif')
            <div class="bodyPageHolder">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="javascript:void();" class="my-booking-btn">{{ __('Profile') }}</a>
                    </div>
                    <div>
                        <div class="white-bg">
                            <div class="left-wrap-profile floatRight">
                                <div class="profile-image-show">
                                    <img src="data:{{$image_mime}};base64,{{$data->DriverImage}}" onerror="this.src='{!!$setting['profile_img']!!}'"/>
                                    <h5>{{$data->Name ? $data->Name : '--'}}</h5>
                                </div>
                                <div class="profile-details">
                                    <span>{{ __('Personal Details') }}</span>
                                    <span class="floatLeft"><a href="edit_profile" >{{ __('Update') }}</a></span>
                                    <div class="profile-single-wrap">
                                        <strong>{{ __('Nationality') }}</strong>
                                        <span>{{ trim($data->Nationality) != '' ? $data->Nationality : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>{{ __('Id # & Version') }}</strong>
                                        <span>{{$data->ID ? $data->ID.'-'.$data->IDVersion : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>{{ __('Mobile Number') }}</strong>
                                        <span>{{$data->MobileNo ? '0'.(int) $data->MobileNo : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>{{ __('License Number') }}</strong>
                                        <span>{{$data->LicenseID ? $data->LicenseID : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>{{ __('Expiry Date') }}</strong>
                                        <span>{{$data->LicenseExpiryDate ? $data->LicenseExpiryDate : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>{{ __('Licence Issued By') }}</strong>
                                        <span>{{$data->LicenseIssuedBy ? $data->LicenseIssuedBy : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>{{ __('Email') }}</strong>
                                        <span>{{$data->Email ? $data->Email : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>{{ __('Date of Birth') }}</strong>
                                        <span>{{$data->DateOfBirth ? $data->DateOfBirth : '--'}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="right-wrap-profile floatLeft">
                                <div class="profile-right-single">
                                    <h5>{{ __('Membership Details') }}</h5>
                                    <div class="membership-details">
                                        <strong>{{ __('Membership Id') }}</strong>
                                        <span>{{$data->Membership->MembershipNo ? $data->Membership->MembershipNo : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>{{ __('Status') }}</strong>
                                        <span>{{$data->Membership->Status ? $data->Membership->Status : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>{{ __('Card Type') }}</strong>
                                        <span>{{$data->Membership->CardType ? $data->Membership->CardType : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>{{ __('Issue Date') }}</strong>
                                        <span>{{$data->Membership->IssueDate ? $data->Membership->IssueDate : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>{{ __('Expiry Date') }}</strong>
                                        <span>{{$data->Membership->ExpiryDate ? $data->Membership->ExpiryDate : '--'}}</span>
                                    </div>
                                </div>
                                <div class="profile-right-single">
                                    <h5>{{ __('Loyalty') }}</h5>
                                    <div class="membership-details">
                                        <strong>{{ __('Total Points') }}</strong>
                                        <span>{{$data->Loyality->TotalPoints ? $data->Loyality->TotalPoints : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>{{ __('Used Points') }}</strong>
                                        <span>{{$data->Loyality->UsedPoints ? $data->Loyality->UsedPoints : '--'}}</span>
                                    </div>
                                    @php ($dt = $up = $dn = '')
                                    @if ($data->Loyality->LastUsed != '')
                                        @php (list($dt, $up, $dn) = explode(',',$data->Loyality->LastUsed))
                                    @endif
                                    <div class="membership-details">
                                        <strong>{{ __('Last Used') }}</strong>
                                        <span>{{ $dt ? $dt : '--' }}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>{{ __('Balance') }}</strong>
                                        <span>{{$data->Loyality->BalancePoints ? $data->Loyality->BalancePoints : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>{{ __('Document Number') }}</strong>
                                        <span>{{ $dn ? $dn : '--' }}</span>
                                    </div>
                                </div>
                                <div class="profile-right-single">
                                    <h5>{{ __('Uploaded Documents') }}</h5>
                                    <div class="membership-details">
                                        <strong>{{ __('ID/Iqama') }}</strong>
                                        <span>{{$data->ID}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>{{ __('License') }}</strong>
                                        <span>{{$data->LicenseID}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="clearBoth"></div>
                        </div>

                        <div class="clearBoth"></div>
                    </div>
                </div>

            </div>
@stop