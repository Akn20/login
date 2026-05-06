@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Edit Insurance Claim</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.accountant.claims.index') }}" class="btn btn-light">
                Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.accountant.claims.update', $claim->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Insurance Provider</label>
                    <input type="text" name="insurance_provider"
                           value="{{ $claim->insurance_provider }}"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Patient</label>
                    <select name="patient_id" class="form-control" required>
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}"
                            {{ $claim->patient_id == $p->id ? 'selected' : '' }}>
                            {{ $p->first_name }} {{ $p->last_name }}
                        </option>
                    @endforeach
                </select>
                                </div>

                <div class="mb-3">
                    <label>Billed Amount</label>
                    <input type="number" name="billed_amount"
                           value="{{ $claim->billed_amount }}"
                           class="form-control">
                </div>

                <button class="btn btn-primary">Update</button>
            </form>

        </div>
    </div>

</div>
@endsection