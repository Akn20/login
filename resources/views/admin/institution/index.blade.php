@extends('layouts.admin')

@section('page-title', 'Institutions | ' . config('app.name'))

@section('content')

    <div class="main-content">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header mb-4">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Institutions</h5>
                </div>
            </div>

            <div class="page-header-right ms-auto d-flex align-items-center gap-2">

                <form method="GET" action="{{ route('admin.institutions.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2"
                        placeholder="Search Institution" value="{{ request('search') }}">
                    <button class="btn btn-light-brand btn-sm">
                        <i class="feather-search"></i>
                    </button>
                </form>

                <a href="{{ route('admin.institutions.create') }}" class="btn btn-primary btn-sm">
                    <i class="feather-plus me-1"></i> Add Institution
                </a>


            </div>
        </div>

        {{-- ================= TABLE CARD ================= --}}
        <div class="card stretch stretch-full">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Institution Name</th>
                                <th>Organization</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($institutions as $institution)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-semibold">{{ $institution->name }}</td>
                                    <td>{{ $institution->organization_id ?? '-' }}</td>
                                    <td>{{ $institution->email ?? '-' }}</td>
                                    <td>
                                        @if($institution->status == 'Active')
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">

                                            <a href="{{ route('admin.institutions.edit', $institution->id) }}"
                                                class="btn btn-sm btn-light">
                                                <i class="feather-edit"></i>
                                            </a>



                                            <form action="{{ route('admin.institutions.destroy', $institution->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="feather-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        No Institutions Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer">
                {{ $institutions->links() }}
            </div>
        </div>

    </div>

@endsection