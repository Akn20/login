<!DOCTYPE html>

<html>

<head>

    <title>

        Refund Receipt

    </title>

    <style>

        body{
            font-family: Arial;
            padding: 30px;
        }

        .header{
            text-align:center;
            margin-bottom:30px;
        }

        .table{
            width:100%;
            border-collapse: collapse;
        }

        .table td,
        .table th{
            border:1px solid #ccc;
            padding:10px;
        }

        .text-end{
            text-align:right;
        }

    </style>

</head>

<body onload="window.print()">

<div class="header">

    <h2>

        Hospital Refund Receipt

    </h2>

</div>

<table class="table">

    <tr>

        <th>Refund No</th>

        <td>{{ $refund->refund_no }}</td>

    </tr>

    <tr>

        <th>Patient Name</th>

        <td>

            {{ $refund->patient->first_name ?? '' }}
            {{ $refund->patient->last_name ?? '' }}

        </td>

    </tr>

    <tr>

        <th>Patient Code</th>

        <td>

            {{ $refund->patient->patient_code ?? '' }}

        </td>

    </tr>

    <tr>

        <th>Refund Type</th>

        <td>

            {{ $refund->refund_type }}

        </td>

    </tr>

    <tr>

        <th>Refund Amount</th>

        <td>

            ₹ {{ number_format($refund->refund_amount, 2) }}

        </td>

    </tr>

    <tr>

        <th>Refund Date</th>

        <td>

            {{ $refund->refund_date->format('d-m-Y') }}

        </td>

    </tr>

    <tr>

        <th>Refund Mode</th>

        <td>

            {{ $refund->refund_mode }}

        </td>

    </tr>

    <tr>

        <th>Transaction No</th>

        <td>

            {{ $refund->transaction_no ?? '-' }}

        </td>

    </tr>

    <tr>

        <th>Reason</th>

        <td>

            {{ $refund->refund_reason }}

        </td>

    </tr>

</table>

<br><br>

<div class="text-end">

    <strong>

        Authorized Signature

    </strong>

</div>

</body>

</html>