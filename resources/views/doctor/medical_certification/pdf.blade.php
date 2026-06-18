<!DOCTYPE html>
<html>

<head>

    <title>
        Medical Certificate
    </title>

    <style>

        body {
            font-family: sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signed {
            color: green;
            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="header">

    <div class="title">
        MEDICAL CERTIFICATE
    </div>

    <p>
        Hospital Management System
    </p>

</div>


<div class="section">

    <table>

        <tr>

            <td>
                Certificate Number
            </td>

            <td>
                {{ $record->certificate_number }}
            </td>

        </tr>

        <tr>

            <td>
                Employee Name
            </td>

            <td>
                {{ $record->employee_name }}
            </td>

        </tr>

        <tr>

            <td>
                Department
            </td>

            <td>
                {{ $record->department }}
            </td>

        </tr>

        <tr>

            <td>
                Designation
            </td>

            <td>
                {{ $record->designation }}
            </td>

        </tr>

        <tr>

            <td>
                Certificate Type
            </td>

            <td>
                {{ $record->certificate_type }}
            </td>

        </tr>

        <tr>

            <td>
                Issue Date
            </td>

            <td>
                {{ $record->issue_date }}
            </td>

        </tr>

        <tr>

            <td>
                Valid From
            </td>

            <td>
                {{ $record->valid_from }}
            </td>

        </tr>

        <tr>

            <td>
                Valid Until
            </td>

            <td>
                {{ $record->valid_until }}
            </td>

        </tr>

        <tr>

            <td>
                Diagnosis / Reason
            </td>

            <td>
                {{ $record->diagnosis_reason }}
            </td>

        </tr>

        <tr>

            <td>
                Medical Remarks
            </td>

            <td>
                {{ $record->medical_remarks }}
            </td>

        </tr>

    </table>

</div>


<div class="signature">

    <p>

        Doctor:
        {{ $record->doctor_name }}

    </p>

    <p>

        Registration No:
        {{ $record->registration_number }}

    </p>

    <p>

        Hospital:
        {{ $record->hospital_name }}

    </p>


    @if($record->signature_status)

    <p class="signed">

        Digitally Signed

    </p>

    @endif

</div>

</body>
</html>