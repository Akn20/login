@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white">
            <h4>🚨 Emergency Patient Snapshot</h4>
        </div>

        <div class="card-body">

            @include('admin.emergency-records.partials.emergency-card')

        </div>
    </div>

</div>
@endsection