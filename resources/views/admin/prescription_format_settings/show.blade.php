@extends('layouts.admin')

@section('content')

<div class="main-content">

<div class="card">

<div class="card-header">
    <h4>Prescription Format Details</h4>
</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
    <th width="250">Header Text</th>
    <td>{{ $format->header_text }}</td>
</tr>

<tr>
    <th>Footer Text</th>
    <td>{{ $format->footer_text }}</td>
</tr>

<tr>
    <th>Paper Size</th>
    <td>{{ $format->paper_size }}</td>
</tr>

<tr>
    <th>Orientation</th>
    <td>{{ $format->orientation }}</td>
</tr>

<tr>
    <th>Margins</th>
    <td>{{ $format->margins }}</td>
</tr>

<tr>
    <th>Status</th>
    <td>
        @if($format->status == 'Active')
            <span class="badge bg-success">Active</span>
        @else
            <span class="badge bg-danger">Inactive</span>
        @endif
    </td>
</tr>

</table>

<a href="{{ route('prescription-format-settings.index') }}"
   class="btn btn-secondary">
    Back
</a>

</div>

</div>

</div>

@endsection