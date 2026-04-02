@extends('layouts.admin')

@section('page-title', 'Employee Documents')

@section('content')

<div class="page-header mb-4">
    <div class="page-header-left">
        <h5>Employee Documents</h5>
    </div>

    <div class="page-header-right text-end">
        <a href="{{ route('hr.edm.create') }}" class="btn btn-primary">
            + Upload Document
        </a>
    </div>
</div>

<!-- 🔍 SEARCH CARD -->
<div class="card mb-4">
    <div class="card-body">

        <form method="GET" action="{{ route('hr.edm.index') }}">
            <div class="row align-items-center">

                <div class="col-md-3">
                    <input type="text" name="employee_name"
                        value="{{ request('employee_name') }}"
                        class="form-control"
                        placeholder="Search by Employee Name">
                </div>

                <div class="col-md-3">
                    <select name="document_type" class="form-control">
                        <option value="">All Document Types</option>
                        <option value="Offer Letter" {{ request('document_type') == 'Offer Letter' ? 'selected' : '' }}>Offer Letter</option>
                        <option value="Appointment Letter" {{ request('document_type') == 'Appointment Letter' ? 'selected' : '' }}>Appointment Letter</option>
                        <option value="ID Proof" {{ request('document_type') == 'ID Proof' ? 'selected' : '' }}>ID Proof</option>
                        <option value="Certificate" {{ request('document_type') == 'Certificate' ? 'selected' : '' }}>Certificate</option>
                        <option value="Medical License" {{ request('document_type') == 'Medical License' ? 'selected' : '' }}>Medical License</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button class="btn btn-primary d-flex align-items-center gap-1">
                        <i class="feather-search"></i> Search
                    </button>

                    <a href="{{ route('hr.edm.index') }}"
                        class="btn btn-outline-secondary d-flex align-items-center gap-1">
                        <i class="feather-refresh-cw"></i> Reset
                    </a>
                </div>

            </div>
        </form>

    </div>
</div>

<!-- 📄 TABLE CARD -->
<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Document Type</th>
                        <th>Uploaded Date</th>
                        <th>Expiry Date</th>
                        <!-- //<th>Status</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($documents as $key => $doc)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $doc->staff->name ?? '-' }}</td>
                        <td>{{ $doc->document_type }}</td>
                        <td>{{ $doc->created_at->format('d-m-Y') }}</td>

                        <!-- STATUS -->
                      <td>
    @if($doc->expiry_date)
        @php $expiry = \Carbon\Carbon::parse($doc->expiry_date); @endphp

        {{ $expiry->format('d-m-Y') }} <br>

        @if($expiry->isPast())
            <span class="badge bg-danger">Expired</span>
        @elseif(now()->diffInDays($expiry) <= 30)
            <span class="badge bg-warning">Expiring Soon</span>
        @else
            <span class="badge bg-success">Active</span>
        @endif
    @else
        -
    @endif
</td>

                        <!-- ACTIONS -->
                        <td>

                            <!-- Download -->
                            <a href="{{ route('hr.edm.download', $doc->id) }}"
                               class="text-success me-2"
                               title="Download">
                                <i class="feather-download"></i>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('hr.edm.edit', $doc->id) }}"
                               class="text-primary me-2"
                               title="Edit">
                                <i class="feather-edit"></i>
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('hr.edm.delete', $doc->id) }}"
                                method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button style="border:none; background:none;"
                                    class="text-danger"
                                    title="Delete"
                                    onclick="return confirm('Delete this document?')">
                                    <i class="feather-trash-2"></i>
                                </button>
                            </form>

                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection