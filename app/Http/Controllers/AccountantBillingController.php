<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountantBillingController extends Controller
{
    /**
     * Display IPD Billing List
     */
    public function index()
    {
        // Dummy data for UI
        $patients = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'ipd_no' => 'IPD001',
                'admission_date' => '2026-04-10',
                'room' => 'Room 101',
                'doctor' => 'Dr. Smith',
                'status' => 'Interim',
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'ipd_no' => 'IPD002',
                'admission_date' => '2026-04-12',
                'room' => 'Room 202',
                'doctor' => 'Dr. Adams',
                'status' => 'Final',
            ],
        ];

        return view('admin.Accountant.Billing.index', compact('patients'));
    }

    /**
     *  Create ( Bill)
     */
    public function create()
{
    $patients = [
        [
            'id' => 1,
            'name' => 'John Doe',
            'ipd_no' => 'IPD001',
            'doctor' => 'Dr. Smith',
            'room' => 'Room 101',
            'admission_date' => '2026-04-10',
        ],
        [
            'id' => 2,
            'name' => 'Jane Smith',
            'ipd_no' => 'IPD002',
            'doctor' => 'Dr. Adams',
            'room' => 'Room 202',
            'admission_date' => '2026-04-12',
        ],
    ];

    return view('admin.Accountant.Billing.create', compact('patients'));
}

    /**
     * Show Edit Billing
     */
    public function edit($id)
    {
        $patient = [
            'id' => $id,
            'name' => 'John Doe',
            'ipd_no' => 'IPD001',
            'doctor' => 'Dr. Smith',
            'room' => 'Room 101',
            'admission_date' => '2026-04-10',
        ];

        // Dummy charges
        $charges = [
            [
                'date' => '2026-04-11',
                'type' => 'Room',
                'description' => 'Room Charge',
                'qty' => 2,
                'rate' => 2000,
                'amount' => 4000,
            ],
            [
                'date' => '2026-04-12',
                'type' => 'Lab',
                'description' => 'Blood Test',
                'qty' => 1,
                'rate' => 500,
                'amount' => 500,
            ],
        ];

        return view('admin.Accountant.Billing.edit', compact('patient', 'charges'));
    }

    /**
     * View Final Bill
     */
    public function show($id)
    {
        $patient = [
            'id' => $id,
            'name' => 'John Doe',
            'ipd_no' => 'IPD001',
            'doctor' => 'Dr. Smith',
            'room' => 'Room 101',
            'admission_date' => '2026-04-10',
        ];

        $charges = [
            [
                'date' => '2026-04-11',
                'type' => 'Room',
                'description' => 'Room Charge',
                'qty' => 2,
                'rate' => 2000,
                'amount' => 4000,
            ],
            [
                'date' => '2026-04-12',
                'type' => 'Lab',
                'description' => 'Blood Test',
                'qty' => 1,
                'rate' => 500,
                'amount' => 500,
            ],
        ];

        $summary = [
            'total' => 4500,
            'discount' => 200,
            'tax' => 100,
            'grand_total' => 4400,
        ];

        return view('admin.Accountant.Billing.view', compact('patient', 'charges', 'summary'));
    }
}