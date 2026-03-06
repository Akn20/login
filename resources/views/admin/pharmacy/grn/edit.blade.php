{{-- resources/views/admin/pharmacy/grn/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit GRN')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Edit Goods Receipt Note (GRN)</h4>
            <small class="text-muted">Pharmacy → GRN → Edit ({{ $grn->grn_no }})</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.grn.show', $grn->id) }}" class="btn btn-light">
                <i class="feather-eye"></i> View
            </a>
            <a href="{{ route('admin.grn.index') }}" class="btn btn-light">
                <i class="feather-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- NOTE --}}
    @if($grn->status !== 'Draft')
        <div class="alert alert-warning">
            <strong>Note:</strong> Editing is allowed only when status is <b>Draft</b>.
        </div>
    @endif

    {{-- ERRORS --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.grn.update', $grn->id) }}" method="POST" id="grnEditForm">
        @csrf
        @method('PUT')

        {{-- GRN HEADER DETAILS --}}
        <div class="card mb-3">
            <div class="card-header">
                <strong>GRN Details</strong>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label">GRN No</label>
                        <input type="text" class="form-control" value="{{ $grn->grn_no }}" readonly>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">GRN Date</label>
                        <input type="date" name="grn_date" class="form-control"
                               value="{{ old('grn_date', $grn->grn_date) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Vendor <span class="text-danger">*</span></label>
                        <select class="form-select" name="vendor_id" required>
                            <option value="">Select Vendor</option>
                            @foreach($vendors as $v)
                                <option value="{{ $v->id }}"
                                    {{ old('vendor_id', $grn->vendor_id) == $v->id ? 'selected' : '' }}>
                                    {{ $v->vendor_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Invoice No <span class="text-danger">*</span></label>
                        <input type="text" name="invoice_no" class="form-control"
                               value="{{ old('invoice_no', $grn->invoice_no) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                        <input type="date" name="invoice_date" class="form-control"
                               value="{{ old('invoice_date', $grn->invoice_date) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Purchase Order (Optional)</label>
                        <input type="text" name="po_no" class="form-control"
                               value="{{ old('po_no', $grn->po_no) }}" placeholder="PO No (if any)">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Remarks</label>
                        <input type="text" name="remarks" class="form-control"
                               value="{{ old('remarks', $grn->remarks) }}" placeholder="Remarks (optional)">
                    </div>

                </div>
            </div>
        </div>

        {{-- ITEMS TABLE --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>GRN Items</strong>

                <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">
                    <i class="feather-plus"></i> Add Item
                </button>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover align-middle" id="itemsTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;">SL</th>
                            <th style="min-width: 220px;">Medicine</th>
                            <th style="min-width: 130px;">Batch No</th>
                            <th style="min-width: 140px;">Expiry</th>
                            <th style="min-width: 110px;" class="text-end">Qty</th>
                            <th style="min-width: 110px;" class="text-end">Free Qty</th>
                            <th style="min-width: 130px;" class="text-end">Purchase Rate</th>
                            <th style="min-width: 110px;" class="text-end">Disc %</th>
                            <th style="min-width: 110px;" class="text-end">Tax %</th>
                            <th style="min-width: 140px;" class="text-end">Amount</th>
                            <th style="width:90px;" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody id="itemsBody">
                        @php
                            $oldItems = old('items');
                            $itemsToRender = is_array($oldItems) ? $oldItems : $grn->items->toArray();
                        @endphp

                        @foreach($itemsToRender as $idx => $it)
                            @php
                                // support both old('items') array keys and model array keys
                                $med = $it['medicine_name'] ?? '';
                                $batch = $it['batch_no'] ?? '';
                                $expiry = $it['expiry'] ?? '';
                                $qty = $it['qty'] ?? 0;
                                $free = $it['free_qty'] ?? 0;
                                $rate = $it['purchase_rate'] ?? 0;
                                $disc = $it['discount_percent'] ?? 0;
                                $tax = $it['tax_percent'] ?? 0;
                            @endphp

                            <tr data-index="{{ $idx }}">
                                <td class="sl">{{ $idx + 1 }}</td>

                                <td>
                                    <select name="items[{{ $idx }}][medicine_name]"
                                            class="form-select medicine"
                                            onchange="calcRow(this)"
                                            required>
                                        <option value="">Select</option>
                                        @foreach($medicines as $m)
                                            <option value="{{ $m->medicine_name }}" {{ $med == $m->medicine_name ? 'selected' : '' }}>
                                                {{ $m->medicine_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="text" name="items[{{ $idx }}][batch_no]" class="form-control batch"
                                           value="{{ $batch }}" placeholder="Batch">
                                </td>

                                <td>
                                    <input type="date"
                                        name="items[{{ $idx }}][expiry]"
                                        class="form-control expiry"
                                        value="{{ $expiry }}"
                                        onchange="calcRow(this)">
                                </td>

                                <td>
                                    <input type="number" name="items[{{ $idx }}][qty]" class="form-control qty text-end"
                                           min="0" value="{{ $qty }}" oninput="calcRow(this)">
                                </td>

                                <td>
                                    <input type="number" name="items[{{ $idx }}][free_qty]" class="form-control free_qty text-end"
                                           min="0" value="{{ $free }}" oninput="calcRow(this)">
                                </td>

                                <td>
                                    <input type="number" name="items[{{ $idx }}][purchase_rate]" class="form-control rate text-end"
                                           min="0" step="0.01" value="{{ $rate }}" oninput="calcRow(this)">
                                </td>

                                <td>
                                    <input type="number" name="items[{{ $idx }}][discount_percent]" class="form-control disc text-end"
                                           min="0" max="100" step="0.01" value="{{ $disc }}" oninput="calcRow(this)">
                                </td>

                                <td>
                                    <input type="number" name="items[{{ $idx }}][tax_percent]" class="form-control tax text-end"
                                           min="0" max="100" step="0.01" value="{{ $tax }}" oninput="calcRow(this)">
                                </td>

                                <td class="text-end">
                                    <span class="amount fw-semibold">0.00</span>
                                </td>

                                <td class="text-center">
                                    <button type="button"
                                            class="btn btn-light btn-icon rounded-circle"
                                            title="Remove"
                                            onclick="removeRow(this)">
                                        <i class="feather-trash text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        {{-- TOTALS --}}
        <div class="card mb-3">
            <div class="card-header">
                <strong>Summary</strong>
            </div>

            <div class="card-body">
                <div class="row g-3 justify-content-end">

                    <div class="col-md-3">
                        <label class="form-label">Sub Total (₹)</label>
                        <input type="text" class="form-control text-end" id="subTotal" value="0.00" readonly>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Total Discount (₹)</label>
                        <input type="text" class="form-control text-end" id="totalDisc" value="0.00" readonly>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Total Tax (₹)</label>
                        <input type="text" class="form-control text-end" id="totalTax" value="0.00" readonly>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Grand Total (₹)</label>
                        <input type="text" class="form-control text-end fw-bold" id="grandTotal" value="0.00" readonly>
                    </div>

                </div>
            </div>
        </div>

        {{-- BUTTONS --}}
        <div class="d-flex justify-content-end gap-2 mb-4">
           <button type="submit" name="action" value="draft" class="btn btn-secondary">
    <i class="feather-save"></i> Update Draft
</button>

<button type="submit" name="action" value="submit" class="btn btn-success">
    <i class="feather-check"></i> Submit
</button>

            <a href="{{ route('admin.grn.index') }}" class="btn btn-light">
                Cancel
            </a>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
function format2(n){ n = Number(n || 0); return n.toFixed(2); }

function updateSL(){
    document.querySelectorAll('#itemsBody tr').forEach((tr, idx) => {
        tr.querySelector('.sl').textContent = (idx + 1);
        tr.dataset.index = idx;

        // update input names to match new index
        tr.querySelectorAll('input, select').forEach(el => {
            const name = el.getAttribute('name');
            if(!name) return;
            el.setAttribute('name', name.replace(/items\[\d+\]/, `items[${idx}]`));
        });
    });
}

function addRow(){
    const tbody = document.getElementById('itemsBody');
    const idx = tbody.querySelectorAll('tr').length;

    const tr = document.createElement('tr');
    tr.dataset.index = idx;
    const medicineOptions = ['<option value="">Select</option>']
    .concat((window.__MEDICINES__ || []).map(name =>
        `<option value="${name}">${name}</option>`
    )).join('');

    tr.innerHTML = `
    <td class="sl">${idx + 1}</td>

    <td>
        <select name="items[${idx}][medicine_name]" class="form-select medicine" onchange="calcRow(this)">
            ${medicineOptions}
        </select>
    </td>
    

        <td><input type="text" name="items[${idx}][batch_no]" class="form-control batch" placeholder="Batch"></td>
       <input type="date" name="items[${idx}][expiry]" class="form-control expiry" onchange="calcRow(this)">
        <td><input type="number" name="items[${idx}][qty]" class="form-control qty text-end" min="0" value="0" oninput="calcRow(this)"></td>
        <td><input type="number" name="items[${idx}][free_qty]" class="form-control free_qty text-end" min="0" value="0" oninput="calcRow(this)"></td>

        <td><input type="number" name="items[${idx}][purchase_rate]" class="form-control rate text-end" min="0" step="0.01" value="0" oninput="calcRow(this)"></td>
        <td><input type="number" name="items[${idx}][discount_percent]" class="form-control disc text-end" min="0" max="100" step="0.01" value="0" oninput="calcRow(this)"></td>
        <td><input type="number" name="items[${idx}][tax_percent]" class="form-control tax text-end" min="0" max="100" step="0.01" value="0" oninput="calcRow(this)"></td>

        <td class="text-end"><span class="amount fw-semibold">0.00</span></td>

        <td class="text-center">
            <button type="button" class="btn btn-light btn-icon rounded-circle" title="Remove" onclick="removeRow(this)">
                <i class="feather-trash text-danger"></i>
            </button>
        </td>
    `;

    tbody.appendChild(tr);
    calcRow(tr.querySelector('.qty'));
    updateSL();
}

function removeRow(btn){
    const tbody = document.getElementById('itemsBody');
    const rows = tbody.querySelectorAll('tr');
    if(rows.length === 1){
        alert("At least one item row is required.");
        return;
    }
    btn.closest('tr').remove();
    updateSL();
    calcTotals();
}

function calcRow(el){
    const tr = el.closest('tr');

    const qty  = Number(tr.querySelector('.qty')?.value || 0);
    const rate = Number(tr.querySelector('.rate')?.value || 0);
    const discP = Number(tr.querySelector('.disc')?.value || 0);
    const taxP  = Number(tr.querySelector('.tax')?.value || 0);

    const base = qty * rate;
    const disc = base * (discP / 100);
    const after = base - disc;
    const tax = after * (taxP / 100);
    const amount = after + tax;

    tr.querySelector('.amount').textContent = format2(amount);

    tr.dataset.base = base;
    tr.dataset.disc = disc;
    tr.dataset.tax  = tax;
    tr.dataset.amount = amount;

    calcTotals();
}

function calcTotals(){
    let subTotal = 0, totalDisc = 0, totalTax = 0, grandTotal = 0;

    document.querySelectorAll('#itemsBody tr').forEach(tr => {
        subTotal += Number(tr.dataset.base || 0);
        totalDisc += Number(tr.dataset.disc || 0);
        totalTax += Number(tr.dataset.tax || 0);
        grandTotal += Number(tr.dataset.amount || 0);
    });

    document.getElementById('subTotal').value = format2(subTotal);
    document.getElementById('totalDisc').value = format2(totalDisc);
    document.getElementById('totalTax').value = format2(totalTax);
    document.getElementById('grandTotal').value = format2(grandTotal);
}

document.addEventListener('DOMContentLoaded', () => {
    updateSL();

    document.querySelectorAll('#itemsBody tr').forEach(tr => {
        const qty = tr.querySelector('.qty');
        if (qty) {
            calcRow(qty);   // this sets base, disc, tax, amount
        }
    });

    calcTotals();
});
</script>

<script>
    window.__MEDICINES__ = @json($medicines->pluck('medicine_name'));
</script>
@endpush