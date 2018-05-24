@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">

                    <div>
                        <div class="login-bg">
                            <div class="login-wrapper">
                                <div class="white-transparent"></div>
                                <div class="main-login-wrapper">
                                    <h4>Login to your Account</h4>
                                    <div class="login-inner-wrapper">
                                        <form action="{{url('/login')}}" method="POST">
                                            <input type="text" name="emailId" placeholder="Email Id" class="username" autofocus/>
                                            <input type="password" name="password" placeholder="Password" class="email" />
                                            <input type="submit" value="Login" />
                                        </form>
                                        <div class="buttons-signup">
                                            <a href="{{url('/signup')}}" class="floatRight">Don't have account? Register</a>
                                            <a href="{{url('/request_password') }}" class="floatLeft">Forgot Password?</a>
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