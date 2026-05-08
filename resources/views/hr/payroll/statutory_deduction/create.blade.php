@extends('layouts.admin')

@section('page-title', 'Add Statutory Deduction')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">
    <h5>Add Statutory Deduction</h5>

    <a href="{{ route('hr.payroll.statutory-deduction.index') }}" class="btn btn-light">
        Back
    </a>
</div>


            @include('hr.payroll.statutory_deduction.form', [
                'deduction' => null
            ])

    

@endsection