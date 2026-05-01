@extends('layouts.admin')

@section('content')

<form action="{{ route('hr.payroll.payroll-result-deductions.store') }}"
      method="POST">

    @csrf

    @include('hr.payroll.payroll_result_deductions.form')

</form>

@endsection