@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif


@extends('layouts.admin')

@section('page-title', 'Medication Administration | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5>Medication Administration</h5>
                </div>
            </div>
        </div>

        <div class="main-content">

            <!-- Patient Selection -->
            <div class="card mb-4">
                <div class="card-body">

                    <form method="GET" action="{{ route('admin.medication.index') }}">

                        <div class="row">

                            <div class="col-md-6">
                                <label class="form-label">Select Patient</label>

                                <select name="patient_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">Select Patient</option>

                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->first_name }} {{ $patient->last_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                    </form>

                </div>
            </div>

            <!-- Medication Table -->
            <div class="card">

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>Sl.No.</th>
                                    <th>Medicine</th>
                                    <th>Dosage</th>
                                    <th>Frequency</th>
                                    <th>Duration</th>
                                    <th>Instructions</th>
                                    <th>Status</th>
                                    <th>Administered Time</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($medications as $index => $item)

                                                        <tr>

                                                            <td>{{ $index + 1 }}</td>

                                                            <td>{{ $item->medicine_name }}</td>

                                                            <td>{{ $item->dosage ?? '-' }}</td>

                                                            <td>{{ $item->frequency ?? '-' }}</td>

                                                            <td>{{ $item->duration ?? '-' }}</td>

                                                            <td>{{ $item->instructions ?? '-' }}</td>

                                                            <td>
                                                                <span class="badge bg-{{ 
                                                                        $item->status == 'administered' ? 'success' :
                                    ($item->status == 'missed' ? 'danger' : 'warning') 
                                                                    }}">
                                                                    {{ ucfirst($item->status ?? 'pending') }}
                                                                </span>
                                                            </td>

                                                            <td>
                                                                {{ $item->administered_time
                                    ? \Carbon\Carbon::parse($item->administered_time)->format('d-m-Y H:i')
                                    : '-' }}
                                                            </td>

                                                            <td class="text-end">

                                                                <div class="hstack gap-2 justify-content-end">

                                                                    <!-- Administer -->
                                                                    <td class="text-end">

    <div class="hstack gap-2 justify-content-end">

        @if($item->status == 'administered')

            <button class="btn btn-sm btn-success" disabled>
                Administered
            </button>

        @elseif($item->status == 'missed')

            <button class="btn btn-sm btn-danger" disabled>
                Missed
            </button>

        @else

            <!-- Administer -->
            <form action="{{ route('admin.medication.administer') }}" method="POST">
                @csrf
                <input type="hidden" name="prescription_item_id" value="{{ $item->id }}">
                <button type="submit" class="btn btn-sm btn-success">
                    Administer
                </button>
            </form>

            <!-- Missed -->
            <form action="{{ route('admin.medication.missed') }}" method="POST">
                @csrf
                <input type="hidden" name="prescription_item_id" value="{{ $item->id }}">
                <button type="submit" class="btn btn-sm btn-danger">
                    Missed
                </button>
            </form>

        @endif

    </div>

</td>

                                                                </div>

                                                            </td>

                                                        </tr>

                                @empty

                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No medications found
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection