@extends('layouts.admin')

@section('page-title', 'Deleted Salary Structures')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h5 class="mb-1">Deleted Salary Structures</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Deleted Records</li>
        </ul>
    </div>

    <a href="{{ route('hr.payroll.salary-structure.index') }}"
       class="btn btn-light">
        Back
    </a>
</div>

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

    <th class="text-end">Actions</th>
</tr>
</thead>

<tbody>
@forelse($records as $row)
<tr>

    <!-- Name -->
    <td>
        <span class="badge bg-soft-primary text-primary">
            {{ $row->salary_structure_name }}
        </span>
    </td>

    <!-- Category -->
    <td>
        <span class="badge bg-soft-info text-info">
            {{ ucfirst($row->structure_category) }}
        </span>
    </td>

    <!-- Fixed Allowances -->
    <td>
        @php
            $allowances = \App\Models\Allowance::whereIn('id', $row->fixed_allowance_components ?? [])->pluck('display_name');
        @endphp
        {{ implode(', ', $allowances->toArray()) }}
    </td>

    <!-- Variable Allowance -->
    <td>
        @if($row->variable_allowance_allowed)
            <span class="text-success">Yes</span>
        @else
            <span class="text-danger">No</span>
        @endif
    </td>

    <!-- Residual -->
    <td>
        {{ optional(\App\Models\Allowance::find($row->residual_component_id))->display_name }}
    </td>

    <!-- Fixed Deductions -->
    <td>
        @php
            $deductions = \App\Models\PayrollDeduction::whereIn('id', $row->fixed_deduction_components ?? [])->pluck('display_name');
        @endphp
        {{ implode(', ', $deductions->toArray()) }}
    </td>

    <!-- Variable Deduction -->
    <td>
        @if($row->variable_deduction_allowed)
            <span class="text-success">Yes</span>
        @else
            <span class="text-danger">No</span>
        @endif
    </td>

    <!-- Hourly -->
    <td>
        @if($row->hourly_pay_eligible)
            <span class="badge bg-soft-success text-success">Yes</span>
        @else
            <span class="badge bg-soft-danger text-danger">No</span>
        @endif
    </td>

    <!-- Overtime -->
    <td>
        @if($row->overtime_eligible)
            <span class="badge bg-soft-success text-success">Yes</span>
        @else
            <span class="badge bg-soft-danger text-danger">No</span>
        @endif
    </td>

 

    <!-- Actions -->
    <td class="text-end">
        <div class="d-flex gap-2 justify-content-end">

            <!-- Restore -->
            <form action="{{ route('hr.payroll.salary-structure.restore', $row->id) }}"
                  method="POST">
                @csrf
                <button type="submit"
                        class="btn btn-outline-success btn-icon rounded-circle btn-sm"
                        title="Restore">
                    <i class="feather-refresh-ccw"></i>
                </button>
            </form>

            <!-- Permanent Delete -->
            <form action="{{ route('hr.payroll.salary-structure.forceDelete', $row->id) }}"
                  method="POST"
                  onsubmit="return confirm('Permanently delete this record?')">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
                        title="Delete Permanently">
                    <i class="feather-trash-2"></i>
                </button>
            </form>

        </div>
    </td>

</tr>
@empty
<tr>
    <td colspan="11" class="text-center text-muted">
        No Deleted Records Found
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