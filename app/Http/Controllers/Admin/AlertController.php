<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\AlertAuditLog;
use App\Models\CriticalValueAlert;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = CriticalValueAlert::with('report.sample')
            ->latest()
            ->get();

        return view('admin.laboratory.alerts.index', compact('alerts'));
    }

    public function acknowledge($id)
    {
        $alert = CriticalValueAlert::findOrFail($id);

        $alert->update([
            'status' => 'Acknowledged',
            'acknowledged_at' => now(),
            'acknowledged_by' => Auth::id(),
        ]);
        AlertAuditLog::create([
            'alert_id' => $alert->id,
            'user_id' => Auth::id(),
            'action' => 'ACKNOWLEDGED',
            'timestamp' => now()
        ]);

        return back()->with('success', 'Alert acknowledged');
    }
}
