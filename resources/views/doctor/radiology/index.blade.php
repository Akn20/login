@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-md-6">
            <h3>Radiology Reports</h3>
        </div>

        <div class="col-md-6 text-end">
            <a href="{{ route('doctor.radiology.create') }}"
               class="btn btn-primary">

                Request Imaging
            </a>
        </div>

    </div>


    @if(session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif


    <div class="card">

        <div class="card-header">

            <strong>Imaging Reports</strong>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                    <tr>

                        <th>Patient</th>
                        <th>Scan Type</th>
                        <th>Status</th>
                        <th>Report Date</th>
                        <th>Action</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($reports as $report)

                    <tr>

                        <td>
                            {{ $report->request->patient->first_name }}
                            {{ $report->request->patient->last_name }}
                        </td>

                        <td>
                            {{ $report->request->scanType->name }}
                        </td>

                        <td>

                            <span class="badge bg-info">

                                {{ $report->status }}

                            </span>

                        </td>

                        <td>

                            {{ $report->created_at->format('d-m-Y') }}

                        </td>

                        <td>

                            <a href="{{ route('doctor.radiology.show',$report->id) }}"
                               class="btn btn-sm btn-primary">

                               View

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="text-center">

                            No Reports Found

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection