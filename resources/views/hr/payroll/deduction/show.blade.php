@extends('layouts.admin')

@section('page-title', 'View Deduction | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        {{-- Page header --}}
        <div class="page-header">
            <div class="page-header d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-5">
                        <i class="feather-eye me-1"></i>
                        View Payroll Deduction
                    </h5>
                    <small class="text-muted">
                        Detailed configuration of the selected deduction.
                    </small>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">HR</li>
                    <li class="breadcrumb-item">Payroll</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('hr.payroll.deduction.index') }}">Deductions</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $deduction->display_name }}
                    </li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('hr.payroll.deduction.edit', $deduction->id) }}" class="btn btn-primary">
                    <i class="feather-edit me-1"></i> Edit
                </a>
                <a href="{{ route('hr.payroll.deduction.index') }}" class="btn btn-light">
                    <i class="feather-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card stretch stretch-full">
                        <div class="card-body">

                            {{-- Basic Details --}}
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold text-uppercase small text-muted">Basic Details</span>
                                    </div>
                                    <i class="feather-info text-muted"></i>
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Deduction Name</label>
                                        <div class="fw-semibold">{{ $deduction->name }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Display Name</label>
                                        <div class="fw-semibold">{{ $deduction->display_name }}</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted">Description / Remarks</label>
                                        <div>{{ $deduction->description ?: '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Classification --}}
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold text-uppercase small text-muted">Deduction
                                            Classification</span>
                                    </div>
                                    <i class="feather-layers text-muted"></i>
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Nature</label>
                                        <div class="fw-semibold">
                                            {{ $deduction->nature === 'FIXED' ? 'Fixed' : 'Variable' }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Category</label>
                                        <div class="fw-semibold">
                                            @if($deduction->category === 'RECURRING')
                                                Recurring (every month)
                                            @else
                                                Ad‑hoc (one time)
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Attendance & Applicability --}}
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold text-uppercase small text-muted">Attendance &
                                            Applicability</span>
                                    </div>
                                    <i class="feather-calendar text-muted"></i>
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">LOP Impact</label>
                                        <div>
                                            @if($deduction->lop_impact === 'YES')
                                                <span class="badge bg-soft-danger text-danger">Yes – reduce for LOP</span>
                                            @else
                                                <span class="badge bg-soft-secondary text-muted">No – ignore LOP</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Prorata Applicable</label>
                                        <div>
                                            @if($deduction->prorata_applicable === 'YES')
                                                <span class="badge bg-soft-info text-info">Yes – DOJ/DOL prorata</span>
                                            @else
                                                <span class="badge bg-soft-secondary text-muted">No – full month amount</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tax & Statutory --}}
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold text-uppercase small text-muted">Tax & Statutory</span>
                                    </div>
                                    <i class="feather-shield text-muted"></i>
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label text-muted">Tax Deductible</label>
                                        <div>
                                            @if($deduction->tax_deductible === 'YES')
                                                <span class="badge bg-soft-success text-success">Yes</span>
                                            @else
                                                <span class="badge bg-soft-secondary text-muted">No</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-muted">PF Impact</label>
                                        <div>
                                            @if($deduction->pf_impact === 'YES')
                                                <span class="badge bg-soft-success text-success">Yes</span>
                                            @else
                                                <span class="badge bg-soft-secondary text-muted">No</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-muted">ESI Impact</label>
                                        <div>
                                            @if($deduction->esi_impact === 'YES')
                                                <span class="badge bg-soft-success text-success">Yes</span>
                                            @else
                                                <span class="badge bg-soft-secondary text-muted">No</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-muted">PT Impact</label>
                                        <div>
                                            @if($deduction->pt_impact === 'YES')
                                                <span class="badge bg-soft-success text-success">Yes</span>
                                            @else
                                                <span class="badge bg-soft-secondary text-muted">No</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Policy & Payslip --}}
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold text-uppercase small text-muted">Policy & Payslip</span>
                                    </div>
                                    <i class="feather-file-text text-muted"></i>
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Rule Set Code</label>
                                        <div>{{ $deduction->rule_set_code ?: '-' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-muted">Show in Payslip</label>
                                        <div>
                                            @if($deduction->show_in_payslip === 'YES')
                                                <span class="badge bg-soft-success text-success">Yes</span>
                                            @else
                                                <span class="badge bg-soft-secondary text-muted">No</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-muted">Payslip Order</label>
                                        <div>{{ $deduction->payslip_order ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Status & Audit --}}
                            <div class="card mb-0 border-0 shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold text-uppercase small text-muted">Status & Audit</span>
                                    </div>
                                    <i class="feather-activity text-muted"></i>
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Status</label>
                                        <div>
                                            @if($deduction->status === 'ACTIVE')
                                                <span class="badge bg-soft-success text-success">Active</span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Created At</label>
                                        <div>{{ $deduction->created_at?->format('d M Y H:i') ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label text-muted">Last Updated</label>
                                        <div>{{ $deduction->updated_at?->format('d M Y H:i') ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Optional side panel for quick info --}}
                <div class="col-lg-4">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <h6 class="mb-3">Summary</h6>
                            <p class="mb-1"><strong>Code:</strong> {{ $deduction->name }}</p>
                            <p class="mb-1"><strong>Display:</strong> {{ $deduction->display_name }}</p>
                            <p class="mb-1">
                                <strong>Type:</strong>
                                {{ $deduction->nature === 'FIXED' ? 'Fixed' : 'Variable' }},
                                {{ $deduction->category === 'RECURRING' ? 'Recurring' : 'Ad‑hoc' }}
                            </p>
                            <p class="mb-0">
                                <strong>Visible in Payslip:</strong>
                                {{ $deduction->show_in_payslip === 'YES' ? 'Yes' : 'No' }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection