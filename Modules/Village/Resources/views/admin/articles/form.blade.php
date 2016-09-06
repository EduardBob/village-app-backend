@extends($admin->getView('form', 'admin'))


@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('custom/css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('custom/js/chosen/chosen.min.css') }}">
    <style>
      .chosen-container .chosen-drop,
      .chosen-container-active .chosen-drop,
      .chosen-container.chosen-with-drop .chosen-drop{
            top: 113px;
            width: 80%;
            left: 10px;
            border: none;
      }
        .cke_toolgroup .cke_button__abbr_icon{
            background: url("/custom/images/box.png");
        }
      .chosen-container-single .chosen-drop{
          display: none;
      }
        .chosen-container-single.chosen-container-active .chosen-drop{
            display:  inline;
        }
    </style>
@stop
@section('scripts')
   @parent
   <script type="text/javascript" src={{ URL::asset('custom/js/moment.min.js') }}></script>
   <script type="text/javascript" src={{ URL::asset('custom/js/bootstrap-datetimepicker.min.js') }}></script>
   <script type="text/javascript" src={{ URL::asset('custom/js/chosen/chosen.jquery.min.js') }}></script>
   <script>
       $( document ).ready(function() {
           $('.js-date-time-field').datetimepicker({
               minDate: new Date(),
               useCurrent: false,
               sideBySide: true,
               format: 'DD-MM-YYYY HH:mm',
               locale: '{{App::getLocale()}}',
           });
           // CKEDITOR dynamic plugin.
           CKEDITOR.replace( 'text', {
               extraPlugins: 'abbr',
           });
           CKEDITOR.plugins.add( 'abbr', {
               icons: '/custom/images/box.png',
               init: function( editor ) {
                   editor.addCommand( 'abbr', new CKEDITOR.dialogCommand( 'abbrDialog' ) );
                   editor.ui.addButton( 'Abbr', {
                       label: '{{$admin->trans('popup.title')}}',
                       command: 'abbr',
                       toolbar: 'insert'
                   });
               }
           });
            var villageHtml = '';
            @if($currentUser && $currentUser->inRole('admin'))
               villageHtml = '{{$admin->trans('popup.village')}}: <select id="villages">';
               villageHtml += '<option>{{$admin->trans('popup.village_chose')}}</option>';
               @foreach (\Modules\Village\Entities\Village::all()->sortBy('title') as $village)
                villageHtml += '<option value="{{$village->id}}">{{$village->name}}</option>';
               @endforeach
               villageHtml +='</select>';
            @endif

           var selectHtml;
           selectHtml = '<select id="services-products"></select>';

           CKEDITOR.dialog.add( 'abbrDialog', function( editor ) {
               return {
                   title: '{{$admin->trans('popup.title')}}',
                   minWidth: 400,
                   minHeight: 200,
                   contents: [
                       {
                           id: 'tab-basic',
                           label: 'Basic Settings',
                           elements: [
                               {
                                   type: 'html',
                                   html: villageHtml
                               },
                               {
                                   type: 'html',
                                   html: selectHtml
                               }
                           ]
                       },
                   ],
                   onOk: function() {
                       editor.insertHtml($('#services-products').val());
                   }
               };
           });

           CKEDITOR.on('dialogDefinition', function (e) {
               var dialog = e.data.definition.dialog;
               dialog.on('show', function () {
                   @if($currentUser && $currentUser->inRole('admin'))
                       if($('select#village_id').val() > 0){
                           $('#villages').val($('select#village_id').val());
                           getProductAndServices($('select#villages').val());
                       }
                       $('#villages').on('change', function (e) {
                           var villageId = $("option:selected", this).val();
                           getProductAndServices(villageId);
                       });
                   @else
                      getProductAndServices({{$currentUser->village->id}});
                   @endif
               });
           });
           function getProductAndServices(villageId) {
               var $popupSelect = $('#services-products');
               $popupSelect.html('');
               $popupSelect.chosen('destroy');
               $.getJSON("/backend/village/services/get-choices-by-village/" + villageId, function (data) {
                   $popupSelect.append('<optgroup id="services-group" label="{{$admin->trans('popup.services')}}"></optgroup>');
                   for (var key in data) {
                       var optionHtml ='<option value=" %%' + data[key] + '^service^' + key + '%% ">' + data[key] + '</option>';
                       $popupSelect.find('#services-group').append(optionHtml);
                   }
                   $.getJSON("/backend/village/products/get-choices-by-village/" + villageId, function (data) {
                       $popupSelect.append('<optgroup id="products-group" label="{{$admin->trans('popup.products')}}"></optgroup>');
                       for (var key in data) {
                           var optionHtml ='<option value=" %%' + data[key] + '^product^' + key + '%% ">' + data[key] + '</option>';
                           $popupSelect.find('#products-group').append(optionHtml);
                       }
                       $popupSelect.chosen();
                       $('#services-products').on('change', function(event, params) {
                           $(this).next().removeClass('chosen-container-active');
                       });
                   });
               });
           }
       });
   </script>
@stop