<?php

namespace App\Http\Controllers\HR\EDM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeDocument;

class EmployeeDocumentController extends Controller
{
    public function create()
    {
         $employees = \App\Models\Staff::all();
        return view('hr.EDM.create', compact('employees'));
    }
   public function index(Request $request)
    {
        $query = EmployeeDocument::with('staff');

        // Search by employee name
        if ($request->employee_name) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        // Filter by document type
        if ($request->document_type) {
            $query->where('document_type', $request->document_type);
        }

        $documents = $query->latest()->get();

        return view('hr.EDM.index', compact('documents'));
    }

    public function destroy($id)
    {
        $doc = EmployeeDocument::findOrFail($id);

        // Delete file from storage
        \Storage::delete($doc->file_path);

        $doc->delete();

        return redirect()->back()->with('success', 'Document deleted!');
    }

    public function download($id)
{
    $doc = EmployeeDocument::findOrFail($id);

    // ✅ FIX PATH (based on your folder structure)
    $filePath = storage_path('app/private/' . $doc->file_path);

    if (!file_exists($filePath)) {
        return back()->with('error', 'File not found!');
    }

    return response()->download($filePath);
}
 // Store Document
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'document_type' => 'required',
            'file' => 'required|file|max:5120',
        ]);

        // Store file securely
        $path = $request->file('file')->store('private_documents', 'local');

        EmployeeDocument::create([
            'staff_id' => $request->staff_id,
            'document_type' => $request->document_type,
            'file_path' => $path,
            'expiry_date' => $request->expiry_date,
            'uploaded_by' => auth()->id(),
        ]);

        // Save & Add Another logic
        if ($request->has('save_add_another')) {
            return redirect()->back()
                ->with('employee_id', $request->staff_id)
                ->with('success', 'Document uploaded!');
        }

        return redirect()->route('hr.edm.index')
            ->with('success', 'Document uploaded successfully!');
    }

    public function edit($id)
{
    $document = EmployeeDocument::findOrFail($id);
    $employees = \App\Models\Staff::all();

    return view('hr.EDM.edit', compact('document', 'employees'));
}

public function update(Request $request, $id)
{
    $doc = EmployeeDocument::findOrFail($id);

    $request->validate([
        'staff_id' => 'required',
        'document_type' => 'required',
         'file' => 'nullable|file|max:10240',
    ]);

    if ($request->hasFile('file')) {
        \Storage::delete($doc->file_path);

        $path = $request->file('file')->store('private_documents');

        $doc->file_path = $path;
    }

    $doc->update([
        'staff_id' => $request->staff_id,
        'document_type' => $request->document_type,
        'expiry_date' => $request->expiry_date,
    ]);

    return redirect()->route('hr.edm.index')->with('success', 'Document updated!');
}
}
