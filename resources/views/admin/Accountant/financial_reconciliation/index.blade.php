@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Financial Reconciliation</h5>
        </div>

        <div class="page-header-right ms-auto d-flex align-items-center gap-2">

        <!-- Search -->
        <form method="GET" action="{{ route('admin.financial-reconciliation.index') }}" class="d-flex">
            <input type="date"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Search ..."
                   style="width: 220px;">

            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>
        </form>

        <!-- Add Button -->
        <a href="{{ route('admin.financial-reconciliation.create') }}" class="btn btn-primary">
            <i class="feather-plus me-2"></i> New Reconciliation
        </a>

        <!-- Deleted Button -->
        <a href="{{ route('admin.financial-reconciliation.deleted') }}" class="btn btn-danger">
            Deleted Reconciliations
        </a>
                

    </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">

    {{ session('success') }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">
    </button>

</div>

@endif

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-bordered align-middle">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reconciliation id</th>
                        <th>Date</th>
                        <th>Total Cash</th>
                        <th>Total Digital</th>
                        <th>Bank Deposit</th>
                        <th>Difference</th>
                        <th>Status</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($reconciliations as $key => $item)

                        <tr>

                            <td>{{ $key + 1 }}</td>
                            <td> REC-{{ strtoupper(substr($item->id, 0, 6)) }} </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->reconciliation_date)->format('d M Y') }}
                            </td>

                            <td>
                                ₹ {{ number_format($item->total_cash, 2) }}
                            </td>

                            <td>
                                ₹ {{ number_format($item->total_digital, 2) }}
                            </td>

                            <td>
                                ₹ {{ number_format($item->total_bank_deposit, 2) }}
                            </td>

                            <td>
                                ₹ {{ number_format($item->difference_amount, 2) }}
                            </td>

                            <td>
                                @if($item->status == 'Matched')
                                    <span class="badge bg-success">
                                        {{ $item->status }}
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>
                             <td>
                                <div class="d-flex gap-2 align-items-center">

                                {{--Edit --}}
                                    <a href="{{ route('admin.financial-reconciliation.edit', $item->id) }}"
                                        
                                        class="avatar-text avatar-md" title="Edit">
                                        <i class="feather feather-edit"></i>
                                    </a>
                                {{--View --}}
                                    <a href="{{ route('admin.financial-reconciliation.view', $item->id) }}"
                                        class="avatar-text avatar-md" title="View">
                                        <i class="feather feather-eye"></i>
                                    </a>

                                   {{---Delete--}}
                                   <form action="{{ route('admin.financial-reconciliation.delete', $item->id) }}"
                                        method="POST"
                                        class="m-0"
                                        onsubmit="return confirm('Move this reconciliation to deleted list?')">

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
                                No reconciliation records found
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection