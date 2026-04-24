@extends('layouts.admin')

@section('content')

    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h5 class="me-3">Notifications</h5>
            <p class="text-muted mb-0">Your critical alert and system notifications are shown here.</p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Received At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notification)
                            <tr class="{{ $notification->is_read ? '' : 'table-info' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $notification->message }}</td>
                                <td>
                                    <span class="badge bg-{{ $notification->is_read ? 'secondary' : 'danger' }}">
                                        {{ $notification->is_read ? 'Read' : 'Unread' }}
                                    </span>
                                </td>
                                <td>{{ optional($notification->created_at)->format('d M Y H:i') ?? '-' }}</td>
                                <td class="text-center">
                                    @unless($notification->is_read)
                                        <form action="{{ route('doctor.notifications.read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                Mark Read
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-success">Done</span>
                                    @endunless
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No notifications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
