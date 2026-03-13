@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">

        <h3>Post Operative Notes</h3>

        <a href="{{ route('surgery.index') }}" class="btn btn-secondary">
            Back to Surgeries
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header">
            <h5>Post Operative Records</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Patient</th>

                        <th>Patient Name</th>

                        <th>Surgery Type</th>

                        <th>Procedure Performed</th>

                        <th>Duration</th>

                        <th>Patient Condition</th>

                        <th>Complication</th>

                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($posts as $post)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $post->surgery->patient_id }}</td>

                        <td>{{ $post->surgery->patient->first_name }} {{ $post->surgery->patient->last_name }}</td>

                        <td>{{ $post->surgery->surgery_type }}</td>

                        <td>{{ $post->procedure_performed }}</td>

                        <td>{{ $post->duration }}</td>

                        <td>{{ $post->patient_condition }}</td>

                        <td>{{ $post->complication_type ?: 'None' }}</td>

                        <td class="text-end">
                            <div class="hstack gap-2 justify-content-end">
                                <a href="{{ route('prescriptions.post.edit', $post->id) }}"
                                    class="avatar-text avatar-md action-icon action-edit" title="Edit">
                                    <i class="feather-edit"></i>
                                </a>

                                <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this postoperative record?');">
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

                        <td colspan="9" class="text-center">
                            No Post Operative Records Found
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection