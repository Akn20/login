<!DOCTYPE html>
<html>
<head>
    <title>Payslip</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; }
        .section { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #000; padding: 6px; }
    </style>
</head>
<body>

<div class="header">
    <h2>Your Company Name</h2>
    <h4>Salary Slip</h4>
</div>

<div class="section">
    <strong>Employee ID:</strong> {{ $staff->employee_id }} <br>
    <strong>Name:</strong> {{ $staff->name }} <br>
    <strong>Department:</strong> {{ $staff->department->department_name ?? '-' }}
</div>

<div class="section">
    <h4>Earnings</h4>
    <table>
        <tr>
            <td>Basic Salary</td>
            <td>{{ $basic }}</td>
        </tr>
        <tr>
            <td>Allowances</td>
            <td>{{ $allowances }}</td>
        </tr>
        <tr>
            <th>Gross Salary</th>
            <th>{{ $gross }}</th>
        </tr>
    </table>
</div>

<div class="section">
    <h4>Deductions</h4>
    <table>
        <tr>
            <td>PF</td>
            <td>{{ $pf }}</td>
        </tr>
        <tr>
            <td>ESI</td>
            <td>{{ $esi }}</td>
        </tr>
        <tr>
            <td>Tax</td>
            <td>{{ $tax }}</td>
        </tr>
        <tr>
            <th>Total Deductions</th>
            <th>{{ $deductions }}</th>
        </tr>
    </table>
</div>

<div class="section">
    <h3>Net Salary: {{ $net }}</h3>
</div>

</body>
</html>