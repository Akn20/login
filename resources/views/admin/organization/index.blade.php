@extends('layouts.admin')

@section('page-title', 'Organizations | ' . config('app.name'))

@section('content')



    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-0">Organizations</h5>
            </div>
            <ul class="breadcrumb ms-3">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.organization.index') }}">Organization</a>
                </li>
                <li class="breadcrumb-item">List</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.organization.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i> New Organization
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">

        <div class="col-lg-4 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <h6 class="text-muted">Total Organizations</h6>
                    <h3 class="fw-bold mb-0">{{ $organizations->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <h6 class="text-muted">Active</h6>
                    <h3 class="fw-bold text-success mb-0">
                        {{ $organizations->where('status', 1)->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <h6 class="text-muted">Inactive</h6>
                    <h3 class="fw-bold text-danger mb-0">
                        {{ $organizations->where('status', 0)->count() }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Organization Table -->
    <div class="row">
        <div class="col-12">
            <div class="card stretch stretch-full">
                <div class="card-body p-0">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Organization</th>
                                    <th>Type</th>
                                    <th>Email</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($organizations as $org)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            <div class="fw-bold">{{ $org->name }}</div>
                                            <small class="text-muted">{{ $org->city }}</small>
                                        </td>

                                        <td>{{ $org->type }}</td>

                                        <td>{{ $org->email }}</td>

                                        <td>
                                            <span class="badge bg-soft-primary text-primary">
                                                {{ $org->plan_type }}
                                            </span>
                                        </td>

                                        <td>
                                            @if($org->status)
                                                <span class="badge bg-soft-success text-success">
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                                    <i class="feather-more-horizontal"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.organization.edit', $org->id) }}">
                                                            <i class="feather-edit me-2"></i> Edit
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <form action="{{ route('admin.organization.destroy', $org->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="feather-trash-2 me-2"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center p-4">
                                            No Organizations Found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection