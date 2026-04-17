@extends('layouts.admin')

@section('page-title', 'Edit Hourly Pay Approval | ' . config('app.name'))
@section('title', 'Edit Hourly Pay Approval')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

<div>

<h5 class="mb-1">
<i class="feather-edit me-1"></i>
Edit Hourly Entry
</h5>

<ul class="breadcrumb mb-0">
<li class="breadcrumb-item">Payroll</li>
<li class="breadcrumb-item">Hourly Pay Approval</li>
</ul>

</div>

<div class="d-flex gap-2">

<button type="submit"
form="hourlyForm"
class="btn btn-primary">

<i class="feather-save me-1"></i>
Update

</button>

<a href="{{ route('hr.payroll.hourly-pay-approval.index') }}"
class="btn btn-light">

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

<form id="hourlyForm"
method="POST"
action="{{ route('hr.payroll.hourly-pay-approval.update',$entry->id) }}">

@csrf
@method('PUT')

@include('hr.payroll.hourly_pay_approval.form')

</form>

</div>

</div>

@endsection