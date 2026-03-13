<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class NurseNotesController extends Controller
{
    public function index()
    {
        $nursingNotes = new LengthAwarePaginator([], 0, 10);

        return view('admin.nurse.nursing_notes.index', compact('nursingNotes'));
    }

    public function create()
{
    $patients = [];
    $nurses = [];

    return view('admin.Nurse.nursing_notes.create', compact('patients', 'nurses'));
}

public function edit($id)
{
    $note = (object)[
        'id' => $id,
        'patient_id' => '',
        'nurse_id' => '',
        'shift' => '',
        'pain_level' => '',
        'patient_condition' => '',
        'behavioral_observation' => '',
        'intake_details' => '',
        'output_details' => '',
        'wound_care_notes' => '',
        'remarks' => '',
    ];

    $patients = [];
    $nurses = [];

    return view('admin.Nurse.nursing_notes.edit', compact('note', 'patients', 'nurses'));
}
}
