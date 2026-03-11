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

}