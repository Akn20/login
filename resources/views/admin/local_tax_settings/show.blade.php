@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="card">

        <div class="card-header">
            <h4>Local Tax Setting Details</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="250">Tax Name</th>
                    <td>{{ $tax->tax_name }}</td>
                </tr>

                <tr>
                    <th>Tax Percentage</th>
                    <td>{{ $tax->tax_percentage }}%</td>
                </tr>

                <tr>
                    <th>Tax Type</th>
                    <td>{{ $tax->tax_type }}</td>
                </tr>

                <tr>
                    <th>Applicable On</th>
                    <td>{{ $tax->applicable_on }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>

                        @if($tax->status == 'Active')

                            <span class="badge bg-success">
                                Active
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Inactive
                            </span>

                        @endif

                    </td>
                </tr>

            </table>

            <a href="{{ route('local-tax-settings.index') }}"
               class="btn btn-secondary">
                Back
            </a>

        </div>

    </div>

</div>

@endsection