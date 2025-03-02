@include('salon.header', ['site_title' => 'Services | Salonuxe'])

@if ($action == "add")
    @include('salon.services.add')
@elseif ($action == "edit" && isset($href))
    @include('salon.services.edit')
@else
    @include('salon.services.list')
@endif

@include('salon.footer')
