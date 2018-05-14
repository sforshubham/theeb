@extends('layouts.default')
@section('content')
    <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
        <div class="safeArea">
            <div class="rental-tabs-top">
                <a href="#" class="rental-history-btn">Rental History</a>
                <ul>
                    <li><a href="agreement">Aggrement</a></li>
                    <li><a href="invoice">Invoice</a></li>
                    <li><a href="payment">Payment</a></li>
                    <li class="active"><a href="reservation">Reservation</a></li>
                </ul>
            </div>
            <div>
                <div class="white-bg">
                    <div class="from-end-date-rental">
                        <input type="text" placeholder="Filter by date range" id="daterangepicker" />
                    </div>

                    <div class="address-table"></div>
                    
                    @if (isset($result->Reservations) && isset($result->Reservations->Reservation))
                        @if (is_object($result->Reservations->Reservation))
                            @php($result->Reservations->Reservation = [$result->Reservations->Reservation])
                        @endif
                        @php($row_count = count($result->Reservations->Reservation))


                        <table cellpadding="0" cellspacing="0" width="100%" class="table-rental">
                        @for ($i = 0; $i < $row_count; $i++)
                                @php ($reservation = $result->Reservations->Reservation[$i])
                            <tr>
                                <th colspan="4">Reservation No. {{ $reservation->ReservationNo }}</th>
                            </tr>
                            <tr>
                            @php($j = 1)
                            @foreach ($reservation as $key => $value)
                                @if ($key == 'ReservationNo') 
                                    @continue
                                @endif

                                <td>{{ $labels[$key] }}</td>
                                <td>{{ $value }}</td>

                                @if ($j % 2 == 0)
                                    </tr><tr>
                                @endif
                                @php($j++)
                            @endforeach
                            </tr>
                        @endfor
                        </table>
                        <div class="clearBoth"></div>
                    @else
                        <div style="
                            color:  grey;
                            border-top: 1px grey solid;
                            padding-top: 40px;
                            margin-top: 20px;
                        ">No records found...</div>
                    @endif
                </div>
                <div class="clearBoth"></div>
            </div>
        </div>
    </div>
@stop

@include('app.daterangepicker')