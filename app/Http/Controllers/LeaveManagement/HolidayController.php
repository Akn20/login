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
    $data = $request->validate([
        'name'       => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date',
        'details'    => 'nullable|string',
        'document'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'status'     => 'required|in:active,inactive', // Matches Weekend style
    ],[
        // Custom error message for the user
        'end_date.after_or_equal' => 'The end date must be a date after or equal to the start date.',
    ]);

    if ($request->hasFile('document')) {
        $data['document'] = $request->file('document')->store('holidays', 'public');
    }

    $holiday = Holiday::create($data);

    if ($request->wantsJson()) {
        return response()->json(['success' => true, 'data' => $holiday], 201);
    }
    return redirect()->route('hr.holidays.index')->with('success', 'Created!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $holiday = Holiday::findOrFail($id);
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $holiday,
            ]);
        }
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

    // Use 'sometimes' so it doesn't fail if you only update one field
    $data = $request->validate([
        'name'       => 'sometimes|string|max:255',
        'start_date' => 'sometimes|date',
        'end_date'   => 'sometimes|date|after_or_equal:start_date',
        'status'     => 'sometimes|in:active,inactive',
        
    ],[
        // Custom error message for the user
        'end_date.after_or_equal' => 'The end date must be a date after or equal to the start date.',
    ]);

    // Update the database fields
    $holiday->update($request->only(['name', 'start_date', 'end_date', 'status', 'details']));

    // Save document only if a new one is provided
    if ($request->hasFile('document')) {
        $holiday->document = $request->file('document')->store('holidays', 'public');
        $holiday->save();
    }
    if ($request->wantsJson()) {
    return response()->json([
        'success' => true,
        'message' => 'Holiday updated successfully!']);
    }
    return redirect()->route('hr.holidays.index')->with('success', 'Holiday updated successfully!');

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
        return redirect()->route('hr.holidays.index')
            ->with('success', 'Holiday moved to trash successfully!');
    }
public function deleted()
{
    $holidays = Holiday::onlyTrashed()->latest()->get();

    if (request()->wantsJson()) {
        return response()->json(['success' => true, 'data' => $holidays]);
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
        return redirect()->route('hr.holidays.index')
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
        return redirect()->route('hr.holidays.deleted')
            ->with('success', 'Holiday permanently deleted.');
    }
   public function toggleStatus($id)
{
    $holiday = Holiday::findOrFail($id);
    
    // Toggle between the two allowed strings
    $holiday->status = ($holiday->status === 'active') ? 'inactive' : 'active';
    $holiday->save();

    return back()->with('success', 'Status updated successfully!');
}
}