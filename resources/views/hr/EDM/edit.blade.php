@extends('layouts.admin')

@section('page-title', 'Edit Document')

@section('content')

<div class="page-header mb-4">
    <h5>Edit Document</h5>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.edm.update', $document->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <!-- Employee -->
                <div class="col-md-6 mb-3">
                    <label>Employee</label>
                    <select name="staff_id" class="form-control">
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}"
                                {{ $document->staff_id == $emp->id ? 'selected' : '' }}>
                                {{ $emp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Document Type -->
                <div class="col-md-6 mb-3">
                    <label>Document Type</label>
                    <select name="document_type" class="form-control">
                        <option {{ $document->document_type == 'Offer Letter' ? 'selected' : '' }}>Offer Letter</option>
                        <option {{ $document->document_type == 'Appointment Letter' ? 'selected' : '' }}>Appointment Letter</option>
                        <option {{ $document->document_type == 'ID Proof' ? 'selected' : '' }}>ID Proof</option>
                        <option {{ $document->document_type == 'Certificate' ? 'selected' : '' }}>Certificate</option>
                        <option {{ $document->document_type == 'Medical License' ? 'selected' : '' }}>Medical License</option>
                    </select>
                </div>

                <!-- File -->
                <div class="col-md-6 mb-3">
                    <label>Replace File</label>
                    <input type="file" name="file" class="form-control">
                </div>

                <!-- Expiry -->
                <div class="col-md-6 mb-3">
                    <label>Expiry Date</label>
                    <input type="date" name="expiry_date"
                        value="{{ $document->expiry_date }}"
                        class="form-control">
                </div>

            </div>

            <div class="text-end">
                <button class="btn btn-primary">Update</button>
            </div>

        </form>

    </div>
</div>

@endsection