<header class="page-header">
    <h2>Bookings</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs pe-2">
            <li>
                <a href="/">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Bookings</span></li>
            <li><span>List</span></li>
        </ol>
    </div>
</header>
<div class="row">
    <div class="col">
        <div class="card card-modern">
            <div class="card-body">
                <div class="datatables-header-footer-wrapper">
                    <div class="datatable-header">
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                <h2 class="my-0">My Bookings</h2>
                            </div>
                        </div>
                    </div>
                    <table class="table table-ecommerce-simple table-borderless table-striped mb-0" style="min-width: 1000px;">
                        <thead>
                            <tr>
                                <th>Sr. </th>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Advance</th>
                                <th>Salon Name</th>
                                <th>Salon Phone</th>
                                <th>Appointment Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $appointment->service_name }}</td>
                                    <td class="fw-bold">Rs. {{ $appointment->service_price }}</td>
                                    <td class="fw-bold">
                                        @if($appointment->status === 1 && empty($appointment->advance_paid) )
                                        Rs. {{ $appointment->advance_amount }}
                                        @elseif(!empty($appointment->advance_paid))
                                        Rs. {{ $appointment->advance_paid }}
                                        @else
                                        "N/A"
                                        @endif
                                    </td>
                                    <td>{{ $appointment->salon_name }}</td>
                                    <td>{{ $appointment->salon_phone }}</td>
                                    <td class="fw-bold">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                    <td class="fw-bold">{{ \Carbon\Carbon::createFromFormat('H:i', $appointment->appointment_time)->format('h:i A') }}</td>
                                    <td>{!! get_booking_status($appointment->status) !!}</td>
                                    <td>

                                        @if($appointment->status === 1 && empty($appointment->advance_paid) )
                                            <form method="POST" action="{{ route('appointments.pay', $appointment->href) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm  btn-success">
                                                    Pay Advance  <i class="fa-solid fa-money-bill-wave text-light"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if(!$appointment->client_completed && session('user')->login_type == 2)
                                        <form action="{{ route('appointments.markCompleted', $appointment->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Mark as Completed</button>
                                        </form>
                                        @endif

                                        <form action="{{ route('appointments.delete', $appointment->href) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash text-light"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $appointments->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>