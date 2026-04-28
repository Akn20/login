<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Discharge Summary</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background: #f2f2f2;
            text-align: left;
        }
    </style>
</head>

<body>

<div class="header">
    <div class="title">Hospital Discharge Summary</div>
</div>

<table>

<tr>
    <th>Patient Name</th>
    <td>
        {{ $ipd->patient->first_name ?? '-' }} 
        {{ $ipd->patient->last_name ?? '' }}
    </td>
</tr>

<tr>
    <th>Admission ID</th>
    <td>{{ $ipd->admission_id ?? '-' }}</td>
</tr>

<tr>
    <th>Diagnosis</th>
    <td>{{ optional($discharge)->diagnosis ?? '-' }}</td>
</tr>

<tr>
    <th>Treatment Summary</th>
    <td>{{ optional($discharge)->treatment_given ?? '-' }}</td>
</tr>

<tr>
    <th>Doctor Name</th>
    <td>{{ optional($discharge)->doctor_name ?? '-' }}</td>
</tr>

<tr>
    <th>Discharge Date</th>
    <td>{{ optional($discharge)->date ?? '-' }}</td>
</tr>

</table>

<br><br>

<div style="text-align:right;">
    <strong>Authorized Signature</strong>
</div>

</body>
</html>