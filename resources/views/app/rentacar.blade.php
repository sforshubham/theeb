@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
                <div class="safeArea">
                    <div class="tabs-top">
                        <a href="javascript:" class="my-booking-btn">Show Vehicles</a>

                    </div>
                    <?php 
                    $vehicleOptn = $branchOptn = '';

                    $input_data = session('data');
                    if (session()->has('data')) {
                        $input_data = session('data');
                        $selected['CarCategory'] = $input_data['CarCategory'];
                    } else {
                        $input_data = [];
                    }
                    foreach ($branches as $branch) {
                        $branchOptn .= '<option value="'.$branch['BranchCode'].'">'.$branch['BranchName'].'</option>';
                    }
                    foreach ($vehicles as $veh) {
                        $vehicleOptn .= '<option value="'.$veh['VTHCode'].'">'.$veh['VTHDesc'].'</option>';
                    }

                    $vehicleOptn = str_replace('<option value="'.$selected['CarCategory'].'">', '<option value="'.$selected['CarCategory'].'" selected="selected">', $vehicleOptn);
                    ?>
                    <div>
                        <div class="white-bg">
                            <div class="show-vehicles">
                            <form method="GET" action = "{{url('/price_estimation')}}">
                                <div class="show-vehicles-individual-wrap">
                                    <label><img src="{{url('/')}}/images/map-icon.png" align="absmiddle" />Pickup Location</label>
                                    <select name="PickupLocation" required>
                                        <option value="">Select Pickup Location</option>
                                        {!! isset($input_data['PickupLocation']) ? str_replace('<option value="'.$input_data['PickupLocation'].'">', '<option value="'.$input_data['PickupLocation'].'" selected="selected">', $branchOptn) : $branchOptn !!}
                                    </select>
                                    <label><img src="{{url('/')}}/images/map-icon.png" align="absmiddle" />Drop Location</label>
                                    <select name="DropLocation" required>
                                        <option value="">Select Drop Location</option>
                                        {!! isset($input_data['DropLocation']) ? str_replace('<option value="'.$input_data['DropLocation'].'">', '<option value="'.$input_data['DropLocation'].'" selected="selected">', $branchOptn) : $branchOptn !!}
                                    </select>
                                </div>
                                <div class="show-vehicles-individual-wrap">
                                    <label><img src="{{url('/')}}/images/time-icon.png" align="absmiddle" />Pickup Time</label>
                                    <input type="text" placeholder="Select Pickup Time" id="datetimepicker1" required readonly/>
                                    <input type="hidden" name="PickupDate" id="out_date" value="{{ $input_data['PickupDate'] ?? '' }}" />
                                    <input type="hidden" name="PickupTime" id="out_time" value="{{ $input_data['PickupTime'] ?? '' }}" />
                                    <label><img src="{{url('/')}}/images/time-icon.png" align="absmiddle" />Drop Time</label>
                                    <input type="text" placeholder="Select Drop Time" id="datetimepicker2" required readonly value="{{ isset($input_data['DropDate']) ? $input_data['DropDate'].' '.$input_data['DropTime'] : '' }}"/>
                                    <input type="hidden" name="DropDate" id="in_date" value="{{ $input_data['DropDate'] ?? '' }}"/>
                                    <input type="hidden" name="DropTime" id="in_time" value="{{ $input_data['DropTime'] ?? '' }}"/>
                                    <input type="hidden" name="CarGroup" value="{{$selected['CarGroup']}}" />
                                </div>
                                <div class="show-vehicles-individual-wrap">
                                    <label><img src="{{url('/')}}/images/car-icon.png" align="absmiddle" />Select Car Category</label>
                                    <select name="CarCategory" required>
                                        <option value="">Select Car Category</option>
                                        {!! $vehicleOptn !!}
                                    </select>

                                </div>
                                <div class="show-vehicles-individual-wrap">
                                    <label>&nbsp;</label>
                                    <input type="submit" Value="Show Vehicles" />

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
        @if (empty($input_data))
            var currentdate = new Date();
            var latedate = (currentdate.getDate()+2) + "/" + ((currentdate.getMonth()+1) < 10 ? '0'+(currentdate.getMonth()+1) : (currentdate.getMonth()+1) ) + "/" + currentdate.getFullYear();
            var ctime = "00:00";
            $('#out_date, #in_date').val(latedate);
            $('#out_time, #in_time').val(ctime);
        @endif
        $('#datetimepicker1').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            timePickerIncrement:5,
            minDate:moment().startOf('d') .add(2, 'days'),
            {!! isset($input_data['PickupDate']) ? 'startDate: "'.$input_data['PickupDate'].' '.convert24hrto12hr($input_data['PickupTime']).'",' : '' !!}
            locale: {
                format: 'DD/MM/YYYY hh:mm A'
            }
        }, function(start, end, label) {
            var out_date = start.format('DD/MM/YYYY');
            var out_time = start.format('HH:mm');
            $('#out_date').val(out_date);
            $('#out_time').val(out_time);
            $('#in_date').val(out_date);
            $('#in_time').val(out_time);
            console.log(start)

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
                var in_time = start.format('HH:mm');
                $('#in_date').val(in_date);
                $('#in_time').val(in_time);
            });
        });

        $('#datetimepicker2').daterangepicker({
            minDate: moment().startOf('d') .add(2, 'days'),
            singleDatePicker: true,
            timePicker: true,
            timePickerIncrement:5,
            locale: {
              format: 'DD/MM/YYYY hh:mm A'
            }
        }, function(start, end, label) {
            var in_date = start.format('DD/MM/YYYY');
            var in_time = start.format('HH:mm');
            $('#in_date').val(in_date);
            $('#in_time').val(in_time);
        });
    });
</script>
@stop
