<?php

namespace App\Http\Controllers;

use App\Models\Expiry;
use App\Models\MedicineBatch;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpiryController extends Controller
{

    public function index()
    {
        $limitDate = now()->addDays(30);

        $batches = MedicineBatch::with(['medicine','latestExpiryLog'])
            ->whereDate('expiry_date','<=',$limitDate)
            ->latest()
            ->get();

        return view('admin.pharmacy.expiry.index', compact('batches'));
    }

    public function show($id)
    {
        $batch = MedicineBatch::with('medicine')->findOrFail($id);

        $expiryLog = Expiry::where('batch_id',$id)->latest()->first();

        return view('admin.pharmacy.expiry.show',compact('batch','expiryLog'));
    }


    /*
    |--------------------------------------------------------------------------
    | MARK EXPIRED
    |--------------------------------------------------------------------------
    */

    public function markExpired($id)
    {
        $batch = MedicineBatch::findOrFail($id);

        $expiry = Expiry::firstOrCreate(
            ['batch_id' => $batch->id],
            [
                'expiry_date' => $batch->expiry_date,
                'quantity' => $batch->quantity,
                'status' => 'EXPIRED',
                'created_by' => auth()->id()
            ]
        );

        $expiry->update([
            'status' => 'EXPIRED'
        ]);

        return back()->with('success','Batch marked as EXPIRED.');
    }


    /*
    |--------------------------------------------------------------------------
    | RETURN TO VENDOR
    |--------------------------------------------------------------------------
    */

public function returnToVendor($id)
{
    $batch = MedicineBatch::findOrFail($id);

    $expiry = Expiry::firstOrCreate(
        ['batch_id' => $batch->id],
        [
            'expiry_date' => $batch->expiry_date,
            'quantity' => $batch->quantity,
            'status' => 'EXPIRED'
        ]
    );

    if ($expiry->status !== 'EXPIRED') {
        return back()->with('error', 'Only expired batches can be returned.');
    }

    $expiry->update([
        'status' => 'PENDING',
        'updated_by' => auth()->id(),
    ]);

    return back()->with('success', 'Return request created.');
}

    /*
    |--------------------------------------------------------------------------
    | APPROVE RETURN
    |--------------------------------------------------------------------------
    */

    public function approve($id)
    {
        $expiry = Expiry::where('batch_id',$id)->latest()->first();

        if(!$expiry || $expiry->status !== 'PENDING'){
            return back()->with('error','Only pending returns can be approved.');
        }

        $expiry->update([
            'status' => 'APPROVED',
            'updated_by' => auth()->id()
        ]);

        return back()->with('success','Return approved.');
    }


    /*
    |--------------------------------------------------------------------------
    | COMPLETE RETURN
    |--------------------------------------------------------------------------
    */

public function complete($id)
{
    $expiry = Expiry::where('batch_id', $id)->latest()->first();

    if (!$expiry || $expiry->status !== 'APPROVED') {
        return back()->with('error', 'Only approved returns can be completed.');
    }

    $batch = MedicineBatch::findOrFail($id);

    $expiry->update([
        'status' => 'COMPLETED',
        'updated_by' => auth()->id(),
    ]);

    // Reduce stock
    $batch->update([
        'quantity' => 0
    ]);

    return back()->with('success', 'Return completed and stock adjusted.');
}


    /*
    |--------------------------------------------------------------------------
    | TRASH
    |--------------------------------------------------------------------------
    */

    public function trash()
    {
        $logs = Expiry::onlyTrashed()->with(['batch.medicine'])->latest()->get();

        return view('admin.pharmacy.expiry.trash',compact('logs'));
    }


    public function restore($id)
    {
        Expiry::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success','Record restored.');
    }


    public function forceDelete($id)
    {
        Expiry::onlyTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success','Record permanently deleted.');
    }

    
    /* =========================================================
   API endpoints
   ========================================================= */


    public function apiIndex()
    {
        $limitDate = now()->addDays(30);

        $batches = MedicineBatch::with(['medicine','latestExpiryLog'])
            ->whereDate('expiry_date', '<=', $limitDate)
            ->latest()
            ->get()
            ->map(function ($batch) {

                $exp = Carbon::parse($batch->expiry_date);
                $log = $batch->latestExpiryLog ?? null;

                $status = $log->status ?? ($exp->isPast() ? 'EXPIRED' : 'EXPIRING');

                return [
                    'batch_id'     => $batch->id,
                    'medicine_id'  => $batch->medicine_id,
                    'medicine'     => $batch->medicine->medicine_name ?? null,
                    'batch_number' => $batch->batch_number,
                    'expiry_date'  => $exp->format('Y-m-d'),
                    'quantity'     => (int) $batch->quantity,
                    'days_left'    => $exp->isPast() ? 0 : now()->diffInDays($exp),
                    'status'       => $status,
                ];
            });

        return ApiResponse::success($batches, 'Expiry list retrieved successfully');
    }

    public function apiShow($batchId)
    {
        $batch = MedicineBatch::with(['medicine','latestExpiryLog'])->find($batchId);

        if (!$batch) {
            return ApiResponse::error('Batch not found');
        }

        $exp = Carbon::parse($batch->expiry_date);
        $log = $batch->latestExpiryLog ?? null;

        $status = $log->status ?? ($exp->isPast() ? 'EXPIRED' : 'EXPIRING');

        $data = [
            'batch_id'      => $batch->id,
            'medicine_id'   => $batch->medicine_id,
            'medicine'      => $batch->medicine->medicine_name ?? null,
            'batch_number'  => $batch->batch_number,
            'expiry_date'   => $exp->format('Y-m-d'),
            'quantity'      => (int) $batch->quantity,
            'status'        => $status,
            'remarks'       => $log->remarks ?? null,
            'log_id'        => $log->id ?? null,
            'updated_at'    => $log->updated_at ?? null,
        ];

        return ApiResponse::success($data, 'Expiry details retrieved successfully');
    }


    public function apiMarkExpired($batchId)
    {
        $batch = MedicineBatch::find($batchId);

        if (!$batch) {
            return ApiResponse::error('Batch not found');
        }

        // create log if missing
        $log = Expiry::firstOrCreate(
            ['batch_id' => $batch->id],
            [
                'expiry_date' => $batch->expiry_date,
                'quantity'    => $batch->quantity, // remove if column not present
                'status'      => 'EXPIRED',
                'created_by'  => 1,
            ]
        );

        $log->update([
            'status'     => 'EXPIRED',
            'updated_by' => 1,
        ]);

        return ApiResponse::success($log, 'Batch marked as EXPIRED');
    }

    public function apiReturnToVendor($batchId, Request $request)
    {
        $batch = MedicineBatch::find($batchId);

        if (!$batch) {
            return ApiResponse::error('Batch not found');
        }

        $log = Expiry::where('batch_id', $batch->id)->latest()->first();

        if (!$log || $log->status !== 'EXPIRED') {
            return ApiResponse::error('Only EXPIRED batches can be returned');
        }

        $log->update([
            'status'     => 'PENDING',
            'remarks'    => $request->remarks ?? $log->remarks,
            'updated_by' => 1,
        ]);

        return ApiResponse::success($log, 'Return request created (PENDING)');
    }

    public function apiApprove($batchId)
    {
        $log = Expiry::where('batch_id', $batchId)->latest()->first();

        if (!$log) {
            return ApiResponse::error('Expiry log not found');
        }

        if ($log->status !== 'PENDING') {
            return ApiResponse::error('Only PENDING returns can be approved');
        }

        $log->update([
            'status'     => 'APPROVED',
            'updated_by' => 1,
        ]);

        return ApiResponse::success($log, 'Return approved successfully');
    }

    public function apiComplete($batchId)
    {
        $log = Expiry::where('batch_id', $batchId)->latest()->first();

        if (!$log) {
            return ApiResponse::error('Expiry log not found');
        }

        if ($log->status !== 'APPROVED') {
            return ApiResponse::error('Only APPROVED returns can be completed');
        }

        DB::beginTransaction();
        try {
            $log->update([
                'status'     => 'COMPLETED',
                'updated_by' => 1,
            ]);

            MedicineBatch::where('id', $batchId)->update(['quantity' => 0]);
            DB::commit();

            return ApiResponse::success($log, 'Return completed and stock adjusted');

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Error occurred while completing return');
        }
    }

    public function apiTrash()
    {
        $logs = Expiry::onlyTrashed()
            ->with(['batch.medicine'])
            ->latest()
            ->get()
            ->map(function ($log) {
                return [
                    'log_id'       => $log->id,
                    'batch_id'     => $log->batch_id,
                    'medicine'     => $log->batch->medicine->medicine_name ?? null,
                    'batch_number' => $log->batch->batch_number ?? null,
                    'status'       => $log->status,
                    'deleted_at'   => $log->deleted_at,
                ];
            });

        return ApiResponse::success($logs, 'Deleted expiry logs retrieved successfully');
    }

    public function apiRestore($id)
    {
        $log = Expiry::onlyTrashed()->find($id);

        if (!$log) {
            return ApiResponse::error('Log not found');
        }
        $log->restore();

        return ApiResponse::success($log, 'Log restored successfully');
    }

    public function apiForceDelete($id)
    {
        $log = Expiry::onlyTrashed()->find($id);

        if (!$log) {
            return ApiResponse::error('Log not found');
        }

        $log->forceDelete();

        return ApiResponse::success(null, 'Log permanently deleted');
    }
}