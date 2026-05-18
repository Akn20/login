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

                <form method="POST" action="{{ route('admin.laboratory.result.submit', $sample->id) }}" enctype="multipart/form-data">
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
                <th>Status</th>
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
            data-min="{{ $param->parameter->min_value }}"
            data-max="{{ $param->parameter->max_value }}"
            data-status="status{{ $sample->id }}{{ $loop->index }}"
            oninput="checkRange(this,
                {{ $param->parameter->min_value }},
                {{ $param->parameter->max_value }},
                'status{{ $sample->id }}{{ $loop->index }}'
            )"
            {{ $sample->status == 'Completed' ? 'readonly' : '' }}>
    </td>

    <td>{{ $param->parameter->unit }}</td>

    <td>
        {{ $param->parameter->min_value }} -
        {{ $param->parameter->max_value }}
    </td>

    <td id="status{{ $sample->id }}{{ $loop->index }}">
        -
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