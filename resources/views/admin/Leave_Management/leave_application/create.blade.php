@extends('layouts.admin')

@section('page-title', 'Apply Leave')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10 mb-1">Apply Leave</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.leave-application.index') }}">Leave Application</a>
            </li>
            <li class="breadcrumb-item active">Apply Leave</li>
        </ul>
    </div>
</div>

<div class="row">


<div class="col-lg-8">

    {{-- Validation Errors --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<div class="card mb-3">
    <div class="card-body">


    <h6 class="mb-3">Leave Balance</h6>

    <div class="row text-center">

        @foreach($leaveBalances as $type => $balance)

        <div class="col-md-3 col-sm-4 col-6 mb-3">
            <div class="border rounded p-3 h-100">
                <h4 class="mb-1">{{ $balance }}</h4>
                <small class="text-muted text-capitalize">{{ $type }}</small>
            </div>
        </div>

        @endforeach

    </div>

</div>


</div>


    {{-- Apply Leave Form --}}
    <div class="card">
        <div class="card-body">

            @include('admin.Leave_Management.leave_application.form')

        </div>
    </div>

</div>

</div>

@endsection
