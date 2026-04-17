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

                        @php
                            $files = $report->files->where('is_main', 1)->sortByDesc('version');
                            $latestVersion = $files->first()?->version;
                        @endphp

                        @foreach($files as $file)
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

                                {{-- LABELS --}}
                                @if($file->version == $latestVersion)
                                    <span class="badge bg-success ms-2">Current</span>

                                    <span class="badge bg-info">
                                        {{ $report->verification_status }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary ms-2">Old</span>
                                @endif

                            </div>
                        @endforeach

                        {{-- 📎 SUPPORTING FILES --}}
                        <h6 class="mt-4">Attachments</h6>

                        @foreach($report->files->where('is_main', 0)->sortByDesc('version') as $file)
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

                                <span class="badge bg-dark ms-2">Attachment</span>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
        <div class="card mt-3">
            <div class="card-body">

                <h5>Verification Panel</h5>

                <p>
                    <strong>Verification Status:</strong>
                    <span class="badge bg-info">
                        {{ $report->verification_status ?? 'Pending' }}
                    </span>
                </p>

                @if($report->verification_status == 'Rejected')
                    <div class="alert alert-danger">
                        This report was rejected. Please edit and resubmit.
                    </div>
                @endif

                @if($report->verification_status == 'Rejected')
                    <a href="{{ route('admin.laboratory.report.edit', $report->id) }}" class="btn btn-warning">
                        Edit & Resubmit
                    </a>
                @endif

                <div class="d-flex gap-2 flex-wrap">

                    {{-- VERIFY --}}
                    @if($report->status == 'Completed' && $report->verification_status == 'Pending')
                        <form method="POST" action="{{ route('admin.laboratory.report.verify', $report->id) }}">
                            @csrf
                            <button class="btn btn-success">Verify</button>
                        </form>

                        <form method="POST" action="{{ route('admin.laboratory.report.reject', $report->id) }}">
                            @csrf
                            <input type="text" name="notes" placeholder="Reason" class="form-control mb-1" required>
                            <button class="btn btn-danger">Reject</button>
                        </form>
                    @endif

                    {{-- SIGN --}}
                    @if($report->verification_status == 'Verified' && !$report->digital_signature)
                        <form method="POST" action="{{ route('admin.laboratory.report.sign', $report->id) }}">
                            @csrf
                            <button class="btn btn-warning">Sign</button>
                        </form>
                    @endif

                    {{-- FINALIZE --}}
                    @if($report->verification_status == 'Verified')
                        <form method="POST" action="{{ route('admin.laboratory.report.finalize', $report->id) }}">
                            @csrf
                            <button class="btn btn-primary">Finalize</button>
                        </form>
                    @endif

                </div>

                {{-- SIGNATURE --}}
                @if($report->digital_signature)
                    <p class="mt-3">
                        <strong>Signed By:</strong> {{ $report->digital_signature }}
                    </p>
                @endif

            </div>
        </div>
    </div>

@endsection