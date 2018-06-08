@extends('layouts.default')
@section('content')
    <div class="bodyPageHolder">
        <div class="safeArea">

            <div>
                <div class="login-bg">
                    <div class="signup-wrapper">
                        <div class="loading" id="loader" style="display: none;">Loading…</div>
                        <div class="white-transparent"></div>
                        <div class="main-login-wrapper">
                            <h4>{{ __('Edit Profile') }}</h4>
                            <div class="signup-inner-wrapper">
                                <form name="signup_form" method="post" enctype="multipart/form-data">
                                    <div class="three-column-signup">
                                        <select name="IdType" disabled="disabled">
                                            <option value="0" selected="">{{ __('ID Type') }}</option>   
                                            <option value="S">Saudi ID</option>
                                            <option value="I">Iqama</option>
                                            <option value="P">Passport</option>
                                        </select>
                                        <input type="text" placeholder="{{ __('ID Number') }}" name="IdNo" id="IdNo" disabled="disabled" class="id-number" value="{{ $IdNo }}" /><input type="file" name="IdDoc" id="IdDoc"><label for="IdDoc" id="IdDocLabel"></label>
                                        <input type="text" placeholder="{{ __('ID Version') }}*" name="IDSerialNo" value="{{ $IDSerialNo }}" />
                                    </div>
                                    <div class="two-column-signup">
                                        <input type="text" disabled="disabled" placeholder="{{ __('License Number') }}" class="license-number" name="LicenseId" value="{{ $LicenseId }}" id="LicenseId" /><input type="file" name="LicenseDoc" id="LicenseDoc"><label for="LicenseDoc" id="LicenseDocLabel"></label>
                                        <input type="text" placeholder="{{ __('License Expiry Date') }}*" readonly="readonly" name="LicenseExpiryDate" value="{{ $LicenseExpiryDate }}" />
                                    </div>
                                    <div class="three-column-signup">
                                        <select name="Nationality" disabled="disabled">
                                            <option value="" selected>{{ __('Nationality') }}</option>
                                            @foreach (allCountries() as $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" disabled="disabled" placeholder="{{ __('First Name') }}" name="FirstName" value="{{ $FirstName }}" />
                                        <input type="text" disabled="disabled" placeholder="{{ __('Last Name') }}*" name="LastName" value="{{ $LastName }}" />
                                    </div>
                                    <div class="two-column-signup">
                                        <input disabled="disabled" type="text" placeholder="{{ __('Address 1') }}" name="Address1" value="{{ $Address1 }}" />
                                        <input disabled="disabled" type="text" placeholder="{{ __('Address 2') }}" name="Address2" value="{{ $Address2 }}" />
                                    </div>
                                    <div class="two-column-signup">
                                        <input disabled="disabled" type="text" placeholder="{{ __('Date of Birth') }}*" name="DateOfBirth" readonly="readonly" value="{{ $DateOfBirth }}" />
                                        <input type="text" placeholder="{{ __('Mobile Number') }}*" name="Mobile" value="{{ $Mobile }}" />
                                    </div>
                                    <div class="two-column-signup">
                                        <input disabled="disabled" type="text" placeholder="{{ __('Email') }}*" name="Email" value="{{ $Email }}" />
                                        <input type="file" name="DriverImage" title ="Upload Driver profile image"/>
                                    </div>
                                    <input type="button" value="{{ __('Update') }}" name="signup" />
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

@section('daterangepicker_script')
    <script type="text/javascript" src="{{ url('/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/daterangepicker.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/daterangepicker.css') }}" />
@stop

@section('custom_script')

<script type="text/javascript">
    jQuery(function() {
        //var old_date = moment().subtract(18, 'years').subtract(1, 'days');
        // Set Notifier defaults
        jQuery.notify.defaults({ autoHideDelay: 7000 });

        @if ($status == true)
            jQuery.notify("Profile has been updated successfully", "success");
        @elseif (is_array($response))
            jQuery.notify("{{ implode($response, '\n') }}", "error");
        @endif

        @if ($Nationality != '')
            jQuery('select[name="Nationality"] option[value="{{ $Nationality }}"]').attr('selected', 'selected');
        @endif

        // Init license expiry data calender
        jQuery('input[name="LicenseExpiryDate"]').daterangepicker({
            autoUpdateInput: false,
            showDropdowns: true,
            singleDatePicker: true,
            minDate: {!! '"'.$LicenseExpiryDate.'"' ?? 'moment()' !!},
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        jQuery('input[name="LicenseExpiryDate"], input[name="DateOfBirth"]').on('apply.daterangepicker', function(ev, picker) {
            jQuery(this).val(picker.startDate.format('DD/MM/YYYY'));
        });

        @if ($IdType != '')
            jQuery('select[name="IdType"]').val('{{ $IdType }}').trigger('change');
        @endif


        // Sign up - input button - on click event handler
        jQuery('input[name="signup"]').click(function() {
            var id_type = jQuery('select[name="IdType"]');
            var id_number = jQuery('input[name="IdNo"]');
            var IDSerialNo = jQuery('input[name="IDSerialNo"]');
            var first_name = jQuery('input[name="FirstName"]');
            var last_name = jQuery('input[name="LastName"]');
            var mobile = jQuery('input[name="Mobile"]');
            var email = jQuery('input[name="Email"]');
            var password = jQuery('input[name="Password"]');
            var id_doc = jQuery('input[name="IdDoc"]');
            var license_id = jQuery('input[name="LicenseId"]');
            var license_doc = jQuery('input[name="LicenseDoc"]');
            var license_expiry_date = jQuery('input[name="LicenseExpiryDate"]');
            var nationality = jQuery('select[name="Nationality"]');
            var address1 = jQuery('input[name="Address1"]');
            var address2 = jQuery('input[name="Address2"]');
            var date_of_birth = jQuery('input[name="DateOfBirth"]');

            if (id_type.val() == 'P' || !isNaN(IDSerialNo.val()) && IDSerialNo.val() != 0 && /^[0-9]{1,2}$/.test(IDSerialNo.val())) {
                // Valid ID Version number
            } else {
                IDSerialNo.focus().notify("Version can only be between 1-99", "error");
                return;
            }

            if (license_expiry_date.val() == "") {
                // License Expiry Date - mandatory
                license_expiry_date.focus().notify("Please enter the expiry date for License", "error");
                return;
            }

            // Mobile validation
            if (!/^05[0-9]{8}$/.test(mobile.val())) {
                mobile.focus().notify("Invalid mobile number", "error");
                return;
            }

            jQuery('form[name="signup_form"]').submit();
        });
    });
</script>
@stop