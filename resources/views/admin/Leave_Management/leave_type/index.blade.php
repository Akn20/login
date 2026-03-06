@extends('layouts.admin')

@section('page-title', 'Leave Type Master | ' . config('app.name'))
@section('title', 'Leave Type Master')

@section('content')



@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif


<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div class="page-header-title">
        <h5 class="m-0 mb-1">
            <i class="feather-calendar me-2"></i>Leave Type Master
        </h5>

        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Leave Type</li>
        </ul>
    </div>

    <div class="d-flex gap-2 align-items-center">

        <form method="GET" action="{{ route('admin.leave-type.index') }}" class="d-flex">

          
<input type="text"
       id="searchInput"
       name="search"
       value="{{ request('search') }}"
       class="form-control form-control-sm me-2"
       placeholder="Search Leave Type">

            <button class="btn btn-light-brand btn-sm">
                <i class="feather-search"></i>
            </button>

        </form>

        <a href="{{ route('admin.leave-type.create') }}" class="btn btn-primary">
            <i class="feather-plus me-1"></i> Add Leave Type
        </a>
<a href="{{ route('admin.leave-type.deleted') }}" 
   class="btn btn-danger">
    Deleted Leave Types
</a>

    </div>
</div>
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    clearTimeout(this.delay);

    this.delay = setTimeout(function() {
        this.form.submit();
    }.bind(this), 500); // 500ms delay
});
</script>

<div class="card stretch stretch-full">
    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Leave Type</th>
                        <th>Half Day</th>
                        <th>Approval</th>
                        
                        <th>Created Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @if(isset($leaveTypes) && $leaveTypes->count())
                        @foreach ($leaveTypes as $index => $leave)

                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $leave->display_name ?? '-' }}</td>

                            <td>
                                @if($leave->allow_half_day ?? false)
                                    Yes
                                @else
                                    No
                                @endif
                            </td>

                            <td>
                                @if($leave->approval_required ?? false)
                                    Required
                                @else
                                    Not Required
                                @endif
                            </td>

                            

                            <td>
                                {{ $leave->created_at ?? '-' }}
                            </td>

                            <td class="text-end">

                                <div class="d-flex justify-content-end gap-2">

                                    <a href="{{ route('admin.leave-type.edit', $leave->id) }}"
                                       class="btn btn-outline-secondary btn-icon rounded-circle">
                                        <i class="feather-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.leave-type.delete', $leave->id) }}"
      method="POST"
      onsubmit="return confirm('Are you sure you want to delete this leave type?');"
      style="display:inline;">

    @csrf
    @method('DELETE')

    <button type="submit"
        class="btn btn-outline-danger btn-icon rounded-circle">
        <i class="feather-trash"></i>
    </button>

</form>

                                </div>

                            </td>
                        </tr>

                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">
                                No Leave Types Found
                            </td>
                        </tr>
                    @endif

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection