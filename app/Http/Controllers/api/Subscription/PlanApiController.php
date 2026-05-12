<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Plan::latest()->get()
        );
    }

    public function store(Request $request)
    {
        $plan = Plan::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Plan created',
            'data' => $plan
        ]);
    }

    public function show($id)
    {
        return response()->json(
            Plan::findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $plan->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Plan updated'
        ]);
    }

    public function destroy($id)
    {
        Plan::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Plan deleted'
        ]);
    }
}