@extends('layouts.admin')

@section('content')

<div class="container-fluid">

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
                    <h5 class="mb-0">
                        Clinical Interpretation Notes
                    </h5>
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

                            <a href="{{ route('doctor.radiology.index') }}"class="btn btn-secondary btn-sm">Back</a>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection