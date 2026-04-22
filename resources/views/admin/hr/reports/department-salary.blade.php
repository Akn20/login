@extends('layouts.admin')

@section('content')

<div class="container">
    <h3 class="mb-3">Department-wise Salary Report</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Department</th>
                <th>Total Employees</th>
                <th>Total Salary</th>
                <th>Average Salary</th>
                <th>Highest Salary</th>
                <th>Lowest Salary</th>
            </tr>
        </thead>

        <tbody>
            @foreach($report as $r)
            <tr>
                <td>{{ $r['department'] }}</td>
                <td>{{ $r['employees'] }}</td>
                <td>₹{{ $r['total_salary'] }}</td>
                <td>₹{{ $r['average_salary'] }}</td>
                <td>₹{{ $r['highest_salary'] }}</td>
                <td>₹{{ $r['lowest_salary'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection