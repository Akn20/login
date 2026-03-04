@extends('layouts.admin') 

@section('page-title', 'Leave Mapping | ' . config('app.name'))

@section('content')
    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-left">
            <h5 class="m-b-10 mb-1">Leave Mapping</h5> {{-- Title from your requirement  --}}
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Mapping List</li>
            </ul>
        </div>

        <div class="d-flex gap-2 align-items-center">
            {{-- Add Mapping Button --}}
            <a href="{{ route('admin.leave-mappings.create') }}" class="btn btn-primary">
                <i class="feather-plus me-1"></i> Add Leave Mapping
            </a>

            <a href="{{ route('admin.leave-mappings.deleted') }}" class="btn btn-danger">
                Deleted Records
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card stretch stretch-full">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                   <th>Leave Type</th> 
                                    <th>Employee Status</th> 
                                  <th>Accrual</th> 
                                    <th>Carry Forward</th> 
                                    <th>Category </th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @foreach($mappings as $mapping)
                                    <tr>
                                        <td>
                                            <span class="badge bg-soft-primary text-primary">
                                                {{ $mapping->leaveType->display_name }} {{-- Blue badge style  --}}
                                            </span>
                                        </td>
                                        <td>{{ is_array($mapping->employee_status) ? implode(', ', $mapping->employee_status) : $mapping->employee_status }}</td>
                                        <td>{{ $mapping->accrual_value }} / {{ $mapping->accrual_frequency }}</td>
                                        <td>
                                            @if($mapping->carry_forward_allowed)
                                                <span class="text-success">Yes (Max: {{ $mapping->carry_forward_limit }})</span> {{-- Green for Yes  --}}
                                            @else
                                                <span class="text-danger">No</span> {{-- Red for No [cite: 157] --}}
                                            @endif
                                        </td>
                                                                            <td>
    @foreach($mapping->designations ?? [] as $role)
        <span class="badge bg-soft-info text-info">{{ ucfirst($role) }}</span>
    @endforeach
</td>
    
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('admin.leave-mappings.edit', $mapping->id) }}"
                                                    class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">
                                                   <i class="feather-edit-2"></i> {{-- Pencil icon --}}
                                                </a>

                                                <form action="{{ route('admin.leave-mappings.delete', $mapping->id) }}" method="POST"
                                                    onsubmit="return confirm('Move to trash?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-icon rounded-circle btn-sm">
                                                       <i class="feather-trash-2"></i> {{-- Trash icon  --}}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection