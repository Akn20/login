@extends('layouts.admin')

@section('title', 'Variable Allowance')

@section('content')

    <div class="page-header mb-4 d-flex align-items-center justify-content-between">

        <div>
            <h5 class="mb-1">
                <i class="feather-plus-circle me-1"></i>
                {{ isset($allowance) ? 'Edit Variable Allowance' : 'Add Variable Allowance' }}
            </h5>

            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">Payroll</li>
                <li class="breadcrumb-item">Variable Allowance</li>
            </ul>
        </div>

        {{-- 🔥 ACTION BUTTONS --}}
        <div class="d-flex gap-2">

            <button type="submit" form="form" class="btn btn-primary">
                <i class="feather-save me-1"></i>
                {{ isset($allowance) ? 'Update' : 'Save' }}
            </button>

            <a href="{{ route('hr.payroll.allowance.index', ['type' => 'variable']) }}" class="btn btn-light">
                Cancel
            </a>

        </div>

    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="form" method="POST" action="{{ isset($allowance)
        ? route('hr.payroll.allowance.update', $allowance->id)
        : route('hr.payroll.allowance.store') }}">

        @csrf
        @if(isset($allowance)) @method('PUT') @endif

        <input type="hidden" name="type" value="variable">

        <div class="card mt-3">
            <div class="card-body">

                <h6>Basic Details</h6>

                <div class="row">
                    <div class="col-md-6">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $allowance->name ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label>Display Name</label>
                        <input type="text" name="display_name" class="form-control"
                            value="{{ old('display_name', $allowance->display_name ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control"
                            value="{{ old('description', $allowance->description ?? '') }}">
                    </div>
                </div>

                <hr>

                <h6>Tax & Statutory</h6>

                <div class="row">
                    <div class="col-md-4">
                        <label>Taxable</label>
                        <select name="taxable" class="form-control">
                            <option value="1" {{ old('taxable', $allowance->taxable ?? 0) == 1 ? 'selected' : '' }}>Yes
                            </option>
                            <option value="0" {{ old('taxable', $allowance->taxable ?? 0) == 0 ? 'selected' : '' }}>No
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>PF</label>
                        <select name="pf_applicable" class="form-control">
                            <option value="1" {{ old('pf_applicable', $allowance->pf_applicable ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('pf_applicable', $allowance->pf_applicable ?? 0) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>ESI</label>
                        <select name="esi_applicable" class="form-control">
                            <option value="1" {{ old('esi_applicable', $allowance->esi_applicable ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('esi_applicable', $allowance->esi_applicable ?? 0) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>

                <hr>

                <h6>Status</h6>

                <select name="status" class="form-control">
                    <option value="1" {{ old('status', $allowance->status ?? 0) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $allowance->status ?? 0) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>

            </div>
        </div>

    </form>

@endsection