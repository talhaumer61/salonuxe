@include('admin.header', ['site_title' => "FAQ's | Salonuxe"])

@if ($action == "add")
    @include('admin.faqs.add')
@elseif ($action == "edit" && isset($id))
    @include('admin.faqs.edit')
@else
    @include('admin.faqs.list')
@endif

@include('admin.footer')
