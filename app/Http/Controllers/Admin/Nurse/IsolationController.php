<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IsolationRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IsolationController extends Controller
{
    public function index()
    {
        $records = IsolationRecord::with('patient')->latest()->get();
        return view('admin.nurse.isolation.index', compact('records'));
    }

    public function create()
    {
        $patients = DB::table('patients')->get();
        return view('admin.nurse.isolation.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'isolation_type' => 'required',
            'start_date' => 'required',
            'status' => 'required'
        ]);

        IsolationRecord::create([
            'id' => Str::uuid(),
            'patient_id' => $request->patient_id,
            'nurse_id' => 1,
            'isolation_type' => $request->isolation_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.isolation.index')->with('success', 'Added');
    }

    public function edit($id)
    {
        $record = IsolationRecord::findOrFail($id);
        $patients = DB::table('patients')->get();

        return view('admin.nurse.isolation.edit', compact('record', 'patients'));
    }

    public function update(Request $request, $id)
    {
        $record = IsolationRecord::findOrFail($id);

        $record->update($request->all());

        return redirect()->route('admin.isolation.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        IsolationRecord::findOrFail($id)->delete();
        return back()->with('success', 'Moved to trash');
    }

    public function trash()
    {
        $records = IsolationRecord::onlyTrashed()->get();
        return view('admin.nurse.isolation.trash', compact('records'));
    }

    public function restore($id)
    {
        IsolationRecord::withTrashed()->where('id', $id)->restore();
        return back()->with('success', 'Restored');
    }

    public function forceDelete($id)
    {
        IsolationRecord::withTrashed()->where('id', $id)->forceDelete();
        return back()->with('success', 'Deleted permanently');
    }
}