@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder">
                 <div class="book-a-car-bg"></div>
                <div class="safeArea">
                    <?php 
                    $vehicleOptn = $branchOptn = '';

                    $input_data = session('data');
                    if (session()->has('data')) {
                        $input_data = session('data');
                        $selected['CarCategory'] = $input_data['CarCategory'];
                    } else {
                        $input_data = [];
                    }
                    $schedules = [];
                    foreach ($branches as $branch) {
                        $schedules[$branch['BranchCode']] = $branch['Schedule'];
                        $branchOptn .= '<option value="'.$branch['BranchCode'].'">'.$branch['BranchName'].'</option>';
                    }
                    foreach ($vehicles as $veh) {
                        $vehicleOptn .= '<option value="'.$veh['VTHCode'].'">'.$veh['VTHDesc'].'</option>';
                    }

                    $vehicleOptn = str_replace('<option value="'.$selected['CarCategory'].'">', '<option value="'.$selected['CarCategory'].'" selected="selected">', $vehicleOptn);
                    ?>
                    <div>
                        <div class="white-bg white-bg-space">
                            <h3 style="font-size: 25px; margin-bottom: 20px;">{{ __('Car Reservation') }}</h3>
                            <div class="show-vehicles">
                            <form method="GET" action = "{{url('/price_estimation')}}">
                                <div class="show-vehicles-individual-wrap ishow-vehicles-individual-wrap">
                                    <select class="widthbig" name="PickupLocation" id="out_location" required="required">
                                        <option value="">{{ __('Select Pickup Location') }}</option>
                                        {!! isset($input_data['PickupLocation']) ? str_replace('<option value="'.$input_data['PickupLocation'].'">', '<option value="'.$input_data['PickupLocation'].'" selected="selected">', $branchOptn) : $branchOptn !!}
                                    </select>
                                    <input class="widthsm" type="text" placeholder="Select Pickup Time" id="datetimepicker1" required="required" readonly="readonly" />
                                    <input type="hidden" name="PickupDate" id="out_date" value="{{ $input_data['PickupDate'] ?? '' }}" />
                                    <input type="hidden" name="PickupTime" id="out_time" value="{{ $input_data['PickupTime'] ?? '' }}" />
                                    <select class="widthbig" name="CarCategory" required="required">
                                        <option value="">{{ __('Select Car Category') }}</option>
                                        {!! $vehicleOptn !!}
                                    </select>
                                </div>
                                <div class="show-vehicles-individual-wrap ishow-vehicles-individual-wrap">
                                    <select class="widthbig" name="DropLocation" id="in_location" required="required">
                                        <option value="">{{ __('Select Drop Location') }}</option>
                                        {!! isset($input_data['DropLocation']) ? str_replace('<option value="'.$input_data['DropLocation'].'">', '<option value="'.$input_data['DropLocation'].'" selected="selected">', $branchOptn) : $branchOptn !!}
                                    </select>
                                    <input class="widthsm" type="text" placeholder="Select Drop Time" id="datetimepicker2" required="required" readonly="readonly" />
                                    <input type="hidden" name="DropDate" id="in_date" value="{{ $input_data['DropDate'] ?? '' }}"/>
                                    <input type="hidden" name="DropTime" id="in_time" value="{{ $input_data['DropTime'] ?? '' }}"/>
                                    <input type="hidden" name="CarGroup" value="{{$selected['CarGroup']}}" />
                                    <input class="widthbig" style="background-color: #e3a6c2 !important;" type="submit" id="FormSubmit" Value="{{ __('Book Now') }}" />
                                </div>
                            </form>
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
    $(function() {
        var pickup_start_date = '';
        var time_format = "HH:mm";
        var currentdate = moment();
        //var cm = parseInt(currentdate.getMinutes());
        var cm = currentdate.add(1, 'd').format('mm');
        var mm = cm % 5;
        var mins = 0;
        if (mm) {
            var mins = (5 - mm);
        }
        currentdate.add(mins, 'minutes');
        var mins = currentdate.format('mm');
        var ctime = currentdate.format(time_format);

        var latedate = currentdate.format('DD/MM/YYYY');
        var branch_schedule = {!! json_encode($schedules) !!};

        moment.fn.roundNext5Min = function () {
            var intervals = Math.floor(this.minutes() / 5);
            if(this.minutes() % 5 != 0)
                intervals++;
            if(intervals == 20) {
                this.add('hours', 1);
                intervals = 0;
            }
            this.minutes(intervals * 5);
            this.seconds(0);
            return this;
        }

        @if (empty($input_data))
            $('#out_date, #in_date').val(latedate);
            $('#out_time, #in_time').val(ctime);
        @endif

        $('#FormSubmit').on('click', function (e){
            $('.notifyjs-corner').empty(); // removes existing messages
            var out_location = $('#out_location').val();
            var out_date = $('#out_date').val();
            var out_time = $('#out_time').val();
            var in_location = $('#in_location').val();
            var in_date = $('#in_date').val();
            var in_time = $('#in_time').val();
            var car_cat = $('select[name="CarCategory"]').val();

            if (out_location == '' || in_location == '') {
                $.notify("Pickup and Drop location can not be blank", {globalPosition: "top right", className: "error"});
                return false;
            }
            if (car_cat == '') {
                $.notify("Car Category can not be blank", {globalPosition: "top right", className: "error"});
                return false;
            }

            var out_m = moment(out_date+' '+out_time, 'DD/MM/YYYY HH:mm');
            var in_m = moment(in_date+' '+in_time, 'DD/MM/YYYY HH:mm');
            var is_pickup_avail = false;
            var is_drop_avail = false;

            if (out_location in branch_schedule) {
                var out_d = out_m.get('d') + 1;
                var sch = JSON.parse(branch_schedule[out_location]);
                $.each(sch, function(key, value) {
                    if (value.DayCode == out_d) {
                        var chosen_time = moment(out_time, time_format);
                        var start_time = moment(value.StartTime, time_format);
                        var end_time = moment(value.EndTime, time_format);
                        if (!chosen_time.isBetween(start_time, end_time)) {
                        } else {
                            is_pickup_avail = true;
                        }
                    }
                });
            }

            if (in_location in branch_schedule) {
                var in_d = in_m.get('d') + 1;
                var sch = JSON.parse(branch_schedule[in_location]);
                $.each(sch, function(key, value) {
                    if (value.DayCode == in_d) {
                        var chosen_time = moment(in_time, time_format);
                        var start_time = moment(value.StartTime, time_format);
                        var end_time = moment(value.EndTime, time_format);
                        if (!chosen_time.isBetween(start_time, end_time)) {
                        } else {
                            is_drop_avail = true;
                        }
                    }
                });
            }
            if (is_drop_avail == false) {
                e.preventDefault();
                $.notify("{!! str_replace('{tag}', 'Drop Location', config('settings.resp_msg.branch_unavailable')) !!}", {globalPosition: "top right", className: "error"});
            }

            if (is_pickup_avail == false) {
                e.preventDefault();
                $.notify("{!! str_replace('{tag}', 'Pickup Location', config('settings.resp_msg.branch_unavailable')) !!}", {globalPosition: "top right", className: "error"});
            }

        });

        $('#datetimepicker1').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            timePickerIncrement:5,
            minDate:moment().startOf('d') .add(1, 'd'),
            {!! isset($input_data['PickupDate']) ? 'startDate: "'.$input_data['PickupDate'].' '.convert24hrto12hr($input_data['PickupTime']).'",' : 'startDate: moment().add(1, \'d\').roundNext5Min(),' !!}
            locale: {
                format: 'DD/MM/YYYY hh:mm A'
            }
        }, function(start, end, label) {
            var out_date = start.format('DD/MM/YYYY');
            var out_time = start.format(time_format);
            $('#out_date').val(out_date);
            $('#out_time').val(out_time);
            $('#in_date').val(out_date);
            $('#in_time').val(out_time);

            $('#datetimepicker2').daterangepicker({
                minDate: start,
                startDate: start,
                singleDatePicker: true,
                timePicker: true,
                timePickerIncrement:5,
                locale: {
                  format: 'DD/MM/YYYY hh:mm A'
                }
            }, function(start, end, label) {
                var in_date = start.format('DD/MM/YYYY');
                var in_time = start.format(time_format);
                $('#in_date').val(in_date);
                $('#in_time').val(in_time);
            });
        });

        $('#datetimepicker2').daterangepicker({
            {!! isset($input_data['PickupDate']) ? 'minDate: "'.$input_data['PickupDate'].' '.convert24hrto12hr($input_data['PickupTime']).'",' : 'minDate: moment().add(1, \'d\').startOf(\'d\'),' !!}
            {!! isset($input_data['DropDate']) ? 'startDate: "'.$input_data['DropDate'].' '.convert24hrto12hr($input_data['DropTime']).'",' : 'startDate: moment().add(1, \'d\').roundNext5Min(),' !!}
            singleDatePicker: true,
            timePicker: true,
            timePickerIncrement:5,
            locale: {
              format: 'DD/MM/YYYY hh:mm A'
            }
        }, function(start, end, label) {
            var in_date = start.format('DD/MM/YYYY');
            var in_time = start.format(time_format);
            $('#in_date').val(in_date);
            $('#in_time').val(in_time);
        });
    });

    $('select[name="PickupLocation"]').on('change', function (){
        var selected_val = $(this).val();
        $('select[name="DropLocation"]').val(selected_val);
    });
</script>
@stop
