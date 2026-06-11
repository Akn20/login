@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">Medical History Management</h3>

    {{-- Search Patient --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">Search Patient</h5>
        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.patients.medical-history') }}">

                <div class="row align-items-end">

                    <div class="col-md-8 mb-3">

                        <label class="form-label">
                            Patient Name / UHID / Mobile
                        </label>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="Search by Patient Name, UHID or Mobile">

                    </div>

                    <div class="col-md-2 mb-3">

                        <button type="submit"
                                class="btn btn-primary w-100">

                            <i class="feather-search"></i> Search

                        </button>

                    </div>

                    <div class="col-md-2 mb-3">

                        <a href="{{ route('admin.patients.medical-history') }}"
                           class="btn btn-light w-100">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Matching Patients --}}
    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">Matching Patients</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>
                        <tr>
                            <th>UHID</th>
                            <th>Patient Name</th>
                            <th>Mobile</th>
                            <th>Gender</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                       @if(request('search'))

        @forelse($patients as $patient)

                            <tr>

                                <td>{{ $patient->patient_code }}</td>

                                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>

                                <td>{{ $patient->mobile }}</td>

                                <td>{{ $patient->gender }}</td>

                                <td>

                                    <a href="{{ route(
                                        'admin.patients.medical-history.show',
                                        $patient->id
                                    ) }}"
                                       class="btn btn-sm btn-primary">

                                        View Medical History

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center">

                                    No patients found

                                </td>

                            </tr>

                        @endforelse

                        @endif

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection