<!DOCTYPE html>
<html>
<head>

    <title>
        Patient Visit Summary
    </title>

</head>

<body>

<h2>
    Patient Visit Summary
</h2>

<hr>

<p>
    UHID :
    {{ $patient->patient_code }}
</p>

<p>
    Name :
    {{ $patient->first_name }}
    {{ $patient->last_name }}
</p>

<p>
    Mobile :
    {{ $patient->mobile }}
</p>

<p>
    Age :
    {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}
</p>

<p>
    Gender :
    {{ $patient->gender }}
</p>

<hr>

<table width="100%"
       border="1"
       cellspacing="0"
       cellpadding="5">

    <thead>

    <tr>

        <th>Date</th>

        <th>Symptoms</th>

        <th>Diagnosis</th>

    </tr>

    </thead>

    <tbody>

    @foreach($consultations as $consultation)

        <tr>

            <td>
                {{ $consultation->consultation_date }}
            </td>

            <td>
                {{ $consultation->symptoms }}
            </td>

            <td>
                {{ $consultation->diagnosis }}
            </td>

        </tr>

    @endforeach

    </tbody>

</table>

</body>
</html>