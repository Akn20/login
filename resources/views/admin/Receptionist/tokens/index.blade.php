@extends('layouts.admin')

@section('content')
<div class="nxl-content">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Token & Queue Management</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Receptionist</li>
                <li class="breadcrumb-item">Token & Queue Management</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.tokens.create') }}" class="btn btn-primary">
                Generate Token
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card stretch stretch-full">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Token No.</th>
                                        <th>Appointment id</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($tokens as $index => $token)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $token->token_number ?? '-' }}</td>
                                            <td>{{ $token->appointment->id ?? '-' }}</td>
                                            <td>
                                                {{ $token->appointment->patient->first_name ?? '-' }}
                                                {{ $token->appointment->patient->last_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $token->appointment->doctor->name ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $token->appointment->department->department_name ?? '-' }}
                                            </td>
                                            <td>
                                                @if(($token->status ?? '') == 'WAITING')
                                                    <span class="badge bg-soft-warning text-warning">Waiting</span>
                                                @elseif(($token->status ?? '') == 'SKIPPED')
                                                    <span class="badge bg-soft-danger text-danger">Skipped</span>
                                                @elseif(($token->status ?? '') == 'COMPLETED')
                                                    <span class="badge bg-soft-success text-success">Completed</span>
                                                @else
                                                    <span class="badge bg-soft-secondary text-secondary">
                                                        {{ $token->status ?? 'N/A' }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="text-end">
                                                <div class="hstack gap-2 justify-content-end">

                                                    <!-- View -->
                                                    <a href="{{ route('admin.tokens.show', $token->id) }}"
                                                       class="avatar-text avatar-md action-icon">
                                                        <i class="feather-eye"></i>
                                                    </a>

                                                    <!-- Reassign -->
                                                    <a href="{{ route('admin.tokens.edit', $token->id) }}"
                                                       class="avatar-text avatar-md action-icon action-edit">
                                                        <i class="feather-repeat"></i>
                                                    </a>

                                                    <!-- Skip -->
                                                    @if(($token->status ?? '') == 'WAITING')
                                                        <form action="{{ route('admin.tokens.skip', $token->id) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Are you sure you want to skip this token?')">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                    class="avatar-text avatar-md action-icon action-delete">
                                                                <i class="feather-skip-forward"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <!-- Complete -->
                                                    @if(($token->status ?? '') != 'COMPLETED')
                                                        <form action="{{ route('admin.tokens.complete', $token->id) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Are you sure you want to complete this token?')">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                    class="avatar-text avatar-md action-icon">
                                                                <i class="feather-check-circle"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                No token records found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection