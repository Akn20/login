<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockController extends Controller
{
    // LIST STOCK
    public function index()
    {
        $batches = MedicineBatch::with('medicine')->latest()->get();
        return view('admin.pharmacy.stock.index', compact('batches'));
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.pharmacy.stock.create');
    }

    // STORE MEDICINE + OPENING STOCK
    public function store(Request $request)
    {
        $request->validate([
            'medicine_name' => 'required',
            'batch_number'  => 'required',
            'expiry_date'   => 'required|date',
            'quantity'      => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {

            $medicine = Medicine::create([
                'medicine_name' => $request->medicine_name,
                'generic_name'  => $request->generic_name,
                'category'      => $request->category,
                'manufacturer'  => $request->manufacturer,
                'status'        => $request->status ?? 1,
            ]);

            $batch = MedicineBatch::create([
                'medicine_id'   => $medicine->id,
                'batch_number'  => $request->batch_number,
                'expiry_date'   => $request->expiry_date,
                'purchase_price'=> $request->purchase_price ?? 0,
                'mrp'           => $request->mrp ?? 0,
                'quantity'      => $request->quantity,
                'reorder_level' => $request->reorder_level ?? 0,
                'status'        => $request->status ?? 1,
            ]);

            StockMovement::create([
                'medicine_id'  => $medicine->id,
                'batch_id'     => $batch->id,
                'movement_type'=> 'OPENING',
                'quantity'     => $request->quantity,
                'reference_id' => null,
            ]);

            DB::commit();

            return redirect()->route('admin.stock.index')
                ->with('success', 'Medicine created with opening stock.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error occurred.');
        }
    }

    // SHOW
    public function show($id)
    {
        $batch = MedicineBatch::with('medicine')->findOrFail($id);
        return view('admin.pharmacy.stock.show', compact('batch'));
    }

    // EDIT BATCH
    public function edit($id)
    {
        $batch = MedicineBatch::findOrFail($id);
        return view('admin.pharmacy.stock.edit', compact('batch'));
    }

    // UPDATE BATCH (NO quantity edit)
    public function update(Request $request, $id)
    {
        $batch = MedicineBatch::findOrFail($id);

        $request->validate([
            'batch_number'  => 'required|string|max:100',
            'expiry_date'   => 'required|date',
            'purchase_price'=> 'required|numeric|min:0',
            'mrp'           => 'required|numeric|min:0',
            'reorder_level' => 'required|integer|min:1',
            
        ]);

        $batch->update($request->only([
            'batch_number',
            'expiry_date',
            'purchase_price',
            'mrp',
            'reorder_level',
            
        ]));
       

        return redirect()->route('admin.stock.index')
            ->with('success', 'Stock Updated Successfully');
    }

    // DELETE
    public function destroy($id)
    {
        MedicineBatch::findOrFail($id)->delete();
        return redirect()->route('admin.stock.index');
    }

    // TRASH
    public function trash()
    {
        $batches = MedicineBatch::onlyTrashed()->with('medicine')->get();
        return view('admin.pharmacy.stock.trash', compact('batches'));
    }

    // RESTORE
    public function restore($id)
    {
        MedicineBatch::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.stock.index');
    }

    // FORCE DELETE
    public function forceDelete($id)
    {
        MedicineBatch::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.stock.index');
    }

    // LOW STOCK
    public function lowStock()
    {
        $batches = MedicineBatch::with('medicine')
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->get();

        return view('admin.pharmacy.stock.low', compact('batches'));
    }
}