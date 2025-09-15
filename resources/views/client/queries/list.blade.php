<header class="page-header">
    <h2>Messages</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs pe-2">
            <li>
                <a href="/">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Dashboard</span></li>
            <li><span>Messages</span></li>
        </ol>
    </div>
</header>
<div class="row">
    <div class="col">
        <div class="card card-modern">
            <div class="card-body">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>My Queries</h3>
        <!-- Start New Query -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newQueryModal">Start New Query</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Salon</th>
                    <th>Subject / Job</th>
                    <th>Latest Message</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($queries as $q)
                    @php
                        $last = $q->messages->last();
                    @endphp
                    <tr>
                        <td>{{ $q->salon_name }}</td>
                        <td>{{ $q->subject ?? ($q->job_title ? 'Job: '.$q->job_title : '—') }}</td>
                        <td style="max-width:360px;">
                            <small class="text-muted">{{ $last ? \Illuminate\Support\Str::limit($last->message, 80) : '-' }}</small>
                        </td>
                        <td>
                            {!! $q->is_replied ? '<span class="badge bg-success">Replied</span>' : '<span class="badge bg-warning">Pending</span>' !!}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($q->updated_at)->format('M d, Y') }}</td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#queryModal{{ $q->id }}">Open</button>
                        </td>
                    </tr>

                    <!-- Thread Modal -->
                    <div class="modal fade" id="queryModal{{ $q->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Conversation with {{ $q->salon_name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body d-flex flex-column" style="max-height:500px;">
                                
                                <!-- Scrollable messages -->
                                <div class="flex-grow-1 mb-2" style="overflow-y:auto; max-height:400px;">
                                @foreach($q->messages as $msg)
                                    @if($msg->sender_type == 'user')
                                        <div class="p-2 mb-2 bg-light rounded">
                                            <small class="text-muted">You • {{ \Carbon\Carbon::parse($msg->created_at)->format('M d, Y H:i') }}</small>
                                            <p class="mb-0">{{ $msg->message }}</p>
                                        </div>
                                    @else
                                        <div class="p-2 mb-2 bg-primary text-white rounded">
                                            <small class="text-white">Salon • {{ \Carbon\Carbon::parse($msg->created_at)->format('M d, Y H:i') }}</small>
                                            <p class="mb-0 text-white">{{ $msg->message }}</p>
                                        </div>
                                    @endif
                                @endforeach
                                </div>

                                <!-- Reply form -->
                                <form action="{{ route('queries.message', $q->id) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <textarea name="message" rows="3" class="form-control" placeholder="Type your message..." required></textarea>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Send</button>
                                </div>
                                </form>

                            </div>
                            </div>
                        </div>
                    </div>


                @empty
                    <tr>
                        <td colspan="6" class="text-center">You have no queries yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- New Query Modal (start a new query) -->
<div class="modal fade" id="newQueryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('queries.start') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Start New Query</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
              <label class="form-label">Salon</label>
              <select name="salon_id" class="form-select" required>
                  <option value="">-- Select Salon --</option>
                  @foreach($salons as $s)
                      <option value="{{ $s->salon_id }}">{{ $s->salon_name }}</option>
                  @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label class="form-label">Subject (optional)</label>
              <input type="text" name="subject" class="form-control" maxlength="255">
          </div>
          <div class="mb-3">
              <label class="form-label">Message</label>
              <textarea name="message" class="form-control" rows="4" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Start Query</button>
        </div>
      </div>
    </form>
  </div>
</div>


            </div>
        </div>
    </div>
</div>