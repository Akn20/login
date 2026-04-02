@extends('layouts.admin')

@section('page-title', 'Add Hourly Pay')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h5 class="mb-1">Add Work Type</h5>
    </div>

    <!-- ✅ BACK BUTTON -->
    <a href="{{ route('hr.payroll.hourly-pay.index') }}" class="btn btn-light">
        <i class="feather-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.hourly-pay.store') }}" method="POST">
            @csrf

            @include('hr.payroll.hourly_pay.form')

        </form>

    </div>
</div>

@endsection