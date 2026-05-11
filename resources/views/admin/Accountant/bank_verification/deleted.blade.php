@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Deleted Verification</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.bank-verification.index') }}"
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
                        <th>Bank</th>

                        <th>Deposit Amount</th>

                        <th>Deposit Date</th>

                        <th>Reference No</th>

                        <th>Status</th>

                        <th>Verified By</th>

                        <th width="180">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($verifications as $key => $item)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>
                            {{ $item->bank_name }}
                        </td>

                        <td>
                            ₹ {{ number_format($item->deposit_amount, 2) }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->deposit_date)->format('d M Y') }}
                        </td>

                        <td>
                            {{ $item->reference_number }}
                        </td>

                        <td>
                            {{ $item->verification_status }}
                        </td>
                        <td>
                            {{ $item->verified_by }}
                        </td>


                        <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <!-- Restore -->
                                        <form action="{{ route('admin.bank-verification.restore', $item->id) }}"
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
                                        <form action="{{ route('admin.bank-verification.forceDelete', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Permanently delete this verification?')">
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