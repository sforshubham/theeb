@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
<div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
    <div class="safeArea">
        <div class="tabs-top">
            <a href="javascript:" class="my-booking-btn">{{ __('My Booking') }}</a>
            <ul class="booking_tabs">
                <li rel="ongoing" class="category_tab active"><a href="javascript:">{{ __('Ongoing') }}</a></li>
                <li rel="completed" class="category_tab"><a href="javascript:">{{ __('Completed') }}</a></li>
                <li rel="cancelled" class="category_tab"><a href="javascript:">{{ __('Cancelled') }}</a></li>
            </ul>
        </div>
        <div class="ongoing_div category_div">
            <div class="white-bg">
            @if (isset($result->OnGoing->Reservation))
                @if (is_object($result->OnGoing->Reservation))
                    @php ($result->OnGoing->Reservation = [$result->OnGoing->Reservation])
                @endif
                @foreach ($result->OnGoing->Reservation as $list)
                <div class="single-car-section">
                    <img src="{{ $list->CarGroupImagePath }}" onerror="this.src='{!!$setting['car_img']!!}'"/>
                    <h4 class="truncate-text">{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }} <span class="my-booking-reservation-no">{{ isset($list->ReservationNo) ? __('Reservation No').' :' . $list->ReservationNo : '&nbsp;' }}</span></h4><br/>

                    <div class="pickup-drop-time border-right">
                        <span><strong>{{ __('Pickup Details') }}</strong><br/>
                        {{ $list->CheckOutDate.' '.convert24hrto12hr($list->CheckOutTime) }}
                        </span>
                    </div>
                    <div class="pickup-drop-time">
                        <span><strong>{{ __('Drop Details') }}</strong><br/>
                        {{ $list->CheckInDate.' '.convert24hrto12hr($list->CheckInTime) }}
                        </span>
                    </div>
                    <div class="buttons-all" real-reservation-no="{{ $list->ReservationNo }}" reservation-no="{{ $list->InternetReservationNo }}" out-date="{{ $list->CheckOutDate }}" in-date="{{ $list->CheckInDate }}" out-time="{{$list->CheckOutTime}}" in-time="{{$list->CheckInTime}}" show-out-time="{{convert24hrto12hr($list->CheckOutTime) }}" show-in-time="{{convert24hrto12hr($list->CheckInTime)}}" out-branch-name ="{{ remove_numbers($list->CheckOutBranch) }}"  in-branch-name ="{{ remove_numbers($list->CheckInBranch) }}"  out-branch-code ="{{ remove_characters($list->CheckOutBranch) }}" in-branch-code ="{{ remove_characters($list->CheckInBranch) }}" total-paid="{{ $list->TotalPaid }}" total-before-tax="{{ $list->TotalBeforeTax }}" sales-tax="{{ $list->SalesTax }}" total-discount="{{ $list->TotalDiscount }}" total-with-tax="{{ $list->TotalWithTax }}" car-group-desc="{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }}" res-status="{{ $list->ReservationStatus == 'Clonfirmed' ? 'Confirmed' : $list->ReservationStatus }}">
                        <a href="javascript:" class="cancel-booking-btn buttons">{{ __('Cancel Booking') }}</a>
                        <a href="javascript:" class="extend-booking-btn buttons">{{ __('Extend Booking') }}</a>
                        <a href="javascript:" class="view-booking-btn buttons">{{ __('View Booking') }}</a>
                    </div>
                </div>
                @endforeach
            @else
                <div style="
                    color:  grey;
                    border-top: 1px grey solid;
                    padding-top: 40px;
                    margin-top: 20px;
                ">{{$setting['no_data']}}</div>
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
                    <img src="{{ $list->CarGroupImagePath }}" onerror="this.src='{!!$setting['car_img']!!}'"/>
                    <h4 class="truncate-text">{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }}<span class="my-booking-reservation-no">{{ isset($list->ReservationNo) ? __('Reservation No').' :' . $list->ReservationNo : '&nbsp;' }}</span></h4>
                    <div class="pickup-drop-time border-right">
                        <span><strong>{{ __('Pickup Details') }}</strong><br/>
                        {{ $list->CheckOutDate.' '.convert24hrto12hr($list->CheckOutTime) }}
                        </span>
                    </div>
                    <div class="pickup-drop-time ">
                        <span><strong>{{ __('Drop Details') }}</strong><br/>
                        {{ $list->CheckInDate.' '.convert24hrto12hr($list->CheckInTime) }}
                        </span>
                    </div>
                    <div class="buttons-all" real-reservation-no="{{ $list->ReservationNo }}" reservation-no="{{ $list->InternetReservationNo }}" out-date="{{ $list->CheckOutDate }}" in-date="{{ $list->CheckInDate }}" out-time="{{$list->CheckOutTime}}" in-time="{{$list->CheckInTime}}" show-out-time="{{convert24hrto12hr($list->CheckOutTime) }}" show-in-time="{{convert24hrto12hr($list->CheckInTime)}}" out-branch-name ="{{ remove_numbers($list->CheckOutBranch) }}"  in-branch-name ="{{ remove_numbers($list->CheckInBranch) }}"  out-branch-code ="{{ remove_characters($list->CheckOutBranch) }}" in-branch-code ="{{ remove_characters($list->CheckInBranch) }}" total-paid="{{ $list->TotalPaid }}" total-before-tax="{{ $list->TotalBeforeTax }}" sales-tax="{{ $list->SalesTax }}" total-discount="{{ $list->TotalDiscount }}" total-with-tax="{{ $list->TotalWithTax }}" car-group-desc="{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }}" res-status="{{ $list->ReservationStatus == 'Clonfirmed' ? 'Confirmed' : $list->ReservationStatus }}">
                        <a href="javascript:" class="view-booking-btn buttons">{{ __('View Booking') }}</a>
                    </div>
                </div>
                @endforeach
            @else
                <div style="
                    color:  grey;
                    border-top: 1px grey solid;
                    padding-top: 40px;
                    margin-top: 20px;
                ">{{$setting['no_data']}}</div>
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
                    <img src="{{ $list->CarGroupImagePath }}" onerror="this.src='{!!$setting['car_img']!!}'"/>
                    <h4 class="truncate-text">{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }}<span class="my-booking-reservation-no">{{ isset($list->ReservationNo) ? __('Reservation No').' :' . $list->ReservationNo : '&nbsp;' }}</span></h4>
                    <div class="pickup-drop-time border-right">
                        <span><strong>{{ __('Pickup Details') }}</strong><br/>
                        {{ $list->CheckOutDate.' '.convert24hrto12hr($list->CheckOutTime) }}
                        </span>
                    </div>
                    <div class="pickup-drop-time ">
                        <span><strong>{{ __('Drop Details') }}</strong><br/>
                        {{ $list->CheckInDate.' '.convert24hrto12hr($list->CheckInTime) }}
                        </span>
                    </div>
                    <div class="buttons-all" real-reservation-no="{{ $list->ReservationNo }}" reservation-no="{{ $list->InternetReservationNo }}" out-date="{{ $list->CheckOutDate }}" in-date="{{ $list->CheckInDate }}" out-time="{{$list->CheckOutTime}}" in-time="{{$list->CheckInTime}}" show-out-time="{{convert24hrto12hr($list->CheckOutTime) }}" show-in-time="{{convert24hrto12hr($list->CheckInTime)}}" out-branch-name ="{{ remove_numbers($list->CheckOutBranch) }}"  in-branch-name ="{{ remove_numbers($list->CheckInBranch) }}"  out-branch-code ="{{ remove_characters($list->CheckOutBranch) }}" in-branch-code ="{{ remove_characters($list->CheckInBranch) }}" total-paid="{{ $list->TotalPaid }}" total-before-tax="{{ $list->TotalBeforeTax }}" sales-tax="{{ $list->SalesTax }}" total-discount="{{ $list->TotalDiscount }}" total-with-tax="{{ $list->TotalWithTax }}" car-group-desc="{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }}" res-status="{{ $list->ReservationStatus == 'Clonfirmed' ? 'Confirmed' : $list->ReservationStatus }}">
                        <a href="javascript:" class="view-booking-btn buttons">{{ __('View Booking') }}</a>
                    </div>
                </div>
                @endforeach
            @else
                <div style="
                    color:  grey;
                    border-top: 1px grey solid;
                    padding-top: 40px;
                    margin-top: 20px;
                ">{{$setting['no_data']}}</div>
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
        <span rel="myModal" class="close">&times;</span>
        <div>
            <div class="white-bg">
                <div class="show-vehicles">
                    <form method="POST" id="extend-res-form" action = "{{url('/modify_reservation')}}">
                        <div class="show-vehicles-individual-wrap">
                            <label><img src="{{url('/')}}/images/map-icon.png" align="absmiddle" />Pickup Location</label>
                            <select name="OutBranch" required>
                                <option value="">Select Pickup Location</option>
                            </select>
                            <label><img src="{{url('/')}}/images/map-icon.png" align="absmiddle" />Drop Location</label>
                            <select name="InBranch" required>
                                <option value="">Select Drop Location</option>
                            </select>
                        </div>
                        <div class="show-vehicles-individual-wrap">
                            <label><img src="{{url('/')}}/images/time-icon.png" align="absmiddle" />Pickup Time</label>
                            <input type="text" placeholder="Select Pickup Time" id="datetimepicker1" required readonly/>
                            <input type="hidden" name="OutDate" id="out_date"/>
                            <input type="hidden" name="OutTime" id="out_time"/>
                            <label><img src="{{url('/')}}/images/time-icon.png" align="absmiddle" />Drop Time</label>
                            <input type="text" placeholder="Select Drop Time" id="datetimepicker2" required readonly/>
                            <input type="hidden" name="InDate" id="in_date"/>
                            <input type="hidden" name="InTime" id="in_time"/>
                            <input type="hidden" name="ReservationNo" id="reservation_no"/>
                        </div>
                        <div class="show-vehicles-individual-wrap">
                            <label>&nbsp;</label>
                            <input type="submit" Value="Extend Booking" />

                        </div>
                    </form>
                </div>
                <div class="clearBoth"></div>
            </div>

            <div class="clearBoth"></div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="myModal2" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span rel ="myModal2" class="close">&times;</span>
        <div>
            <div class="white-bg">
                <div class="show-vehicles">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table-rental">
                       <tbody>
                          <tr>
                             <th id="t_reservation_no" colspan="4"></th>
                          </tr>
                          <tr>
                             <td>Pickup Branch</td>
                             <td id ="t_pickup_branch"></td>
                             <td>Drop Branch</td>
                             <td id ="t_drop_branch"></td>
                          </tr>
                          <tr>
                             <td>Pickup Time</td>
                             <td id ="t_pickup_time"></td>
                             <td>Drop Time</td>
                             <td id ="t_drop_time"></td>
                          </tr>
                          <tr>
                             <td>Car Description</td>
                             <td id ="t_car_desc"></td>
                             <td>Current Status</td>
                             <td id ="t_res_status"></td>
                          </tr>
                          <tr>
                             <td>Total With Tax</td>
                             <td id ="t_with_tax"></td>
                             <td>Total Before Tax</td>
                             <td id ="t_before_tax"></td>
                          </tr>
                          <tr>
                             <td>Sales Tax</td>
                             <td id ="t_sales_tax"></td>
                             <td>Total Discount</td>
                             <td id ="t_tot_disc"></td>
                          </tr>
                          <tr>
                             <td>Total Paid</td>
                             <td id ="t_total_paid"></td>
                             <td>Net Payable</td>
                             <td id ="t_net_payable"></td>
                          </tr>
                       </tbody>
                    </table>
                </div>
                <div class="clearBoth"></div>
            </div>

            <div class="clearBoth"></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ url('/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/daterangepicker.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ url('/css/daterangepicker.css') }}" />
<script>
    var modal = document.getElementById('myModal');
    var modal2 = document.getElementById('myModal2');
    var currency = "{{ env('APP_CURRENCY') }}";

    $(".view-booking-btn").on('click', function() {
        var selector = $(this).parent('.buttons-all');

        var out_date = selector.attr('out-date');
        var in_date = selector.attr('in-date');
        var show_out_time = selector.attr('show-out-time');
        var show_in_time = selector.attr('show-in-time');

        var t_pickup_time = out_date+' '+show_out_time ;
        var t_drop_time = in_date+' '+show_in_time ;
        var t_pickup_branch = selector.attr('out-branch-name');
        var t_drop_branch = selector.attr('in-branch-name');
        var t_car_desc = selector.attr('car-group-desc');
        var t_reservation_no = selector.attr('real-reservation-no');
        var t_total_paid = selector.attr('total-paid');
        var t_before_tax  = selector.attr('total-before-tax');
        var t_sales_tax = selector.attr('sales-tax');
        var t_tot_disc = selector.attr('total-discount');
        var t_with_tax = selector.attr('total-with-tax');
        var t_res_status = selector.attr('res-status');
        var t_net_payable = parseFloat(t_with_tax) - parseFloat(t_total_paid);

        var thead = 'Reservation No.: '+t_reservation_no;
        $('#t_reservation_no').html(thead);
        $('#t_pickup_branch').html(t_pickup_branch);
        $('#t_drop_branch').html(t_drop_branch);
        $('#t_pickup_time').html(t_pickup_time);
        $('#t_drop_time').html(t_drop_time);
        $('#t_car_desc').html(t_car_desc);
        $('#t_res_status').html(t_res_status);
        $('#t_with_tax').html(t_with_tax);
        $('#t_before_tax').html(t_before_tax);
        $('#t_sales_tax').html(t_sales_tax);
        $('#t_tot_disc').html(t_tot_disc);
        $('#t_total_paid').html(t_total_paid);
        $('#t_net_payable').html(t_net_payable.toFixed(2));

        modal2.style.display = "block";
        jQuery('body').css({'overflow-y': 'hidden'});
    });

    $(".extend-booking-btn").on('click', function() {
        var selector = $(this).parent('.buttons-all');
        var out_date = selector.attr('out-date');
        var in_date = selector.attr('in-date');
        var out_time = selector.attr('out-time');
        var in_time = selector.attr('in-time');
        var show_out_time = selector.attr('show-out-time');
        var show_in_time = selector.attr('show-in-time');
        var out_branch_name = selector.attr('out-branch-name');
        var out_branch_code = selector.attr('out-branch-code');
        var in_branch_name = selector.attr('in-branch-name');
        var in_branch_code = selector.attr('in-branch-code');
        var reservation_no = selector.attr('reservation-no');


        $('select[name="OutBranch"]').html('<option value="'+out_branch_code+'">'+out_branch_name+'</option>');
        $('select[name="InBranch"]').html('<option value="'+in_branch_code+'">'+in_branch_name+'</option>');
        $('#datetimepicker1').val(out_date+' '+show_out_time);
        $('#out_date').val(out_date);
        $('#out_time').val(out_time);
        $('#datetimepicker2').val(in_date+' '+show_in_time);
        $('#in_date').val(in_date);
        $('#in_time').val(in_time);
        $('#reservation_no').val(reservation_no);

        $('#datetimepicker2').daterangepicker({
            minDate: in_date,
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
        modal.style.display = "block";
        jQuery('body').css({'overflow-y': 'hidden'});
    });

    $(".close").on('click', function() {
        var modal_id = $(this).attr('rel');
        jQuery('body').css({'overflow-y': ''});
        $('#'+modal_id).css({'display':'none'})
    });

    window.onclick = function(event) {
        jQuery('body').css({'overflow-y': ''});
        if (event.target == modal) {
            modal.style.display = "none";
        } else if (event.target == modal2) {
            modal2.style.display = "none";
        }
    }
</script>
<script type="text/javascript">
    $('.category_tab').on('click', function() {
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
        var res_no = $(this).parent('.buttons-all').attr('reservation-no');
        $('#cancel_reservation_no').val(res_no);
        $('#cancel-booking-form').submit();
    });
</script>
@stop