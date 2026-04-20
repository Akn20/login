@extends('layouts.admin')

@section('page-title', 'Deleted Employee Salary Assignments')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h5 class="mb-1">Deleted Records</h5>
    </div>

    <a href="{{ route('hr.payroll.employee-salary-assignment.index') }}" class="btn btn-secondary">
        Back
    </a>
</div>

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

                        <!-- Employee -->
                        <td>
                            <span class="badge bg-soft-primary text-primary">
                                {{ optional($item->employee)->name ?? '-' }}
                            </span>
                        </td>

                        <!-- Structure -->
                        <td>
                            <span class="badge bg-soft-info text-info">
                                {{ optional($item->salaryStructure)->salary_structure_name ?? '-' }}
                            </span>
                        </td>

                        <!-- Salary -->
                        <td>₹ {{ $item->salary_amount }}</td>

                        <!-- Basis -->
                        <td>{{ strtoupper($item->salary_basis) }}</td>

                        <!-- Pay Frequency -->
                        <td>{{ ucfirst($item->pay_frequency) }}</td>

                        <!-- Effective From -->
                        <td>{{ $item->effective_from }}</td>

                        <!-- Status -->
                      <td>
    @if(strtolower($item->status) == 'active')
        <span class="badge bg-soft-success text-success">Active</span>
    @else
        <span class="badge bg-soft-danger text-danger">Inactive</span>
    @endif
</td>

                        <!-- Actions -->
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">

                                <!-- Restore -->
                                <form action="{{ route('hr.payroll.employee-salary-assignment.restore', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-outline-success btn-icon rounded-circle btn-sm"
                                            title="Restore">
                                        <i class="feather-rotate-ccw"></i>
                                    </button>
                                </form>

                                <!-- Permanent Delete -->
                                <form action="{{ route('hr.payroll.employee-salary-assignment.forceDelete', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Permanent delete?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
                                            title="Delete Permanently">
                                        <i class="feather-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No deleted records
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