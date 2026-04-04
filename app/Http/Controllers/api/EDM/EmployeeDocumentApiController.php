<?php

namespace App\Http\Controllers\Api\EDM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeDocument;
use App\Models\Staff;
use Illuminate\Support\Facades\Storage;

class EmployeeDocumentApiController extends Controller
{
    // 📄 List all documents
    public function index()
    {
        $documents = EmployeeDocument::with('staff')->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $documents
        ]);
    }

    // 📄 Store document
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'document_type' => 'required',
            'file' => 'required|file',
        ]);

        $path = $request->file('file')->store('private_documents', 'local');

        $doc = EmployeeDocument::create([
            'staff_id' => $request->staff_id,
            'document_type' => $request->document_type,
            'file_path' => $path,
            'expiry_date' => $request->expiry_date,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Document uploaded successfully',
            'data' => $doc
        ]);
    }

    // 📄 Show single document
    public function show($id)
    {
        $doc = EmployeeDocument::with('staff')->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $doc
        ]);
    }

    // 📄 Update
    public function update(Request $request, $id)
    {
        $doc = EmployeeDocument::findOrFail($id);

        if ($request->hasFile('file')) {
            Storage::delete($doc->file_path);

            $path = $request->file('file')->store('private_documents', 'local');
            $doc->file_path = $path;
        }

        $doc->update([
            'staff_id' => $request->staff_id,
            'document_type' => $request->document_type,
            'expiry_date' => $request->expiry_date,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Document updated'
        ]);
    }

    // 📄 Delete
    public function destroy($id)
    {
        $doc = EmployeeDocument::findOrFail($id);

        Storage::delete($doc->file_path);
        $doc->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }

    // 📄 Download (for mobile)
    public function download($id)
    {
        $doc = EmployeeDocument::findOrFail($id);

        return response()->json([
            'status' => true,
            'file_url' => url('api/edm/file/'.$doc->id)
        ]);
    }

    // 📄 Serve file
    public function file($id)
    {
        $doc = EmployeeDocument::findOrFail($id);

        $path = storage_path('app/' . $doc->file_path);

        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->file($path);
    }
}
