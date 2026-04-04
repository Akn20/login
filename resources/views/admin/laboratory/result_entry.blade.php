
@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3>Result Entry</h3>
        </div>

        <div class="card-body">

            <!-- SUCCESS MESSAGE -->
            @if(session('success'))  
                <div id="successMessage" class="alert alert-success">
                    {{ session('success') }}
                </div>  
            @endif
            <!-- TABLE -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL No.</th>
                        <th>Patient Name</th>
                        <th>Test Name</th>
                        <th>Sample ID</th>
                        <th>Status</th>
                        <th>Result Entry</th>
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

                    <td>
                        <span class="badge 
                            @if($sample->status=='In Process') bg-info
                            @elseif($sample->status=='Completed') bg-success
                            @else bg-warning @endif">
                            {{ $sample->status }}
                        </span>
                    </td>

                    <td>
                        @if($sample->status == 'In Process')
                            <button type="button" class="btn btn-primary btn-sm"
                                onclick="openResultModal('{{ $sample->id }}')">
                                Enter Result
                            </button>
                        @else
                            <span class="text-muted">Not Available</span>
                        @endif
                    </td>

                    <td>
                        @if($sample->status == 'Completed')
                            <button class="btn btn-success btn-sm">View</button>
                        @endif
                    </td>

                </tr>
                @endforeach

                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- ✅ MODALS -->
@foreach($samples as $sample)

<div id="resultModal{{ $sample->id }}" class="custom-modal">
    <div class="custom-modal-content">

        <h5>Enter Result</h5>

        @php
            $data = $sample->labReport->result_data ?? [];
        @endphp

        <form method="POST" action="{{ route('admin.laboratory.result.submit', $sample->id) }}">
            @csrf

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
                            <input type="number" name="hemoglobin"
                                value="{{ $data['hemoglobin'] ?? '' }}"
                                class="form-control"
                                oninput="checkRange(this, 12, 16, 'status{{ $sample->id }}1')">
                        </td>
                        <td>g/dL</td>
                        <td>12 - 16</td>
                        <td id="status{{ $sample->id }}1">-</td>
                    </tr>

                    <tr>
                        <td>Glucose</td>
                        <td>
                            <input type="number" name="glucose"
                                value="{{ $data['glucose'] ?? '' }}"
                                class="form-control"
                                oninput="checkRange(this, 70, 110, 'status{{ $sample->id }}2')">
                        </td>
                        <td>mg/dL</td>
                        <td>70 - 110</td>
                        <td id="status{{ $sample->id }}2">-</td>
                    </tr>
                </tbody>
            </table>

            <!-- Attachments -->
            <div class="mb-2">
                <label>Upload Attachments</label>
                <input type="file" name="attachments[]" class="form-control" multiple>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">

                <button type="button" class="btn btn-secondary"
                    onclick="closeResultModal('{{ $sample->id }}')">
                    Cancel
                </button>

                <button type="submit"
                    formaction="{{ route('admin.laboratory.result.saveDraft', $sample->id) }}"
                    class="btn btn-warning">
                    Save Draft
                </button>

                <button type="submit" class="btn btn-success">
                    Submit
                </button>

            </div>

        </form>

    </div>
</div>

@endforeach

@endsection
<script>

/* ===============================
   INITIALIZE ALL FUNCTIONS
================================= */
function initResultEntry() {

    /* 🔹 OPEN MODAL */
    window.openResultModal = function(id) {
        let modal = document.getElementById('resultModal' + id);
        if (modal) {
            modal.style.display = 'block';
        } else {
            console.log("Modal not found:", id);
        }
    };

    /* 🔹 CLOSE MODAL */
    window.closeResultModal = function(id) {
        let modal = document.getElementById('resultModal' + id);
        if (modal) {
            modal.style.display = 'none';
        }
    };

    /* 🔹 RANGE CHECK */
    window.checkRange = function(input, min, max, statusId) {
        let value = parseFloat(input.value);
        let status = document.getElementById(statusId);

        if (!status) return;

        if (isNaN(value)) {
            status.innerHTML = "-";
            status.style.color = "";
            return;
        }

        if (value < min) {
            status.innerHTML = "Low";
            status.style.color = "orange";
        } else if (value > max) {
            status.innerHTML = "High";
            status.style.color = "red";
        } else {
            status.innerHTML = "Normal";
            status.style.color = "green";
        }
    };

    /* 🔥 AUTO HIDE SUCCESS MESSAGE */
    let msg = document.getElementById('successMessage');

    if (msg) {
        setTimeout(function () {
            msg.style.transition = "opacity 0.5s";
            msg.style.opacity = "0";

            setTimeout(() => {
                msg.remove();
            }, 500);

        }, 3000);
    }
}

/* ===============================
   NORMAL PAGE LOAD
================================= */
document.addEventListener('DOMContentLoaded', function () {
    initResultEntry();
});

/* ===============================
   UNPOLY AJAX LOAD
================================= */
up.on('up:content:updated', function () {
    initResultEntry();
});


/* ===============================
   CLICK OUTSIDE MODAL TO CLOSE
================================= */
window.onclick = function(event) {
    let modals = document.getElementsByClassName('custom-modal');

    for (let modal of modals) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
};

</script>