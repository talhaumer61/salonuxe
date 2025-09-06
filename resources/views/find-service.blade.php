@include('include.navbar', ['site_title' => 'Find a Service | Salonuxe'])
@include('include.find_service.banner')
    @include('include.find_service.form')
@if (isset($services))
    @include('include.find_service.results')
@endif
@include('include.footer')