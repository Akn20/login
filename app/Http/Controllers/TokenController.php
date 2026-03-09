<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\Appointment;
use Illuminate\Support\Str;

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
        $appointments = Appointment::with(['patient','doctor','department'])->get();

        $selectedAppointment = null;

        if ($request->appointment_id) {
            $selectedAppointment = Appointment::with(['patient','doctor','department'])
                ->find($request->appointment_id);
        }

        return view('admin.receptionist.tokens.create', compact(
            'appointments',
            'selectedAppointment'
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
            'appointment.doctor',
            'appointment.department'
        ])->findOrFail($id);

        return view('admin.Receptionist.tokens.show', compact('token'));
    }


    /**
     * Reassign Token (Edit)
     */
    public function edit($id)
    {
        $token = Token::findOrFail($id);

        $appointments = Appointment::with([
            'patient',
            'doctor',
            'department'
        ])->get();

        return view('admin.Receptionist.tokens.edit', compact('token', 'appointments'));
    }


    /**
     * Update Token Assignment
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id'
        ]);

        $token = Token::findOrFail($id);

        $token->update([
            'appointment_id' => $request->appointment_id
        ]);

        return redirect()
            ->route('admin.tokens.index')
            ->with('success', 'Token reassigned successfully.');
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