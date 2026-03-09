@csrf

<div class="row">

    {{-- LEFT CARD --}}
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Patient Basic Details</h5>

                <div class="mb-3">
                    <label class="form-label">First Name *</label>
                    <input type="text"
                           name="first_name"
                           class="form-control"
                           value="{{ old('first_name', $patient->first_name ?? '') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name *</label>
                    <input type="text"
                           name="last_name"
                           class="form-control"
                           value="{{ old('last_name', $patient->last_name ?? '') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender *</label>
                    <select name="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender', $patient->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $patient->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $patient->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date of Birth *</label>
                    <input type="date"
                           name="date_of_birth"
                           class="form-control"
                           value="{{ old('date_of_birth', $patient->date_of_birth ?? '') }}"
                           required>
                </div>

            </div>
        </div>
    </div>


    {{-- RIGHT CARD --}}
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Contact Information</h5>

                <div class="mb-3">
                    <label class="form-label">Mobile *</label>
                    <input type="text"
                           name="mobile"
                           class="form-control"
                           value="{{ old('mobile', $patient->mobile ?? '') }}"
                           pattern="[0-9]{10}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $patient->email ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Emergency Contact</label>
                    <input type="text"
                           name="emergency_contact"
                           class="form-control"
                           value="{{ old('emergency_contact', $patient->emergency_contact ?? '') }}"
                           pattern="[0-9]{10}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Blood Group</label>
                    <select name="blood_group" class="form-control">
                        <option value="">Select</option>
                        @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $group)
                            <option value="{{ $group }}"
                                {{ old('blood_group', $patient->blood_group ?? '') == $group ? 'selected' : '' }}>
                                {{ $group }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
    </div>


    {{-- ADDRESS CARD --}}
    <div class="col-12">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Address Details</h5>

                <div class="mb-3">
                    <label class="form-label">Address *</label>
                    <textarea name="address"
                              class="form-control"
                              required>{{ old('address', $patient->address ?? '') }}</textarea>
                </div>

            </div>
        </div>
    </div>


    {{-- STATUS & VIP --}}
    <div class="col-12">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Additional Settings</h5>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="1" {{ old('status', $patient->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $patient->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <!-- IMPORTANT FIX -->
                            <input type="hidden" name="is_vip" value="0">

                            <input type="checkbox"
                                name="is_vip"
                                value="1"
                                {{ isset($patient) && $patient->is_vip ? 'checked' : '' }}>
                            <label class="form-check-label">Mark as VIP</label>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>