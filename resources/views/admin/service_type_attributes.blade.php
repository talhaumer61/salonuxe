@include('admin.header', ['site_title' => 'Service Type Attributes | Salonuxe'])

@if ($action == "add")
    @include('admin.service_type_attributes.add')
@elseif ($action == "edit" && isset($attribute))
    @include('admin.service_type_attributes.edit')
@else
    @include('admin.service_type_attributes.list')
@endif

@include('admin.footer')
