<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewPatientController extends Controller
{
    public function viewPatientProfile($id)
    {
        return view('doctor.opd.view-patient-profile');
    }
}