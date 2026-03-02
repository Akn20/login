@extends('layouts.admin')

@section('page-title', 'Expiry Management | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Expiry Management</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Pharmacy</li>
                <li class="breadcrumb-item">Expiry</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.expiries.trash') }}" class="btn btn-neutral">
                Deleted Records
            </a>

            <a href="{{ route('admin.expiries.create') }}" class="btn btn-neutral">
                Add Expiry
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="card stretch stretch-full">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sl.No.</th>
                                <th>Medicine</th>
                                <th>Batch</th>
                                <th>Expiry Date</th>
                                <th>Quantity</th>
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
                                <td>{{ $expiry->quantity }}</td>

                                <td class="text-end">
                                    <div class="hstack gap-2 justify-content-end">

                                        <a href="{{ route('admin.expiries.edit', $expiry->id) }}"
                                            class="avatar-text avatar-md action-icon action-edit">
                                            <i class="feather-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.expiries.delete', $expiry->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="avatar-text avatar-md action-icon action-delete">
                                                <i class="feather-trash-2"></i>
                                            </button>
                                        </form>

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