<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use Illuminate\Http\Request;
use App\Models\LabRequest;
use App\Models\Department;
use Illuminate\Support\Str;

class LabTestController extends Controller
{

    public function create()
    {
        return view('admin.laboratory.tests.create');
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'test_name' => 'required|string|max:255',
            'test_code' => 'required|string|max:50|unique:lab_tests,test_code',
            'test_category' => 'nullable|string|max:100',
            'sample_type' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'turnaround_time' => 'nullable|string|max:100',
            'status' => 'required|boolean',
            'description' => 'nullable|string'
        ]);

        // Store Data
        LabTest::create([
            'test_name' => $request->test_name,
            'test_code' => $request->test_code,
            'test_category' => $request->test_category,
            'sample_type' => $request->sample_type,
            'price' => $request->price,
            'turnaround_time' => $request->turnaround_time,
            'status' => $request->status,
            'description' => $request->description
        ]);


        return redirect()->back()->with('success', 'Lab Test Added Successfully');
    }
    public function index(Request $request)
    {
        $query = LabRequest::with(['patient', 'consultation.doctor']);

        // Filter by priority (urgency)
        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        // Filter by department
        if ($request->department) {
            $query->whereHas('consultation.doctor', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        $labRequests = $query->latest()->get();

        $departments = Department::all();

        return view(
            'admin.laboratory.tests.view-labrequests',
            compact('labRequests', 'departments')
        );
    }
    /* =====================================
       API: LIST LAB TESTS
    ===================================== */
    public function apiIndex()
    {
        $tests = LabTest::select('id', 'test_name')->get();

        return response()->json([
            'status' => true,
            'data' => $tests
        ]);
    }


    /* =====================================
       API: SHOW SINGLE LAB TEST
    ===================================== */
    public function apiShow($id)
    {
        $test = LabRequest::find($id);

        if (!$test) {
            return response()->json([
                'status' => false,
                'message' => 'Lab test not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $test
        ]);
    }


    /* =====================================
       API: UPDATE LAB TEST
    ===================================== */
    public function apiUpdate(Request $request, $id)
    {
        $test = LabRequest::find($id);

        if (!$test) {
            return response()->json([
                'status' => false,
                'message' => 'Lab test not found'
            ], 404);
        }

        $test->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Lab test updated successfully',
            'data' => $test
        ]);
    }


    /* =====================================
       API: DELETE LAB TEST
    ===================================== */
    public function apiDelete($id)
    {
        $test = LabRequest::find($id);

        if (!$test) {
            return response()->json([
                'status' => false,
                'message' => 'Lab test not found'
            ], 404);
        }

        $test->delete();

        return response()->json([
            'status' => true,
            'message' => 'Lab test deleted successfully'
        ]);
    }


    /* =====================================
       API: LIST LAB REQUESTS
    ===================================== */


    public function apiLabRequests(Request $request)
    {
        try {

            $query = LabRequest::with(['patient', 'consultation']);

            //  PRIORITY FILTER
            if ($request->filled('priority')) {
                $query->whereRaw('LOWER(priority) = ?', [strtolower($request->priority)]);
            }

            // DEPARTMENT FILTER (FIXED: follow same relation as web index)
            if ($request->filled('department')) {
                $query->whereHas('consultation.doctor', function ($q) use ($request) {
                    $q->where('department_id', $request->department);
                });
            }

            $requests = $query->latest()->get();

            $departments = Department::all();

            return response()->json([
                'status' => true,
                'data' => $requests,
                'departments' => $departments
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()   // 👈 VERY IMPORTANT for debugging
            ], 500);
        }
    }
    public function apiStore(Request $request)
    {
        $request->validate([
            'test_name' => 'required|string|max:255',
            'test_code' => 'required|string|max:50|unique:lab_tests,test_code',
            'test_category' => 'nullable|string|max:100',
            'sample_type' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'turnaround_time' => 'nullable|string|max:100',
            'status' => 'required|boolean',
            'description' => 'nullable|string'
        ]);

        $test = LabTest::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Lab test created successfully',
            'data' => $test
        ], 201);
    }



}


