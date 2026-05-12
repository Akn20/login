@extends('layouts.admin')

@section('content')
<div class="container-fluid">

<form method="GET" class="mb-4">
    <div class="row align-items-end">

        {{-- SEARCH --}}
        <div class="col-md-4">
            <label class="form-label">Search</label>
            <input type="text" name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Patient / IPD No">
        </div>

        {{-- STATUS --}}
        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="final" {{ request('status')=='final'?'selected':'' }}>Final</option>
                <option value="interim" {{ request('status')=='interim'?'selected':'' }}>Interim</option>
                <option value="not_created" {{ request('status')=='not_created'?'selected':'' }}>Not Created</option>
            </select>
        </div>

        {{-- BUTTONS --}}
        <div class="col-md-5">
            <div class="d-flex gap-2">

                <button type="submit" class="btn btn-primary">
                    <i class="feather-search"></i> Search
                </button>

                <a href="{{ route('admin.accountant.billing.index') }}"
                   class="btn btn-secondary">
                    Reset
                </a>

            </div>
        </div>

    </div>
</form>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>IPD Billing Management</h3>

    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-header">
            IPD Patient Billing List
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>IPD No</th>
                        <th>Admission Date</th>
                        <th>Room</th>
                        <th>Doctor</th>
                        <th>Status</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($patients as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>{{ $p->name }}</td>

                        <td>{{ $p->ipd_no }}</td>

                        <td>{{ \Carbon\Carbon::parse($p->admission_date)->format('d-m-Y') }}</td>

                        <td>{{ $p->room ?? '-' }}</td>

                        <td>{{ $p->doctor ?? '-' }}</td>

                        {{-- STATUS --}}
                        <td>
                            @if($p->bill_id)
                                @if($p->status == 'final')
                                    <span class="badge bg-success">Final</span>
                                @else
                                    <span class="badge bg-warning text-dark">Interim</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">Not Created</span>
                            @endif
                        </td>

                        {{-- ACTIONS --}}
                        <td class="text-center">

                            @if($p->bill_id)

                                {{-- VIEW --}}
                                <a href="{{ route('admin.accountant.billing.view', $p->bill_id) }}"
                                   class="text-info me-2" title="View">
                                    <i class="feather-eye"></i>
                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('admin.accountant.billing.edit', $p->bill_id) }}"
                                   class="text-primary" title="Edit">
                                    <i class="feather-edit"></i>
                                </a>

                            @else

                                {{-- CREATE --}}
                                <a href="{{ route('admin.accountant.billing.create') }}?ipd_id={{ $p->id }}"
                                   class="text-success" title="Create Bill">
                                    <i class="feather-plus-circle"></i>
                                </a>

                            @endif

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