@extends('layouts.admin')

@section('page-title', 'Salary Structure')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h5 class="mb-1">Salary Structure</h5>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('hr.payroll.salary-structure.create') }}" class="btn btn-primary">
            <i class="feather-plus me-1"></i> Add Structure
        </a>

        <a href="{{ route('hr.payroll.salary-structure.deleted') }}" class="btn btn-danger">
            Deleted Records
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
    <th>Name</th>
    <th>Category</th>
    <th>Fixed Allowances</th>
    <th>Variable Allowance</th>
    <th>Residual</th>
    <th>Fixed Deductions</th>
    <th>Variable Deduction</th>
    <th>Hourly Pay</th>
    <th>Overtime</th>
    <th>Status</th>
    <th class="text-end">Actions</th>
</tr>
</thead>

<tbody>
@forelse($records as $item)
<tr>

    <!-- Name -->
    <td>
        <span class="badge bg-soft-primary text-primary">
            {{ $item->salary_structure_name }}
        </span>
    </td>

    <!-- Category -->
    <td>
        <span class="badge bg-soft-info text-info">
            {{ ucfirst($item->structure_category) }}
        </span>
    </td>

    <!-- Fixed Allowances -->
    <td>
        @php
            $allowances = \App\Models\Allowance::whereIn('id', $item->fixed_allowance_components ?? [])->pluck('display_name');
        @endphp
        {{ implode(', ', $allowances->toArray()) }}
    </td>

    <!-- Variable Allowance -->
    <td>
        @if($item->variable_allowance_allowed)
            <span class="text-success">Yes</span>
        @else
            <span class="text-danger">No</span>
        @endif
    </td>

    <!-- Residual -->
    <td>
        {{ optional(\App\Models\Allowance::find($item->residual_component_id))->display_name }}
    </td>

    <!-- Fixed Deductions -->
    <td>
        @php
            $deductions = \App\Models\PayrollDeduction::whereIn('id', $item->fixed_deduction_components ?? [])->pluck('display_name');
        @endphp
        {{ implode(', ', $deductions->toArray()) }}
    </td>

    <!-- Variable Deduction -->
    <td>
        @if($item->variable_deduction_allowed)
            <span class="text-success">Yes</span>
        @else
            <span class="text-danger">No</span>
        @endif
    </td>

    <!-- Hourly -->
    <td>
        @if($item->hourly_pay_eligible)
            <span class="badge bg-soft-success text-success">Yes</span>
        @else
            <span class="badge bg-soft-danger text-danger">No</span>
        @endif
    </td>

    <!-- Overtime -->
    <td>
        @if($item->overtime_eligible)
            <span class="badge bg-soft-success text-success">Yes</span>
        @else
            <span class="badge bg-soft-danger text-danger">No</span>
        @endif
    </td>

    <!-- Status -->
    <td>
        @if($item->status == 'active')
            <span class="badge bg-soft-success text-success">Active</span>
        @else
            <span class="badge bg-soft-danger text-danger">Inactive</span>
        @endif
    </td>

    <!-- Actions (MATCHED STYLE) -->
    <td class="text-end">
        <div class="d-flex gap-2 justify-content-end">

            <!-- View -->
            <a href="{{ route('hr.payroll.salary-structure.show', $item->id) }}"
               class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
               title="View">
                <i class="feather-eye"></i>
            </a>

            <!-- Edit -->
            <a href="{{ route('hr.payroll.salary-structure.edit', $item->id) }}"
               class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
               title="Edit">
                <i class="feather-edit-2"></i>
            </a>

            <!-- Delete -->
            <form action="{{ route('hr.payroll.salary-structure.destroy', $item->id) }}"
                method="POST"
                onsubmit="return confirm('Move to trash?')">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
                        title="Delete">
                    <i class="feather-trash-2"></i>
                </button>
            </form>

        </div>
    </td>

</tr>
@empty
<tr>
    <td colspan="11" class="text-center text-muted">
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