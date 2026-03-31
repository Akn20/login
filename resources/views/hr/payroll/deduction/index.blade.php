@extends('layouts.admin')

@section('page-title', 'Payroll Deductions | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Payroll Deductions</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">HR</li>
                    <li class="breadcrumb-item">Payroll</li>
                    <li class="breadcrumb-item">Deductions</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('hr.payroll.deduction.create') }}" class="btn btn-neutral">
                    Add Deduction
                </a>
                <a href="{{ route('hr.payroll.deduction.deleted') }}" class="btn btn-outline-danger">
                    Deleted Records
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
                                            <th>Prorata</th>
                                            <th>Policy</th>
                                            <th>Status</th>
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
                                                        Ad-hoc (One-time)
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($deduction->prorata_applicable === 'YES')
                                                        <span class="badge bg-soft-success text-success">Yes</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">No</span>
                                                    @endif
                                                </td>
                                                <td>{{ $deduction->rule_set_code ?? '-' }}</td>
                                                <td>
                                                    @if($deduction->status === 'ACTIVE')
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                    @endif
                                                </td>

                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        {{-- Show --}}
                                                        <a href="{{ route('hr.payroll.deduction.show', $deduction->id) }}"
                                                            class="avatar-text avatar-md action-icon" title="View">
                                                            <i class="feather-eye"></i>
                                                        </a>

                                                        {{-- Edit --}}
                                                        <a href="{{ route('hr.payroll.deduction.edit', $deduction->id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit" title="Edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        {{-- Delete --}}
                                                        <form
                                                            action="{{ route('hr.payroll.deduction.delete', $deduction->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this deduction?');">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-delete"
                                                                title="Delete">
                                                                <i class="feather-trash-2"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    No deduction records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
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