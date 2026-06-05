@extends('layouts.admin')

@section('content')

<div class="container">

    <h3>
        Patient Profile
    </h3>

    <div class="card shadow">

    <div class="card-header bg-info text-white">
        Patient Information
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">
                <p><strong>UHID :</strong> {{ $patient->patient_code }}</p>
                <p><strong>Name :</strong> {{ $patient->first_name }} {{ $patient->last_name }}</p>
                <p><strong>Mobile :</strong> {{ $patient->mobile }}</p>
                <p><strong>Gender :</strong> {{ $patient->gender }}</p>
            </div>

            <div class="col-md-6">
                <p><strong>Email :</strong> {{ $patient->email }}</p>
                <p><strong>Address :</strong> {{ $patient->address }}</p>
                <p><strong>Age :</strong> {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</p>
                <p><strong>Status :</strong> {{ $patient->status == 1 ? 'Active' : 'Inactive' }}</p>
                <p><strong>Registration Date :</strong> {{ $patient->created_at->format('d M Y') }}</p>
            </div>

        </div>


        <div class="d-flex gap-2 mt-3">

    <a href="{{ route('admin.patient-inquiry.visit-history',$patient->id) }}"
       class="btn btn-primary btn-sm">
        Visit History
    </a>

    <a href="{{ route('admin.patient-inquiry.visit-summary',$patient->id) }}"
       class="btn btn-success btn-sm">
        Visit Summary
    </a>

</div>

    </div>

</div>

</div>

@endsection