@extends('layouts.admin')

@section('page-title', 'Statutory Deduction')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h5 class="mb-1">Statutory Deduction</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Statutory Deduction</li>
        </ul>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('hr.payroll.statutory-deduction.create') }}" class="btn btn-primary">
            <i class="feather-plus me-1"></i> Add Deduction
        </a>

        <a href="{{ route('hr.payroll.statutory-deduction.deleted') }}" class="btn btn-danger">
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
                        <th>Code</th>
                        <th>Rule Set</th>
                        <th>Category</th>
                        <th>Compliance head</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $item)
                        <tr>

                            <td>{{ $item->statutory_code }}</td>

                            <td>
                                <span class="badge bg-soft-primary text-primary">
                                    {{ $item->ruleSet->rule_set_name ?? '-' }}
                                </span>
                            </td>

                            <td>{{ $item->statutory_category }}</td>

                            <td>{{ $item->compliance_head }}</td>

                            <td>
                                @if($item->status == 'active')
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Inactive</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">

                                    <!-- View -->
                                    <a href="{{ route('hr.payroll.statutory-deduction.show', $item->id) }}"
                                       class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">
                                        <i class="feather-eye"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('hr.payroll.statutory-deduction.edit', $item->id) }}"
                                       class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">
                                        <i class="feather-edit-2"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('hr.payroll.statutory-deduction.destroy', $item->id) }}"
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
                            <td colspan="6" class="text-center text-muted">
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