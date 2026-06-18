
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header d-flex align-items-center justify-content-between">

        <div>

            <h4 class="fw-bold">
                Notifications
            </h4>

            <p class="text-muted mb-0">
                Manage critical alerts and system notifications
            </p>

        </div>

    </div>



    {{-- DASHBOARD CARDS --}}
    <div class="row mt-4 g-3">

        <div class="col">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Total
                    </h6>

                    <h2 class="text-primary fw-bold">
                        {{ $totalNotifications }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Unread
                    </h6>

                    <h2 class="text-danger fw-bold">
                        {{ $unreadNotifications }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Critical
                    </h6>

                    <h2 class="text-warning fw-bold">
                        {{ $criticalAlerts }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Reports
                    </h6>

                    <h2 class="text-info fw-bold">
                        {{ $labReports }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        FollowUps
                    </h6>

                    <h2 class="text-success fw-bold">
                        {{ $followups }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Medication
                    </h6>

                    <h2 class="text-secondary fw-bold">
                        {{ $medicationReviews }}
                    </h2>

                </div>

            </div>

        </div>

<div class="col">

    <div class="card shadow-sm border-0">

        <div class="card-body text-center">

            <h6 class="text-muted">
                Emergency
            </h6>

            <h2 class="text-danger fw-bold">
                {{ $emergencyAlerts }}
            </h2>

        </div>

    </div>

</div>



    </div>



    {{-- FILTERS --}}
    <div class="card mt-4 border-0 shadow-sm">

        <div class="card-body">

            <form method="GET">

                <div class="row align-items-end">

                    {{-- TYPE --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Notification Type
                        </label>

                        <select
                            name="type"
                            class="form-control">

                            <option value="">
                                All Types
                            </option>

                            <option value="Critical">
                                Critical
                            </option>

                            <option value="Lab Report">
                                Lab Report
                            </option>

                            <option value="Follow-up">
                                Follow-up
                            </option>

                            <option value="Medication Review">
                                Medication Review
                            </option>
                            
                                <option value="Emergency">
                                    Emergency
                                </option>





                        </select>

                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-control">

                            <option value="">
                                All Status
                            </option>

                            <option value="Unread">
                                Unread
                            </option>

                            <option value="Read">
                                Read
                            </option>

                        </select>

                    </div>

                    {{-- BUTTON --}}
                    <div class="col-md-4 mb-3">

                        <button class="btn btn-primary">

                            <i class="fa fa-filter"></i>
                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>



    {{-- NOTIFICATION TABLE --}}
    <div class="card mt-4 border-0 shadow-sm">

        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>#</th>
                            <th>Type</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Received At</th>
                            <th class="text-center">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($notifications as $notification)

                            <tr class="{{ $notification->is_read ? '' : 'table-info' }}">

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                {{-- TYPE --}}
                                <td>

                                    <span class="badge bg-dark">

                                        {{ $notification->type }}

                                    </span>

                            
                                </td>

                                {{-- TITLE --}}
                                <td>

                                    {{ $notification->title }}

                                </td>

                                {{-- MESSAGE --}}
                                <td>

                                    {{ $notification->message }}

                                </td>

                                {{-- PRIORITY --}}
                                <td>

                                    @if($notification->priority == 'High')

                                        <span class="badge bg-danger">
                                            High
                                        </span>

                                    @elseif($notification->priority == 'Medium')

                                        <span class="badge bg-warning text-dark">
                                            Medium
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            Low
                                        </span>

                                    @endif

                                </td>

                                {{-- STATUS --}}
                                <td>

                                    <span class="badge bg-{{ $notification->is_read ? 'secondary' : 'danger' }}">

                                        {{ $notification->is_read ? 'Read' : 'Unread' }}

                                    </span>

                                </td>

                                {{-- DATE --}}
                                <td>

                                    {{ optional($notification->created_at)->format('d M Y H:i') ?? '-' }}

                                </td>

                                {{-- ACTION --}}
                                <td class="text-center">

                                    @unless($notification->is_read)

                                        <form action="{{ route('doctor.notifications.read', $notification->id) }}"
                                              method="POST">

                                            @csrf

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-success">

                                                Mark Read

                                            </button>

                                        </form>

                                    @else

                                        <span class="text-success">
                                            Done
                                        </span>

                                    @endunless

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center">

                                    No notifications found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">

                {{ $notifications->links() }}

            </div>

        </div>

    </div>

</div>



{{-- NOTIFICATION SOUND --}}
<audio id="notificationSound" preload="auto">
    <source src="{{ asset('sound/notification.mp3') }}" type="audio/mpeg">
</audio>

<script>
(function () {
    const soundKey = 'notification_sound_allowed';
    const audioId = 'notificationSound';
    const unreadCount = Number("{{ $unreadNotifications ?? 0 }}");
    const oldCount = Number(localStorage.getItem('notification_count') || 0);
    const soundEl = document.getElementById(audioId);

    function log() {
        if (window.console && console.log) {
            console.log.apply(console, arguments);
        }
    }

    function warn() {
        if (window.console && console.warn) {
            console.warn.apply(console, arguments);
        }
    }

    function error() {
        if (window.console && console.error) {
            console.error.apply(console, arguments);
        }
    }

    function isAudioAllowed() {
        return localStorage.getItem(soundKey) === 'true';
    }

    function enableAudio() {
        localStorage.setItem(soundKey, 'true');
        log('[notifications] audio enabled');
        primeAudio();
    }

    function primeAudio() {
        if (!soundEl) return;
        try {
            const playPromise = soundEl.play();
            if (playPromise && playPromise.then) {
                playPromise.then(() => {
                    soundEl.pause();
                    soundEl.currentTime = 0;
                    log('[notifications] audio primed');
                }).catch(err => {
                    warn('[notifications] audio prime blocked', err);
                });
            }
        } catch (err) {
            warn('[notifications] audio prime exception', err);
        }
    }

    function playNotificationSound() {
        if (!soundEl) {
            warn('[notifications] audio element not found');
            return;
        }

        if (!isAudioAllowed()) {
            warn('[notifications] cannot play sound until user interaction');
            return;
        }

        soundEl.play()
            .then(() => log('[notifications] sound played'))
            .catch(err => warn('[notifications] sound play failed', err));
    }

    function initSound() {
        log('[notifications] initSound unreadCount=', unreadCount, 'oldCount=', oldCount);

        if (unreadCount > oldCount) {
            playNotificationSound();
        }

        localStorage.setItem('notification_count', String(unreadCount));
    }

    document.addEventListener('click', enableAudio, { once: true });
    document.addEventListener('keydown', enableAudio, { once: true });

    initSound();

    if (window.up && up.on) {
        up.on('up:fragment:inserted', function (event) {
            if (event.target && event.target.querySelector && event.target.querySelector('#' + audioId)) {
                initSound();
            }
        });
    }
})();
</script>

@endsection
