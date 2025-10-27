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
                                <h2 class="my-0">Bookings</h2>
                            </div>
                        </div>
                    </div>
                    <table class="table table-ecommerce-simple table-borderless table-striped mb-0" id="datatable-ecommerce-list" style="min-width: 640px;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Advance Amount</th>
                                <th>Paid</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $order)
                            <tr id="appointment-row-{{ $order->href }}">
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $order->client_name }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($order->appointment_date)->format('M d, Y') }}</td>
                                <td>{{ $order->service_name }}</td>
                                <td>Rs. {{ number_format($order->service_price, 2) }}</td>
                                @if ($order->status == 1)
                                    <td>Rs. {{ number_format($order->advance_amount, 2) }}</td>
                                    <td>
                                        @if ($order->advance_paid)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-warning text-dark">No</span>
                                        @endif
                                    </td>
                                @else
                                    <td>Rs. 0.00</td>
                                    <td><span class="text-muted">N/A</span></td>
                                @endif
                                <td id="status-{{ $order->href }}">{!! get_booking_status($order->status) !!}</td>
                                <td class="text-center">
                                    @if(!$order->salon_completed && session('user')->login_type == 3)
                                            <form action="{{ route('appointments.markCompleted', $order->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Mark as Completed</button>
                                            </form>
                                        @endif
                                    @if ($order->status == 2)
                                        <button class="btn btn-sm btn-success" onclick="updateStatus('{{ $order->href }}', 1)"><i class="fa-regular fa-circle-check"></i> Accept</button>
                                        <button class="btn btn-sm btn-danger" onclick="updateStatus('{{ $order->href }}', 3)"><i class="fa-regular fa-circle-xmark"></i> Reject</button>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Bootstrap 5 Pagination --}}
                    <div class="d-flex justify-content-end mt-3">
                        {{ $appointments->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Script to accept or reject appointment --}}
<script>
    function updateStatus(href, newStatus) {
        if (!confirm('Are you sure you want to update the status?')) return;

        fetch(`/appointments/update-status/${href}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message || 'Status updated');
                location.reload();
            } else {
                alert(data.message || 'Failed to update status.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Something went wrong: ' + error.message);
        });
    }
</script>
