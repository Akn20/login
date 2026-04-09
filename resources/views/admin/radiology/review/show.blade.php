@extends('layouts.admin')

@section('content')

<div class="nxl-content">

<h5>Review Scan</h5>

<form method="POST" action="{{ route('admin.radiology.review.store') }}">
@csrf

<input type="hidden" name="scan_request_id" value="{{ $requestData->id }}">

<div class="mb-3">
    <label>Observations</label>
    <textarea name="observations" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Findings</label>
    <textarea name="findings" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Diagnosis</label>
    <textarea name="diagnosis" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="Approved">Approve</option>
        <option value="Rejected">Reject</option>
    </select>
</div>

<button class="btn btn-success">Submit Report</button>

</form>

</div>

@endsection