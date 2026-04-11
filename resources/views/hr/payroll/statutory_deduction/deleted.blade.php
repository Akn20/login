@extends('layouts.admin')

@section('page-title', 'Deleted Statutory Deductions')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between">
    <h5>Deleted Records</h5>
    <a href="{{ route('hr.payroll.statutory-deduction.index') }}" class="btn btn-secondary btn-sm">Back</a>
</div>

<div class="card">
    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($records as $row)
                    <tr>
                        <td>{{ $row->statutory_code }}</td>
                        <td>{{ $row->statutory_name }}</td>
                        <td>{{ $row->statutory_category }}</td>
                        <td>

                            <form action="{{ route('hr.payroll.statutory-deduction.restore', $row->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm">Restore</button>
                            </form>

                            <form action="{{ route('hr.payroll.statutory-deduction.forceDelete', $row->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Permanent delete?')">Delete</button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No Deleted Records</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection