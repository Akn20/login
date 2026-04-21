@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Reports Dashboard</h2>

    <div class="row">

        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.nurse-reports.vitals') }}" class="card p-3 text-decoration-none">
                <h5>Vital Trends</h5>
                <p>View patient vitals over time</p>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.nurse-reports.medications') }}" class="card p-3 text-decoration-none">
                <h5>Medication Report</h5>
                <p>Track medication administration</p>
            </a>
        </div>

        

    </div>
</div>
@endsection