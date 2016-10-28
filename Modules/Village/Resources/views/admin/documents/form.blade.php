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
    @if($currentUser->hasAccess('village.documents.makePersonal'))
    <script>
        var users = JSON.parse('{!! json_encode((new Modules\Village\Entities\User)->getListWithRolesAndBuildings()) !!}');
        var usersSelected = [];
                @if(@$model->users)
        var usersSelected = JSON.parse('{!! json_encode(@$model->users()->select('user_id')->lists('user_id')) !!}');
        @endif;
        var buildingsSaved = [];
                @if(@$model->buildings)
        var buildingsSaved = JSON.parse('{!! json_encode(@$model->buildings()->select('building_id')->lists('building_id')) !!}');
        @endif;
        var buildingsList = JSON.parse('{!! json_encode((new Modules\Village\Entities\Building())->getListWithFacilities()) !!}');
        var userTemplates = '{{$admin->trans('popup.chose_placeholder')}}:  <select name="user_templates" id="user_templates">';
        userTemplates += '<option value=" ##first_name## ">Имя</option>';
        userTemplates += '<option value=" ##last_name## ">Фамилия</option>';
        userTemplates += '<option value=" ##facility## ">Объект</option>';
        userTemplates += '<option value=" ##address## ">Адрес</option>';
        userTemplates += '</select>';

        $(document).ready(function () {
            personalSwitch();

            function sortOptions($select) {
                var optionsList = $select.find('option');
                optionsList.sort(function (a, b) {
                    if (a.text > b.text) return 1;
                    else if (a.text < b.text) return -1;
                    else return 0
                })
                $select.empty().append(optionsList);
            }

            function personalSwitch() {
                var isPersonal = $("#hidden_is_personal").val();
                if (isPersonal == 1) {
                    $('.users-holder').show();
                    $('[name="is_important"]').iCheck('uncheck');
                    $('.important-switch').hide();
                    $('.cke_button__users').show();
                    fillUserSelect();
                }
                else {
                    $('.users-holder').hide();
                    $('.users-holder #users_select').html('');
                    $('.important-switch').show();
                    $('.cke_button__users').hide();
                }
            }

            $("#village_id, #role_id").change(function (event) {
                clearBuildings();
                fillUserSelect();
            });

            $("#buildings").change(function (event) {
                fillUserSelect();
            });

            $("#hidden_is_personal").change(function (event) {
                personalSwitch();
            });

            function clearBuildings() {
                var $buildings = $('#buildings');
                $buildings.html('');
                $buildings.chosen('destroy');
            }

            function fillUserSelect() {
                var villageId = $('#village_id').val();
                var villageUsers = [];
                villageId = parseInt(villageId);
                var villageBuildings = [];
                for (var building in buildingsList[villageId]) {
                    villageBuildings[building] = buildingsList[villageId][building];
                }
                for (var user in users[villageId]) {
                    villageUsers[user] = users[villageId][user];
                }
                var $userSelect = $('#users_select');
                var $buildingsSelect = $('#buildings');
                var roleSelected = parseInt($('#role_id').val());
                $userSelect.html('');
                $userSelect.chosen('destroy');
                var usersList = [];
                var userToBuilding = [];
                var roleToBuilding = [];
                var userToRole = [];
                // Make data arrays
                for (var role in villageUsers) {
                    role = parseInt(role);
                    var buildings = villageUsers[role];
                    for (var buildingId in buildings) {
                        buildingId = parseInt(buildingId);
                        roleToBuilding[role] = buildingId;
                        var allUsers = buildings[buildingId];
                        for (var userId in allUsers) {
                            userId = parseInt(userId);
                            userToBuilding[userId] = buildingId;
                            userToRole[userId] = role;
                            usersList[userId] = allUsers[userId];
                        }
                    }
                }
                var buildingsSelected = $buildingsSelect.val();
                for (var userId in usersList) {
                    userId = parseInt(userId);
                    // Remove users not in selected role.
                    if (roleSelected > 0 && userToRole[userId] != roleSelected) {
                        delete(usersList[userId]);
                    }
                    var userBuildingId = userToBuilding[userId].toString();
                    // Remove users not in selected buildings.
                    if (buildingsSelected && $.inArray(userBuildingId, buildingsSelected) == -1) {
                        delete(usersList[userId]);
                    }
                }
                // Fill user select.
                for (var userId in usersList) {
                    userId = parseInt(userId);
                    $userSelect.append('<option value="' + userId + '">' + usersList[userId] + '</option>');
                    buildingId = userToBuilding[userId];
                    if (buildingId > 0 && !$buildingsSelect.find('option[value="' + buildingId + '"]').length) {
                        $buildingsSelect.append('<option value="' + buildingId + '">' + villageBuildings[buildingId] + '</option>');
                    }
                }
                // Setting saved values on edit page.
                if (buildingsSaved.length) {
                    $buildingsSelect.val(buildingsSaved);
                    buildingsSaved = [];
                }
                if (usersSelected.length) {
                    $userSelect.val(usersSelected);
                    usersSelected = [];
                }
                if (usersList.length > 0) {
                    $('.users-holder #users_select_chosen input').val('{{$admin->trans('form.to_all_users')}}');
                    $('.users-holder #users_select_chosen input').val('{{$admin->trans('form.to_all_buildings')}}');
                    sortOptions($buildingsSelect);
                    sortOptions($userSelect);
                    $buildingsSelect.chosen();
                    $userSelect.chosen();
                }
                else {
                    $userSelect.html('<option value="">{{$admin->trans('form.no_users')}}</option>');
                    $buildingsSelect.html('<option value="">{{$admin->trans('form.no_buildings')}}</option>');
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
                        label: '{{$admin->trans('popup.title_placeholder')}}',
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
                    title: '{{$admin->trans('popup.title_placeholder')}}',
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
                    title: '{{$admin->trans('popup.chose_placeholder')}}',
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