@csrf

<div class="row">

    <!-- LEFT -->
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Report Details</h5>

                <!-- Sample -->
                <div class="mb-3">
                    <label class="form-label">Sample *</label>
                    <select name="sample_id" class="form-control" required>
                        <option value="">Select Sample</option>
                        @foreach($samples as $sample)
                            <option value="{{ $sample->id }}">
                                {{ $sample->sample_id }} - {{ $sample->patient_id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Main Report -->
                <div class="mb-3">
                    <label class="form-label">Report File (PDF) *</label>
                    <input type="file" name="report_file" class="form-control" accept=".pdf" required>
                </div>

                <!-- Supporting -->
                <div class="mb-3">
                    <label class="form-label">Supporting Files</label>
                    <input type="file" name="supporting_files[]" class="form-control" multiple>
                </div>

            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Additional Info</h5>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        @foreach(['Draft','In Progress','Completed'] as $st)
                            <option value="{{ $st }}">{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Remarks -->
                <div class="mb-3">
                    <label class="form-label">Remarks</label>
                    <textarea name="remarks" class="form-control"></textarea>
                </div>

            </div>
        </div>
    </div>

</div>