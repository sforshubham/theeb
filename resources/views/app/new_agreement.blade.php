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
                                <input type="text" readonly="readonly" placeholder="{{ __('Filter by date range') }}" id="daterangepicker" />
                            </div>
                            @if (isset($result->Agreements) && isset($result->Agreements->Agreement))
                                @if (is_object($result->Agreements->Agreement))
                                    @php($result->Agreements->Agreement = [$result->Agreements->Agreement])
                                @endif
                                @php($row_count = count($result->Agreements->Agreement))
                                @for ($i = 0; $i < $row_count; $i++)
                                    @php ($agreement = $result->Agreements->Agreement[$i])

                                    <div class="address-table padding-all-10 floatLeft">
                                        
                                        <span class="download_link" data-agreementno="{{ $i }}" style="color: #1269a0; cursor: pointer;">Download PDF</span>
                                        <form action="{{ url('/download_rental_history_pdf') }}" method="post" name="download_pdf_{{ $i }}">
                                            <input type="hidden" name="for" value="A">
                                            <input type="hidden" name="agreement" value="{{ json_encode($agreement) }}">
                                            <input type="hidden" name="h1" value="{{ $result->Agreements->H1 }}">
                                            <input type="hidden" name="h2" value="{{ $result->Agreements->H2 }}">
                                        </form>
                                        <div class="clearBoth"></div>
                                    </div>

                                    @include('app.single_agreement', ['agreement' => $agreement, 'h1' => $result->Agreements->H1, 'h2' => $result->Agreements->H2])
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

@stop
@include('app.daterangepicker')
@section('custom_script_new')
<script type="text/javascript">
    jQuery(function() {
        jQuery('.download_link').click(function() {
            var agreementno = jQuery(this).data('agreementno');
            jQuery('form[name="download_pdf_' + agreementno + '"]').submit();
        });
    });
</script>
@stop