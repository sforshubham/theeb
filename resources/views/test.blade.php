@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">

                    <div>
                        <div class="login-bg">
                            <div class="login-wrapper">
                                <div class="white-transparent"></div>
                                <div class="main-login-wrapper">
                                    <h4>Change Password</h4>
                                    <div class="login-inner-wrapper">
                                        <input type="text" placeholder="Enter Old Password" class="change-pwd-input" />
                                        <input type="text" placeholder="Enter New Password" class="change-pwd-input" />
                                        <input type="text" placeholder="Confirm Password" class="change-pwd-input" />
                                        <input type="button" value="Submit" class="submit-buttom change-pwd-input-btn" />

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