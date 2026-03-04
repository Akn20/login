<?php

namespace App\Http\Controllers;

use App\Models\Expiry;
use App\Models\MedicineBatch;
use Illuminate\Http\Request;

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
}