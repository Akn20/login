<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expiry;
use Illuminate\Http\Request;
use App\Models\MedicineBatch;
use Carbon\Carbon;


class ExpiryController extends Controller
{
     // LIST: show expiring batches (<= 30 days) + existing expiry records
    public function index()
    {
        $limitDate = now()->addDays(30);

        $batches = MedicineBatch::with('medicine')
            ->whereDate('expiry_date', '<=', $limitDate)
            ->latest()
            ->get();

        $expiries = Expiry::with(['batch.medicine'])->latest()->get();

        return view('admin.pharmacy.expiry.index', compact('batches', 'expiries'));
    }
    
    // SHOW
    public function show($id)
    {  
        $batch = MedicineBatch::with('medicine')->findOrFail($id);
        $expiry = Expiry::where('batch_id', $batch->id)->latest()->first();
        return view('admin.pharmacy.expiry.show', compact('batch', 'expiry'));
    }

    // DELETE (soft delete)
    public function destroy($id)
    {
        Expiry::findOrFail($id)->delete();
        return redirect()->route('admin.expiry.index')->with('success', 'Expiry record deleted successfully.');
    }

    // TRASH
    public function trash()
    {
        $expiries = Expiry::onlyTrashed()->with(['batch.medicine'])->latest()->get();
        return view('admin.pharmacy.expiry.trash', compact('expiries'));
    }

    // RESTORE
    public function restore($id)
    {
        Expiry::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.expiry.index')->with('success', 'Expiry record restored successfully.');
    }

    // FORCE DELETE
    public function forceDelete($id)
    {
        Expiry::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.expiry.index')->with('success', 'Expiry record permanently deleted.');
    }

    // MARK EXPIRED (by expiry record id)
    public function markExpired($id)
    {
        $batch = MedicineBatch::findOrFail($id);

        $expiry = Expiry::firstOrCreate(
            ['batch_id' => $batch->id],
            [
                'expiry_date' => $batch->expiry_date,
                'quantity'    => $batch->quantity,
                'status'      => 'EXPIRING',
                'created_by'  => auth()->id(),
            ]
        );

        $expiry->update([
            'status'     => 'EXPIRED',
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Batch marked as EXPIRED.');
    }

    // RETURN TO VENDOR (sets PENDING)
    public function returnToVendor($id) 
    {
        $batch = MedicineBatch::findOrFail($id);

        $expiry = Expiry::where('batch_id', $batch->id)->latest()->first();

        if (!$expiry || $expiry->status !== 'EXPIRED') {
            return back()->with('error', 'Only EXPIRED batches can be returned to vendor.');
        }

        $expiry->update([
            'status'     => 'PENDING',
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Return request created (PENDING).');
    }

    // APPROVE RETURN
    public function approve($id) 
    {
        $expiry = Expiry::where('batch_id', $id)->latest()->first();

        if (!$expiry || $expiry->status !== 'PENDING') {
            return back()->with('error', 'Only PENDING returns can be approved.');
        }

        $expiry->update([
            'status'     => 'APPROVED',
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Return Approved.');
    }

    // COMPLETE RETURN
    public function complete($id) 
    {
        $expiry = Expiry::where('batch_id', $id)->latest()->first();

        if (!$expiry || $expiry->status !== 'APPROVED') {
            return back()->with('error', 'Only APPROVED returns can be completed.');
        }

        $expiry->update([
            'status'     => 'COMPLETED',
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Return Completed.');
    }
    
}