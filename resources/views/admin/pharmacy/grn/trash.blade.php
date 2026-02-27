@extends('layouts.admin')

@section('title', 'GRN Trash')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">GRN Trash</h4>
            <small class="text-muted">Pharmacy → GRN → Trash</small>
        </div>

        <a href="{{ route('admin.grn.index') }}" class="btn btn-light">
            <i class="feather-arrow-left"></i> Back
        </a>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">SL</th>
                        <th>GRN No</th>
                        <th>Vendor</th>
                        <th>Invoice No</th>
                        <th>Deleted At</th>
                        <th class="text-center" style="width:200px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($grns as $index => $r)
                    <tr>
                        <td>{{ ($grns->currentPage() - 1) * $grns->perPage() + $index + 1 }}</td>
                        <td class="fw-semibold">{{ $r->grn_no }}</td>
                        <td>{{ $r->vendor_name }}</td>
                        <td>{{ $r->invoice_no }}</td>
                        <td>{{ $r->deleted_at }}</td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                {{-- RESTORE --}}
                                <form action="{{ route('admin.grn.restore', $r->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="btn btn-light btn-icon rounded-circle"
                                            title="Restore"
                                            onclick="return confirm('Restore this GRN?')">
                                        <i class="feather-rotate-ccw text-success"></i>
                                    </button>
                                </form>

                                {{-- FORCE DELETE --}}
                                <form action="{{ route('admin.grn.forceDelete', $r->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-light btn-icon rounded-circle"
                                            title="Delete Permanently"
                                            onclick="return confirm('Permanently delete this GRN? This cannot be undone!')">
                                        <i class="feather-trash text-danger"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No deleted GRNs found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $grns->links() }}
            </div>

        </div>
    </div>

</div>
@endsection