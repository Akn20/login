@extends('layouts.admin')

@section('content')

<div class="nxl-content">

<h5>Scan Scheduling</h5>

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- 🔥 SCHEDULING FORM --}}
<div class="card mb-4">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.radiology.schedule.store') }}">
        @csrf

        <div class="row">

            {{-- SELECT REQUEST --}}
            <div class="col-md-4">
                <label>Scan Request</label>
                <select name="scan_request_id" class="form-control" required>
                    <option value="">Select Request</option>

                    @foreach($requests as $req)
                    <option value="{{ $req->id }}">
                        {{ $req->patient->first_name ?? '' }} - {{ $req->body_part }}
                    </option>
                    @endforeach

                </select>
            </div>

            {{-- DATE --}}
            <div class="col-md-4">
                <label>Date</label>
                <input type="date" name="scan_date" class="form-control" required>
            </div>

            {{-- TIME --}}
            <div class="col-md-4">
                <label>Time</label>
                <input type="time" name="scan_time" class="form-control" required>
            </div>

        </div>

        <div class="mt-3">
            <button class="btn btn-primary">Schedule Scan</button>
        </div>

        </form>

    </div>
</div>

{{-- 🔥 PENDING REQUESTS --}}
<div class="card mb-4">
    <div class="card-body">

        <h6>Pending Requests</h6>

        <table class="table table-hover">
           <thead>
<tr>
    <th>Patient</th>
    <th>Body Part</th>
    <th>Status</th>
    <th >Action</th>
</tr>
</thead>

<tbody>
@foreach($requests as $req)
<tr>

    <td>{{ $req->patient->first_name ?? '' }}</td>
    <td>{{ $req->body_part }}</td>

    <td>
        <span class="badge bg-warning">{{ $req->status }}</span>
    </td>

    {{-- 🔥 ONE CLICK BUTTON --}}
    <td class="text-end">

        <form action="{{ route('admin.radiology.schedule.quick') }}" method="POST">
            @csrf
            <input type="hidden" name="scan_request_id" value="{{ $req->id }}">

            <button class="btn btn-sm btn-success">
                📅 Schedule Now
            </button>
        </form>

    </td>

</tr>
@endforeach
</tbody>
        </table>

    </div>
</div>

{{-- 🔥 SCHEDULED LIST --}}
<div class="card">
    <div class="card-body">

        <h6>Scheduled Scans</h6>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Body Part</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($schedules as $key => $s)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ optional($s->request->patient)->first_name }}</td>
                    <td>{{ $s->request->body_part }}</td>
                    <td>{{ $s->scan_date }}</td>
                    <td>{{ $s->scan_time }}</td>

                    {{-- ACTION --}}
                    <td class="text-end">
                        <div class="hstack gap-2 justify-content-end">

                            <a href="{{ route('admin.radiology.schedule.edit', $s->id) }}"
                               class="avatar-text avatar-md action-icon action-edit">
                                <i class="feather-edit"></i>
                            </a>

                            <form action="{{ route('admin.radiology.schedule.delete', $s->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this schedule?')">
                                @csrf
                                @method('DELETE')
                                <button class="avatar-text avatar-md action-icon action-delete">
                                    <i class="feather-trash-2"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No Scheduled Scans</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

</div>

@endsection