@extends($admin->getView('layout'))

@section('styles')
    {!! Theme::style('css/vendor/iCheck/flat/blue.css') !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?php $admin->route('index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').each(function(){
                $(this).iCheck({
                    checkboxClass: 'icheckbox_flat-blue',
                    radioClass: 'iradio_flat-blue',
                    insert: '<input type="hidden" id="hidden_' + $(this).attr('name') + '" name="' + $(this).attr('name') + '" value="'+ ($(this).attr('checked') ? 1 : 0) +'" />'
                });
            });

            $('input[type="checkbox"]').on('ifChecked', function(){
                var $hidden = $(this).parent().find('#hidden_' + $(this).attr('name'));
                $hidden.val('1').trigger('change');
            });

            $('input[type="checkbox"]').on('ifUnchecked', function(){
                var $hidden = $(this).parent().find('#hidden_' + $(this).attr('name'));
                $hidden.val('0').trigger('change');
            });
        });
    </script>
@stop
