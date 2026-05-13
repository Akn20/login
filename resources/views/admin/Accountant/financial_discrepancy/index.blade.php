@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header">
        <div class="page-header-left">
            <h5>Financial Discrepancies</h5>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <form method="GET"
      action="{{ route('admin.financial-discrepancy.search') }}"
      class="d-flex align-items-center gap-2">

    <input type="text"
           name="search"
           value="{{ request('search') }}"
           class="form-control"
           placeholder="Search Issue Type...">

    <select name="status"
            class="form-control">

        <option value="">
            All Status
        </option>

        <option value="Open"
            {{ request('status') == 'Open' ? 'selected' : '' }}>
            Open
        </option>

        <option value="Resolved"
            {{ request('status') == 'Resolved' ? 'selected' : '' }}>
            Resolved
        </option>

    </select>

    <button type="submit"
            class="btn btn-primary">

        <i class="feather-search"></i>

    </button>

</form>

            <a href="{{ route('admin.financial-discrepancy.create') }}"
               class="btn btn-primary">
                + New Discrepancy
            </a>

            <a href="{{ route('admin.financial-discrepancy.deleted') }}"
               class="btn btn-danger">
                Deleted Records
            </a>

        </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    <div class="card mt-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead>
                        <tr>

                            <th>#</th>

                            <th>Reconciliation id</th>

                            <th>Issue Type</th>

                            <th>Expected</th>

                            <th>Actual</th>

                            <th>Difference</th>

                            <th>Status</th>

                            <th>Remarks</th>

                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>

                        @forelse($discrepancies as $key => $item)

                            <tr>

                                <td>{{ $key + 1 }}</td>

                                <td> REC-{{ strtoupper(substr($item->financialReconciliation->id, 0, 6)) }} | {{ \Carbon\Carbon::parse( $item->financialReconciliation->reconciliation_date )->format('d M Y') }} </td>

                                <td>{{ $item->issue_type }}</td>

                                <td>₹ {{ number_format($item->expected_amount, 2) }}</td>

                                <td>₹ {{ number_format($item->actual_amount, 2) }}</td>

                                <td>

                                    <span class="{{ $item->difference_amount != 0 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">

                                        ₹ {{ number_format($item->difference_amount, 2) }}

                                    </span>

                                </td>

                                <td>

                                    @if($item->status == 'Resolved')

                                        <span class="badge bg-success">
                                            Resolved
                                        </span>

                                    @elseif($item->status == 'Under Review')

                                        <span class="badge bg-warning">
                                            Under Review
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Open
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $item->remarks ?? '-' }}
                                </td>

                                <td>
                                <div class="d-flex gap-2 align-items-center">

                                {{--Edit --}}
                                    <a href="{{ route('admin.financial-discrepancy.edit', $item->id) }}"
                                        
                                        class="avatar-text avatar-md" title="Edit">
                                        <i class="feather feather-edit"></i>
                                    </a>
                                {{--View --}}
                                    <a href="{{ route('admin.financial-discrepancy.view', $item->id) }}"
                                        class="avatar-text avatar-md" title="View">
                                        <i class="feather feather-eye"></i>
                                    </a>

                                   {{---Delete--}}
                                   <form action="{{ route('admin.financial-discrepancy.delete', $item->id) }}"
                                        method="POST"
                                        class="m-0"
                                        onsubmit="return confirm('Move this discrepancy to deleted list?')">

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
                                <td colspan="8" class="text-center">
                                    No discrepancies found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection