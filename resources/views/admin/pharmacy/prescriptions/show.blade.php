{{-- resources/views/admin/pharmacy/prescriptions/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Prescription Details')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h4 class="mb-0">Prescription Details</h4>
            <small class="text-muted">Pharmacy → Prescriptions → View</small>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-secondary">
                Back
            </a>

            {{-- Pending --}}
            @if($prescription->status == 'Pending')

                <a href="{{ route('admin.prescriptions.verify',$prescription->id) }}"
                   class="btn btn-primary">
                    Verify Prescription
                </a>

               <form action="{{ route('admin.prescriptions.reject',$prescription->id) }}"
                method="POST"
                style="display:inline;">
                
                @csrf

                <button type="submit" class="btn btn-danger">
                    Reject
                </button>

            </form>

            {{-- Verified --}}
            @elseif($prescription->status == 'Verified')

                <a href="{{ route('admin.prescriptions.dispense',$prescription->id) }}"
                   class="btn btn-success">
                    Dispense Medicines
                </a>

            {{-- Dispensed --}}
            @elseif($prescription->status == 'Dispensed')

                <a href="{{ route('admin.prescriptions.print',$prescription->id) }}"
                   class="btn btn-info">
                    Print Bill
                </a>

            @endif

        </div>

    </div>

    <!-- Patient & Doctor Information -->
    <div class="row">

        <!-- Patient Info -->
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <strong>Patient Information</strong>
                </div>

                <div class="card-body">

                    <p><strong>Patient Name:</strong> {{ $prescription->patient_name ?? '-' }}</p>

                    <p><strong>Phone:</strong> {{ $prescription->patient_phone ?? '-' }}</p>

                    <p><strong>Gender:</strong>
                        {{ $prescription->patient_gender ?? '-' }}
                    </p>

                </div>
            </div>

        </div>

        <!-- Doctor Info -->
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <strong>Doctor Information</strong>
                </div>

                <div class="card-body">

                    <p><strong>Doctor Name:</strong>
                        {{ $prescription->doctor_name ?? 'Offline Doctor' }}
                    </p>

                    <p><strong>Department:</strong>
                        {{ $prescription->doctor_department ?? '-' }}
                    </p>

                    <p><strong>Prescription Date:</strong>
                        {{ $prescription->prescription_date ?? '-' }}
                    </p>

                    <p><strong>Prescription Type:</strong>

                        <span class="badge bg-info">
                            {{ $prescription->prescription_type ?? '-' }}
                        </span>

                    </p>

                </div>
            </div>

        </div>

    </div>

    <!-- Medicines List -->
    <div class="card mt-3">

        <div class="card-header">
            <strong>Prescribed Medicines</strong>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($prescription->items ?? [] as $key => $item)

                        <tr>

                            <td>{{ $key+1 }}</td>

                            <td>{{ $item->medicine_name ?? $item->name ?? '-' }}</td>

                            <td>{{ $item->dosage ?? '-' }}</td>

                            <td>{{ $item->frequency ?? '-' }}</td>

                            <td>{{ $item->duration ?? '-' }}</td>

                            <td>{{ $item->instructions ?? '-' }}</td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No medicines found
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- Uploaded Prescription -->
    @if(!empty($prescription->uploaded_prescription))

    <div class="card mt-3">

        <div class="card-header">
            <strong>Uploaded Prescription</strong>
        </div>

        <div class="card-body">

            <a href="{{ asset('storage/'.$prescription->uploaded_prescription) }}"
               target="_blank"
               class="btn btn-info">

               View Uploaded Prescription

            </a>

        </div>

    </div>

    @endif

</div>

@endsection