@extends('village::admin.admin.edit')

@section('content-header')
    <h1>
        {{ trans('user::users.breadcrumb.edit-user') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('user::users.breadcrumb.edit-user') }}</li>
    </ol>
@stop

@section('scripts')
    @parent

<script>
$( document ).ready(function() {
    @if($currentUser->hasAccess('village.buildings.getChoicesByVillage'))
    var $village = $('#village_id');
    $village.change(function(){
        var $building = $("#building_id");
        $building.html('');
        var selectedVillageId = $village.val();
        if (selectedVillageId > 0) {
            $.get('{{ URL::route('admin.village.building.get_choices_by_village', [null, null]) }}/'+selectedVillageId+'/'+'{{ @$model->building_id }}', function(data){
                $building.html(data);
            });
        }
    });

    $village.trigger('change');
    @endif
});
</script>
@stop