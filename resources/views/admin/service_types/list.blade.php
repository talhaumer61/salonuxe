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
                                <a href="/service-types/add" class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">+ Add</a>
                            </div>
                            {{-- <div class="col-8 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                    <label class="ws-nowrap me-3 mb-0">Filter By:</label>
                                    <select class="form-control select-style-1 filter-by" name="filter-by">
                                        <option value="all" selected="">All</option>
                                        <option value="1">ID</option>
                                        <option value="2">Company Name</option>
                                        <option value="3">Slug</option>
                                        <option value="4">Parent Category</option>
                                    </select>
                                </div>
                            </div> --}}
                            {{-- <div class="col-4 col-lg-auto ps-lg-1 mb-3 mb-lg-0">
                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                    <label class="ws-nowrap me-3 mb-0">Show:</label>
                                    <select class="form-control select-style-1 results-per-page" name="results-per-page">
                                        <option value="12" selected="">12</option>
                                        <option value="24">24</option>
                                        <option value="36">36</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-auto ps-lg-1">
                                <div class="search search-style-1 search-style-1-lg mx-lg-auto">
                                    <div class="input-group">
                                        <input type="text" class="search-term form-control" name="search-term" id="search-term" placeholder="Search Category">
                                        <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div id="datatable-ecommerce-list_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row justify-content-between">
                            <div class="col-auto"></div>
                            <div class="col-auto"></div>
                        </div>
                        <div class="table-responsive">
                            @if($serviceTypes->count() > 0)
                                <table class="table table-ecommerce-simple table-striped mb-0 dataTable no-footer" id="datatable-ecommerce-list" style="min-width: 550px;">
                                    <thead>
                                        <tr>
                                            <th width="8%">Sr.</th>
                                            <th width="28%">Name</th>
                                            <th width="23%">Status</th>
                                            <th class="text-center" width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($serviceTypes as $key => $serviceType)
                                            <tr>
                                                <td><strong>{{ ($serviceTypes->currentPage() - 1) * $serviceTypes->perPage() + $loop->iteration }}</strong></td>
                                                {{-- <td><strong>{{ $serviceType->name }}</strong></td> --}}
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset( $serviceType->icon) }}" 
                                                             alt="{{ $serviceType->name }}" 
                                                             class="img-thumbnail me-2" 
                                                             >
                                                        <strong>{{ $serviceType->name }}</strong>
                                                    </div>
                                                </td>
                                                <td>{!! get_status($serviceType->status) !!}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('service_types', ['action' => 'edit', 'href' => $serviceType->href]) }}" class="btn btn-sm btn-warning"> <i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="#" onclick="confirmDelete('service_types', {{ $serviceType->id }}, 'id');" class="btn btn-sm btn-danger delete-btn"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Bootstrap 5 Pagination -->
                                <div class=" mt-3 text-dark">
                                    {{ $serviceTypes->links('pagination::bootstrap-5') }}
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