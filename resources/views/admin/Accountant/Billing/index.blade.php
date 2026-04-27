@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>IPD Billing Management</h3>

        <a href="{{ route('admin.accountant.billing.create') }}" 
        class="btn btn-success">
            + New Billing
        </a>
    </div>

    {{-- Filters --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">

                <div class="col-md-3">
                    <label>Patient Name</label>
                    <input type="text" class="form-control" placeholder="Search patient...">
                </div>

                <div class="col-md-3">
                    <label>IPD No</label>
                    <input type="text" class="form-control" placeholder="IPD number">
                </div>

                <div class="col-md-3">
                    <label>Status</label>
                    <select class="form-control">
                        <option value="">All</option>
                        <option>Interim</option>
                        <option>Final</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>

            </div>
        </div>
    </div>

    {{-- Billing Table --}}
    <div class="card">
        <div class="card-header">
            Patient Billing List
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>IPD No</th>
                        <th>Admission Date</th>
                        <th>Room</th>
                        <th>Doctor</th>
                        <th>Status</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($patients as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p['name'] }}</td>
                        <td>{{ $p['ipd_no'] }}</td>
                        <td>{{ $p['admission_date'] }}</td>
                        <td>{{ $p['room'] }}</td>
                        <td>{{ $p['doctor'] }}</td>

                        <td>
                            @if($p['status'] == 'Final')
                                <span class="badge bg-success">Final</span>
                            @else
                                <span class="badge bg-warning text-dark">Interim</span>
                            @endif
                        </td>

                        <td class="text-center">

                            <a href="{{ route('admin.accountant.billing.view', $p['id']) }}"
                            class="text-info me-2" title="View">
                                <i class="feather-eye"></i>
                            </a>

                            <a href="{{ route('admin.accountant.billing.edit', $p['id']) }}"
                            class="text-primary" title="Edit">
                                <i class="feather-edit"></i>
                            </a>

                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No Records Found</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection