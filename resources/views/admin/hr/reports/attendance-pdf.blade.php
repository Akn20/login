<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
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

<h3>Attendance Report</h3>

<table>
    <thead>
        <tr>
            <th>Employee</th>
            <th>Department</th>
            <th>Date</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $a)
        <tr>
            <td>{{ $a->staff->name ?? '' }}</td>
            <td>{{ $a->department->name ?? '' }}</td>
            <td>{{ $a->attendance_date }}</td>
            <td>{{ $a->check_in }}</td>
            <td>{{ $a->check_out }}</td>
            <td>{{ $a->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>