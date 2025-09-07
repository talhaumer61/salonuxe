<header class="page-header">
    <h2>Jobs</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs pe-2">
            <li>
                <a href="/admin">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Jobs</span></li>
            <li><span>List</span></li>
        </ol>
    </div>
</header>
<div class="row">
    <div class="col">
        <div class="card card-modern">
            <div class="card-body">
                @if ($salon)
                    <div class="datatables-header-footer-wrapper mt-2">
                        <div class="datatable-header">
                            <div class="row align-items-center mb-3">
                                <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                    <a href="/jobs/add" class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">+ Add Job</a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            @if(isset($jobs) && $jobs->count() > 0)
                                <table class="table table-ecommerce-simple table-striped mb-0 dataTable no-footer" style="min-width: 550px;">
                                    <thead>
                                        <tr>
                                            <th width="8%">Sr.</th>
                                            <th width="30%">Title</th>
                                            <th width="15%">Attachment</th>
                                            <th width="12%">Status</th>
                                            <th class="text-center" width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $serial = 1; @endphp
                                        @foreach($jobs as $job)
                                            <tr>
                                                <td><strong>{{ $serial++ }}</strong></td>
                                                <td><strong>{{ $job->job_title }}</strong></td>
                                                <td>
                                                    @if($job->job_file)
                                                        <a href="{{ asset($job->job_file) }}" target="_blank" class="btn btn-sm btn-info">View File</a>
                                                    @else
                                                        <span class="text-muted">No File</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {!! $job->job_status == 1 
                                                        ? '<span class="badge bg-success">Open</span>' 
                                                        : '<span class="badge bg-danger">Closed</span>' !!}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('salon.jobs', ['action' => 'edit', 'href' => $job->job_href]) }}" class="btn btn-sm btn-warning">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" onclick="confirmDelete('salon_jobs', {{ $job->job_id }}, 'job_id');" class="btn btn-sm btn-danger">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                    @if(DB::table('job_applications')->where('job_id', $job->job_id)->exists())
                                                        <a href="{{ route('salon.jobs', ['action' => 'applications', 'href' => $job->job_href]) }}" 
                                                        class="btn btn-sm btn-info">
                                                        <i class="fa-solid fa-users"></i> Applications
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-3 text-dark">
                                    {{ $jobs->links('pagination::bootstrap-5') }}
                                </div>
                            @else
                                <div class="text-center mt-5 bg-light p-3 rounded">
                                    <h4 class="text-danger fw-bold">No jobs found</h4>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center mt-5 bg-light p-3 rounded">
                        <h4 class="text-danger fw-bold">Complete Salon Profile to Access Jobs</h4>
                        <h5><a href="/salon-profile" class="text-success fw-bold">Salon Profile <i class="fa-solid fa-arrow-right"></i></a></h5>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
<!-- end: page -->
</div>