@section('daterangepicker_script')
    <script type="text/javascript" src="{{ url('/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/daterangepicker.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/daterangepicker.css') }}" />
@stop

@section('custom_script')
    <script type="text/javascript">
        jQuery(function() {
            @if ($start_date && $end_date)
                jQuery('input#daterangepicker').val("{{ $start_date }} - {{ $end_date }}");
            @endif
            jQuery('input#daterangepicker').daterangepicker({
                autoUpdateInput: false,
                maxDate: moment().format('DD/MM/Y'),
                maxSpan: {
                    "months": 3
                },
                ranges: {
                   'Today': [moment(), moment()],
                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, function(start, end, label) {
                window.location = "?StartDate=" + start.format('DD/MM/YYYY') + "&EndDate=" + end.format('DD/MM/YYYY');
            });

            jQuery('input#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
                jQuery(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
        });
    </script>
@stop
