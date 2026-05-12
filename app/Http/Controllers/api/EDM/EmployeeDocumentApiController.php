<?php

namespace App\Http\Controllers\Api\EDM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeDocumentApiController extends Controller
{
    /**
     * 📄 List documents (with pagination)
     */
    public function index(Request $request)
    {
        $documents = EmployeeDocument::with('staff')
            ->latest()
            ->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Documents fetched successfully',
            'data' => $documents
        ]);
    }

    /**
     * 📄 Store document
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required|exists:staff,id',
            'document_type' => 'required|string|max:100',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120', // 5MB
            'expiry_date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Store file
        $path = $request->file('file')->store('private_documents');

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

    /**
     * 📄 Show single document
     */
    public function show($id)
    {
        $doc = EmployeeDocument::with('staff')->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $doc
        ]);
    }

    /**
     * 📄 Update document
     */
    public function update(Request $request, $id)
    {
        $doc = EmployeeDocument::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'staff_id' => 'required|exists:staff,id',
            'document_type' => 'required|string|max:100',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'expiry_date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Replace file if new uploaded
        if ($request->hasFile('file')) {
            if ($doc->file_path && Storage::exists($doc->file_path)) {
                Storage::delete($doc->file_path);
            }

            $doc->file_path = $request->file('file')->store('private_documents');
        }

        $doc->update([
            'staff_id' => $request->staff_id,
            'document_type' => $request->document_type,
            'expiry_date' => $request->expiry_date,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Document updated successfully',
            'data' => $doc
        ]);
    }

    /**
     * 📄 Delete document
     */
    public function destroy($id)
    {
        $doc = EmployeeDocument::findOrFail($id);

        if ($doc->file_path && Storage::exists($doc->file_path)) {
            Storage::delete($doc->file_path);
        }

        $doc->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }

    /**
     * 📄 Download file (direct download)
     */
    public function download($id)
    {
        $doc = EmployeeDocument::findOrFail($id);

        if (!Storage::exists($doc->file_path)) {
            return response()->json([
                'status' => false,
                'message' => 'File not found'
            ], 404);
        }

        return Storage::download($doc->file_path);
    }

    /**
     * 📄 View file in browser (for mobile preview)
     */
    public function view($id)
    {
        $doc = EmployeeDocument::findOrFail($id);

        if (!Storage::exists($doc->file_path)) {
            return response()->json([
                'status' => false,
                'message' => 'File not found'
            ], 404);
        }

        return response()->file(storage_path('app/' . $doc->file_path));
    }
    // ===============================
// GET EMPLOYEES FOR DROPDOWN
// ===============================
public function employees()
{
    $employees = \App\Models\Staff::select('id', 'name')
        ->orderBy('name')
        ->get();

    return response()->json([
        'status' => true,
        'data' => $employees
    ]);
}
}