@extends('layouts.admin')

@section('page-title', 'Deleted Statutory Contributions')

@section('content')

<div class="card">
    <div class="card-body">

        <h5>Deleted Records Page</h5>

        <p>UI placeholder for deleted statutory contributions.</p>

        <a href="{{ route('hr.payroll.statutory-contribution.index') }}"
           class="btn btn-light">
            Back
        </a>

    </div>
</div>

@endsection