@extends('layouts.admin')

@section('page-title', (isset($deduction) ? 'Edit Deduction' : 'Add Deduction') . ' | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        {{-- Page header --}}
        <div class="page-header">
            <div class="page-header d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-5">
                        <i class="feather-percent me-1"></i>
                        {{ isset($deduction) ? 'Edit Payroll Deduction' : 'Add Payroll Deduction' }}
                    </h5>
                    <small class="text-muted">
                        Configure deduction rules that will be applied during payroll run.
                    </small>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">HR</li>
                    <li class="breadcrumb-item">Payroll</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('hr.payroll.deduction.index') }}">Deductions</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ isset($deduction) ? 'Edit' : 'Create' }}
                    </li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('hr.payroll.deduction.index') }}" class="btn btn-light">
                    <i class="feather-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>

        <div class="main-content">
            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>There were some problems with your input.</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body">

                            <form method="POST" action="{{ isset($deduction)
        ? route('hr.payroll.deduction.update', $deduction->id)
        : route('hr.payroll.deduction.store') }}">
                                @csrf
                                @if (isset($deduction))
                                    @method('PUT')
                                @endif

                                {{-- Basic Details --}}
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-semibold text-uppercase small text-muted">Basic Details</span>
                                            <div class="small text-muted">
                                                Name and description shown to HR and on payslip.
                                            </div>
                                        </div>
                                        <i class="feather-info text-muted"></i>
                                    </div>
                                    <div class="card-body row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Deduction Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $deduction->name ?? '') }}"
                                                placeholder="Eg. Loan Recovery, Advance EMI">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Display Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="display_name" class="form-control"
                                                value="{{ old('display_name', $deduction->display_name ?? '') }}"
                                                placeholder="Label visible on payslip">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Description / Remarks</label>
                                            <textarea name="description" class="form-control" rows="2"
                                                placeholder="Internal note for HR (optional)">{{ old('description', $deduction->description ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- Deduction Classification --}}
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-semibold text-uppercase small text-muted">Deduction
                                                Classification</span>
                                            <div class="small text-muted">
                                                Controls whether this is recurring or ad‑hoc, fixed or variable.
                                            </div>
                                        </div>
                                        <i class="feather-layers text-muted"></i>
                                    </div>
                                    <div class="card-body row g-3">
                                        @php
                                            $nature = old('nature', $deduction->nature ?? 'FIXED');
                                            $category = old('category', $deduction->category ?? 'RECURRING');
                                        @endphp
                                        <div class="col-md-6">
                                            <label class="form-label">Deduction Nature <span
                                                    class="text-danger">*</span></label>
                                            <select name="nature" class="form-select">
                                                <option value="FIXED" {{ $nature === 'FIXED' ? 'selected' : '' }}>Fixed
                                                </option>
                                                <option value="VARIABLE" {{ $nature === 'VARIABLE' ? 'selected' : '' }}>
                                                    Variable</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Deduction Category <span
                                                    class="text-danger">*</span></label>
                                            <select name="category" class="form-select">
                                                <option value="RECURRING" {{ $category === 'RECURRING' ? 'selected' : '' }}>
                                                    Recurring (every month)
                                                </option>
                                                <option value="ADHOC" {{ $category === 'ADHOC' ? 'selected' : '' }}>
                                                    Ad‑hoc (one time)
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Attendance & Applicability --}}
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-semibold text-uppercase small text-muted">Attendance &
                                                Applicability</span>
                                            <div class="small text-muted">
                                                How this deduction reacts to LOP and partial months.
                                            </div>
                                        </div>
                                        <i class="feather-calendar text-muted"></i>
                                    </div>
                                    <div class="card-body row g-3">
                                        @php
                                            $lopImpact = old('lop_impact', $deduction->lop_impact ?? 'YES');
                                            $prorata = old('prorata_applicable', $deduction->prorata_applicable ?? 'YES');
                                        @endphp
                                        <div class="col-md-6">
                                            <label class="form-label">LOP Impact <span class="text-danger">*</span></label>
                                            <select name="lop_impact" class="form-select">
                                                <option value="YES" {{ $lopImpact === 'YES' ? 'selected' : '' }}>Yes – reduce
                                                    for LOP</option>
                                                <option value="NO" {{ $lopImpact === 'NO' ? 'selected' : '' }}>No – ignore LOP
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Prorata Applicable <span
                                                    class="text-danger">*</span></label>
                                            <select name="prorata_applicable" class="form-select">
                                                <option value="YES" {{ $prorata === 'YES' ? 'selected' : '' }}>Yes – DOJ/DOL
                                                    prorata</option>
                                                <option value="NO" {{ $prorata === 'NO' ? 'selected' : '' }}>No – full month
                                                    amount</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tax & Statutory --}}
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-semibold text-uppercase small text-muted">Tax & Statutory</span>
                                            <div class="small text-muted">
                                                Set tax treatment and statutory impacts for compliance.
                                            </div>
                                        </div>
                                        <i class="feather-shield text-muted"></i>
                                    </div>
                                    <div class="card-body row g-3">
                                        @php
                                            $taxDeductible = old('tax_deductible', $deduction->tax_deductible ?? 'YES');
                                            $pfImpact = old('pf_impact', $deduction->pf_impact ?? 'NO');
                                            $esiImpact = old('esi_impact', $deduction->esi_impact ?? 'NO');
                                            $ptImpact = old('pt_impact', $deduction->pt_impact ?? 'NO');
                                        @endphp
                                        <div class="col-md-3">
                                            <label class="form-label">Tax Deductible <span
                                                    class="text-danger">*</span></label>
                                            <select name="tax_deductible" class="form-select">
                                                <option value="YES" {{ $taxDeductible === 'YES' ? 'selected' : '' }}>Yes
                                                </option>
                                                <option value="NO" {{ $taxDeductible === 'NO' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">PF Impact <span class="text-danger">*</span></label>
                                            <select name="pf_impact" class="form-select">
                                                <option value="YES" {{ $pfImpact === 'YES' ? 'selected' : '' }}>Yes</option>
                                                <option value="NO" {{ $pfImpact === 'NO' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">ESI Impact <span class="text-danger">*</span></label>
                                            <select name="esi_impact" class="form-select">
                                                <option value="YES" {{ $esiImpact === 'YES' ? 'selected' : '' }}>Yes</option>
                                                <option value="NO" {{ $esiImpact === 'NO' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">PT Impact <span class="text-danger">*</span></label>
                                            <select name="pt_impact" class="form-select">
                                                <option value="YES" {{ $ptImpact === 'YES' ? 'selected' : '' }}>Yes</option>
                                                <option value="NO" {{ $ptImpact === 'NO' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Policy Mapping --}}
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-semibold text-uppercase small text-muted">Policy Mapping</span>
                                            <div class="small text-muted">
                                                Optionally link to a deduction rule set.
                                            </div>
                                        </div>
                                        <i class="feather-link text-muted"></i>
                                    </div>
                                    <div class="card-body">
                                        <label class="form-label">Rule Set Code</label>
                                        <input type="text" name="rule_set_code" class="form-control"
                                            value="{{ old('rule_set_code', $deduction->rule_set_code ?? '') }}"
                                            placeholder="Eg. PF_RULE_2026 (optional)">
                                    </div>
                                </div>

                                {{-- Payslip & Status --}}
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-semibold text-uppercase small text-muted">Payslip &
                                                Status</span>
                                            <div class="small text-muted">
                                                Controls visibility and ordering on the employee payslip.
                                            </div>
                                        </div>
                                        <i class="feather-file-text text-muted"></i>
                                    </div>
                                    <div class="card-body row g-3">
                                        @php
                                            $showPayslip = old('show_in_payslip', $deduction->show_in_payslip ?? 'YES');
                                            $status = old('status', $deduction->status ?? 'ACTIVE');
                                        @endphp
                                        <div class="col-md-4">
                                            <label class="form-label">Show in Payslip <span
                                                    class="text-danger">*</span></label>
                                            <select name="show_in_payslip" class="form-select">
                                                <option value="YES" {{ $showPayslip === 'YES' ? 'selected' : '' }}>Yes
                                                </option>
                                                <option value="NO" {{ $showPayslip === 'NO' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Payslip Display Order</label>
                                            <input type="number" name="payslip_order" class="form-control"
                                                value="{{ old('payslip_order', $deduction->payslip_order ?? '') }}"
                                                placeholder="Eg. 3">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select">
                                                <option value="ACTIVE" {{ $status === 'ACTIVE' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="INACTIVE" {{ $status === 'INACTIVE' ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Footer buttons --}}
                                <div class="d-flex justify-content-end mt-3">
                                    <a href="{{ route('hr.payroll.deduction.index') }}"
                                        class="btn btn-outline-secondary me-2">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($deduction) ? 'Update Deduction' : 'Save Deduction' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection