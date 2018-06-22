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
                            <h4>{{ __('Register') }}</h4>
                            <div class="signup-inner-wrapper">
                                <form name="signup_form" method="post" enctype="multipart/form-data">
                                    <div class="three-column-signup">
                                        <select name="IdType">
                                            <option value="0" selected="">{{ __('ID Type') }}</option>   
                                            <option value="S">Saudi ID</option>
                                            <option value="I">Iqama</option>
                                            <option value="P">Passport</option>
                                        </select>
                                        <input type="text" placeholder="{{ __('ID Number') }}" name="IdNo" id="IdNo" class="id-number" value="{{ $IdNo }}" /><input type="file" name="IdDoc" id="IdDoc"><label for="IdDoc" id="IdDocLabel"></label>
                                        <input type="text" placeholder="{{ __('ID Version') }}*" name="id_version" value="{{ $id_version }}" />
                                    </div>
                                    <div class="two-column-signup">
                                        <input type="text" placeholder="{{ __('License Number') }}" class="license-number" name="LicenseId" value="{{ $LicenseId }}" id="LicenseId" /><input type="file" name="LicenseDoc" id="LicenseDoc"><label for="LicenseDoc" id="LicenseDocLabel"></label>
                                        <input type="text" placeholder="{{ __('License Expiry Date') }}*" readonly="readonly" name="LicenseExpiryDate" value="{{ $LicenseExpiryDate }}" />
                                    </div>
                                    <div class="three-column-signup">
                                        <select name="Nationality">
                                            <option value="" selected>{{ __('Nationality') }}</option>
                                            @foreach (allCountries() as $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" placeholder="{{ __('First Name') }}" name="FirstName" value="{{ $FirstName }}" />
                                        <input type="text" placeholder="{{ __('Last Name') }}*" name="LastName" value="{{ $LastName }}" />
                                    </div>
                                    <div class="two-column-signup">
                                        <input type="text" placeholder="{{ __('Address 1') }}" name="Address1" value="{{ $Address1 }}" />
                                        <input type="text" placeholder="{{ __('Address 2') }}" name="Address2" value="{{ $Address2 }}" />
                                    </div>
                                    <div class="two-column-signup">
                                        <input type="text" placeholder="{{ __('Date of Birth') }}*" name="DateOfBirth" readonly="readonly" value="{{ $DateOfBirth }}" />
                                        <input type="text" placeholder="{{ __('Mobile Number') }}*" name="Mobile" value="{{ $Mobile }}" />
                                    </div>
                                    <div class="two-column-signup">
                                        <input type="text" placeholder="{{ __('Email') }}*" name="Email" value="{{ $Email }}" />
                                        <input autocomplete="new-password" disabled="disabled" type="hidden" placeholder="{{ __('Password') }}*" name="Password" value="" />
                                    </div>
                                    <input type="button" value="{{ __('Register') }}" name="signup" />
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
    var max_upload_size = {!! env('MAX_UPLOAD_SIZE_IN_MB',2) !!};
    jQuery(function() {
        var old_date = moment().subtract(18, 'years').subtract(1, 'days');
        // Set Notifier defaults
        jQuery.notify.defaults({ autoHideDelay: 7000 });

        @if ($status == true)
            jQuery.notify("Your details have been saved successfully. Please login with your credentials.", "success");
        @elseif (is_array($response))
            jQuery.notify("{{ implode($response, '\n') }}", "error");
        @endif

        @if ($Nationality != '')
            jQuery('select[name="Nationality"] option[value="{{ $Nationality }}"]').attr('selected', 'selected');
        @endif

        // Init date of birth calender
        jQuery('input[name="DateOfBirth"]').daterangepicker({
            autoUpdateInput: false,
            showDropdowns: true,
            singleDatePicker: true,
            startDate:old_date,
            maxDate:old_date,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        // Init license expiry data calender
        jQuery('input[name="LicenseExpiryDate"]').daterangepicker({
            autoUpdateInput: false,
            showDropdowns: true,
            singleDatePicker: true,
            minDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        jQuery('input[name="LicenseExpiryDate"], input[name="DateOfBirth"]').on('apply.daterangepicker', function(ev, picker) {
            jQuery(this).val(picker.startDate.format('DD/MM/YYYY'));
        });

        // Id type - dropdown - on change event handler
        jQuery('select[name="IdType"]').change(function() {
            var id_type = jQuery(this);
            var id_version = jQuery('input[name="id_version"]')

            id_version.prop('disabled', false);
            if (id_type.val() == 'P') {
                // Passport - Disable ID Version
                id_version.prop('disabled', true);
            }


            if (jQuery('input[name="IdNo"]').val() != '') {
                jQuery('input[name="IdNo"]').trigger('change');
            }
        });

        @if ($IdType != '')
            jQuery('select[name="IdType"]').val('{{ $IdType }}').trigger('change');
        @endif

        // Id number - input field - on change event handler
        jQuery('input[name="IdNo"]').change(function() {
            var id_type = jQuery('select[name="IdType"]');
            var id_number = jQuery('input[name="IdNo"]');

            if (id_number.val() == "") {
                id_number.notify("Please enter an ID Number", "error");
                return;
            }

            if (id_type.val() == 0) {
                // ID type not selected
                id_type.notify("Please select ID Type first", "error");
                return;
            } else if (id_type.val() == 'S') {
                // Saudi ID - ID Number must start wtih 1
                if (!/^1[0-9]{9}$/.test(id_number.val())) {
                    id_number.notify("Invalid ID number for a Saudi ID, please recheck", "error");
                    return;
                }
            } else if (id_type.val() == 'I') {
                // Iqama - ID Number must start with 2
                if (!/^2[0-9]{9}$/.test(id_number.val())) {
                    id_number.notify("Invalid ID number for an Iqama, please recheck", "error");
                    return;
                }
            } else if (id_type.val() == 'P') {
                // Passport - No validation for ID Number
            } else {
                id_type.notify("Selected ID type does not adhere to standards.", "error");
                return;
            }

            jQuery('input[name="LicenseId"]').val(id_number.val());

            // try to fetch the ID based records
            jQuery('#loader').show();
            jQuery.get( "{{url('/view_driver')}}", { IdNo: id_number.val() } ).done(function( data ) {
                if (data['OTPVerified'] == 'Y' && data['Email'] != '') {
                    window.location = "{{url('/already_verified')}}"
                } else if (data['IdNo'] != '') {
                    for (var property in data) {
                        if (property == 'IdType' || property == 'IdNo') {
                            continue;
                        }
                        if (jQuery('input[name="' + property + '"]').length) {
                            jQuery('input[name="' + property + '"]').val(data[property]);
                        } else if (jQuery('select[name="' + property + '"]').length) {
                            jQuery('select[name="' + property + '"]').val(data[property]);
                        }
                    }
                } else {
                    jQuery.notify("We do not have your details with us. Please fill up the remaining form to proceed.", "info");
                }
            }).always(function() {
                jQuery('#loader').hide();
            });;
        });

        // Sign up - input button - on click event handler
        jQuery('input[name="signup"]').click(function() {
            var id_type = jQuery('select[name="IdType"]');
            var id_number = jQuery('input[name="IdNo"]');
            var id_version = jQuery('input[name="id_version"]');
            var first_name = jQuery('input[name="FirstName"]');
            var last_name = jQuery('input[name="LastName"]');
            var mobile = jQuery('input[name="Mobile"]');
            var email = jQuery('input[name="Email"]');
            //var password = jQuery('input[name="Password"]');
            var id_doc = jQuery('input[name="IdDoc"]');
            var license_id = jQuery('input[name="LicenseId"]');
            var license_doc = jQuery('input[name="LicenseDoc"]');
            var license_expiry_date = jQuery('input[name="LicenseExpiryDate"]');
            var nationality = jQuery('select[name="Nationality"]');
            var address1 = jQuery('input[name="Address1"]');
            var address2 = jQuery('input[name="Address2"]');
            var date_of_birth = jQuery('input[name="DateOfBirth"]');

            if (id_type.val() == 0) {
                // ID type not selected
                id_type.focus().notify("Please select ID Type first", "error");
                return;
            }

            if (id_number.val() == "") {
                id_number.focus().notify("Please enter an ID Number", "error");
                return;
            }

            if (id_type.val() == 'S') {
                // Saudi ID - ID Number must start wtih 2
                if (!/^1[0-9]{9}$/.test(id_number.val())) {
                    id_number.focus().notify("Invalid ID number for a Saudi ID, please recheck", "error");
                    return;
                }
            } else if (id_type.val() == 'I') {
                // Iqama - ID Number must start with 2
                if (!/^2[0-9]{9}$/.test(id_number.val())) {
                    id_number.focus().notify("Invalid ID number for an Iqama, please recheck", "error");
                    return;
                }
            } else if (id_type.val() == 'P') {
                // Passport - No validation for ID Number
            } else {
                id_type.focus().notify("Selected ID type does not adhere to standards.", "error");
                return;
            }

            if (id_doc.get(0).files.length === 0) {
                // ID Doc - mandatory
                id_doc.focus().notify("Submit a snapshot of the ID doc", "error");
                return;
            }

            if (id_doc.val() && id_doc[0].files[0].size > max_upload_size*1000*1000) {
                id_doc.focus().notify("File size should be less than "+max_upload_size+" MB", "error");
                id_doc.val('');
                return;
            }

            if (id_type.val() == 'P' || !isNaN(id_version.val()) && id_version.val() != 0 && /^[0-9]{1,2}$/.test(id_version.val())) {
                // Valid ID Version number
            } else {
                id_version.focus().notify("Version can only be between 1-99", "error");
                return;
            }

            if (license_id.val() == "") {
                // License ID - mandatory
                license_id.focus().notify("Please enter a License ID", "error");
                return;
            } else if (license_id.val() != id_number.val()) {
                license_id.focus().notify("License ID should match the ID number", "error");
                return;
            }

            if (license_doc.get(0).files.length === 0) {
                // ID Doc - mandatory
                license_doc.focus().notify("Submit a snapshot of the License ID", "error");
                return;
            }
            if (license_doc.val() && license_doc[0].files[0].size > max_upload_size*1000*1000) {
                license_doc.focus().notify("File size should be less than "+max_upload_size+" MB", "error");
                license_doc.val('');
                return;
            }

            if (license_expiry_date.val() == "") {
                // License Expiry Date - mandatory
                license_expiry_date.focus().notify("Please enter the expiry date for License", "error");
                return;
            }

            if (id_type.val() == 'S') {
                // Saudi ID - Nationality should also be Saudi Arabia
                if (nationality.val() != 'Saudi Arabia') {
                    nationality.focus().notify("For a Saudi ID, nationality should be Saudi Arabia", "error");
                    return;
                }
            } else if(nationality.val() == "") {
                nationality.focus().notify("Please select your nationality here.", "error");
                return;
            }

            // Mandatory First name 
            if (first_name.val().trim() == '') {
                first_name.focus().notify("First name is mandatory", "error");
                return;
            }

            // Mandatory Last name 
            if (last_name.val().trim()  == '') {
                last_name.focus().notify("Last name is mandatory", "error");
                return;
            }

            // Mandatory Address1 
            if (address1.val().trim() == '') {
                address1.focus().notify("This address field is mandatory", "error");
                return;
            }

            // Mandatory Address2 
            if (address2.val().trim() == '') {
                address2.focus().notify("This address field is mandatory", "error");
                return;
            }

            if (date_of_birth.val() == "") {
                // License Expiry Date - mandatory
                date_of_birth.focus().notify("Please enter the date of birth", "error");
                return;
            }

            // Mobile validation
            if (!/^05[0-9]{8}$/.test(mobile.val())) {
                mobile.focus().notify("Invalid mobile number", "error");
                return;
            }

            // Email validation
            if (email.val().trim()  == '') {
                email.focus().notify("Email is mandatory", "error");
                // Remaining validations are handled by backend code
                return;
            }

            // Password validation - min 8 chars
            /*if (!/^.{8,}$/.test(password.val())) {
                password.focus().notify("Password field should have minimum 8 chars", "error");
                return;
            }*/

            jQuery('form[name="signup_form"]').submit();
        });
    });
</script>
@stop