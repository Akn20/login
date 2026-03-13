@extends('layouts.admin')

@section('content')

<style>
.btn-warning {
    background-color: #ffc107 !important;
    border-color: #ffc107 !important;
    color: #212529 !important;
}

.btn-warning:hover {
    background-color: #e0a800 !important;
    border-color: #d39e00 !important;
}

.action-icon.btn-warning {
    background-color: #ffc107 !important;
    border-color: #ffc107 !important;
    color: #212529 !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    position: relative;
}

.action-icon.btn-warning:hover {
    background-color: #e0a800 !important;
    border-color: #d39e00 !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.5);
}

.badge-sm {
    font-size: 0.6em;
    padding: 0.1em 0.3em;
}
</style>

<div class="container">

    <div class="d-flex justify-content-between mb-3">

        <h3>Surgery Management</h3>

        <a href="{{ route('surgery.create') }}" class="btn btn-primary">
            Schedule Surgery
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="card">

        <div class="card-header">
            <h5>Scheduled Surgeries</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Patient</th>

                        <th>Patient Name</th>

                        <th>Surgery Type</th>

                        <th>Date</th>

                        <th>Surgeon</th>

                        <th>Priority</th>

                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($surgeries as $surgery)

                    <tr>

                        <td>{{ $surgery->patient_id }}</td>

                        <td>{{ $surgery->patient->first_name }} {{ $surgery->patient->last_name }}</td>

                        <td>{{ $surgery->surgery_type }}</td>

                        <td>{{ $surgery->surgery_date }}</td>

                        <td>{{ $surgery->surgeon->name ?? 'N/A' }}</td>

                        <td>

                            @if($surgery->priority == 'Emergency')

                                <span class="badge bg-danger">Emergency</span>

                            @else

                                <span class="badge bg-success">Normal</span>

                            @endif

                        </td>

                        <td class="text-end">
                            <div class="hstack gap-2 justify-content-end">
                                {{-- Post Op --}}
                                <a href="{{ route('prescriptions.post.create',$surgery->id) }}"
                                    class="avatar-text avatar-md action-icon {{ !in_array($surgery->id, $surgeriesWithPostOp) ? 'btn-warning' : '' }}"
                                    title="Post Op {{ !in_array($surgery->id, $surgeriesWithPostOp) ? '(Pending)' : '' }}">
                                    <i class="feather-file-text"></i>
                                    @if(!in_array($surgery->id, $surgeriesWithPostOp))
                                        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle badge-sm">!</span>
                                    @endif
                                </a>

                                {{-- Edit --}}
                                <a href="{{route('prescriptions.post.edit',$surgery->id) }}"
                                    class="avatar-text avatar-md action-icon action-edit" title="Edit">
                                    <i class="feather-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('surgery.destroy',$surgery->id) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this surgery?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="avatar-text avatar-md action-icon action-delete"
                                        title="Delete">
                                        <i class="feather-trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">
                            No Surgeries Scheduled
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection