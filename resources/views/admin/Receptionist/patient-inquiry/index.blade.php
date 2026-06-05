@extends('layouts.admin')

@section('content')

<div class="container">

    <h3 class="mb-4">
        Patient Search & Inquiry
    </h3>

   <div class="row">

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET"
                      action="{{ route('admin.patient-inquiry.search.uhid') }}">

                    <label class="fw-bold">
                        Search By UHID
                    </label>

                    <input type="text"
                           name="uhid"
                           class="form-control mb-2"
                           placeholder="Enter UHID">

                    <button class="btn btn-primary w-100">
                        Search
                    </button>

                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET"
                      action="{{ route('admin.patient-inquiry.search.mobile') }}">

                    <label class="fw-bold">
                        Search By Mobile
                    </label>

                    <input type="text"
                           name="mobile"
                           class="form-control mb-2"
                           placeholder="Enter Mobile Number">

                    <button class="btn btn-success w-100">
                        Search
                    </button>

                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET"
                      action="{{ route('admin.patient-inquiry.search.name') }}">

                    <label class="fw-bold">
                        Search By Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control mb-2"
                           placeholder="Enter Patient Name">

                    <button class="btn btn-info w-100">
                        Search
                    </button>

                </form>
            </div>
        </div>
    </div>

</div>

@if(isset($patients))

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        Search Results
    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover align-middle">

            <thead class="text-center">
                <tr>
                    <th>UHID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Registration Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody class="text-center">

            @forelse($patients as $patient)

                <tr>

                    <td>{{ $patient->patient_code }}</td>

                    <td>
                        {{ $patient->first_name }}
                        {{ $patient->last_name }}
                    </td>

                    <td>{{ $patient->mobile }}</td>

                    <td>{{ $patient->gender }}</td>

                    <td>{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</td>
                    <td>
                        {{ $patient->created_at->format('d M Y') }}
                    </td>
                    <td>
                        @if($patient->status==1)
                            <span class="badge bg-success">
                                Active
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Inactive
                            </span>
                        @endif

                    </td>
                    <td class="text-center">
    <div class="hstack gap-2 justify-content-center">

        {{-- View --}}
        <a href="{{ route('admin.patient-inquiry.show', $patient->id) }}"
           class="avatar-text avatar-md"
           data-bs-toggle="tooltip"
           title="View">
            <i class="feather feather-eye"></i>
        </a>

        {{-- Visit History --}}
        <a href="{{ route('admin.patient-inquiry.visit-history', $patient->id) }}"
           class="avatar-text avatar-md"
           data-bs-toggle="tooltip"
           title="Visit History">
            <i class="feather feather-activity"></i>
        </a>

    </div>
</td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="text-center text-danger">
                        No Records Found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endif

</div>

@endsection