@extends('layouts.admin')

@section('page-title', 'Shift Report')

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">         
                    <h5 class="m-b-10">Shift Report</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">Shift Report</li>
                </ul>
            </div>
        </div>

        <div class="main-content">

            <!--Filter -->
            <form method="GET">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-end g-3">

                            <div class="col-md-4">
                                <label>Entry Type</label>
                                <select name="entry_type" class="form-control">
                                    <option value="">All</option>
                                    <option value="note" {{ request('entry_type') == 'note' ? 'selected' : '' }}>Note</option>
                                    <option value="task" {{ request('entry_type') == 'task' ? 'selected' : '' }}>Task</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Task Status</label>
                                <select name="task_status" class="form-control">
                                    <option value="">All</option>
                                    <option value="pending" {{ request('task_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ request('task_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-primary w-100">Filter</button>
                            </div>

                            <div class="col-md-2">
                                <a href="{{ route('admin.nurse-reports.shift') }}" class="btn btn-light w-100">Reset</a>
                            </div>

                        </div>
                    </div>
                </div>
            </form>

            <!--Table -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nurse</th>
                                    <th>Shift</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $d)
                                <tr>
                                    <td>{{ $d->nurse_name ?? 'N/A' }}</td>
                                    <td>
                                        {{ $d->shift_name }} <br>
                                        <small>{{ $d->start_time }} - {{ $d->end_time }}</small>
                                    </td>
                                    <td>{{ ucfirst($d->entry_type) }}</td>
                                    <td>{{ $d->description }}</td>
                                    <td>
                                        <span class="badge {{ $d->task_status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                            {{ $d->task_status ?? 'No status' }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{ $data->links() }}
        </div>
    </div>
@endsection