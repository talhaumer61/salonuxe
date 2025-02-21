@include('admin.header', ['site_title' => 'Service Types | Salonuxe'])

@if ($action == "add")
    @include('admin.service_types.add')
@elseif ($action == "edit" && isset($serviceType))
    @include('admin.service_types.edit')
@else
    @include('admin.service_types.list')
@endif

@include('admin.footer')
