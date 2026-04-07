<?php

namespace App\Http\Controllers\Admin\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Grn;
use App\Models\GrnItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StockMovement;
use App\Models\Vendor;
use App\Models\Medicine;
use App\Models\MedicineBatch;
use Illuminate\Support\Str;
class PharmacyGrnController extends Controller
{
    public function index(Request $request)
    {
        $query = Grn::query();

        if ($request->filled('from_date')) {
            $query->whereDate('grn_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('grn_date', '<=', $request->to_date);
        }

        if ($request->filled('vendor')) {
            $query->where('vendor_name', $request->vendor);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $grns = $query->latest()->paginate(10);

        // ✅ vendor list from DB
        $vendors = Grn::query()
            ->whereNotNull('vendor_name')
            ->where('vendor_name', '!=', '')
            ->distinct()
            ->orderBy('vendor_name')
            ->pluck('vendor_name');

        return view('admin.pharmacy.grn.index', compact('grns', 'vendors'));
    }

public function create()
{
    $vendors = Vendor::query()
        ->where('status', 'Active')
        ->whereNull('deleted_at')
        ->orderBy('vendor_name')
        ->get(['id', 'vendor_name']);

    $medicines = Medicine::query()
        ->where('status', 1)
        ->orderBy('medicine_name')
        ->get(['id', 'medicine_name']);

    return view('admin.pharmacy.grn.create', compact('vendors', 'medicines'));
}

    public function store(Request $request)
    {
        $request->validate([
           // 'vendor_id'    => 'required|exists:vendors,id',
            'grn_date'     => 'required|date',
            'invoice_no'   => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'po_no'        => 'nullable|string|max:255',
            'remarks'      => 'nullable|string|max:500',
            'status'       => 'nullable|in:Draft,Submitted,Verified,Rejected',

            'items'                 => 'required|array|min:1',
            'items.*.medicine_name' => 'required|string|max:255',
            'items.*.qty'           => 'required|integer|min:1',
            'items.*.purchase_rate' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0',
            'items.*.tax_percent'      => 'nullable|numeric|min:0',
            'items.*.batch_no'         => 'nullable|string|max:255',
            'items.*.expiry'           => 'nullable|date',
            'items.*.free_qty'         => 'nullable|integer|min:0',
        ]);

        return DB::transaction(function () use ($request) {

            $nextId = (Grn::withTrashed()->max('id') ?? 0) + 1;
            $grnNo  = 'GRN-' . str_pad((string)$nextId, 4, '0', STR_PAD_LEFT);

            // ✅ get vendor from vendor_id dropdown
            $vendor = Vendor::findOrFail($request->vendor_id);

            $grn = Grn::create([
                'grn_no'       => $grnNo,
                'grn_date'     => $request->grn_date,

                // ✅ THIS is where vendor_id is saved
               // 'vendor_id'    => $vendor->id,
                'vendor_name'  => $vendor->vendor_name,

                'invoice_no'   => $request->invoice_no,
                'invoice_date' => $request->invoice_date,
                'po_no'        => $request->po_no,
                'remarks'      => $request->remarks,
                'status'       => $request->status ?? 'Draft',

                'sub_total'       => 0,
                'total_discount'  => 0,
                'total_tax'       => 0,
                'grand_total'     => 0,
            ]);

            $sub = 0; $discT = 0; $taxT = 0; $grand = 0;

            foreach ($request->items as $it) {
                $qty   = (int)($it['qty'] ?? 0);
                $rate  = (float)($it['purchase_rate'] ?? 0);
                $discP = (float)($it['discount_percent'] ?? 0);
                $taxP  = (float)($it['tax_percent'] ?? 0);

                $base   = $qty * $rate;
                $disc   = $base * ($discP / 100);
                $after  = $base - $disc;
                $tax    = $after * ($taxP / 100);
                $amount = $after + $tax;

                GrnItem::create([
                    'grn_id'           => $grn->id,
                    'medicine_name'    => $it['medicine_name'],
                    'batch_no'         => $it['batch_no'] ?? null,
                    'expiry'           => $it['expiry'] ?? null,
                    'qty'              => $qty,
                    'free_qty'         => (int)($it['free_qty'] ?? 0),
                    'purchase_rate'    => $rate,
                    'discount_percent' => $discP,
                    'tax_percent'      => $taxP,
                    'amount'           => $amount,
                ]);

                $sub   += $base;
                $discT += $disc;
                $taxT  += $tax;
                $grand += $amount;
            }

            $grn->update([
                'sub_total'      => $sub,
                'total_discount' => $discT,
                'total_tax'      => $taxT,
                'grand_total'    => $grand,
            ]);

            return redirect()->route('admin.grn.index')->with('success', 'GRN created successfully.');
        });
    }

    public function show($id)
    {
        $grn = Grn::with('items')->findOrFail($id);
        return view('admin.pharmacy.grn.show', compact('grn'));
    }

    

    public function print($id)
    {
        $grn = Grn::with('items')->findOrFail($id);

        $pdf = Pdf::loadView('admin.pharmacy.grn.print', compact('grn'))
                    ->setPaper('A4', 'portrait');

        return $pdf->download($grn->grn_no . '.pdf');
    }
public function edit($id)
{
    $grn = Grn::with('items')->findOrFail($id);

    if ($grn->status !== 'Draft') {
        return redirect()->route('admin.grn.show', $grn->id)
            ->withErrors('Only Draft GRN can be edited.');
    }

    $vendors = Vendor::query()
        ->where('status', 'Active')
        ->whereNull('deleted_at')
        ->orderBy('vendor_name')
        ->get(['id', 'vendor_name']);

    $medicines = Medicine::query()
        ->where('status', 1)
        ->orderBy('medicine_name')
        ->get(['id', 'medicine_name']);

    return view('admin.pharmacy.grn.edit', compact('grn', 'vendors', 'medicines'));
}




public function update(Request $request, $id)
{
    $grn = \App\Models\Grn::with('items')->findOrFail($id);

    if ($grn->status !== 'Draft') {
        return redirect()->route('admin.grn.show', $grn->id)
            ->withErrors('Only Draft GRN can be updated.');
    }

    $request->validate([
        'grn_date'     => 'required|date',
      //  'vendor_id'    => 'required|exists:vendors,id',
        'invoice_no'   => 'required|string|max:255',
        'invoice_date' => 'required|date',
        'po_no'        => 'nullable|string|max:255',
        'remarks'      => 'nullable|string|max:500',

        'action'       => 'required|in:draft,submit',

        'items'                 => 'required|array|min:1',
        'items.*.medicine_name' => 'required|string|max:255',
        'items.*.qty'           => 'required|numeric|min:1',
        'items.*.purchase_rate' => 'required|numeric|min:0',
        'items.*.discount_percent' => 'nullable|numeric|min:0',
        'items.*.tax_percent'      => 'nullable|numeric|min:0',
        'items.*.batch_no'         => 'nullable|string|max:255',
        'items.*.expiry'           => 'nullable|date',   // IMPORTANT: expiry is date now
        'items.*.free_qty'         => 'nullable|integer|min:0',
    ]);

    $vendor = Vendor::findOrFail($request->vendor_id);

    DB::beginTransaction();
    try {

        // ✅ Update header
        $grn->update([
            'grn_date'     => $request->grn_date,
         //   'vendor_id'    => $vendor->id,
            'vendor_name'  => $vendor->vendor_name,
            'invoice_no'   => $request->invoice_no,
            'invoice_date' => $request->invoice_date,
            'po_no'        => $request->po_no,
            'remarks'      => $request->remarks,
            'status' => $request->action === 'submit' ? 'Submitted' : 'Draft',
        ]);

        // ✅ Delete old items and insert again
        $grn->items()->delete();

        // ✅ Calculate totals properly
        $sub = 0; $discT = 0; $taxT = 0; $grandTotal = 0;

        foreach ($request->items as $item) {

            $qty   = (float)($item['qty'] ?? 0);
            $rate  = (float)($item['purchase_rate'] ?? 0);
            $discP = (float)($item['discount_percent'] ?? 0);
            $taxP  = (float)($item['tax_percent'] ?? 0);

            $base  = $qty * $rate;
            $disc  = $base * ($discP / 100);
            $after = $base - $disc;
            $tax   = $after * ($taxP / 100);
            $amt   = $after + $tax;

            $sub       += $base;
            $discT     += $disc;
            $taxT      += $tax;
            $grandTotal += $amt;

            $grn->items()->create([
                'medicine_name'    => $item['medicine_name'],
                'batch_no'         => $item['batch_no'] ?? null,
                'expiry'           => $item['expiry'] ?? null, // date
                'qty'              => $qty,
                'free_qty'         => (int)($item['free_qty'] ?? 0),
                'purchase_rate'    => $rate,
                'discount_percent' => $discP,
                'tax_percent'      => $taxP,
                'amount'           => $amt,
            ]);
        }

        // ✅ Save all totals in GRN table
        $grn->update([
            'sub_total'      => $sub,
            'total_discount' => $discT,
            'total_tax'      => $taxT,
            'grand_total'    => $grandTotal,
        ]);

        DB::commit();

        return redirect()->route('admin.grn.show', $grn->id)
            ->with('success', 'GRN updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors($e->getMessage())->withInput();
    }
}
public function trash()
{
    $grns = Grn::onlyTrashed()->latest()->paginate(10);
    return view('admin.pharmacy.grn.trash', compact('grns'));
}

public function restore($id)
{
    $grn = Grn::onlyTrashed()->findOrFail($id);
    $grn->restore();

    return redirect()->route('admin.grn.trash')->with('success', 'GRN restored successfully.');
}

public function forceDelete($id)
{
    $grn = Grn::onlyTrashed()->findOrFail($id);

    // delete child items first (important)
    $grn->items()->delete();

    $grn->forceDelete();

    return redirect()->route('admin.grn.trash')->with('success', 'GRN permanently deleted.');
}
    
public function destroy($id)
{
    $grn = Grn::findOrFail($id);
    $grn->delete();

    return redirect()->route('admin.grn.index')->with('success', 'GRN moved to trash.');
}

public function verify($id)
{
    $grn = Grn::with('items')->findOrFail($id);

    // only allow verify/reject if Submitted
    if ($grn->status !== 'Submitted') {
        return redirect()->route('admin.grn.show', $grn->id)
            ->withErrors('Only Submitted GRN can be verified/rejected.');
    }

    // PO details: if you only have PO no (string), pass it as simple detail
    // If you have a PurchaseOrder model later, we can load that too.
    $po = [
        'po_no' => $grn->po_no,
        'note'  => $grn->po_no ? 'PO details integration pending (showing PO No only).' : 'No PO linked.',
    ];

    return view('admin.pharmacy.grn.verify', compact('grn', 'po'));
}

public function verifyStore(Request $request, $id)
{
    $grn = Grn::with('items')->findOrFail($id);

    if ($grn->status !== 'Submitted') {
        return redirect()->route('admin.grn.show', $grn->id)
            ->withErrors('Only Submitted GRN can be verified.');
    }

    // ✅ Added invoice_file validation
    $request->validate([
        'invoice_file'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'verify_remarks' => 'nullable|string|max:255',
    ]);

    DB::beginTransaction();

    try {

        // ✅ store invoice file if uploaded (before update)
        $invoicePath = null;
        if ($request->hasFile('invoice_file')) {
            $invoicePath = $request->file('invoice_file')
                ->store('grn_invoices', 'public'); // storage/app/public/grn_invoices/...
        }

        foreach ($grn->items as $item) {

            // 1️⃣ Find medicine
            $medicine = Medicine::where('medicine_name', $item->medicine_name)->first();

            if (!$medicine) {
                throw new \Exception("Medicine not found: " . $item->medicine_name);
            }

            $totalQty = (int)$item->qty + (int)$item->free_qty;

            // 2️⃣ Find batch
            $batch = MedicineBatch::where('medicine_id', $medicine->id)
                ->where('batch_number', $item->batch_no)
                ->where('expiry_date', $item->expiry)
                ->first();

            if ($batch) {
                $batch->quantity += $totalQty;
                $batch->save();
            } else {
                $batch = MedicineBatch::create([
                    'medicine_id'    => $medicine->id,
                    'batch_number'   => $item->batch_no,
                    'expiry_date'    => $item->expiry,
                    'purchase_price' => $item->purchase_rate,
                    'mrp'            => $item->purchase_rate,
                    'quantity'       => $totalQty,
                    'reorder_level'  => 0,
                ]);
            }

            // 3️⃣ Insert stock movement
            StockMovement::create([
                'id'            => (string) Str::uuid(),
                'medicine_id'   => $medicine->id,
                'batch_id'      => $batch->id,
                'movement_type' => 'IN',
                'quantity'      => $totalQty,
                'reference_id'  => (string) $grn->id,
            ]);
        }

        // 4️⃣ Update GRN status + remarks + invoice file
        $updateData = [
            'status'         => 'Verified',
            'verify_remarks' => $request->verify_remarks ?? null,
        ];

        if ($invoicePath) {
            $updateData['invoice_file'] = $invoicePath;
        }

        $grn->update($updateData);

        DB::commit();

        return redirect()->route('admin.grn.show', $grn->id)
            ->with('success', 'GRN verified and stock updated successfully.');

    } catch (\Exception $e) {

        DB::rollBack();
        return back()->withErrors($e->getMessage());
    }
}

public function rejectStore(Request $request, $id)
{
    $grn = Grn::findOrFail($id);

    if ($grn->status !== 'Submitted') {
        return redirect()->route('admin.grn.show', $grn->id)
            ->withErrors('Only Submitted GRN can be rejected.');
    }

    // Reject remarks should be required
    $request->validate([
        'reject_reason' => 'required|string|max:255',
    ]);

    $grn->update([
        'status' => 'Rejected',
        // store reason only if column exists; otherwise remove this line
        'reject_reason' => $request->reject_reason,
    ]);

    return redirect()->route('admin.grn.show', $grn->id)
        ->with('success', 'GRN rejected successfully.');
}

public function verifySubmit(Request $request, $id)
{
    $request->validate([
        'action' => 'required|in:approve,reject',
        'verify_remarks' => 'nullable|string|max:500',
    ]);

    $grn = Grn::findOrFail($id);

    if ($request->action === 'approve') {
        $grn->status = 'Verified';
    } else {
        $grn->status = 'Cancelled';
    }

    $grn->remarks = $request->verify_remarks ?: $grn->remarks;
    $grn->save();

    return redirect()->route('admin.grn.show', $grn->id)->with('success', 'Verification updated.');
}



// ============================
// API METHODS (JSON responses)
// ============================

public function apiIndex(Request $request)
{
    $query = Grn::query();

    if ($request->filled('from_date')) {
        $query->whereDate('grn_date', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $query->whereDate('grn_date', '<=', $request->to_date);
    }
    if ($request->filled('vendor')) {
        $query->where('vendor_name', $request->vendor);
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $grns = $query->latest()->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'GRN list fetched',
        'data' => $grns
    ]);
}

public function apiShow($id)
{
    $grn = Grn::with('items')->findOrFail($id);

    return response()->json([
        'success' => true,
        'message' => 'GRN fetched',
        'data' => $grn
    ]);
}

public function apiStore(Request $request)
{
    $request->validate([
        'grn_date' => 'required|date',
      //  'vendor_id' => 'required|exists:vendors,id',
        'invoice_no' => 'required|string|max:255',
        'invoice_date' => 'required|date',
        'po_no' => 'nullable|string|max:255',
        'remarks' => 'nullable|string|max:500',
        'status' => 'nullable|in:Draft,Submitted,Verified,Rejected',
        'items' => 'required|array|min:1',
        'items.*.medicine_name' => 'required|string|max:255',
        'items.*.qty' => 'required|integer|min:1',
        'items.*.purchase_rate' => 'required|numeric|min:0',
        'items.*.discount_percent' => 'nullable|numeric|min:0',
        'items.*.tax_percent' => 'nullable|numeric|min:0',
        'items.*.batch_no' => 'nullable|string|max:255',
        'items.*.expiry' => 'nullable|date',
        'items.*.free_qty' => 'nullable|integer|min:0',
    ]);

    $grn = DB::transaction(function () use ($request) {

        $nextId = (Grn::withTrashed()->max('id') ?? 0) + 1;
        $grnNo = 'GRN-' . str_pad((string)$nextId, 4, '0', STR_PAD_LEFT);

        $vendor = \App\Models\Vendor::findOrFail($request->vendor_id);

        $grn = Grn::create([
            'grn_no' => $grnNo,
            'grn_date' => $request->grn_date,
            'vendor_name' => $vendor->vendor_name,
         //   'vendor_id' => $vendor->id,
            'invoice_no' => $request->invoice_no,
            'invoice_date' => $request->invoice_date,
            'po_no' => $request->po_no,
            'remarks' => $request->remarks,
            'status' => $request->status ?? 'Draft',
            'sub_total' => 0,
            'total_discount' => 0,
            'total_tax' => 0,
            'grand_total' => 0,
        ]);

        $sub = 0; $discT = 0; $taxT = 0; $grand = 0;

        foreach ($request->items as $it) {
            $qty = (int)$it['qty'];
            $rate = (float)$it['purchase_rate'];
            $discP = (float)($it['discount_percent'] ?? 0);
            $taxP  = (float)($it['tax_percent'] ?? 0);

            $base = $qty * $rate;
            $disc = $base * ($discP / 100);
            $after = $base - $disc;
            $tax = $after * ($taxP / 100);
            $amount = $after + $tax;

            GrnItem::create([
                'grn_id' => $grn->id,
                'medicine_name' => $it['medicine_name'],
                'batch_no' => $it['batch_no'] ?? null,
                'expiry' => $it['expiry'] ?? null,
                'qty' => $qty,
                'free_qty' => (int)($it['free_qty'] ?? 0),
                'purchase_rate' => $rate,
                'discount_percent' => $discP,
                'tax_percent' => $taxP,
                'amount' => $amount,
            ]);

            $sub += $base;
            $discT += $disc;
            $taxT += $tax;
            $grand += $amount;
        }

        $grn->update([
            'sub_total' => $sub,
            'total_discount' => $discT,
            'total_tax' => $taxT,
            'grand_total' => $grand,
        ]);

        return $grn->load('items');
    });

    return response()->json([
        'success' => true,
        'message' => 'GRN created successfully',
        'data' => $grn
    ], 201);
}

public function apiUpdate(Request $request, $id)
{
    $grn = Grn::with('items')->findOrFail($id);

    if ($grn->status !== 'Draft') {
        return response()->json([
            'success' => false,
            'message' => 'Only Draft GRN can be updated'
        ], 422);
    }

    $request->validate([
        'grn_date' => 'required|date',
     //   'vendor_id' => 'required|exists:vendors,id',
        'invoice_no' => 'required|string|max:255',
        'invoice_date' => 'required|date',
        'po_no' => 'nullable|string|max:255',
        'remarks' => 'nullable|string|max:500',
        'items' => 'required|array|min:1',
        'items.*.medicine_name' => 'required|string|max:255',
        'items.*.qty' => 'required|integer|min:1',
        'items.*.purchase_rate' => 'required|numeric|min:0',
        'items.*.discount_percent' => 'nullable|numeric|min:0',
        'items.*.tax_percent' => 'nullable|numeric|min:0',
        'items.*.batch_no' => 'nullable|string|max:255',
        'items.*.expiry' => 'nullable|date',
        'items.*.free_qty' => 'nullable|integer|min:0',
    ]);

    $updated = DB::transaction(function () use ($request, $grn) {

        $vendor = \App\Models\Vendor::findOrFail($request->vendor_id);

        $grn->update([
            'grn_date' => $request->grn_date,
            'vendor_name' => $vendor->vendor_name,
            'invoice_no' => $request->invoice_no,
            'invoice_date' => $request->invoice_date,
            'po_no' => $request->po_no,
            'remarks' => $request->remarks,
        ]);

        $grn->items()->delete();

        $sub = 0; $discT = 0; $taxT = 0; $grand = 0;

        foreach ($request->items as $it) {
            $qty = (int)$it['qty'];
            $rate = (float)$it['purchase_rate'];
            $discP = (float)($it['discount_percent'] ?? 0);
            $taxP  = (float)($it['tax_percent'] ?? 0);

            $base = $qty * $rate;
            $disc = $base * ($discP / 100);
            $after = $base - $disc;
            $tax = $after * ($taxP / 100);
            $amount = $after + $tax;

            $grn->items()->create([
                'medicine_name' => $it['medicine_name'],
                'batch_no' => $it['batch_no'] ?? null,
                'expiry' => $it['expiry'] ?? null,
                'qty' => $qty,
                'free_qty' => (int)($it['free_qty'] ?? 0),
                'purchase_rate' => $rate,
                'discount_percent' => $discP,
                'tax_percent' => $taxP,
                'amount' => $amount,
            ]);

            $sub += $base;
            $discT += $disc;
            $taxT += $tax;
            $grand += $amount;
        }

        $grn->update([
            'sub_total' => $sub,
            'total_discount' => $discT,
            'total_tax' => $taxT,
            'grand_total' => $grand,
        ]);

        return $grn->load('items');
    });

    return response()->json([
        'success' => true,
        'message' => 'GRN updated successfully',
        'data' => $updated
    ]);
}

public function apiDestroy($id)
{
    $grn = Grn::findOrFail($id);
    $grn->delete();

    return response()->json([
        'success' => true,
        'message' => 'GRN moved to trash'
    ]);
}

public function apiTrash()
{
    $grns = Grn::onlyTrashed()->latest()->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Trash list fetched',
        'data' => $grns
    ]);
}

public function apiRestore($id)
{
    $grn = Grn::onlyTrashed()->findOrFail($id);
    $grn->restore();

    return response()->json([
        'success' => true,
        'message' => 'GRN restored'
    ]);
}

public function apiForceDelete($id)
{
    $grn = Grn::onlyTrashed()->findOrFail($id);
    $grn->items()->delete();
    $grn->forceDelete();

    return response()->json([
        'success' => true,
        'message' => 'GRN permanently deleted'
    ]);
}

public function apiVerify(Request $request, $id)
{
    $grn = Grn::findOrFail($id);

    if ($grn->status !== 'Submitted') {
        return response()->json([
            'success' => false,
            'message' => 'Only Submitted GRN can be verified'
        ], 422);
    }

    $request->validate([
        'verify_remarks' => 'nullable|string|max:255',
    ]);

    $grn->update([
        'status' => 'Verified',
        'verify_remarks' => $request->verify_remarks ?? null,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'GRN verified',
        'data' => $grn
    ]);
}

public function apiReject(Request $request, $id)
{
    $grn = Grn::findOrFail($id);

    if ($grn->status !== 'Submitted') {
        return response()->json([
            'success' => false,
            'message' => 'Only Submitted GRN can be rejected'
        ], 422);
    }

    $request->validate([
        'reject_reason' => 'required|string|max:255',
    ]);

    $grn->update([
        'status' => 'Rejected',
        'reject_reason' => $request->reject_reason,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'GRN rejected',
        'data' => $grn
    ]);
}
}