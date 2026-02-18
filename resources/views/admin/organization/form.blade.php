<div class="row">

    <!-- LEFT CARD -->
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Organization Master</h5>

                <div class="mb-3">
                    <label class="form-label">Organization Name *</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ old('name', $organization->name ?? '') }}" required pattern="^[A-Za-z\s]+$"
                        title="Only alphabets and spaces allowed">
                </div>

                <div class="mb-3">
                    <label class="form-label">Organization Type *</label>
                    <select name="type" class="form-control" required>
                        <option value="">Select Type</option>
                        <option value="Private" {{ old('type', $organization->type ?? '') == 'Private' ? 'selected' : '' }}>Private</option>
                        <option value="Trust" {{ old('type', $organization->type ?? '') == 'Trust' ? 'selected' : '' }}>
                            Trust</option>
                        <option value="Government" {{ old('type', $organization->type ?? '') == 'Government' ? 'selected' : '' }}>Government</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Registration Number</label>
                    <input type="text" name="registration_number" class="form-control"
                        value="{{ old('registration_number', $organization->registration_number ?? '') }}"
                        pattern="^[A-Za-z0-9\-\/]+$" title="Alphanumeric characters only">
                </div>

                <div class="mb-3">
                    <label class="form-label">GST / Tax ID</label>
                    <input type="text" name="gst" class="form-control"
                        value="{{ old('gst', $organization->gst ?? '') }}" pattern="^[A-Za-z0-9]{1,15}$"
                        title="GST must be alphanumeric and max 15 characters">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Number *</label>
                    <input type="text" name="contact_number" class="form-control"
                        value="{{ old('contact_number', $organization->contact_number ?? '') }}" required
                        pattern="^[0-9]{10}$" title="Enter valid 10 digit number">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', $organization->email ?? '') }}" required>
                </div>

            </div>
        </div>
    </div>

    <!-- RIGHT CARD -->
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Admin & Subscription</h5>

                <div class="mb-3">
                    <label class="form-label">Admin Name *</label>
                    <input type="text" name="admin_name" class="form-control"
                        value="{{ old('admin_name', $organization->admin_name ?? '') }}" required
                        pattern="^[A-Za-z\s]+$">
                </div>

                <div class="mb-3">
                    <label class="form-label">Admin Email *</label>
                    <input type="email" name="admin_email" class="form-control"
                        value="{{ old('admin_email', $organization->admin_email ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Admin Mobile *</label>
                    <input type="text" name="admin_mobile" class="form-control"
                        value="{{ old('admin_mobile', $organization->admin_mobile ?? '') }}" required
                        pattern="^[0-9]{10}$">
                </div>

                <div class="mb-3">
                    <label class="form-label">Subscription Plan *</label>
                    <select name="plan_type" class="form-control" required>
                        <option value="">Select Plan</option>
                        <option value="Basic" {{ old('plan_type', $organization->plan_type ?? '') == 'Basic' ? 'selected' : '' }}>Basic</option>
                        <option value="Standard" {{ old('plan_type', $organization->plan_type ?? '') == 'Standard' ? 'selected' : '' }}>Standard</option>
                        <option value="Premium" {{ old('plan_type', $organization->plan_type ?? '') == 'Premium' ? 'selected' : '' }}>Premium</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Organization Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="1" {{ old('status', $organization->status ?? 1) == 1 ? 'selected' : '' }}>Active
                        </option>
                        <option value="0" {{ old('status', $organization->status ?? 1) == 0 ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>

            </div>
        </div>
    </div>

    <!-- ADDRESS -->
    <div class="col-12">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Address Details</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Address *</label>
                        <textarea name="address" class="form-control"
                            required>{{ old('address', $organization->address ?? '') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>City *</label>
                        <input type="text" name="city" class="form-control"
                            value="{{ old('city', $organization->city ?? '') }}" required pattern="^[A-Za-z\s]+$">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>State *</label>
                        <input type="text" name="state" class="form-control"
                            value="{{ old('state', $organization->state ?? '') }}" required pattern="^[A-Za-z\s]+$">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Country *</label>
                        <input type="text" name="country" class="form-control"
                            value="{{ old('country', $organization->country ?? '') }}" required pattern="^[A-Za-z\s]+$">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Pincode *</label>
                        <input type="text" name="pincode" class="form-control"
                            value="{{ old('pincode', $organization->pincode ?? '') }}" required pattern="^[0-9]{6}$">
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>