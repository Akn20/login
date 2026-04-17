@extends('layouts.admin')

@section('content')

<div class="container">
    <h3 class="mb-3">Payroll Summary Report</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Emp ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Basic</th>
                <th>Allowances</th>
                <th>Deductions</th>
                <th>Gross</th>
                <th>Net</th>
                <th>PF</th>
                <th>ESI</th>
                <th>Tax</th>
                <th>Status</th>
                <th>Payslip</th>
            </tr>
        </thead>

        <tbody>
            @foreach($report as $r)
            <tr>
                <td>{{ $r['employee_id'] }}</td>
                <td>{{ $r['name'] }}</td>
                <td>{{ $s['department']->department_name ?? '-' }}</td>
                <td>{{ $r['basic'] }}</td>
                <td>{{ $r['allowances'] }}</td>
                <td>{{ $r['deductions'] }}</td>
                <td><strong>{{ $r['gross'] }}</strong></td>
                <td><strong>{{ $r['net'] }}</strong></td>
                <td>{{ $r['pf'] }}</td>
                <td>{{ $r['esi'] }}</td>
                <td>{{ $r['tax'] }}</td>
                <td>
                    <span class="badge bg-success">{{ $r['status'] }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.reports.payslip', $r['id']) }}"
                    class="btn btn-sm btn-outline-primary">
                        Download
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection