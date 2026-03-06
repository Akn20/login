<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
class StockController extends Controller
{
    // LIST STOCK
    public function index()
    {
        $batches = MedicineBatch::with(['medicine','latestExpiryLog'])
            ->latest()
            ->get();
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
            'expiry_date' => 'required|date ', 
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

    //API
    public function apiIndex()
    {
         $batches = MedicineBatch::with(['medicine','latestExpiryLog'])
            ->latest()
            ->get();
        return ApiResponse::success($batches, 'Stock list retrieved successfully');
    }

    /* Get Single Stock (API) */
    public function apiShow($id)
    {
        $batch = MedicineBatch::with('medicine')->find($id);

        if (!$batch) {
            return ApiResponse::error('Stock not found');
        }

        $data = [
            'batch_id'       => $batch->id,
            'medicine_id'    => $batch->medicine_id,
            'medicine_name'  => $batch->medicine->medicine_name ?? null,
            'generic_name'   => $batch->medicine->generic_name ?? null,
            'category'       => $batch->medicine->category ?? null,
            'manufacturer'   => $batch->medicine->manufacturer ?? null,

            'batch_number'   => $batch->batch_number,
            'expiry_date'    => $batch->expiry_date,
            'quantity'       => (int) $batch->quantity,
            'purchase_price' => (float) $batch->purchase_price,
            'mrp'            => (float) $batch->mrp,
            'reorder_level'  => (int) $batch->reorder_level,

            'is_low_stock'   => $batch->quantity <= $batch->reorder_level,
            'is_expired'     => \Carbon\Carbon::parse($batch->expiry_date)->isPast(),
        ];

        return ApiResponse::success($data, 'Stock details retrieved successfully');
    }

    public function apiLowStock()
    {
        $batches = MedicineBatch::with('medicine')
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->latest()
            ->get();
            
        return ApiResponse::success(data: $batches, message: 'Low stock items fetched successfully');
    }
    /* Add Medicine + Opening Stock (API) */
    public function apiStore(Request $request)
    {
        $request->validate([
            'medicine_name'  => 'required|max:150',
            'generic_name'   => 'nullable|max:150',
            'category'       => 'nullable|max:100',
            'manufacturer'   => 'nullable|max:150',

            'batch_number'   => 'required|max:100',
            'expiry_date'    => 'required|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'mrp'            => 'nullable|numeric|min:0',
            'quantity'       => 'required|integer|min:1',
            'reorder_level'  => 'nullable|integer|min:0',
            'status'         => 'nullable|in:0,1',
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
            'medicine_id'    => $medicine->id,
            'batch_number'   => $request->batch_number,
            'expiry_date'    => $request->expiry_date,
            'purchase_price' => $request->purchase_price ?? 0,
            'mrp'            => $request->mrp ?? 0,
            'quantity'       => $request->quantity,
            'reorder_level'  => $request->reorder_level ?? 0,
            'status'         => $request->status ?? 1,
        ]);

        StockMovement::create([
            'medicine_id'   => $medicine->id,
            'batch_id'      => $batch->id,
            'movement_type' => 'OPENING',
            'quantity'      => $request->quantity,
            'reference_id'  => null,
        ]);

        DB::commit();

        $batch->load('medicine');

        return ApiResponse::success($batch, 'Stock created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Error occurred while creating stock');
        }
    }
    /* Update Stock Batch (API) */
    public function apiUpdate(Request $request, $id)
    {
        $batch = MedicineBatch::find($id);

        if (!$batch) {
            return ApiResponse::error('Stock not found');
        }

        $request->validate([
            'batch_number'   => 'required|string|max:100',
            'expiry_date'    => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'mrp'            => 'required|numeric|min:0',
            'reorder_level'  => 'required|integer|min:0',
        ]);

        $batch->update([
            'batch_number'   => $request->batch_number,
            'expiry_date'    => $request->expiry_date,
            'purchase_price' => $request->purchase_price,
            'mrp'            => $request->mrp,
            'reorder_level'  => $request->reorder_level,
        ]);

        return ApiResponse::success($batch, 'Stock updated successfully');
    }
    /* Delete Stock (Soft Delete API) */
    public function apiDestroy($id)
    {
        $batch = MedicineBatch::find($id);

        if (!$batch) {
            return ApiResponse::error('Stock not found');
        }

        $batch->delete();

        return ApiResponse::success(null, 'Stock deleted successfully');
    }
    /* Get Trash Stock (API) */
    public function apiTrash()
    {
        $batches = MedicineBatch::onlyTrashed()->with('medicine')->latest()->get();

        return ApiResponse::success($batches, 'Trash stock retrieved successfully');
    }
    public function apiRestore($id)
    {
        $batch = MedicineBatch::withTrashed()->find($id);

        if (!$batch) {
            return ApiResponse::error('Stock not found');
        }

        $batch->restore();

        return ApiResponse::success($batch, 'Stock restored successfully');
    }
    public function apiForceDelete($id)
    {
        $batch = MedicineBatch::withTrashed()->find($id);

        if (!$batch) {
            return ApiResponse::error('Stock not found');
        }

        $batch->forceDelete();

        return ApiResponse::success(null, 'Stock permanently deleted');
    }
    
}
