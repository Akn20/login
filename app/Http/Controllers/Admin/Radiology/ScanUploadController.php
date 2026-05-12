<?php

namespace App\Http\Controllers\Admin\Radiology;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScanUpload;
use App\Models\ScanRequest;

class ScanUploadController extends Controller
{
    public function index()
    {
       $requests = ScanRequest::with('patient')->get();
    $uploads = ScanUpload::latest()->get(); // ✅ ADD THIS

    return view('admin.radiology.upload.index', compact('requests','uploads'));
    }

    

public function store(Request $request)
{
    $request->validate([
        'scan_request_id' => 'required',
        'files.*' => 'required|mimes:jpg,jpeg,png,pdf|max:10240'
    ]);

    if ($request->hasFile('files')) {

        foreach ($request->file('files') as $file) {

            $path = $file->store('radiology', 'public');

            ScanUpload::create([
                'scan_request_id' => $request->scan_request_id,
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'notes' => $request->notes
            ]);
        }

        // ✅ ADD THIS (IMPORTANT 🔥)
        ScanRequest::where('id', $request->scan_request_id)
            ->update(['status' => 'Uploaded']);
    }

    return back()->with('success', 'Files Uploaded Successfully');
}
public function view($id)
{
    $file = ScanUpload::findOrFail($id);

    return view('admin.radiology.upload.view', compact('file'));
}
}