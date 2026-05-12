@extends('layouts.admin')

@section('content')

<div class="card">
<div class="card-body">


<form action="{{ route('hr.payroll.payroll-result-earnings.update', $record->id) }}" method="POST">
    @csrf
    @method('PUT')

    @include('hr.payroll.payroll_result_earnings.form')

</form>

</div>
</div>

@endsection