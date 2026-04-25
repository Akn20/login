@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4">🧑‍⚕️ Nurse Dashboard</h3>

    <!-- SUMMARY CARDS -->
    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-left border-success">
                <div class="card-body">
                    <h6 class="text-muted">Total Patients</h6>
                    <h3>{{ $patients->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-left border-danger">
                <div class="card-body">
                    <h6 class="text-muted">Critical Patients</h6>
                    <h3>{{ $criticalPatients }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
             <div class="card shadow-sm border-left border-secondary">
                <div class="card-body">
                    <h6 class="text-muted">Pending Medications</h6>
                    <h3>{{ $pendingMedications }}</h3>
            
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-left border-warning">
                <div class="card-body">
                    <h6 class="text-muted">Vitals Due</h6>
                    <h3>{{ $pendingVitals }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-left border-success">
                <div class="card-body">
                    <h6 class="text-muted">Discharges</h6>
                    <h3>{{ $discharges }}</h3>
                </div>
            </div>
        </div>

    </div>

    

</div>
@endsection