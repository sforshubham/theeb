@extends('layouts.default')
@section('content')
    <div class="bodyPageHolder">
        <div class="safeArea">
            <div class="rental-tabs-top">
                <a href="javascript:" class="rental-history-btn">{{ __('Rental History') }}</a>
                <ul>
                    <li class="active"><a href="agreement">{{ __('Rental') }}</a></li>
                    <li><a href="invoice">{{ __('Invoice') }}</a></li>
                    <li><a href="payment">{{ __('Payment') }}</a></li>
                    <li><a href="reservation">{{ __('Reservation') }}</a></li>
                </ul>
            </div>
            <div>
                <div class="white-bg">
                    <div class="from-end-date-rental">
                        <input type="text" placeholder="Filter by date range" id="daterangepicker" />
                    </div>
                    
                    @if (isset($result->Agreements) && isset($result->Agreements->Agreement))
                    
                    <div class="address-table">{{ $result->Agreements->H1 }} {{ $result->Agreements->H2 }} </div>
                    
                        @if (is_object($result->Agreements->Agreement))
                            @php($result->Agreements->Agreement = [$result->Agreements->Agreement])
                        @endif
                        @php($row_count = count($result->Agreements->Agreement))


                        <table cellpadding="0" cellspacing="0" width="100%" class="table-rental">
                        @for ($i = 0; $i < $row_count; $i++)
                                @php ($agreement = $result->Agreements->Agreement[$i])
                            <tr>
                                <th colspan="4">Agreement No. {{ $agreement->AgreementNo }}</th>
                            </tr>
                            <tr>
                            @php($j = 1)
                            @foreach ($agreement as $key => $value)
                                @if ($key == 'AgreementNo') 
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
                        ">{{ __('Record not found') }}</div>
                    @endif
                </div>
                <div class="clearBoth"></div>
            </div>
        </div>
    </div>
@stop

@include('app.daterangepicker')