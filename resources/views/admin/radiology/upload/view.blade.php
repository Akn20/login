@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    {{-- HEADER --}}
    <div class="page-header d-flex justify-content-between align-items-center">
        <h5>Scan Preview</h5>

        <div class="d-flex gap-2">
            {{-- 🔙 BACK BUTTON --}}
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                ← Back
            </a>

            {{-- ⬇️ DOWNLOAD --}}
            <a href="{{ asset('storage/'.$file->file_path) }}" 
               download 
               class="btn btn-success btn-sm">
                Download
            </a>
        </div>
    </div>

    {{-- FILE INFO --}}
    <div class="card mb-3">
        <div class="card-body">

            <p><strong>File Type:</strong> {{ strtoupper($file->file_type) }}</p>

            <p><strong>Patient:</strong> 
                {{ optional($file->scanRequest->patient)->first_name }} 
                {{ optional($file->scanRequest->patient)->last_name }}
            </p>

        </div>
    </div>

    {{-- PREVIEW AREA --}}
    <div class="card">
        <div class="card-body text-center">

            @if(in_array($file->file_type, ['jpg','jpeg','png']))
                <img src="{{ asset('storage/'.$file->file_path) }}" 
                     class="img-fluid rounded">
            
            @elseif($file->file_type == 'pdf')
                <iframe src="{{ asset('storage/'.$file->file_path) }}" 
                        width="100%" 
                        height="600px"
                        style="border: none;">
                </iframe>

            @else
                <p class="text-danger">Preview not supported</p>
            @endif

        </div>
    </div>

</div>

@endsection