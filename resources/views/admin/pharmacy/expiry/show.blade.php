@extends('layouts.admin')

@section('page-title', 'View Expiry Record | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Expiry Details</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Pharmacy</li>
                <li class="breadcrumb-item">Expiry</li>
                <li class="breadcrumb-item">View</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.expiries.edit', $expiry->id) }}" class="btn btn-neutral">
                Edit
            </a>
            <a href="{{ route('admin.expiries.index') }}" class="btn btn-neutral">
                Back
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="card stretch stretch-full">
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th style="width:200px;">Medicine Name</th>
                        <td>{{ $expiry->medicine_name }}</td>
                    </tr>
                    <tr>
                        <th>Batch Number</th>
                        <td>{{ $expiry->batch_number }}</td>
                    </tr>
                    <tr>
                        <th>Expiry Date</th>
                        <td>{{ \Carbon\Carbon::parse($expiry->expiry_date)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $expiry->quantity }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection