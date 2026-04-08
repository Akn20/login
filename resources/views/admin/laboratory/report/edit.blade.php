@extends('layouts.admin')

@section('content')

    <div class="page-header d-flex align-items-center">
        <h5 class="me-3">Upload More Files</h5>

        <a href="{{ route('admin.laboratory.report.show', $report->id) }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="main-content">
        <form method="POST" action="{{ route('admin.laboratory.report.updateFiles', $report->id) }}"
            enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-control">
                            @foreach(['Draft', 'In Progress', 'Completed'] as $st)
                                <option value="{{ $st }}" {{ $report->status == $st ? 'selected' : '' }}>
                                    {{ $st }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Main Report (PDF)</label>
                        <input type="file" name="report_file" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Supporting Files</label>
                        <input type="file" name="supporting_files[]" class="form-control" multiple>
                    </div>

                    <button class="btn btn-success">Upload</button>

                </div>
            </div>

        </form>
    </div>

@endsection