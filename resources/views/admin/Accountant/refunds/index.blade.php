@extends('layouts.admin')

@section('page-title', 'Refund Management')

@section('content')

<div class="page-header mb-4">

    <div class="page-header-left">

        <h5>Refund Management</h5>

    </div>

    <div class="page-header-right text-end">

        <a href="{{ route('admin.refunds.create') }}"
           class="btn btn-primary">

            + Create Refund

        </a>

    </div>

</div>

{{-- SUCCESS MESSAGE --}}
@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

{{-- TABLE CARD --}}
<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Refund No</th>

                        <th>Patient</th>

                        <th>Refund Type</th>

                        <th>Amount</th>

                        <th>Status</th>

                        <th>Date</th>

                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($refunds as $key => $refund)

                    <tr>

                        <td>
                            {{ $refunds->firstItem() + $key }}
                        </td>

                        <td>

                            {{ $refund->refund_no }}

                        </td>

                        <td>

                            {{ $refund->patient->first_name ?? '' }}
                            {{ $refund->patient->last_name ?? '' }}

                        </td>

                        <td>

                            {{ $refund->refund_type }}

                        </td>

                        <td>

                            ₹ {{ number_format($refund->refund_amount, 2) }}

                        </td>

                        <td>

                            @if($refund->status == 'Pending')

                                <span class="badge bg-warning">

                                    Pending

                                </span>

                            @elseif($refund->status == 'Approved')

                                <span class="badge bg-primary">

                                    Approved

                                </span>

                            @elseif($refund->status == 'Processed')

                                <span class="badge bg-success">

                                    Processed

                                </span>

                            @elseif($refund->status == 'Rejected')

                                <span class="badge bg-danger">

                                    Rejected

                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $refund->refund_date->format('d-m-Y') }}

                        </td>

                        <td>

    {{-- VIEW --}}
    <a href="{{ route('admin.refunds.show', $refund->id) }}"
       class="text-info me-2"
       title="View">

        <i class="feather-eye"></i>

    </a>

    {{-- EDIT --}}
    @if($refund->status != 'Processed')

    <a href="{{ route('admin.refunds.edit', $refund->id) }}"
       class="text-primary me-2"
       title="Edit">

        <i class="feather-edit"></i>

    </a>

    @endif

    {{-- DELETE --}}
    @if($refund->status != 'Processed')

    <form action="{{ route('admin.refunds.delete', $refund->id) }}"
          method="POST"
          style="display:inline;">

        @csrf
        @method('DELETE')

        <button type="submit"
                class="text-danger border-0 bg-transparent"
                onclick="return confirm('Delete refund?')">

            <i class="feather-trash-2"></i>

        </button>

    </form>

    @endif

</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="text-center">

                            No Refunds Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="mt-3">

            {{ $refunds->links() }}

        </div>

    </div>

</div>

@endsection