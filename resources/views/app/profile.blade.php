@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="javascript:void();" class="my-booking-btn">Profile</a>
                    </div>
                    <div>
                        <div class="white-bg">
                            <div class="left-wrap-profile floatRight">
                                <div class="profile-image-show">
                                    <img src="data:image/gif;base64,{{$data->DriverImage}}" onerror="this.src='{!!$setting['profile_img']!!}'"/>
                                    <h5>{{$data->Name ? $data->Name : '--'}}</h5>
                                </div>
                                <div class="profile-details">
                                    <span>Personal Details</span>
                                    <div class="profile-single-wrap">
                                        <strong>Nationality</strong>
                                        <span>{{$data->Nationality ? $data->Nationality : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>ID & version</strong>
                                        <span>{{$data->ID ? $data->ID.'-'.$data->IDVersion : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>License Number</strong>
                                        <span>{{$data->LicenseID ? $data->LicenseID : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>License Expiry Date</strong>
                                        <span>{{$data->LicenseExpiryDate ? $data->LicenseExpiryDate : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>License Issued By</strong>
                                        <span>{{$data->LicenseIssuedBy ? $data->LicenseIssuedBy : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>Email Id</strong>
                                        <span>{{$data->Email ? $data->Email : '--'}}</span>
                                    </div>
                                    <div class="profile-single-wrap">
                                        <strong>Date Of Birth</strong>
                                        <span>{{$data->DateOfBirth ? $data->DateOfBirth : '--'}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="right-wrap-profile floatLeft">
                                <div class="profile-right-single">
                                    <h5>Membership Details</h5>
                                    <div class="membership-details">
                                        <strong>Membership ID</strong>
                                        <span>{{$data->Membership->MembershipNo ? $data->Membership->MembershipNo : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>Status</strong>
                                        <span>{{$data->Membership->Status ? $data->Membership->Status : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>Card Type</strong>
                                        <span>{{$data->Membership->CardType ? $data->Membership->CardType : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>Issue Date</strong>
                                        <span>{{$data->Membership->IssueDate ? $data->Membership->IssueDate : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>Expiry Date</strong>
                                        <span>{{$data->Membership->ExpiryDate ? $data->Membership->ExpiryDate : '--'}}</span>
                                    </div>
                                </div>
                                <div class="profile-right-single">
                                    <h5>Loyalty</h5>
                                    <div class="membership-details">
                                        <strong>Total Points</strong>
                                        <span>{{$data->Loyality->TotalPoints ? $data->Loyality->TotalPoints : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>Used Points</strong>
                                        <span>{{$data->Loyality->UsedPoints ? $data->Loyality->UsedPoints : '--'}}</span>
                                    </div>
                                    @php (list($dt, $up, $dn) = explode(',',$data->Loyality->LastUsed))
                                    <div class="membership-details">
                                        <strong>Last Used</strong>
                                        <span>{{ $dt ? $dt : '--' }}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>Balance Points</strong>
                                        <span>{{$data->Loyality->BalancePoints ? $data->Loyality->BalancePoints : '--'}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>Document Number</strong>
                                        <span>{{ $dn ? $dn : '--' }}</span>
                                    </div>
                                </div>
                                <div class="profile-right-single">
                                    <h5>Uploaded Documents</h5>
                                    <div class="membership-details">
                                        <strong>ID/Iqama</strong>
                                        <span>{{$data->ID}}</span>
                                    </div>
                                    <div class="membership-details">
                                        <strong>License</strong>
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