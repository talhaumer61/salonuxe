
<div class="container">
    <!-- Salon Info -->
    <div class="row mb-4 p-3">
        <div class="col-md-3">
            <img src="{{ asset($salon->salon_logo) }}" class="img-fluid rounded shadow" alt="{{ $salon->salon_name }}">
        </div>
        <div class="col-md-9">
            <h2>{{ $salon->salon_name }}</h2>
            <p><i class="fas fa-map-marker-alt"></i> {{ $salon->salon_address }}, {{ $salon->city_name }}</p>
            <p><i class="fas fa-clock"></i> {{ $salon->opening_time }} - {{ $salon->closing_time }}</p>
            <p><i class="fas fa-phone"></i> {{ $salon->salon_phone }}</p>
            <p><i class="fas fa-envelope"></i> {{ $salon->salon_email }}</p>
        </div>
    </div>

    <!-- Services -->
    <div class="container">
        <h3 class="mb-4 text-center">Services Offered</h3>
        @if($services->isNotEmpty())
            @foreach($services as $typeId => $group)
                <div class="my-4">
                    <h4 class="mb-3">{{ $group->first()->type_name }}</h4>
                    <div class="row">
                        @foreach($group as $service)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <img src="{{ asset($service->service_photo) }}" class="card-img-top" alt="{{ $service->service_name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $service->service_name }}</h5>
                                        <p class="card-text">
                                            <span class="fw-bold">Price:</span> Rs. {{ $service->service_price }}
                                        </p>
                                        <a href="/book-appointment/{{ $service->service_href }}" class="btn btn-outline-primary btn-sm">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center text-muted my-5">
                <p>No services found for this salon.</p>
            </div>
        @endif
    </div>
</div>

