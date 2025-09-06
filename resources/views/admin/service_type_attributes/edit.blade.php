
<header class="page-header page-header-left-inline-breadcrumb">
    <h2 class="font-weight-bold text-6">Edit Attribute</h2>
    <div class="right-wrapper">
        <ol class="breadcrumbs">
            <li><span>Dashboard</span></li>
            <li><span>Service Type</span></li>
            <li><span>Edit</span></li>
        </ol>
    </div>
</header>

<div class="container-fluid bg-white">
    <form action="/service-type-attributes/update/{{ $attribute->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="service_type_id" class="form-label">Service Type</label>
            <select name="service_type_id" id="service_type_id" class="form-control" required>
                <option value="">-- Select Service Type --</option>
                @foreach($serviceTypes as $type)
                    <option value="{{ $type->id }}" 
                        {{ old('service_type_id', $attribute->service_type_id) == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="label" class="form-label">Attribute Label</label>
            <input type="text" id="label" name="label" class="form-control" 
                   value="{{ old('label', $attribute->label) }}" required>
        </div>

        <div class="mb-3">
            <label for="key" class="form-label">Key (unique identifier)</label>
            <input type="text" id="key" name="key" class="form-control" 
                   value="{{ old('key', $attribute->key) }}" required>
            <small class="text-muted">E.g. suitable_for_hair_type</small>
        </div>

        <div class="mb-3">
            <label for="input_type" class="form-label">Input Type</label>
            <select name="input_type" id="input_type" class="form-control" required>
                <option value="">-- Select Type --</option>
                <option value="text" {{ old('input_type', $attribute->input_type) == 'text' ? 'selected' : '' }}>Text</option>
                <option value="number" {{ old('input_type', $attribute->input_type) == 'number' ? 'selected' : '' }}>Number</option>
                <option value="select" {{ old('input_type', $attribute->input_type) == 'select' ? 'selected' : '' }}>Select (Single)</option>
                <option value="multiselect" {{ old('input_type', $attribute->input_type) == 'multiselect' ? 'selected' : '' }}>Multi Select</option>
                <option value="radio" {{ old('input_type', $attribute->input_type) == 'radio' ? 'selected' : '' }}>Radio Buttons</option>
                <option value="checkbox" {{ old('input_type', $attribute->input_type) == 'checkbox' ? 'selected' : '' }}>Checkboxes</option>
            </select>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_required" name="is_required" value="1"
                   {{ old('is_required', $attribute->is_required) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_required">Required?</label>
        </div>

        <div class="mb-3" id="options-wrapper" style="display:{{ in_array($attribute->input_type, ['select', 'multiselect', 'radio', 'checkbox']) ? 'block' : 'none' }};">
            <label class="form-label">Options</label>
            <div id="options-container">
                @if(in_array($attribute->input_type, ['select', 'multiselect', 'radio', 'checkbox']))
                    @forelse($options as $option)
                        <div class="d-flex mb-2 option-item">
                            <input type="hidden" name="existing_options_id[]" value="{{ $option->id }}">
                            <input type="text" name="options[]" class="form-control me-2" placeholder="Enter option value" value="{{ $option->value }}">
                            <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
                        </div>
                    @empty
                        <div class="d-flex mb-2 option-item">
                            <input type="text" name="options[]" class="form-control me-2" placeholder="Enter option value">
                            <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
                        </div>
                    @endforelse
                @else
                    <div class="d-flex mb-2 option-item">
                        <input type="text" name="options[]" class="form-control me-2" placeholder="Enter option value">
                        <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-secondary btn-sm" id="add-option">+ Add Option</button>
        </div>

        <button type="submit" class="btn btn-primary">Update Attribute</button>
    </form>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputType = document.getElementById('input_type');
        const optionsWrapper = document.getElementById('options-wrapper');
        const addOptionBtn = document.getElementById('add-option');
        const optionsContainer = document.getElementById('options-container');

        inputType.addEventListener('change', function() {
            const typesWithOptions = ['select', 'multiselect', 'radio', 'checkbox'];
            if (typesWithOptions.includes(this.value)) {
                optionsWrapper.style.display = 'block';
            } else {
                optionsWrapper.style.display = 'none';
                // Clear options when the type changes to one without them
                optionsContainer.innerHTML = `
                    <div class="d-flex mb-2 option-item">
                        <input type="text" name="options[]" class="form-control me-2" placeholder="Enter option value">
                        <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
                    </div>
                `;
            }
        });

        addOptionBtn.addEventListener('click', function() {
            const newOption = document.createElement('div');
            newOption.classList.add('d-flex', 'mb-2', 'option-item');
            newOption.innerHTML = `
                <input type="text" name="options[]" class="form-control me-2" placeholder="Enter option value">
                <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
            `;
            optionsContainer.appendChild(newOption);
        });

        optionsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-option')) {
                e.target.closest('.option-item').remove();
            }
        });

        document.getElementById('label').addEventListener('input', function() {
            const keyInput = document.getElementById('key');
            keyInput.value = this.value.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]+/g, '');
        });
    });
</script>