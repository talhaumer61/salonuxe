@include('include.navbar', ['site_title' => 'Salons | Salonuxe'])

@if(isset($href) && $href)
    {{-- Show single salon detail --}}
    @include('include.salons.name')     {{-- e.g., for salon name, image, contact --}}
    @include('include.salons.detail')   {{-- e.g., services of that salon --}}
@else
    {{-- Show all salons --}}
    @include('include.salons.banner')
    @include('include.salons.list')
@endif

@include('include.footer')
