@extends('layouts.admin')

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
                <h5 class="m-b-10">Deleted Nursing Notes</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Nurse</li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.nursing-notes.index') }}">Nursing Notes</a>
                </li>
                <li class="breadcrumb-item">Deleted Records</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.nursing-notes.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card stretch stretch-full">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Patient Name</th>
                                        <th>Shift</th>
                                        <th>Nurse Name</th>
                                        <th>Deleted At</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($deletedNotes as $index => $note)
                                        <tr>
                                            <td>{{ $deletedNotes->firstItem() + $index }}</td>
                                            <td>
                                                {{ $note->patient->first_name ?? '-' }}
                                                {{ $note->patient->last_name ?? '' }}
                                            </td>
                                            <td>{{ $note->shift ?? '-' }}</td>
                                            <td>{{ $note->nurse->name ?? '-' }}</td>
                                            <td>
                                                {{ $note->deleted_at ? $note->deleted_at->format('d-m-Y h:i A') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                <form action="{{ route('admin.nursing-notes.restore', $note->id) }}"
                                                      method="POST"
                                                      class="d-inline-block"
                                                      onsubmit="return confirm('Are you sure you want to restore this nursing note?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="avatar-text avatar-md action-icon action-restore border-0 bg-transparent">
                                                        <i class="feather-rotate-ccw"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                No deleted nursing notes found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="p-3">
                            {{ $deletedNotes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection