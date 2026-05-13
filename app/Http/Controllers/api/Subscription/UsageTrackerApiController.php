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
            UsageTracker::latest()->get()
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