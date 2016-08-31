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
           $('.js-date-time-field').datetimepicker({
               minDate: new Date(),
               useCurrent: false,
               sideBySide: true,
               format: 'DD-MM-YYYY HH:mm',
               locale: 'ru',
           });
       });
   </script>
@stop