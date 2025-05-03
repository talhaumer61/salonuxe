<header class="page-header">
    <h2>Services</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Services</span></li>
            <li><span>List</span></li>
        </ol>
    </div>
</header>
<section class="card">
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered table-light mb-0" id="datatable-editable">
            <thead>
                <tr>
                    <th class="text-center">Sr.</th>
                    <th>Service Name</th>
                    <th>Category</th>
                    <th>Salon Name</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Status</th>
                    <th width="100" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $sr = ($services->currentPage() - 1) * $services->perPage() + 1; @endphp
                @forelse($services as $service)
                <tr data-item-id="{{ $service->service_id }}">
                    <td class="text-center">{{ $sr++ }}</td>
                    <td>{{ $service->service_name }}</td>
                    <td>{{ $service->category }}</td>
                    <td>{{ $service->salon_name ?? 'N/A' }}</td>
                    <td class="text-center">{{ 'Rs. '.$service->service_price ?? 'Free' }}</td>
                    <td class="text-center">
                        {!! get_service_status($service->service_status) !!}
                    </td>
                    <td class="text-center">
                        @if ($service->service_status != 1)
                            <a href="{{ route('admin.services.changeStatus', ['href' => $service->service_href, 'status' => 1]) }}" class="btn btn-success btn-xs">
                                <i class="fa-solid fa-check"></i>
                            </a>
                            @if ($service->service_status != 3)
                            <a href="{{ route('admin.services.changeStatus', ['href' => $service->service_href, 'status' => 3]) }}" class="btn btn-danger btn-xs">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            @endif
                        @endif
                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No services found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $services->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
