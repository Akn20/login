@extends('layouts.admin')

@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Result Entry</h3>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Patient Name</th>
                            <th>Test Name</th>
                            <th>Sample ID</th>
                            <th>Status</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach($samples as $key => $sample)
                            <tr>

                                <td>{{ $key + 1 }}</td>

                                <td>
                                    {{ ($sample->labRequest->patient->first_name ?? '') . ' ' . ($sample->labRequest->patient->last_name ?? '') }}
                                </td>

                                <td>{{ $sample->labRequest->test_name ?? '' }}</td>

                                <td>{{ $sample->sample_id ?? '-' }}</td>

                                <!-- STATUS -->
                                <td>
                                    @if($sample->status == 'Completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($sample->status == 'In Process')
                                        <span class="badge bg-info">In Process</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>

                                <!-- RESULT ENTRY -->
                                <td>
                                    @if($sample->status != 'Completed')
                                        <button class="btn btn-primary btn-sm" onclick="openResultModal('{{ $sample->id }}')">
                                            ENTER RESULT
                                        </button>
                                    @else
                                        <button class="btn btn-success btn-sm" onclick="openResultModal('{{ $sample->id }}')">
                                            VIEW RESULT
                                        </button>
                                    @endif
                                </td>



                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- MODALS -->
    @foreach($samples as $sample)

        <div id="resultModal{{ $sample->id }}" class="custom-modal">
            <div class="custom-modal-content">

                <h5>
                    @if(optional($sample->labReport)->status == 'Completed' || $sample->status == 'Completed')
                        View Result
                    @else
                        Enter Result
                    @endif
                </h5>
                <div class="mb-2">
                    <strong>Status:</strong>
                    @if($sample->labReport && $sample->labReport->status == 'Completed')
                        <span class="badge bg-success">Completed</span>
                    @else
                        <span class="badge bg-warning">Draft</span>
                    @endif
                </div>

                @php
                    $testName = strtolower($sample->labRequest->test_name ?? '');
                    $data = $sample->labReport->result_data ?? [];
                @endphp

                <form method="POST" action="{{ route('admin.laboratory.result.submit', $sample->id) }} "
                    enctype="multipart/form-data">
                    @csrf

                    {{-- ================= BLOOD TEST ================= --}}
                    @if(isset($sample->parameters) && count($sample->parameters) > 0)

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Parameter</th>
                <th>Value</th>
                <th>Unit</th>
                <th>Range</th>
            </tr>
        </thead>

        <tbody>
            @foreach($sample->parameters as $param)

                @php
                    $name = $param->parameter->name;
                @endphp

                <tr>
                    <td>{{ $name }}</td>

                    <td>
                        <input type="number"
                            name="parameters[{{ $name }}]"
                            value="{{ $data[$name] ?? '' }}"
                            class="form-control"
                            {{ $sample->status == 'Completed' ? 'readonly' : '' }}>
                    </td>

                    <td>{{ $param->parameter->unit }}</td>

                    <td>
                        {{ $param->parameter->min_value }} -
                        {{ $param->parameter->max_value }}
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

@else

    <div>
        <label><strong>Test Report</strong></label>

        <textarea name="report"
            class="form-control"
            rows="4"
            required
            {{ $sample->status == 'Completed' ? 'readonly' : '' }}>
            {{ $data['report'] ?? '' }}
        </textarea>
    </div>

@endif

                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Parameter</th>
                                    <th>Value</th>
                                    <th>Unit</th>
                                    <th>Range</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>Hemoglobin</td>
                                    <td>
                                        <input type="number" name="hemoglobin" value="{{ $data['hemoglobin'] ?? '' }}"
                                            class="form-control" required {{ $sample->status == 'Completed' ? 'readonly' : '' }}
                                            data-min="12" data-max="16" data-status="status{{ $sample->id }}1"
                                            oninput="checkRange(this, 12, 16, 'status{{ $sample->id }}1')">
                                    </td>
                                    <td>g/dL</td>
                                    <td>12 - 16</td>
                                    <td id="status{{ $sample->id }}1">-</td>
                                </tr>

                                <tr>
                                    <td>Glucose</td>
                                    <td>
                                        <input type="number" name="glucose" value="{{ $data['glucose'] ?? '' }}"
                                            class="form-control" required {{ $sample->status == 'Completed' ? 'readonly' : '' }}
                                            data-min="70" data-max="110" data-status="status{{ $sample->id }}2"
                                            oninput="checkRange(this, 70, 110, 'status{{ $sample->id }}2')">
                                    </td>
                                    <td>mg/dL</td>
                                    <td>70 - 110</td>
                                    <td id="status{{ $sample->id }}2">-</td>
                                </tr>

                            </tbody>
                        </table>

                        {{-- ================= ALL OTHER TESTS ================= --}}
                    @else

                        <div>
                            <label><strong>Test Report</strong></label>

                            <textarea name="report" class="form-control" rows="4" required {{ $sample->status == 'Completed' ? 'readonly' : '' }}>
                                    {{ $data['report'] ?? '' }}
                                    </textarea>
                        </div>

                    @endif

                    {{-- ================= FILE UPLOAD ================= --}}
                    @if($sample->status != 'Completed')

                        <div class="mb-2 mt-3">
                            <label>Upload Attachments</label>
                            <input type="file" name="attachments[]" class="form-control" multiple accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                    @endif
                    @if(!empty($data['attachments']))
                        <div class="mt-2">
                            <label><strong>Uploaded Files:</strong></label><br>

                            @foreach($data['attachments'] as $file)
                                <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                    View File
                                </a>
                            @endforeach
                        </div>
                    @endif
                    {{-- ================= BUTTONS ================= --}}
                    <div class="d-flex justify-content-end gap-2">

                        <button type="button" class="btn btn-secondary" width="50px"
                            onclick="closeResultModal('{{ $sample->id }}')">
                            Cancel
                        </button>

                        @if($sample->status != 'Completed')

                            <button type="submit" name="action" value="draft" class="btn btn-warning">
                                Save Draft
                            </button>

                            <button type="submit" name="action" value="submit"
                                onclick="return confirm('Are you sure to submit final result?')" class="btn btn-success">
                                Submit
                            </button>

                        @else

                            <span class="badge bg-success p-2 align-self-center">Result Submitted</span>

                        @endif

                    </div>

                </form>
            </div>
        </div>

    @endforeach

@endsection

<script>

    function initResultEntry() {

        window.openResultModal = function (id) {
            document.getElementById('resultModal' + id).style.display = 'block';
        };

        window.closeResultModal = function (id) {
            document.getElementById('resultModal' + id).style.display = 'none';
        };

        window.checkRange = function (input, min, max, statusId) {

            let value = parseFloat(input.value);
            let status = document.getElementById(statusId);

            if (!status) return;

            if (isNaN(value)) {
                status.innerHTML = "-";
                return;
            }

            if (value < min) {
                status.innerHTML = "Low";
                status.style.color = "orange";
            }
            else if (value > max) {
                status.innerHTML = "High";
                status.style.color = "red";
            }
            else {
                status.innerHTML = "Normal";
                status.style.color = "green";
            }
        };
    }

    document.addEventListener('DOMContentLoaded', function () {

        // 🔥 STEP 1: Initialize functions FIRST
        initResultEntry();

        // 🔥 STEP 2: THEN calculate existing values
        const inputs = document.querySelectorAll('input[type="number"]');

        inputs.forEach(input => {
            if (input.value) {

                const min = input.getAttribute('data-min');
                const max = input.getAttribute('data-max');
                const statusId = input.getAttribute('data-status');

                if (min && max && statusId) {
                    window.checkRange(input, parseFloat(min), parseFloat(max), statusId);
                }
            }
        });
    });

    // 🔥 CLICK OUTSIDE MODAL
    window.onclick = function (event) {
        let modals = document.getElementsByClassName('custom-modal');
        for (let modal of modals) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    };

</script>