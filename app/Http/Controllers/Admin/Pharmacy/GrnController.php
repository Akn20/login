<?php

namespace App\Http\Controllers\Admin\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Grn;
use App\Models\GrnItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class GrnController extends Controller
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
        return view('admin.pharmacy.grn.create');
    }

    public function store(Request $request)
    {
        // UI form -> later you can change field names; for now we validate basic
        $request->validate([
            'grn_date' => 'required|date',
            'vendor_name' => 'required|string|max:255',
            'invoice_no' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.medicine_name' => 'required|string|max:255',
            'items.*.qty' => 'required|integer|min:0',
            'items.*.purchase_rate' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request) {

            // Generate GRN number
            $nextId = (Grn::withTrashed()->max('id') ?? 0) + 1;
            $grnNo = 'GRN-' . str_pad((string)$nextId, 4, '0', STR_PAD_LEFT);

            $grn = Grn::create([
                'grn_no' => $grnNo,
                'grn_date' => $request->grn_date,
                'vendor_name' => $request->vendor_name,
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
                $qty = (int)($it['qty'] ?? 0);
                $rate = (float)($it['purchase_rate'] ?? 0);
                $discP = (float)($it['discount_percent'] ?? 0);
                $taxP  = (float)($it['tax_percent'] ?? 0);

                $base = $qty * $rate;
                $disc = $base * ($discP / 100);
                $after = $base - $disc;
                $tax = $after * ($taxP / 100);
                $amount = $after + $tax;

                GrnItem::create([
                    'grn_id' => $grn->id,
                    'medicine_name' => $it['medicine_name'] ?? '',
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
    $grn = \App\Models\Grn::with('items')->findOrFail($id);

    // only Draft can be edited (optional rule)
    if ($grn->status !== 'Draft') {
        return redirect()->route('admin.grn.show', $grn->id)
            ->with('success', 'Only Draft GRN can be edited.');
    }

    return view('admin.pharmacy.grn.edit', compact('grn'));
}



public function update(Request $request, $id)
{
    $grn = \App\Models\Grn::with('items')->findOrFail($id);

    if ($grn->status !== 'Draft') {
        return redirect()->route('admin.grn.show', $grn->id)
            ->withErrors('Only Draft GRN can be updated.');
    }

    $request->validate([
        'grn_date' => 'required|date',
        'vendor_name' => 'required|string',
        'invoice_no' => 'required|string',
        'invoice_date' => 'required|date',
        'po_no' => 'nullable|string',
        'remarks' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.medicine_name' => 'required|string',
        'items.*.qty' => 'required|numeric|min:1',
        'items.*.purchase_rate' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();
    try {

        // Update header
        $grn->update([
            'grn_date' => $request->grn_date,
            'vendor_name' => $request->vendor_name,
            'invoice_no' => $request->invoice_no,
            'invoice_date' => $request->invoice_date,
            'po_no' => $request->po_no,
            'remarks' => $request->remarks,
        ]);

        // Delete old items and insert again (simple + safe)
        $grn->items()->delete();

        $grandTotal = 0;

        foreach ($request->items as $item) {

            $qty = (float)$item['qty'];
            $rate = (float)$item['purchase_rate'];
            $discP = (float)($item['discount_percent'] ?? 0);
            $taxP  = (float)($item['tax_percent'] ?? 0);

            $base = $qty * $rate;
            $disc = $base * ($discP/100);
            $after = $base - $disc;
            $tax = $after * ($taxP/100);
            $amt = $after + $tax;

            $grandTotal += $amt;

            $grn->items()->create([
                'medicine_name' => $item['medicine_name'],
                'batch_no' => $item['batch_no'] ?? null,
                'expiry' => $item['expiry'] ?? null,
                'qty' => $qty,
                'free_qty' => $item['free_qty'] ?? 0,
                'purchase_rate' => $rate,
                'discount_percent' => $discP,
                'tax_percent' => $taxP,
                'amount' => $amt,
            ]);
        }

        $grn->update(['grand_total' => $grandTotal]);

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
    $grn = Grn::findOrFail($id);

    if ($grn->status !== 'Submitted') {
        return redirect()->route('admin.grn.show', $grn->id)
            ->withErrors('Only Submitted GRN can be verified.');
    }

    $request->validate([
        'verify_remarks' => 'nullable|string|max:255',
    ]);

    $grn->update([
        'status' => 'Verified',
        // store remark only if column exists; otherwise remove this line
        'verify_remarks' => $request->verify_remarks ?? null,
    ]);

    return redirect()->route('admin.grn.show', $grn->id)
        ->with('success', 'GRN verified successfully.');
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
}