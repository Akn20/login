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
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $item)
                    <tr>

                        <td>{{ optional($item->employee)->name ?? '-' }}</td>

                        <td>{{ optional($item->salaryStructure)->salary_structure_name ?? '-' }}</td>

                        <td>₹ {{ $item->salary_amount }}</td>

                        <td>
                            <span class="badge bg-soft-danger text-danger">
                                Deleted
                            </span>
                        </td>

                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">

                                <!-- Restore -->
                                <form action="{{ route('hr.payroll.employee-salary-assignment.restore', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-success btn-icon rounded-circle btn-sm">
                                        <i class="feather-rotate-ccw"></i>
                                    </button>
                                </form>

                                <!-- Force Delete -->
                                <form action="{{ route('hr.payroll.employee-salary-assignment.forceDelete', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Permanent delete?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-outline-danger btn-icon rounded-circle btn-sm">
                                        <i class="feather-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
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