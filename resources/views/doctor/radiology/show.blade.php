@extends('layouts.admin')

@section('content')

<div class="nxl-content">
   
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            
            <div class="page-header-title">
                <h5 class="m-b-10">Radiology Report Details</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Doctor</li>
                <li class="breadcrumb-item">Radiology</li>
                <li class="breadcrumb-item">Report Details</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('doctor.radiology.index') }}" class="btn btn-secondary">
                Back to Reports
            </a>

        </div>
    </div>
    
    <div class="main-content">
        
        <div class="row justify-content-center">

            <div class="col-lg-9">

                <!-- Report Details Card -->

                <div class="card mb-3">

                    <div class="card-header">
                        <h5 class="mb-0">Radiology Report</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <p><strong>Patient :</strong> {{ $report->request->patient->first_name }} {{ $report->request->patient->last_name }}</p>
                                <p><strong>Scan Type :</strong>{{ $report->request->scanType->name }} </p>
                                <p><strong>Status :</strong> {{ $report->status }} </p>
                            </div>


                            <div class="col-md-6">
                                <p> <strong>Radiologist Findings :</strong>{{ $report->findings }}</p>
                                <p><strong>Diagnosis :</strong>{{ $report->diagnosis }}</p>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Upload Card -->

                <div class="card mb-3">

                    <div class="card-header">
                        <h5 class="mb-0">Uploaded Scans</h5>
                    </div>

                    <div class="card-body">

                        @foreach($report->request->uploads as $upload)

                            <div class="d-flex align-items-center gap-2">

                                <a href="{{ asset('storage/'.$upload->file_path) }}" target="_blank"
                                class="btn btn-primary btn-sm"> View Scan
                                </a>

                                <a href="{{ route('doctor.radiology.download', $report->id) }}" class="btn btn-primary btn-sm">
                                    Download Report
                                </a>
                            </div>

                        @endforeach

                    </div>
                </div>

                <!-- Notes Card -->

                <div class="card">

                    <div class="card-header">
                        <h5 class="mb-0">Clinical Interpretation Notes</h5>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('doctor.radiology.note') }}"
                            method="POST">

                            @csrf
                            <input type="hidden" name="report_id" value="{{ $report->id }}">

                            <div class="mb-3">
                                <textarea
                                    name="notes"
                                    rows="4"
                                    class="form-control"
                                    placeholder="Add interpretation notes">
                                </textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm"> Save Note</button>
                            </div>

                        </form>

                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <strong> Previous Clinical Notes</strong>
                    </div>

                    <div class="card-body">

                        @forelse($notes as $note)

                            <div class="border rounded p-3 mb-3">

                                <p class="mb-1">{{ $note->interpretation_notes }}</p>

                                <small class="text-muted">Added: {{ $note->created_at->format('d-m-Y h:i A') }}</small>
                            </div>

                        @empty

                            <p class="text-muted">No clinical notes added.</p>

                        @endforelse

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection