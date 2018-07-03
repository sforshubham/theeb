@extends('layouts.default')
@section('content')
    <div class="bodyPageHolder">
        <div class="safeArea">
            <div class="rental-tabs-top">
                <a href="javascript:" class="rental-history-btn">{{ __('Rental History') }}</a>
                <ul>
                    <li><a href="agreement">{{ __('Rental') }}</a></li>
                    <li><a href="invoice">{{ __('Invoice') }}</a></li>
                    <li><a href="payment">{{ __('Payment') }}</a></li>
                    <li class="active"><a href="reservation">{{ __('Reservation') }}</a></li>
                </ul>
            </div>
            <div>
                <div class="white-bg">
                    <div class="from-end-date-rental">
                        <input type="text" readonly="readonly" placeholder="{{ __('Filter by date range') }}" id="daterangepicker" />
                    </div>

                    <div class="address-table"></div>
                    
                    @if (isset($result->Reservations) && isset($result->Reservations->Reservation))
                        @if (is_object($result->Reservations->Reservation))
                            @php($result->Reservations->Reservation = [$result->Reservations->Reservation])
                        @endif
                        @php($row_count = count($result->Reservations->Reservation))

                        @for ($i = 0; $i < $row_count; $i++)
                            @php ($reservation = $result->Reservations->Reservation[$i])
                            <div class="address-table border-all padding-all-10" style="margin-bottom:0">
                                <div class="floatRight mg-rt-30 theeb-logo"><img src="{{url('/images/logo.png')}}" alt="شركة ذيب لتأجير السيارات" title="شركة ذيب لتأجير السيارات"></div>
                                <div class="floatRight pd-top-15"><strong>Theeb Rent A Car Co</strong>
                                    <br>Riyadh- 11423, P.O-9551,
                                    <br/>H.O contact- 011 2780246, Customer Service - 925002345
                                    <br/> Branch : 10
                                </div>
                                <div class="clearBoth"></div>
                            </div>
                        <table cellpadding="0" cellspacing="0" width="100%" class="table-rental">
                            <tr>
                                <th colspan="3">{{ __('Reservation No') }}: {{ $reservation->ReservationNo }}</th>
                                <th colspan="1"><a href="javascript:void(0);" class="doc-download-btn" rel="{{ $reservation->ReservationNo }}">{{ __('Download Document') }}</a></th>
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
                        </table>
                        @endfor
                        <div class="clearBoth"></div>
                    @else
                        <div style="
                            color:  grey;
                            border-top: 1px grey solid;
                            padding-top: 40px;
                            margin-top: 20px;
                        ">{{ __('Record not found') }}</div>
                    @endif
                </div>
                <div class="clearBoth"></div>
            </div>
        </div>
    </div>
    <form action="document_print" method="POST" id="reservation_doc">
        <input type="hidden" name="DocumentNumber" id="reservation_number" />
    </form>
    <script type="text/javascript">
        $('.doc-download-btn').on('click', function (){
            var doc_num = $(this).attr('rel');
            if (doc_num) {
                $('#reservation_number').val(doc_num);
                $('#reservation_doc').submit();
            } else {
                return false;
            }
        });
    </script>
@stop

@include('app.daterangepicker')