@extends('layouts.admin')

@section('page-title', 'View Statutory Deduction')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between">
    <h5>View Statutory Deduction</h5>
    <a href="{{ route('hr.payroll.statutory-deduction.index') }}" class="btn btn-secondary btn-sm">Back</a>
</div>

<div class="card">
    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th>Code</th>
                <td>{{ $record->statutory_code }}</td>
            </tr>

            <tr>
                <th>Name</th>
                <td>{{ $record->statutory_name }}</td>
            </tr>

            <tr>
                <th>Category</th>
                <td>{{ $record->statutory_category }}</td>
            </tr>

            <tr>
                <th>Rule Set</th>
                <td>{{ $record->ruleSet->rule_set_name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Eligibility</th>
                <td>{{ $record->eligibility_flag ? 'Yes' : 'No' }}</td>
            </tr>

            <tr>
                <th>Salary Ceiling</th>
                <td>{{ $record->salary_ceiling_amount ?? '-' }}</td>
            </tr>

            <tr>
                <th>States</th>
                <td>
                    {{ $record->applicable_states ? implode(', ', json_decode($record->applicable_states)) : '-' }}
                </td>
            </tr>

            <tr>
                <th>Prorata</th>
                <td>{{ $record->prorata_applicable ? 'Yes' : 'No' }}</td>
            </tr>

            <tr>
                <th>LOP Impact</th>
                <td>{{ $record->lop_impact ? 'Yes' : 'No' }}</td>
            </tr>

            <tr>
                <th>Rounding Rule</th>
                <td>{{ $record->rounding_rule }}</td>
            </tr>

            <tr>
                <th>Payslip Order</th>
                <td>{{ $record->payslip_order }}</td>
            </tr>

            <tr>
                <th>Compliance Head</th>
                <td>{{ $record->compliance_head }}</td>
            </tr>

            <tr>
                <th>Authority Code</th>
                <td>{{ $record->authority_code }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <span class="badge bg-{{ $record->status == 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($record->status) }}
                    </span>
                </td>
            </tr>

        </table>

    </div>
</div>

@endsection