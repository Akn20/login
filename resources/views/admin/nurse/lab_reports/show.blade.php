@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Report Details</h3>

    <div class="card p-3">

        @if($type == 'lab')

            <p><strong>Patient:</strong>
                {{ $report->sample->patient->first_name ?? 'N/A' }}
            </p>

            <p><strong>Status:</strong> {{ $report->status }}</p>

            <pre>{{ json_encode($report->result_data, JSON_PRETTY_PRINT) }}</pre>

        @elseif($type == 'radiology')

            <p><strong>Patient:</strong>
                {{ $report->request->patient->first_name ?? 'N/A' }}
            </p>

            <p><strong>Status:</strong> {{ $report->status }}</p>

            <p><strong>Observations:</strong> {{ $report->observations }}</p>
            <p><strong>Findings:</strong> {{ $report->findings }}</p>
            <p><strong>Diagnosis:</strong> {{ $report->diagnosis }}</p>

        @endif

    </div>
</div>
@endsection