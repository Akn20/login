<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;


class InstitutionController extends Controller
{
    public function index(Request $request)
    {
        $institutions = Institution::latest()->paginate(10);
        return view('admin.institution.index', compact('institutions'));
    }

    public function create()
    {
        return view('admin.institution.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required'
        ]);

        Institution::create($request->all());

        return redirect()->route('admin.institutions.index')
            ->with('success', 'Institution Created Successfully');
    }
}
