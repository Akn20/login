
@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                Follow-up Management
            </h4>

            <div class="page-header-right ms-auto d-flex gap-2">


            {{-- Add --}}
            <a href="{{ route('doctor.followups.create') }}" class="btn btn-primary btn-sm">
                <i class="feather-plus me-1"></i> Schedule Follow-up
            </a>

            {{-- Deleted --}}
            <a href="{{ route('doctor.followups.deleted') }}" class="btn btn-danger btn-sm">
                Deleted Follow-ups
            </a>

        </div>


        </div>

        <div class="card-body">

            {{-- SUCCESS MESSAGE --}}
            
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show"
         role="alert">

        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">

        </button>

    </div>

@endif



            {{-- FILTER FORM --}}
            <form method="GET"
                  action="{{ route('doctor.followups.index') }}"
                  class="row mb-4">

                <div class="col-md-3">

                    <input type="text"
                           name="patient_name"
                           class="form-control"
                           placeholder="Search Patient"
                           value="{{ request('patient_name') }}">

                </div>

                <div class="col-md-2">

                    <select name="status"
                            class="form-control">

                        <option value="">
                            All Status
                        </option>

                        <option value="Pending"
                            {{ request('status') == 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="Completed"
                            {{ request('status') == 'Completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="Missed"
                            {{ request('status') == 'Missed' ? 'selected' : '' }}>
                            Missed
                        </option>

                    </select>

                </div>

                <div class="col-md-2">

                    <input type="date"
                           name="from_date"
                           class="form-control"
                           value="{{ request('from_date') }}">

                </div>

                <div class="col-md-2">

                    <input type="date"
                           name="to_date"
                           class="form-control"
                           value="{{ request('to_date') }}">

                </div>

                <div class="col-md-3 d-flex gap-2">
                     <button class="btn btn-light-brand btn-sm">
                    <i class="feather-search"></i>
                </button>
                </div>

            </form>

            {{-- TABLE --}}
            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Patient</th>

                            <th>Doctor</th>

                            <th>Follow-up Date</th>

                            <th>Status</th>

                            <th>Remarks</th>

                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($followUps as $followup)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>

                                    {{ optional($followup->patient)->first_name }}
                                    {{ optional($followup->patient)->last_name }}

                                </td>

                                <td>

                                    {{ optional($followup->doctor)->name }}

                                </td>

                                <td>

                                    {{ \Carbon\Carbon::parse($followup->follow_up_date)->format('d M Y') }}

                                </td>

                                <td>

                                    @if($followup->status == 'Pending')

                                        <span class="badge bg-warning">

                                            Pending

                                        </span>

                                    @elseif($followup->status == 'Completed')

                                        <span class="badge bg-success">

                                            Completed

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Missed

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    {{ $followup->remarks ?? '-' }}

                                </td>

                                <td class="text-end">
                                        <div class="hstack gap-2 justify-content-end">

                                            {{-- View --}}
                                            <a href="{{ route('doctor.followups.show', $followup->id) }}" class="avatar-text avatar-md"
                                                data-bs-toggle="tooltip" title="View">
                                                <i class="feather feather-eye"></i>
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('doctor.followups.edit', $followup->id) }}" class="avatar-text avatar-md"
                                                data-bs-toggle="tooltip" title="Edit">
                                                <i class="feather feather-edit"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('doctor.followups.destroy', $followup->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this follow-up?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" title="Delete">
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                        

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center">

                                    No follow-ups found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">

                {{ $followUps->links() }}

            </div>

        </div>

    </div>

</div>

@endsection

