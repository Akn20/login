@extends('layouts.admin')

@section('page-title', 'Deleted Deductions | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Deleted Payroll Deductions</h5>
                    <small class="text-muted">
                        Soft-deleted deduction records. You can restore or permanently delete them from here.
                    </small>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">HR</li>
                    <li class="breadcrumb-item">Payroll</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('hr.payroll.deduction.index') }}">Deductions</a>
                    </li>
                    <li class="breadcrumb-item active">Deleted</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('hr.payroll.deduction.index') }}" class="btn btn-light">
                    <i class="feather-arrow-left me-1"></i> Back to Active
                </a>
            </div>
        </div>

        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Display Name</th>
                                            <th>Nature</th>
                                            <th>Category</th>
                                            <th>Policy</th>
                                            <th>Deleted At</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($deductions as $i => $deduction)
                                            <tr>
                                                <td>{{ $deductions->firstItem() + $i }}</td>
                                                <td class="fw-semibold">{{ $deduction->display_name }}</td>
                                                <td>{{ $deduction->nature === 'FIXED' ? 'Fixed' : 'Variable' }}</td>
                                                <td>
                                                    @if($deduction->category === 'RECURRING')
                                                        Recurring
                                                    @else
                                                        Ad‑hoc (One-time)
                                                    @endif
                                                </td>
                                                <td>{{ $deduction->rule_set_code ?? '-' }}</td>
                                                <td>{{ $deduction->deleted_at?->format('d M Y H:i') ?? '-' }}</td>
                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        {{-- Restore --}}
                                                       <form action="{{ route('hr.payroll.deduction.restore', $deduction->id) }}"
                                                            method="POST">

                                                            @csrf
                                                            @method('PUT')

                                                            <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-edit"
                                                                title="Restore">
                                                                <i class="feather-rotate-ccw"></i>
                                                            </button>

                                                        </form>

                                                        {{-- Force Delete --}}
                                                        <form
                                                            action="{{route('hr.payroll.deduction.force-delete', $deduction->id)  }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('This will permanently delete the deduction. Continue?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-delete"
                                                                title="Delete Permanently">
                                                                <i class="feather-trash-2"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    No deleted deductions found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $deductions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection