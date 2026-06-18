@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Create Insurance Claim</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.accountant.claims.index') }}" class="btn btn-light">
                <i class="feather-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            {{-- Errors --}}
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('admin.accountant.claims.store') }}">
                @csrf

                <div class="mb-3">
                    <label>Insurance Provider</label>
                    <input type="text" name="insurance_provider"
                           value="{{ old('insurance_provider') }}"
                           class="form-control">
                </div>

                                <div class="mb-3">
                    <label>Patient</label>
                    <select name="patient_id" class="form-control" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->first_name }} {{ $p->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Billed Amount</label>
                    <input type="number" step="0.01" name="billed_amount"
                           value="{{ old('billed_amount') }}"
                           class="form-control">
                </div>



                <button class="btn btn-primary">Save</button>
            </form>

        </div>
    </div>

</div>
@endsection