@extends('layouts.admin')

@section('content')

<div class="card">
<div class="card-body">

<form action="{{ route('hr.payroll.payroll-result-earnings.store') }}" method="POST">
    @csrf

    @include('hr.payroll.payroll_result_earnings.form')

</form>

</div>
</div>

@endsection