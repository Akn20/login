@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Deleted Financial Reconciliation</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.financial-reconciliation.index') }}"
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
                        <th>Reconciliation ID</th>
                         <th>Date</th>
                        <th>Total Cash</th>
                        <th>Total Digital</th>
                        <th>Bank Deposit</th>
                        <th>Difference</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($reconciliations as $key => $item)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>
                            REC-{{ strtoupper(substr($item->id, 0, 6)) }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->reconciliation_date)->format('d M Y') }}
                        </td>

                        <td>
                            ₹ {{ number_format($item->total_cash, 2) }}
                        </td>

                        <td>
                            ₹ {{ number_format($item->total_digital, 2) }}
                        </td>

                        <td>
                            ₹ {{ number_format($item->total_bank_deposit, 2) }}
                        </td>

                        <td>
                            ₹ {{ number_format($item->difference_amount, 2) }}
                        </td>

                        <td>
                            {{ $item->status }}
                        </td>

                        <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <!-- Restore -->
                                        <form action="{{ route('admin.financial-reconciliation.restore', $item->id) }}"
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
                                        <form action="{{ route('admin.financial-reconciliation.forceDelete', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Permanently delete this reconciliation?')">
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
                        <td colspan="4" class="text-center">
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