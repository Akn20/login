@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Medication Report</h3>

    <!-- Filters -->
    <form method="GET" class="mb-3">
        <input type="text" name="patient_id" placeholder="Patient ID" class="form-control mb-2">

        <select name="status" class="form-control mb-2">
            <option value="">All</option>
            <option value="administered">Administered</option>
            <option value="missed">Missed</option>
        </select>

        <button class="btn btn-primary">Filter</button>
    </form>

    <!-- Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Medication</th>
                <th>Status</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $m)
            <tr>
                <td>{{ $m->patient_id }}</td>
                <td>{{ $m->medication_name }}</td>
                <td>{{ $m->status }}</td>
                <td>{{ $m->administered_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $data->links() }}
</div>
@endsection