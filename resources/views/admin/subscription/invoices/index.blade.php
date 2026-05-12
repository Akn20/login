@extends('layouts.admin')

@section('title', 'Subscription Invoices')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                Subscription Invoices
            </h4>

            <p class="text-muted mb-0">
                Manage billing invoices
            </p>

        </div>
         {{-- CREATE BUTTON --}}
    <a href="{{ route('admin.subscription.invoices.create') }}"
       class="btn btn-primary">

        <i class="feather-plus"></i>

        Create Invoice

    </a>

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

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Invoice No</th>

                            <th>Organization</th>

                            <th>Plan</th>

                            <th>Total Amount</th>

                            <th>Invoice Date</th>

                            <th>Due Date</th>

                            <th>Status</th>

                            <th width="150">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($invoices as $invoice)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $invoice->invoice_number }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $invoice->subscription->organization->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $invoice->subscription->plan->name ?? '-' }}
                                </td>

                                <td>
                                    ₹ {{ number_format($invoice->total_amount, 2) }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
                                </td>

                                <td>

                                    @if($invoice->status == 'paid')

                                        <span class="badge bg-success">
                                            Paid
                                        </span>

                                    @elseif($invoice->status == 'pending')

                                        <span class="badge bg-warning">
                                            Pending
                                        </span>

                                    @elseif($invoice->status == 'overdue')

                                        <span class="badge bg-danger">
                                            Overdue
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Cancelled
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.subscription.invoices.edit', $invoice->id) }}"
                                           class="btn btn-sm btn-warning">

                                            <i class="feather-edit"></i>

                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('admin.subscription.invoices.delete', $invoice->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete invoice?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">

                                                <i class="feather-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9"
                                    class="text-center py-5">

                                    No invoices found

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