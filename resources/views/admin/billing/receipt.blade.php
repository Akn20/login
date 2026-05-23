<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <style>
        body { font-family: DejaVu Sans; }
        .box { border:1px solid #000; padding:20px; }
    </style>
</head>
<body>

<div class="box">

<h2>Hospital Receipt</h2>

<p><strong>Receipt No:</strong> {{ $billing->receipt_no }}</p>
<p><strong>Patient:</strong> {{ $billing->patient->name }}</p>
<p><strong>Amount Paid:</strong> ₹ {{ $billing->amount }}</p>
<p><strong>Payment Mode:</strong> {{ $billing->payment_mode }}</p>
<p><strong>Date:</strong> {{ $billing->created_at }}</p>

</div>

</body>
</html>