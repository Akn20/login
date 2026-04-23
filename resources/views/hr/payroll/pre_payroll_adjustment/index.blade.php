@extends('layouts.admin')

@section('page-title', 'Pre Payroll Adjustment')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h5 class="mb-1">Pre Payroll Adjustment</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Pre Payroll Adjustment</li>
        </ul>
    </div>

    <div>
   <a href="{{ route('hr.pre-payroll.create') }}" class="btn btn-primary">
            <i class="feather-plus me-1"></i> Add Adjustment
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Employee</th>
                        <th>Payroll Month</th>
                        <th>Working Days</th>
                        <th>Days Paid</th>
                        <th>Net Pay</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $item)
                    <tr>
                        <td>{{ $item->pre_payroll_code }}</td>
                        <td>
                            <span class="badge bg-soft-primary text-primary">
                                {{ optional($item->employee)->name }}
                            </span>
                        </td>

                        <td>{{ $item->payroll_month }}</td>

                        <td>{{ $item->working_days }}</td>

                        <td>{{ $item->days_paid }}</td>

                        <td>₹ {{ $item->net_payable }}</td>

                        <td>
                            @if($item->status == 'Approved')
                                <span class="badge bg-soft-success text-success">Approved</span>
                            @elseif($item->status == 'Submitted')
                                <span class="badge bg-soft-info text-info">Submitted</span>
                            @else
                                <span class="badge bg-soft-warning text-warning">Draft</span>
                            @endif
                        </td>
                        
   <td class="text-end d-flex justify-content-end gap-2">

 {{-- EDIT ICON --}}
@if($item->status != 'Approved')
    <a href="{{ route('hr.pre-payroll.edit', $item->id) }}" 
       class="btn btn-sm btn-light border"
       title="Edit">
        <i class="feather-edit text-primary"></i>
    </a>
@endif

    {{-- APPROVE BUTTON --}}
    @if($item->status == 'Submitted')
        <form action="{{ route('hr.pre-payroll.approve', $item->id) }}" 
              method="POST" 
              style="display:inline;">
            @csrf
            <button class="btn btn-sm btn-light border" title="Approve">
    <i class="feather-check text-success"></i>
</button>
        </form>
    @endif

    {{-- APPROVED LABEL --}}
    @if($item->status == 'Approved')
        <span class="text-success">✔ Approved</span>
    @endif

</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No records found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

            <div class="p-3">
                {{ $records->links() }}
            </div>

        </div>

    </div>
</div>

@endsection