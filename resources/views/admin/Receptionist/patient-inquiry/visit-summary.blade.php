@extends('layouts.admin')

@section('content')

<div class="container">

    <h3>
        Visit Summary
    </h3>

    <div class="card">

        <div class="card-body">

            <h5>
                {{ $patient->first_name }}
                {{ $patient->last_name }}
            </h5>

            <p>
                UHID :
                {{ $patient->patient_code }}
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

            @foreach($consultations as $consultation)

                <p>

                    <strong>Date :</strong>

                    {{ $consultation->consultation_date }}

                </p>

                <p>

                    <strong>Diagnosis :</strong>

                    {{ $consultation->diagnosis }}

                </p>

                <p>

                    <strong>Symptoms :</strong>

                    {{ $consultation->symptoms }}

                </p>

                <p>

                    <strong>Doctor :</strong>

                    {{ optional($consultation->doctor)->name ?? 'N/A' }}

                </p>
   
                <hr>

            @endforeach

            <a href="{{ route('admin.patient-inquiry.print-summary',$patient->id) }}"
               class="btn btn-primary">

                Download PDF
            </a>

        </div>

    </div>

</div>

@endsection