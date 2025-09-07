<header class="page-header">
    <h2>Services</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs pe-2">
            <li>
                <a href="/admin">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Services</span></li>
            <li><span>Edit</span></li>
        </ol>
    </div>
</header>
<form class="ecommerce-form action-buttons-fixed" action="/jobs/update/{{ $job->job_id }}" method="post" enctype="multipart/form-data">
    @if ($salon)
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-briefcase"></i>
                                <h2 class="card-big-info-title">Job Details</h2>
                                <p class="card-big-info-desc">Edit job title, description, and status.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                {{-- Job Title --}}
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">Title</label>
                                    <div class="col-lg-7 col-xl-10">
                                        <input type="text" class="form-control form-control-modern" name="job_title"
                                               value="{{ old('job_title', $job->job_title) }}" required>
                                    </div>
                                </div>

                                {{-- Job Status --}}
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">Status</label>
                                    <div class="col-lg-7 col-xl-10">
                                        <select name="job_status" class="form-control form-control-modern" required>
                                            <option value="1" {{ old('job_status', $job->job_status) == 1 ? 'selected' : '' }}>Open</option>
                                            <option value="2" {{ old('job_status', $job->job_status) == 2 ? 'selected' : '' }}>Closed</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Job Description --}}
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-2 control-label text-lg-end pt-2 mt-1 mb-0">Description</label>
                                    <div class="col-lg-7 col-xl-10">
                                        <textarea class="form-control form-control-modern" name="job_desc" rows="6">{{ old('job_desc', $job->job_desc) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        {{-- Job File --}}
        <div class="row mt-2">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-file"></i>
                                <h2 class="card-big-info-title">Attachment</h2>
                                <p class="card-big-info-desc">Upload a new file to replace the existing one.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <div class="col">
                                        @if($job->job_file)
                                            <div class="mb-3">
                                                <label>Current File:</label><br>
                                                <a href="{{ asset($job->job_file) }}" target="_blank" class="btn btn-sm btn-info">View Current File</a>
                                            </div>
                                        @endif
                                        <div id="dropzone-form-file" class="dropzone-modern dz-square dz-clickable dropzone initialized">
                                            <span class="dropzone-upload-message text-center">
                                                <i class="bx bxs-cloud-upload"></i>
                                                <h6>Drop new file here or click to upload.</h6>
                                            </span>
                                            <input type="file" class="form-control" name="job_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="row action-buttons">
            <div class="col-12 col-md-auto ms-md-auto mt-3 mt-md-0 ms-auto d-flex">
                <a href="{{ route('salon.jobs', 'list') }}" class="mx-1 btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                    Cancel
                </a>
                <button type="submit" class="mx-1 btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                    <i class="bx bx-save text-4 me-2"></i> Update Job
                </button>
            </div>
        </div>
    @else
        <div class="text-center mt-5 bg-light p-3 rounded">
            <h4 class="text-danger fw-bold">Complete Salon Profile to Access Jobs</h4>
            <h5><a href="/salon-profile" class="text-success fw-bold">Salon Profile <i class="fa-solid fa-arrow-right"></i></a></h5>
        </div>
    @endif
</form>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var serviceType = document.getElementById('serviceType');
    var groups = document.querySelectorAll('.service-attributes');

    function hideAllGroups(){
        groups.forEach(function(g){ g.style.display = 'none'; });
    }

    serviceType.addEventListener('change', function () {
        hideAllGroups();
        var v = this.value;
        if (!v) return;
        var el = document.getElementById('type-' + v);
        if (el) el.style.display = 'block';
    });

    // On page load, show the attributes for the selected service type
    if (serviceType.value) {
        var ev = new Event('change');
        serviceType.dispatchEvent(ev);
    }
});
</script>