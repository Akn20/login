@extends('layouts.admin')

@section('page-title', 'Breakdown Reports | ' . config('app.name'))

@section('content')

<div class="page-header mb-4">
    <div class="page-header-left d-flex align-items-center">
        <h5>Breakdown Reports</h5>
    </div>

    <div class="page-header-right ms-auto d-flex gap-2">

        <!-- SEARCH -->
        <form method="GET" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-control" placeholder="Search..." style="width:220px;">
            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>
        </form>

        <!-- ADD -->
        <a href="{{ route('admin.laboratory.breakdown.create') }}" class="btn btn-primary">
            New Breakdown
        </a>

        <!-- DELETED -->
        <a href="{{ route('admin.laboratory.breakdown.deleted') }}" class="btn btn-danger">
            Deleted
        </a>

    </div>
</div>

<div class="card stretch stretch-full">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Equipment</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Severity</th>
                        <th>Status</th>
                        <th class="text-center" style="width:120px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($breakdowns as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->equipment->name ?? '-' }}</td>

                        <td>{{ Str::limit($item->description, 40) }}</td>

                        <td>{{ $item->breakdown_date }}</td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                {{ $item->severity }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-{{ 
                                $item->status == 'Resolved' ? 'success' : 
                                ($item->status == 'Under Repair' ? 'warning text-dark' : 'secondary') 
                            }}">
                                {{ $item->status }}
                            </span>
                        </td>

                        <!-- ACTIONS -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <!-- VIEW -->
                                <a href="{{ route('admin.laboratory.breakdown.show', $item->id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle">
                                    <i class="feather-eye"></i>
                                </a>

                                <!-- EDIT -->
                                <a href="{{ route('admin.laboratory.breakdown.edit', $item->id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle">
                                    <i class="feather-edit-2"></i>
                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('admin.laboratory.breakdown.destroy', $item->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-outline-danger btn-icon rounded-circle">
                                        <i class="feather-trash-2"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Records Found</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>

    </div>

    <div class="card-footer">
        {{ $breakdowns->links() }}
    </div>

</div>

@endsection
