@extends('layouts.admin')

@section('page-title', 'Shift Management | ' . config('app.name'))
@section('content')

<div class="nxl-content">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Add Handover Notes</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Nurse</li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.nurse-shifts.index') }}">Shift Management</a>
                </li>
                <li class="breadcrumb-item">Add Handover Notes</li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card stretch stretch-full ">
                    <div class="card-body">
                        <form action="{{ route('admin.nurse-shifts.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="shift_assignment_id" value="{{ $shift->id }}">

                            <div class="mb-3">
                                <label>Type</label>
                                <select name="entry_type" class="form-control">
                                    <option value="note">Note</option>
                                    <option value="task">Task</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4"></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Task Status (only if task)</label>
                                <select name="task_status" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('admin.nurse-shifts.index') }}" class="btn btn-light"> Cancel</a>
                            </div>
                        </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection