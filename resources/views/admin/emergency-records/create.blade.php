@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">🚑 Emergency Case Registration</h5>
        </div>

        <div class="card-body">
            @include('admin.emergency-records.partials.form')
        </div>
    </div>

</div>
@endsection