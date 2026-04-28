<?php

namespace App\Http\Controllers\Admin\PatientPortal;

use App\Http\Controllers\Controller;
use App\Models\IpdAdmission;
use App\Models\IpdDischarge;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientEmrController extends Controller
{
    // 🔹 Shared method (clean architecture)
    private function getDischargeData($ipd_id)
    {
        $ipd = IpdAdmission::with('patient')->findOrFail($ipd_id);

        // 🔐 Only allow discharged patients
        if ($ipd->status !== 'discharged') {
            abort(403, 'Discharge not completed');
        }

        $discharge = IpdDischarge::where('ipd_id', $ipd_id)->first();

        if (!$discharge) {
            abort(404, 'Discharge summary not found');
        }

        return compact('ipd', 'discharge');
    }

    // 🔹 View Summary
    public function dischargeSummary($ipd_id)
    {
        $data = $this->getDischargeData($ipd_id);

        return view('admin.patients.emr.discharge_summary', $data);
    }

    // 🔹 Download PDF
    public function download($ipd_id)
    {
        $data = $this->getDischargeData($ipd_id);

        $pdf = Pdf::loadView('admin.patients.emr.discharge_pdf', $data);

        return $pdf->download('discharge_summary_'.$data['ipd']->admission_id.'.pdf');
    }
    public function index()
{
    $ipds = IpdAdmission::with('patient')
        ->where('status', 'discharged')
        ->latest()
        ->paginate(10);

    return view('admin.patients.emr.discharge_list', compact('ipds'));
}
}