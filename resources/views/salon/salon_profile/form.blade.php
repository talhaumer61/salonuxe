<header class="page-header">
    <h2>Salon Profile</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs pe-2">
            <li>
                <a href="/admin">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Salon Profile</span></li>
        </ol>
    </div>
</header>
<form class="ecommerce-form action-buttons-fixed" 
      action="{{ $salon ? route('update.salon') : route('add.salon') }}" 
      method="POST" enctype="multipart/form-data">
    @csrf
    @if($salon)
        @method('PUT')
    @endif
    <div class="row">
        <div class="col">
            <section class="card card-modern card-big-info">
                <div class="card-body">
                    <div class="tabs-modern row" style="min-height: 490px;">
                        <div class="col-lg-2-5 col-xl-1-5">
                            <div class="nav flex-column" id="tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" role="tab" aria-controls="general" aria-selected="true">
                                    <i class="bx bx-cog me-2"></i> General</a>
                                <a class="nav-link" id="timings-tab" data-bs-toggle="pill" data-bs-target="#timings" role="tab" aria-controls="timings" aria-selected="false">
                                    <i class="bx bx-timer me-2"></i> Timings</a>
                                <a class="nav-link" id="contact-tab" data-bs-toggle="pill" data-bs-target="#contact" role="tab" aria-controls="contact" aria-selected="false">
                                    <i class="bx bxs-contact me-2"></i> Contact
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3-5 col-xl-4-5">
                            <div class="tab-content" id="tabContent">
                                <!-- General Tab -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-4 col-xl-2 control-label text-lg-end mb-0">Salon Name</label>
                                        <div class="col-lg-8 col-xl-10">
                                            <input type="text" class="form-control form-control-modern" name="salon_name" 
                                                   value="{{ $salon->salon_name ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-4 col-xl-2 control-label text-lg-end mb-0">Address</label>
                                        <div class="col-lg-8 col-xl-10">
                                            <input type="text" class="form-control form-control-modern" name="salon_address" 
                                                   value="{{ $salon->salon_address ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-4 col-xl-2 control-label text-lg-end mb-0">City</label>
                                        <div class="col-lg-8 col-xl-10">
                                            <select class="form-control form-control-modern" name="id_city">
                                                <option value="" selected disabled>Select City</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" 
                                                            {{ isset($salon) && $salon->id_city == $city->id ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-xl-2 control-label text-lg-end pt-2 mt-1 mb-0">About</label>
                                        <div class="col-lg-8 col-xl-10">
                                            <textarea class="form-control form-control-modern" name="salon_about" rows="6">{{ $salon->salon_about ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-4 col-xl-2 control-label text-lg-end pt-2 mt-1 mb-0">Logo</label>
                                        <div class="col-lg-8 col-xl-10">
                                            <div id="dropzone-form-image" class="dropzone-modern dz-square dz-clickable dropzone initialized">
                                                <span class="dropzone-upload-message text-center">
                                                    <i class="bx bxs-cloud-upload"></i>
                                                    <h6>Drop files here or click to upload.</h6>
                                                </span>
                                                <input type="file" class="form-control" name="salon_logo" id="salon_logo" accept=".jpg, .jpeg, .png, .svg"  data-bs-original-title="" title="">
                                            </div>
                                            @if(isset($salon) && $salon->salon_logo)
                                                <img src="{{ asset( $salon->salon_logo) }}" alt="Salon Logo" class="mt-2" width="100">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Timings Tab -->
                                <div class="tab-pane fade" id="timings" role="tabpanel" aria-labelledby="timings-tab">
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-4 col-xl-2 control-label text-lg-end mb-0">Opening Time</label>
                                        <div class="col-lg-8 col-xl-10">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="far fa-clock"></i>
                                                </span>
                                                <input type="text" data-plugin-timepicker="" class="form-control form-control-modern" name="opening_time" value="{{ $salon->opening_time ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-4 col-xl-2 control-label text-lg-end mb-0">Closing Time</label>
                                        <div class="col-lg-8 col-xl-10">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="far fa-clock"></i>
                                                </span>
                                                <input type="text" type="text" data-plugin-timepicker="" class="form-control" name="closing_time" 
                                                value="{{ $salon->closing_time ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Tab -->
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-4 col-xl-2 control-label text-lg-end mb-0">Phone No</label>
                                        <div class="col-lg-8 col-xl-10">
                                            <input type="text" class="form-control form-control-modern" name="salon_phone" value="{{ $salon->salon_phone ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-4 col-xl-2 control-label text-lg-end mb-0">Email</label>
                                        <div class="col-lg-8 col-xl-10">
                                            <input type="email" class="form-control form-control-modern" name="salon_email" value="{{ $salon->salon_email ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row action-buttons">
        <div class="col-12 col-md-auto">
            <button type="submit" class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                <i class="bx bx-save text-4 me-2"></i> {{ $salon ? 'Update Salon' : 'Add Salon' }}
            </button>
        </div>
        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
            <a href="/salon-profile" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Cancel</a>
        </div>
    </div>
</form>

