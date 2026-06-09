@extends('layouts.admin')

@section('title', 'Patient Alerts')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Patient Alerts</h4>

        <a href="{{ route('patient-alerts.create') }}" class="btn btn-primary">
            + Create Alert
        </a>
    </div>
    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <!-- Alerts Table -->
    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Patient Name</th>
                        <th>Alert Type</th>
                        <th>Title</th>
                        <th>Alert Date</th>
                        <th>Read Status</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @if($alerts->count() > 0)

                        @foreach($alerts as $key => $alert)
                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>
                                    {{ $alert->patient->first_name ?? '' }}
                                    {{ $alert->patient->last_name ?? '' }}
                                </td>

                                <td>
                                    {{ ucfirst($alert->alert_type) }}
                                </td>

                                <td>
                                    {{ $alert->title }}
                                </td>

                                <td>
                                    {{ $alert->alert_date
                                        ? \Carbon\Carbon::parse($alert->alert_date)->format('d-m-Y h:i A')
                                        : 'N/A'
                                    }}
                                </td>

                                <td>

                                    @if($alert->is_read)

                                        <span class="badge bg-success">
                                            Read
                                        </span>

                                    @else

                                        <span class="badge bg-primary">
                                            Unread
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a href="{{ route('patient-alerts.show', $alert->id ) }}"
                                        class="btn btn-info btn-sm">

                                        View

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    @else

                        <tr>

                            <td colspan="7" class="text-center">
                                No alerts found.
                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection

