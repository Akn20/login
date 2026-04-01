@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Sample Collection</h4>
    </div>

    <div class="card-body">
        <!-- TABLE -->
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>SL No.</th>
                    <th>Patient Name</th>
                    <th>Test Name</th>
                    <th>Sample ID</th>
                    <th>Collection Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @if($samples->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No samples found</td>
                    </tr>
                @endif
                @foreach($samples as $key => $sample)
                <tr>

                    <td>{{ $key + 1 }}</td>

                    <!-- Patient -->
                    <td>
                        {{ ($sample->labRequest->patient->first_name ?? '') . ' ' . ($sample->labRequest->patient->last_name ?? '') }}                    </td>

                    <!-- Test -->
                    <td>
                        {{ $sample->labRequest->test_name ?? '' }}
                    </td>

                    <!-- Sample ID -->
                    <td>{{ $sample->sample_id ?? '-' }}</td>

                    <!-- Time -->
                    <td>{{ $sample->collection_time ?? '-' }}</td>

                    <!-- STATUS -->
                    <td>
                        <span class="badge 
                            @if($sample->status=='Pending') bg-warning
                            @elseif($sample->status=='Collected') bg-primary
                            @elseif($sample->status=='In Process') bg-info
                            @elseif($sample->status=='Completed') bg-success
                            @else bg-danger @endif">
                            {{ $sample->status }}
                        </span>
                    </td>

                    <!-- ACTIONS -->
                    <td>

                        <!-- Collect -->
                       

                        @if($sample->status == 'Pending')
                            <form action="{{ route('admin.laboratory.sample.collect', $sample->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm">Collect</button>
                            </form>

                        @elseif($sample->status == 'Collected')
                            <form action="{{ route('admin.laboratory.sample.process', $sample->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="In Process">
                                <button class="btn btn-primary btn-sm">Start Processing</button>
                            </form>

                        @elseif($sample->status == 'In Process')
                            <form action="{{ route('admin.laboratory.sample.complete', $sample->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Completed">
                                <button class="btn btn-success btn-sm">Complete</button>
                            </form>
                        @endif

                        <!-- Reject -->
                         @if($sample->status == 'Rejected')
                            <button class="btn btn-primary btn-sm" 
                                    onclick="openReasonModal('{{ $sample->id }}')">
                                View Reason
                            </button>
                        @elseif($sample->status != 'Completed')
                            <button class="btn btn-danger btn-sm"
                                onclick="openModal('{{ $sample->id }}')">
                                Reject
                            </button>
                        @endif

                    </td>

                </tr>

                <!-- MODAL -->
                <div id="rejectModal{{ $sample->id }}" class="custom-modal">

                    <div class="custom-modal-content">

                        <h5>Reject Sample</h5>

                        <form method="POST" action="{{ route('admin.laboratory.sample.reject', $sample->id) }}">
                            @csrf

                            <textarea name="reason" class="form-control mb-4" required placeholder="Enter reason"></textarea>

                            <div  style="display: flex; gap: 30px; justify-content: flex-end; margin-top: 10px;">
                                <button type="button" class="btn btn-secondary btn-sm"
                                        onclick="closeModal('{{ $sample->id }}')">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Submit
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

                <!-- REASON MODAL -->
                <div id="reasonModal{{ $sample->id }}" class="custom-modal">

                    <div class="custom-modal-content">

                        <h5>Rejection Reason</h5>

                        <textarea class="form-control mb-2" readonly>
                            {{ $sample->rejection_reason }}
                        </textarea>

                        <div style="display: flex; justify-content: flex-end;">
                            <button class="btn btn-primary btn-sm"
                                    onclick="closeReasonModal('{{ $sample->id }}')">
                                Close
                            </button>
                        </div>

                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
<script>
function openModal(id) {
    document.getElementById('rejectModal' + id).style.display = 'block';
}

function closeModal(id) {
    document.getElementById('rejectModal' + id).style.display = 'none';
}

function openReasonModal(id) {
    document.getElementById('reasonModal' + id).style.display = 'block';
}

function closeReasonModal(id) {
    document.getElementById('reasonModal' + id).style.display = 'none';
}
</script>
