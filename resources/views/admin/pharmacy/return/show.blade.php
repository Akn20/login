@extends('layouts.admin')

@section('page-title', 'View Return | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-title">
            <h5 class="m-b-10">Return Details</h5>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.returns.edit', $return->id) }}" class="btn btn-neutral">
                Edit
            </a>
            <a href="{{ route('admin.returns.index') }}" class="btn btn-neutral">
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
                        <td>{{ $return->medicine_name }}</td>
                    </tr>
                    <tr>
                        <th>Return Date</th>
                        <td>{{ \Carbon\Carbon::parse($return->return_date)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $return->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Reason</th>
                        <td>{{ $return->reason ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection