<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::with('institution')->paginate(15);
        $totalHospitals = Hospital::count();
        $activeHospitals = Hospital::where('status', true)->count();
        $inactiveHospitals = Hospital::where('status', false)->count();
        return view('admin.hospitals.index', compact('hospitals', 'totalHospitals', 'activeHospitals', 'inactiveHospitals'));
    }

    public function create()
    {
        $institutions = Institution::orderBy('name')->get();
        return view('admin.hospitals.create', compact('institutions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:hospitals,code',
            'institution_id' => 'required|exists:institutions,id',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|string|max:20',
            'status' => 'required|boolean',
        ]);

        $data['id'] = (string) Str::uuid();

        Hospital::create($data);

        return redirect()
            ->route('admin.hospitals.index')
            ->with('success', 'Hospital created successfully.');
    }

    public function edit(Hospital $hospital)
    {
        $institutions = Institution::orderBy('name')->get();
        return view('admin.hospitals.edit', compact('hospital', 'institutions'));
    }

    public function update(Request $request, Hospital $hospital)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:hospitals,code,' . $hospital->id . ',id',
            'institution_id' => 'required|exists:institutions,id',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|string|max:20',
            'status' => 'required|boolean',
        ]);

        $hospital->update($data);

        return redirect()
            ->route('admin.hospitals.index')
            ->with('success', 'Hospital updated successfully.');
    }

    public function destroy(Hospital $hospital)
    {
        $hospital->delete();

        return redirect()
            ->route('admin.hospitals.index')
            ->with('success', 'Hospital deleted successfully.');
    }

    public function toggleStatus(Hospital $id)
    {
        $hospital = $id; 
        $hospital->status = !$hospital->status;
        $hospital->save();

        $totalHospitals = Hospital::count();
        $activeHospitals = Hospital::where('status', true)->count();
        $inactiveHospitals = Hospital::where('status', false)->count();

        return response()->json([
            'success' => true,
            'status' => $hospital->status ? 'active' : 'inactive',
            'is_active' => (bool) $hospital->status,
            'totalHospitals' => $totalHospitals,
            'activeHospitals' => $activeHospitals,
            'inactiveHospitals' => $inactiveHospitals
        ]);
    }

}
