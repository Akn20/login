<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parameter;

class ParameterController extends Controller
{
    public function index()
    {
        $parameters = Parameter::latest()->get();
        return view('admin.laboratory.parameters.index', compact('parameters'));
    }

    public function create()
    {
        return view('admin.laboratory.parameters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'unit' => 'nullable',
            'min_value' => 'nullable|numeric',
            'max_value' => 'nullable|numeric',
        ]);

        Parameter::create($request->all());

        return redirect()->route('admin.laboratory.parameters.index')
            ->with('success', 'Parameter added successfully');
    }

    public function edit($id)
    {
        $parameter = Parameter::findOrFail($id);
        return view('admin.laboratory.parameters.edit', compact('parameter'));
    }

    public function update(Request $request, $id)
    {
        $parameter = Parameter::findOrFail($id);

        $parameter->update($request->all());

        return redirect()->route('admin.laboratory.parameters.index')
            ->with('success', 'Updated successfully');
    }

    public function destroy($id)
    {
        Parameter::destroy($id);

        return back()->with('success', 'Deleted successfully');
    }
}