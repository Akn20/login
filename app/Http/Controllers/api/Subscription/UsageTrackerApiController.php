<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use App\Models\UsageTracker;
use Illuminate\Http\Request;

class UsageTrackerApiController extends Controller
{
   public function index()
{
    return response()->json(

        \App\Models\Subscription::with([
            'organization',
            'plan'
        ])->latest()->get()->map(function ($item) {

            return [

                'id' => $item->id,

                'organization' =>
                    $item->organization?->name,

                'plan' =>
                    $item->plan?->name,

                'users' =>
                    '0 / ' .
                    (
                        $item->plan?->max_users == -1
                        ? 'Unlimited'
                        : $item->plan?->max_users
                    ),

                'patients' =>
                    '0 / ' .
                    (
                        $item->plan?->max_patients == -1
                        ? 'Unlimited'
                        : $item->plan?->max_patients
                    ),

                'hospitals' =>
                    '0 / ' .
                    (
                        $item->plan?->max_staff == -1
                        ? 'Unlimited'
                        : $item->plan?->max_staff
                    ),

                'status' =>
                    ucfirst($item->status),

                'start_date' =>
                    $item->start_date,

                'expiry_date' =>
                    $item->expiry_date,

                'auto_renew' =>
                    $item->auto_renew,
            ];
        })
    );
}

    public function store(Request $request)
    {
        $tracker = UsageTracker::create(
            $request->all()
        );

        return response()->json([
            'status' => true,
            'message' => 'Usage tracker created',
            'data' => $tracker
        ]);
    }

    public function show($id)
    {
        return response()->json(
            UsageTracker::findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $tracker = UsageTracker::findOrFail($id);

        $tracker->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Usage tracker updated'
        ]);
    }

    public function destroy($id)
    {
        UsageTracker::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Usage tracker deleted'
        ]);
    }
}