<style>
    .filter-bar .form-label {
        font-size: 0.9rem;
    }

    .filter-bar .input-group-text {
        border-right: 0;
    }

    .filter-bar .form-control,
    .filter-bar .form-select {
        border-radius: 0.375rem;
        box-shadow: none;
    }

    .filter-bar .btn {
        padding: 0.5rem 1rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .filter-bar .row > div {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

<!-- Filter Bar -->
<div class="filter-bar py-4 shadow-sm rounded" style="background-color: var(--peach);">
    <div class="container">
        <form id="filterForm" method="GET" action="{{ url()->current() }}">
            @csrf
            <div class="row g-4 align-items-end">
                <!-- Search -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-dark">
                        <i class="fa fa-search me-1"></i>Search Service
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="e.g. Facial, Hair Cut">
                    </div>
                </div>

                <!-- City Filter -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-dark">
                        <i class="fa fa-map-marker-alt me-1"></i>Filter by City
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa fa-city text-muted"></i>
                        </span>
                        <select name="city" id="city" class="form-select border-start-0">
                            <option value="">All Cities</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Min Price -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-dark">
                        <i class="fa fa-dollar-sign me-1"></i>Min Price
                    </label>
                    <input type="number" name="min_price" id="min_price" class="form-control" placeholder="0">
                </div>

                <!-- Max Price -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-dark">
                        <i class="fa fa-dollar-sign me-1"></i>Max Price
                    </label>
                    <input type="number" name="max_price" id="max_price" class="form-control" placeholder="10000">
                </div>

                <!-- Buttons -->
                <div class="col-md-2 d-flex gap-2">
                    <button type="button" id="applyFilters" class="btn btn-primary w-100">
                        <i class="fa fa-filter me-1"></i>Apply
                    </button>
                    <button type="button" id="clearFilters" class="btn btn-outline-secondary w-100">
                        <i class="fa fa-times me-1"></i>Clear
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Services Section -->
<div id="services-section">
    @if($flatServices->isNotEmpty())
        @foreach($services as $typeId => $serviceGroup)
            <div class="offer-three-wrapper float-left py-0">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="offer-head head-border animated my-5 wow fade-up">
                                <h3>{{ $serviceGroup->first()->type_name }}</h3>
                                <span></span>
                            </div>
                            <div class="row">
                                @foreach($serviceGroup->take(6) as $service)
                                    <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                                        <div class="item-card card shadow-sm h-100">
                                            <div class="position-relative">
                                                <img src="{{ asset($service->service_photo) }}" class="card-img-top" alt="Background">
                                                <div class="position-absolute top-100 start-50 translate-middle-x" style="margin-top: -25px;">
                                                    <img src="{{ asset($service->salon_logo) }}" class="rounded-circle bg-white p-1" style="width: 50px; height: 50px;" alt="{{ $service->service_name }}">
                                                </div>
                                            </div>
                                            <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                                <h5 class="card-title text-center mt-4">{{ $service->service_name }}</h5>
                                                <p class="text-center text-dark mb-1">
                                                    <i class="fa-solid fa-store"></i> {{ $service->salon_name }}, {{ $service->city_name }} 
                                                </p>
                                                <p class="card-text text-center text-dark">
                                                    <span class="fw-bold">Rs. </span> {{ $service->service_price }}
                                                </p>
                                            </div>
                                            <div class="card-footer bg-transparent text-center border-0">
                                                <a href="/book-appointment/{{ $service->service_href }}" class="btn btn-outline-primary btn-sm">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mb-5">
                                <h6 class="text-center my-3">
                                    @if(!$href)
                                        <a href="{{ url('available-services/' . $serviceGroup->first()->type_href) }}" class="btn btn-outline-success">
                                            View All <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center p-4" style="background-color: var(--peach);">
            <img src="{{ asset('images/not_found.png') }}" alt="No Results" style="max-width: 180px;">
            <h4 class="text-muted">Oops! No services found.</h4>
            <p>Try changing your search or filter options.</p>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterForm');
    const section = document.getElementById('services-section');
    const applyBtn = document.getElementById('applyFilters');
    const clearBtn = document.getElementById('clearFilters');
    const searchInput = document.getElementById('search');

    function fetchFilteredServices() {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        fetch(`${form.action}?${params}`, {
            method: "GET",
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const htmlParser = new DOMParser();
            const parsedDoc = htmlParser.parseFromString(data.html, 'text/html');
            const newSection = parsedDoc.querySelector('#services-section');
            if (newSection) {
                section.innerHTML = newSection.innerHTML;
            }
        })
        .catch(err => console.error('AJAX Error:', err));
    }

    searchInput.addEventListener('input', fetchFilteredServices);
    applyBtn.addEventListener('click', fetchFilteredServices);
    clearBtn.addEventListener('click', () => {
        form.reset();
        fetchFilteredServices();
    });
});
</script>
