@extends('layouts.admin')

@section('page-title', 'Deleted Infection Logs | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <!-- 🔷 Header -->
        <div class="page-header">

            <div class="page-header-left d-flex align-items-center">

                <div class="page-header-title">
                    <h5>Deleted Infection Logs</h5>
                </div>

            </div>

            <div class="page-header-right ms-auto d-flex gap-2">

                <a href="{{ route('admin.infection.index') }}" class="btn btn-neutral">
                    Back
                </a>

            </div>

        </div>

        <!-- 🔷 Content -->
        <div class="main-content">

            <div class="card">

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>Sl.No.</th>
                                    <th>Patient</th>
                                    <th>Infection</th>
                                    <th>Severity</th>
                                    <th>Status</th>
                                    <th>Recorded At</th>

                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($logs as $index => $log)

                                    <tr>

                                        <td>{{ $index + 1 }}</td>

                                        <td>
                                            {{ $log->patient->first_name ?? '' }}
                                            {{ $log->patient->last_name ?? '' }}
                                        </td>

                                        <td>{{ $log->infection_type }}</td>

                                        <td>{{ $log->severity }}</td>

                                        <td>{{ $log->status }}</td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($log->recorded_at)->format('d-m-Y H:i') }}
                                        </td>

                                        <td class="text-end">

                                            <div class="hstack gap-2 justify-content-end">

                                                {{-- Restore --}}
                                                <a href="{{ route('admin.infection.restore', $log->id) }}"
                                                    class="avatar-text avatar-md action-icon action-restore">

                                                    <i class="feather-refresh-ccw"></i>

                                                </a>

                                                {{-- Permanent Delete --}}
                                                <a href="{{ route('admin.infection.forceDelete', $log->id) }}"
                                                    class="avatar-text avatar-md action-icon action-delete"
                                                    onclick="return confirm('Permanent delete?')">

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