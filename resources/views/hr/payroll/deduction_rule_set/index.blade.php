@extends('layouts.admin')

@section('page-title', 'Deduction Rule Set')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h5 class="mb-1">Deduction Rule Set</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Deduction Rule Set</li>
        </ul>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('hr.payroll.deduction-rule-set.create') }}" class="btn btn-primary">
            <i class="feather-plus me-1"></i> Add Rule
        </a>

        <a href="{{ route('hr.payroll.deduction-rule-set.deleted') }}" class="btn btn-danger">
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
                        <th>Name</th>
                        <th>Category</th>
                        <th>Calculation Type</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rules as $item)
                        <tr>

                            <td>{{ $item->rule_set_code }}</td>

                            <td>
                                <span class="badge bg-soft-primary text-primary">
                                    {{ $item->rule_set_name }}
                                </span>
                            </td>

                            <td>{{ $item->rule_category }}</td>

                            <td>
                                <span class="badge bg-soft-info text-info">
                                    {{ $item->calculation_type }}
                                </span>
                            </td>

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
        <a href="{{ route('hr.payroll.deduction-rule-set.show', $item->id) }}"
           class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
           title="View">
            <i class="feather-eye"></i>
        </a>

        <!-- Edit -->
        <a href="{{ route('hr.payroll.deduction-rule-set.edit', $item->id) }}"
           class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
           title="Edit">
            <i class="feather-edit-2"></i>
        </a>

        <!-- Delete -->
        <form action="{{ route('hr.payroll.deduction-rule-set.delete', $item->id) }}"
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
                            <td colspan="6" class="text-center text-muted">
                                No records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
            <div class="p-3">
    {{ $rules->links() }}
</div>
        </div>

    </div>
</div>

@endsection