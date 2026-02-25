<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bed;
use App\Models\Ward;

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
        return view('admin.beds.create', compact('wards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $wards = Ward::all();
        return view('admin.beds.edit', compact('bed','wards'));
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
