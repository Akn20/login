@extends('layouts.admin')

@section('page-title', 'Patients | ' . config('app.name'))

@section('content')

<!-- Page Header -->
<div class="page-header mb-4">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-0">Patients</h5>
        </div>

        <ul class="breadcrumb ms-3">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.patients.index') }}">Patients</a>
            </li>
            <li class="breadcrumb-item">List</li>
        </ul>
    </div>

    <div class="page-header-right ms-auto d-flex align-items-center gap-2">

        <!-- Search -->
        <form method="GET" action="{{ route('admin.patients.index') }}" class="d-flex">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Search Patient..."
                   style="width: 220px;">

            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>
        </form>

        <!-- Add Button -->
        <a href="{{ route('admin.patients.create') }}" class="btn btn-primary">
            <i class="feather-plus me-2"></i> New Patient
        </a>

        <!-- Deleted Button -->
        <a href="{{ route('admin.patients.deleted') }}" class="btn btn-danger">
            Deleted Patients
        </a>

    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card stretch stretch-full">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Patient Code</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Gender</th>
                                <th>VIP</th>
                                <th>Status</th>
                                <th class="text-center" style="width:120px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        @if ($patients->count())
                            @foreach ($patients as $index => $patient)
                                <tr>
                                    <td>{{ $patients->firstItem() ? $patients->firstItem() + $index : $index + 1 }}</td>

                                    <td>{{ $patient->patient_code }}</td>

                                    <td>
                                        <div class="fw-bold">
                                            {{ $patient->first_name }} {{ $patient->last_name }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $patient->email ?? '-' }}
                                        </small>
                                    </td>

                                    <td>{{ $patient->mobile }}</td>

                                    <td>{{ ucfirst($patient->gender) }}</td>

                                    <!-- VIP Toggle -->
                                    <td>
                                       @include('partials.status-toggle', [
                                        'id'      => $patient->id,
                                        'url'     => route('admin.patients.toggleVip', $patient->id),
                                        'checked' => (bool) $patient->is_vip,
                                        'type'    => 'vip'
                                    ])
                                    </td>   

                                    <!-- STATUS Toggle -->
                                    <td>
                                        @include('partials.status-toggle', [
                                        'id' => $patient->id,
                                        'url' => route('admin.patients.toggleStatus', $patient->id),
                                        'checked' => (bool) $patient->status,
                                        'type' => 'status'
                                    ])
                                    </td>

                                    <!-- ACTIONS -->
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 align-items-center">

                                            <!-- View -->
                                            <a href="{{ route('admin.patients.show', $patient->id) }}"
                                            class="btn btn-outline-secondary btn-icon rounded-circle"
                                            title="View">
                                                <i class="feather-eye"></i>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('admin.patients.edit', $patient->id) }}"
                                            class="btn btn-outline-secondary btn-icon rounded-circle"
                                            title="Edit">
                                                <i class="feather-edit-2"></i>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('admin.patients.destroy', $patient->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Move patient to trash?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip"
                                                    title="Trash">
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center">No Patients Found</td>
                            </tr>
                        @endif
                        </tbody>

                    </table>
                </div>

            </div>

            <div class="card-footer">
                {{ $patients->links() }}
            </div>

        </div>
    </div>
</div>

@endsection