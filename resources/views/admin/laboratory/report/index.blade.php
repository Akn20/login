@extends('layouts.admin')

@section('content')

    <div class="page-header d-flex align-items-center">

        <h5 class="me-3">Reports</h5>

        <!-- SEARCH -->
        <form method="GET" class="d-flex ms-auto me-2">
            <input type="text" name="search" class="form-control" placeholder="Search Report..."
                value="{{ request('search') }}">
            <button class="btn btn-light ms-1">
                <i class="feather-search"></i>
            </button>
        </form>

        <!-- NEW BUTTON -->
        <a href="{{ route('admin.laboratory.report.create') }}" class="btn btn-primary me-2">
            <i class="feather-plus"></i> New Report
        </a>

        <!-- DELETED BUTTON -->
        <a href="{{ route('admin.laboratory.report.deleted') }}" class="btn btn-danger">
            Deleted Reports
        </a>

    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sample</th>
                        <th>Status</th>
                        <th>Verification</th>
                        <th>Uploaded At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $report->sample->sample_id ?? '-' }}</td>
                            <td>{{ $report->status }}</td>
                            <td>
                                @php
                                    $status = $report->verification_status ?? 'Pending';

                                    $colors = [
                                        'Pending' => 'warning',
                                        'Verified' => 'success',
                                        'Rejected' => 'danger',
                                        'Finalized' => 'primary',
                                    ];
                                @endphp

                                <span class="badge bg-{{ $colors[$status] ?? 'secondary' }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td>{{ $report->created_at->format('d M Y H:i') }}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- VIEW -->
                                    <a href="{{ route('admin.laboratory.report.show', $report->id) }}"
                                        class="btn btn-outline-primary btn-icon rounded-circle">
                                        <i class="feather-eye"></i>
                                    </a>

                                    <!-- UPLOAD MORE -->
                                    @if($report->verification_status !== 'Finalized')
                                        <a href="{{ route('admin.laboratory.report.edit', $report->id) }}"
                                            class="btn btn-outline-success btn-icon rounded-circle">
                                            <i class="feather-edit"></i>
                                        </a>
                                    @endif

                                    <!-- DELETE -->
                                    <form method="POST" action="{{ route('admin.laboratory.report.destroy', $report->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-icon rounded-circle">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No Reports Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

@endsection