@extends('layouts.default')
@section('content')
            <div class="bodyPageHolder">
                <div class="safeArea">
                    <div class="rental-tabs-top">
                        <a href="#" class="rental-history-btn">Rental History</a>
                        <ul>
                            <li class="active"><a href="#">Rental</a></li>
                            <li><a href="#">Invoice</a></li>
                            <li><a href="#">Payment</a></li>
                            <li><a href="#">Reservation</a></li>
                        </ul>
                    </div>
                    <div>
                        <div class="white-bg">
                            <div class="from-end-date-rental">
                                <input type="text" placeholder="From Date" />
                                <input type="text" placeholder="To Date" />
                            </div>
                            <div class="address-table border-all padding-all-10">
                                <div class="floatRight mg-rt-30 theeb-logo"><img src="{{url('/images/logo.png')}}" alt="شركة ذيب لتأجير السيارات" title="شركة ذيب لتأجير السيارات"></div>
                                <div class="floatRight pd-top-15"><strong>Theeb Rent A Car Co</strong>
                                    <br>Riyadh- 11423, P.O-9551,
                                    <br/>H.O contact- 011 2780246, Customer Service - 925002345
                                    <br/> Branch : 10
                                </div>
                                <div class="clearBoth"></div>
                            </div>
                            <table cellpadding="0" cellspacing="0" width="100%" class="table-rental table-invoice">
                                <tr>
                                    <th colspan="8">Agreement No.</th>
                                </tr>
                                <tr>
                                    <td>Branch</td>
                                    <td>Riyadh</td>
                                    <td>Contact No.</td>
                                    <td>+966 2020202</td>
                                    <td>Branch</td>
                                    <td>Riyadh</td>
                                    <td>Contact No.</td>
                                    <td>+966 2020202</td>
                                </tr>
                                <tr>
                                    <td>Branch</td>
                                    <td>Riyadh</td>
                                    <td>Contact No.</td>
                                    <td>+966 2020202</td>
                                    <td>Branch</td>
                                    <td>Riyadh</td>
                                    <td>Contact No.</td>
                                    <td>+966 2020202</td>
                                </tr>

                                <tr>
                                    <td>Branch</td>
                                    <td>Riyadh</td>
                                    <td>Contact No.</td>
                                    <td>+966 2020202</td>
                                    <td>Branch</td>
                                    <td>Riyadh</td>
                                    <td>Contact No.</td>
                                    <td>+966 2020202</td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0" width="100%" class="table-rental table-invoice mg-top-30">
                                <tr>
                                    <th colspan="8">Invoice</th>
                                </tr>
                                <tr>
                                    <td>Branch</td>
                                    <td>Riyadh</td>
                                    <td>Contact No.</td>
                                    <td>+966 2020202</td>
                                    <td>Branch</td>
                                    <td>Riyadh</td>
                                    <td>Contact No.</td>
                                    <td>+966 2020202</td>
                                </tr>
                                <tr>
                                    <td>Branch</td>
                                    <td>Riyadh</td>
                                    <td>Contact No.</td>
                                    <td>+966 2020202</td>
                                    <td>Branch</td>
                                    <td>Riyadh</td>
                                    <td>Contact No.</td>
                                    <td>+966 2020202</td>
                                </tr>

                                <tr>
                                    <td>Branch</td>
                                    <td>Riyadh</td>
                                    <td>Contact No.</td>
                                    <td>+966 2020202</td>
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