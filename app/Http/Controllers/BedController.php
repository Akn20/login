<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bed;
use App\Models\Ward;
use Illuminate\Validation\Rule;  
class BedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beds = Bed::with('ward')->latest()->get();
        return view('admin.beds.index', compact('beds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $wards = Ward::all();
        $bed =null;
        return view('admin.beds.create', compact('wards','bed'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        
        'bed_code' => 'required|string|max:100|unique:beds,bed_code',
        'ward_id' => 'required|uuid|exists:wards,id',
        'room_number' => 'nullable|string|max:50',
        'bed_type' => 'required|string',
        'status' => 'required|string',
    ]);

   
    Bed::create($validated);

    return redirect()
        ->route('admin.beds.index')
        ->with('success', 'Bed created successfully');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
    {
        $bed = Bed::findOrFail($id);
        $wards = Ward::all();

        return view('admin.beds.edit', compact('bed', 'wards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
            $bed = Bed::findOrFail($id);

            $validated = $request->validate([
                'bed_code' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('beds', 'bed_code')->ignore($bed->id),
                ],
                'ward_id' => 'required|uuid|exists:wards,id',
                'room_number' => 'nullable|string|max:50',
                'bed_type' => 'required|string',
                'status' => 'required|string',
            ]);

            $bed->update($validated);

            return redirect()
                ->route('admin.beds.index')
                ->with('success', 'Bed updated successfully');
        

    }


    /**
     * Suggest BedCode based on ward
     */
    public function generateCode($wardId)
    {
        $ward = Ward::findOrFail($wardId);

        // Create prefix from ward name (first 3 letters uppercase)
        $prefix = strtoupper(substr($ward->ward_name, 0, 3));

        // Count existing beds in that ward
        $count = Bed::where('ward_id', $wardId)->count() + 1;

        $number = str_pad($count, 3, '0', STR_PAD_LEFT);

        $code = $prefix . '-' . $number;

        return response()->json(['code' => $code]);
    }

    /**
     * Soft delete
     */
    public function deleted()

    {
        $beds = Bed::onlyTrashed()->with('ward')->latest()->get();
        return view('admin.beds.deleted', compact('beds'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bed = Bed::where('id',$id)->firstOrFail();
        $bed->delete();   // This will soft delete

        return redirect()
            ->route('admin.beds.index')
            ->with('success', 'Bed moved to trash successfully');
    }

    // Restore
    public function restore($id)
    {
        $bed = Bed::onlyTrashed()->findOrFail($id);
        $bed->restore();

        return redirect()
            ->route('admin.beds.deleted')
            ->with('success', 'Bed restored successfully.');
    }


    // Permanent Delete
    public function forceDelete($id)
    {
        $bed = Bed::onlyTrashed()->findOrFail($id);
        $bed->forceDelete();

        return redirect()
            ->route('admin.beds.deleted')
            ->with('success', 'Bed permanently deleted.');
    }

    //Api to get beds by ward
    public function apiIndex()
    {
        $beds = Bed::with('ward')->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $beds
        ]);
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'bed_code' => 'required|string|max:100|unique:beds,bed_code',
            'ward_id' => 'required|uuid|exists:wards,id',
            'room_number' => 'nullable|string|max:50',
            'bed_type' => 'required|string',
            'status' => 'required|string',
        ]);

        $bed = Bed::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Bed created successfully',
            'data' => $bed
        ], 201);
    }

    public function apiShow($id)
    {
        $bed = Bed::with('ward')->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $bed
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $bed = Bed::findOrFail($id);

        $validated = $request->validate([
            'bed_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('beds', 'bed_code')->ignore($bed->id),
            ],
            'ward_id' => 'required|uuid|exists:wards,id',
            'room_number' => 'nullable|string|max:50',
            'bed_type' => 'required|string',
            'status' => 'required|string',
        ]);

        $bed->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Bed updated successfully',
            'data' => $bed
        ]);
    }

    public function apiDestroy($id)
    {
        $bed = Bed::findOrFail($id);
        $bed->delete();

        return response()->json([
            'status' => true,
            'message' => 'Bed deleted successfully'
        ]);
    }

    public function forceDeleteApi($id)
    {
        $bed = Bed::onlyTrashed()->findOrFail($id);
        $bed->forceDelete();

        return response()->json([
            'status' => true,
            'message' => 'Bed permanently deleted'
        ]);
    }
}
