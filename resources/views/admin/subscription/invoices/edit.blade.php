@extends('layouts.admin')

@section('title', 'Edit Invoice')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <h4 class="mb-4">
                Edit Invoice
            </h4>

            <form action="{{ route('admin.subscription.invoices.update', $invoice->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status"
                            class="form-control">

                        <option value="pending"
                            {{ $invoice->status == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="paid"
                            {{ $invoice->status == 'paid' ? 'selected' : '' }}>
                            Paid
                        </option>

                        <option value="overdue"
                            {{ $invoice->status == 'overdue' ? 'selected' : '' }}>
                            Overdue
                        </option>

                        <option value="cancelled"
                            {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>

                </div>

                <button class="btn btn-primary">
                    Update Invoice
                </button>

            </form>

        </div>

    </div>

</div>

@endsection