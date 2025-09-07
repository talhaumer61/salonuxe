
<div class="container-fluid" style="background-color: var(--back)">
    <!-- Salon Info -->
    <div class="row mb-4 p-3">
        <div class="col-md-3">
            <img src="{{ asset($salon->salon_logo) }}" class="img-fluid rounded shadow" alt="{{ $salon->salon_name }}">
        </div>
        <div class="col-md-9">
            <h2>{{ $salon->salon_name }}</h2>
            <p><i class="fas fa-map-marker-alt"></i> {{ $salon->salon_address }}, {{ $salon->city_name }}</p>
            <p><i class="fas fa-clock"></i> {{ $salon->opening_time }} - {{ $salon->closing_time }}</p>
            <p><i class="fas fa-phone"></i> {{ $salon->salon_phone }}</p>
            <p><i class="fas fa-envelope"></i> {{ $salon->salon_email }}</p>
        </div>
    </div>

    <!-- Services -->
    <div class="container">
        <h3 class="mb-4 text-center">Services Offered</h3>
        @if($services->isNotEmpty())
            @foreach($services as $typeId => $group)
                <div class="my-4">
                    <h4 class="mb-3">{{ $group->first()->type_name }}</h4>
                    <div class="row">
                        @foreach($group as $service)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <img src="{{ asset($service->service_photo) }}" class="card-img-top" alt="{{ $service->service_name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $service->service_name }}</h5>
                                        <p class="card-text">
                                            <span class="fw-bold">Price:</span> Rs. {{ $service->service_price }}
                                        </p>
                                        <a href="/book-appointment/{{ $service->service_href }}" class="btn btn-outline-primary btn-sm">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center text-muted my-5">
                <p>No services found for this salon.</p>
            </div>
        @endif
    </div>

    <!-- Jobs -->
    <div class="container mt-5">
        <h3 class="mb-4 text-center">Job Opportunities</h3>
        @if($jobs->isNotEmpty())
            <div class="row">
                @foreach($jobs as $job)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow border-0 rounded-3">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary">{{ $job->job_title }}</h5>
                                <p class="card-text text-muted mb-2">
                                    <i class="fas fa-map-marker-alt"></i> {{ $salon->city_name }}
                                </p>
                                <p class="card-text mb-2"><span class="fw-bold">Experience:</span> {{ $job->experience ?? 'Not specified' }}</p>
                                <p class="card-text mb-2"><span class="fw-bold">Salary:</span> {{ $job->salary ?? 'Negotiable' }}</p>
                                <p class="card-text small flex-grow-1">{{ Str::limit($job->job_desc, 120) }}</p>

                                <!-- Buttons -->
                                <div class="mt-auto d-flex justify-content-between">
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#jobDetailModal{{ $job->job_id }}">View Details</button>
                                    <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#applyModal{{ $job->job_id }}">Apply Now</button>
                                </div>
                            </div>
                            <div class="card-footer text-muted small">
                                Posted on {{ \Carbon\Carbon::parse($job->date_added)->format('M d, Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Job Detail Modal -->
                    <div class="modal fade" id="jobDetailModal{{ $job->job_id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $job->job_title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Experience:</strong> {{ $job->experience ?? 'Not specified' }}</p>
                            <p><strong>Salary:</strong> {{ $job->salary ?? 'Negotiable' }}</p>
                            <p>{{ $job->job_desc }}</p>
                        </div>
                        </div>
                    </div>
                    </div>

                    <!-- Apply Modal -->
                    <div class="modal fade" id="applyModal{{ $job->job_id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                        <form action="{{ route('apply.job') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="job_id" value="{{ $job->job_id }}">

                            <div class="modal-header">
                            <h5 class="modal-title">Apply for {{ $job->job_title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="applicant_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="applicant_email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="applicant_phone" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cover Letter</label>
                                <textarea name="cover_letter" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Resume (PDF/DOC, max 2MB)</label>
                                <input type="file" name="resume" class="form-control">
                            </div>
                            </div>

                            <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit Application</button>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>

                @endforeach
            </div>
        @else
            <div class="text-center text-muted my-5">
                <p>No job opportunities available at this salon right now.</p>
            </div>
        @endif
    </div>

</div>

