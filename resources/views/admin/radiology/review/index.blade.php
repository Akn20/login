@extends('layouts.admin')

@section('content')

<div class="nxl-content">

<h5>Radiology Review</h5>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Patient</th>
            <th>Scan Type</th>
            <th>Files</th>
            <th class="text-end">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($requests as $req)
        <tr>

            <td>
                {{ $req->patient->first_name ?? '' }}
            </td>

            <td>{{ $req->scanType->name }}</td>

            {{-- 🔥 FILE PREVIEW COLUMN --}}
            <td>
                @foreach($req->uploads as $file)

                    <a href="{{ route('admin.radiology.upload.view', $file->id) }}"
                        
                        class="me-2">

                        <i class="feather-eye"></i>

                    </a>

                @endforeach
            </td>

            {{-- 🔥 REVIEW BUTTON --}}
            <td class="text-end">
                <a href="{{ route('admin.radiology.review.show',$req->id) }}"
                    class="btn btn-primary btn-sm">
                    Review
                </a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection