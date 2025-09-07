<header class="page-header">
    <h2>Applications - {{ $job->job_title }}</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs pe-2">
            <li><a href="/admin"><i class="bx bx-home-alt"></i></a></li>
            <li><span>Jobs</span></li>
            <li><span>Applications</span></li>
        </ol>
    </div>
</header>

<div class="row">
    <div class="col">
        <div class="card card-modern">
            <div class="card-body">
                @if($applications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Applicant</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Resume</th>
                                    <th>Status</th>
                                    <th>Applied On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $app)
                                    <tr>
                                        <td>{{ $app->applicant_name }}</td>
                                        <td>{{ $app->applicant_email }}</td>
                                        <td>{{ $app->applicant_phone ?? '-' }}</td>
                                        <td>
                                            @if($app->resume)
                                                <a href="{{ asset(''.$app->resume) }}" 
                                                   target="_blank" class="btn btn-sm btn-primary">View</a>
                                            @else
                                                <span class="text-muted">No File</span>
                                            @endif
                                        </td>
                                        <td>
                                            {!! $app->is_replied 
                                                ? '<span class="badge bg-success">Replied</span>' 
                                                : '<span class="badge bg-warning">Pending</span>' !!}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($app->created_at)->format('M d, Y') }}</td>
                                        <td>
                                            <!-- Response Button -->
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#responseModal{{ $app->id }}">
                                                Respond
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Response Modal -->
                                    <div class="modal fade" id="responseModal{{ $app->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form action="{{ route('applications.respond') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="application_id" value="{{ $app->id }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Respond to {{ $app->applicant_name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="response" class="form-label">Response Message</label>
                                                            <textarea name="response" class="form-control" rows="5" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Send Response</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $applications->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center mt-5 bg-light p-3 rounded">
                        <h4 class="text-danger fw-bold">No applications found</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
