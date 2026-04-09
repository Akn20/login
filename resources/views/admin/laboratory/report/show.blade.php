@extends('layouts.admin')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')

    <div class="page-header">
        <h5>View Report</h5>

        <a href="{{ route('admin.laboratory.report.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="main-content">
        <div class="row">

            <!-- LEFT -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                        <p><strong>Sample:</strong> {{ $report->sample->sample_id }}</p>
                        <p><strong>Status:</strong> {{ $report->status }}</p>

                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                        <h5>Files</h5>

                        {{-- 🟢 MAIN REPORT --}}
                        <h6 class="mt-3">Main Report</h6>

                        @foreach($report->files->where('is_main', 1)->sortBy('version') as $file)
                            <div class="mb-2">
                                <a href="{{ Storage::url($file->file_path) }}" target="_blank">
                                    View (v{{ $file->version }})
                                </a>

                                <a href="{{ Storage::url($file->file_path) }}" download>
                                    Download
                                </a>

                                <small class="text-muted">
                                    ({{ $file->created_at->format('d M H:i') }})
                                </small>
                            </div>
                        @endforeach

                        {{-- 📎 SUPPORTING FILES --}}
                        <h6 class="mt-4">Attachments</h6>

                        @foreach($report->files->where('is_main', 0)->sortBy('version') as $file)
                            <div class="mb-2">
                                <a href="{{ Storage::url($file->file_path) }}" target="_blank">
                                    View (v{{ $file->version }})
                                </a>

                                <a href="{{ Storage::url($file->file_path) }}" download>
                                    Download
                                </a>

                                <small class="text-muted">
                                    ({{ $file->created_at->format('d M H:i') }})
                                </small>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection