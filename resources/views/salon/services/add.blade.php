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
            <li><span>Add</span></li>
        </ol>
    </div>
</header>
<!-- start: page -->
<form class="ecommerce-form action-buttons-fixed" action="{{ route('salon.services.add') }}" method="post" enctype="multipart/form-data">
    @if ($salon)
        @csrf
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
                                        <input type="text" class="form-control form-control-modern" name="service_name" value="" required="">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="serviceType" class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">Service Type</label>
                                    <div class="col-lg-7 col-xl-10">
                                        <select name="service_type_id" id="serviceType" class="form-control form-control-modern" required>
                                            <option value="">-- Select Service Type --</option>
                                            @foreach($serviceTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Attributes grouped by service type -->
                                @foreach($attributes as $serviceTypeId => $attrGroup)
                                    <div id="type-{{ $serviceTypeId }}" class="service-attributes" style="display:none;">
                                        {{-- <h6 class="mb-3">{{ $serviceTypes->firstWhere('id', $serviceTypeId)->name ?? 'Attributes' }}</h6> --}}

                                        @foreach($attrGroup as $attr)
                                            <div class="form-group row align-items-center mb-3">
                                                <label class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">{{ $attr->label }}</label>
                                                <div class="col-lg-7 col-xl-10">
                                                    @php
                                                        $singleTypes = ['select','single','radio'];
                                                        $multiTypes  = ['multiselect','multiple','checkbox'];
                                                    @endphp

                                                    @if(in_array($attr->input_type, $singleTypes))
                                                        @foreach($attr->options as $opt)
                                                            <div class="form-check">
                                                                <input class="form-check-input" 
                                                                    type="radio" 
                                                                    name="attributes[{{ $attr->id }}]" 
                                                                    id="attr-{{ $attr->id }}-opt-{{ $opt->id }}" 
                                                                    value="{{ $opt->id }}" 
                                                                    {{ $attr->is_required ? 'required' : '' }}>
                                                                <label class="form-check-label" for="attr-{{ $attr->id }}-opt-{{ $opt->id }}">{{ $opt->value }}</label>
                                                            </div>
                                                        @endforeach
                                                    @elseif(in_array($attr->input_type, $multiTypes))
                                                        @foreach($attr->options as $opt)
                                                            <div class="form-check">
                                                                <input class="form-check-input" 
                                                                    type="checkbox" 
                                                                    name="attributes[{{ $attr->id }}][]" 
                                                                    id="attr-{{ $attr->id }}-opt-{{ $opt->id }}" 
                                                                    value="{{ $opt->id }}">
                                                                <label class="form-check-label" for="attr-{{ $attr->id }}-opt-{{ $opt->id }}">{{ $opt->value }}</label>
                                                            </div>
                                                        @endforeach
                                                    @elseif(in_array($attr->input_type, ['text','number']))
                                                        <input type="{{ $attr->input_type }}" 
                                                            class="form-control form-control-modern" 
                                                            name="attributes[{{ $attr->id }}]" 
                                                            {{ $attr->is_required ? 'required' : '' }}>
                                                    @else
                                                        @foreach($attr->options as $opt)
                                                            <div class="form-check">
                                                                <input class="form-check-input" 
                                                                    type="checkbox" 
                                                                    name="attributes[{{ $attr->id }}][]" 
                                                                    value="{{ $opt->id }}">
                                                                <label class="form-check-label">{{ $opt->value }}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach

                                {{-- <div id="attributes-container"></div> --}}
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">Price</label>
                                    <div class="col-lg-7 col-xl-10">
                                        <input type="number" class="form-control form-control-modern" name="service_price" value="" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-2 control-label text-lg-end pt-2 mt-1 mb-0">Description</label>
                                    <div class="col-lg-7 col-xl-10">
                                        <textarea class="form-control form-control-modern" name="service_desc" rows="6"></textarea>
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
                <a href="/service-types" class="mx-1 btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                    {{-- <i class="bx bx-trash text-4 me-2"></i> --}}
                    Cancel
                </a>
                <button type="submit" class="mx-1 btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                    <i class="bx bx-save text-4 me-2"></i> Add
                </button>
            </div>
        </div>
    @else
        <div class="text-center mt-5 bg-light p-3 rounded">
            <h4 class="text-danger fw-bold">Complete Salon Profile to Access Services</h4>
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

    // Optional: on page load, show selected (if editing)
    if (serviceType.value) {
        var ev = new Event('change');
        serviceType.dispatchEvent(ev);
    }
});
</script>
