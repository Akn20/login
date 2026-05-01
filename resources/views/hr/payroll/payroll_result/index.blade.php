@extends('layouts.admin')

@section('page-title', 'Payroll Result / Salary Sheet')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <!-- LEFT SIDE -->
    <div class="page-header-left">

        <h5 class="m-b-10 mb-1">
            Payroll Result / Salary Sheet
        </h5>

        <ul class="breadcrumb mb-0">

            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item active">
                Payroll Result List
            </li>

        </ul>

    </div>


    <!-- RIGHT SIDE (Generate Button) -->
    <div class="page-header-right">

        <a href="{{ route('hr.payroll.payroll-result.generate') }}"
           class="btn btn-primary btn-sm">

            Generate Payroll

        </a>

    </div>

</div>



<div class="row">
<div class="col-12">

<div class="card stretch stretch-full">
<div class="card-body p-0">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead>

<tr>

<th>#</th>

<th>Employee ID</th>

<th>Payroll Month</th>

<th>Financial Year</th>

<th>Working Days</th>

<th>Paid Days</th>

<th>LOP Days</th>

<th>Gross Earnings</th>

<th>Total Deductions</th>

<th>Net Payable</th>

<th>Status</th>

<th>Locked On</th>

<th class="text-end">Action</th>

</tr>

</thead>



<tbody>

@forelse($payrollResults as $index => $result)

<tr>

<td>{{ $index + 1 }}</td>


<td>
<span class="badge bg-soft-primary text-primary">
{{ $result->staff_id }}
</span>
</td>


<td>
{{ $result->payroll_month }}
</td>


<td>
{{ $result->financial_year }}
</td>


<td>
{{ $result->working_days }}
</td>


<td>
{{ $result->paid_days }}
</td>


<td>
{{ $result->lop_days }}
</td>


<td>
₹ {{ number_format($result->gross_earnings, 2) }}
</td>


<td>
₹ {{ number_format($result->total_deductions, 2) }}
</td>


<td>

<strong>
₹ {{ number_format($result->net_payable, 2) }}
</strong>

</td>


<td>

@if($result->status == 'Locked')

<span class="badge bg-danger">
Locked
</span>

@else

<span class="badge bg-warning">
Reversed
</span>

@endif

</td>



<td>

{{ $result->locked_on }}

</td>



<td class="text-end">

<div class="d-flex gap-2 justify-content-end">

<a href="{{ route('hr.payroll.payroll-result.show', $result->id) }}"
   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
   title="View">

<i class="feather-eye"></i>

</a>

</div>

</td>


</tr>

@empty

<tr>

<td colspan="13" class="text-center text-muted">

No payroll results found

</td>

</tr>

@endforelse


</tbody>

</table>

</div>

</div>
</div>

</div>
</div>

@endsection