<header class="page-header">
    <h2>Serivice Types</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs pe-2">
            <li>
                <a href="/admin">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Serivice Types</span></li>
            <li><span>List</span></li>
        </ol>
    </div>
</header>
<div class="row">
    <div class="col">
        <div class="card card-modern">
            <div class="card-body">
                <div class="datatables-header-footer-wrapper mt-2">
                    <div class="datatable-header">
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                <a href="/faqs/add" class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">+ Add</a>
                            </div>
                        </div>
                    </div>
                    <div id="datatable-ecommerce-list_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row justify-content-between">
                            <div class="col-auto"></div>
                            <div class="col-auto"></div>
                        </div>
                        <div class="table-responsive">
                            @if($faqs->count() > 0)
                                <table class="table table-ecommerce-simple table-striped mb-0 dataTable no-footer" id="datatable-ecommerce-list" style="min-width: 550px;">
                                    <thead>
                                        <tr>
                                            <th width="8%">Sr.</th>
                                            <th width="40%">Question</th>
                                            <th width="20%">Status</th>
                                            <th class="text-center" width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($faqs as $key => $faq)
                                            <tr>
                                                <td><strong>{{ ($faqs->currentPage() - 1) * $faqs->perPage() + $loop->iteration }}</strong></td>
                                                <td><strong>{{ $faq->question }}</strong></td>
                                                <td>{!! get_status($faq->status) !!}</td>
                                                <td class="text-center">
                                                    <a href="/faqs/edit/{{$faq->id}}" class="btn btn-sm btn-warning">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" onclick="confirmDelete(this, 'faqs', {{ $faq->id }}, 'id');" class="btn btn-sm btn-danger delete-btn">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Bootstrap 5 Pagination -->
                                <div class="mt-3 text-dark">
                                    {{ $faqs->links('pagination::bootstrap-5') }}
                                </div>
                            @else
                                <div class="text-center mt-5 bg-light p-3 rounded">
                                    <h4 class="text-danger fw-bold">No records found</h4>
                                </div>
                            @endif

                        </div>
                    </div>
                
            </div>
        </div>
    </div>
</div>
<!-- end: page -->
</div>