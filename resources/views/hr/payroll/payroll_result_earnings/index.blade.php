@extends('layouts.admin')

@section('page-title', 'Payroll Earnings')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h5 class="mb-1">Payroll Earnings</h5>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('hr.payroll.payroll-result-earnings.create') }}" class="btn btn-primary">
            <i class="feather-plus me-1"></i> Add Earning
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Taxable</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $item)
                    <tr>

                        <!-- Code -->
                        <td>
                            <span class="badge bg-soft-primary text-primary">
                                {{ $item->earning_code }}
                            </span>
                        </td>

                        <!-- Name -->
                        <td>
                            <span class="badge bg-soft-info text-info">
                                {{ $item->earning_name }}
                            </span>
                        </td>

                        <!-- Type -->
                        <td>
                            @if($item->earning_type == 'Fixed')
                                <span class="badge bg-soft-success text-success">Fixed</span>
                            @elseif($item->earning_type == 'Variable')
                                <span class="badge bg-soft-warning text-warning">Variable</span>
                            @else
                                <span class="badge bg-soft-dark text-dark">OT</span>
                            @endif
                        </td>

                        <!-- Amount -->
                        <td>₹ {{ $item->amount }}</td>

                        <!-- Taxable -->
                        <td>
                            @if($item->taxable)
                                <span class="badge bg-soft-success text-success">Yes</span>
                            @else
                                <span class="badge bg-soft-danger text-danger">No</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">

                                <a href="{{ route('hr.payroll.payroll-result-earnings.show', $item->id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">
                                    <i class="feather-eye"></i>
                                </a>

                                <a href="{{ route('hr.payroll.payroll-result-earnings.edit', $item->id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">
                                    <i class="feather-edit-2"></i>
                                </a>

                                <form action="{{ route('hr.payroll.payroll-result-earnings.delete', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Move to trash?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-outline-danger btn-icon rounded-circle btn-sm">
                                        <i class="feather-trash-2"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No records found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

            <div class="p-3">
                {{ $records->links() }}
            </div>

        </div>

    </div>
</div>

@endsection