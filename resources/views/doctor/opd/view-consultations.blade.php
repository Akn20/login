@extends('layouts.admin')

@section('content')

    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">

            <div class="card-header">
                <h4>Patient Consultations</h4>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th class="text-center">Token</th>
                            <th class="text-center">Patient Name</th>
                            <th class="text-center">Consultation Date</th>
                            <th class="text-center">Consultation Time</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($consultations as $consultation)

                            <tr>

                                {{-- Token --}}
                                <td class="text-center">
                                    {{ 100 + $loop->iteration }}
                                </td>

                                {{-- Patient Name --}}
                                <td class="text-center">
                                    {{ $consultation->patient->first_name }}
                                    {{ $consultation->patient->last_name }}
                                </td>

                                {{-- Consultation Date --}}
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d-m-Y') }}
                                </td>

                                {{-- Consultation Time --}}
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('h:i A') }}
                                </td>

                                {{-- Action --}}
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('doctor.edit-consultation', $consultation->id) }}"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <a href="{{ route('doctor.consultation-summary', ['id' => $consultation->id]) }}"
                                            class="btn btn-primary btn-sm">
                                            Generate Consultation Summary
                                        </a>

                                        <a href="{{ route('doctor.print-prescription', $consultation->id) }}"
                                            class="btn btn-primary btn-sm">
                                            Print Prescription
                                        </a>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    No Consultations Available
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection