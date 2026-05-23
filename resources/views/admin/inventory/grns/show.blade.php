@extends('layouts.admin')

@section('content')

<div class="container">

    <h3 class="mb-4">
        GRN Details
    </h3>

    <div class="card">

        <div class="card-body">

            <p>
                <strong>GRN No:</strong>
                {{ $grn->grn_number }}
            </p>

            <p>
                <strong>PO Number:</strong>
                {{ $grn->purchaseOrder->po_number }}
            </p>

            <p>
                <strong>Date:</strong>
                {{ $grn->received_date }}
            </p>

            <p>
                <strong>Total:</strong>
                ₹ {{ number_format($grn->total_amount, 2) }}
            </p>

        </div>
    </div>

    <div class="card mt-4">

        <div class="card-header">
            Items
        </div>

        <div class="card-body">

            <table class="table">

                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Batch</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($grn->items as $item)

                    <tr>

                        <td>{{ $item->medicine_name }}</td>

                        <td>{{ $item->batch_no }}</td>

                        <td>{{ $item->qty }}</td>

                        <td>{{ $item->purchase_rate }}</td>

                        <td>{{ $item->amount }}</td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection