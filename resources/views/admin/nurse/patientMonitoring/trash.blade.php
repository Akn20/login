@extends('layouts.admin')

@section('page-title', 'Deleted Vitals | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <div class="page-header">

            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5>Deleted Vitals Records</h5>
                </div>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.patientMonitoring.index') }}" class="btn btn-neutral">
                    Back
                </a>
            </div>

        </div>

        <div class="main-content">

            <div class="card">

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>Sl.No.</th>
                                    <th>Temperature</th>
                                    <th>Pulse</th>
                                    <th>SpO2</th>
                                    <th>Recorded At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($vitals as $index => $vital)

                                    <tr>

                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $vital->temperature }}</td>

                                        <td>{{ $vital->pulse_rate }}</td>

                                        <td>{{ $vital->spo2 }}</td>

                                        <td>{{ \Carbon\Carbon::parse($vital->recorded_at)->format('d-m-Y H:i') }}</td>

                                        <td class="text-end">

                                            <div class="hstack gap-2 justify-content-end">

                                                <a href="{{ route('admin.patientMonitoring.restore', $vital->id) }}"
                                                    class="avatar-text avatar-md action-icon action-restore">

                                                    <i class="feather-refresh-ccw"></i>

                                                </a>

                                                <a href="{{ route('admin.patientMonitoring.forceDelete', $vital->id) }}"
                                                    class="avatar-text avatar-md action-icon action-delete"
                                                    onclick="return confirm('Permanently delete this record?')">

                                                    <i class="feather-trash"></i>

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection