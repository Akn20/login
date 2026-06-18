<!DOCTYPE html>
<html>

<head>

    <title>Laboratory's Report</title>

    <style>

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        color: #222;
        font-size: 12px;
        line-height: 1.4;
        -webkit-font-smoothing: antialiased;
    }

    .pdf-wrapper {
        padding: 12px 14px;
    }

    .header {
        text-align: center;
        margin-bottom: 15px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 8px;
    }

    .header h1 {
        margin: 0;
        font-size: 24px;
    }

    .header h3 {
        margin: 2px 0 0;
        font-size: 15px;
        color: #666;
        font-weight: normal;
    }

    .section {
        margin-bottom: 12px;
        page-break-inside: avoid;
        break-inside: avoid;
    }

    .section-title {
        background: #f5f5f5;
        padding: 8px;
        border: 1px solid #ddd;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead { display: table-header-group }
    tfoot { display: table-footer-group }

    table th,
    table td {
        border: 1px solid #ccc;
        padding: 7px;
        vertical-align: top;
    }

    table th {
        width: 30%;
        background: #fafafa;
        text-align: left;
    }

    .badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 4px;
        color: white;
        font-size: 11px;
        font-weight: bold;
    }

    .success {
        background: green;
    }

    .warning {
        background: orange;
    }

    .note-box {
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 0;
        page-break-inside: avoid;
    }

    .note-title {
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 6px;
    }

    p {
        margin: 6px 0;
    }

    .footer {
        margin-top: 20px;
        text-align: center;
        font-size: 10px;
        color: #777;
    }

    @page {
        margin: 12mm;
    }

    /* Prevent breaking cards/tables across pages */
    table, tbody, tr, td, th, .note-box, .section {
        page-break-inside: avoid;
    }

    /* Small helper for forcing page breaks when needed */
    .page-break { page-break-after: always; }

</style>
</head>

<body>

<div class="pdf-wrapper">

    @php

        $sample = $report->sample;

        $labRequest = optional($sample)->labRequest;

        $patient = optional($labRequest)->patient;

    @endphp

    {{-- HEADER --}}
    <div class="header">

        <h1>HIMS</h1>

        <h3>Hospital Laboratory Report</h3>

    </div>



    {{-- PATIENT INFORMATION --}}
    <div class="section">

        <div class="section-title">
            Patient Information
        </div>

        <table>

            <tr>
                <th>Patient Name</th>
                <td>
                    {{ $patient->first_name ?? 'N/A' }}
                    {{ $patient->last_name ?? '' }}
                </td>
            </tr>

            <tr>
                <th>Test Name</th>
                <td>
                    {{ $labRequest->test_name ?? 'N/A' }}
                </td>
            </tr>

            <tr>
                <th>Sample ID</th>
                <td>
                    {{ $sample->barcode ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Priority</th>
                <td>
                    {{ ucfirst($labRequest->priority ?? '-') }}
                </td>
            </tr>

            <tr>
                <th>Report Date</th>
                <td>
                    {{ $report->created_at->format('d M Y h:i A') }}
                </td>
            </tr>

            <tr>
                <th>Status</th>

                <td>

                    @if($report->status == 'Completed')

                        <span class="badge success">
                            Completed
                        </span>

                    @else

                        <span class="badge warning">
                            Pending
                        </span>

                    @endif

                </td>

            </tr>

        </table>

    </div>



    {{-- RESULT VALUES --}}
    <div class="section">

        <div class="section-title">
            Laboratory Result Values
        </div>

        @if(is_array($report->result_data))

            <table>

                <thead>

                    <tr>

                        <th style="width:40%">
                            Parameter
                        </th>

                        <th>
                            Result Value
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($report->result_data as $key => $value)

                        @if($key != 'attachments')

                            <tr>

                                <td>

                                    {{ ucfirst(str_replace('_', ' ', $key)) }}

                                </td>

                                <td>

                                    @if(is_array($value))

                                        {{ json_encode($value) }}

                                    @else

                                        {{ $value }}

                                    @endif

                                </td>

                            </tr>

                        @endif

                    @endforeach

                </tbody>

            </table>

        @else

            <p>No result data available.</p>

        @endif

    </div>



    {{-- CLINICAL NOTES --}}
    <div class="section">

        <div class="section-title">
            Clinical Notes
        </div>

        @forelse($report->clinicalNotes as $note)

            <div class="note-box">

                <div class="note-title">
                    Doctor Observation
                </div>

                <p>
                    <strong>Observation:</strong><br>
                    {{ $note->clinical_observation ?? '-' }}
                </p>

                <p>
                    <strong>Diagnosis:</strong><br>
                    {{ $note->diagnosis ?? '-' }}
                </p>

                <p>
                    <strong>Follow-up Advice:</strong><br>
                    {{ $note->follow_up_advice ?? '-' }}
                </p>

                <p style="margin-top:15px; color:#666; font-size:12px;">

                    Added on:
                    {{ $note->created_at->format('d M Y h:i A') }}

                </p>

            </div>

        @empty

            <p>No clinical notes available.</p>

        @endforelse

    </div>



    {{-- FOOTER --}}
    <div class="footer">

        Generated from Hospital Information Management System (HIMS)

    </div>

</div><!-- /.pdf-wrapper -->

</body>

</html>