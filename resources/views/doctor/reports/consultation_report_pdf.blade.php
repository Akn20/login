<!DOCTYPE html>
<html>

<head>

    <title>Consultation Summary Report</title>

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
            margin-bottom: 15px;
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

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 7px;
            vertical-align: top;
        }

        table th {
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

        .danger {
            background: red;
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

        table,
        tbody,
        tr,
        td,
        th,
        .section {
            page-break-inside: avoid;
        }

    </style>

</head>

<body>

<div class="pdf-wrapper">

    {{-- HEADER --}}
    <div class="header">

        <h1>HIMS</h1>

        <h3>
            Consultation Summary Report
        </h3>

    </div>



    {{-- REPORT SUMMARY --}}
    <div class="section">

        <div class="section-title">
            Report Summary
        </div>

        <table>

            <tr>

                <th style="width:30%">
                    Total Consultations
                </th>

                <td>
                    {{ $consultations->count() }}
                </td>

            </tr>

            <tr>

                <th>
                    Generated Date
                </th>

                <td>
                    {{ now()->format('d M Y h:i A') }}
                </td>

            </tr>

        </table>

    </div>



    {{-- CONSULTATION LIST --}}
    <div class="section">

        <div class="section-title">
            Consultation Records
        </div>

        <table>

            <thead>

                <tr>

                    <th>#</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Department</th>
                    <th>Symptoms</th>
                    <th>Diagnosis</th>
                    <th>Prescription</th>
                    <th>Date</th>

                </tr>

            </thead>

            <tbody>

                @forelse($consultations as $key => $consultation)

                    <tr>

                        <td>
                            {{ $key + 1 }}
                        </td>

                        {{-- PATIENT --}}
                        <td>

                            {{ $consultation->patient->first_name ?? '' }}
                            {{ $consultation->patient->last_name ?? '' }}

                        </td>

                        {{-- DOCTOR --}}
                        <td>

                            {{ optional($consultation->doctor)->name ?? 'N/A' }}

                        </td>

                        {{-- DEPARTMENT --}}
                        <td>

                            {{ optional(optional($consultation->doctor)->department)->department_name ?? 'N/A' }}

                        </td>

                        {{-- SYMPTOMS --}}
                        <td>

                            {{ $consultation->symptoms ?? 'N/A' }}

                        </td>

                        {{-- DIAGNOSIS --}}
                        <td>

                            {{ $consultation->diagnosis ?? 'N/A' }}

                        </td>

                        {{-- PRESCRIPTION --}}
                        <td>

                            @if($consultation->medicines->count() > 0)

                                <span class="badge success">
                                    Yes
                                </span>

                            @else

                                <span class="badge danger">
                                    No
                                </span>

                            @endif

                        </td>

                        {{-- DATE --}}
                        <td>

                            {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d M Y') }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8" align="center">

                            No consultation records found

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>



    {{-- FOOTER --}}
    <div class="footer">

        Generated from Hospital Information Management System (HIMS)

    </div>

</div>

</body>

</html>