<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    public function index()
    {
        $tokens = [];
        return view('admin.Receptionist.tokens.index', compact('tokens'));
    }

    public function create()
    {
        $patients = Patient::select('id', 'first_name', 'last_name', 'patient_code')->get();
        $doctors = DB::table('doctors')
                ->select('id','first_name','last_name','specialization')
                ->get();
        return view('admin.Receptionist.tokens.create', compact('patients', 'doctors'));
    }
}
