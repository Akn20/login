<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Subscription::with([
                'organization',
                'plan'
            ])->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $subscription = Subscription::create(
            $request->all()
        );

        return response()->json([
            'status' => true,
            'message' => 'Subscription created',
            'data' => $subscription
        ]);
    }

    public function show($id)
    {
        return response()->json(
            Subscription::with([
                'organization',
                'plan'
            ])->findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Subscription updated'
        ]);
    }

    public function destroy($id)
    {
        Subscription::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Subscription deleted'
        ]);
    }
}