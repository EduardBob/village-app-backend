@extends($admin->getView('form', 'admin'))


@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('custom/css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('custom/js/chosen/chosen.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('custom/css/articles.css') }}">
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src={{ URL::asset('custom/js/moment.min.js') }}></script>
    <script type="text/javascript" src={{ URL::asset('custom/js/bootstrap-datetimepicker.min.js') }}></script>
    <script type="text/javascript" src={{ URL::asset('custom/js/chosen/chosen.jquery.min.js') }}></script>
    @if($currentUser->hasAccess('village.articles.makePersonal'))
    <script>
        var users = JSON.parse('{!! json_encode((new Modules\Village\Entities\User)->getListWithRoles()) !!}');
        var usersSelected = [];
         @if(@$model->users)
        var usersSelected = JSON.parse('{!! json_encode(@$model->users()->select('user_id')->lists('user_id')) !!}');
        @endif;
        var userTemplates = '<select name="user_templates" id="user_templates">';
        userTemplates += '<option value=" Дорогой ##first_name## ##last_name##! ">Дорогой Фамилия Имя!</option>';
        userTemplates += '<option value=" Здравствуйте ##first_name## ##last_name##! ">Здравствуйте Фамилия Имя!</option>';
        userTemplates += '</select>';

        $(document).ready(function () {
            personalSwitch();
            function personalSwitch() {
                var isPersonal = $("#hidden_is_personal").val();
                if (isPersonal == 1) {
                    $('.users-holder').show();
                    fillUserSelect($("#village_id").val());
                    $('[name="is_important"]').iCheck('uncheck');
                    $('.important-switch').hide();
                    $('.cke_button__users').show();
                }
                else {
                    $('.users-holder').hide();
                    $('.users-holder #users_select').html('');
                    $('.important-switch').show();
                    $('.cke_button__users').hide();
                }
            }

            $("#village_id, #role_id").change(function (event) {
                fillUserSelect();
            });

            $("#hidden_is_personal").change(function (event) {
                personalSwitch();
            });
            function fillUserSelect() {
                villageId = $('#village_id').val();
                villageUsers = users[villageId];
                $userSelect = $('#users_select');
                var roleSelected = $('#role_id').val();
                $userSelect.html('');
                $userSelect.chosen('destroy');
                usersList = []
                for (var roles in villageUsers) {
                    var role = villageUsers[roles];
                    for (var id in role) {
                        if (
                                (!(id in usersList) && roleSelected == '') ||
                                (!(id in usersList) && roleSelected != '' && roles == roleSelected )
                        ) {
                            usersList[id] = role[id];
                        }
                    }

                }
                for (var id in usersList) {

                    $userSelect.append('<option value="' + id + '">' + usersList[id] + '</option>');
                }
                if (usersSelected.length) {
                    $userSelect.val(usersSelected);
                    usersSelected = [];
                }
                if(usersList.length > 0)
                {
                    $('.users-holder .search-field input').val('{{$admin->trans('form.to_all_users')}}');
                    $userSelect.chosen();
                }
                else{
                    $userSelect.html('<option value="">{{$admin->trans('form.no_users')}}</option>');
                }
            }

            $('.js-date-time-field').datetimepicker({
                minDate: new Date(),
                useCurrent: false,
                sideBySide: true,
                format: 'DD-MM-YYYY HH:mm',
                locale: '{{App::getLocale()}}',
            });
            $('.users-multiple-control').chosen();

            // CKEDITOR dynamic plugins add.
            CKEDITOR.replace('text', {
                extraPlugins: 'abbr,users'
            });

            CKEDITOR.plugins.add('abbr', {
                icons: '',
                init: function (editor) {
                    editor.addCommand('abbr', new CKEDITOR.dialogCommand('abbrDialog'));
                    editor.ui.addButton('Abbr', {
                        label: '{{$admin->trans('popup.title')}}',
                        command: 'abbr',
                        toolbar: 'insert'
                    });
                }
            });

            CKEDITOR.plugins.add('users', {
                icons: '',
                init: function (editor) {
                    editor.addCommand('users', new CKEDITOR.dialogCommand('usersDialog'));
                    editor.ui.addButton('users', {
                        label: '{{$admin->trans('popup.title')}}',
                        command: 'users',
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
                    villageHtml += '</select>';
                    @endif

            var selectHtml;
            selectHtml = '<select id="services-products"></select>';

            CKEDITOR.dialog.add('abbrDialog', function (editor) {
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
                    onOk: function () {
                        editor.insertHtml($('#services-products').val());
                    }
                };
            });

            CKEDITOR.on('dialogDefinition', function (e) {
                var dialog = e.data.definition.dialog;
                dialog.on('show', function () {
                    @if($currentUser && $currentUser->inRole('admin'))
                    if ($('select#village_id').val() > 0) {
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
            CKEDITOR.dialog.add('usersDialog', function (editor) {
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
                                    html: userTemplates,
                                }
                            ]
                        },
                    ],
                    onOk: function () {
                        editor.insertHtml($('#user_templates').val());
                    }
                };
            });

            function getProductAndServices(villageId) {
                var $popupSelect = $('#services-products');
                $popupSelect.html('');
                $popupSelect.chosen('destroy');
                $.getJSON("/backend/village/services/get-choices-by-village/" + villageId, function (data) {
                    $popupSelect.append('<optgroup id="services-group" label="{{$admin->trans('popup.services')}}"></optgroup>');
                    for (var key in data) {
                        var optionHtml = '<option value=" %%' + data[key] + '^service^' + key + '%% ">' + data[key] + '</option>';
                        $popupSelect.find('#services-group').append(optionHtml);
                    }
                    $.getJSON("/backend/village/products/get-choices-by-village/" + villageId, function (data) {
                        $popupSelect.append('<optgroup id="products-group" label="{{$admin->trans('popup.products')}}"></optgroup>');
                        for (var key in data) {
                            var optionHtml = '<option value=" %%' + data[key] + '^product^' + key + '%% ">' + data[key] + '</option>';
                            $popupSelect.find('#products-group').append(optionHtml);
                        }
                        $popupSelect.chosen();
                        $('#services-products').on('change', function (event, params) {
                            $(this).next().removeClass('chosen-container-active');
                        });
                    });
                });
            }
        });
    </script>
    @endif
@stop