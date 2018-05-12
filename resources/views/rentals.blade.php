@extends('layouts.default')
@section('content')
    <div class="bodyPageHolder" style="background: url(images/about-page-img.html) no-repeat center top;">
        <div class="safeArea">
            <div class="rental-tabs-top">
                <a href="#" class="rental-history-btn">Rental History</a>
                <ul>
                    <li class="active"><a href="#">Aggrement</a></li>
                    <li><a href="#">Invoice</a></li>
                    <li><a href="#">Payment</a></li>
                    <li><a href="#">Reservation</a></li>
                </ul>
            </div>
            <div>
                <div class="white-bg">
                    <div class="from-end-date-rental">
                        <input type="text" placeholder="From Date"/> <input type="text" placeholder="To Date"/>
                    </div>
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
                            
                            <td>{{ $key }}</td>
                            <td>{{ $value }}</td>
                            
                            @if ($j % 2 == 0)
                                </tr><tr>
                            @endif
                            @php($j++)
                        @endforeach
                        </tr>
                    @endfor
                        <tr>
                            <th colspan="4">Invoice</th>
                        </tr>
                        <tr>
                            <td>Branch</td>
                            <td>Riyadh</td>
                            <td>Contact No.</td>
                            <td>+966 2020202</td>
                        </tr>
                    </table>
                    <div class="clearBoth"></div>
                </div>
                <div class="clearBoth"></div>
            </div>
        </div>
    </div>
@stop