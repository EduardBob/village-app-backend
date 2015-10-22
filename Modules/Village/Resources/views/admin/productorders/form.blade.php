@extends($admin->getView('form', 'admin'))

@section('styles')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('custom/css/bootstrap-datetimepicker.css') }}">
@stop

@section('scripts')
    @parent

    <script type="text/javascript" src={{ URL::asset('custom/js/moment.min.js') }}></script>
    <script type="text/javascript" src={{ URL::asset('custom/js/bootstrap-datetimepicker.min.js') }}></script>

    <script>
        $( document ).ready(function() {
            $('.js-date-field').datetimepicker({
//                minDate: new Date(),
                format: 'YYYY-MM-DD HH:mm'
            });
        });
    </script>
@stop