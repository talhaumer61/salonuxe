<header class="page-header">
    <h2>Service Type Attributes</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs pe-2">
            <li>
                <a href="/admin">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Services</span></li>
            <li><span>Types Attributes</span></li>
        </ol>
    </div>
</header>
<div class="row">
    <div class="col">
        <div class="card card-modern">
            <div class="card-body">
                <div class="datatables-header-footer-wrapper mt-2">
                    <div class="datatable-header">
                        <div class="row align-items-center mb-3 justify-content-end">
                            <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                <a href="/service-type-attributes/add" class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">+ Add Attribute</a>
                            </div>
                        </div>
                    </div>
                    <div id="datatable-ecommerce-list_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row justify-content-between">
                            <div class="col-auto"></div>
                            <div class="col-auto"></div>
                        </div>
                        <div class="table-responsive">
                            @if($attributes->count() > 0)
                                <table class="table table-ecommerce-simple table-striped mb-0 dataTable no-footer" id="datatable-ecommerce-list" style="min-width: 550px;">
                                    <thead>
                                        <tr>
                                            <th width="5%">Sr.</th>
                                            <th width="15%">Label</th>
                                            <th width="15%">Service Type</th>
                                            <th width="15%">Input Type</th>
                                            <th width="30%">Options</th>
                                            <th width="10%">Required</th>
                                            <th class="text-center" width="10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attributes as $key => $attribute)
                                            <tr>
                                                <td><strong>{{ ($attributes->currentPage() - 1) * $attributes->perPage() + $loop->iteration }}</strong></td>
                                                <td><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->service_type_name }}</td>
                                                <td>{{ $attribute->input_type }}</td>
                                                <td>
                                                    @if(isset($attributeOptions[$attribute->id]))
                                                        @foreach($attributeOptions[$attribute->id] as $option)
                                                            <span class="badge bg-secondary">{{ $option->value }}</span>
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($attribute->is_required)
                                                        <span class="badge bg-danger">Yes</span>
                                                    @else
                                                        <span class="badge bg-success">No</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="/service-type-attributes/edit/{{ $attribute->id }}" class="btn btn-sm btn-warning"> <i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="#" onclick="confirmDelete('attributes', {{ $attribute->id }}, 'id');" class="btn btn-sm btn-danger delete-btn"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class=" mt-3 text-dark">
                                    {{ $attributes->links('pagination::bootstrap-5') }}
                                </div>
                            @else
                                <div class="text-center mt-5 bg-light p-3 rounded">
                                    <h4 class="text-danger fw-bold">No attributes found</h4>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>