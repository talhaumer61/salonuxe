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
                                            <img src="{{ asset($service->service_photo) }}" class="rounded-circle bg-white p-1" style="width: 50px; height: 50px;" alt="{{ $service->service_name }}">
                                        </div>
                                    </div>
                                
                                    <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                        <h5 class="card-title text-center mt-4">{{ $service->service_name }}</h5>
                                
                                        {{-- NEW: Show Salon Name --}}
                                        <p class="text-center text-dark mb-1">
                                            <i class="fa-solid fa-store"></i> {{ $service->salon_name }}, {{ $service->city_name }} 
                                        </p>
                                
                                
                                        <p class="card-text text-center text-dark">
                                            <span class="fw-bold">Rs. </span> {{ $service->service_price }}
                                        </p>
                                    </div>
                                
                                    <div class="card-footer bg-transparent text-center border-0">
                                        <a href="#" class="btn btn-outline-primary btn-sm">Book Now</a>
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
