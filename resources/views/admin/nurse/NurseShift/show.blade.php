@extends('layouts.admin')

@section('page-title', 'Shift Management | ' . config('app.name'))

@section('content')
    <div class="nxl-content">
        
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">   
                    <h5>View Handover Notes</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.nurse-shifts.index') }}">Shift Management</a> 
                    </li>
                </ul>
            </div>
            <div class="page-header-right ms-auto d-flex gap-1">
                <a href="{{ route('admin.nurse-shifts.index') }}" class="btn btn-neutral">Back</a>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full ">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($entries as $entry)
                                        <tr>
                                            <td>{{ $entry->entry_type }}</td>
                                            <td>{{ $entry->description }}</td>

                                            {{-- Status --}}
                                            <td>
                                                @if($entry->task_status == 'completed')
                                                    <span class="badge bg-soft-success text-success">Completed</span>
                                                @else
                                                    <span class="badge bg-soft-danger text-danger">Pending</span>
                                                @endif
                                            </td>

                                            <td>{{ \Carbon\Carbon::parse($entry->created_at)->format('d M Y, h:i A') }}</td>

                                            {{-- Action --}}
                                            <td>
                                                <form action="{{ route('admin.nurse-shifts.complete', $entry->id) }}" method="POST">
                                                    @csrf

                                                    <button 
                                                        class="btn btn-success btn-sm"
                                                        {{ $entry->task_status == 'completed' ? 'disabled style=cursor:not-allowed; opacity:0.6;' : '' }}
                                                    >
                                                        {{ $entry->task_status == 'completed' ? 'Completed' : 'Mark as Completed' }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No handover entries</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection