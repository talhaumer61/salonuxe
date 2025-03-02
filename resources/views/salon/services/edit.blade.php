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
            <li><span>{{$service->service_name}}</span></li>
        </ol>
    </div>
</header>
<!-- start: page -->
<form class="ecommerce-form action-buttons-fixed" action="{{ route('salon.services.update', $service->service_href) }}" method="post" enctype="multipart/form-data">
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
                                <label class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">Name</label>
                                <div class="col-lg-7 col-xl-10">
                                    <input type="text" class="form-control form-control-modern" name="service_name" value="{{ old('service_name', $service->service_name ?? '') }}" required="">
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">Status</label>
                                <div class="col-lg-7 col-xl-10">
                                    <select class="form-control form-control-modern" name="service_status">
                                        <option value="1" {{ (isset($service) && $service->service_status == 1) ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ (isset($service) && $service->service_status == 2) ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">Type</label>
                                <div class="col-lg-7 col-xl-10">
                                    <select class="form-control form-control-modern" name="id_type">
                                        <option value="" selected>Choose One...</option>
                                        @foreach ($serviceTypes as $serviceType)
                                            <option value="{{ $serviceType->id }}" {{ (isset($service) && $service->id_type == $serviceType->id) ? 'selected' : '' }}>
                                                {{ $serviceType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row align-items-center mb-3">
                                <label class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">Price</label>
                                <div class="col-lg-7 col-xl-10">
                                    <input type="number" class="form-control form-control-modern" name="service_price" value="{{ old('service_price', $service->service_price ?? '') }}" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 col-xl-2 control-label text-lg-end pt-2 mt-1 mb-0">Description</label>
                                <div class="col-lg-7 col-xl-10">
                                    <textarea class="form-control form-control-modern" name="service_desc" rows="6">{{ old('service_desc', $service->service_desc ?? '') }}</textarea>
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
                            <h2 class="card-big-info-title">Photo</h2>
                            <p class="card-big-info-desc">Upload photo related to your serivce.</p>
                        </div>
                        <div class="col-lg-3-5 col-xl-4-5">
                            <div class="form-group row align-items-center">
                                <div class="col">
                                    <div id="dropzone-form-image" class="dropzone-modern dz-square dz-clickable dropzone initialized">
                                        <span class="dropzone-upload-message text-center">
                                            <i class="bx bxs-cloud-upload"></i>
                                            <h6>Drop files here or click to upload.</h6>
                                        </span>
                                        <input type="file" class="form-control" name="service_photo" id="news_photo" accept=".jpg, .jpeg, .png, .svg" required="" data-bs-original-title="" title="">
                                        @if(isset($service) && $service->service_photo)
                                            <img src="{{ asset($service->service_photo) }}" class="my-2" alt="Service Image" width="100">
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
        {{-- <div class="col-12 col-md-auto">
            <button type="submit" class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-loading-text="Loading...">
                <i class="bx bx-save text-4 me-2"></i> Save Category
            </button>
        </div>
        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
            <a href="ecommerce-category-list.html" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Cancel</a>
        </div> --}}
        <div class="col-12 col-md-auto ms-md-auto mt-3 mt-md-0 ms-auto d-flex">
            <a href="/services" class="mx-1 btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                {{-- <i class="bx bx-trash text-4 me-2"></i> --}}
                Cancel
            </a>
            <button type="submit" class="mx-1 btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                <i class="bx bx-save text-4 me-2"></i> Update
            </button>
        </div>
    </div>
</form>
