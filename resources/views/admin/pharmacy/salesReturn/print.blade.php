@extends('layouts.admin')

@section('title', 'Print Sales Return')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body" id="printArea">

            <div class="text-center mb-3">
    <h4>Pharmacy Department</h4>
    <small>Sales Return / Refund Receipt</small>
</div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Return No:</strong> {{ $salesReturn->return_number }}</p>
                    <p><strong>Bill No:</strong> {{ $salesReturn->bill->bill_number ?? '-' }}</p>
                    <p><strong>Return Date:</strong> {{ $salesReturn->created_at->format('Y-m-d') }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Patient:</strong> {{ $salesReturn->patient_id ?? '-' }}</p>
                    <p><strong>Refund Mode:</strong> Cash</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Medicine</th>
                            <th>Batch</th>
                            <th>Return Qty</th>
                            <th>Unit Price</th>
                            <th>Refund Amount</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($salesReturn->items as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->medicine->medicine_name ?? '-' }}</td>
                            <td>{{ $item->batch->batch_number ?? '-' }}</td>
                            <td>{{ $item->quantity }}</td>

                            <td>
                              ₹ {{ $item->quantity ? number_format($item->refund_amount / $item->quantity,2) : 0 }} 
                            <td>
                                ₹ {{ number_format($item->refund_amount, 2) }}
                            </td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <div style="min-width: 300px;">
                    <div class="d-flex justify-content-between">
                        <span>Total Refund</span>
                        <strong>₹ {{ number_format($salesReturn->total_refund,2) }}</strong>
                    </div>
                </div>
            </div>

            <hr>

            <div class="text-center mt-3">
                <small>Thank You</small>
            </div>

        </div>
    </div>

</div>

<style>
@media print {
    body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: absolute; left: 0; top: 0; width: 100%; }
}
</style>
<script>
window.onload = function() {
    window.close();
};
</script>

@endsection