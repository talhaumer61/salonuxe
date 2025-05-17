<header class="page-header page-header-left-inline-breadcrumb">
    <h2 class="font-weight-bold text-6">Book Appointment</h2>
    <div class="right-wrapper">
        <ol class="breadcrumbs">
            <li><span>Home</span></li>
            <li><span>Book Appointment</span></li>
            <li><span>{{$service->service_name}}</span></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
    </div>
</header>
<!-- start: page -->
<form class="ecommerce-form action-buttons-fixed" action="{{ route('make.appointment') }}" method="post">
    @csrf
    <input type="hidden" name="id_client" value="{{session('user')->id}}">
    <input type="hidden" name="id_salon" value="{{$service->id_salon}}">
    <input type="hidden" name="id_service" value="{{$service->service_id}}">
    <div class="row">
        <div class="col">
            <section class="card card-modern card-big-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2-5 col-xl-1-5 py-2 text-center">
                            <i class="card-big-info-icon fa-regular fa-user-circle"></i>
                            <h2 class="card-big-info-title">General Info</h2>
                            {{-- <p class="card-big-info-desc">Add here the customer billing info with all details and necessary information.</p> --}}
                        </div>
                        <div class="col-lg-3-5 col-xl-4-5">
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-3 col-xl-3 control-label text-lg-end mb-0">Full Name</label>
                                <div class="col-lg-9 col-xl-9">
                                    <input type="text" class="form-control form-control-modern" name="client_name" value="{{ session('user')->name }}" required="">
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-3 col-xl-3 control-label text-lg-end mb-0">Phone</label>
                                <div class="col-lg-9 col-xl-9">
                                    <input type="text" class="form-control form-control-modern" name="client_phone" value="{{ session('user')->phone }}" required="">
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-3 col-xl-3 control-label text-lg-end mb-0">Email</label>
                                <div class="col-lg-9 col-xl-9">
                                    <input type="text" class="form-control form-control-modern" name="client_email" value="{{ session('user')->email }}" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <section class="card card-modern card-big-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2-5 col-xl-1-5 py-2 text-center">
                            <i class="card-big-info-icon fa-regular fa-circle-check"></i>
                            <h2 class="card-big-info-title">Salon & Service Info</h2>
                        </div>
                        <div class="col-lg-3-5 col-xl-4-5">
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-3 col-xl-3 control-label text-lg-end mb-0">Salon Name</label>
                                <div class="col-lg-9 col-xl-9">
                                    <input type="text" class="form-control form-control-modern" name="salon_name" value="{{ $service->salon_name }}" required="" readonly>
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-3 col-xl-3 control-label text-lg-end mb-0">Address</label>
                                <div class="col-lg-9 col-xl-9">
                                    <input type="text" class="form-control form-control-modern" name="salon_address" value="{{ $service->salon_address }}" required="" readonly>
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-3 col-xl-3 control-label text-lg-end mb-0">Phone</label>
                                <div class="col-lg-9 col-xl-9">
                                    <input type="text" class="form-control form-control-modern" name="salon_phone" value="{{ $service->salon_phone }}" required="" readonly>
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-3 col-xl-3 control-label text-lg-end mb-0">Timing</label>
                                <div class="col-lg-9 col-xl-9">
                                    <input type="text" class="form-control form-control-modern" name="salon_phone" value="{{ $service->opening_time.' - '.$service->closing_time  }}" required="" readonly>
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-3 col-xl-3 control-label text-lg-end mb-0">Service Name</label>
                                <div class="col-lg-9 col-xl-9">
                                    <input type="text" class="form-control form-control-modern" name="service_name" value="{{ $service->service_name  }}" required="" readonly>
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-3 col-xl-3 control-label text-lg-end mb-0">Service Name</label>
                                <div class="col-lg-9 col-xl-9">
                                    <input type="text" class="form-control form-control-modern" name="service_price" value="{{ 'Rs. '.$service->service_price  }}" required="" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <section class="card card-modern card-big-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2-5 col-xl-1-5 py-2 text-center">
                            <i class="card-big-info-icon fa-regular fa-clock"></i>
                            <h2 class="card-big-info-title">Appointment Info</h2>
                        </div>
                        <div class="col-lg-3-5 col-xl-4-5">
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-3 col-xl-3 control-label text-lg-end mb-0">Date</label>
                                <div class="col-lg-9 col-xl-9">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                        <input name="appointment_date" data-plugin-masked-input="" type="date" data-input-mask="99/99/9999" placeholder="__/__/____" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-3 col-xl-3 control-label text-lg-end mb-0">Time</label>
                                <div class="col-lg-9 col-xl-9">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="far fa-clock"></i>
                                        </span>
                                        <input name="appointment_time" type="time" data-plugin-timepicker="" class="form-control">
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
            <a href="/" class="delete-button btn btn-danger btn-px-4 ms-1 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                <i class="fa-solid fa-xmark text-light me-2" style="color: white"></i> Cancel
            </a>
            <button type="submit" class="delete-button btn btn-primary btn-px-4 ms-1 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                Submit
                <i class="fa-solid fa-check text-4 ms-2"></i> 
            </button>
        </div>
    </div>
</form>