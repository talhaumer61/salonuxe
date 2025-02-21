<header class="page-header page-header-left-inline-breadcrumb">
    <h2 class="font-weight-bold text-6">Service Type</h2>
    <div class="right-wrapper">
        <ol class="breadcrumbs">
            <li><span>Dashboard</span></li>
            <li><span>Service Type</span></li>
            <li><span>{{ $serviceType->name }}</span></li>
        </ol>
    </div>
</header>
<!-- start: page -->
<form class="ecommerce-form action-buttons-fixed" action="{{ route('service_types.update', $serviceType->href) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')  {{-- Required for updating in Laravel --}}
    
    <div class="row">
        <div class="col">
            <section class="card card-modern card-big-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2-5 col-xl-1-5">
                            <i class="card-big-info-icon bx bx-slider"></i>
                            <h2 class="card-big-info-title">Details</h2>
                            <p class="card-big-info-desc">Add description with all details and necessary information.</p>
                        </div>
                        <div class="col-lg-3-5 col-xl-4-5">
                            <div class="form-group row align-items-center mb-3">
                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Name</label>
                                <div class="col-lg-7 col-xl-6">
                                    <input type="text" class="form-control form-control-modern" name="name" value="{{ old('name', $serviceType->name) }}" required>
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Status</label>
                                <div class="col-lg-7 col-xl-6">
                                    <select class="form-control form-control-modern" name="status">
                                        <option value="" disabled>Choose One...</option>
                                        <option value="1" {{ $serviceType->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ $serviceType->status == 2 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 col-xl-3 control-label text-lg-end pt-2 mt-1 mb-0">Description</label>
                                <div class="col-lg-7 col-xl-6">
                                    <textarea class="form-control form-control-modern" name="description" rows="6">{{ old('description', $serviceType->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col">
            <section class="card card-modern card-big-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2-5 col-xl-1-5">
                            <i class="card-big-info-icon bx bx-camera"></i>
                            <h2 class="card-big-info-title">Icon</h2>
                            <p class="card-big-info-desc">Upload type icon</p>
                        </div>
                        <div class="col-lg-3-5 col-xl-4-5">
                            <div class="form-group row align-items-center">
                                <div class="col">
                                    <div id="dropzone-form-image" class="dropzone-modern dz-square dz-clickable dropzone initialized">
                                        <span class="dropzone-upload-message text-center">
                                            <i class="bx bxs-cloud-upload"></i>
                                            <h6>Drop files here or click to upload.</h6>
                                        </span>
                                        <input type="file" class="form-control" name="icon" id="news_photo" accept=".jpg, .jpeg, .png, .svg">
                                        @if($serviceType->icon)
                                            <p class="mt-2">Current Icon: <img src="{{ asset( $serviceType->icon) }}" alt="Icon" width="50"></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    
    <div class="row action-buttons">
        <div class="col-12 col-md-auto ms-md-auto mt-3 mt-md-0 ms-auto d-flex">
            <a href="/service_types" class="mx-1 btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                Cancel
            </a>
            <button type="submit" class="mx-1 btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                <i class="bx bx-save text-4 me-2"></i> Save Changes
            </button>
        </div>
    </div>
</form>
