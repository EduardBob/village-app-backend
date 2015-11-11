<style>
    h3  {
        border-bottom: 1px solid #eee;
    }
</style>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <?php foreach ($permissions as $name => $value): ?>
                @if(!isset($currentUser) || $currentUser->hasAccess("$name.*"))
                <div class="col-md-12">
                    <h3>{{ ucfirst($name) }}</h3>
                </div>
                <div class="clearfix"></div>
                <?php foreach ($value as $subPermissionTitle => $permissionActions): ?>
                    @if(!isset($currentUser) || $currentUser->hasAccess("$subPermissionTitle.*"))
                    <div class="permissionGroup">
                        <div class="col-md-8">
                            <h4 class="pull-left">{{ ucfirst($subPermissionTitle) }}</h4>
                            <p class="pull-right" style="margin-top: 10px;">
                                <a href="" class="jsSelectAllInGroup">{{ trans('user::roles.select all')}}</a> |
                                <a href="" class="jsDeselectAllInGroup">{{ trans('user::roles.deselect all')}}</a> |
                                <a href="" class="jsSwapAllInGroup">{{ trans('user::roles.swap')}}</a>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <?php foreach (array_chunk($permissionActions, ceil(count($permissionActions)/2)) as $permissionActionGroup): ?>
                            <div class="col-md-3">
                                <?php foreach ($permissionActionGroup as $permissionAction): ?>
                                    @if(!isset($currentUser) || $currentUser->hasAccess("$subPermissionTitle.$permissionAction"))
                                    <div class="checkbox">
                                        <label for="<?php echo "$subPermissionTitle.$permissionAction" ?>">
                                            <input name="permissions[<?php echo "$subPermissionTitle.$permissionAction" ?>]" type="hidden" value="false" />
                                            <input id="<?php echo "$subPermissionTitle.$permissionAction" ?>" name="permissions[<?php echo "$subPermissionTitle.$permissionAction" ?>]" type="checkbox" class="flat-blue" <?php echo $model->hasAccess("$subPermissionTitle.$permissionAction") ? 'checked' : '' ?> value="true" /> {{ ucfirst($permissionAction) }}
                                        </label>
                                    </div>
                                    @endif
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                        <div class="clearfix"></div>
                    </div>
                    @endif
                <?php endforeach; ?>
                @endif
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
    $( document ).ready(function() {
        $('.jsSelectAllInGroup').on('click',function (event) {
            event.preventDefault();
            $(this).closest('.permissionGroup').find('input[type=checkbox]').each(function (index, value) {
                $(value).iCheck('check');
            });
        });
        $('.jsDeselectAllInGroup').on('click',function (event) {
            event.preventDefault();
            $(this).closest('.permissionGroup').find('input[type=checkbox]').each(function (index, value) {
                $(value).iCheck('uncheck');
            });
        });
        $('.jsSwapAllInGroup').on('click',function (event) {
            event.preventDefault();
            $(this).closest('.permissionGroup').find('input[type=checkbox]').each(function (index, value) {
                $(value).iCheck('toggle');
            });
        });
    });
</script>
