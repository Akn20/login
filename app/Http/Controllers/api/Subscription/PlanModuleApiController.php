<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use App\Models\PlanModule;
use Illuminate\Http\Request;

class PlanModuleApiController extends Controller
{
    public function index()
    {
        return response()->json(
            PlanModule::latest()->get()
        );
    }

    public function store(Request $request)
    {
        $module = PlanModule::create(
            $request->all()
        );

        return response()->json([
            'status' => true,
            'message' => 'Plan module assigned',
            'data' => $module
        ]);
    }

    public function show($id)
    {
        return response()->json(
            PlanModule::findOrFail($id)
        );
    }

    public function destroy($id)
    {
        PlanModule::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Plan module deleted'
        ]);
    }
}