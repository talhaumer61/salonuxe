@include('salon.header', ['site_title' => 'Jobs | Salonuxe'])

@if ($action == "add")
    @include('salon.jobs.add')
@elseif ($action == "edit" && isset($href))
    @include('salon.jobs.edit')
@elseif ($action == "applications" && isset($href))
    @include('salon.jobs.applications')
@else
    @include('salon.jobs.list')
@endif

@include('salon.footer')
