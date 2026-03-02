@extends('layouts.admin')

@section('page-title', 'Deleted Expiry Records | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-title">
            <h5>Deleted Expiry Records</h5>
        </div>
        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.expiries.index') }}" class="btn btn-neutral">
                Back
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="card">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sl.No.</th>
                                <th>Medicine</th>
                                <th>Batch</th>
                                <th>Expiry Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiries as $index => $expiry)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $expiry->medicine_name }}</td>
                                    <td>{{ $expiry->batch_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($expiry->expiry_date)->format('d-m-Y') }}</td>

                                    <td class="text-end">
                                        <div class="hstack gap-2 justify-content-end">
                                            <a href="{{ route('admin.expiries.restore', $expiry->id) }}"
                                                class="avatar-text avatar-md action-icon action-restore">
                                                <i class="feather-refresh-ccw"></i>
                                            </a>

                                            <a href="{{ route('admin.expiries.forceDelete', $expiry->id) }}"
                                                class="avatar-text avatar-md action-icon action-delete"
                                                onclick="return confirm('Permanently delete?')">
                                                <i class="feather-trash"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection