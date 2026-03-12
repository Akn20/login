<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\Appointment;
use Illuminate\Support\Str;
use App\Models\Staff;

class TokenController extends Controller
{

    /**
     * Display Token List
     */
    public function index()
    {
        $tokens = Token::with([
            'appointment.patient',
            'appointment.doctor',
            'appointment.department'
        ])
        ->latest()
        ->get();

        return view('admin.Receptionist.tokens.index', compact('tokens'));
    }


    /**
     * Show Generate Token Form
     */
    public function create(Request $request)
    {
        $appointments = Appointment::with(['patient', 'department'])->get();

    $selectedAppointment = null;
    $selectedDoctor = null;

    if ($request->appointment_id) {
        $selectedAppointment = Appointment::with(['patient', 'department'])
            ->find($request->appointment_id);

        if ($selectedAppointment) {
            $selectedDoctor = Staff::where('id', $selectedAppointment->doctor_id)
                ->orWhere('user_id', $selectedAppointment->doctor_id)
                ->first();
        }
    }

    return view('admin.receptionist.tokens.create', compact(
        'appointments',
        'selectedAppointment',
        'selectedDoctor'
    ));
    }


    /**
     * Store Generated Token
     */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id'
        ]);

        try {

            // Generate next token number
            $lastToken = Token::orderBy('token_number', 'desc')->first();

            $tokenNumber = $lastToken ? $lastToken->token_number + 1 : 1;

            Token::create([
                'id' => Str::uuid(),
                'appointment_id' => $request->appointment_id,
                'token_number' => $tokenNumber,
                'status' => 'WAITING'
            ]);

            return redirect()
                ->route('admin.tokens.index')
                ->with('success', 'Token generated successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', 'Token generation failed.');
        }
    }


    /**
     * View Token Details
     */
    public function show($id)
    {
        $token = Token::with([
        'appointment.patient',
        'appointment.department'
    ])->findOrFail($id);

    $selectedDoctor = null;

    if ($token->appointment) {
        $selectedDoctor = Staff::where('id', $token->appointment->doctor_id)
            ->orWhere('user_id', $token->appointment->doctor_id)
            ->first();
    }

    return view('admin.receptionist.tokens.show', compact('token', 'selectedDoctor'));
    }


    /**
     * Reassign Token (Edit)
     */
    public function edit($id)
    {
       $token = Token::with(['appointment.patient', 'appointment.department', 'appointment.doctor'])
        ->findOrFail($id);

    $doctors = Staff::join('roles', 'staff.role_id', '=', 'roles.id')
        ->where('roles.name', 'Doctor')
        ->whereNull('staff.deleted_at')
        ->select('staff.id', 'staff.name')
        ->get();

    return view('admin.receptionist.tokens.edit', compact('token', 'doctors'));
    }


    /**
     * Update Token Assignment
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'doctor_id' => 'required|exists:staff,id'
    ]);

    $token = Token::with('appointment')->findOrFail($id);

    if (!$token->appointment) {
        return redirect()->route('admin.tokens.index')
            ->with('error', 'Linked appointment not found.');
    }

    $token->appointment->update([
        'doctor_id' => $request->doctor_id
    ]);

    return redirect()->route('admin.tokens.index')
        ->with('success', 'Doctor reassigned successfully.');
    }


    /**
     * Skip Token
     */
    public function skip($id)
    {
        $token = Token::findOrFail($id);

        $token->update([
            'status' => 'SKIPPED'
        ]);

        return redirect()
            ->route('admin.tokens.index')
            ->with('success', 'Token skipped.');
    }


    /**
     * Complete Token
     */
    public function complete($id)
    {
        $token = Token::findOrFail($id);

        $token->update([
            'status' => 'COMPLETED'
        ]);

        return redirect()
            ->route('admin.tokens.index')
            ->with('success', 'Token completed.');
    }

    /********API Endpoints * ******/
 public function apiIndex()
{
    $tokens = Token::with([
        'appointment.patient:id,first_name,last_name',
        'appointment.doctor:id,name',
        'appointment.department:id,department_name'
    ])
    ->whereHas('appointment') // IMPORTANT
    ->get();

    $data = $tokens->map(function ($token) {

        return [
            'token_id' => $token->id,
            'token_number' => $token->token_number,
            'status' => $token->status,

            'patient_name' =>
                optional($token->appointment->patient)->first_name . ' ' .
                optional($token->appointment->patient)->last_name,

            'doctor_name' =>
                optional($token->appointment->doctor)->name,

            'department' =>
                optional($token->appointment->department)->department_name,

            'appointment_time' =>
                $token->appointment->appointment_time ?? null
        ];
    });

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}


    public function apiStore(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id'
        ]);

        $lastToken = Token::orderBy('token_number','desc')->first();

        $tokenNumber = $lastToken ? $lastToken->token_number + 1 : 1;

        $token = Token::create([
            'id' => Str::uuid(),
            'appointment_id' => $request->appointment_id,
            'token_number' => $tokenNumber,
            'status' => 'WAITING'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Token generated successfully',
            'data' => $token
        ]);
    } 


    public function apiShow($id)
    {
        $token = Token::with([
            'appointment:id,patient_id,doctor_id,department_id,appointment_date,appointment_time',
            'appointment.patient:id,patient_code,first_name,last_name',
            'appointment.doctor:id,name',
            'appointment.department:id,department_name'
        ])->findOrFail($id);

        $data = [
            'token_id' => $token->id,
            'token_number' => $token->token_number,
            'status' => $token->status,
            'appointment' => [
                'id' => $token->appointment->id,
                'date' => $token->appointment->appointment_date,
                'time' => $token->appointment->appointment_time,
            ],
            'patient' => [
                'id' => $token->appointment->patient->id,
                'code' => $token->appointment->patient->patient_code,
                'name' => $token->appointment->patient->first_name . ' ' . $token->appointment->patient->last_name,
            ],
            'doctor' => [
                'id' => $token->appointment->doctor->id ?? null,
                'name' => $token->appointment->doctor->name ?? null,
            ],
            'department' => [
                'id' => $token->appointment->department->id ?? null,
                'name' => $token->appointment->department->department_name ?? null,
            ]
        ];

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }


    public function apiSkip($id)
    {
        $token = Token::findOrFail($id);

        $token->update([
            'status' => 'SKIPPED'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Token skipped successfully'
        ]);
    }


    public function apiComplete($id)
    {
        $token = Token::findOrFail($id);

        $token->update([
            'status' => 'COMPLETED'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Token completed successfully'
        ]);
    }


    public function apiDoctors()
{
    $doctors = Staff::join('roles', 'staff.role_id', '=', 'roles.id')
        ->where('roles.name', 'Doctor')
        ->whereNull('staff.deleted_at')
        ->select('staff.id', 'staff.name')
        ->get();

    return response()->json([
        'status' => true,
        'data' => $doctors
    ]);
}
    
public function apiReassign(Request $request, $id)
{
    $request->validate([
        'doctor_id' => 'required|exists:staff,id'
    ]);

    $token = Token::with('appointment')->findOrFail($id);

    if (!$token->appointment) {
        return response()->json([
            'status' => false,
            'message' => 'Linked appointment not found'
        ], 404);
    }

    $token->appointment->update([
        'doctor_id' => $request->doctor_id
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Doctor reassigned successfully'
    ]);
}
}