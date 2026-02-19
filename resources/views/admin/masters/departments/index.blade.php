@extends('layouts.admin')

@section('page-title', 'Departments | ' . config('app.name'))

@section('content')
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Departments</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Masters</li>
                    <li class="breadcrumb-item">Departments</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.departments.deleted') }}" class="btn btn-primary">
                    View Deleted Records
                </a>
                <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">+ Add Department</a>
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
                                            <th>S.No</th>
                                            <th>Department Name</th>
                                            <th>Department Code</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th class="text-end" style="width:160px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($departments as $i => $d)
                                            <tr>
                                                <td>{{ $departments->firstItem() + $i }}</td>
                                                <td class="fw-semibold">{{ $d->department_name }}</td>
                                                <td>{{ $d->department_code }}</td>
                                                <td>{{$d->description}}</td>
                                                <td>
                                                    @if($d->status)
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <a class="avatar-text avatar-md action-icon action-edit" title="Edit"
                                                            href="{{ route('admin.departments.edit', $d->id) }}">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        <form method="POST" class="m-0 p-0"
                                                            action="{{ route('admin.departments.destroy', $d->id) }}"
                                                            onsubmit="return confirm('Delete this department?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="avatar-text avatar-md action-icon action-delete"
                                                                title="Delete">
                                                                <i class="feather-trash-2"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">No departments available.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $departments->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection