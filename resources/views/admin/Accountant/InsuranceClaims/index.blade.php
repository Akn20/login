@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="page-header mb-4">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-0">Insurance Claims</h5>
        </div>

        
    </div>

    <div class="page-header-right ms-auto d-flex align-items-center gap-2">

        <!-- Search -->
        <form method="GET" action="{{ route('admin.accountant.claims.index') }}" class="d-flex">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Search Claim..."
                   style="width: 220px;">

            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>
        </form>

        <!-- Add Button -->
        <a href="{{ route('admin.accountant.claims.create') }}" class="btn btn-primary">
            <i class="feather-plus me-2"></i> New Claim
        </a>

        <!-- Deleted Button -->
        <a href="{{ route('admin.accountant.claims.deleted') }}" class="btn btn-danger">
            Deleted Claims
        </a>
                <a href="{{ route('admin.accountant.claims.reports') }}" class="btn btn-success">
            <i class="feather-bar-chart-2 me-2"></i> Reports
        </a>

    </div>
</div>

    <div class="card">
        <div class="card-header">Claims List</div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Claim No</th>
                        <th>Patient</th>
                        <th>Provider</th>
                        <th>Billed</th>
                        <th>Approved</th>
                        <th>Paid</th>
                        <th>Difference</th>
                        <th>Paid Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($claims as $index => $claim)

                    @php
                        $approved = $claim->approval->approved_amount ?? 0;
                        $paid = $claim->payments->sum('payment_amount');
                        $diff = $approved - $paid;
                    @endphp

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $claim->claim_number }}</td>
                        <td>{{ $claim->patient->first_name ?? '-' }} {{ $claim->patient->last_name ?? '-' }}</td>
                        <td>{{ $claim->insurance_provider }}</td>
                        <td>{{ $claim->billed_amount }}</td>
                        <td>{{ $approved }}</td>
                        <td>{{ $paid }}</td>
                        <td>{{ $diff }}</td>
                        <td>
                            @if($claim->payments->isNotEmpty())
                                {{ $claim->payments->last()->payment_date->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($claim->status == 'pending')
                                <span class="badge bg-warning">Pending</span>

                            @elseif($claim->status == 'partial')
                                <span class="badge bg-info">Partial</span>

                            @elseif($claim->status == 'approved')
                                <span class="badge bg-success">Approved</span>

                            @elseif($claim->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>



                         <td>
                                <div class="d-flex gap-2 align-items-center">

                                {{--Edit --}}
                                    <a href="{{ route('admin.accountant.claims.edit', $claim->id) }}"
                                        
                                        class="avatar-text avatar-md" title="Edit">
                                        <i class="feather feather-edit"></i>
                                    </a>
                                {{--View --}}
                                    <a href="{{ route('admin.accountant.claims.view', $claim->id) }}"
                                        class="avatar-text avatar-md" title="View">
                                        <i class="feather feather-eye"></i>
                                    </a>

                                   {{---Delete--}}
                                   <form action="{{ route('admin.accountant.claims.delete', $claim->id) }}"
                                        method="POST"
                                        class="m-0"
                                        onsubmit="return confirm('Move this claim to deleted list?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                            data-bs-toggle="tooltip"
                                            title="Delete">
                                            <i class="feather feather-trash-2"></i>
                                        </button>

                                    </form>
                            </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No Claims Found</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection