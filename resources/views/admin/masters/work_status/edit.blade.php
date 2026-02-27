@extends('layouts.admin')

@section('content')
<<<<<<< HEAD
 <div class="container">

    <h3 class="mb-3">Edit Work Status</h3>

    <div class="card">
        <div class="card-body">

<form action="{{ route('admin.work-status.update', $workStatus->id) }}" method="POST">
                @csrf

                <div class="mb-3">
    <label class="form-label">Work Status Code</label>
    <input type="text" name="work_status_code" class="form-control"
        value="{{ $workStatus->work_status_code }}">
</div>

<div class="mb-3">
    <label class="form-label">Work Status Name</label>
    <input type="text" name="work_status_name" class="form-control"
        value="{{ $workStatus->work_status_name }}">
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ $workStatus->description }}</textarea>
</div>


                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="Active"
                            {{ $workStatus->status == 'Active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="Inactive"
                            {{ $workStatus->status == 'Inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('admin.work-status.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
 @endsection
=======
    <div class="container">

        <h3 class="mb-3">Edit Work Status</h3>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.work-status.update', $workStatus->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Work Status Code</label>
                        <input type="text" name="work_status_code" class="form-control"
                            value="{{ $workStatus->work_status_code }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Work Status Name</label>
                        <input type="text" name="work_status_name" class="form-control"
                            value="{{ $workStatus->work_status_name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control">{{ $workStatus->description }}</textarea>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="Active" {{ $workStatus->status == 'Active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="Inactive" {{ $workStatus->status == 'Inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>

                        <a href="{{ route('admin.work-status.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
>>>>>>> cbc0430ccf1712cd3f0a5246d00bbd83c3d9cd82
