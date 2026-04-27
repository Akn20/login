<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IpdBill;
use App\Models\IpdBillItem;
use Carbon\Carbon;

class AccountantBillingController extends Controller
{
    /**
     * 🔹 INDEX (Real Data from DB)
     */
    public function index()
    {
        $patients = DB::table('ipd_admissions as ipd')
            ->join('patients as p', 'p.id', '=', 'ipd.patient_id')
            ->leftJoin('users as d', 'd.id', '=', 'ipd.doctor_id')
            ->leftJoin('rooms as r', 'r.id', '=', 'ipd.room_id')
            ->leftJoin('ipd_bills as b', 'b.ipd_id', '=', 'ipd.id')

            ->select(
                'ipd.id',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as name"),
                'ipd.admission_id as ipd_no',
                'ipd.admission_date',
                'r.room_number as room',
                'd.name as doctor',
                'b.id as bill_id',
                DB::raw("IFNULL(b.status, 'interim') as status")
            )

            ->orderBy('ipd.created_at', 'desc')
            ->get();

        return view('admin.Accountant.Billing.index', compact('patients'));
    }

    /**
     * 🔹 CREATE
     */
    public function create()
    {
        $patients = DB::table('ipd_admissions as ipd')
            ->join('patients as p', 'p.id', '=', 'ipd.patient_id')
            ->select('ipd.id as ipd_id', 'p.name', 'ipd.admission_id')
            ->get();

        return view('admin.Accountant.Billing.create', compact('patients'));
    }

    /**
     * 🔹 STORE BILL
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $total = 0;

            foreach ($request->items as $item) {
                $total += $item['amount'];
            }

            $discount = $request->discount ?? 0;
            $tax = $request->tax ?? 0;

            $grandTotal = $total - $discount + $tax;

            // 🔹 Get Advance
            $ipd = DB::table('ipd_admissions')
                ->where('id', $request->ipd_id)
                ->first();

            $advance = $ipd->advance_amount ?? 0;

            $payable = max($grandTotal - $advance, 0);

            // 🔹 Create Bill
            $bill = IpdBill::create([
                'patient_id' => $request->patient_id,
                'ipd_id' => $request->ipd_id,
                'bill_no' => $this->generateBillNumber(),
                'bill_date' => Carbon::now(),
                'status' => 'interim',

                'total_amount' => $total,
                'discount' => $discount,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'payable_amount' => $payable,
            ]);

            // 🔹 Save Items
            foreach ($request->items as $item) {
                IpdBillItem::create([
                    'bill_id' => $bill->id,
                    'type' => $item['type'],
                    'reference_id' => $item['reference_id'] ?? null,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'rate' => $item['rate'],
                    'amount' => $item['amount'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.accountant.billing.index')
                ->with('success', 'Bill Created Successfully');

        } catch (\Exception $e) {

            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * 🔹 EDIT
     */
    public function edit($id)
    {
        $bill = IpdBill::with('items')->where('id', $id)->firstOrFail();

        return view('admin.Accountant.Billing.edit', compact('bill'));
    }

    /**
     * 🔹 VIEW
     */
    public function show($id)
    {
        $bill = IpdBill::with('items')->where('id', $id)->firstOrFail();

        return view('admin.Accountant.Billing.view', compact('bill'));
    }

    /**
     * 🔹 BILL NUMBER
     */
    private function generateBillNumber()
    {
        $count = IpdBill::count() + 1;
        return 'IPD-BILL-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }
}