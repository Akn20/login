<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use Illuminate\Http\Request;

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


        return redirect()->back()->with('success','Lab Test Added Successfully');
    }

}
