<header class="page-header">
    <h2>Customer Messages</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs pe-2">
            <li>
                <a href="/">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Dashboard</span></li>
            <li><span>Customer Messages</span></li>
        </ol>
    </div>
</header>
<div class="row">
    <div class="col">
        <div class="card card-modern">
            <div class="card-body">
                <div class="container mt-4">
                    <header class="page-header">
                        <h2>Customer Queries</h2>
                    </header>

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="card">
                    <div class="card-body">
                        @if($queries->count())
                            <div class="table-responsive">
                                <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th>User</th>
                                    <th>Subject / Job</th>
                                    <th>Latest</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($queries as $q)
                                        @php $last = $q->messages->last(); @endphp
                                        <tr>
                                        <td>{{ $q->user_name }}<br><small class="text-muted">{{ $q->user_email }}</small></td>
                                        <td>{{ $q->subject ?? ($q->job_title ? 'Job: '.$q->job_title : '—') }}</td>
                                        <td><small class="text-muted">{{ $last ? \Illuminate\Support\Str::limit($last->message, 80) : '-' }}</small></td>
                                        <td>{!! $q->is_replied ? '<span class="badge bg-success">Replied</span>' : '<span class="badge bg-warning">Pending</span>' !!}</td>
                                        <td>{{ \Carbon\Carbon::parse($q->updated_at)->format('M d, Y') }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#ownerQueryModal{{ $q->id }}">View / Reply</button>
                                        </td>
                                        </tr>

                                        <!-- Owner Thread Modal -->
                                        <div class="modal fade" id="ownerQueryModal{{ $q->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Conversation with {{ $q->user_name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body d-flex flex-column" style="max-height:500px;">
                                                        
                                                        <!-- Scrollable messages area -->
                                                        <div class="flex-grow-1 mb-2" style="overflow-y:auto; max-height:400px;">
                                                            @foreach($q->messages as $msg)
                                                                @if($msg->sender_type == 'user')
                                                                    <div class="p-2 mb-2 bg-light rounded">
                                                                        <small class="text-muted">
                                                                            {{ $q->user_name }} • {{ \Carbon\Carbon::parse($msg->created_at)->format('M d, Y H:i') }}
                                                                        </small>
                                                                        <p class="mb-0">{{ $msg->message }}</p>
                                                                    </div>
                                                                @else
                                                                    <div class="p-2 mb-2 bg-success text-white rounded">
                                                                        <small class="text-white-50">
                                                                            Owner • {{ \Carbon\Carbon::parse($msg->created_at)->format('M d, Y H:i') }}
                                                                        </small>
                                                                        <p class="mb-0">{{ $msg->message }}</p>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                        <!-- Reply form -->
                                                        <form action="{{ route('owner.queries.reply', $q->id) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-2">
                                                                <textarea name="message" rows="3" class="form-control" placeholder="Type a reply..." required></textarea>
                                                            </div>
                                                            <div class="text-end">
                                                                <button class="btn btn-success">Send Reply</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    @endforeach
                                </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $queries->links('pagination::bootstrap-5') }}
                            </div>
                        @else
                            <div class="text-center p-4">
                                <h4 class="text-muted mb-0">No queries yet.</h4>
                            </div>
                        @endif
                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>