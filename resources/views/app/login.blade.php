@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">

                    <div>
                        <div class="login-bg">
                            <div class="login-wrapper">
                                <div class="white-transparent"></div>
                                <div class="main-login-wrapper">
                                    <h4>{{ __('Login') }}</h4>
                                    <div class="login-inner-wrapper">
                                        <form action="{{url('/login')}}" method="POST">
                                            <input type="text" name="emailId" placeholder="{{ __('Email') }}" class="username" autofocus/>
                                            <input type="password" name="password" placeholder="{{ __('Password') }}" class="email" />
                                            <input type="submit" value="{{ __('Login') }}" />
                                        </form>
                                        <div class="buttons-signup">
                                            <a href="{{url('/signup')}}" class="floatRight">{{ __("Don't have an account? Register") }}</a>
                                            <a href="{{url('/request_password') }}" class="floatLeft">{{ __('Forgot Password') }}</a>
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