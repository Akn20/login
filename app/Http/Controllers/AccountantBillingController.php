<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IpdBill;
use App\Models\IpdBillItem;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AccountantBillingController extends Controller
{

    /**
     * 🔹 INDEX (IPD LIST + BILL STATUS)
     */
    public function index()
    {
        
        $patients = DB::table('ipd_admissions as ipd')
            ->leftJoin('patients as p', 'p.id', '=', 'ipd.patient_id')
            ->leftJoin('staff as s', 's.id', '=', 'ipd.doctor_id') // ✅ FIX
            ->leftJoin('rooms as r', 'r.id', '=', 'ipd.room_id')
            ->leftJoin('ipd_bills as b', 'b.ipd_id', '=', 'ipd.id')

            ->select(
                'ipd.id',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as name"),
                'ipd.admission_id as ipd_no',
                'ipd.admission_date',
                DB::raw("IFNULL(r.room_number, '-') as room"),
                DB::raw("IFNULL(s.name, '-') as doctor"), // ✅ FIX
                'b.id as bill_id',
                DB::raw("IFNULL(b.status, 'interim') as status")
            )
            ->when(request('search'), function ($q) {
                $search = request('search');

                $q->where(function ($sub) use ($search) {
                    $sub->where('p.first_name', 'like', "%$search%")
                        ->orWhere('p.last_name', 'like', "%$search%")
                        ->orWhere('ipd.admission_id', 'like', "%$search%");
                });
            })

            ->when(request('status'), function ($q) {
                $status = request('status');

                if ($status == 'not_created') {
                    $q->whereNull('b.id');
                } else {
                    $q->where('b.status', $status);
                }
            })

            ->get();
        return view('admin.Accountant.Billing.index', compact('patients'));
    }


    /**
     * 🔹 CREATE (SEND PATIENT LIST)
     */
    public function create(Request $request)
    {
        $ipd_id = $request->ipd_id;

        $patient = DB::table('ipd_admissions as ipd')
            ->leftJoin('patients as p', 'p.id', '=', 'ipd.patient_id')
            ->leftJoin('staff as s', 's.id', '=', 'ipd.doctor_id')
            ->leftJoin('rooms as r', 'r.id', '=', 'ipd.room_id')   // (optional)

            ->select(
                'ipd.id as ipd_id',
                'ipd.patient_id',
                'ipd.admission_id',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as name"),
                DB::raw("IFNULL(s.name, '-') as doctor"),
                DB::raw("IFNULL(r.room_number, '-') as room"), // optional
                'ipd.advance_amount'
            )

            ->where('ipd.id', $ipd_id)
            ->first();

        $pharmacyItems = DB::table('pharmacy_ipd_dispense as pd')

            ->join('ipd_prescriptions as pr', 'pr.id', '=', 'pd.prescription_id')
            ->join('ipd_admissions as ipd', 'ipd.id', '=', 'pr.ipd_id')

            ->leftJoin('medicines as m', 'm.id', '=', 'pd.medicine_id')
            ->leftJoin('medicine_batches as mb', 'mb.id', '=', 'pd.batch_id')

            ->select(
                DB::raw('IFNULL(m.medicine_name, pd.medicine_name) as medicine_name'),
                DB::raw('SUM(pd.dispensed_quantity) as qty'),
                DB::raw('IFNULL(mb.mrp, 0) as price')
            )

            ->where('ipd.id', $ipd_id) // ✅ MOST IMPORTANT FILTER

            ->where('pd.dispensed_quantity', '>', 0)

            ->groupBy('pd.medicine_id', 'mb.mrp', 'm.medicine_name', 'pd.medicine_name')

            ->get();

        $labItems = DB::table('lab_requests as lr')
            ->leftJoin('lab_tests as lt', 'lt.test_name', '=', 'lr.test_name')

            ->select(
                'lr.test_name',
                DB::raw('IFNULL(lt.price, 0) as price')
            )

            ->where('lr.patient_id', $patient->patient_id)
            ->where('lr.status', '!=', 'cancelled')

            ->get();    

        $scanItems = DB::table('scan_requests as sr')
            ->leftJoin('scan_types as st', 'st.id', '=', 'sr.scan_type_id')

            ->select(
                'st.name as scan_name',
                DB::raw('0 as price') // no price in DB
            )

            ->where('sr.patient_id', $patient->patient_id)
            ->get();

        $roomCharge = DB::table('ipd_admissions as ipd')
            ->leftJoin('rooms as r', 'r.id', '=', 'ipd.room_id')

            ->select(
                'r.room_number',
                'ipd.admission_date',
                'ipd.discharge_date'
            )
            ->where('ipd.id', $patient->ipd_id)
            ->first();

        return view('admin.Accountant.Billing.create', compact('patient','pharmacyItems','labItems','scanItems','roomCharge'));
    }


    /**
     * 🔹 STORE BILL
     */

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            // ✅ TOTAL CALCULATION
            $total = collect($request->items)->sum(function ($item) {
                return (float) $item['amount'];
            });

            $discountPercent = (float) $request->discount;
            $taxPercent = (float) $request->tax;

            $discount = ($total * $discountPercent) / 100;
            $tax = ($total * $taxPercent) / 100;

            $grandTotal = $total - $discount + $tax;

            // ✅ GET ADVANCE FROM IPD
            $ipd = DB::table('ipd_admissions')
                ->where('id', $request->ipd_id)
                ->first();

            $advance = $ipd->advance_amount ?? 0;

            $payable = max($grandTotal - $advance, 0);

            // ✅ INSERT BILL (IMPORTANT FIXES HERE)
            $billId = Str::uuid();

            DB::table('ipd_bills')->insert([
                'id' => $billId, // ✅ UUID FIX
                'patient_id' => $request->patient_id,
                'ipd_id' => $request->ipd_id,
                'bill_no' => 'IPD-' . rand(1000, 9999),

                'bill_date' => Carbon::now()->toDateString(), // ✅ FIX (DATE only)

                'status' => 'interim',

                'total_amount' => $total,
                'discount' => $discount,
                'tax' => $tax,
                'discount_percent' => $discountPercent,
                'tax_percent' => $taxPercent,
                'grand_total' => $grandTotal,
                'payable_amount' => $payable,

                'created_at' => now(),
                'updated_at' => now(),

                'created_by' => auth()->id(),

                'notes' => $request->notes,
            ]);

            // ✅ INSERT ITEMS
            foreach ($request->items as $item) {

                DB::table('ipd_bill_items')->insert([
                    'id' => Str::uuid(), // ✅ UUID FIX
                    'bill_id' => $billId,

                    'reference_type' => strtolower($item['type']),
                    'reference_id' => $item['reference_id'] ?? null, // ✅ ADD THIS
                    
                    'type' => $item['type'],
                    'description' => $item['description'],
                    'quantity' => $item['quantity'] ?? 1,
                    'rate' => $item['rate'] ?? 0,
                    'amount' => $item['amount'] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('admin.accountant.billing.index')
                ->with('success', 'Bill Created Successfully');

        } catch (\Exception $e) {

            DB::rollback();

            dd($e->getMessage()); // 👈 TEMP DEBUG (remove later)
        }
    }


    /**
     * 🔹 VIEW BILL
     */
    public function show($id)
    {
        $bill = IpdBill::with(['items', 'patient'])
            ->where('id', $id)
            ->firstOrFail();

        return view('admin.Accountant.Billing.view', compact('bill'));
    }


    /**
     * 🔹 EDIT BILL
     */
    public function edit($id)
    {
        $bill = IpdBill::with(['items'])->findOrFail($id);

        $ipd_id = $bill->ipd_id;

        // 🔹 SAME AS CREATE (PATIENT)
        $patient = DB::table('ipd_admissions as ipd')
            ->leftJoin('patients as p', 'p.id', '=', 'ipd.patient_id')
            ->leftJoin('staff as s', 's.id', '=', 'ipd.doctor_id')
            ->leftJoin('rooms as r', 'r.id', '=', 'ipd.room_id')
            ->select(
                'ipd.id as ipd_id',
                'ipd.patient_id',
                'ipd.admission_id',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as name"),
                DB::raw("IFNULL(s.name, '-') as doctor"),
                DB::raw("IFNULL(r.room_number, '-') as room"),
                'ipd.advance_amount'
            )
            ->where('ipd.id', $ipd_id)
            ->first();

        // 🔹 SAME AS CREATE (PHARMACY)
        $pharmacyItems = DB::table('pharmacy_ipd_dispense as pd')
            ->join('ipd_prescriptions as pr', 'pr.id', '=', 'pd.prescription_id')
            ->join('ipd_admissions as ipd', 'ipd.id', '=', 'pr.ipd_id')
            ->leftJoin('medicines as m', 'm.id', '=', 'pd.medicine_id')
            ->leftJoin('medicine_batches as mb', 'mb.id', '=', 'pd.batch_id')
            ->select(
                DB::raw('IFNULL(m.medicine_name, pd.medicine_name) as medicine_name'),
                DB::raw('SUM(pd.dispensed_quantity) as qty'),
                DB::raw('IFNULL(mb.mrp, 0) as price')
            )
            ->where('ipd.id', $ipd_id)
            ->where('pd.dispensed_quantity', '>', 0)
            ->groupBy('pd.medicine_id', 'mb.mrp', 'm.medicine_name', 'pd.medicine_name')
            ->get();

        // 🔹 LAB
        $labItems = DB::table('lab_requests as lr')
            ->leftJoin('lab_tests as lt', 'lt.test_name', '=', 'lr.test_name')
            ->select(
                'lr.test_name',
                DB::raw('IFNULL(lt.price, 0) as price')
            )
            ->where('lr.patient_id', $patient->patient_id)
            ->where('lr.status', '!=', 'cancelled')
            ->get();

        // 🔹 SCAN
        $scanItems = DB::table('scan_requests as sr')
            ->leftJoin('scan_types as st', 'st.id', '=', 'sr.scan_type_id')
            ->select(
                'st.name as scan_name',
                DB::raw('0 as price')
            )
            ->where('sr.patient_id', $patient->patient_id)
            ->get();

        // 🔹 ROOM
        $roomCharge = DB::table('ipd_admissions as ipd')
            ->leftJoin('rooms as r', 'r.id', '=', 'ipd.room_id')
            ->select(
                'r.room_number',
                'ipd.admission_date',
                'ipd.discharge_date'
            )
            ->where('ipd.id', $ipd_id)
            ->first();

        return view('admin.Accountant.Billing.edit', compact(
            'bill',
            'patient',
            'pharmacyItems',
            'labItems',
            'scanItems',
            'roomCharge'
        ));
    }


    /**
     * 🔹 BILL NUMBER GENERATOR
     */
    private function generateBillNumber()
    {
        $count = IpdBill::count() + 1;
        return 'IPD-BILL-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        DB::beginTransaction();

        try {

            $bill = IpdBill::findOrFail($id);

            if (!$request->items || count($request->items) == 0) {
                return back()->with('error', 'No items found');
            }

            $total = 0;

            foreach ($request->items as $item) {
                $amount = isset($item['amount']) ? (float)$item['amount'] : 0;
                $total += $amount;
            }

            $discountPercent = (float) ($request->discount ?? 0);
            $taxPercent = (float) ($request->tax ?? 0);

            $discount = ($total * $discountPercent) / 100;
            $tax = ($total * $taxPercent) / 100;

            $grandTotal = $total - $discount + $tax;

            $ipd = DB::table('ipd_admissions')
                ->where('id', $bill->ipd_id)
                ->first();

            $advance = $ipd->advance_amount ?? 0;

            $payable = max($grandTotal - $advance, 0);

            // ✅ UPDATE BILL
            $bill->update([
                'total_amount' => $total,
                'discount' => $discount,
                'tax' => $tax,
                'discount_percent' => $discountPercent,
                'tax_percent' => $taxPercent,
                'grand_total' => $grandTotal,
                'payable_amount' => $payable,
                'notes' => $request->notes,
            ]);

            // ✅ DELETE OLD ITEMS
            IpdBillItem::where('bill_id', $bill->id)->delete();

            // ✅ INSERT NEW ITEMS (SAFE)
            foreach ($request->items as $item) {

                IpdBillItem::create([
                    'bill_id' => $bill->id,
                    'type' => $item['type'] ?? '',
                    'description' => $item['description'] ?? '',
                    'quantity' => $item['quantity'] ?? 1,
                    'rate' => $item['rate'] ?? 0,
                    'amount' => $item['amount'] ?? 0,
                    'reference_id' => $item['reference_id'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.accountant.billing.index')
                ->with('success', 'Bill Updated Successfully');

        } catch (\Exception $e) {

            DB::rollback();

            dd($e->getMessage()); // TEMP DEBUG
        }
    }

    //API FUNCTIONS 

    public function apiIndex(Request $request)
    {
        $patients = DB::table('ipd_admissions as ipd')
            ->leftJoin('patients as p', 'p.id', '=', 'ipd.patient_id')
            ->leftJoin('staff as s', 's.id', '=', 'ipd.doctor_id')
            ->leftJoin('rooms as r', 'r.id', '=', 'ipd.room_id')
            ->leftJoin('ipd_bills as b', 'b.ipd_id', '=', 'ipd.id')

            ->select(
                'ipd.id',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as name"),
                'ipd.admission_id as ipd_no',
                'ipd.admission_date',
                DB::raw("IFNULL(r.room_number, '-') as room"),
                DB::raw("IFNULL(s.name, '-') as doctor"),
                'b.id as bill_id',
                DB::raw("IFNULL(b.status, 'interim') as status")
            )

            ->when($request->search, function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($sub) use ($search) {
                    $sub->where('p.first_name', 'like', "%$search%")
                        ->orWhere('p.last_name', 'like', "%$search%")
                        ->orWhere('ipd.admission_id', 'like', "%$search%");
                });
            })

            ->when($request->status, function ($q) use ($request) {
                if ($request->status == 'not_created') {
                    $q->whereNull('b.id');
                } else {
                    $q->where('b.status', $request->status);
                }
            })

            ->orderBy('ipd.created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $patients
        ]);
    }

    public function apiPatient($ipd_id)
    {
        $patient = DB::table('ipd_admissions as ipd')
            ->leftJoin('patients as p', 'p.id', '=', 'ipd.patient_id')
            ->leftJoin('staff as s', 's.id', '=', 'ipd.doctor_id')
            ->leftJoin('rooms as r', 'r.id', '=', 'ipd.room_id')

            ->select(
                'ipd.id as ipd_id',
                'ipd.patient_id',
                'ipd.admission_id',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as name"),
                DB::raw("IFNULL(s.name, '-') as doctor"),
                DB::raw("IFNULL(r.room_number, '-') as room"),
                'ipd.advance_amount'
            )

            ->where('ipd.id', $ipd_id)
            ->first();

        return response()->json([
            'status' => true,
            'data' => $patient
        ]);
    }

    public function apiShow($id)
    {
        $bill = IpdBill::with(['items', 'patient'])
            ->where('id', $id)
            ->first();

        return response()->json([
            'status' => true,
            'data' => $bill
        ]);
    }

    public function apiStore(Request $request)
    {
        DB::beginTransaction();

        try {

            $total = collect($request->items)->sum(fn($i) => (float)$i['amount']);

            $discountPercent = (float) $request->discount;
            $taxPercent = (float) $request->tax;

            $discount = ($total * $discountPercent) / 100;
            $tax = ($total * $taxPercent) / 100;

            $grandTotal = $total - $discount + $tax;

            $ipd = DB::table('ipd_admissions')
                ->where('id', $request->ipd_id)
                ->first();

            $advance = $ipd->advance_amount ?? 0;

            $payable = max($grandTotal - $advance, 0);

            $billId = Str::uuid();

            DB::table('ipd_bills')->insert([
                'id' => $billId,
                'patient_id' => $request->patient_id,
                'ipd_id' => $request->ipd_id,
                'bill_no' => 'IPD-' . rand(1000, 9999),
                'bill_date' => now()->toDateString(),
                'status' => 'interim',

                'total_amount' => $total,
                'discount' => $discount,
                'tax' => $tax,
                'discount_percent' => $discountPercent,
                'tax_percent' => $taxPercent,
                'grand_total' => $grandTotal,
                'payable_amount' => $payable,

                'notes' => $request->notes,

                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($request->items as $item) {
                DB::table('ipd_bill_items')->insert([
                    'id' => Str::uuid(),
                    'bill_id' => $billId,
                    'type' => $item['type'] ?? '',
                    'description' => $item['description'] ?? '',
                    'quantity' => $item['quantity'] ?? 1,
                    'rate' => $item['rate'] ?? 0,
                    'amount' => $item['amount'] ?? 0,
                    'reference_id' => $item['reference_id'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Bill Created',
                'bill_id' => $billId
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function apiUpdate(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $bill = IpdBill::findOrFail($id);

            $total = collect($request->items)->sum(fn($i) => (float)$i['amount']);

            $discountPercent = (float) $request->discount;
            $taxPercent = (float) $request->tax;

            $discount = ($total * $discountPercent) / 100;
            $tax = ($total * $taxPercent) / 100;

            $grandTotal = $total - $discount + $tax;

            $ipd = DB::table('ipd_admissions')
                ->where('id', $bill->ipd_id)
                ->first();

            $advance = $ipd->advance_amount ?? 0;

            $payable = max($grandTotal - $advance, 0);

            $bill->update([
                'total_amount' => $total,
                'discount' => $discount,
                'tax' => $tax,
                'discount_percent' => $discountPercent,
                'tax_percent' => $taxPercent,
                'grand_total' => $grandTotal,
                'payable_amount' => $payable,
                'notes' => $request->notes,
            ]);

            IpdBillItem::where('bill_id', $bill->id)->delete();

            foreach ($request->items as $item) {
                IpdBillItem::create([
                    'bill_id' => $bill->id,
                    'type' => $item['type'] ?? '',
                    'description' => $item['description'] ?? '',
                    'quantity' => $item['quantity'] ?? 1,
                    'rate' => $item['rate'] ?? 0,
                    'amount' => $item['amount'] ?? 0,
                    'reference_id' => $item['reference_id'] ?? null,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Bill Updated'
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}