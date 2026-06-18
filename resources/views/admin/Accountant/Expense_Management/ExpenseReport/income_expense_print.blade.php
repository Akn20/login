<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>
        Income & Expense Report
    </title>

    <style>

        body{
            font-family: Arial, sans-serif;
            margin:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            border:1px solid #000;
            padding:8px;
            text-align:left;
        }

        th{
            background:#f2f2f2;
        }

        .text-center{
            text-align:center;
        }

        .summary-table{
            width:40%;
            margin-bottom:20px;
        }

    </style>

</head>

<body onload="window.print()">

<h2 class="text-center">
    Income and Expense Report
</h2>

<p class="text-center">
    Generated Time :
    {{ now()->format('d/m/Y H:i:s') }}
</p>

<table class="summary-table">

    <tr>
        <td>Total Income</td>
        <td>₹{{ number_format($totalIncome,2) }}</td>
    </tr>

    <tr>
        <td>Total Expense</td>
        <td>₹{{ number_format($totalExpense,2) }}</td>
    </tr>

    <tr>
        <td>Balance Amount</td>
        <td>₹{{ number_format($balance,2) }}</td>
    </tr>

</table>

<br>

<h3>
    Fee Income
</h3>

<table>

    <thead>

    <tr>

        <th>Sl No</th>
        <th>Income Type</th>
        <th>Reference</th>
        <th>Amount</th>

    </tr>

    </thead>

    <tbody>

    @php
        $sl = 1;
    @endphp

    @foreach($receptionistBillings as $row)

    <tr>

        <td>{{ $sl++ }}</td>
        <td>Receptionist Billing</td>
        <td>{{ $row->receipt_no }}</td>
        <td>{{ number_format($row->amount,2) }}</td>

    </tr>

    @endforeach

    @foreach($accountantPayments as $row)

    <tr>

        <td>{{ $sl++ }}</td>
        <td>Accountant Payment</td>
        <td>{{ $row->transaction_id ?? '-' }}</td>
        <td>{{ number_format($row->amount,2) }}</td>

    </tr>

    @endforeach

    @foreach($salesBills as $row)

    <tr>

        <td>{{ $sl++ }}</td>
        <td>Pharmacy Sales</td>
        <td>{{ $row->payment_status }}</td>
        <td>{{ number_format($row->paid_amount,2) }}</td>

    </tr>

    @endforeach

    </tbody>

    <tfoot>

    <tr>

        <th colspan="3">
            Total
        </th>

        <th>
            {{ number_format($totalIncome,2) }}
        </th>

    </tr>

    </tfoot>

</table>

<br><br>

<h3>
    Expense
</h3>

<table>

    <thead>

    <tr>

        <th>Sl No</th>
        <th>Expense Header</th>
        <th>Expense Sub Header</th>
        <th>Amount</th>

    </tr>

    </thead>

    <tbody>

    @php
        $expenseSl = 1;
    @endphp

    @foreach($expenses as $expense)

        @foreach($expense->items as $item)

        <tr>

            <td>{{ $expenseSl++ }}</td>

            <td>
                {{ $item->expense_heading }}
            </td>

            <td>
                {{ $expense->category->category_name ?? '-' }}
            </td>

            <td>
                {{ number_format($item->total,2) }}
            </td>

        </tr>

        @endforeach

    @endforeach

    </tbody>

    <tfoot>

    <tr>

        <th colspan="3">
            Total
        </th>

        <th>
            {{ number_format($totalExpense,2) }}
        </th>

    </tr>

    </tfoot>

</table>

</body>
</html>