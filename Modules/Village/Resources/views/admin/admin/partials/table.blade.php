<table class="data-table table table-bordered table-hover">
    <thead>
        <tr>
            @yield('table-head')
            @section('table-head-actions')
                @if($currentUser && $currentUser->hasAccess($admin->getAccess('edit')) || $currentUser->hasAccess($admin->getAccess('destroy')))
                    <th>{{ $admin->trans('table.actions') }}</th>
                @endif
            @show
        </tr>
    </thead>
    <tbody>
        @section('table-body')
        @show
    </tbody>
    <tfoot>
        @yield('table-head')
        @yield('table-head-actions')
    </tfoot>
</table>