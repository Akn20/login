@extends('layouts.admin')

@section('content')

<form action="{{ route('hr.payroll.payroll-result-deductions.update', $record->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    @include('hr.payroll.payroll_result_deductions.form', [
    'record' => $record,
    'ruleSets' => $ruleSets,
    'payrollResults' => $payrollResults
])

</form>

@endsection