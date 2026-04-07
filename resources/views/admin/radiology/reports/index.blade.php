@extends('layouts.admin')

@section('content')

<div class="nxl-content">

<h5>Radiology Reports</h5>

<table class="table">
    <thead>
        <tr>
            <th>Patient</th>
            <th>Scan</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($reports as $r)
        <tr>
            <td>{{ $r->request->patient->first_name }}</td>
            <td>{{ $r->request->scanType->name }}</td>
            <td>
                <a href="{{ route('admin.radiology.reports.show',$r->id) }}" class="btn btn-primary">
                    View Report
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

</div>

@endsection