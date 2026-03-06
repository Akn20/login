@extends('layouts.admin')

@section('page-title', 'Duplicate Patients | ' . config('app.name'))

@section('content')

<div class="page-header mb-4">
    <h5>Duplicate Patients</h5>
</div>

<div class="card">
    <div class="card-body">

        @forelse($groups as $group)

            <form method="POST" action="{{ route('admin.patients.merge') }}" class="mb-4">
                @csrf

                <h6>
                    {{ $group[0]->first_name }} {{ $group[0]->last_name }}
                    ({{ $group[0]->mobile }})
                </h6>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Select Master</th>
                            <th>Patient Code</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group as $patient)
                            <tr>
                                <td>
                                    <input type="radio"
                                           name="master_id"
                                           value="{{ $patient->id }}"
                                           required>
                                    <input type="hidden"
                                           name="duplicate_ids[]"
                                           value="{{ $patient->id }}">
                                </td>
                                <td>{{ $patient->patient_code }}</td>
                                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                <td>{{ $patient->email ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn btn-danger">
                    Merge Selected
                </button>
            </form>

        @empty
            <p>No duplicate patients found.</p>
        @endforelse

    </div>
</div>

@endsection