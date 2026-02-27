<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>GRN Print</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; }
        .text-right { text-align: right; }
        .no-border td { border: none; }
    </style>
</head>
<body>

<div class="header">
    <div class="title">Goods Receipt Note (GRN)</div>
</div>

<table class="no-border">
    <tr>
        <td><strong>GRN No:</strong> {{ $grn->grn_no }}</td>
        <td><strong>Date:</strong> {{ $grn->grn_date }}</td>
    </tr>
    <tr>
        <td><strong>Vendor:</strong> {{ $grn->vendor_name }}</td>
        <td><strong>Invoice No:</strong> {{ $grn->invoice_no }}</td>
    </tr>
    <tr>
        <td><strong>Invoice Date:</strong> {{ $grn->invoice_date }}</td>
        <td><strong>Status:</strong> {{ $grn->status }}</td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>SL</th>
            <th>Medicine</th>
            <th>Batch</th>
            <th>Expiry</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($grn->items as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->medicine_name }}</td>
            <td>{{ $item->batch_no }}</td>
            <td>{{ $item->expiry }}</td>
            <td class="text-right">{{ $item->qty }}</td>
            <td class="text-right">{{ number_format($item->purchase_rate,2) }}</td>
            <td class="text-right">{{ number_format($item->amount,2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<table class="no-border">
    <tr>
        <td></td>
        <td class="text-right"><strong>Sub Total:</strong> {{ number_format($grn->sub_total,2) }}</td>
    </tr>
    <tr>
        <td></td>
        <td class="text-right"><strong>Total Discount:</strong> {{ number_format($grn->total_discount,2) }}</td>
    </tr>
    <tr>
        <td></td>
        <td class="text-right"><strong>Total Tax:</strong> {{ number_format($grn->total_tax,2) }}</td>
    </tr>
    <tr>
        <td></td>
        <td class="text-right"><strong>Grand Total:</strong> {{ number_format($grn->grand_total,2) }}</td>
    </tr>
</table>

</body>
</html>