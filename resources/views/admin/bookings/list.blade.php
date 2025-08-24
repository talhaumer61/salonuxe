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
                <h3>Bookings List</h3>
                <div class="datatables-header-footer-wrapper">
                    <table class="table table-ecommerce-simple table-borderless table-striped mb-0" id="datatable-ecommerce-list" style="min-width: 640px;">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="25%">Customer Name</th>
                                <th width="18%">Date</th>
                                <th width="18%">Service</th>
                                <th width="15%">Salon</th>
                                <th width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                            <tr>
                                <td><strong>{{ $loop->iteration }}</strong></td>
                                <td>
                                    <strong>{{ $appointment->client_name }}</strong><br>
                                    <small>{{ $appointment->client_email }} | {{ $appointment->client_phone }}</small>
                                </td>
                                <td>{{ date('M d, Y', strtotime($appointment->appointment_date)) }}<br><small>{{ $appointment->appointment_time }}</small></td>
                                <td>{{ $appointment->service_name ?? 'N/A' }}</td>
                                <td>{{ $appointment->salon_name ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $statusMap = [1 => 'Accepted', 2 => 'Pending', 3 => 'Rejected'];
                                        $statusClass = [1 => 'completed', 2 => 'on-hold', 3 => 'canceled'];
                                    @endphp
                                    <span class="ecommerce-status {{ $statusClass[$appointment->status] ?? 'on-hold' }}">
                                        {{ $statusMap[$appointment->status] ?? 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach

                            @if($appointments->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No appointments found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>