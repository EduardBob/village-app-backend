@extends($admin->getView('index', 'admin'))

@section('scripts')
    @parent

    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src={{ URL::asset('custom/js/jquery.dataTables.yadcf.js') }}></script>
    <script type="text/javascript">
        $(document).ready(function() {
            'use strict';

            var datepickerDefaults = {
                locale: 'ru'
            };

            yadcf.init(window.LaravelDataTables.dataTableBuilder, [
                {
                    column_number: 1,
                    filter_type: "text",
                    column_data_type: 'html',
                    filter_delay: 300
                },
                {
                    column_number: 2,
                    filter_type: "date",
                    datepicker_type: 'bootstrap-datetimepicker',
                    date_format: 'YYYY-MM-DD',
                    filter_delay: 300,
                    filter_plugin_options: datepickerDefaults
                }
            ]);
        });
    </script>
@stop
