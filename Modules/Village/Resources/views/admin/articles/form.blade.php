@extends($admin->getView('form', 'admin'))


@section('styles')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('custom/css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('custom/js/chosen/chosen.min.css') }}">
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
               icons: 'abbr',
               init: function( editor ) {
                   editor.addCommand( 'abbr', new CKEDITOR.dialogCommand( 'abbrDialog' ) );
                   editor.ui.addButton( 'Abbr', {
                       label: 'Insert Abbreviation',
                       command: 'abbr',
                       toolbar: 'insert'
                   });
               }
           });

            @if($currentUser && $currentUser->inRole('admin'))
             var villageID = 'all';
            @else
             var villageID = {!! $currentUser->village->id  !!};
            @endif

           var selectHtml;
           selectHtml = '<select id="services-products">';
           selectHtml += '<optgroup label="Услуги">';

           var products = [];
           $.getJSON( "/backend/village/products/get-choices-by-village/"+villageID, function( data ) {
               $.each( data, function( key, val ) {
                   products['%%'+val+':product:'+key+'%%'] = val;
                   selectHtml += '<option value="%%'+val+':service:'+key+'%%">'+val+'</option>';
                   console
               });
           });
           selectHtml +='</optgroup>';
//           var services = [];
//           $.getJSON( "/backend/village/services/get-choices-by-village/"+villageID, function( data ) {
//               $.each( data, function( key, val ) {
//                   services.push([val, '%%'+val+':service:'+key+'%%']);
//                  // selectHtml += '<option value="%%'+val+':service:'+key+'%%">'+val+'</option>';
//                   //services.push([val,key]);
//               });
//           });




//           for (var i = 0; i < products.length; i++) {
//               selectHtml += '<option value="'+products[i][1]+'">'+products[i][0]+'</option>';
//           }
           selectHtml += '</select>';

         //  console.log(selectHtml);

           CKEDITOR.dialog.add( 'abbrDialog', function( editor ) {
               return {
                   title: 'Abbreviation Properties',
                   minWidth: 400,
                   minHeight: 200,
                   contents: [
                       {
                           id: 'tab-basic',
                           label: 'Basic Settings',
                           elements: [
//                               {
//                                   // Text input field for the abbreviation text.
//                                   type: 'select',
//                                   id: 'sport',
//                                   label: 'Select your favourite sport',
//                                   items: services,
//                                   'default': 'Value',
//
//                               },
                               {
                                   type: 'html',
                                   html: selectHtml
                               }

                           ]
                       },
                   ],
                   // This method is invoked once a user clicks the OK button, confirming the dialog.
                   onOk: function() {
                       var dialog = this;
                       var abbr = editor.document.createElement( 'abbr' );
                       abbr.setAttribute( 'title', dialog.getValueOf( 'tab-basic', 'title' ) );
                       abbr.setText( dialog.getValueOf( 'tab-basic', 'abbr' ) );
                       var id = dialog.getValueOf( 'tab-adv', 'id' );
                       if ( id )
                           abbr.setAttribute( 'id', id );
                       editor.insertElement( abbr );
                   }
               };
           });

           CKEDITOR.on('dialogDefinition', function (e) {
               var dialogName = e.data.name;
               var dialog = e.data.definition.dialog;
               dialog.on('show', function () {
                   console.log( $('.cke_dialog_ui_input_select'));
                   $('#services-products').chosen();
                   console.log('dialog ' + dialogName + ' opened. The width is ' + this.getSize().width + 'px.');
               });
               dialog.on('hide', function () {
                   console.log('dialog ' + dialogName + ' closed.');
               });
           });







       });
   </script>
@stop