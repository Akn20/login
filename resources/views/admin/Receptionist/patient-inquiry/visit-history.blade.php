@extends('layouts.admin')

@section('content')

<div class="container">

    

    <div class="container-fluid">


<div class="card">

    <div class="card-header">
        <h4>
            Visit History - {{ $patient->first_name }} {{ $patient->last_name }}
        </h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Visit Date</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Visit Type</th>
                    <th>Symptoms</th>
                    <th>Diagnosis</th>
                </tr>
            </thead>

            <tbody>

                @forelse($consultations as $index => $consultation)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>
                            {{ $consultation->created_at->format('d M Y') }}
                        </td>

                        <td>
                            {{ optional($consultation->doctor->department)->department_name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ optional($consultation->doctor)->name ?? 'N/A' }}
                        </td>

                        <td>

                            @if($consultation->appointment_id)

                                <span class="badge bg-success">
                                    OPD
                                </span>

                            @else

                                <span class="badge bg-primary">
                                    IPD
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $consultation->symptoms ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $consultation->diagnosis ?? 'N/A' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">
                            No Visit History Found
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