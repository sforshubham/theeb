@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">

                    <div>
                        <div class="login-bg">
                            <div class="login-wrapper">
                                <div class="white-transparent"></div>
                                <div class="main-login-wrapper">
                                    <h4>Forgot Password</h4>
                                    <div class="login-inner-wrapper">
                                        <form method="POST" action="{{url('/forgot_password')}}">
                                            <input type="text" name="Email" placeholder="Enter Email" class="change-pwd-input" />
                                            <input type="submit" value="Submit" class="submit-buttom change-pwd-input-btn" />
                                        </form>
                                        <div class="buttons-signup">
                                            <a href="{{url('/') }}" class="floatLeft">Sign In?</a>
                                            <div class="clearBoth"></div>
                                        </div>
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