@extends('layouts.admin')

@section('page-title', 'Edit Statutory Contribution')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>
        <h5 class="mb-1">
            Edit Statutory Contribution
        </h5>
    </div>


    <!-- Back Button -->
    <a href="{{ route('hr.payroll.statutory-contribution.index') }}"
       class="btn btn-light">

        <i class="feather-arrow-left me-1"></i>
        Back

    </a>

</div>


<div class="card">

    <div class="card-body">

        <form action="{{ route('hr.payroll.statutory-contribution.update', $statutoryContribution->id) }}"
              method="POST">

            @csrf
            @method('PUT')


            {{-- Reuse Form --}}
            @include('hr.payroll.statutory_contribution.form')


        </form>

    </div>

</div>

@endsection