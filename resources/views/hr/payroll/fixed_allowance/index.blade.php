@extends('layouts.admin')

@section('page-title', 'Fixed Allowances | ' . config('app.name'))
@section('title', 'Fixed Allowances')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1">
                <i class="feather-plus-circle me-2"></i>Fixed Allowances
            </h5>
            <ul class="breadcrumb mb-0">

                <li class="breadcrumb-item">Payroll</li>
                <li class="breadcrumb-item">Fixed Allowances</li>
            </ul>
        </div>

        <div class="d-flex gap-2 align-items-center">

            {{-- Filter --}}
            <form method="GET" action="{{ route('hr.payroll.allowance.index') }}" class="d-flex">
                <input type="hidden" name="type" value="fixed">
                <select name="frequency" class="form-control form-control-sm me-2">
                    <option value="">All Frequency</option>
                    <option value="monthly" {{ request('frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ request('frequency') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>

                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search Allowance"
                    value="{{ request('search') }}">

                <button class="btn btn-light-brand btn-sm">
                    <i class="feather-search"></i>
                </button>
            </form>

            <a href="{{ route('hr.payroll.allowance.create', ['type' => 'fixed']) }}" class="btn btn-primary">
                <i class="feather-plus me-1"></i> Add Fixed Allowance
            </a>

            <a href="{{ route('hr.payroll.allowance.deleted', ['type' => 'fixed']) }}" class="btn btn-danger">
                <i class="feather-trash me-1"></i> Deleted Fixed Allowance
            </a>
        </div>
    </div>

    <div class="card stretch stretch-full">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Display Name</th>
                            <th>Calculation</th>
                            <th>Frequency</th>
                            <th>Prorata</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($allowances->count())
                            @foreach ($allowances as $index => $allowance)
                                <tr>
                                    <td>
                                        {{ $allowances->firstItem() ? $allowances->firstItem() + $index : $index + 1 }}
                                    </td>

                                    <td>{{ $allowance->name }}</td>

                                    <td>{{ $allowance->display_name }}</td>

                                    <td>{{ ucfirst($allowance->calculation_type) }}</td>

                                    <td>{{ ucfirst($allowance->pay_frequency) }}</td>

                                    <td>
                                        {{ $allowance->prorata ? 'Yes' : 'No' }}
                                    </td>

                                    <td>
                                        @if ($allowance->status)
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">

                                            <a href="{{ route('hr.payroll.allowance.edit', $allowance->id) }}"
                                                class="btn btn-outline-secondary btn-icon rounded-circle" title="Edit">
                                                <i class="feather-edit-2"></i>
                                            </a>

                                            <form action="{{ route('hr.payroll.allowance.destroy', $allowance->id) }}" method="POST"
                                                onsubmit="return confirm('Move to trash?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-outline-secondary btn-icon rounded-circle"
                                                    title="Trash">
                                                    <i class="feather-trash-2"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">No Allowances Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($allowances->hasPages())
                <div class="mt-3 px-3 pb-3">
                    {{ $allowances->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection