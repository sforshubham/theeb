@extends('layouts.default')
@section('content')
    <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
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
                                        <input type="text" placeholder="{{ __('License Expiry Date') }}*" name="LicenseExpiryDate" value="{{ $LicenseExpiryDate }}" />
                                    </div>
                                    <div class="three-column-signup">
                                        <select name="Nationality">
                                            <option value="" selected>{{ __('Nationality') }}</option>
                                            <option value="Afghanistan">Afghanistan</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="American Samoa">American Samoa</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Anguilla">Anguilla</option>
                                            <option value="Antartica">Antarctica</option>
                                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Aruba">Aruba</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaijan">Azerbaijan</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                            <option value="Benin">Benin</option>
                                            <option value="Bermuda">Bermuda</option>
                                            <option value="Bhutan">Bhutan</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                                            <option value="Botswana">Botswana</option>
                                            <option value="Bouvet Island">Bouvet Island</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                            <option value="Brunei Darussalam">Brunei Darussalam</option>
                                            <option value="Bulgaria">Bulgaria</option>
                                            <option value="Burkina Faso">Burkina Faso</option>
                                            <option value="Burundi">Burundi</option>
                                            <option value="Cambodia">Cambodia</option>
                                            <option value="Cameroon">Cameroon</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Cape Verde">Cape Verde</option>
                                            <option value="Cayman Islands">Cayman Islands</option>
                                            <option value="Central African Republic">Central African Republic</option>
                                            <option value="Chad">Chad</option>
                                            <option value="Chile">Chile</option>
                                            <option value="China">China</option>
                                            <option value="Christmas Island">Christmas Island</option>
                                            <option value="Cocos Islands">Cocos (Keeling) Islands</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Comoros">Comoros</option>
                                            <option value="Congo">Congo</option>
                                            <option value="Congo">Congo, the Democratic Republic of the</option>
                                            <option value="Cook Islands">Cook Islands</option>
                                            <option value="Costa Rica">Costa Rica</option>
                                            <option value="Cota D'Ivoire">Cote d'Ivoire</option>
                                            <option value="Croatia">Croatia (Hrvatska)</option>
                                            <option value="Cuba">Cuba</option>
                                            <option value="Cyprus">Cyprus</option>
                                            <option value="Czech Republic">Czech Republic</option>
                                            <option value="Denmark">Denmark</option>
                                            <option value="Djibouti">Djibouti</option>
                                            <option value="Dominica">Dominica</option>
                                            <option value="Dominican Republic">Dominican Republic</option>
                                            <option value="East Timor">East Timor</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="Egypt">Egypt</option>
                                            <option value="El Salvador">El Salvador</option>
                                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                                            <option value="Eritrea">Eritrea</option>
                                            <option value="Estonia">Estonia</option>
                                            <option value="Ethiopia">Ethiopia</option>
                                            <option value="Falkland Islands">Falkland Islands (Malvinas)</option>
                                            <option value="Faroe Islands">Faroe Islands</option>
                                            <option value="Fiji">Fiji</option>
                                            <option value="Finland">Finland</option>
                                            <option value="France">France</option>
                                            <option value="France Metropolitan">France, Metropolitan</option>
                                            <option value="French Guiana">French Guiana</option>
                                            <option value="French Polynesia">French Polynesia</option>
                                            <option value="French Southern Territories">French Southern Territories</option>
                                            <option value="Gabon">Gabon</option>
                                            <option value="Gambia">Gambia</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Germany">Germany</option>
                                            <option value="Ghana">Ghana</option>
                                            <option value="Gibraltar">Gibraltar</option>
                                            <option value="Greece">Greece</option>
                                            <option value="Greenland">Greenland</option>
                                            <option value="Grenada">Grenada</option>
                                            <option value="Guadeloupe">Guadeloupe</option>
                                            <option value="Guam">Guam</option>
                                            <option value="Guatemala">Guatemala</option>
                                            <option value="Guinea">Guinea</option>
                                            <option value="Guinea-Bissau">Guinea-Bissau</option>
                                            <option value="Guyana">Guyana</option>
                                            <option value="Haiti">Haiti</option>
                                            <option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
                                            <option value="Holy See">Holy See (Vatican City State)</option>
                                            <option value="Honduras">Honduras</option>
                                            <option value="Hong Kong">Hong Kong</option>
                                            <option value="Hungary">Hungary</option>
                                            <option value="Iceland">Iceland</option>
                                            <option value="India">India</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="Iran">Iran (Islamic Republic of)</option>
                                            <option value="Iraq">Iraq</option>
                                            <option value="Ireland">Ireland</option>
                                            <option value="Israel">Israel</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Jamaica">Jamaica</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Jordan">Jordan</option>
                                            <option value="Kazakhstan">Kazakhstan</option>
                                            <option value="Kenya">Kenya</option>
                                            <option value="Kiribati">Kiribati</option>
                                            <option value="Democratic People's Republic of Korea">Korea, Democratic People's Republic</option>
                                            <option value="Korea">Korea, Republic of</option>
                                            <option value="Kuwait">Kuwait</option>
                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                            <option value="Lao">Lao People's Democratic Republic</option>
                                            <option value="Latvia">Latvia</option>
                                            <option value="Lebanon">Lebanon</option>
                                            <option value="Lesotho">Lesotho</option>
                                            <option value="Liberia">Liberia</option>
                                            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                            <option value="Liechtenstein">Liechtenstein</option>
                                            <option value="Lithuania">Lithuania</option>
                                            <option value="Luxembourg">Luxembourg</option>
                                            <option value="Macau">Macau</option>
                                            <option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
                                            <option value="Madagascar">Madagascar</option>
                                            <option value="Malawi">Malawi</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="Maldives">Maldives</option>
                                            <option value="Mali">Mali</option>
                                            <option value="Malta">Malta</option>
                                            <option value="Marshall Islands">Marshall Islands</option>
                                            <option value="Martinique">Martinique</option>
                                            <option value="Mauritania">Mauritania</option>
                                            <option value="Mauritius">Mauritius</option>
                                            <option value="Mayotte">Mayotte</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Micronesia">Micronesia, Federated States of</option>
                                            <option value="Moldova">Moldova, Republic of</option>
                                            <option value="Monaco">Monaco</option>
                                            <option value="Mongolia">Mongolia</option>
                                            <option value="Montserrat">Montserrat</option>
                                            <option value="Morocco">Morocco</option>
                                            <option value="Mozambique">Mozambique</option>
                                            <option value="Myanmar">Myanmar</option>
                                            <option value="Namibia">Namibia</option>
                                            <option value="Nauru">Nauru</option>
                                            <option value="Nepal">Nepal</option>
                                            <option value="Netherlands">Netherlands</option>
                                            <option value="Netherlands Antilles">Netherlands Antilles</option>
                                            <option value="New Caledonia">New Caledonia</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Nigeria">Nigeria</option>
                                            <option value="Niue">Niue</option>
                                            <option value="Norfolk Island">Norfolk Island</option>
                                            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                            <option value="Norway">Norway</option>
                                            <option value="Oman">Oman</option>
                                            <option value="Pakistan">Pakistan</option>
                                            <option value="Palau">Palau</option>
                                            <option value="Panama">Panama</option>
                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Peru">Peru</option>
                                            <option value="Philippines">Philippines</option>
                                            <option value="Pitcairn">Pitcairn</option>
                                            <option value="Poland">Poland</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Puerto Rico">Puerto Rico</option>
                                            <option value="Qatar">Qatar</option>
                                            <option value="Reunion">Reunion</option>
                                            <option value="Romania">Romania</option>
                                            <option value="Russia">Russian Federation</option>
                                            <option value="Rwanda">Rwanda</option>
                                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                                            <option value="Saint LUCIA">Saint LUCIA</option>
                                            <option value="Saint Vincent">Saint Vincent and the Grenadines</option>
                                            <option value="Samoa">Samoa</option>
                                            <option value="San Marino">San Marino</option>
                                            <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                            <option value="Senegal">Senegal</option>
                                            <option value="Seychelles">Seychelles</option>
                                            <option value="Sierra">Sierra Leone</option>
                                            <option value="Singapore">Singapore</option>
                                            <option value="Slovakia">Slovakia (Slovak Republic)</option>
                                            <option value="Slovenia">Slovenia</option>
                                            <option value="Solomon Islands">Solomon Islands</option>
                                            <option value="Somalia">Somalia</option>
                                            <option value="South Africa">South Africa</option>
                                            <option value="South Georgia">South Georgia and the South Sandwich Islands</option>
                                            <option value="Span">Spain</option>
                                            <option value="SriLanka">Sri Lanka</option>
                                            <option value="St. Helena">St. Helena</option>
                                            <option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
                                            <option value="Sudan">Sudan</option>
                                            <option value="Suriname">Suriname</option>
                                            <option value="Svalbard">Svalbard and Jan Mayen Islands</option>
                                            <option value="Swaziland">Swaziland</option>
                                            <option value="Sweden">Sweden</option>
                                            <option value="Switzerland">Switzerland</option>
                                            <option value="Syria">Syrian Arab Republic</option>
                                            <option value="Taiwan">Taiwan, Province of China</option>
                                            <option value="Tajikistan">Tajikistan</option>
                                            <option value="Tanzania">Tanzania, United Republic of</option>
                                            <option value="Thailand">Thailand</option>
                                            <option value="Togo">Togo</option>
                                            <option value="Tokelau">Tokelau</option>
                                            <option value="Tonga">Tonga</option>
                                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                            <option value="Tunisia">Tunisia</option>
                                            <option value="Turkey">Turkey</option>
                                            <option value="Turkmenistan">Turkmenistan</option>
                                            <option value="Turks and Caicos">Turks and Caicos Islands</option>
                                            <option value="Tuvalu">Tuvalu</option>
                                            <option value="Uganda">Uganda</option>
                                            <option value="Ukraine">Ukraine</option>
                                            <option value="United Arab Emirates">United Arab Emirates</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United States">United States</option>
                                            <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                            <option value="Uruguay">Uruguay</option>
                                            <option value="Uzbekistan">Uzbekistan</option>
                                            <option value="Vanuatu">Vanuatu</option>
                                            <option value="Venezuela">Venezuela</option>
                                            <option value="Vietnam">Viet Nam</option>
                                            <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                            <option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
                                            <option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
                                            <option value="Western Sahara">Western Sahara</option>
                                            <option value="Yemen">Yemen</option>
                                            <option value="Yugoslavia">Yugoslavia</option>
                                            <option value="Zambia">Zambia</option>
                                            <option value="Zimbabwe">Zimbabwe</option>
                                        </select>
                                        <input type="text" placeholder="{{ __('First Name') }}" name="FirstName" value="{{ $FirstName }}" />
                                        <input type="text" placeholder="{{ __('Last Name') }}*" name="LastName" value="{{ $LastName }}" />
                                    </div>
                                    <div class="two-column-signup">
                                        <input type="text" placeholder="{{ __('Address 1') }}" name="Address1" value="{{ $Address1 }}" />
                                        <input type="text" placeholder="{{ __('Address 2') }}" name="Address2" value="{{ $Address2 }}" />
                                    </div>
                                    <div class="two-column-signup">
                                        <input type="text" placeholder="{{ __('Date of Birth') }}*" name="DateOfBirth" value="{{ $DateOfBirth }}" />
                                        <input type="text" placeholder="{{ __('Mobile Number') }}*" name="Mobile" value="{{ $Mobile }}" />
                                    </div>
                                    <div class="two-column-signup">
                                        <input type="text" placeholder="{{ __('Email') }}*" name="Email" value="{{ $Email }}" />
                                        <input type="password" placeholder="{{ __('Password') }}*" name="Password" value="{{ $Password }}" />
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
<script type="text/javascript" src="{{ URL::asset('js/notify.min.js') }}"></script>
<script type="text/javascript">
    jQuery(function() {
        // Set Notifier defaults
        jQuery.notify.defaults({ autoHideDelay: 7000 });

        @if ($status == true)
            jQuery.notify("Your details have been saved successfully. Please login with your credentials.", "success");
        @elseif (is_array($response))
            jQuery.notify("{{ implode($response, '\n') }}", "error");
        @endif

        @if ($Nationality != '')
            jQuery('select[name="Nationality"] option[value={{ $Nationality }}]').attr('selected', 'selected');
        @endif

        // Init date of birth calender
        jQuery('input[name="DateOfBirth"]').daterangepicker({
            autoUpdateInput: false,
            showDropdowns: true,
            singleDatePicker: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        // Init license expiry data calender
        jQuery('input[name="LicenseExpiryDate"]').daterangepicker({
            autoUpdateInput: false,
            showDropdowns: true,
            singleDatePicker: true,
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
                // Saudi ID - ID Number must start wtih 2
                if (!/^2.*/.test(id_number.val())) {
                    id_number.notify("Invalid ID number for a Saudi ID, please recheck", "error");
                    return;
                }
            } else if (id_type.val() == 'I') {
                // Iqama - ID Number must start with 2
                if (!/^1.*/.test(id_number.val())) {
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
                if (data['IdNo'] != '') {
                    for (var property in data) {
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
            var password = jQuery('input[name="Password"]');
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
                if (!/^2.*/.test(id_number.val())) {
                    id_number.focus().notify("Invalid ID number for a Saudi ID, please recheck", "error");
                    return;
                }
            } else if (id_type.val() == 'I') {
                // Iqama - ID Number must start with 2
                if (!/^1.*/.test(id_number.val())) {
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
            if (!/^.{8,}$/.test(password.val())) {
                password.focus().notify("Password field should have minimum 8 chars", "error");
                return;
            }

            jQuery('form[name="signup_form"]').submit();
        });
    });
</script>
@stop