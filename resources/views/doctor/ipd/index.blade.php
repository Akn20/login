@extends('layouts.admin')

@section('content')

<style>
.card-box {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
}
.badge-active {
    background-color: #28a745;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
}
.badge-discharged {
    background-color: #dc3545;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
}
</style>

<div class="container mt-4">

    <div class="card-box">
        <h4 class="mb-3">IPD - Admitted Patients</h4>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Admission Date</th>
                    <th>Ward</th>
                    <th>Bed</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($patients as $p)
                <tr>
                    <!-- Patient -->
                    <td>
                        {{ $p->patient ? $p->patient->first_name . ' ' . $p->patient->last_name : 'N/A' }}
                    </td>

                    <!-- Date -->
                    <td>{{ $p->admission_date }}</td>

                    <!-- Ward -->
                    <td>{{ $p->ward->ward_name ?? 'N/A' }}</td>

                    <!-- Bed -->
                    <td>{{ $p->bed->room_number ?? 'N/A' }}</td>

                    <!-- Status -->
                    <td>
                        @if($p->status == 'discharged')
                            <span class="badge-discharged">Discharged</span>
                        @else
                            <span class="badge-active">Active</span>
                        @endif
                    </td>

                    <!-- Action -->
                    <td>
                        <a href="{{ route('doctor.ipd.show', $p->id) }}"
                           class="btn btn-primary btn-sm">
                           View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No patients found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection