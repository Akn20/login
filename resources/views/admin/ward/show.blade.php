@extends('layouts.admin')

@section('content')

    <div class="page-header">
        <div class="page-header-left">
            <h5 class="m-b-10">Ward Details</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.ward.index') }}" class="btn btn-light-brand btn-sm">
                <i class="feather-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="main-content">

        <div class="card stretch stretch-full">
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Ward Name</div>
                    <div class="col-md-8">{{ $ward->ward_name }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Type</div>
                    <div class="col-md-8">{{ $ward->ward_type }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Floor</div>
                    <div class="col-md-8">{{ $ward->floor_number }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Total Beds</div>
                    <div class="col-md-8">{{ $ward->total_beds }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status</div>
                    <div class="col-md-8">
                        @if($ward->status)
                            <span class="badge bg-soft-success text-success">
                                Active
                            </span>
                        @else
                            <span class="badge bg-soft-danger text-danger">
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Created At</div>
                    <div class="col-md-8">
                        {{ $ward->created_at->format('d M Y h:i A') }}
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection