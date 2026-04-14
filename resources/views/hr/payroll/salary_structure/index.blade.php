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
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $item)
                        <tr>

                            <td>{{ $item->salary_structure_code }}</td>

                            <td>
                                <span class="badge bg-soft-primary text-primary">
                                    {{ $item->salary_structure_name }}
                                </span>
                            </td>

                            <td>{{ ucfirst($item->structure_category) }}</td>

                            <td>
                                @if($item->status == 'active')
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Inactive</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">

                                    <a href="{{ route('hr.payroll.salary-structure.show', $item->id) }}"
                                       class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">
                                        <i class="feather-eye"></i>
                                    </a>

                                    <a href="{{ route('hr.payroll.salary-structure.edit', $item->id) }}"
                                       class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">
                                        <i class="feather-edit-2"></i>
                                    </a>

                                    <form action="{{ route('hr.payroll.salary-structure.delete', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Move to trash?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-outline-danger btn-icon rounded-circle btn-sm">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
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