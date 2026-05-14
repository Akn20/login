@extends('layouts.admin')

@section('page-title', 'Employee Salary Assignment')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h5 class="mb-1">Employee Salary Assignment</h5>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('hr.payroll.employee-salary-assignment.create') }}" class="btn btn-primary">
            <i class="feather-plus me-1"></i> Add Assignment
        </a>

        <a href="{{ route('hr.payroll.employee-salary-assignment.deleted') }}" class="btn btn-danger">
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
                        <th>Employee</th>
                        <th>Structure</th>
                        <th>Salary</th>
                        <th>Basis</th>
                        <th>Pay Frequency</th>
                        <th>Effective From</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $item)
                    <tr>

                        <td>
                            <span class="badge bg-soft-primary text-primary">
                                {{ optional($item->employee)->name ?? '-' }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-soft-info text-info">
                                {{ optional($item->salaryStructure)->salary_structure_name ?? '-' }}
                            </span>
                        </td>

                        <td>₹ {{ $item->salary_amount }}</td>

                        <td>{{ strtoupper($item->salary_basis) }}</td>

                        <td>{{ ucfirst($item->pay_frequency) }}</td>

                        <td>{{ $item->effective_from }}</td>

                        <td>
                            @if($item->status == 'active')
                                <span class="badge bg-soft-success text-success">Active</span>
                            @else
                                <span class="badge bg-soft-danger text-danger">Inactive</span>
                            @endif
                        </td>

                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">

                                <a href="{{ route('hr.payroll.employee-salary-assignment.show', $item->id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">
                                    <i class="feather-eye"></i>
                                </a>

                                <a href="{{ route('hr.payroll.employee-salary-assignment.edit', $item->id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">
                                    <i class="feather-edit-2"></i>
                                </a>

                                <form action="{{ route('hr.payroll.employee-salary-assignment.delete', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Move to trash?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-outline-danger btn-icon rounded-circle btn-sm">
                                        <i class="feather-trash-2"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
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