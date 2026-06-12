@extends('layouts.admin')

@section('page-title', 'Medical Certifications')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>

        <h5 class="mb-1">
            Medical Certifications
        </h5>

    </div>

    <div>

        <a href="{{ route('doctor.medical-certification.create') }}"
           class="btn btn-primary">

            <i class="feather-plus me-1"></i>

            Add Certificate

        </a>

    </div>

</div>


@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif
<form method="GET"
      action="{{ route('doctor.medical-certification.index') }}">

<div class="card mb-4">

<div class="card-body">

<div class="row">

    {{-- EMPLOYEE NAME --}}
    <div class="col-md-4 mb-3">

        <label>Employee Name</label>

        <input type="text"
               name="employee_name"
               class="form-control"
               value="{{ request('employee_name') }}">

    </div>

    {{-- CERTIFICATE TYPE --}}
    <div class="col-md-3 mb-3">

        <label>Certificate Type</label>

        <select name="certificate_type"
                class="form-control">

            <option value="">All</option>

            <option value="Sick Leave"
                {{ request('certificate_type') == 'Sick Leave' ? 'selected' : '' }}>

                Sick Leave

            </option>

            <option value="Fitness"
                {{ request('certificate_type') == 'Fitness' ? 'selected' : '' }}>

                Fitness

            </option>

            <option value="Insurance"
                {{ request('certificate_type') == 'Insurance' ? 'selected' : '' }}>

                Insurance

            </option>

        </select>

    </div>

    {{-- STATUS --}}
    <div class="col-md-3 mb-3">

        <label>Status</label>

        <select name="status"
                class="form-control">

            <option value="">All</option>

            <option value="Draft"
                {{ request('status') == 'Draft' ? 'selected' : '' }}>

                Draft

            </option>

            <option value="Signed"
                {{ request('status') == 'Signed' ? 'selected' : '' }}>

                Signed

            </option>

            <option value="Cancelled"
                {{ request('status') == 'Cancelled' ? 'selected' : '' }}>

                Cancelled

            </option>

            <option value="Expired"
                {{ request('status') == 'Expired' ? 'selected' : '' }}>

                Expired

            </option>

        </select>

    </div>

    {{-- BUTTONS --}}
    <div class="col-md-2 d-flex align-items-end gap-2 mb-3">

        {{-- SEARCH --}}
        <button class="btn btn-primary w-100">

            Search

        </button>

        {{-- RESET --}}
        <a href="{{ route('doctor.medical-certification.index') }}"
           class="btn btn-secondary w-100">

            Reset

        </a>

    </div>

</div>

</div>

</div>

</form>

<div class="card">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th>Certificate No</th>

                        <th>Employee</th>

                        <th>Department</th>

                        <th>Certificate Type</th>

                        <th>Issue Date</th>

                        <th>Status</th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($records as $item)

                    <tr>

                        {{-- CERTIFICATE NUMBER --}}
                        <td>

                            <span class="badge bg-soft-primary text-primary">

                                {{ $item->certificate_number }}

                            </span>

                        </td>


                        {{-- EMPLOYEE --}}
                        <td>

                            {{ $item->employee_name }}

                        </td>


                        {{-- DEPARTMENT --}}
                        <td>

                            {{ $item->department }}

                        </td>


                        {{-- TYPE --}}
                        <td>

                            <span class="badge bg-soft-info text-info">

                                {{ $item->certificate_type }}

                            </span>

                        </td>


                        {{-- ISSUE DATE --}}
                        <td>

                            {{ $item->issue_date }}

                        </td>


                      <td>
                        {{--STATUS--}}

    @if($item->status == 'Signed')

        <span class="badge bg-soft-success text-success">

            Signed

        </span>

    @elseif($item->status == 'Cancelled')

        <span class="badge bg-soft-danger text-danger">

            Cancelled

        </span>

    @elseif($item->status == 'Expired')

        <span class="badge bg-soft-dark text-dark">

            Expired

        </span>

    @else

        <span class="badge bg-soft-warning text-warning">

            Draft

        </span>

    @endif

</td>

<td class="text-end">

    <div class="d-flex gap-2 justify-content-end">

        {{-- VIEW --}}
        <a href="{{ route(
                'doctor.medical-certification.show',
                $item->id
            ) }}"
           class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
           title="View">

            <i class="feather-eye"></i>

        </a>


        {{-- EDIT --}}
        @if(
            !$item->signature_status
            &&
            $item->status != 'Cancelled'
            &&
            $item->status != 'Expired'
        )

        <a href="{{ route(
                'doctor.medical-certification.edit',
                $item->id
            ) }}"
           class="btn btn-outline-primary btn-icon rounded-circle btn-sm"
           title="Edit">

            <i class="feather-edit"></i>

        </a>

        @endif



        {{-- SIGN --}}
        @if(
            !$item->signature_status
            &&
            $item->status != 'Cancelled'
            &&
            $item->status != 'Expired'
        )

        <form action="{{ route(
                        'doctor.medical-certification.sign',
                        $item->id
                    ) }}"
              method="POST">

            @csrf

            <button type="submit"
                    class="btn btn-outline-success btn-icon rounded-circle btn-sm"
                    title="Sign">

                <i class="feather-check"></i>

            </button>

        </form>

        @endif



        {{-- CANCEL --}}
        @if(
            $item->status != 'Cancelled'
            &&
            $item->status != 'Expired'
        )

        <form action="{{ route(
                        'doctor.medical-certification.cancel',
                        $item->id
                    ) }}"
              method="POST">

            @csrf

            <button type="submit"
                    class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
                    title="Cancel">

                <i class="feather-x"></i>

            </button>

        </form>

        @endif

    </div>

</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7"
                            class="text-center text-muted">

                            No records found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection