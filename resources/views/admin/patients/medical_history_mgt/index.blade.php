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

            <div class="row align-items-end">

                <div class="col-md-8 mb-3">
                    <label class="form-label">Patient Name / UHID / Mobile</label>
                    <input type="text"
                           class="form-control"
                           placeholder="Search by Patient Name, UHID or Mobile">
                </div>

                <div class="col-md-2 mb-3">
                    <button type="button" class="btn btn-primary w-100">
                        <i class="feather-search"></i> Search
                    </button>
                </div>

                <div class="col-md-2 mb-3">
                    <button type="reset" class="btn btn-light w-100">
                        Reset
                    </button>
                </div>

            </div>

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

                        {{-- Dummy Data For UI Testing --}}

                        <tr>
                            <td>P0001</td>
                            <td>Lavanya K</td>
                            <td>9876543210</td>
                            <td>Female</td>
                            <td>
                      <a href="{{ route('admin.patients.medical-history.show', 'fff4099b-1eac-11f1-abc1-0fdc22170dfb') }}"
   class="btn btn-sm btn-primary">
    View Medical History
</a>
                            </td>
                        </tr>

                        <tr>
                            <td>P0002</td>
                            <td>Lavanya Rao</td>
                            <td>9988776655</td>
                            <td>Female</td>
                            <td>
                               <a href="{{ route('admin.patients.medical-history.show', 1) }}"
   class="btn btn-sm btn-primary">
    View Medical History
</a>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection