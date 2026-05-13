@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Bank Verifications</h5>
        </div>

        <div class="page-header-right ms-auto d-flex align-items-center gap-2">

        <!-- Search -->
        <form method="GET" action="{{ route('admin.bank-verification.search') }}" class="d-flex">
            <input type="text"
                   name="bank_name"
                   value="{{ request('bank_name') }}"
                   class="form-control"
                   placeholder="Search Bank..."

                   style="width: 220px;">

            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>
        </form>

        <!-- Add Button -->
        <a href="{{ route('admin.bank-verification.create') }}" class="btn btn-primary">
            <i class="feather-plus me-2"></i> New
        </a>

        <!-- Deleted Button -->
        <a href="{{ route('admin.bank-verification.deleted') }}" class="btn btn-danger">
            Deleted Verifications
        </a>
                

    </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    {{-- TABLE --}}
    <div class="card">

        <div class="card-body table-responsive">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Bank</th>

                        <th>Deposit Amount</th>

                        <th>Deposit Date</th>

                        <th>Reference No</th>

                        <th>Status</th>

                        <th>Verified By</th>

                        <th width="100">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($verifications as $key => $item)

                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>{{ $item->bank_name }}</td>

                            <td>
                                ₹ {{ number_format($item->deposit_amount, 2) }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->deposit_date)->format('d M Y') }}
                            </td>

                            <td>
                                {{ $item->reference_number ?? 'N/A' }}
                            </td>

                            <td>

                                @if($item->verification_status == 'Verified')

                                    <span class="badge bg-success">
                                        Verified
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Mismatch
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $item->verified_by ?? 'N/A' }}
                            </td>

                             <td>
                                <div class="d-flex gap-2 align-items-center">

                                {{--Edit --}}
                                    <a href="{{ route('admin.bank-verification.edit', $item->id) }}"
                                        
                                        class="avatar-text avatar-md" title="Edit">
                                        <i class="feather feather-edit"></i>
                                    </a>
                                {{--View --}}
                                    <a href="{{ route('admin.bank-verification.view', $item->id) }}"
                                        class="avatar-text avatar-md" title="View">
                                        <i class="feather feather-eye"></i>
                                    </a>

                                   {{---Delete--}}
                                   <form action="{{ route('admin.bank-verification.delete', $item->id) }}"
                                        method="POST"
                                        class="m-0"
                                        onsubmit="return confirm('Move this verification to deleted list?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                            data-bs-toggle="tooltip"
                                            title="Delete">
                                            <i class="feather feather-trash-2"></i>
                                        </button>

                                    </form>
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center">

                                No verification records found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection