@extends('layouts.admin')

@section('content')

<div class="page-header d-flex align-items-center">
    <h5 class="me-3">Critical Alerts</h5>
</div>

<div class="card">
    <div class="card-body">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sample</th>
                    <th>Parameter</th>
                    <th>Value</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($alerts as $alert)
                    <tr class="{{ $alert->status == 'Pending' ? 'table-danger' : '' }}">

                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($alert->report->sample)->sample_id ?? '-' }}</td>
                        <td>{{ $alert->parameter_name }}</td>
                        <td>{{ $alert->value }}</td>

                        <td>
                            <span class="badge bg-{{ $alert->status == 'Pending' ? 'danger' : 'success' }}">
                                {{ $alert->status }}
                            </span>
                        </td>

                        <td>
                            @if($alert->status == 'Pending')
                                <form method="POST" action="{{ route('admin.laboratory.alerts.ack', $alert->id) }}">
                                    @csrf
                                    <button class="btn btn-success btn-sm">
                                        Acknowledge
                                    </button>
                                </form>
                            @else
                                <span class="text-success">Done</span>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No Alerts Found</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@endsection