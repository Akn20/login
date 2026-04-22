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
    // ================= GET ALERTS =================
    public function apiIndex(Request $request)
    {
        $query = CriticalValueAlert::with('report.sample')->latest();

        // 🔍 SEARCH
        if ($request->search) {
            $query->where('parameter_name', 'like', '%' . $request->search . '%');
        }

        // 🔘 FILTER
        if ($request->status && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        $alerts = $query->get();

        return response()->json([
            'status' => true,
            'data' => $alerts
        ]);
    }

    // ================= ACKNOWLEDGE =================
    public function apiAcknowledge($id)
    {
        $alert = CriticalValueAlert::findOrFail($id);

        if ($alert->status === 'Acknowledged') {
            return response()->json([
                'status' => false,
                'message' => 'Already acknowledged'
            ]);
        }

        $alert->update([
            'status' => 'Acknowledged',
            'acknowledged_at' => now(),
            'acknowledged_by' => Auth::id(),
        ]);

        // 📝 AUDIT LOG
        AlertAuditLog::create([
            'alert_id' => $alert->id,
            'user_id' => Auth::id(),
            'action' => 'ACKNOWLEDGED',
            'timestamp' => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Alert acknowledged successfully'
        ]);
    }

}
