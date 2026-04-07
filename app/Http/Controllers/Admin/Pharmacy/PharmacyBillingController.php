<?php
 
namespace App\Http\Controllers\Admin\Pharmacy;
 
use App\Http\Controllers\Controller;
use App\Models\SalesBill;
use App\Models\SalesBillItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Medicine;
use App\Models\MedicineBatch;
 
 
class PharmacyBillingController extends Controller
{
    public function index(Request $request)
{
    $query = SalesBill::query();
 
    $bills = SalesBill::with(['patient'])->get();
 
    // Filters
    if ($request->from_date) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }
 
    if ($request->to_date) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }
 
    if ($request->payment_status) {
        $query->where('payment_status', $request->payment_status);
    }
 
    if ($request->invoice_status) {
        $query->where('invoice_status', $request->invoice_status);
    }
 
    if ($request->q) {
        $query->where(function ($q) use ($request) {
            $q->where('bill_number', 'like', '%' . $request->q . '%')
              ->orWhere('patient_id', 'like', '%' . $request->q . '%')
              ->orWhere('prescription_id', 'like', '%' . $request->q . '%');
        });
    }
 
    // ✅ USE QUERY HERE (THIS IS THE FIX)
    $bills = $query->latest()->get();
 
    return view('admin.pharmacy.billing.index', compact('bills'));
 
}
 
 
 
public function create()
{
    $medicines = Medicine::all();
    $batches = MedicineBatch::all();
 
    return view('admin.pharmacy.billing.create', compact('medicines', 'batches'));
}
 
public function store(Request $request)
{
    // ❌ REMOVE DEBUG
    // dd($request->items[0]);
    //dd($request->all());
   
   $validator = \Validator::make($request->all(), [
    'patient_id' => 'required',
    'items' => 'required|array|min:1',
    'items.*.medicine_id' => 'required',
    'items.*.batch_id' => 'required',
    'items.*.qty' => 'required|numeric|min:1',
    'items.*.unit_price' => 'required|numeric|min:0',
]);
 
//if ($validator->fails()) {
  //  dd($validator->errors());
//}
 
    DB::beginTransaction();
 
    try {
 
        // ✅ 1. Generate Bill Number
        $billNumber = 'BILL' . time();
 
        $total = 0;
 
        // ✅ 2. Calculate Total Properly
        foreach ($request->items as $item) {
 
            $qty = $item['qty'];
            $price = $item['unit_price'];
            $discount = $item['discount'] ?? 0;
            $taxPercent = $item['tax_percent'] ?? 0;
 
            $subtotal = $qty * $price;
 
            $discountAmount = ($subtotal * $discount) / 100;
            $afterDiscount = $subtotal - $discountAmount;
 
            $taxAmount = ($afterDiscount * $taxPercent) / 100;
 
            $lineTotal = $afterDiscount + $taxAmount;
 
            $total += $lineTotal;
        }
 
        $paid = $request->paid_amount ?? 0;
        $balance = $total - $paid;
 
        // ✅ 3. Save Bill
        $bill = SalesBill::create([
            'bill_id' => Str::uuid(),
            'bill_number' => $billNumber,
            'patient_id' => $request->patient_id,
            'prescription_id' => $request->prescription_id,
            'total_amount' => $total,
            'paid_amount' => $paid,
            'balance_amount' => $balance,
            'payment_mode' => $request->payment_mode,
            'payment_status' => $request->payment_status,
            'invoice_status' => 'Draft',
            'remarks' => $request->remarks,
        ]);
 
        // ✅ 4. Save Items (IMPORTANT FIXES HERE)
        foreach ($request->items as $item) {
 
            $qty = $item['qty'];
            $price = $item['unit_price'];
            $discount = $item['discount'] ?? 0;
            $taxPercent = $item['tax_percent'] ?? 0;
 
            $subtotal = $qty * $price;
            $discountAmount = ($subtotal * $discount) / 100;
            $afterDiscount = $subtotal - $discountAmount;
            $taxAmount = ($afterDiscount * $taxPercent) / 100;
            $lineTotal = $afterDiscount + $taxAmount;
 
            SalesBillItem::create([
                'id' => Str::uuid(),
                'sales_bill_id' => $bill->bill_id,
                'medicine_id' => $item['medicine_id'],
                'batch_id' => $item['batch_id'],
                'quantity' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['qty'] * $item['unit_price'],
            ]);
        }
 
        DB::commit();
 
        return redirect()->route('admin.pharmacy.billing.index')
            ->with('success', 'Invoice Created Successfully');
 
    }
    catch (\Exception $e) {
        dd($e->getMessage());
    }
}
 
public function view($id)
{
    $invoice = SalesBill::with('patient')->findOrFail($id);
 
    $items = SalesBillItem::with(['medicine', 'batch'])
        ->where('sales_bill_id', $id)
        ->get();
 
    return view('admin.pharmacy.billing.view', compact('invoice', 'items'));
}
 
 
 public function edit($bill_id)
    {
        $bill = SalesBill::with(['patient', 'items.medicine', 'items.batch'])
        ->findOrFail($bill_id);
        $medicines = Medicine::all();
        $batches = MedicineBatch::all();
 
        return view('admin.pharmacy.billing.edit', compact('bill', 'medicines', 'batches'));
    }
 
/**
 * Update the sales bill.
 */
/*
public function update(Request $request, $bill_id)
{
    $bill = SalesBill::findOrFail($bill_id);
 
    $validated = $request->validate([
    'patient_id' => 'required|string|max:255',
    'prescription_id' => 'required|string|max:255',
    'remarks' => 'nullable|string',
    'payment_status' => 'required|in:Paid,Partially Paid,Unpaid',
    'payment_mode' => 'required|string',
    'paid_amount' => 'nullable|numeric|min:0',
]);
 
    DB::beginTransaction();
 
    try {
 
        $total = 0;
 
        foreach ($validated['items'] as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }
 
        $paid = $validated['paid_amount'] ?? 0;
        $balance = $total - $paid;
 
        // ✅ update bill
        $bill->update([
            'prescription_id' => $validated['prescription_id'],
            'remarks' => $validated['remarks'] ?? null,
            'payment_status' => $validated['payment_status'],
            'payment_mode' => $validated['payment_mode'],
            'paid_amount' => $paid,
            'total_amount' => $total, // ✅ IMPORTANT FIX
            'balance_amount' => $balance,
        ]);
 
        // ✅ delete old items
        //$bill->items()->delete();
 
        // ✅ insert new items
       
        //foreach ($validated['items'] as $item) {
          //  $bill->items()->create([
            //    'id' => Str::uuid(),
              //  'medicine_id' => $item['medicine_id'],
                //'batch_id' => $item['batch_id'],
                //'quantity' => $item['quantity'],
                //'unit_price' => $item['unit_price'],
                //'total_price' => $item['quantity'] * $item['unit_price'],
            //]);
        //}
 
        DB::commit();
 
        return redirect()->route('admin.pharmacy.billing.index')
            ->with('success', 'Updated Successfully');
 
    } catch (\Exception $e) {
        DB::rollBack();
        dd($e->getMessage());
    }
}
*/
 
public function update(Request $request, $bill_id)
{
    $bill = SalesBill::where('bill_id', $bill_id)->firstOrFail();

    DB::beginTransaction();

    try {

        $total = 0;

        // 🔥 DELETE OLD ITEMS
        $bill->items()->delete();

        // 🔥 INSERT NEW ITEMS + CALCULATE TOTAL
        foreach ($request->items as $item) {

            $qty = $item['quantity'];
            $price = $item['unit_price'];
            $discount = $item['discount'] ?? 0;
            $tax = $item['tax_percent'] ?? 0;

            $subtotal = $qty * $price;

            $discountAmount = ($subtotal * $discount) / 100;
            $afterDiscount = $subtotal - $discountAmount;

            $taxAmount = ($afterDiscount * $tax) / 100;

            $lineTotal = $afterDiscount + $taxAmount;

            $total += $lineTotal;

            SalesBillItem::create([
                'id' => Str::uuid(),
                'sales_bill_id' => $bill->bill_id,
                'medicine_id' => $item['medicine_id'],
                'batch_id' => $item['batch_id'],
                'quantity' => $qty,
                'unit_price' => $price,
                'total_price' => $lineTotal,
            ]);
        }

        // 🔥 CALCULATE PAYMENT
        $paid = $request->paid_amount ?? 0;
        $balance = $total - $paid;

        // 🔥 UPDATE BILL
        $bill->update([
            'remarks' => $request->remarks,
            'payment_status' => $request->payment_status,
            'payment_mode' => $request->payment_mode,
            'paid_amount' => $paid,
            'total_amount' => $total, // ✅ IMPORTANT
            'balance_amount' => $balance,
        ]);

        DB::commit();

        return redirect()->route('admin.pharmacy.billing.index')
            ->with('success', 'Sales bill updated successfully.');

    } catch (\Exception $e) {

        DB::rollBack();
        dd($e->getMessage());
    }
}
 
public function print($bill_id)
{
    $bill = SalesBill::with(['patient', 'items.medicine', 'items.batch'])
        ->findOrFail($bill_id);
 
    return view('admin.pharmacy.billing.print', compact('bill'));
}
 
 
 
 
// ================= APP API FUNCTIONS =================
 
 
// ✅ 1. LIST BILLS (API)
public function apiIndex(Request $request)
{
    $query = SalesBill::query();
 
    if ($request->from_date) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }
 
    if ($request->to_date) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }
 
    if ($request->payment_status) {
        $query->where('payment_status', $request->payment_status);
    }
 
    if ($request->invoice_status) {
        $query->where('invoice_status', $request->invoice_status);
    }
 
    if ($request->q) {
        $query->where(function ($q) use ($request) {
            $q->where('bill_number', 'like', '%' . $request->q . '%')
              ->orWhere('patient_id', 'like', '%' . $request->q . '%')
              ->orWhere('prescription_id', 'like', '%' . $request->q . '%');
        });
    }
 
    $bills = $query->with('patient')->latest()->get();
 
    return response()->json([
        'status' => true,
        'data' => $bills
    ]);
}
 
 
// ✅ 2. CREATE BILL (API)
public function apiStore(Request $request)
{
    $request->validate([
        'patient_id' => 'required',
        'items' => 'required|array|min:1',
        'items.*.medicine_id' => 'required',
        'items.*.batch_id' => 'required',
        'items.*.qty' => 'required|numeric|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
    ]);
 
    DB::beginTransaction();
 
    try {
 
        $billNumber = 'BILL' . time();
        $total = 0;
 
        foreach ($request->items as $item) {
 
            $qty = $item['qty'];
            $price = $item['unit_price'];
            $discount = $item['discount'] ?? 0;
            $taxPercent = $item['tax_percent'] ?? 0;
 
            $subtotal = $qty * $price;
            $discountAmount = ($subtotal * $discount) / 100;
            $afterDiscount = $subtotal - $discountAmount;
            $taxAmount = ($afterDiscount * $taxPercent) / 100;
 
            $lineTotal = $afterDiscount + $taxAmount;
            $total += $lineTotal;
        }
 
        $paid = $request->paid_amount ?? 0;
        $balance = $total - $paid;
 
        $bill = SalesBill::create([
            'bill_id' => Str::uuid(),
            'bill_number' => $billNumber,
            'patient_id' => $request->patient_id,
            'prescription_id' => $request->prescription_id,
            'total_amount' => $total,
            'paid_amount' => $paid,
            'balance_amount' => $balance,
            'payment_mode' => $request->payment_mode,
            'payment_status' => $request->payment_status,
            'invoice_status' => 'Draft',
            'remarks' => $request->remarks,
        ]);
 
        foreach ($request->items as $item) {
            SalesBillItem::create([
                'id' => Str::uuid(),
                'sales_bill_id' => $bill->bill_id,
                'medicine_id' => $item['medicine_id'],
                'batch_id' => $item['batch_id'],
                'quantity' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['qty'] * $item['unit_price'],
            ]);
        }
 
        DB::commit();
 
        return response()->json([
            'status' => true,
            'message' => 'Invoice Created Successfully',
            'data' => $bill
        ]);
 
    } catch (\Exception $e) {
 
        DB::rollBack();
 
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
 
 
// ✅ 3. VIEW BILL (API)
public function apiView($bill_id)
{
    $invoice = SalesBill::with('patient')
        ->where('bill_id', $bill_id)
        ->first();
 
    if (!$invoice) {
        return response()->json([
            'status' => false,
            'message' => 'Bill not found'
        ], 404);
    }
 
    $items = SalesBillItem::with(['medicine', 'batch'])
        ->where('sales_bill_id', $bill_id)
        ->get();
 
    return response()->json([
        'status' => true,
        'invoice' => $invoice,
        'items' => $items
    ]);
}
 
 
// ✅ 4. UPDATE BILL (API)
public function apiUpdate(Request $request, $bill_id)
{
    $bill = SalesBill::where('bill_id', $bill_id)->first();
 
    if (!$bill) {
        return response()->json([
            'status' => false,
            'message' => 'Bill not found'
        ], 404);
    }
 
    try {
 
        $bill->update([
            'prescription_id' => $request->prescription_id,
            'remarks' => $request->remarks,
            'payment_status' => $request->payment_status,
            'payment_mode' => $request->payment_mode,
            'paid_amount' => $request->paid_amount ?? 0,
            'balance_amount' => ($bill->total_amount ?? 0) - ($request->paid_amount ?? 0),
        ]);
 
        return response()->json([
            'status' => true,
            'message' => 'Sales bill updated successfully'
        ]);
 
    } catch (\Exception $e) {
 
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
 
 
// ✅ 5. PRINT BILL (API)
public function apiPrint($bill_id)
{
    $bill = SalesBill::with(['patient','items.medicine', 'items.batch'])
        ->where('bill_id', $bill_id)
        ->first();
 
    if (!$bill) {
        return response()->json([
            'status' => false,
            'message' => 'Bill not found'
        ], 404);
    }
 
    return response()->json([
        'status' => true,
        'data' => $bill
    ]);
}
 
}
 