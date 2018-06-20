@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder">
                <div class="safeArea">

                    <div>
                        <div class="login-bg">
                            <div class="login-wrapper">
                                <div class="white-transparent"></div>
                                <div class="main-login-wrapper">
                                    <h4>{{ __('Enter One Time Password') }}</h4>
                                    <div class="login-inner-wrapper">
                                        <form action="{{url('/verify')}}" method="POST" name="verify-form">
                                            <input type="text" name="PassportID" placeholder="{{ __('ID Number') }}" class="username" autofocus value="{{ $PassportID ?? ''}}"/>
                                            <input type="text" name="EmailID" placeholder="{{ __('Email') }}" class="username" value="{{ $EmailID ?? ''}}"/>
                                            <input autocomplete="new-password" type="password" name="OTP" placeholder="{{ __('OTP') }}" class="email"/>
                                            <input type="button" name="verify" value="{{ __('Verify') }}" />
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
<script type="text/javascript">
    @if (isset($status))
        @if ($status == true)
            jQuery.notify('{!! $response !!}', "success");
        @elseif (is_array($response))
            jQuery.notify("{{ implode($response, '\n') }}", "error");
        @endif
    @endif
    jQuery('input[name="verify"]').click(function() {
        var id_number = jQuery('input[name="PassportID"]');
        var email = jQuery('input[name="EmailID"]');
        var otp = jQuery('input[name="OTP"]');

        if (id_number.val().trim() == "") {
            id_number.focus().notify("Please enter an ID Number", "error");
            return;
        }

        // Email validation
        if (email.val().trim()  == '') {
            email.focus().notify("Please enter an Email", "error");
            // Remaining validations are handled by backend code
            return;
        }
        if (!ValidateEmail(email.val().trim())) {
            email.focus().notify("Please enter a valid Email", "error");
            // Remaining validations are handled by backend code
            return;
        }

        if (otp.val().trim() == "") {
            otp.focus().notify("Please enter an ID Number", "error");
            return;
        }
        jQuery('form[name="verify-form"]').submit();
    });

    function ValidateEmail(email)
    {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
        {
            return true;
        }
        return false;
    }
</script>
@stop