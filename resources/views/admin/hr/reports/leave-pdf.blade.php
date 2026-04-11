<!DOCTYPE html>
<html>
<head>
    <title>Leave Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>

<h3>Leave Report</h3>

<table>
    <thead>
        <tr>
            <th>Employee</th>
            <th>Department</th>
            <th>Leave Type</th>
            <th>From</th>
            <th>To</th>
            <th>Days</th>
            <th>Status</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $l)
        <tr>
            <td>{{ $l->staff->name ?? '' }}</td>
            <td>{{ $l->staff->department->name ?? '' }}</td>
            <td>{{ $l->leaveType->display_name ?? '' }}</td>
            <td>{{ $l->from_date }}</td>
            <td>{{ $l->to_date }}</td>
            <td>{{ $l->leave_days }}</td>
            <td>{{ $l->status }}</td>
            <td>{{ $l->remaining_balance }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>