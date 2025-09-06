<div class="container mb-5">
    <div class="row">
        <div class="col-lg-4 mb-4">
            </div>

        <div class="col-lg-8">
            <h2 class="mb-4">Search Results</h2>
            @if ($services->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    No services found that match your criteria. Please try a different search.
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                    @foreach ($services as $service)
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0 service-card">
                                <div class="position-relative">
                                    <img src="{{ asset($service->service_photo) }}" class="card-img-top service-img" alt="{{ $service->service_name }}">
                                    <div class="card-img-overlay d-flex flex-column justify-content-end p-2">
                                        <h5 class="card-title text-white bg-secondary p-1 rounded service-title-bg">{{ $service->service_name }}</h5>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $service->salon_name }}</h6>
                                    <p class="card-text mb-3 text-truncate">{{ Str::limit($service->service_desc, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <h4 class="text-primary mb-0">Rs. {{ number_format($service->service_price, 2) }}</h4>
                                    </div>
                                    <a href="#" class="btn btn-primary fw-bold px-4">Book Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Add some custom styles for a better look */
    .service-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .service-img {
        height: 200px; /* Consistent image height */
        object-fit: cover;
    }
    .service-title-bg {
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background for text on image */
    }
</style>