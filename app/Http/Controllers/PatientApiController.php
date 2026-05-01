<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientApiController extends Controller
{
    public function basicInfo($id)
{
    $patient = Patient::findOrFail($id);

    return response()->json([
        'name' => $patient->first_name . ' ' . $patient->last_name,
        'gender' => $patient->gender,
        'mobile' => $patient->mobile,
        'blood_group' => $patient->blood_group,
        'age' => Carbon::parse($patient->date_of_birth)->age,
    ]);
}
}
