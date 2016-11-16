@if(!$admin->checkLimit())
    <style>.btn-primary {display:  none}</style>
    {!! $admin->trans('messages.limit') !!}
@else
    @include($admin->getView('partials.edit-fields'))
@endif