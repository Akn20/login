@extends('layouts.admin')

@section('page-title', 'Patient Monitoring | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Patient Monitoring</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">Patient Monitoring</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.patientMonitoring.trash') }}" class="btn btn-neutral">
                    Deleted Records
                </a>

                <a href="{{ route('admin.patientMonitoring.create') }}" class="btn btn-neutral">
                    Record Vitals
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table table-hover">

                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Patient</th>
                                            <th>Temperature</th>
                                            <th>Blood Pressure</th>
                                            <th>Pulse</th>
                                            <th>Respiratory</th>
                                            <th>SpO2</th>
                                            <th>Blood Sugar</th>
                                            <th>Weight</th>
                                            <th>Recorded At</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($vitals as $index => $vital)

                                            <tr>

                                                <td>{{ $index + 1 }}</td>

                                                <td>
                                                    {{ $vital->patient->first_name }} {{ $vital->patient->last_name }}
                                                </td>

                                                <td>{{ $vital->temperature ?? '-' }}</td>

                                                <td>
                                                    {{ $vital->blood_pressure_systolic }}/{{ $vital->blood_pressure_diastolic }}
                                                </td>

                                                <td>{{ $vital->pulse_rate ?? '-' }}</td>

                                                <td>{{ $vital->respiratory_rate ?? '-' }}</td>

                                                <td>{{ $vital->spo2 ?? '-' }}</td>

                                                <td>{{ $vital->blood_sugar ?? '-' }}</td>

                                                <td>{{ $vital->weight ?? '-' }}</td>

                                                <td>
                                                    {{ \Carbon\Carbon::parse($vital->recorded_at)->format('d-m-Y H:i') }}
                                                </td>

                                                <td class="text-end">

                                                    <div class="hstack gap-2 justify-content-end">

                                                        <a href="{{ route('admin.patientMonitoring.show', $vital->id) }}"
                                                            class="avatar-text avatar-md action-icon">
                                                            <i class="feather-eye"></i>
                                                        </a>

                                                        <a href="{{ route('admin.patientMonitoring.edit', $vital->id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        <form action="{{ route('admin.patientMonitoring.delete', $vital->id) }}"
                                                            method="POST" onsubmit="return confirm('Delete this record?')">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-delete">

                                                                <i class="feather-trash-2"></i>

                                                            </button>

                                                        </form>

                                                    </div>

                                                </td>

                                            </tr>

                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection