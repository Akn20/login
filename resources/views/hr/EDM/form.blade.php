<div class="row">

    <!-- Employee Dropdown -->
    <div class="col-md-6 mb-3">
        <label>Employee</label>
        <select name="staff_id" class="form-control" required>
            <option value="">Select Employee</option>
            @foreach($employees as $emp)
                <option value="{{ $emp->id }}"
                    {{ old('staff_id', session('employee_id')) == $emp->id ? 'selected' : '' }}>
                    {{ $emp->employee_id }} - {{ $emp->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Document Type -->
    <div class="col-md-6 mb-3">
        <label>Document Type</label>
        <select name="document_type" class="form-control" required>
            <option value="">Select Type</option>
            <option>Offer Letter</option>
            <option>Appointment Letter</option>
            <option>ID Proof</option>
            <option>Certificate</option>
            <option>Medical License</option>
        </select>
    </div>

    <!-- File Upload -->
    <div class="col-md-6 mb-3">
        <label>Upload File</label>
        <input type="file" name="file" class="form-control" required>
    </div>

    <!-- Expiry Date -->
    <div class="col-md-6 mb-3">
        <label>Expiry Date</label>
        <input type="date" name="expiry_date" class="form-control">
    </div>

</div>