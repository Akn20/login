<?php

namespace App\Http\Controllers\Admin\Radiology;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScanType;

class ScanTypeController extends Controller
{
    public function index()
    {
        $scanTypes = ScanType::latest()->get();
        return view('admin.radiology.scan-types.index', compact('scanTypes'));
    }

    public function create()
    {
        return view('admin.radiology.scan-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:scan_types,name',
            'status' => 'required'
        ]);

        ScanType::create($request->all());

        return redirect()->route('admin.radiology.scan-types.index')
            ->with('success', 'Scan Type Created Successfully');
    }

    public function edit($id)
    {
        $scanType = ScanType::findOrFail($id);
        return view('admin.radiology.scan-types.edit', compact('scanType'));
    }

    public function update(Request $request, $id)
    {
        $scanType = ScanType::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:scan_types,name,' . $id,
            'status' => 'required'
        ]);

        $scanType->update($request->all());

        return redirect()->route('admin.radiology.scan-types.index')
            ->with('success', 'Scan Type Updated Successfully');
    }

    public function destroy($id)
    {
        $scanType = ScanType::findOrFail($id);
        $scanType->delete();

        return back()->with('success', 'Deleted Successfully');
    }
}
