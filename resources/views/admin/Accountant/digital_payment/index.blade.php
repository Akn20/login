@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Digital Payments</h5>
        </div>

        <div class="page-header-right ms-auto d-flex align-items-center gap-2">

        <!-- Search -->
        <form method="GET" action="{{ route('admin.digital-payment.search') }}" class="d-flex">
            <input type="text"
                   name="payment_method"
                   value="{{ request('payment_method') }}"
                   class="form-control"
                   placeholder="Search Payment Method..."

                   style="width: 220px;">

            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>
        </form>

        <!-- Add Button -->
        <a href="{{ route('admin.digital-payment.create') }}" class="btn btn-primary">
            <i class="feather-plus me-2"></i> New
        </a>

        <!-- Deleted Button -->
        <a href="{{ route('admin.digital-payment.deleted') }}" class="btn btn-danger">
            Deleted Payments
        </a>
                

    </div>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    {{-- TABLE --}}
    <div class="card">

        <div class="card-body table-responsive">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Reconciliation id</th>

                        <th>Method</th>

                        <th>Gateway</th>

                        <th>Amount</th>

                        <th>Date</th>

                        <th>Transaction Ref</th>

                        <th>Matching</th>

                        <th>Settlement</th>

                        <th width="150">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($payments as $key => $item)

                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>

    REC-{{ strtoupper(substr($item->financialReconciliation->id, 0, 6)) }}

    |

    {{ \Carbon\Carbon::parse(
        $item->financialReconciliation->reconciliation_date
    )->format('d M Y') }}

</td>

                            <td>{{ $item->payment_method }}</td>

                            <td>{{ $item->payment_gateway }}</td>

                            <td>
                                ₹ {{ number_format($item->payment_amount, 2) }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->payment_date)->format('d M Y') }}
                            </td>

                            <td>
                                {{ $item->transaction_reference ?? 'N/A' }}
                            </td>

                            {{-- MATCHING STATUS --}}
                            <td>

                                @if($item->matching_status == 'Matched')

                                    <span class="badge bg-success">
                                        Matched
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Mismatch
                                    </span>

                                @endif

                            </td>

                            {{-- SETTLEMENT STATUS --}}
                            <td>

                                @if($item->settlement_status == 'Settled')

                                    <span class="badge bg-success">
                                        Settled
                                    </span>

                                @else

                                    <span class="badge bg-warning">
                                        Pending
                                    </span>

                                @endif

                            </td>

                            {{-- ACTIONS --}}
                             <td>
                                <div class="d-flex gap-2 align-items-center">

                                {{--Edit --}}
                                    <a href="{{ route('admin.digital-payment.edit', $item->id) }}"
                                        
                                        class="avatar-text avatar-md" title="Edit">
                                        <i class="feather feather-edit"></i>
                                    </a>
                                {{--View --}}
                                    <a href="{{ route('admin.digital-payment.view', $item->id) }}"
                                        class="avatar-text avatar-md" title="View">
                                        <i class="feather feather-eye"></i>
                                    </a>

                                   {{---Delete--}}
                                   <form action="{{ route('admin.digital-payment.delete', $item->id) }}"
                                        method="POST"
                                        class="m-0"
                                        onsubmit="return confirm('Move this payment to deleted list?')">

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

                            <td colspan="9" class="text-center">

                                No digital payments found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection