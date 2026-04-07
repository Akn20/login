<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use Illuminate\Http\Request;
use App\Models\TestParameter;
use App\Models\Parameter;

class TestParameterController extends Controller
{
    public function index()
    {
        $mappings = TestParameter::with('parameter')->get()->groupBy('test_name');
        $tests = LabTest::all();
        $parameters = Parameter::all();
        return view('admin.laboratory.test_parameters.create', compact('mappings', 'parameters', 'tests'));
    }

    public function create()
    {
        $parameters = Parameter::all();
        $tests = LabTest::all();
        $mappings = TestParameter::with('parameter')->get()->groupBy('test_name');

        return view('admin.laboratory.test_parameters.create', compact('parameters', 'tests', 'mappings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'test_name' => 'required|array',
            'parameters' => 'required|array'
        ]);

        foreach ($request->test_name as $index => $testName) {

            // Remove old mappings (avoid duplicates)
            TestParameter::where('test_name', $testName)->delete();

            // Insert new mappings
            if (isset($request->parameters[$index])) {

                foreach ($request->parameters[$index] as $paramId) {

                    TestParameter::create([
                        'test_name' => $testName,
                        'parameter_id' => $paramId
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.laboratory.test-parameters.create')
            ->with('success', 'Mapping saved successfully');
    }
    public function apiIndex()
    {
        $mappings = TestParameter::with('parameter')
            ->get()
            ->groupBy('test_name');

        return response()->json([
            'status' => true,
            'message' => 'Mappings fetched successfully',
            'data' => $mappings
        ]);
    }
    public function apiStore(Request $request)
    {
        $request->validate([
            'test_name' => 'required|array',
            'parameters' => 'required|array'
        ]);

        foreach ($request->test_name as $index => $testName) {

            // Remove old mappings
            TestParameter::where('test_name', $testName)->delete();

            if (isset($request->parameters[$index])) {

                foreach ($request->parameters[$index] as $paramId) {

                    TestParameter::create([
                        'test_name' => $testName,
                        'parameter_id' => $paramId
                    ]);
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Mapping saved successfully'
        ]);
    }
    public function apiParameters()
    {
        return response()->json([
            'status' => true,
            'data' => Parameter::all()
        ]);
    }
    public function apiTests()
    {
        return response()->json([
            'status' => true,
            'data' => LabTest::all()
        ]);
    }
    public function apiAddParameter(Request $request)
{
    $request->validate([
        'name' => 'required',
        'unit' => 'nullable',
        'min_value' => 'nullable|numeric',
        'max_value' => 'nullable|numeric',
    ]);

    $param = Parameter::create($request->all());

    return response()->json([
        'status' => true,
        'message' => 'Parameter added successfully',
        'data' => $param
    ]);
}

}