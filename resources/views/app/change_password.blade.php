@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder">
                <div class="safeArea">

                    <div>
                        <div class="login-bg">
                            <div class="login-wrapper">
                                <div class="white-transparent"></div>
                                <div class="main-login-wrapper">
                                    <h4>{{ __('Change Password') }}</h4>
                                    <div class="login-inner-wrapper">
                                    <form method="POST" action="{{url('/reset_password')}}">
                                        <input type="password" name="OldPassword" placeholder="{{ __('Enter Old Password') }}" class="change-pwd-input" />
                                        <input type="password" name="NewPassword" placeholder="{{ __('Enter New Password') }}" class="change-pwd-input" />
                                        <input type="password" name="ConfirmPassword" placeholder="{{ __('Confirm New Password') }}" class="change-pwd-input" />
                                        <input type="submit" value="{{ __('Submit') }}" class="submit-buttom change-pwd-input-btn" />
                                    </form>
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