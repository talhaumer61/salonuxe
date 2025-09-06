<div class="contact-form pb-4">
    <div class="container">
        <div class="row">
            <div class="sidebar-head">
                <h6>Find Your Perfect Service</h6>
            </div>
            <div class="sidebar-body form-head">
                <form action="{{ route('client.services.search') }}" method="GET">
                    @csrf

                    <div class="mb-3">
                        <label for="serviceType" class="form-label">Service Type</label>
                        <select name="service_type_id" id="serviceType" class="form-control">
                            <option value="">-- All Services --</option>
                            @foreach ($serviceTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="attributes-container">
                        @foreach ($attributes as $serviceTypeId => $attributeGroup)
                            <div id="type-{{ $serviceTypeId }}" class="attribute-group" style="display:none;">
                                @foreach ($attributeGroup->groupBy('attribute_id') as $attributeId => $options)
                                    <div class="mb-3">
                                        <label class="form-label">{{ $options->first()->label }}</label>
                                        @if ($options->first()->input_type === 'multiselect' || $options->first()->input_type === 'checkbox')
                                            @foreach ($options as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="attribute_options[]" value="{{ $option->option_id }}">
                                                    <label class="form-check-label">{{ $option->value }}</label>
                                                </div>
                                            @endforeach
                                        @elseif ($options->first()->input_type === 'radio')
                                            @foreach ($options as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="attribute_options[]" value="{{ $option->option_id }}">
                                                    <label class="form-check-label">{{ $option->value }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label for="min_price" class="form-label">Budget Range</label>
                        <div class="d-flex">
                            <input type="number" name="min_price" class="form-control me-2" placeholder="Min Price">
                            <input type="number" name="max_price" class="form-control" placeholder="Max Price">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Search Services</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('serviceType').addEventListener('change', function() {
        var selectedTypeId = this.value;
        document.querySelectorAll('.attribute-group').forEach(group => {
            group.style.display = 'none';
        });
        if (selectedTypeId) {
            document.getElementById('type-' + selectedTypeId).style.display = 'block';
        }
    });
</script>