<div class="main-content">
    <div class="row">

        {{-- ================= 1. CORE DETAILS ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>1. Institution Details</h5>
                </div>
                <div class="card-body row g-3">

                    <div class="col-md-6">
                        <label>Organization *</label>
                        <select name="organization_id" class="form-control" required>
                            <option value="">Select Organization</option>
                            @foreach($organizations as $org)
                                <option value="{{ $org->id }}" {{ old('organization_id', $institution->organization_id ?? '') == $org->id ? 'selected' : '' }}>
                                    {{ $org->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Institution Name *</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $institution->name ?? '') }}" required pattern="^[A-Za-z\s]+$">
                    </div>

                    <div class="col-md-6">
                        <label>Institution Code *</label>
                        <input type="text" class="form-control"
                            value="{{ old('code', $institution->code ?? $nextCode ?? '') }}" readonly>
                        <input type="hidden" name="code"
                            value="{{ old('code', $institution->code ?? $nextCode ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label>GST Number</label>
                        <input type="text" name="gst_number" class="form-control"
                            value="{{ old('gst_number', $institution->gst_number ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $institution->email ?? '') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label>Contact Number *</label>
                        <input type="text" name="contact_number" class="form-control"
                            value="{{ old('contact_number', $institution->contact_number ?? '') }}" required
                            pattern="^[0-9]{8,15}$">
                    </div>

                    <div class="col-md-12">
                        <label>Address</label>
                        <textarea name="address"
                            class="form-control">{{ old('address', $institution->address ?? '') }}</textarea>
                    </div>

                    <div class="col-md-3">
                        <label>City</label>
                        <input type="text" name="city" class="form-control"
                            value="{{ old('city', $institution->city ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label>State</label>
                        <input type="text" name="state" class="form-control"
                            value="{{ old('state', $institution->state ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Country</label>
                        <input type="text" name="country" class="form-control"
                            value="{{ old('country', $institution->country ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Pincode</label>
                        <input type="text" name="pincode" class="form-control"
                            value="{{ old('pincode', $institution->pincode ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label>Timezone</label>
                        <input type="text" name="timezone" class="form-control"
                            value="{{ old('timezone', $institution->timezone ?? '') }}">
                    </div>

                </div>
            </div>
        </div>


        {{-- ================= 2. BRANDING ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>2. Branding</h5>
                </div>
                <div class="card-body row g-3">

                    <div class="col-md-6">
                        <label>Institution URL</label>
                        <input type="url" name="institution_url" class="form-control"
                            value="{{ old('institution_url', $institution->institution_url ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label>Login Template</label>
                        <input type="text" name="login_template" class="form-control"
                            value="{{ old('login_template', $institution->login_template ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label>Default Language</label>
                        <input type="text" name="default_language" class="form-control"
                            value="{{ old('default_language', $institution->default_language ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label>Logo</label>
                        <input type="file" name="logo" class="form-control">
                    </div>

                </div>
            </div>
        </div>


        {{-- ================= 3. ADMIN ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>3. Admin</h5>
                </div>
                <div class="card-body row g-3">

                    <div class="col-md-4">
                        <label>Admin Name</label>
                        <input type="text" name="admin_name" class="form-control"
                            value="{{ old('admin_name', $institution->admin_name ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Admin Email</label>
                        <input type="email" name="admin_email" class="form-control"
                            value="{{ old('admin_email', $institution->admin_email ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Admin Mobile</label>
                        <input type="text" name="admin_mobile" class="form-control"
                            value="{{ old('admin_mobile', $institution->admin_mobile ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Role</label>
                        <input type="text" name="role" class="form-control"
                            value="{{ old('role', $institution->role ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="1" {{ old('status', $institution->status ?? 1) == 1 ? 'selected' : '' }}>
                                Active </option>
                            <option value="0" {{ old('status', $institution->status ?? 1) == 0 ? 'selected' : '' }}>
                                Inactive </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Modules *</label>
                        @php $selectedModules = old('modules', isset($institution) && $institution->modules ? $institution->modules->pluck('id')->toArray() : []); @endphp
                        <select name="modules[]" class="form-control select2" multiple="multiple" required
                            style="width:100%;">
                            @foreach($modules as $module) <option value="{{ $module->id }}" {{ in_array($module->id, $selectedModules) ? 'selected' : '' }}> {{ $module->module_display_name }} </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>


        {{-- ================= 4. LEGAL & COMMERCIAL ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>4. Legal & Commercial</h5>
                </div>
                <div class="card-body row g-3">

                    <div class="col-md-4">
                        <label>MOU Copy</label>

                        @if(isset($institution) && $institution->mou_copy)
                            <p>

                                <a href="{{ asset($institution->mou_copy) }}" target="_blank">

                                </a>
                            </p>
                        @endif

                        <input type="file" name="mou_copy" class="form-control">
                    </div>


                    <div class="col-md-4">
                        <label>PO Number</label>
                        <input type="text" name="po_number" class="form-control"
                            value="{{ old('po_number', $institution->po_number ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label>PO Start Date</label>
                        <input type="date" name="po_start_date" class="form-control"
                            value="{{ old('po_start_date', $institution->po_start_date ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label>PO End Date</label>
                        <input type="date" name="po_end_date" class="form-control"
                            value="{{ old('po_end_date', $institution->po_end_date ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Subscription Plan</label>
                        <select name="subscription_plan" class="form-control">
                            <option value="">Select Plan</option>

                            <option value="Basic" {{ old('subscription_plan', $institution->subscription_plan ?? '') == 'Basic' ? 'selected' : '' }}>
                                Basic
                            </option>

                            <option value="Standard" {{ old('subscription_plan', $institution->subscription_plan ?? '') == 'Standard' ? 'selected' : '' }}>
                                Standard
                            </option>

                            <option value="Premium" {{ old('subscription_plan', $institution->subscription_plan ?? '') == 'Premium' ? 'selected' : '' }}>
                                Premium
                            </option>

                            <option value="Enterprise" {{ old('subscription_plan', $institution->subscription_plan ?? '') == 'Enterprise' ? 'selected' : '' }}>
                                Enterprise
                            </option>
                        </select>
                    </div>


                </div>
            </div>
        </div>


        {{-- ================= 5. BILLING ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>5. Billing</h5>
                </div>
                <div class="card-body row g-3">

                    <div class="col-md-3">
                        <label>Invoice Type</label>
                        <input type="text" name="invoice_type" class="form-control"
                            value="{{ old('invoice_type', $institution->invoice_type ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Invoice Frequency</label>
                        <input type="text" name="invoice_frequency" class="form-control"
                            value="{{ old('invoice_frequency', $institution->invoice_frequency ?? '') }}">
                    </div>


                    <div class="col-md-4">
                        <label>Payment Mode</label>
                        <select name="payment_mode" class="form-control">
                            <option value="">Select Payment Mode</option>

                            <option value="Cash" {{ old('payment_mode', $institution->payment_mode ?? '') == 'Cash' ? 'selected' : '' }}>
                                Cash
                            </option>

                            <option value="Online" {{ old('payment_mode', $institution->payment_mode ?? '') == 'Online' ? 'selected' : '' }}>
                                Online
                            </option>

                            <option value="Cheque" {{ old('payment_mode', $institution->payment_mode ?? '') == 'Cheque' ? 'selected' : '' }}>
                                Cheque
                            </option>

                            <option value="UPI" {{ old('payment_mode', $institution->payment_mode ?? '') == 'UPI' ? 'selected' : '' }}>
                                UPI
                            </option>

                            <option value="Bank Transfer" {{ old('payment_mode', $institution->payment_mode ?? '') == 'Bank Transfer' ? 'selected' : '' }}>
                                Bank Transfer
                            </option>

                        </select>
                    </div>



                    <div class="col-md-3">
                        <label>Invoice Amount</label>
                        <input type="number" step="0.01" name="invoice_amount" class="form-control"
                            value="{{ old('invoice_amount', $institution->invoice_amount ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Payment Status</label>
                        <select name="payment_status" class="form-control">
                            <option value="">Select Status</option>

                            <option value="Pending" {{ old('payment_status', $institution->payment_status ?? '') == 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="Paid" {{ old('payment_status', $institution->payment_status ?? '') == 'Paid' ? 'selected' : '' }}>
                                Paid
                            </option>

                            <option value="Partially Paid" {{ old('payment_status', $institution->payment_status ?? '') == 'Partially Paid' ? 'selected' : '' }}>
                                Partially Paid
                            </option>

                            <option value="Overdue" {{ old('payment_status', $institution->payment_status ?? '') == 'Overdue' ? 'selected' : '' }}>
                                Overdue
                            </option>

                            <option value="Cancelled" {{ old('payment_status', $institution->payment_status ?? '') == 'Cancelled' ? 'selected' : '' }}>
                                Cancelled
                            </option>
                        </select>
                    </div>


                    <div class="col-md-3">
                        <label>Payment Received</label>
                        <select name="payment_received" class="form-control">
                            <option value="0" {{ old('payment_received', $institution->payment_received ?? 0) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('payment_received', $institution->payment_received ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Payment Date</label>
                        <input type="date" name="payment_date" class="form-control"
                            value="{{ old('payment_date', $institution->payment_date ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Transaction Reference</label>
                        <input type="text" name="transaction_reference" class="form-control"
                            value="{{ old('transaction_reference', $institution->transaction_reference ?? '') }}">
                    </div>

                </div>
            </div>
        </div>


        {{-- ================= 6. SUPPORT ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>6. Support</h5>
                </div>
                <div class="card-body row g-3">

                    <div class="col-md-4">
                        <label>POC Name</label>
                        <input type="text" name="poc_name" class="form-control"
                            value="{{ old('poc_name', $institution->poc_name ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label>POC Email</label>
                        <input type="email" name="poc_email" class="form-control"
                            value="{{ old('poc_email', $institution->poc_email ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label>POC Contact</label>
                        <input type="text" name="poc_contact" class="form-control"
                            value="{{ old('poc_contact', $institution->poc_contact ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Support SLA</label>
                        <input type="text" name="support_sla" class="form-control"
                            value="{{ old('support_sla', $institution->support_sla ?? '') }}">
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>