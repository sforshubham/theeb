@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
<div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
    <div class="safeArea">
        <div class="tabs-top">
            <a href="javascript:void();" class="my-booking-btn">My Booking</a>
            <ul class="booking_tabs">
                <li rel="ongoing" class="category_tab active"><a href="javascript:void();">Ongoing</a></li>
                <li rel="completed" class="category_tab"><a href="javascript:void();">Completed</a></li>
                <li rel="cancelled" class="category_tab"><a href="javascript:void();">Cancelled</a></li>
            </ul>
        </div>
        <div class="ongoing_div category_div">
            <div class="white-bg">
            @if (!empty($result->OnGoing->Reservation))
                @if (is_object($result->OnGoing->Reservation))
                    @php ($result->Completed->Reservation = [$result->Completed->Reservation])
                @endif
                @foreach ($result->OnGoing->Reservation as $list)
                <div class="single-car-section">
                    @if (@getimagesize($list->CarGroupImagePath))
                    <img src="{{ $list->CarGroupImagePath }}" />
                    @else
                    <img src="{{ $setting['car_img'] }}" />
                    @endif
                    <h4 class="truncate-text">{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }}</h4>
                    <div class="pickup-drop-time border-right">
                        <span><strong>Pickup Time</strong><br/>
                        {{ $list->CheckOutDate.' '.$list->CheckOutTime }}
                        </span>
                    </div>
                    <div class="pickup-drop-time">
                        <span><strong>Drop Time</strong><br/>
                        {{ $list->CheckInDate.' '.$list->CheckInTime }}
                        </span>
                    </div>
                    <div class="buttons-all">
                        <a href="javascript:void();" rel="{{ $list->InternetReservationNo }}" class="cancel-booking-btn buttons">Cancel Booking</a>
                        <a href="javascript:void();" class="extend-booking-btn buttons">Extend Booking</a>
                        <a href="javascript:void();" class="view-booking-btn buttons">View Booking</a>
                    </div>
                </div>
                @endforeach
            @endif
                <div class="clearBoth"></div>
            </div>
            <form action="cancel_reservation" method="POST" id="cancel-booking-form">
                <input type="hidden" name="ReservationNo" id="cancel_reservation_no" />
            </form>

            <div class="clearBoth"></div>
        </div>
        <div style="display:none" class="completed_div category_div">
            <div class="white-bg">
            @if (isset($result->Completed->Reservation))
                @if (is_object($result->Completed->Reservation))
                    @php ($result->Completed->Reservation = [$result->Completed->Reservation])
                @endif
                @foreach ($result->Completed->Reservation as $list)
                <div class="single-car-section">
                    @if (@getimagesize($list->CarGroupImagePath))
                    <img src="{{ $list->CarGroupImagePath }}" />
                    @else
                    <img src="{{ $setting['car_img'] }}" />
                    @endif
                    <h4 class="truncate-text">{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }}</h4>
                    <div class="pickup-drop-time border-right">
                        <span><strong>Pickup Time</strong><br/>
                        {{ $list->CheckOutDate.' '.$list->CheckOutTime }}
                        </span>
                    </div>
                    <div class="pickup-drop-time ">
                        <span><strong>Drop Time</strong><br/>
                        {{ $list->CheckInDate.' '.$list->CheckInTime }}
                        </span>
                    </div>
                    <div class="buttons-all">
                        <a href="javascript:void();" class="view-booking-btn buttons">View Booking</a>
                    </div>
                </div>
                @endforeach
            @endif
                <div class="clearBoth"></div>
            </div>

            <div class="clearBoth"></div>
        </div>
        <div style="display:none" class="cancelled_div category_div">
            <div class="white-bg">
            @if (isset($result->Cancelled->Reservation))
                @if (is_object($result->Cancelled->Reservation))
                    @php ($result->Cancelled->Reservation = [$result->Cancelled->Reservation])
                @endif
                @foreach ($result->Cancelled->Reservation as $list)
                <div class="single-car-section">
                    @if (@getimagesize($list->CarGroupImagePath))
                    <img src="{{ $list->CarGroupImagePath }}" />
                    @else
                    <img src="{{ $setting['car_img'] }}" />
                    @endif
                    <h4 class="truncate-text">{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }}</h4>
                    <div class="pickup-drop-time border-right">
                        <span><strong>Pickup Time</strong><br/>
                        {{ $list->CheckOutDate.' '.$list->CheckOutTime }}
                        </span>
                    </div>
                    <div class="pickup-drop-time ">
                        <span><strong>Drop Time</strong><br/>
                        {{ $list->CheckInDate.' '.$list->CheckInTime }}
                        </span>
                    </div>
                    <div class="buttons-all">
                        <a href="javascript:void();" class="view-booking-btn buttons">View Booking</a>
                    </div>
                </div>
                @endforeach
            @endif
                <div class="clearBoth"></div>
            </div>

            <div class="clearBoth"></div>
        </div>
    </div>

</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div>
            <div class="white-bg">
                <div class="show-vehicles">
                <form method="GET" action = "{{url('/extend_reservation')}}">
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
    var btn = $(".extend-booking-btn");
    var close_span = $(".close");

    btn.on('click', function() {
        modal.style.display = "block";
        jQuery('body').css({'overflow-y': 'hidden'});
    });

    close_span.on('click', function() {
        jQuery('body').css({'overflow-y': ''});
        modal.style.display = "none";
    });

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
<script type="text/javascript">
    $('.category_tab').on('click', function(){
        var tab_title = $(this).attr('rel');
        $('.category_tab').removeClass('active');
        $(this).addClass('active');
        $('.category_div').hide();
        $('.'+tab_title+'_div').show();
    });

    $('.cancel-booking-btn').on('click', function() {
        var isGood=confirm('Are you sure you want to cancel this booking?');
        if (!isGood) {
          return false;
        }
        var res_no = $(this).attr('rel');
        $('#cancel_reservation_no').val(res_no);
        $('#cancel-booking-form').submit();
    });
</script>
@stop