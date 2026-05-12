<?php

namespace App\Http\Controllers;

use App\Models\ControlledDrug;
use App\Models\ControlledDrugDispense;
use App\Models\ControlledDrugLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Vendor;
class ControlledDrugController extends Controller
{


    public function index()
    {

        $controlledDrugs =
            ControlledDrug::latest()->get();

        return view(
            'admin.pharmacy.controlledDrug.index',
            compact('controlledDrugs')
        );

    }



    public function create()
    {
        $vendors = Vendor::where('status', 'Active')->get();

        return view(
            'admin.pharmacy.controlledDrug.create',
            compact('vendors')
        );
    }



    public function store(Request $request)
    {

        $request->validate([

            'drug_name' => 'required',


            'batch_number' => 'required',

            'expiry_date' => 'required',

            'stock_quantity' => 'required',

            'supplier_id' => 'required|exists:vendors,id',
            'status' => 'required'

        ]);


        ControlledDrug::create([

            'controlled_drug_id' => Str::uuid(),

            'drug_name' => $request->drug_name,


            'batch_number' => $request->batch_number,

            'expiry_date' => $request->expiry_date,

            'stock_quantity' => $request->stock_quantity,

            'supplier_id' => $request->supplier_id,

            'status' => $request->status

        ]);


        return redirect()
            ->route('admin.controlledDrug.index')
            ->with('success', 'Controlled drug added');

    }



    public function show($id)
    {

        $drug = ControlledDrug::findOrFail($id);

        $drug->load(['dispenses', 'logs']);

        return view(
            'admin.pharmacy.controlledDrug.show',
            compact('drug')
        );

    }



    public function edit($id)
    {
        $drug = ControlledDrug::where('controlled_drug_id', $id)->firstOrFail();

        $vendors = Vendor::where('status', 'Active')->get();

        return view('admin.pharmacy.controlledDrug.edit', compact('drug', 'vendors'));
    }



    public function update(Request $request, $id)
    {

        $drug =
            ControlledDrug::findOrFail($id);


        $drug->update([

            'drug_name' => $request->drug_name,


            'batch_number' => $request->batch_number,

            'expiry_date' => $request->expiry_date,

            'stock_quantity' => $request->stock_quantity,

            'supplier_id' => $request->supplier_id,

            'status' => $request->status

        ]);


        return redirect()
            ->route('admin.controlledDrug.index')
            ->with('success', 'Updated successfully');

    }



    public function destroy($id)
    {

        ControlledDrug::findOrFail($id)
            ->delete();

        return redirect()
            ->route('admin.controlledDrug.index')
            ->with('success', 'Deleted successfully');

    }



    /* TRASH */


    public function trash()
    {

        $controlledDrugs =
            ControlledDrug::onlyTrashed()->get();

        return view(
            'admin.pharmacy.controlledDrug.trash',
            compact('controlledDrugs')
        );

    }



    public function restore($id)
    {

        ControlledDrug::withTrashed()
            ->findOrFail($id)
            ->restore();

        return redirect()
            ->route('admin.controlledDrug.trash');

    }



    public function forceDelete($id)
    {

        ControlledDrug::withTrashed()
            ->findOrFail($id)
            ->forceDelete();

        return redirect()
            ->route('admin.controlledDrug.trash');

    }



    /* DISPENSE */



    public function dispenseIndex()
    {
        $dispenses = ControlledDrugDispense::with('drug')
            ->latest()
            ->get();

        return view(
            'admin.pharmacy.controlledDrug.dispense_index',
            compact('dispenses')
        );
    }



    public function dispenseCreate()
    {
        $drugs = ControlledDrug::
            where('status', 'Active')
            ->whereNull('deleted_at')
            ->get();

        return view(
            'admin.pharmacy.controlledDrug.dispense',
            compact('drugs')
        );
    }



    public function dispenseStore(Request $request)
    {

        $drug = ControlledDrug::
            findOrFail($request->controlled_drug_id);


        /* STOCK VALIDATION */

        if ($request->quantity_dispensed > $drug->stock_quantity) {

            return back()
                ->withErrors([
                    'quantity_dispensed' => 'Quantity exceeds available stock'
                ])
                ->withInput();

        }


        /* DATE VALIDATION */

        if ($request->dispense_date > $drug->expiry_date) {

            return back()
                ->withErrors([
                    'dispense_date' => 'Dispense date cannot exceed expiry date'
                ])
                ->withInput();

        }


        /* SAVE DISPENSE */

        ControlledDrugDispense::create([

            'dispense_id' => Str::uuid(),

            'controlled_drug_id' => $request->controlled_drug_id,

            'patient_id' => $request->patient_id,

            'prescription_id' => $request->prescription_id,

            'quantity_dispensed' => $request->quantity_dispensed,

            'dispense_date' => $request->dispense_date,

            'pharmacist_id' => $request->pharmacist_id

        ]);


        /* UPDATE STOCK */

        $drug->stock_quantity -= $request->quantity_dispensed;

        $drug->save();


        /* CREATE LOG */

        ControlledDrugLog::create([

            'log_id' => Str::uuid(),

            'controlled_drug_id' => $request->controlled_drug_id,

            'transaction_type' => "Dispensed",

            'quantity' => $request->quantity_dispensed,

            'transaction_date' => $request->dispense_date,

            'pharmacist_id' => $request->pharmacist_id

        ]);


        return redirect()
            ->route('admin.controlledDrug.dispenseIndex')
            ->with('success', 'Drug dispensed successfully');

    }



    /* LOG */


    public function log()
    {

        $logs = ControlledDrugLog::
            with('drug')
            ->latest()
            ->get();

        return view(
            'admin.pharmacy.controlledDrug.log',
            compact('logs')
        );

    }

    //API Functions for mobile app

    public function apiIndex()
    {
        $drugs = ControlledDrug::
            with('vendor:id,vendor_name')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Controlled drugs fetched',
            'data' => $drugs
        ]);
    }

    public function apiShow($id)
    {
        $drug = ControlledDrug::
            with('vendor:id,vendor_name')
            ->where('controlled_drug_id', $id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $drug
        ]);
    }

    public function apiStore(Request $request)
    {
        $drug = ControlledDrug::create([

            'controlled_drug_id' => Str::uuid(),

            'drug_name' => $request->drug_name,

            'batch_number' => $request->batch_number,

            'expiry_date' => $request->expiry_date,

            'stock_quantity' => $request->stock_quantity,

            'supplier_id' => $request->supplier_id,

            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Drug created',
            'data' => $drug
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $drug = ControlledDrug::
            where('controlled_drug_id', $id)
            ->firstOrFail();

        $drug->update([

            'drug_name' => $request->drug_name,

            'batch_number' => $request->batch_number,

            'expiry_date' => $request->expiry_date,

            'stock_quantity' => $request->stock_quantity,

            'supplier_id' => $request->supplier_id,

            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Drug updated',
            'data' => $drug
        ]);
    }

    public function apiDestroy($id)
    {
        $drug = ControlledDrug::
            where('controlled_drug_id', $id)
            ->firstOrFail();

        $drug->delete();

        return response()->json([
            'success' => true,
            'message' => 'Drug deleted'
        ]);
    }

    public function apiTrash()
    {
        $drugs = ControlledDrug::
            onlyTrashed()
            ->with('vendor:id,vendor_name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $drugs
        ]);
    }

    public function apiRestore($id)
    {
        $drug = ControlledDrug::
            withTrashed()
            ->where('controlled_drug_id', $id)
            ->firstOrFail();

        $drug->restore();

        return response()->json([
            'success' => true,
            'message' => 'Drug restored'
        ]);
    }

    public function apiForceDelete($id)
    {
        $drug = ControlledDrug::
            withTrashed()
            ->where('controlled_drug_id', $id)
            ->firstOrFail();

        $drug->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Drug permanently deleted'
        ]);
    }

    public function apiDispense()
    {
        $records = ControlledDrugDispense::with('controlledDrug')
            ->latest()
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Dispense records fetched',
            'data' => $records
        ]);
    }

    public function apiStoreDispense(Request $request)
    {
        $request->validate([
            'controlled_drug_id' => 'required',
            'patient_id' => 'required',
            'prescription_id' => 'required',
            'quantity_dispensed' => 'required|integer|min:1',
            'dispense_date' => 'required|date',
            'pharmacist_id' => 'required'
        ]);

        // Get drug
        $drug = ControlledDrug::where('controlled_drug_id', $request->controlled_drug_id)->firstOrFail();

        // Check stock
        if ($request->quantity_dispensed > $drug->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Dispense quantity exceeds available stock'
            ], 400);
        }

        // 1️⃣ Create dispense record
        $dispense = ControlledDrugDispense::create([
            'dispense_id' => Str::uuid(),
            'controlled_drug_id' => $request->controlled_drug_id,
            'patient_id' => $request->patient_id,
            'prescription_id' => $request->prescription_id,
            'quantity_dispensed' => $request->quantity_dispensed,
            'dispense_date' => $request->dispense_date,
            'pharmacist_id' => $request->pharmacist_id
        ]);

        // 2️⃣ Reduce stock
        $drug->stock_quantity = $drug->stock_quantity - $request->quantity_dispensed;
        $drug->save();

        // 3️⃣ Insert log
        ControlledDrugLog::create([
            'log_id' => Str::uuid(),
            'controlled_drug_id' => $request->controlled_drug_id,
            'transaction_type' => 'Dispensed',
            'quantity' => $request->quantity_dispensed,
            'transaction_date' => $request->dispense_date,
            'pharmacist_id' => $request->pharmacist_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Drug dispensed successfully',
            'data' => $dispense
        ]);
    }

    public function apiDrugLog()
    {
        $logs = ControlledDrugLog::with([
            'controlledDrug:controlled_drug_id,drug_name,batch_number'
        ])
            ->latest()
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Drug logs fetched',
            'data' => $logs
        ]);
    }

}