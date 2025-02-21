<header class="page-header">
    <h2>Users</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs pe-2">
            <li>
                <a href="/admin">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Users</span></li>
            <li><span>List</span></li>
        </ol>
    </div>
</header>
<div class="row">
    <div class="col">
        <div class="card card-modern">
            <div class="card-body">
                <div class="datatables-header-footer-wrapper mt-2">
                    {{-- <div class="datatable-header">
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                <a href="/service-types/add" class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">+ Add</a>
                            </div>
                        </div>
                    </div> --}}
                    <div id="datatable-ecommerce-list_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row justify-content-between">
                            <div class="col-auto"></div>
                            <div class="col-auto"></div>
                        </div>
                        <div class="table-responsive">
                            @if($users->count() > 0)
                                <table class="table table-ecommerce-simple table-striped mb-0 dataTable no-footer" id="datatable-ecommerce-list" style="min-width: 550px;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="11%">Sr.</th>
                                            <th width="28%">Name</th>
                                            <th width="23%">Username</th>
                                            <th width="23%">Email</th>
                                            <th width="23%">Phone</th>
                                            <th width="12%">Status</th>
                                            {{-- <th class="text-center" width="15%">Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $key => $user)
                                            <tr>
                                                <td class="text-center"><strong>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</strong></td>
                                                
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset($user->photo ?? 'default.png') }}" 
                                                            alt="{{ $user->name }}" 
                                                            class="img-thumbnail me-2" 
                                                            style="width: 40px; height: 40px; border-radius: 50%;">
                                                        <strong>{{ $user->name }}</strong>
                                                    </div>
                                                </td>
                                
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ !empty($user->phone)?$user->phone:"N/A" }}</td>
                                                
                                                <td>{!! get_status($user->status) !!}</td>
                                                
                                                {{-- <td class="text-center">
                                                    <a href="{{ route('edit.user', $user->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" onclick="confirmDelete('users', {{ $user->id }}, 'id');" class="btn btn-sm btn-danger delete-btn">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Bootstrap 5 Pagination -->
                                <div class=" mt-3 text-dark">
                                    {{ $users->links('pagination::bootstrap-5') }}
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