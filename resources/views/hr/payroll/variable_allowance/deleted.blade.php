@extends('layouts.admin')

@section('page-title', 'Deleted Allowances | ' . config('app.name'))
@section('title', 'Deleted Allowances')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h5 class="mb-1">
            <i class="feather-trash-2 me-2"></i>Deleted Variable Allowances
        </h5>

        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Payroll</li>
            <li class="breadcrumb-item">Deleted Variable Allowances</li>
        </ul>
    </div>

    <a href="{{ route('hr.payroll.allowance.index',['type' => 'variable']) }}" class="btn btn-light">
        Back to Allowances
    </a>
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
                        <th>Deleted At</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($allowances as $index => $allowance)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $allowance->name }}</td>

                            <td>{{ $allowance->display_name }}</td>

                            <td>
                                {{ $allowance->deleted_at?->format('d-m-Y H:i') }}
                            </td>

                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">

                                    {{-- RESTORE --}}
                                    <form method="POST"
                                          action="{{ route('hr.payroll.allowance.restore', $allowance->id) }}">
                                        @csrf
                                        <input type="hidden" name="type" value="variable">
                                        <button type="submit"
                                                class="btn btn-outline-success btn-icon rounded-circle"
                                                onclick="return confirm('Restore this allowance?')">
                                            <i class="feather-rotate-ccw"></i>
                                        </button>
                                    </form>

                                    {{-- PERMANENT DELETE --}}
                                    <form method="POST"
                                          action="{{ route('hr.payroll.allowance.forceDelete', $allowance->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="type" value="variable">
                                        <button type="submit"
                                                class="btn btn-outline-danger btn-icon rounded-circle"
                                                onclick="return confirm('Delete permanently? This cannot be undone!')">
                                            <i class="feather-trash "></i> 
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                No deleted allowances found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection