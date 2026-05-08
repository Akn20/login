@extends('layouts.admin')

@section('page-title', 'Payroll Deductions')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>
        <h5 class="mb-1">Payroll Deductions</h5>
    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('hr.payroll.payroll-result-deductions.create') }}"
           class="btn btn-primary">

            <i class="feather-plus me-1"></i>
            Add Deduction

        </a>

    </div>

</div>


@if(session('success'))

<div class="alert alert-success">
    {{ session('success') }}
</div>

@endif


@if(session('error'))

<div class="alert alert-danger">
    {{ session('error') }}
</div>

@endif


<div class="card">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th>Payroll Month</th>

                        <th>Employee</th>

                        <th>Code</th>

                        <th>Name</th>

                        <th>Type</th>

                        <th>Logic</th>

                        <th>Amount</th>

                        <th>Editable</th>

                        <th class="text-end">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($records as $item)

                    <tr>

                        {{-- PAYROLL MONTH --}}
                        <td>

                            <span class="badge bg-soft-dark text-dark">

                                {{ optional($item->payrollResult)->payroll_month ?? '-' }}

                            </span>

                        </td>


                        {{-- EMPLOYEE --}}
                        <td>

                            <span class="badge bg-soft-primary text-primary">

                                {{ optional(optional($item->payrollResult)->employee)->name ?? optional($item->payrollResult)->staff_id ?? '-' }}

                            </span>

                        </td>


                        {{-- CODE --}}
                        <td>

                            <span class="badge bg-soft-info text-info">

                                {{ $item->deduction_code }}

                            </span>

                        </td>


                        {{-- NAME --}}
                        <td>

                            {{ $item->deduction_name }}

                        </td>


                        {{-- TYPE --}}
                        <td>

                            @if($item->deduction_type == 'Fixed')

                                <span class="badge bg-soft-success text-success">
                                    Fixed
                                </span>

                            @elseif($item->deduction_type == 'Variable')

                                <span class="badge bg-soft-warning text-warning">
                                    Variable
                                </span>

                            @else

                                <span class="badge bg-soft-danger text-danger">
                                    Statutory
                                </span>

                            @endif

                        </td>


                        {{-- LOGIC --}}
                        <td>

                            {{ $item->calculation_logic ?? '-' }}

                        </td>


                        {{-- AMOUNT --}}
                        <td>

                            ₹ {{ number_format($item->amount, 2) }}

                        </td>


                        {{-- EDITABLE --}}
                        <td>

                            @if($item->editable_flag)

                                <span class="badge bg-soft-success text-success">
                                    Yes
                                </span>

                            @else

                                <span class="badge bg-soft-danger text-danger">
                                    No
                                </span>

                            @endif

                        </td>


                        {{-- ACTIONS --}}
                        <td class="text-end">

                            <div class="d-flex gap-2 justify-content-end">

                                {{-- VIEW --}}
                                <a href="{{ route('hr.payroll.payroll-result-deductions.show', $item->id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">

                                    <i class="feather-eye"></i>

                                </a>


                                {{-- EDIT --}}
                                @if(
                                    $item->editable_flag &&
                                    optional($item->payrollResult)->status !== 'finalized'
                                )

                                <a href="{{ route('hr.payroll.payroll-result-deductions.edit', $item->id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">

                                    <i class="feather-edit-2"></i>

                                </a>

                                @else

                                <button class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
                                        disabled>

                                    <i class="feather-lock"></i>

                                </button>

                                @endif


                                {{-- DELETE --}}
                                @if(optional($item->payrollResult)->status !== 'finalized')

                                <form action="{{ route('hr.payroll.payroll-result-deductions.delete', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this deduction?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-outline-danger btn-icon rounded-circle btn-sm">

                                        <i class="feather-trash-2"></i>

                                    </button>

                                </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9"
                            class="text-center text-muted">

                            No records found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

            <div class="p-3">

                {{ $records->links() }}

            </div>

        </div>

    </div>

</div>

@endsection