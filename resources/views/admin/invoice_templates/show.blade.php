@extends('layouts.admin')

@section('content')

<div class="main-content">

<div class="card">

<div class="card-header">
    <h4>Invoice Template Details</h4>
</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
    <th width="250">Template Name</th>
    <td>{{ $template->template_name }}</td>
</tr>

<tr>
    <th>Invoice Prefix</th>
    <td>{{ $template->invoice_prefix }}</td>
</tr>

<tr>
    <th>Starting Number</th>
    <td>{{ $template->starting_number }}</td>
</tr>

<tr>
    <th>Show Logo</th>
    <td>{{ $template->show_logo ? 'Yes' : 'No' }}</td>
</tr>

<tr>
    <th>Show Address</th>
    <td>{{ $template->show_address ? 'Yes' : 'No' }}</td>
</tr>

<tr>
    <th>Show Phone</th>
    <td>{{ $template->show_phone ? 'Yes' : 'No' }}</td>
</tr>

<tr>
    <th>Show GST</th>
    <td>{{ $template->show_gst ? 'Yes' : 'No' }}</td>
</tr>

<tr>
    <th>Terms & Conditions</th>
    <td>{{ $template->terms_conditions }}</td>
</tr>

<tr>
    <th>Status</th>
    <td>
        @if($template->status == 'Active')
            <span class="badge bg-success">Active</span>
        @else
            <span class="badge bg-danger">Inactive</span>
        @endif
    </td>
</tr>

</table>

<a href="{{ route('invoice-templates.index') }}"
   class="btn btn-secondary">
    Back
</a>

</div>

</div>

</div>

@endsection