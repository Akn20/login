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
                        <textarea name="address" id="address"
                            class="form-control">{{ old('address', $institution->address ?? '') }}</textarea>
                    </div>

                    <div class="col-md-3">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" id="city"
                            value="{{ old('city', $institution->city ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label>State</label>
                        <input type="text" name="state" class="form-control" id="state"
                            value="{{ old('state', $institution->state ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Country</label>
                        <input type="text" name="country" class="form-control" id="country"
                            value="{{ old('country', $institution->country ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Pincode</label>
                        <input type="text" name="pincode" class="form-control" id="pincode"
                            value="{{ old('pincode', $institution->pincode ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Timezone</label>
                        <input type="text" name="timezone" class="form-control" id="timezone"
                            value="{{ old('timezone', $institution->timezone ?? '') }}">
                    </div>

                </div>
            </div>
        </div>

        {{-- ================= 2. GEOFENCES ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>2. GeoFences</h5>
                </div>
                <div class="card-body row g-3">
                    <div class="col-md-12">
                        <label>Select Location</label>
                        <div id="map" style="height:400px;border-radius:8px;"></div>
                    </div>
                    <div class="mb-3">
                        <button type="button" id="addGeofence" class="btn btn-primary">
                            Add Geofence
                        </button>
                    </div>
                    <div id="geofenceInputs"></div>
                </div>
            </div>
        </div>

        {{-- ================= 3. BRANDING ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>3. Branding</h5>
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


        {{-- ================= 4. ADMIN ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>4. Admin</h5>
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


        {{-- ================= 5. LEGAL & COMMERCIAL ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>5. Legal & Commercial</h5>
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


        {{-- ================= 6. BILLING ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>6. Billing</h5>
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


        {{-- ================= 7. SUPPORT ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>7. Support</h5>
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

<script>
    let existingGeofences = @json(isset($institution) ? $institution->geofences : []);
</script>

<script>

    let map;
    let geofenceIndex = 0;
    let activeGeofence = null;
    let geofences = [];

    document.addEventListener("DOMContentLoaded", function () {
        let lat = 10.8505;
        let lng = 76.2711;

        if (existingGeofences.length > 0) {
            console.log(existingGeofences)
            lat = existingGeofences[0].center_lat;
            lng = existingGeofences[0].center_lng;
        }

        map = L.map('map').setView([lat, lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);
        // LOAD EXISTING GEOFENCES
        if (existingGeofences?.length > 0) {

            existingGeofences?.forEach((geo, index) => {

                createExistingGeofence(
                    geo.name,
                    geo.center_lat,
                    geo.center_lng,
                    geo.radius,
                    geo.status
                );

            });

        }
        // MAP CLICK EVENT
        map.on("click", function (e) {

            if (activeGeofence === null) return;

            let lat = e.latlng.lat;
            let lng = e.latlng.lng;

            document.getElementById(`lat_${activeGeofence}`).value = lat;
            document.getElementById(`lng_${activeGeofence}`).value = lng;

            placeMarker(activeGeofence, lat, lng);

        });

    });

    function createExistingGeofence(name, lat, lng, radius, status) {

        let index = geofenceIndex++;

        // Create marker
        let marker = L.marker([lat, lng], { draggable: true }).addTo(map);

        // Create circle
        let circle = L.circle([lat, lng], {
            radius: radius,
            color: 'red',
            fillOpacity: 0.2
        }).addTo(map);

        geofences[index] = {
            marker: marker,
            circle: circle
        };

        // Add card
        let html = `
    <div class="card p-3 mt-3" id="geofence_card_${index}">

        <h6>Geofence ${index + 1}</h6>

        <div class="row">

            <div class="col-md-3">
                Name
                <input type="text"
                       name="geofences[${index}][name]"
                       value="${name}"
                       class="form-control">
            </div>

            <div class="col-md-2">
                Radius
                <input type="number"
                       name="geofences[${index}][radius]"
                       value="${radius}"
                       class="form-control"
                       onchange="updateRadius(${index},this.value)">
            </div>

            <div class="col-md-2">
                Latitude
                <input type="text"
                       name="geofences[${index}][lat]"
                       id="lat_${index}"
                       value="${lat}"
                       class="form-control">
            </div>

            <div class="col-md-2">
                Longitude
                <input type="text"
                       name="geofences[${index}][lng]"
                       id="lng_${index}"
                       value="${lng}"
                       class="form-control">
            </div>

            <div class="col-md-2">
                Status
                <select name="geofences[${index}][status]" class="form-control">
                    <option value="1" ${status == 1 ? 'selected' : ''}>Active</option>
                    <option value="0" ${status == 0 ? 'selected' : ''}>Inactive</option>
                </select>
            </div>
        <div class="col-md-1">
            Action
                <button type="button"
                        class="btn btn-danger"
                        onclick="removeGeofence(${index})">
                        <i class="feather feather-trash-2"></i>
                </button>
            </div>
        </div>

    </div>
    `;

        document.getElementById("geofenceInputs").insertAdjacentHTML("beforeend", html);

        // Drag marker update
        marker.on("drag", function () {

            let pos = marker.getLatLng();

            circle.setLatLng(pos);

            document.getElementById(`lat_${index}`).value = pos.lat;
            document.getElementById(`lng_${index}`).value = pos.lng;

        });

    }
    /* ADD GEOFENCE CARD */

    document.getElementById("addGeofence").addEventListener("click", function () {

        let index = geofenceIndex++;

        activeGeofence = index;

        let html = `
    <div class="card p-3 mt-3" id="geofence_card_${index}">
        <h6>Geofence ${index + 1}</h6>

        <div class="row">

            <div class="col-md-3">
                Name*
                <input type="text" name="geofences[${index}][name]" class="form-control" required>
            </div>

            <div class="col-md-2">
                Radius
                <input type="number"
                       name="geofences[${index}][radius]"
                       value="100"
                       class="form-control"
                       onchange="updateRadius(${index},this.value)">
            </div>

            <div class="col-md-2">
                Latitude
                <input type="text"
                       name="geofences[${index}][lat]"
                       id="lat_${index}"
                       class="form-control"
                       readonly>
            </div>

            <div class="col-md-2">
                Longitude
                <input type="text"
                       name="geofences[${index}][lng]"
                       id="lng_${index}"
                       class="form-control"
                       readonly>
            </div>

            <div class="col-md-2">
                Status
                <select name="geofences[${index}][status]" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="col-md-1">
            Action
                <button type="button"
                        class="btn btn-danger"
                        onclick="removeGeofence(${index})">
                        <i class="feather feather-trash-2"></i>
                </button>
            </div>

        </div>

        <small class="text-muted">
        Click on the map to select this geofence location
        </small>

    </div>
    `;

        document.getElementById("geofenceInputs").insertAdjacentHTML("beforeend", html);

    });


    /* PLACE MARKER */

    function placeMarker(index, lat, lng) {

        let radiusInput = document.querySelector(`[name="geofences[${index}][radius]"]`);
        let radius = radiusInput.value || 100;

        if (geofences[index]) {

            map.removeLayer(geofences[index].marker);
            map.removeLayer(geofences[index].circle);

        }

        let marker = L.marker([lat, lng], { draggable: true }).addTo(map);

        let circle = L.circle([lat, lng], {
            radius: radius,
            color: 'red',
            fillOpacity: 0.2
        }).addTo(map);

        marker.on("drag", function () {

            let pos = marker.getLatLng();

            circle.setLatLng(pos);

            document.getElementById(`lat_${index}`).value = pos.lat;
            document.getElementById(`lng_${index}`).value = pos.lng;

        });

        geofences[index] = {
            marker: marker,
            circle: circle
        };

    }


    /* UPDATE RADIUS */

    function updateRadius(index, value) {

        if (!geofences[index]) return;

        geofences[index].circle.setRadius(value);

    }


    /* REMOVE GEOFENCE */

    function removeGeofence(index) {

        if (geofences[index]) {

            map.removeLayer(geofences[index].marker);
            map.removeLayer(geofences[index].circle);

        }

        document.getElementById(`geofence_card_${index}`).remove();

    }

</script>