<?php

namespace App\Http\Controllers\Admin\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PharmacySale;
use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\Vendor;
use App\Models\StockMovement;
use App\Models\SalesBill;
use App\Models\SalesBillItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PharmacyReportController extends Controller
{

public function sales(Request $request)
{
    $query = SalesBill::query();

    // Date filter
    if ($request->from) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    // Payment mode filter
    if ($request->payment_mode) {
        $query->where('payment_mode', $request->payment_mode);
    }

    // Optional: only finalized bills
    // $query->where('invoice_status', 'Final');

    $sales = $query->latest()->paginate(10);

    return view('admin.pharmacy.reports.sales', compact('sales'));
}

    // Medicine-wise Report

public function medicine(Request $request)
{
    $query = DB::table('sales_bill_items')
        ->join('sales_bills', 'sales_bill_items.sales_bill_id', '=', 'sales_bills.bill_id')
        ->join('medicines', 'sales_bill_items.medicine_id', '=', 'medicines.id')
        ->select(
            'medicines.id',
            'medicines.medicine_name',
            DB::raw('SUM(sales_bill_items.quantity) as total_quantity'),
            DB::raw('AVG(sales_bill_items.unit_price) as unit_price'),
            DB::raw('SUM(sales_bill_items.total_price) as total_revenue')
        )
        ->groupBy('medicines.id', 'medicines.medicine_name');

    // ✅ DATE FILTER
    if ($request->from) {
        $query->whereDate('sales_bills.created_at', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('sales_bills.created_at', '<=', $request->to);
    }

    // ✅ MEDICINE FILTER
    if ($request->medicine_id) {
        $query->where('medicines.id', $request->medicine_id);
    }

    $medicines = $query->paginate(10)->appends($request->all());

    // dropdown data
    $allMedicines = \App\Models\Medicine::select('id', 'medicine_name')->get();

    return view('admin.pharmacy.reports.medicine', compact('medicines', 'allMedicines'));
}

    // Batch Report


public function batch(Request $request)
{
    $query = DB::table('medicine_batches')
        ->join('medicines', 'medicine_batches.medicine_id', '=', 'medicines.id')
        ->select(
            'medicines.medicine_name',
            'medicine_batches.batch_number',
            'medicine_batches.expiry_date',
            'medicine_batches.quantity'
        );

    // Medicine filter
    if ($request->medicine_id) {
        $query->where('medicines.id', $request->medicine_id);
    }

    // Batch filter
    if ($request->batch) {
        $query->where('medicine_batches.batch_number', 'like', '%' . $request->batch . '%');
    }

    // Expiry range filter
    if ($request->expiry_range == '30') {
        $query->whereBetween('expiry_date', [now(), now()->addDays(30)]);
    }

    if ($request->expiry_range == '60') {
        $query->whereBetween('expiry_date', [now(), now()->addDays(60)]);
    }

    $batches = $query->paginate(10)->appends($request->all());

    // Dropdown
    $allMedicines = \App\Models\Medicine::select('id', 'medicine_name')->get();

    // Summary
    $expiredCount = DB::table('medicine_batches')
        ->whereDate('expiry_date', '<', now())
        ->count();

    $nearExpiryCount = DB::table('medicine_batches')
        ->whereBetween('expiry_date', [now(), now()->addDays(30)])
        ->count();

    return view('admin.pharmacy.reports.batch', compact(
        'batches',
        'allMedicines',
        'expiredCount',
        'nearExpiryCount'
    ));
}

    // Expiry Report
public function expiry(Request $request)
{
    $query = DB::table('medicine_batches')
        ->join('medicines', 'medicine_batches.medicine_id', '=', 'medicines.id')
        ->select(
            'medicines.medicine_name',
            'medicine_batches.batch_number',
            'medicine_batches.expiry_date',
            'medicine_batches.quantity'
        );

    // 🔍 Medicine filter
    if ($request->medicine_id) {
        $query->where('medicines.id', $request->medicine_id);
    }

    // 🔍 Expiry range filter
    if ($request->range == '30') {
        $query->whereBetween('expiry_date', [now(), now()->addDays(30)]);
    }

    if ($request->range == '60') {
        $query->whereBetween('expiry_date', [now(), now()->addDays(60)]);
    }

    if ($request->range == '90') {
        $query->whereBetween('expiry_date', [now(), now()->addDays(90)]);
    }

    $expiry = $query->orderBy('expiry_date', 'asc')
                    ->paginate(10)
                    ->appends($request->all());

    // 🔹 Dropdown data
    $allMedicines = \App\Models\Medicine::select('id', 'medicine_name')->get();

    // 🔹 Summary
    $nearExpiry = DB::table('medicine_batches')
        ->whereBetween('expiry_date', [now(), now()->addDays(30)])
        ->count();

    $expired = DB::table('medicine_batches')
        ->whereDate('expiry_date', '<', now())
        ->count();

    $total = $nearExpiry + $expired;

    return view('admin.pharmacy.reports.expiry', compact(
        'expiry',
        'allMedicines',
        'nearExpiry',
        'expired',
        'total'
    ));
}

    // Low Stock Report
public function lowStock(Request $request)
{
    $query = DB::table('medicine_batches')
        ->join('medicines', 'medicine_batches.medicine_id', '=', 'medicines.id')
        ->select(
            'medicines.id',
            'medicines.medicine_name',
            DB::raw('SUM(medicine_batches.quantity) as total_stock'),
            DB::raw('MAX(medicine_batches.reorder_level) as reorder_level')
        )
        ->groupBy('medicines.id', 'medicines.medicine_name');

    // 🔴 DEFAULT: SHOW ONLY LOW STOCK
    $query->havingRaw('SUM(medicine_batches.quantity) < MAX(medicine_batches.reorder_level)');

    // 🔍 Medicine Filter
    if ($request->medicine_id) {
        $query->where('medicines.id', $request->medicine_id);
    }

    // 🔍 Stock Level Filter (override default if selected)
    if ($request->level == 'critical') {
        $query->havingRaw('SUM(medicine_batches.quantity) < 10');
    }

    $medicines = $query->paginate(10)->appends($request->all());

    // counts (same as before)
    $baseQuery = DB::table('medicine_batches')
        ->select(
            'medicine_id',
            DB::raw('SUM(quantity) as total_stock'),
            DB::raw('MAX(reorder_level) as reorder_level')
        )
        ->groupBy('medicine_id');

    $criticalCount = (clone $baseQuery)
        ->havingRaw('total_stock < 10')
        ->get()->count();

    $lowCount = (clone $baseQuery)
        ->havingRaw('total_stock < reorder_level')
        ->get()->count();

    $allMedicines = Medicine::select('id', 'medicine_name')->get();

    return view('admin.pharmacy.reports.low_stock', compact(
        'medicines',
        'allMedicines',
        'criticalCount',
        'lowCount'
    ));
}

    // Controlled Drugs Report


public function controlled(Request $request)
{
    $query = DB::table('controlled_drug_dispense as d')
        ->join('controlled_drug as c', 'd.controlled_drug_id', '=', 'c.controlled_drug_id')
        ->leftJoin('patients as p', 'd.patient_id', '=', 'p.id') // if exists
        ->select(
            'c.drug_name',
            'd.patient_id',
            'd.quantity_dispensed',
            'd.dispense_date',
            'c.stock_quantity'
        );

    // 🔍 Filters

    if ($request->drug_name) {
        $query->where('c.drug_name', $request->drug_name);
    }

    if ($request->from) {
        $query->whereDate('d.dispense_date', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('d.dispense_date', '<=', $request->to);
    }

    $records = $query->paginate(10);

    // 🔹 Summary

    $totalDispensed = DB::table('controlled_drug_dispense')->sum('quantity_dispensed');

    $remainingStock = DB::table('controlled_drug')->sum('stock_quantity');

    $highRisk = DB::table('controlled_drug')
        ->where('stock_quantity', '<', 20)
        ->count();

        $allMedicines = DB::table('controlled_drug')
    ->select('controlled_drug_id', 'drug_name')
    ->get();
    return view('admin.pharmacy.reports.controlled', compact(
        'records',
        'totalDispensed',
        'remainingStock',
        'highRisk',
        'allMedicines'
    ));
}

    // Vendor Report
public function vendor(Request $request)
{
    $query = DB::table('vendors')
        ->leftJoin('grns', 'vendors.vendor_name', '=', 'grns.vendor_name')
        ->select(
            'vendors.vendor_name',
            DB::raw('COALESCE(SUM(grns.grand_total),0) as total_purchase'),
            DB::raw('COALESCE(MAX(grns.grn_date), NULL) as last_purchase_date')
        )
        ->groupBy('vendors.vendor_name');

    // Filters
    if ($request->vendor_name) {
        $query->where('vendors.vendor_name', $request->vendor_name);
    }

    if ($request->from) {
        $query->whereDate('grns.grn_date', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('grns.grn_date', '<=', $request->to);
    }

    $reportData = $query->paginate(10)->appends($request->all());

    // 🔹 Dropdown vendors (IMPORTANT FIX)
    $allVendors = DB::table('vendors')
        ->select('vendor_name')
        ->get();

    // 🔹 Calculations
    foreach ($reportData as $v) {
        $v->paid_amount = $v->total_purchase * 0.7;
        $v->pending_amount = $v->total_purchase - $v->paid_amount;
    }

    // Summary
    $totalPurchase = DB::table('grns')->sum('grand_total');
    $totalVendors = DB::table('vendors')->count();
    $pendingPayments = $totalPurchase * 0.3;

    return view('admin.pharmacy.reports.vendor', compact(
        'reportData',
        'allVendors',
        'totalPurchase',
        'pendingPayments',
        'totalVendors'
    ));
}

    // GRN Report

public function grn(Request $request)
{
    $query = DB::table('grn_items')
        ->join('grns', 'grn_items.grn_id', '=', 'grns.id')
        ->select(
            'grns.grn_no',
            'grns.vendor_name',
            'grn_items.medicine_name',
            'grn_items.batch_no',
            'grn_items.qty',
            'grn_items.purchase_rate',
            'grn_items.amount',
            'grns.grn_date'
        );

    // 🔍 Filters

    if ($request->vendor_name) {
        $query->where('grns.vendor_name', 'like', '%' . $request->vendor_name . '%');
    }

    if ($request->medicine_name) {
        $query->where('grn_items.medicine_name', 'like', '%' . $request->medicine_name . '%');
    }

    if ($request->from) {
        $query->whereDate('grns.grn_date', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('grns.grn_date', '<=', $request->to);
    }

    $records = $query->latest('grns.grn_date')
                     ->paginate(10)
                     ->appends($request->all());

    // 🔹 Summary

    $totalGRN = DB::table('grns')->count();

    $totalQty = DB::table('grn_items')->sum('qty');

    $totalValue = DB::table('grn_items')->sum('amount');

    return view('admin.pharmacy.reports.grn', compact(
        'records',
        'totalGRN',
        'totalQty',
        'totalValue'
    ));
}
    // Billing Report

public function billing(Request $request)
{
    $query = SalesBill::query();

    // 🔍 Filters

    if ($request->from) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    if ($request->payment_status) {
        $query->where('payment_status', $request->payment_status);
    }

    if ($request->payment_mode) {
        $query->where('payment_mode', $request->payment_mode);
    }

    $bills = $query->latest()
                   ->paginate(10)
                   ->appends($request->all());

    // 🔹 Summary

    $totalAmount = SalesBill::sum('total_amount');
    $totalPaid = SalesBill::sum('paid_amount');
    $totalBalance = SalesBill::sum('balance_amount');

    return view('admin.pharmacy.reports.billing', compact(
        'bills',
        'totalAmount',
        'totalPaid',
        'totalBalance'
    ));
}



// ✅ API
    /* ================= SALES ================= */
public function salesApi(Request $request)
{
    $query = SalesBill::query();

    if ($request->from) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    if ($request->payment_mode) {
        $query->where('payment_mode', $request->payment_mode);
    }

    $sales = $query->latest()->paginate(10);

    return response()->json([
        'status' => true,
        'data' => $sales
    ]);
}


/* ================= MEDICINE ================= */
public function medicineApi(Request $request)
{
    $query = DB::table('sales_bill_items as si')
        ->join('medicines as m', 'si.medicine_id', '=', 'm.id')
        ->select(
            'm.medicine_name',
            DB::raw('SUM(si.quantity) as total_quantity'),
            DB::raw('AVG(si.unit_price) as unit_price'),
            DB::raw('SUM(si.quantity * si.unit_price) as total_revenue') // ✅ FIX
        )
        ->groupBy('m.id', 'm.medicine_name');

    // ✅ FILTER
    if ($request->medicine_name) {
        $query->where('m.medicine_name', 'LIKE', '%' . $request->medicine_name . '%');
    }

    return response()->json([
        'status' => true,
        'data' => $query->paginate(10)
    ]);
}


/* ================= LOW STOCK ================= */
public function lowStockApi(Request $request)
{
    $query = DB::table('medicine_batches as mb')
        ->join('medicines as m', 'mb.medicine_id', '=', 'm.id')
        ->select(
            'm.medicine_name',
            'mb.medicine_id',
            DB::raw('SUM(mb.quantity) as total_stock'),
            DB::raw('MAX(mb.reorder_level) as reorder_level')
        )
        ->groupBy('mb.medicine_id', 'm.medicine_name');

    // 🔴 IMPORTANT: ONLY LOW STOCK
    $query->havingRaw('SUM(mb.quantity) < MAX(mb.reorder_level)');

    // 🔍 Filter: medicine
    if ($request->medicine_id) {
        $query->where('mb.medicine_id', $request->medicine_id);
    }

    // 🔍 Filter: level
    if ($request->level == 'critical') {
        $query->havingRaw('SUM(mb.quantity) < 10');
    }

    if ($request->level == 'low') {
        $query->havingRaw('SUM(mb.quantity) < MAX(mb.reorder_level)');
    }

    $data = $query->paginate(10);

    // ✅ Add status
    $data->getCollection()->transform(function ($item) {
        if ($item->total_stock < 10) {
            $item->status = 'Critical';
        } elseif ($item->total_stock < $item->reorder_level) {
            $item->status = 'Low';
        } else {
            $item->status = 'Normal';
        }
        return $item;
    });

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}


/* ================= EXPIRY ================= */
public function expiryApi(Request $request)
{
    $today = now();

    $query = DB::table('medicine_batches as mb')
        ->join('medicines as m', 'mb.medicine_id', '=', 'm.id')
        ->select(
            'm.medicine_name',
            'mb.batch_number', // ✅ FIXED
            'mb.expiry_date',
            'mb.quantity as stock'
        );

    // Filter: medicine
    if ($request->medicine_id) {
        $query->where('mb.medicine_id', $request->medicine_id);
    }

    $data = $query->orderBy('mb.expiry_date', 'asc')->paginate(10);

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}

/* ================= BATCH ================= */
public function batchWiseApi(Request $request)
{
    $today = now();

    $query = DB::table('medicine_batches as mb')
        ->join('medicines as m', 'mb.medicine_id', '=', 'm.id')
        ->select(
            'm.medicine_name',
            'mb.batch_number',
            'mb.created_at as purchase_date', // ✅ FIX
            'mb.expiry_date',
            'mb.quantity'
        );

    // Filter: batch number
    if ($request->batch_number) {
        $query->where('mb.batch_number', 'LIKE', '%' . $request->batch_number . '%');
    }

    $data = $query->orderBy('mb.expiry_date', 'asc')->paginate(10);

    // Status
    $data->getCollection()->transform(function ($item) use ($today) {
        if ($item->expiry_date < $today) {
            $item->status = 'Expired';
        } elseif ($item->expiry_date <= $today->copy()->addDays(30)) {
            $item->status = 'Near Expiry';
        } else {
            $item->status = 'Active';
        }
        return $item;
    });

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}

/* ================= CONTROLLED DRUG ================= */
public function controlledApi(Request $request)
{
    $query = DB::table('controlled_drug_dispense as d')
        ->join('controlled_drug as c', 'd.controlled_drug_id', '=', 'c.controlled_drug_id')
        ->select(
            'c.drug_name',
            'd.quantity_dispensed',
            'd.dispense_date',
            'c.stock_quantity'
        );

    // 🔍 Filter: Drug Name
    if ($request->drug_name) {
        $query->where('c.drug_name', 'LIKE', '%' . trim($request->drug_name) . '%');
    }

    // 🔍 Filter: From Date
    if ($request->from) {
        $query->whereDate('d.dispense_date', '>=', $request->from);
    }

    // 🔍 Filter: To Date
    if ($request->to) {
        $query->whereDate('d.dispense_date', '<=', $request->to);
    }

    $data = $query->paginate(10);

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}


/* ================= VENDOR ================= */
public function vendorApi(Request $request)
{
    $query = DB::table('vendors')
        ->leftJoin('grns', 'vendors.vendor_name', '=', 'grns.vendor_name')
        ->select(
            'vendors.vendor_name',
            DB::raw('SUM(grns.grand_total) as total_purchase')
        )
        ->groupBy('vendors.vendor_name');

    return response()->json([
        'status' => true,
        'data' => $query->paginate(10)
    ]);
}


/* ================= GRN ================= */
public function grnApi(Request $request)
{
    $query = DB::table('grns as g')
        ->join('grn_items as gi', 'g.id', '=', 'gi.grn_id')
        ->select(
            'g.grn_no',
            'g.vendor_name',
            'g.invoice_no',
            'g.grn_date',
            DB::raw('SUM(gi.amount) as total_amount')
        )
        ->groupBy(
            'g.id',
            'g.grn_no',
            'g.vendor_name',
            'g.invoice_no',
            'g.grn_date'
        );

    // 🔍 Filter: Vendor
    if ($request->vendor_name) {
        $query->where('g.vendor_name', 'LIKE', '%' . trim($request->vendor_name) . '%');
    }

    // 🔍 Filter: From Date
    if ($request->from) {
        $query->whereDate('g.grn_date', '>=', $request->from);
    }

    // 🔍 Filter: To Date
    if ($request->to) {
        $query->whereDate('g.grn_date', '<=', $request->to);
    }

    $data = $query->paginate(10);

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}

/* ================= BILLING ================= */
public function billingApi(Request $request)
{
    $query = DB::table('sales_bills as b')
        ->select(
            'b.bill_number',
            'b.patient_name',
            'b.total_amount',
            'b.paid_amount',
            'b.balance_amount',
            'b.payment_mode',
            'b.created_at as bill_date' // ✅ FIXED
        );

    // ✅ Date Filter
    if ($request->from) {
        $query->whereDate('b.created_at', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('b.created_at', '<=', $request->to);
    }

    // ✅ Payment Mode Filter
    if ($request->payment_mode) {
        $query->where('b.payment_mode', $request->payment_mode);
    }

    return response()->json([
        'status' => true,
        'data' => $query->paginate(10)
    ]);
}


}