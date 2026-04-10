@extends('layouts.admin')

@section('page-title', 'View Statutory Contribution')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>
        <h5 class="mb-1">
            View Statutory Contribution
        </h5>
    </div>

    <!-- Back Button -->
    <a href="{{ route('hr.payroll.statutory-contribution.index') }}"
       class="btn btn-light">

        <i class="feather-arrow-left me-1"></i>
        Back

    </a>

</div>



<!-- Basic Details -->

<div class="card mb-3">

    <div class="card-header">
        Basic Details
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Contribution Code
                </label>

                <div>
                    {{ $statutoryContribution->contribution_code }}
                </div>
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Contribution Name
                </label>

                <div>
                    {{ $statutoryContribution->contribution_name }}
                </div>
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Statutory Category
                </label>

                <div>
                    {{ $statutoryContribution->statutory_category }}
                </div>
            </div>

        </div>


        <div class="row">

            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Rule Set Code
                </label>

                <div>
                    {{ $statutoryContribution->rule_set_code }}
                </div>
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Eligibility Flag
                </label>

                <div>
                    {{ ucfirst($statutoryContribution->eligibility_flag) }}
                </div>
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Status
                </label>

                <div>
                    @if($statutoryContribution->status == 'active')

                        <span class="text-success">
                            Active
                        </span>

                    @else

                        <span class="text-danger">
                            Inactive
                        </span>

                    @endif
                </div>

            </div>

        </div>

    </div>

</div>



<!-- Salary & State Configuration -->

<div class="card mb-3">

    <div class="card-header">
        Salary & State Configuration
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Salary Ceiling Applicable
                </label>

                <div>
                    {{ ucfirst($statutoryContribution->salary_ceiling_applicable) }}
                </div>
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Salary Ceiling Amount
                </label>

                <div>
                    {{ $statutoryContribution->salary_ceiling_amount ?? 'N/A' }}
                </div>
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    State Applicable
                </label>

                <div>
                    {{ ucfirst($statutoryContribution->state_applicable) }}
                </div>
            </div>

        </div>

    </div>

</div>



<!-- Payroll Behaviour -->

<div class="card mb-3">

    <div class="card-header">
        Payroll Behaviour
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Prorata Applicable
                </label>

                <div>
                    {{ ucfirst($statutoryContribution->prorata_applicable) }}
                </div>
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    LOP Impact
                </label>

                <div>
                    {{ ucfirst($statutoryContribution->lop_impact) }}
                </div>
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Rounding Rule
                </label>

                <div>
                    {{ ucfirst($statutoryContribution->rounding_rule) ?? 'N/A' }}
                </div>
            </div>

        </div>

    </div>

</div>



<!-- Payslip Configuration -->

<div class="card mb-3">

    <div class="card-header">
        Payslip Configuration
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Show in Payslip
                </label>

                <div>
                    {{ ucfirst($statutoryContribution->show_in_payslip) }}
                </div>
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Payslip Order
                </label>

                <div>
                    {{ $statutoryContribution->payslip_order ?? 'N/A' }}
                </div>
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Included in CTC
                </label>

                <div>
                    {{ ucfirst($statutoryContribution->included_in_ctc) }}
                </div>
            </div>

        </div>

    </div>

</div>



<!-- Compliance Details -->

<div class="card mb-3">

    <div class="card-header">
        Compliance Details
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Compliance Head
                </label>

                <div>
                    {{ $statutoryContribution->compliance_head }}
                </div>
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label text-muted">
                    Statutory Code
                </label>

                <div>
                    {{ $statutoryContribution->statutory_code }}
                </div>
            </div>

        </div>

    </div>

</div>

@endsection