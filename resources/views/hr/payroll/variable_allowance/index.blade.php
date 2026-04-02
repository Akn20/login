@extends('layouts.admin')

@section('page-title', 'Variable Allowances | ' . config('app.name'))
@section('title', 'Variable Allowances')

@section('content')

    <div class="page-header mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h5><i class="feather-dollar-sign me-2"></i>Variable Allowances</h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">Payroll</li>
                <li class="breadcrumb-item">Variable Allowances</li>
            </ul>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('hr.payroll.allowance.create', ['type' => 'variable']) }}" class="btn btn-primary">
            <i class="feather-plus-circle me-1"></i>
                Add Variable Allowance
            </a>

            <a href="{{ route('hr.payroll.allowance.deleted', ['type' => 'variable']) }}" class="btn btn-danger">
            <i class="feather-trash-2 me-1"></i>
                Deleted Variable Allowance
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($allowances as $index => $allowance)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $allowance->name }}</td>
                            <td>{{ $allowance->display_name }}</td>

                            <td>{{ $allowance->description ?? '-' }}</td>



                            <td>
                                <span class="badge {{ $allowance->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $allowance->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('hr.payroll.allowance.edit', $allowance->id) }}"
                                        class="btn btn-outline-secondary btn-icon rounded-circle" title="Edit">
                                        <i class="feather-edit-2"></i></a>

                                    <form method="POST" action="{{ route('hr.payroll.allowance.destroy', $allowance->id) }}"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-outline-secondary btn-icon rounded-circle"
                                            title="Trash">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No Variable Allowances</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection