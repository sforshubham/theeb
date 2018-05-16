@extends('layouts.default')
@section('content')
@php ($setting = default_settings())
<div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
    <div class="safeArea">
        <div class="tabs-top">
            <a href="" class="my-booking-btn">My Booking</a>
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
                    <h4>{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }}</h4>
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
                        <a href="#" class="cancel-booking-btn buttons">Cancel Booking</a>
                        <a href="#" class="extend-booking-btn buttons">Extend Booking</a>
                        <a href="#" class="view-booking-btn buttons">View Booking</a>
                    </div>
                </div>
                @endforeach
            @endif
                <div class="clearBoth"></div>
            </div>

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
                    <h4>{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }}</h4>
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
                        <a href="#" class="cancel-booking-btn buttons">Cancel Booking</a>
                        <a href="#" class="extend-booking-btn buttons">Extend Booking</a>
                        <a href="#" class="view-booking-btn buttons">View Booking</a>
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
                    <h4>{{ $list->CarGroupDescription ? $list->CarGroupDescription : $setting['car_desc'] }}</h4>
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
                        <a href="#" class="cancel-booking-btn buttons">Cancel Booking</a>
                        <a href="#" class="extend-booking-btn buttons">Extend Booking</a>
                        <a href="#" class="view-booking-btn buttons">View Booking</a>
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
<script type="text/javascript">
    $('.category_tab').on('click', function(){
        var tab_title = $(this).attr('rel');
        $('.category_tab').removeClass('active');
        $(this).addClass('active');
        $('.category_div').hide();
        $('.'+tab_title+'_div').show();
    });
</script>
@stop