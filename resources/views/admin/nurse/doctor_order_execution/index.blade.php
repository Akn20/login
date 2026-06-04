@extends('layouts.admin')

@section('content')

<div class="container-fluid"><div class="row mb-3">
    <div class="col-md-12">
        <h3>Doctor Order Execution</h3>
        <p class="text-muted">View and Execute Doctor Orders</p>
        @if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    {{ session('success') }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
    </button>

</div>

@endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Doctor Orders</h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Order Type</th>
                        <th>Order Name</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- LAB REQUESTS --}}
                    @foreach($labRequests as $lab)

                    <tr>

                        <td>
                            {{ $lab->patient->first_name ?? '' }}
                            {{ $lab->patient->last_name ?? '' }}
                        </td>

                        <td>
                            <span class="badge bg-soft-info text-info">
                                Lab
                            </span>
                        </td>

                        <td>
                            {{ $lab->test_name }}
                        </td>

                        <td>
                            <span class="badge bg-soft-warning text-warning">
                                {{ $lab->priority }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-soft-secondary text-secondary">
                                {{ $lab->status }}
                            </span>
                        </td>

                        <td class="text-end">

                            <div class="d-flex gap-2 justify-content-end">

                                <a href="{{ route('admin.doctor-order-execution.show', ['id' => $lab->id, 'type' => 'Lab']) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
                                   title="View">
                                    <i class="feather-eye"></i>
                                </a>

                                <button class="btn btn-outline-success btn-icon rounded-circle btn-sm"
                                        title="Execute">
                                    <i class="feather-check-circle"></i>
                                </button>

                                <button class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
                                        title="Escalate">
                                    <i class="feather-alert-triangle"></i>
                                </button>

                            </div>

                        </td>

                    </tr>

                    @endforeach


                    {{-- RADIOLOGY REQUESTS --}}
                    @foreach($scanRequests as $scan)

                    <tr>

                        <td>
                            {{ $scan->patient->first_name ?? '' }}
                            {{ $scan->patient->last_name ?? '' }}
                        </td>

                        <td>
                            <span class="badge bg-soft-primary text-primary">
                                Radiology
                            </span>
                        </td>

                        <td>
                            {{ $scan->scanType->name ?? '-' }}
                        </td>

                        <td>
                            <span class="badge bg-soft-warning text-warning">
                                {{ $scan->priority }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-soft-secondary text-secondary">
                                {{ $scan->status }}
                            </span>
                        </td>

                        <td class="text-end">

                            <div class="d-flex gap-2 justify-content-end">

                                <a href="{{ route('admin.doctor-order-execution.show', ['id' => $scan->id, 'type' => 'Radiology']) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
                                   title="View">
                                    <i class="feather-eye"></i>
                                </a>

                                <button class="btn btn-outline-success btn-icon rounded-circle btn-sm"
                                        title="Execute">
                                    <i class="feather-check-circle"></i>
                                </button>

                                <button class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
                                        title="Escalate">
                                    <i class="feather-alert-triangle"></i>
                                </button>

                            </div>

                        </td>

                    </tr>

                    @endforeach
{{-- MEDICATION ORDERS --}}
@foreach($medications as $medication)

<tr>

    <td>
        {{ $medication->patient->first_name ?? '' }}
        {{ $medication->patient->last_name ?? '' }}
    </td>

    <td>
        <span class="badge bg-soft-success text-success">
            Medication
        </span>
    </td>

    <td>
        {{ $medication->prescriptionItem->medicine->medicine_name ?? '-' }}
    </td>

    <td>
        <span class="badge bg-soft-primary text-primary">
            Normal
        </span>
    </td>

    <td>
        <span class="badge bg-soft-secondary text-secondary">
            {{ $medication->status }}
        </span>
    </td>

    <td class="text-end">

        <div class="d-flex gap-2 justify-content-end">

            <a href="{{ route('admin.doctor-order-execution.show', ['id' => $medication->id]) }}"
               class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
               title="View">
                <i class="feather-eye"></i>
            </a>

            <form action="{{ route('admin.doctor-order-execution.execute', $medication->id) }}"
                  method="POST">
                @csrf

                <button type="submit"
                        class="btn btn-outline-success btn-icon rounded-circle btn-sm"
                        title="Execute">
                    <i class="feather-check-circle"></i>
                </button>
            </form>

            <form action="{{ route('admin.doctor-order-execution.escalate', $medication->id) }}"
                  method="POST">
                @csrf

                <button type="submit"
                        class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
                        title="Escalate">
                    <i class="feather-alert-triangle"></i>
                </button>
            </form>

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
@endsection