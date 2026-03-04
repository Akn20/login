<div class="row">

    {{-- ===============================
        MEDICINE DETAILS (CREATE ONLY)
       =============================== --}}
    @if(!isset($batch))

        <div class="col-md-6 mb-3">
            <label class="form-label">
                Medicine Name <span class="text-danger">*</span>
            </label>
            <input type="text"
                   name="medicine_name"
                   value="{{ old('medicine_name') }}"
                   class="form-control"
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Generic Name</label>
            <input type="text"
                   name="generic_name"
                   value="{{ old('generic_name') }}"
                   class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Category</label>
            <input type="text"
                   name="category"
                   value="{{ old('category') }}"
                   class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Manufacturer</label>
            <input type="text"
                   name="manufacturer"
                   value="{{ old('manufacturer') }}"
                   class="form-control">
        </div>
        

        <hr class="my-3">

    @endif


    {{-- ===============================
        BATCH DETAILS (BOTH)
       =============================== --}}

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Batch Number <span class="text-danger">*</span>
        </label>
        <input type="text"
               name="batch_number"
               value="{{ old('batch_number', $batch->batch_number ?? '') }}"
               class="form-control"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Expiry Date <span class="text-danger">*</span>
        </label>
        <input type="date"
               name="expiry_date"
               value="{{ old('expiry_date', $batch->expiry_date ?? '') }}"
               class="form-control"
               required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Purchase Price</label>
        <input type="number"
               step="0.01"
               name="purchase_price"
               value="{{ old('purchase_price', $batch->purchase_price ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">MRP</label>
        <input type="number"
               step="0.01"
               name="mrp"
               value="{{ old('mrp', $batch->mrp ?? '') }}"
               class="form-control">
    </div>

    {{-- Quantity only in CREATE --}}
    @if(!isset($batch))
        <div class="col-md-4 mb-3">
            <label class="form-label">
                Opening Quantity <span class="text-danger">*</span>
            </label>
            <input type="number"
                   name="quantity"
                   value="{{ old('quantity') }}"
                   class="form-control"
                   required>
        </div>
    @endif

    <div class="col-md-6 mb-3">
        <label class="form-label">Reorder Level</label>
        <input type="number"
               name="reorder_level"
               value="{{ old('reorder_level', $batch->reorder_level ?? '') }}"
               class="form-control">
    </div>

    {{-- Status only in CREATE --}}
    <!-- @if(!isset($batch))
        <div class="col-md-6 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
    @endif -->

</div>