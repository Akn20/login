<!DOCTYPE html>
<html>
<head>
    <title>IPD Admission Slip</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
        }

        .section {
            margin-top: 20px;
        }

        .section h4 {
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .row {
            display: flex;
            margin-bottom: 8px;
        }

        .col {
            width: 50%;
        }

        .label {
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Print Button -->
    <button onclick="window.print()" style="font-weight: bold;">
    Print
</button>

    <!-- Header -->
    <div class="header">
        <div class="title">HIMS</div>
        <div>IPD Admission Slip</div>
    </div>

    <!-- Patient -->
    <div class="section">
        <h4>Patient Details</h4>

        <div class="row">
            <div class="col"><span class="label">Name:</span> {{ $ipd->patient->first_name }} {{ $ipd->patient->last_name }}</div>
            <div class="col"><span class="label">Mobile:</span> {{ $ipd->patient->mobile }}</div>
        </div>

        <div class="row">
            <div class="col"><span class="label">Gender:</span> {{ $ipd->patient->gender }}</div>
        </div>
    </div>

    <!-- Admission -->
    <div class="section">
        <h4>Admission Details</h4>

        <div class="row">
            <div class="col"><span class="label">Admission ID:</span> {{ $ipd->admission_id }}</div>
            <div class="col"><span class="label">Date:</span> {{ \Carbon\Carbon::parse($ipd->admission_date)->format('d-m-Y H:i') }}</div>
        </div>

        <div class="row">
            <div class="col"><span class="label">Department:</span> {{ $ipd->department->department_name ?? '-' }}</div>
            <div class="col"><span class="label">Doctor:</span> {{ $ipd->doctor->name ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="col"><span class="label">Type:</span> {{ ucfirst($ipd->admission_type) }}</div>
            <div class="col"><span class="label">Status:</span> {{ ucfirst($ipd->status) }}</div>
        </div>

        @if($ipd->discharge_date)
        <div class="row">
            <div class="col">
                <span class="label">Discharge Date:</span>
                {{ \Carbon\Carbon::parse($ipd->discharge_date)->format('d-m-Y H:i') }}
            </div>
        </div>
        @endif
    </div>

    <!-- Bed -->
    <div class="section">
        <h4>Ward / Bed</h4>

        <div class="row">
            <div class="col"><span class="label">Ward:</span> {{ $ipd->ward->ward_name ?? '-' }}</div>
            <div class="col"><span class="label">Room:</span> {{ $ipd->room->room_number ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="col"><span class="label">Bed:</span> {{ $ipd->bed->bed_code ?? '-' }}</div>
        </div>
    </div>

    <!-- Insurance -->
    <div class="section">
        <h4>Insurance</h4>

        <div class="row">
            <div class="col"><span class="label">Insured:</span> {{ $ipd->insurance_flag ? 'Yes' : 'No' }}</div>
            <div class="col"><span class="label">Provider:</span> {{ $ipd->insurance_provider ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="col"><span class="label">Policy:</span> {{ $ipd->policy_number ?? '-' }}</div>
        </div>
    </div>

    <!-- Notes -->
    <div class="section">
        <h4>Remarks</h4>
        <p>{{ $ipd->notes ?? '-' }}</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Authorized Signature</p>
    </div>

</body>
</html>