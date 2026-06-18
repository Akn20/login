@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10 text-danger">Deleted Insurance Claims</h5>
    </div>

    <div class="page-header-right ms-auto">
        <a href="{{ route('admin.accountant.claims.index') }}" class="btn btn-light-brand btn-sm">
            <i class="feather-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="main-content">
    <div class="card stretch stretch-full">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Claim No</th>
                            <th>Provider</th>
                            <th>Billed Amount</th>
                            <th>Deleted At</th>
                            <th class="text-center" style="width:120px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($claims as $claim)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $claim->claim_number }}</td>
                                <td>{{ $claim->insurance_provider }}</td>
                                <td>{{ $claim->billed_amount }}</td>
                                <td>{{ $claim->deleted_at->format('d M Y H:i') }}</td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <!-- Restore -->
                                        <form action="{{ route('admin.accountant.claims.restore', $claim->id) }}"
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
                                        <form action="{{ route('admin.accountant.claims.forceDelete', $claim->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Permanently delete this claim?')">
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
                                <td colspan="6" class="text-center">
                                    No Deleted Claims Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            {{ $claims->links() }}
        </div>

    </div>
</div>

@endsection