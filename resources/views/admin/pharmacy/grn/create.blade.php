{{-- resources/views/admin/pharmacy/grn/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Create GRN')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Create Goods Receipt Note (GRN)</h4>
            <small class="text-muted">Pharmacy → GRN → Create</small>
        </div>

        <a href="{{ route('admin.grn.index') }}" class="btn btn-light">
            <i class="feather-arrow-left"></i> Back
        </a>
    </div>

    <form action="{{ route('admin.grn.store') }}" method="POST" id="grnForm">
        @csrf

        {{-- this decides Draft/Submitted --}}
        <input type="hidden" name="status" id="statusInput" value="Draft">

        {{-- GRN HEADER DETAILS --}}
        <div class="card mb-3">
            <div class="card-header">
                <strong>GRN Details</strong>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label">GRN No</label>
                        <input type="text" class="form-control" value="AUTO" readonly>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">GRN Date</label>
                        <input type="date" name="grn_date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Vendor <span class="text-danger">*</span></label>
                        <select name="vendor_name" class="form-select" required>
                            <option value="">Select Vendor</option>
                            <option value="ABC Pharma">ABC Pharma</option>
                            <option value="XYZ Suppliers">XYZ Suppliers</option>
                            <option value="City Pharma">City Pharma</option>
                            <option value="Medico Traders">Medico Traders</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Invoice No <span class="text-danger">*</span></label>
                        <input type="text" name="invoice_no" class="form-control" placeholder="Enter invoice no" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                        <input type="date" name="invoice_date" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Purchase Order (Optional)</label>
                        <input type="text" name="po_no" class="form-control" placeholder="PO No (if any)">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Remarks</label>
                        <input type="text" name="remarks" class="form-control" placeholder="Remarks (optional)">
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
                        {{-- Row 1 (default) --}}
                        <tr>
                            <td class="sl">1</td>

                            <td>
                                <select name="items[0][medicine_name]" class="form-select medicine" onchange="calcRow(this)">
                                    <option value="">Select</option>
                                    <option value="Paracetamol 500mg">Paracetamol 500mg</option>
                                    <option value="Amoxicillin 250mg">Amoxicillin 250mg</option>
                                    <option value="Cetirizine 10mg">Cetirizine 10mg</option>
                                    <option value="Pantoprazole 40mg">Pantoprazole 40mg</option>
                                </select>
                            </td>

                            <td>
                                <input type="text" name="items[0][batch_no]" class="form-control batch" placeholder="Batch">
                            </td>

                            <td>
                                <input type="month" name="items[0][expiry]" class="form-control expiry" onchange="calcRow(this)">
                            </td>

                            <td>
                                <input type="number" name="items[0][qty]" class="form-control qty text-end" min="0" value="0" oninput="calcRow(this)">
                            </td>

                            <td>
                                <input type="number" name="items[0][free_qty]" class="form-control free_qty text-end" min="0" value="0" oninput="calcRow(this)">
                            </td>

                            <td>
                                <input type="number" name="items[0][purchase_rate]" class="form-control rate text-end" min="0" step="0.01" value="0" oninput="calcRow(this)">
                            </td>

                            <td>
                                <input type="number" name="items[0][discount_percent]" class="form-control disc text-end" min="0" max="100" step="0.01" value="0" oninput="calcRow(this)">
                            </td>

                            <td>
                                <input type="number" name="items[0][tax_percent]" class="form-control tax text-end" min="0" max="100" step="0.01" value="0" oninput="calcRow(this)">
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
            <button type="button" class="btn btn-secondary" onclick="submitAs('Draft')">
                <i class="feather-save"></i> Save Draft
            </button>

            <button type="button" class="btn btn-success" onclick="submitAs('Submitted')">
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
function format2(n) {
    n = Number(n || 0);
    return n.toFixed(2);
}

function submitAs(status){
    document.getElementById('statusInput').value = status;
    document.getElementById('grnForm').submit();
}

function updateSL() {
    const rows = document.querySelectorAll('#itemsBody tr');
    rows.forEach((tr, idx) => {
        const sl = tr.querySelector('.sl');
        if (sl) sl.textContent = (idx + 1);
    });
}

// keep track of items index for name="items[x][...]"
let rowIndex = 1;

function addRow() {
    const tbody = document.getElementById('itemsBody');
    const tr = document.createElement('tr');

    tr.innerHTML = `
        <td class="sl">0</td>

        <td>
            <select name="items[${rowIndex}][medicine_name]" class="form-select medicine" onchange="calcRow(this)">
                <option value="">Select</option>
                <option value="Paracetamol 500mg">Paracetamol 500mg</option>
                <option value="Amoxicillin 250mg">Amoxicillin 250mg</option>
                <option value="Cetirizine 10mg">Cetirizine 10mg</option>
                <option value="Pantoprazole 40mg">Pantoprazole 40mg</option>
            </select>
        </td>

        <td>
            <input type="text" name="items[${rowIndex}][batch_no]" class="form-control batch" placeholder="Batch">
        </td>

        <td>
            <input type="month" name="items[${rowIndex}][expiry]" class="form-control expiry" onchange="calcRow(this)">
        </td>

        <td>
            <input type="number" name="items[${rowIndex}][qty]" class="form-control qty text-end" min="0" value="0" oninput="calcRow(this)">
        </td>

        <td>
            <input type="number" name="items[${rowIndex}][free_qty]" class="form-control free_qty text-end" min="0" value="0" oninput="calcRow(this)">
        </td>

        <td>
            <input type="number" name="items[${rowIndex}][purchase_rate]" class="form-control rate text-end" min="0" step="0.01" value="0" oninput="calcRow(this)">
        </td>

        <td>
            <input type="number" name="items[${rowIndex}][discount_percent]" class="form-control disc text-end" min="0" max="100" step="0.01" value="0" oninput="calcRow(this)">
        </td>

        <td>
            <input type="number" name="items[${rowIndex}][tax_percent]" class="form-control tax text-end" min="0" max="100" step="0.01" value="0" oninput="calcRow(this)">
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
    `;

    tbody.appendChild(tr);
    rowIndex++;
    updateSL();
    calcTotals();
}

function removeRow(btn) {
    const tbody = document.getElementById('itemsBody');
    const rows = tbody.querySelectorAll('tr');
    if (rows.length === 1) {
        alert("At least one item row is required.");
        return;
    }
    btn.closest('tr').remove();
    updateSL();
    calcTotals();
}

function calcRow(el) {
    const tr = el.closest('tr');

    const qty = Number(tr.querySelector('.qty')?.value || 0);
    const rate = Number(tr.querySelector('.rate')?.value || 0);
    const discP = Number(tr.querySelector('.disc')?.value || 0);
    const taxP  = Number(tr.querySelector('.tax')?.value || 0);

    const base = qty * rate;
    const disc = base * (discP / 100);
    const afterDisc = base - disc;
    const tax = afterDisc * (taxP / 100);
    const amount = afterDisc + tax;

    tr.querySelector('.amount').textContent = format2(amount);

    tr.dataset.base = base;
    tr.dataset.disc = disc;
    tr.dataset.tax  = tax;
    tr.dataset.amount = amount;

    calcTotals();
}

function calcTotals() {
    const rows = document.querySelectorAll('#itemsBody tr');

    let subTotal = 0;
    let totalDisc = 0;
    let totalTax = 0;
    let grandTotal = 0;

    rows.forEach(tr => {
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
    calcTotals();
});
</script>
@endpush