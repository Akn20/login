@extends('layouts.admin')

@section('page-title', 'Payroll Earnings')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>
        <h5 class="mb-1">Payroll Earnings</h5>
    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('hr.payroll.payroll-result-earnings.create') }}"
           class="btn btn-primary">

            <i class="feather-plus me-1"></i>
            Add Earning
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

            <th>Amount</th>

            <th>Status</th>

            <th>Taxable</th>

            <th class="text-end">Actions</th>

        </tr>

    </thead>

    <tbody>

        @forelse($records as $item)

        <tr>

            {{-- PAYROLL MONTH --}}
            <td>

                <span class="badge bg-soft-dark text-dark">

                    {{ $item->payrollResult->payroll_month ?? '-' }}

                </span>

            </td>

            {{-- EMPLOYEE --}}
            <td>

                <span class="badge bg-soft-primary text-primary">

                    {{ $item->payrollResult->staff_id ?? '-' }}

                </span>

            </td>

            {{-- CODE --}}
            <td>

                <span class="badge bg-soft-info text-info">

                    {{ $item->earning_code }}

                </span>

            </td>

            {{-- NAME --}}
            <td>

                {{ $item->earning_name }}

            </td>

            {{-- TYPE --}}
            <td>

                @if($item->earning_type == 'Fixed')

                    <span class="badge bg-soft-success text-success">
                        Fixed
                    </span>

                @elseif($item->earning_type == 'Variable')

                    <span class="badge bg-soft-warning text-warning">
                        Variable
                    </span>

                @else

                    <span class="badge bg-soft-secondary text-secondary">
                        OT
                    </span>

                @endif

            </td>

            {{-- AMOUNT --}}
            <td>

                ₹ {{ number_format($item->amount, 2) }}

            </td>

            {{-- PAYROLL STATUS --}}
            <td>

                @if(($item->payrollResult->status ?? '') == 'Locked')

                    <span class="badge bg-soft-danger text-danger">
                        Locked
                    </span>

                @else

                    <span class="badge bg-soft-success text-success">

                        {{ $item->payrollResult->status ?? '-' }}

                    </span>

                @endif

            </td>

            {{-- TAXABLE --}}
            <td>

                @if($item->taxable)

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
                    <a href="{{ route('hr.payroll.payroll-result-earnings.show', $item->id) }}"
                       class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">

                        <i class="feather-eye"></i>

                    </a>

                    {{-- EDIT --}}
                    @if(($item->payrollResult->status ?? '') != 'Locked')

                    <a href="{{ route('hr.payroll.payroll-result-earnings.edit', $item->id) }}"
                       class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">

                        <i class="feather-edit-2"></i>

                    </a>

                    @endif

                    {{-- DELETE --}}
                    @if(($item->payrollResult->status ?? '') != 'Locked')

                    <form action="{{ route('hr.payroll.payroll-result-earnings.delete', $item->id) }}"
                          method="POST"
                          onsubmit="return confirm('Delete this earning?')">

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
                class="text-center text-muted py-4">

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