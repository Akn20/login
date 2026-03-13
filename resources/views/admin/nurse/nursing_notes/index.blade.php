@extends('layouts.admin')

@section('content')
<div class="nxl-content">

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Nursing Notes</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Nurse</li>
                <li class="breadcrumb-item">Nursing Notes</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.nursing-notes.create') }}" class="btn btn-primary">
                Add Nursing Note
            </a>
        </div>
    </div>


    <!-- Main Content -->
    <div class="main-content">

        <!-- Search Section -->
        <div class="card stretch mb-3">
            <div class="card-body">

                <form action="{{ route('admin.nursing-notes.index') }}" method="GET">

                    <div class="row g-2">

                        <!-- Patient Name -->
                        <div class="col-md-4">
                            
                            <input type="text"
                                   name="patient_name"
                                   class="form-control"
                                   value="{{ request('patient_name') }}"
                                   placeholder="Enter patient name">
                        </div>


                        <!-- Shift -->
                        <div class="col-md-3">

                            <select name="shift" class="form-select">
                                <option value="">Select Shift</option>

                                <option value="Morning"
                                    {{ request('shift') == 'Morning' ? 'selected' : '' }}>
                                    Morning
                                </option>

                                <option value="Evening"
                                    {{ request('shift') == 'Evening' ? 'selected' : '' }}>
                                    Evening
                                </option>

                                <option value="Night"
                                    {{ request('shift') == 'Night' ? 'selected' : '' }}>
                                    Night
                                </option>

                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="col-md-2 d-flex align-items-end gap-2">

                            <button type="submit"
                                    class="btn btn-success w-50">
                                Search
                            </button>

                            <a href="{{ route('admin.nursing-notes.index') }}"
                               class="btn btn-secondary w-50">
                                Reset
                            </a>

                        </div>

                    </div>

                </form>

            </div>
        </div>


        <!-- Table Section -->
        <div class="row">
            <div class="col-lg-12">

                <div class="card stretch stretch-full">
                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover">

                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Patient Name</th>
                                        <th>Shift</th>
                                        <th>Nurse Name</th>
                                        <th>Date & Time</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($nursingNotes as $index => $note)

                                        <tr>

                                            <td>
                                                {{ $nursingNotes->firstItem() + $index }}
                                            </td>

                                            <td>
                                                {{ $note->patient->first_name ?? '-' }}
                                                {{ $note->patient->last_name ?? '' }}
                                            </td>

                                            <td>
                                                {{ $note->shift ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $note->nurse->name ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $note->created_at
                                                    ? $note->created_at->format('d-m-Y h:i A')
                                                    : '-' }}
                                            </td>


                                            <!-- Actions -->
                                            <td class="text-end">

                                                <div class="hstack gap-2 justify-content-end">

                                                    <!-- View -->
                                                    <a href="{{ route('admin.nursing-notes.show', $note->id) }}"
                                                       class="avatar-text avatar-md action-icon action-edit">
                                                        <i class="feather-eye"></i>
                                                    </a>


                                                    <!-- Edit -->
                                                    <a href="{{ route('admin.nursing-notes.edit', $note->id) }}"
                                                       class="avatar-text avatar-md action-icon action-restore">
                                                        <i class="feather-edit"></i>
                                                    </a>


                                                    <!-- Delete -->
                                                    <form action="{{ route('admin.nursing-notes.destroy', $note->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Are you sure you want to delete this nursing note?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-delete border-0 bg-transparent">

                                                            <i class="feather-trash-2"></i>

                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                No nursing notes found.
                                            </td>
                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>


                        <!-- Pagination -->
                        <div class="p-3">
                            {{ $nursingNotes->appends(request()->query())->links() }}
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection