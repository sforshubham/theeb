@extends('layouts.default')
@section('content')

<!-- Trigger/Open The Modal -->
<button id="myBtn">Open Modal</button>

<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div>
            <div class="white-bg">
                <div class="show-vehicles">
                <form method="GET" action = "{{url('/modify_reservation')}}">
                    <div class="show-vehicles-individual-wrap">
                        <label><img src="{{url('/')}}/images/map-icon.png" align="absmiddle" />Pickup Location</label>
                        <select name="PickupLocation" required>
                            <option value="">Select Pickup Location</option>
                        </select>
                        <label><img src="{{url('/')}}/images/map-icon.png" align="absmiddle" />Drop Location</label>
                        <select name="DropLocation" required>
                            <option value="">Select Drop Location</option>
                        </select>
                    </div>
                    <div class="show-vehicles-individual-wrap">
                        <label><img src="{{url('/')}}/images/time-icon.png" align="absmiddle" />Pickup Time</label>
                        <input type="text" placeholder="Select Pickup Time" id="datetimepicker1" required readonly/>
                        <input type="hidden" name="PickupDate" id="out_date"/>
                        <input type="hidden" name="PickupTime" id="out_time"/>
                        <label><img src="{{url('/')}}/images/time-icon.png" align="absmiddle" />Drop Time</label>
                        <input type="text" placeholder="Select Drop Time" id="datetimepicker2" required readonly/>
                        <input type="hidden" name="DropDate" id="in_date"/>
                        <input type="hidden" name="DropTime" id="in_time"/>
                        <input type="hidden" name="CarGroup" value="" />
                    </div>
                    <div class="show-vehicles-individual-wrap">
                        <label><img src="{{url('/')}}/images/car-icon.png" align="absmiddle" />Select Car Category</label>
                        <select name="CarCategory" required>
                            <option value="">Select Car Category</option>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    var modal = document.getElementById('myModal');
    var btn = document.getElementById("myBtn");
    var close_span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
        jQuery('body').css({'overflow-y': 'hidden'});
    }

    close_span.onclick = function() {
        jQuery('body').css({'overflow-y': ''});
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            jQuery('body').css({'overflow-y': ''});
            modal.style.display = "none";
        }
    }

    $(function() {
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

            console.log(in_date+'  '+in_date);
        });
    });
</script>

@stop