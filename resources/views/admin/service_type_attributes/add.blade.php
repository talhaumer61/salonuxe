<header class="page-header page-header-left-inline-breadcrumb">
    <h2 class="font-weight-bold text-6">Service Type</h2>
    <div class="right-wrapper">
        <ol class="breadcrumbs">
            <li><span>Dashboard</span></li>
            <li><span>Service Type</span></li>
            <li><span>Add</span></li>
        </ol>
    </div>
</header>
<!-- start: page -->
<div class="container-fluid bg-white">
    {{-- <h2>Add Attribute for {{ $serviceType->name }}</h2> --}}

    <form action="/service-type-attributes/store" method="POST">
        @csrf

        <!-- Service Type -->
        <div class="mb-3">
            <label for="service_type_id" class="form-label">Service Type</label>
            <select name="service_type_id" id="service_type_id" class="form-control" required>
                <option value="">-- Select Service Type --</option>
                @foreach($serviceTypes as $type)
                    <option value="{{ $type->id }}" {{ old('service_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Attribute Label -->
        <div class="mb-3">
            <label for="label" class="form-label">Attribute Label</label>
            <input type="text" id="label" name="label" class="form-control" 
                value="{{ old('label') }}" required>
        </div>

        <!-- Key (auto-generate from label via JS, but editable) -->
        <div class="mb-3">
            <label for="key" class="form-label">Key (unique identifier)</label>
            <input type="text" id="key" name="key" class="form-control" 
                value="{{ old('key') }}" required>
            <small class="text-muted">E.g. suitable_for_hair_type</small>
        </div>

        <!-- Input Type -->
        <div class="mb-3">
            <label for="input_type" class="form-label">Input Type</label>
            <select name="input_type" id="input_type" class="form-control" required>
                <option value="">-- Select Type --</option>
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="select">Select (Single)</option>
                <option value="multiselect">Multi Select</option>
                <option value="radio">Radio Buttons</option>
                <option value="checkbox">Checkboxes</option>
            </select>
        </div>

        <!-- Is Required -->
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_required" name="is_required" value="1">
            <label class="form-check-label" for="is_required">Required?</label>
        </div>

        <!-- Attribute Options -->
        <div class="mb-3" id="options-wrapper" style="display:none;">
            <label class="form-label">Options</label>
            <div id="options-container">
                <div class="d-flex mb-2 option-item">
                    <input type="text" name="options[]" class="form-control me-2" placeholder="Enter option value">
                    <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" id="add-option">+ Add Option</button>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary">Save Attribute</button>
    </form>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputType = document.getElementById('input_type');
        const optionsWrapper = document.getElementById('options-wrapper');
        const addOptionBtn = document.getElementById('add-option');
        const optionsContainer = document.getElementById('options-container');

        // Show/hide options field based on input_type
        inputType.addEventListener('change', function() {
            const typesWithOptions = ['select', 'multiselect', 'radio', 'checkbox'];
            if (typesWithOptions.includes(this.value)) {
                optionsWrapper.style.display = 'block';
            } else {
                optionsWrapper.style.display = 'none';
            }
        });

        // Add option field
        addOptionBtn.addEventListener('click', function() {
            const newOption = document.createElement('div');
            newOption.classList.add('d-flex', 'mb-2', 'option-item');
            newOption.innerHTML = `
                <input type="text" name="options[]" class="form-control me-2" placeholder="Enter option value">
                <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
            `;
            optionsContainer.appendChild(newOption);
        });

        // Remove option field
        optionsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-option')) {
                e.target.closest('.option-item').remove();
            }
        });

        // Auto-generate key from label
        document.getElementById('label').addEventListener('input', function() {
            const keyInput = document.getElementById('key');
            keyInput.value = this.value.toLowerCase().replace(/\s+/g, '_');
        });
    });
</script>
