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


                        {{-- STATUS --}}
                        <td>

                            @if($item->signature_status)

                                <span class="badge bg-soft-success text-success">

                                    Signed

                                </span>

                            @else

                                <span class="badge bg-soft-warning text-warning">

                                    Pending

                                </span>

                            @endif

                        </td>


                        {{-- ACTIONS --}}
                        <td class="text-end">

                            <div class="d-flex gap-2 justify-content-end">

                                {{-- VIEW --}}
                                <a href="{{ route(
                                        'doctor.medical-certification.show',
                                        $item->id
                                    ) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">

                                    <i class="feather-eye"></i>

                                </a>


                                @if(!$item->signature_status)

                                {{-- EDIT --}}
                                <a href="{{ route(
                                        'doctor.medical-certification.edit',
                                        $item->id
                                    ) }}"
                                   class="btn btn-outline-primary btn-icon rounded-circle btn-sm">

                                    <i class="feather-edit"></i>

                                </a>


                                {{-- SIGN --}}
                                <form action="{{ route(
                                                'doctor.medical-certification.sign',
                                                $item->id
                                            ) }}"
                                      method="POST">

                                    @csrf

                                    <button type="submit"
                                            class="btn btn-outline-success btn-icon rounded-circle btn-sm">

                                        <i class="feather-check"></i>

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