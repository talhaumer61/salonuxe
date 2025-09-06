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
<form class="ecommerce-form action-buttons-fixed" action="/services/update/{{$service->service_id }}" method="post" enctype="multipart/form-data">
    @if ($salon)
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-5">
                                <i class="card-big-info-icon bx bx-slider"></i>
                                <h2 class="card-big-info-title">Details</h2>
                                <p class="card-big-info-desc">Edit description and necessary information.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">Name</label>
                                    <div class="col-lg-7 col-xl-10">
                                        <input type="text" class="form-control form-control-modern" name="service_name" value="{{ old('service_name', $service->service_name) }}" required>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="serviceType" class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">Service Type</label>
                                    <div class="col-lg-7 col-xl-10">
                                        <select name="service_type_id" id="serviceType" class="form-control form-control-modern" required>
                                            <option value="">-- Select Service Type --</option>
                                            @foreach($serviceTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('service_type_id', $service->id_type) == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @foreach($attributes as $serviceTypeId => $attrGroup)
                                    <div id="type-{{ $serviceTypeId }}" class="service-attributes" style="display:none;">
                                        @foreach($attrGroup as $attr)
                                            <div class="form-group row align-items-center mb-3">
                                                <label class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">{{ $attr->label }}</label>
                                                <div class="col-lg-7 col-xl-10">
                                                    @php
                                                        $singleTypes = ['select', 'radio'];
                                                        $multiTypes = ['multiselect', 'checkbox'];
                                                        $selectedValue = $preselectedValues[$attr->id] ?? null;
                                                    @endphp

                                                    @if(in_array($attr->input_type, $singleTypes))
                                                        @foreach($attr->options as $opt)
                                                            <div class="form-check">
                                                                <input class="form-check-input" 
                                                                    type="radio" 
                                                                    name="attributes[{{ $attr->id }}]" 
                                                                    id="attr-{{ $attr->id }}-opt-{{ $opt->id }}" 
                                                                    value="{{ $opt->id }}" 
                                                                    {{ ($selectedValue && in_array($opt->id, $selectedValue)) ? 'checked' : '' }}
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
                                                                    value="{{ $opt->id }}"
                                                                    {{ ($selectedValue && in_array($opt->id, $selectedValue)) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="attr-{{ $attr->id }}-opt-{{ $opt->id }}">{{ $opt->value }}</label>
                                                            </div>
                                                        @endforeach
                                                    @elseif(in_array($attr->input_type, ['text', 'number']))
                                                        <input type="{{ $attr->input_type }}" 
                                                            class="form-control form-control-modern" 
                                                            name="attributes[{{ $attr->id }}]" 
                                                            value="{{ $selectedValue ?? '' }}"
                                                            {{ $attr->is_required ? 'required' : '' }}>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach

                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-5 col-xl-2 control-label text-lg-end mb-0">Price</label>
                                    <div class="col-lg-7 col-xl-10">
                                        <input type="number" class="form-control form-control-modern" name="service_price" value="{{ old('service_price', $service->service_price) }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-xl-2 control-label text-lg-end pt-2 mt-1 mb-0">Description</label>
                                    <div class="col-lg-7 col-xl-10">
                                        <textarea class="form-control form-control-modern" name="service_desc" rows="6">{{ old('service_desc', $service->service_desc) }}</textarea>
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
                                <p class="card-big-info-desc">Upload a new photo to replace the existing one.</p>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row align-items-center">
                                    <div class="col">
                                        @if($service->service_photo)
                                            <div class="mb-3">
                                                <label>Current Photo:</label>
                                                <img src="{{ asset($service->service_photo) }}" alt="{{ $service->service_name }}" class="img-thumbnail" style="max-height: 150px;">
                                            </div>
                                        @endif
                                        <div id="dropzone-form-image" class="dropzone-modern dz-square dz-clickable dropzone initialized">
                                            <span class="dropzone-upload-message text-center">
                                                <i class="bx bxs-cloud-upload"></i>
                                                <h6>Drop new file here or click to upload.</h6>
                                            </span>
                                            <input type="file" class="form-control" name="service_photo" id="news_photo" accept=".jpg, .jpeg, .png, .svg" data-bs-original-title="" title="">
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
                <a href="{{ route('salon.services', 'list') }}" class="mx-1 btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                    Cancel
                </a>
                <button type="submit" class="mx-1 btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                    <i class="bx bx-save text-4 me-2"></i> Update
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

    // On page load, show the attributes for the selected service type
    if (serviceType.value) {
        var ev = new Event('change');
        serviceType.dispatchEvent(ev);
    }
});
</script>