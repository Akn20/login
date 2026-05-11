@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header mb-4">

        <div class="page-header-left">
            <h5 class="m-b-0">
                Verification Details
            </h5>
        </div>

        <div class="page-header-right ms-auto">

            <a href="{{ route('admin.bank-verification.index') }}"
               class="btn btn-light">

                Back

            </a>

        </div>

    </div>

    {{-- DETAILS --}}
    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>Bank Name</th>
                    <td>{{ $verification->bank_name }}</td>
                </tr>

                <tr>
                    <th>Deposit Amount</th>
                    <td>
                        ₹ {{ number_format($verification->deposit_amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>Deposit Date</th>
                    <td>
                        {{ \Carbon\Carbon::parse($verification->deposit_date)->format('d M Y') }}
                    </td>
                </tr>

                <tr>
                    <th>Reference Number</th>
                    <td>
                        {{ $verification->reference_number ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>

                        @if($verification->verification_status == 'Verified')

                            <span class="badge bg-success">
                                Verified
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Mismatch
                            </span>

                        @endif

                    </td>
                </tr>

                <tr>
                    <th>Verified By</th>
                    <td>
                        {{ $verification->verified_by ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <th>Remarks</th>
                    <td>
                        {{ $verification->remarks ?? 'N/A' }}
                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>

@endsection