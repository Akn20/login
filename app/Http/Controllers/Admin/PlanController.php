<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Module;
use App\Models\PlanLimit;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display all plans
     */
    public function index()
    {
        $plans = Plan::latest()->paginate(10);

        return view('admin.subscription.plans.index', compact('plans'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $modules = Module::where('status', 1)->get();

        return view('admin.subscription.plans.create', compact('modules'));
    }

    /**
     * Store new plan
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:plans,name',
            'slug' => 'required|unique:plans,slug',
            'monthly_price' => 'required|numeric',
            'yearly_price' => 'required|numeric',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE PLAN
        |--------------------------------------------------------------------------
        */

        $plan = Plan::create([

            'name' => $request->name,

            'slug' => $request->slug,

            'description' => $request->description,

            'monthly_price' => $request->monthly_price,

            'yearly_price' => $request->yearly_price,

            'trial_days' => $request->trial_days ?? 0,

            'grace_days' => $request->grace_days ?? 0,

            'status' => true
        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE LIMITS
        |--------------------------------------------------------------------------
        */

        PlanLimit::create([

            'plan_id' => $plan->id,

            'max_users' => $request->max_users,

            'max_patients' => $request->max_patients,

            'max_hospitals' => $request->max_hospitals,

            'max_storage_mb' => $request->max_storage_mb
        ]);

        /*
        |--------------------------------------------------------------------------
        | MODULE MAPPING
        |--------------------------------------------------------------------------
        */

        if ($request->modules) {

            $plan->modules()->sync($request->modules);
        }

        return redirect()
            ->route('admin.plans.index')
            ->with('success', 'Plan created successfully');
    }

    /**
     * Edit plan
     */
    public function edit($id)
    {
        $plan = Plan::with('limits', 'modules')->findOrFail($id);

        $modules = Module::where('status', 1)->get();

        return view(
            'admin.subscription.plans.edit',
            compact('plan', 'modules')
        );
    }

    /**
     * Update plan
     */
    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:plans,name,' . $id,
            'slug' => 'required|unique:plans,slug,' . $id,
            'monthly_price' => 'required|numeric',
            'yearly_price' => 'required|numeric',
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE PLAN
        |--------------------------------------------------------------------------
        */

        $plan->update([

    'name' => $request->name,

    'slug' => $request->slug,

    'description' => $request->description,

    'monthly_price' => $request->monthly_price,

    'yearly_price' => $request->yearly_price,

    'trial_days' => $request->trial_days,

    'grace_days' => $request->grace_days,

    'status' => $request->has('status'),
]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE LIMITS
        |--------------------------------------------------------------------------
        */

        if ($plan->limits) {

            $plan->limits->update([

                'max_users' => $request->max_users,

                'max_patients' => $request->max_patients,

                'max_hospitals' => $request->max_hospitals,

                'max_storage_mb' => $request->max_storage_mb
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE MODULES
        |--------------------------------------------------------------------------
        */

        $plan->modules()->sync($request->modules ?? []);

        return redirect()
            ->route('admin.plans.index')
            ->with('success', 'Plan updated successfully');
    }

    /**
     * Delete plan
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);

        $plan->delete();

        return redirect()
            ->back()
            ->with('success', 'Plan deleted successfully');
    }
}