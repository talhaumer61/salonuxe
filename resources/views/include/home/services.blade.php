<style>
    .service-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease-in-out;
}
.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}
.service-image-wrapper {
    background: #fefefe;
    padding: 20px;
    border-bottom: 1px solid #eee;
}
.service-image {
    height: 160px;
    object-fit: contain;
    transition: transform 0.3s ease;
}
.service-card:hover .service-image {
    transform: scale(1.05);
}
.service-info {
    background: rgba(255, 255, 255, 0.95);
}
.service-name {
    font-size: 1.2rem;
    color: #333;
}


</style>
<div class="service-wrapper float-left">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="service-head-wrapper float-left  wow fade-up animated" style="visibility: visible; animation-name: fade-up;">
                    <div class="service-content">
                        <h5>Our Services</h5>
                        <h3>What We Offer</h3>
                    </div>
                    <a href="/available-services" class="service-btn">
                        <div class="main-btn">
                            <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em><span>Explore All Services
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="service-box-wrapper  wow fade-box animated" style="visibility: visible; animation-name: fade-box;">
            <div class="row">
    @foreach($services as $service)
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="service-card position-relative rounded-4 overflow-hidden text-center shadow-sm">
                <div class="service-image-wrapper">
                    <img src="{{ asset($service->icon) }}" alt="{{ $service->name }}" class="img-fluid service-image">
                </div>
                <div class="service-info py-3 px-2">
                    <h5 class="service-name fw-bold text-capitalize mb-1">{{ $service->name }}</h5>
                    <a href="{{ 'available-services/' .$service->href}}" class="btn btn-sm btn-dark mt-2">Explore</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

        </div>
    </div>
</div>

