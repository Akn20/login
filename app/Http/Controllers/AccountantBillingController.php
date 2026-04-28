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
            ->leftJoin('users as d', 'd.id', '=', 'ipd.doctor_id')
            ->leftJoin('rooms as r', 'r.id', '=', 'ipd.room_id')
            ->leftJoin('ipd_bills as b', 'b.ipd_id', '=', 'ipd.id')

            ->select(
                'ipd.id',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as name"),
                'ipd.admission_id as ipd_no',
                'ipd.admission_date',
                DB::raw("IFNULL(r.room_number, '-') as room"),
                DB::raw("IFNULL(d.name, '-') as doctor"), // ✅ FIX
                'b.id as bill_id',
                DB::raw("IFNULL(b.status, 'interim') as status")
            )

            ->orderBy('ipd.created_at', 'desc')
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
            ->leftJoin('users as d', 'd.id', '=', 'ipd.doctor_id') // ✅ JOIN doctor
            ->leftJoin('rooms as r', 'r.id', '=', 'ipd.room_id')   // (optional)

            ->select(
                'ipd.id as ipd_id',
                'ipd.patient_id',
                'ipd.admission_id',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as name"),
                DB::raw("IFNULL(d.name, '-') as doctor"), // ✅ FIX HERE
                DB::raw("IFNULL(r.room_number, '-') as room"), // optional
                'ipd.advance_amount'
            )

            ->where('ipd.id', $ipd_id)
            ->first();

        return view('admin.Accountant.Billing.create', compact('patient'));
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

            $discount = (float) $request->discount;
            $tax = (float) $request->tax;

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
                'grand_total' => $grandTotal,
                'payable_amount' => $payable,

                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ✅ INSERT ITEMS
            foreach ($request->items as $item) {

                DB::table('ipd_bill_items')->insert([
                    'id' => Str::uuid(), // ✅ UUID FIX
                    'bill_id' => $billId,

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
        $bill = IpdBill::with('items')->where('id', $id)->firstOrFail();

        return view('admin.Accountant.Billing.edit', compact('bill'));
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
        DB::beginTransaction();

        try {

            $bill = IpdBill::findOrFail($id);

            if (!$request->items) {
                return back()->with('error', 'No charges added');
            }

            $total = 0;

            foreach ($request->items as $item) {
                $total += $item['amount'];
            }

            $discount = $request->discount ?? 0;
            $tax = $request->tax ?? 0;

            $grandTotal = $total - $discount + $tax;

            // Advance
            $ipd = DB::table('ipd_admissions')
                ->where('id', $bill->ipd_id)
                ->first();

            $advance = $ipd->advance_amount ?? 0;

            $payable = max($grandTotal - $advance, 0);

            // 🔹 Update Bill
            $bill->update([
                'total_amount' => $total,
                'discount' => $discount,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'payable_amount' => $payable,
            ]);

            // 🔹 DELETE OLD ITEMS
            IpdBillItem::where('bill_id', $bill->id)->delete();

            // 🔹 INSERT NEW ITEMS
            foreach ($request->items as $item) {
                IpdBillItem::create([
                    'bill_id' => $bill->id,
                    'type' => $item['type'],
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'rate' => $item['rate'],
                    'amount' => $item['amount'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.accountant.billing.index')
                ->with('success', 'Bill Updated Successfully');

        } catch (\Exception $e) {

            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }
}