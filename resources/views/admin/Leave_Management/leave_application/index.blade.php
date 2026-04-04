@extends('layouts.admin')

@section('page-title', 'Leave Application | ' . config('app.name'))

@section('content')
{{-- Success Message --}}
@if(session('success'))

<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="page-header mb-4 d-flex align-items-center justify-content-between flex-wrap">

<div class="page-header-left d-flex flex-column">
    <h5 class="m-b-10 mb-1">Leave Application</h5>

    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Leave Application</li>
    </ul>
</div>

<div class="d-flex gap-2 align-items-center ms-auto">

    <form method="GET" action="#" class="d-flex gap-2">

        <input type="text"
               id="leaveSearch"
               name="search"
               class="form-control form-control-sm"
               placeholder="Search Leave..."
               style="width:200px;">

        <button class="btn btn-light btn-sm border">
            <i class="feather-search"></i>
        </button>

    </form>

    {{-- Apply Leave Button --}}
    <a href="{{ route('hr.leave-application.create') }}" class="btn btn-primary">
        <i class="feather-plus me-1"></i> Apply Leave
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
<th>Leave Name</th>
<th>Number of Days</th>
<th>Balance Before</th>
<th>Balance After</th>
<th>Leave Applied Date</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody id="leaveTable">

@forelse($applications as $key => $application)

<tr>
<td>{{ $application->leaveType->display_name ?? '-' }}</td>

<td>{{ $application->leave_days }}</td>

<td>{{ $application->balance_before }}</td>

<td>{{ $application->balance_after }}</td>

<!-- <td>{{ \Carbon\Carbon::parse($application->from_date)->format('d/m/Y') }}</td> -->
<td>{{ \Carbon\Carbon::parse($application->created_at)->format('d/m/Y') }}</td>
<td>
@if($application->status == 'pending')
<span class="badge bg-warning">Pending</span>
@elseif($application->status == 'approved')
<span class="badge bg-success">Approved</span>
@elseif($application->status == 'rejected')
<span class="badge bg-danger">Rejected</span>
@else
<span class="badge bg-secondary">Withdrawn</span>
@endif
</td>

<td>
@if($application->status == 'pending')
<form action="{{ route('hr.leave-application.withdraw',$application->id) }}" method="POST">
@csrf
@method('DELETE')
<button class="btn btn-sm btn-danger">Withdraw</button>
</form>
@else
<button class="btn btn-sm btn-secondary" disabled>Withdraw</button>
@endif
</td>

</tr>

@empty

<tr>
<td colspan="8" class="text-center">No leave applications found</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

</div>
</div>

{{-- SEARCH SCRIPT --}}
<script>

document.getElementById("leaveSearch").addEventListener("keyup", function() {

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll("#leaveTable tr");

    rows.forEach(function(row){

        let text = row.innerText.toLowerCase();

        if(text.includes(value)){
            row.style.display = "";
        }else{
            row.style.display = "none";
        }

    });

});

</script>

@endsection