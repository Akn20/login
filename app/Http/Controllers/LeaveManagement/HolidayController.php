<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $holidays = Holiday::latest()->paginate(10);
        if (request()->wantsJson()) {
            $holidays = Holiday::latest()->get();
            return response()->json([
                'success' => true,
                'data' => $holidays,
            ]);
        }
        return view(
            'admin.Leave_Management.holidays.index',
            compact('holidays')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Leave_Management.holidays.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'details' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status' => 'required|boolean',
        ]);

        // File Upload (if exists)
        $filePath = null;

        if ($request->hasFile('document')) {
            $filePath = $request->file('document')->store('holidays', 'public');
        }

        //  Create Holiday
        Holiday::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'details' => $request->details,
            'document' => $filePath,
            'status' => $request->status,
        ]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Holiday created successfully!',
            ]);
        }
        return redirect()
            ->route('admin.holidays.index')
            ->with('success', 'Holiday created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $holiday = Holiday::findOrFail($id);
        return view('admin.Leave_Management.holidays.show', compact('holiday'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $holiday = Holiday::findOrFail($id);
        return view('admin.Leave_Management.holidays.edit', compact('holiday'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $holiday = Holiday::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'details' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Name must match your form
            'status' => 'required|in:0,1', // Matches your select values 0 and 1
        ]);

        // Update basic fields
        $holiday->name = $request->name;
        $holiday->start_date = $request->start_date;
        $holiday->end_date = $request->end_date;
        $holiday->details = $request->details;
        $holiday->status = $request->status;

        // Handle File Update
        if ($request->hasFile('document')) {
            $holiday->document = $request->file('document')->store('holidays', 'public');
        }

        $holiday->save();
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Holiday updated successfully!',
            ]);
        }
        // Straight to dashboard as requested
        return redirect()->route('admin.holidays.index')->with('success', 'Holiday updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->delete(); // This performs a soft delete
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Holiday moved to trash successfully!',
            ]);
        }
        // You MUST redirect back to the list
        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday moved to trash successfully!');
    }
    public function deleted()
    {
        // Fetch only soft-deleted holidays
        $holidays = Holiday::onlyTrashed()->get();
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $holidays,
            ]);
        }
        return view('admin.Leave_Management.holidays.deleted', compact('holidays'));
    }

    public function restore($id)
    {
        // Find the deleted holiday and bring it back
        $holiday = Holiday::onlyTrashed()->findOrFail($id);
        $holiday->restore();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Holiday restored successfully!',
            ]);
        }
        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday restored successfully!');
    }
    public function forceDelete($id)
    {
        // Find the holiday in the trash
        $holiday = Holiday::onlyTrashed()->findOrFail($id);

        // Completely remove from database
        $holiday->forceDelete();
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Holiday permanently deleted.',
            ]);
        }
        return redirect()->route('admin.holidays.deleted')
            ->with('success', 'Holiday permanently deleted.');
    }
    public function toggleStatus($id)
    {
        $holiday = Holiday::findOrFail($id);

        // Toggle between 1 and 0 (or 'active'/'inactive')
        $holiday->status = $holiday->status == 1 ? 0 : 1;
        $holiday->save();
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'status' => $holiday->status,
            ]);
        }
        return redirect()->back();
    }
}