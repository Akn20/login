@extends('layouts.admin')

@section('content')

<div class="container">

    <h2>Doctor Order Execution</h2>

    <hr>

    <h4>Lab Requests Count</h4>

    <p>
        {{ $labRequests->count() }}
    </p>

    <hr>

    <h4>Radiology Requests Count</h4>

    <p>
        {{ $scanRequests->count() }}
    </p>

</div>

@endsection