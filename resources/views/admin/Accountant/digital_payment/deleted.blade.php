@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Deleted Payments</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.digital-payment.index') }}"
               class="btn btn-light">
                Back
            </a>
        </div>
    </div>


    <div class="card">

        <div class="card-body table-responsive">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>#</th>

                        <th>Method</th>

                        <th>Gateway</th>

                        <th>Amount</th>

                        <th>Date</th>

                        <th>Transaction Ref</th>

                        <th>Matching</th>

                        <th>Settlement</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($payments as $key => $item)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>
                            {{ $item->payment_method }}
                        </td>

                        <td>
                            {{ $item->payment_gateway }}
                        </td>

                        <td>
                            ₹ {{ number_format($item->payment_amount, 2) }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->payment_date)->format('d M Y') }}
                        </td>

                        <td>
                            {{ $item->transaction_reference }}
                        </td>
                        <td>
                            {{ $item->matching_status }}
                        </td>
                        <td>
                            {{ $item->settlement_status }}
                        </td>

                        <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <!-- Restore -->
                                        <form action="{{ route('admin.digital-payment.restore', $item->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit"
                                                class="btn btn-outline-success btn-icon rounded-circle"
                                                title="Restore">
                                                <i class="feather-rotate-ccw"></i>
                                            </button>
                                        </form>

                                        <!-- Permanent Delete -->
                                        <form action="{{ route('admin.digital-payment.forceDelete', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Permanently delete this payment?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-outline-danger btn-icon rounded-circle"
                                                title="Delete Permanently">
                                                <i class="feather-trash-2"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="9" class="text-center">
                            No deleted records found
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection