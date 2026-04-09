@extends('layouts.admin')

@section('content')

<div class="nxl-content">

<h5>Upload Scan Files</h5>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.radiology.upload.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
    <label>Select Scan Request</label>
    <select name="scan_request_id" class="form-control">
        @foreach($requests as $req)
        <option value="{{ $req->id }}">
            {{ $req->patient->first_name ?? '' }} - {{ $req->body_part }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Upload Files</label>
    <input type="file" name="files[]" multiple class="form-control">
</div>

<div class="mb-3">
    <label>Notes</label>
    <textarea name="notes" class="form-control"></textarea>
</div>

<button class="btn btn-success">Upload</button>

</form>

{{-- 🔥 ADD THIS PART BELOW FORM --}}

<hr>

<h5 class="mt-4">Uploaded Files</h5>

<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Patient</th>
            <th>File</th>
            <th>Type</th>
            <th class="text-end">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($uploads as $key => $file)
        <tr>
            <td>{{ $key+1 }}</td>

            <td>
                {{ optional($file->scanRequest->patient)->first_name }}
                {{ optional($file->scanRequest->patient)->last_name }}
            </td>

            <td>
                <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">
                    Open File
                </a>
            </td>

            <td>{{ strtoupper($file->file_type) }}</td>

            <td class="text-end">
                <div class="hstack gap-2 justify-content-end">

                    {{-- 👁️ VIEW --}}
                    <a href="{{ route('admin.radiology.upload.view', $file->id) }}"
                        
                        class="avatar-text avatar-md action-icon">
                        <i class="feather-eye"></i>
                    </a>

                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection