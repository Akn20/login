@extends('layouts.admin')

@section('title', 'Sales Return Details')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Sales Return Details</h4>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.salesReturn.index') }}" class="btn btn-light">
                Back
            </a>

            @if($salesReturn->status == 'Draft')
                <a href="{{ route('admin.salesReturn.edit', $salesReturn->id) }}" class="btn btn-light">
                    Edit
                </a>
            @endif

            <button class="btn btn-light" onclick="printReturn()">
                Print
            </button>
        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-3">
                    <small class="text-muted d-block">Return No</small>
                    <strong>{{ $salesReturn->return_number }}</strong>
                </div>

                <div class="col-md-3">
                    <small class="text-muted d-block">Bill No</small>
                    <strong>{{ $salesReturn->bill->bill_number ?? '-' }}</strong>
                </div>

                <div class="col-md-3">
                    <small class="text-muted d-block">Patient</small>
                   <strong>
{{ $salesReturn->patient 
    ? $salesReturn->patient->first_name . ' ' . $salesReturn->patient->last_name 
    : '-' 
}}
</strong>
                </div>

                <div class="col-md-3">
                    <small>Status</small>
                    @php
                        $badge = [
                            'Draft' => 'secondary',
                            'Submitted' => 'warning',
                            'Approved' => 'success',
                            'Rejected' => 'danger',
                            'Completed' => 'primary'
                        ];
                    @endphp
                    <span class="badge bg-{{ $badge[$salesReturn->status] }}">
                        {{ $salesReturn->status }}
                    </span>
                </div>

                <div class="col-md-3">
                    <small class="text-muted d-block">Return Date</small>
                    <strong>{{ $salesReturn->created_at->format('Y-m-d') }}</strong>
                </div>

                <div class="col-md-3">
                    <small>Total Refund</small>
                    <strong>₹ {{ number_format($salesReturn->total_refund,2) }}</strong>
                </div>

               <div class="col-md-3">
    <small>Refund Mode</small>
    <strong>Cash</strong>
</div>

                <div class="col-md-3">
                    <small>Created By</small>
                    <strong>{{ $salesReturn->creator->name ?? '-' }}</strong>
                </div>

            </div>
        </div>
    </div>

    {{-- ITEMS --}}
    <div class="card mb-3">
        <div class="card-header">
            Returned Items
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Medicine</th>
                        <th>Batch</th>
                        <th>Return Qty</th>
                        <th>Unit Price</th>
                        <th>Refund</th>
                        <th>Reason</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($salesReturn->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->medicine->medicine_name ?? '-' }}</td>
                        <td>{{ $item->batch->batch_number }}</td>
                        <td>{{ $item->quantity }}</td>

                        <td>
                            ₹ {{ $item->quantity ? number_format($item->refund_amount / $item->quantity, 2) : 0 }}                        
                        </td>
                        <td>
                            ₹ {{ number_format($item->refund_amount,2) }}
                        </td>

                        <td>{{ $item->reason ?? '-' }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

            <div class="text-end mt-3">
                <strong>Total Refund: ₹ {{ number_format($salesReturn->total_refund,2) }}</strong>
            </div>
        </div>
    </div>

    {{-- APPROVAL SECTION --}}
    @if($salesReturn->status == 'Submitted')

    <div class="card">
        <div class="card-header">
            Approval Actions
        </div>

        <div class="card-body d-flex gap-2">

            <form method="POST" action="{{ route('admin.salesReturn.approve', $salesReturn->id) }}">
                @csrf
                <button class="btn btn-success">Approve</button>
            </form>

            <form method="POST" action="{{ route('admin.salesReturn.reject', $salesReturn->id) }}">
                @csrf
                <input type="hidden" name="reason" value="Rejected by admin">
                <button class="btn btn-danger">Reject</button>
            </form>

        </div>
    </div>

    @endif

</div>
<iframe id="printFrame" style="display:none;"></iframe>

<script>
function printReturn() {
    let frame = document.getElementById('printFrame');
    frame.src = "{{ route('admin.salesReturn.print', $salesReturn->id) }}";

    frame.onload = function() {
        setTimeout(function () {
            frame.contentWindow.focus();
            frame.contentWindow.print();
        }, 50);
    };
}
</script>

@endsection
