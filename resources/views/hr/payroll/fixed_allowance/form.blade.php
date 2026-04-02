@extends('layouts.admin')

@section('page-title', 'Add Fixed Allowance | ' . config('app.name'))
@section('title', 'Add Fixed Allowance')

@section('content')

    <div class="page-header mb-4 d-flex align-items-center justify-content-between">

        <div>
            <h5 class="mb-1">
                <i class="feather-plus-circle me-1"></i>
                {{ isset($allowance) ? 'Edit Fixed Allowance' : 'Add Fixed Allowance' }}
            </h5>

            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">Payroll</li>
                <li class="breadcrumb-item">Allowance</li>
            </ul>
        </div>

        {{-- 🔥 ACTION BUTTONS --}}
        <div class="d-flex gap-2">

            <button type="submit" form="allowanceForm" class="btn btn-primary">
                <i class="feather-save me-1"></i>
                {{ isset($allowance) ? 'Update' : 'Save' }}
            </button>

            <a href="{{ route('hr.payroll.allowance.index', ['type' => 'fixed']) }}" class="btn btn-light">
                Cancel
            </a>

        </div>

    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card stretch stretch-full">
        <div class="card-body">

            <form id="allowanceForm" method="POST" action="{{ isset($allowance)
        ? route('hr.payroll.allowance.update', $allowance->id)
        : route('hr.payroll.allowance.store') }}">

                @csrf
                @if(isset($allowance))
                    @method('PUT')
                @endif
                <input type="hidden" name="type" value="fixed">

                {{-- ================= BASIC DETAILS ================= --}}
                <h6 class="fw-bold mb-3">Basic Details</h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Allowance Name *</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $allowance->name ?? '') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Display Name *</label>
                        <input type="text" name="display_name" class="form-control"
                            value="{{ old('display_name', $allowance->display_name ?? '') }}" required>
                    </div>
                </div>

                <hr>

                {{-- ================= CLASSIFICATION ================= --}}
                <h6 class="fw-bold mb-3">Allowance Classification</h6>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Allowance Nature</label>
                        <select name="nature" class="form-control">
                            <option value="fixed">Fixed</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pay Frequency *</label>
                        <select name="pay_frequency" class="form-control">
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="yearly">Yearly</option>
                            <option value="one_time">One-time</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ old('start_date', isset($allowance) && $allowance->start_date ? $allowance->start_date->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <hr>

                {{-- ================= CALCULATION CONFIG ================= --}}
                <h6 class="fw-bold mb-3">Calculation Configuration</h6>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Calculation Type *</label>
                        <select name="calculation_type" class="form-control">
                            <option value="fixed" {{ old('calculation_type', $allowance->calculation_type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="percentage" {{ old('calculation_type', $allowance->calculation_type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="balancing" {{ old('calculation_type', $allowance->calculation_type ?? '') == 'balancing' ? 'selected' : '' }}>Balancing</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Calculation Base</label>
                        <select name="calculation_base" class="form-control">
                            <option value="basic" {{ old('calculation_base', $allowance->calculation_base ?? '') == 'basic' ? 'selected' : '' }}>Basic</option>
                            <option value="gross" {{ old('calculation_base', $allowance->calculation_base ?? '') == 'gross' ? 'selected' : '' }}>Gross</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Calculation Value</label>
                        <input type="number" step="0.01" name="calculation_value" class="form-control"
                            value="{{ old('calculation_value', $allowance->calculation_value ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Rounding Rule</label>
                        <select name="rounding_rule" class="form-control">
                            <option value="nearest" {{ old('rounding_rule', $allowance->rounding_rule ?? '') == 'nearest' ? 'selected' : '' }}>Nearest</option>
                            <option value="up" {{ old('rounding_rule', $allowance->rounding_rule ?? '') == 'up' ? 'selected' : '' }}>Up</option>
                            <option value="down" {{ old('rounding_rule', $allowance->rounding_rule ?? '') == 'down' ? 'selected' : '' }}>Down</option>
                            <option value="none" {{ old('rounding_rule', $allowance->rounding_rule ?? '') == 'none' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Maximum Limit</label>
                        <input type="number" name="max_limit" class="form-control"
                            value="{{ old('max_limit', $allowance->max_limit ?? '') }}">
                    </div>
                </div>

                <hr>

                {{-- ================= ATTENDANCE RULES ================= --}}
                <h6 class="fw-bold mb-3">Attendance & Prorata</h6>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">LOP Impact</label>
                        <select name="lop_impact" class="form-control">
                            <option value="1" {{ old('lop_impact', $allowance->lop_impact ?? 0) == 1 ? 'selected' : '' }}>Yes
                            </option>
                            <option value="0" {{ old('lop_impact', $allowance->lop_impact ?? 0) == 0 ? 'selected' : '' }}>No
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Prorata Applicable</label>
                        <select name="prorata" class="form-control">
                            <option value="1" {{ old('prorata', $allowance->prorata ?? 0) == 1 ? 'selected' : '' }}>Yes
                            </option>
                            <option value="0" {{ old('prorata', $allowance->prorata ?? 0) == 0 ? 'selected' : '' }}>No
                            </option>
                        </select>
                    </div>
                </div>

                <hr>
                {{-- ================= TAX CONFIG ================= --}}
                <h6 class="fw-bold mb-3">Tax & Statutory</h6>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Taxable</label>
                        <select name="taxable" class="form-control">
                            <option value="1" {{ old('taxable', $allowance->taxable ?? 0) == 1 ? 'selected' : '' }}>Yes
                            </option>
                            <option value="0" {{ old('taxable', $allowance->taxable ?? 0) == 0 ? 'selected' : '' }}>No
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tax Exemption Section</label>
                        <input type="text" name="tax_exemption_section" class="form-control"
                            value="{{ old('tax_exemption_section', $allowance->tax_exemption_section ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">PF Applicable</label>
                        <select name="pf_applicable" class="form-control">
                            <option value="1" {{ old('pf_applicable', $allowance->pf_applicable ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('pf_applicable', $allowance->pf_applicable ?? 0) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">ESI Applicable</label>
                        <select name="esi_applicable" class="form-control">
                            <option value="1" {{ old('esi_applicable', $allowance->esi_applicable ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('esi_applicable', $allowance->esi_applicable ?? 0) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">PT Applicable</label>
                        <select name="pt_applicable" class="form-control">
                            <option value="1" {{ old('pt_applicable', $allowance->pt_applicable ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('pt_applicable', $allowance->pt_applicable ?? 0) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">TDS Applicable</label>
                        <select name="tds_applicable" class="form-control">
                            <option value="1" {{ old('tds_applicable', $allowance->tds_applicable ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('tds_applicable', $allowance->tds_applicable ?? 0) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>

                <hr>

                {{-- ================= PAYSLIP ================= --}}
                <h6 class="fw-bold mb-3">Payslip Configuration</h6>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Show in Payslip</label>
                        <select name="show_in_payslip" class="form-control">
                            <option value="1" {{ old('show_in_payslip', $allowance->show_in_payslip ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('show_in_payslip', $allowance->show_in_payslip ?? 0) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control"
                            value="{{ old('display_order', $allowance->display_order ?? '') }}">
                    </div>
                </div>

                <hr>

                {{-- ================= POLICY ================= --}}
                <h6 class="fw-bold mb-3">Policy Versioning</h6>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Effective From *</label>
                        <input type="date" name="effective_from" class="form-control"
                            value="{{ old('effective_from', isset($allowance) && $allowance->effective_from ? $allowance->effective_from->format('Y-m-d') : '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Effective To</label>
                        <input type="date" name="effective_to" class="form-control"
                            value="{{ old('effective_to', isset($allowance) && $allowance->effective_to ? $allowance->effective_to->format('Y-m-d') : '') }}">
                    </div>
                    <hr>

                </div>
                <h6 class="fw-bold mb-3">Status</h6>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $allowance->status ?? 0) == 1 ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ old('status', $allowance->status ?? 0) == 0 ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection