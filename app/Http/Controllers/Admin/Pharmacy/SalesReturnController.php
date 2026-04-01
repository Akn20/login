<?php

namespace App\Http\Controllers\Admin\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SalesReturn;
use App\Models\SalesReturnItem;
use App\Models\MedicineBatch;
use App\Models\SalesBill;
use App\Models\SalesBillItem;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SalesReturnController extends Controller
{
public function index(Request $request)
{
    $query = SalesReturn::query();

    if ($request->from) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->q) {
        $query->where(function ($q) use ($request) {
            $q->where('return_number', 'like', "%{$request->q}%");
        });
    }
   $returns = $query->with(['bill','patient'])->latest()->paginate(10);

    return view('admin.pharmacy.salesReturn.index', compact('returns'));
}
public function create(Request $request)
{
    $bill = null;
    $billItems = [];

    // Search bill by bill number
    if ($request->bill_no) {

        $bill = SalesBill::where('bill_number', $request->bill_no)
            ->with(['items.medicine','items.batch'])
            ->first();
        
        if ($bill) {
            $billItems = $bill->items;
        }else{
            return back()->with('error','Bill not found');
        }
    }

    return view('admin.pharmacy.salesReturn.create', compact('bill','billItems'));
}
public function store(Request $request)
{
    DB::beginTransaction();

    try {

        $returnNumber = 'SR-' . time();

        $salesReturn = SalesReturn::create([
            'id' => Str::uuid(),
            'return_number' => $returnNumber,
            'bill_id' => $request->bill_id,
            'patient_id' => $request->patient_id,
            'total_refund' => 0,
            'status' => 'Draft',
            'created_by' => auth()->id() ?? 1
        ]);

        $totalRefund = 0;

        foreach ($request->items as $item) {

            // Skip if return qty empty or zero
            if (!isset($item['return_qty']) || $item['return_qty'] <= 0) {
                continue;
            }

            // Fetch original sold item
            $billItem = SalesBillItem::where('sales_bill_id', $request->bill_id)
                        ->where('medicine_id', $item['medicine_id'])
                        ->where('batch_id', $item['batch_id'])
                        ->first();

            if (!$billItem) {
                throw new \Exception("Invalid bill item selected.");
            }

            // Validate return quantity
            if ($item['return_qty'] > $billItem->quantity) {
                throw new \Exception(
                    "Return quantity cannot exceed sold quantity for medicine ID: ".$item['medicine_id']
                );
            }

            // Calculate refund
            $refund = $item['return_qty'] * $item['unit_price'];

            SalesReturnItem::create([
                'id' => Str::uuid(),
                'sales_return_id' => $salesReturn->id,
                'medicine_id' => $item['medicine_id'],
                'batch_id' => $item['batch_id'],
                'quantity' => $item['return_qty'],
                'refund_amount' => $refund
            ]);

            // Update stock

            $totalRefund += $refund;
        }

        // Update total refund
        $salesReturn->update([
            'total_refund' => $totalRefund
        ]);

        DB::commit();

        return redirect()
            ->route('admin.salesReturn.index')
            ->with('success','Sales return created successfully');

    } catch (\Exception $e) {

        DB::rollback();

        return back()->with('error', $e->getMessage());
    }
}
public function update(Request $request, $id)
{
    DB::beginTransaction();

    try {
         
        $salesReturn = SalesReturn::with('items')->findOrFail($id);

        $totalRefund = 0;

       foreach ($request->items as $itemData) {

    $item = SalesReturnItem::find($itemData['id']);

    if (!$item) continue;

    $qty = $itemData['return_qty'] ?? 0;
    $unitPrice = $itemData['unit_price'] ?? 0;

    // Get original sold quantity
    $billItem = SalesBillItem::where('sales_bill_id', $salesReturn->bill_id)
        ->where('medicine_id', $item->medicine_id)
        ->where('batch_id', $item->batch_id)
        ->first();

    if (!$billItem) {
        throw new \Exception("Invalid bill item.");
    }

   if ($qty > $billItem->quantity) {
    throw new \Exception("Return qty exceeds sold qty");
}

    $refund = $qty * $unitPrice;

    $item->update([
        'quantity' => $qty,
        'refund_amount' => $refund,
        'reason' => $itemData['reason'] ?? null
    ]);

    $totalRefund += $refund;
}
        
        // Update sales return
        $salesReturn->update([
            'total_refund' => $totalRefund,
            'refund_mode' => $request->refund_mode,
            'refund_reference' => $request->refund_reference,
            'remarks' => $request->remarks,
            'status' => $request->status
        ]);

        DB::commit();

        return redirect()
            ->route('admin.salesReturn.index')
            ->with('success','Sales Return Updated Successfully');

    } catch (\Exception $e) {

    DB::rollback();

    dd($e->getMessage()); // 👈 ADD THIS

    return back()->with('error',$e->getMessage());
}
}
public function edit(SalesReturn $salesReturn)
{
    $salesReturn->load([
        'items.medicine',
        'items.batch',
        'bill',
         'patient'
    ]);

    return view('admin.pharmacy.salesReturn.edit', compact('salesReturn'));
}

public function show(SalesReturn $salesReturn)
{
    $salesReturn->load([
        'items.medicine',
        'items.batch',
        'bill',
        'patient',
        'creator'
    ]);

    return view('admin.pharmacy.salesReturn.show', compact('salesReturn'));
}
public function approve($id)
{
    DB::beginTransaction();

    try {

        $salesReturn = SalesReturn::with('items')->findOrFail($id);

        if ($salesReturn->status == 'Approved') {
            return back()->with('error', 'Return already approved');
        }

        foreach ($salesReturn->items as $item) {

            $batch = MedicineBatch::find($item->batch_id);

            if ($batch) {

                // Increase stock when return approved
                $batch->quantity += $item->quantity;

                $batch->save();
            }
        }

        $salesReturn->update([
            'status' => 'Approved'
        ]);

        DB::commit();

        return redirect()
            ->route('admin.salesReturn.index')
            ->with('success','Sales Return Approved Successfully');

    } catch (\Exception $e) {

        DB::rollback();

        return back()->with('error',$e->getMessage());
    }
}
public function reject(Request $request, $id)
{
    try {

        $salesReturn = SalesReturn::findOrFail($id);

        $salesReturn->update([
            'status' => 'Rejected',
            'remarks' => $request->reason ?? 'Rejected by admin'
        ]);

        return redirect()
            ->route('admin.salesReturn.index')
            ->with('success','Sales Return Rejected');

    } catch (\Exception $e) {

        return back()->with('error',$e->getMessage());
    }
}
public function print($id)
{
    $salesReturn = SalesReturn::with([
        'items.medicine',
        'items.batch',
        'bill',
        'creator'
    ])->findOrFail($id);

    return view('admin.pharmacy.salesReturn.print', compact('salesReturn'));
}

/// ================================
// SALES RETURN API METHODS
// ================================
public function apiIndex(Request $request)
{
    $query = SalesReturn::with(['bill', 'creator'])->latest();

    if ($request->from) $query->whereDate('created_at', '>=', $request->from);
    if ($request->to) $query->whereDate('created_at', '<=', $request->to);
    if ($request->status) $query->where('status', $request->status);

    if ($request->q) {
        $query->where('return_number', 'like', "%{$request->q}%");
    }

    $returns = $query->paginate($request->get('per_page', 10));

    return response()->json([
        'success' => true,
        'message' => 'Sales returns list',
        'data' => $returns
    ]);
}

public function apiShow($id)
{
    $salesReturn = SalesReturn::with([
        'items.medicine',
        'items.batch',
        'bill',
        'creator'
    ])->find($id);

    if (!$salesReturn) {
        return response()->json([
            'success' => false,
            'message' => 'Sales return not found',
            'data' => null
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Sales return details',
        'data' => $salesReturn
    ]);
}

public function apiBillSearch(Request $request)
{
    $request->validate([
        'bill_no' => 'required|string'
    ]);

    $bill = SalesBill::where('bill_number', $request->bill_no)
        ->with(['items.medicine', 'items.batch'])
        ->first();

    if (!$bill) {
        return response()->json([
            'success' => false,
            'message' => 'Bill not found',
            'data' => null
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Bill found',
        'data' => $bill
    ]);
}

public function apiStore(Request $request)
{
    $request->validate([
        'bill_id' => 'required',
        'patient_id' => 'nullable',
        'created_by' => 'nullable',
        'items' => 'required|array',
        'items.*.medicine_id' => 'required',
        'items.*.batch_id' => 'required',
        'items.*.return_qty' => 'required|numeric|min:0',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.reason' => 'nullable|string',
    ]);

    DB::beginTransaction();

    try {
        $returnNumber = 'SR-' . time();

        $salesReturn = SalesReturn::create([
            'id' => (string) Str::uuid(),
            'return_number' => $returnNumber,
            'bill_id' => $request->bill_id,
            'patient_id' => $request->patient_id,
            'total_refund' => 0,
            'status' => 'Draft',
            'created_by' => $request->created_by ?? 1,
        ]);

        $totalRefund = 0;

        foreach ($request->items as $item) {

            if (($item['return_qty'] ?? 0) <= 0) continue;

            // ✅ Validate against sold quantity in bill
            $billItem = SalesBillItem::where('sales_bill_id', $request->bill_id)
                ->where('medicine_id', $item['medicine_id'])
                ->where('batch_id', $item['batch_id'])
                ->first();

            if (!$billItem) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Bill item not found for selected medicine/batch',
                    'data' => null
                ], 422);
            }

            if ($item['return_qty'] > $billItem->quantity) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Return quantity cannot be greater than sold quantity',
                    'data' => null
                ], 422);
            }

            $refund = $item['return_qty'] * $item['unit_price'];

            SalesReturnItem::create([
                'id' => (string) Str::uuid(),
                'sales_return_id' => $salesReturn->id,
                'medicine_id' => $item['medicine_id'],
                'batch_id' => $item['batch_id'],
                'quantity' => $item['return_qty'],
                'unit_price' => $item['unit_price'],
                'refund_amount' => $refund,
                'reason' => $item['reason'] ?? null,
            ]);

            $batch = MedicineBatch::find($item['batch_id']);
            if ($batch) {
                $batch->quantity += $item['return_qty'];
                $batch->save();
            }

            $totalRefund += $refund;
        }

        $salesReturn->update([
            'total_refund' => $totalRefund
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Sales return created successfully',
            'data' => $salesReturn->load(['items.medicine', 'items.batch', 'bill', 'creator'])
        ], 201);

    } catch (\Exception $e) {
        DB::rollback();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'data' => null
        ], 500);
    }
}

public function apiUpdate(Request $request, $id)
{
    $request->validate([
        'items' => 'required|array',
        'items.*.id' => 'required|string',
        'items.*.return_qty' => 'required|numeric|min:0',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.reason' => 'nullable|string',

        'status' => 'nullable|string',
        'refund_reference' => 'nullable|string',
        'remarks' => 'nullable|string',
    ]);

    DB::beginTransaction();

    try {
        $salesReturn = SalesReturn::with('items')->findOrFail($id);

        $totalRefund = 0;

        foreach ($request->items as $itemData) {

            $item = SalesReturnItem::where('sales_return_id', $salesReturn->id)
                ->where('id', $itemData['id'])
                ->first();

            if (!$item) continue;

            // ✅ Validate against sold quantity in original bill
            $billItem = SalesBillItem::where('sales_bill_id', $salesReturn->bill_id)
                ->where('medicine_id', $item->medicine_id)
                ->where('batch_id', $item->batch_id)
                ->first();

            if (!$billItem) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Bill item not found for selected medicine/batch',
                    'data' => null
                ], 422);
            }

            if ($itemData['return_qty'] > $billItem->quantity) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Return quantity cannot be greater than sold quantity for medicine ID: ' . $item->medicine_id,
                    'data' => null
                ], 422);
            }

            $qty = $itemData['return_qty'];
            $unitPrice = $itemData['unit_price'];
            $refund = $qty * $unitPrice;

            $item->update([
                'quantity' => $qty,
                'unit_price' => $unitPrice,
                'refund_amount' => $refund,
                'reason' => $itemData['reason'] ?? null,
            ]);

            $totalRefund += $refund;
        }

        $salesReturn->update([
            'total_refund' => $totalRefund,
            'remarks' => $request->remarks,
            'status' => $request->status ?? $salesReturn->status,
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Sales return updated successfully',
            'data' => $salesReturn->load(['items.medicine', 'items.batch', 'bill', 'creator'])
        ]);

    } catch (\Exception $e) {
        DB::rollback();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'data' => null
        ], 500);
    }
}

public function apiApprove($id)
{
    try {
        $salesReturn = SalesReturn::findOrFail($id);
        $salesReturn->update(['status' => 'Approved']);

        return response()->json([
            'success' => true,
            'message' => 'Sales return approved',
            'data' => $salesReturn
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'data' => null
        ], 500);
    }
}

public function apiReject(Request $request, $id)
{
    try {
        $salesReturn = SalesReturn::findOrFail($id);

        $salesReturn->update([
            'status' => 'Rejected',
            'remarks' => $request->reason ?? 'Rejected by admin'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sales return rejected',
            'data' => $salesReturn
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'data' => null
        ], 500);
    }
}
}