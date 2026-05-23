<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    /**
     * LIST SUBSCRIPTIONS
     */
    public function index()
    {
        $subscriptions = Subscription::with(
            'organization',
            'plan'
        )->latest()->paginate(10);

        return view(
            'admin.subscription.subscriptions.index',
            compact('subscriptions')
        );
    }

    /**
     * SHOW CREATE FORM
     */
    public function create()
    {
        $organizations = Organization::where(
            'status',
            true
        )->get();

        $plans = Plan::where(
            'status',
            true
        )->get();

        return view(
            'admin.subscription.subscriptions.create',
            compact('organizations', 'plans')
        );
    }

    /**
     * STORE SUBSCRIPTION
     */
    public function store(Request $request)
    {
        $request->validate([

            'organization_id' => 'required',

            'plan_id' => 'required',

            'start_date' => 'required|date',

            'expiry_date' => 'required|date|after:start_date',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CHECK EXISTING SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        $existing = Subscription::where(
            'organization_id',
            $request->organization_id
        )->first();

        if ($existing) {

            return back()->with(
                'error',
                'Organization already has subscription'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        $subscription = Subscription::create([

            'organization_id' => $request->organization_id,

            'plan_id' => $request->plan_id,

            'start_date' => $request->start_date,

            'expiry_date' => $request->expiry_date,

            'status' => $request->status,

            'auto_renew' => $request->has('auto_renew'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | LOAD PLAN
        |--------------------------------------------------------------------------
        */

        $subscription->load('plan');

        /*
        |--------------------------------------------------------------------------
        | CALCULATE INVOICE
        |--------------------------------------------------------------------------
        */

        $amount = $subscription->plan->monthly_price;

        $tax = ($amount * 18) / 100;

        $discount = 0;

        $totalAmount = $amount + $tax - $discount;

        /*
        |--------------------------------------------------------------------------
        | CREATE INVOICE
        |--------------------------------------------------------------------------
        */

        SubscriptionInvoice::create([

            'subscription_id' => $subscription->id,

            'invoice_number' =>
                'INV-' . strtoupper(Str::random(8)),

            'amount' => $amount,

            'tax' => $tax,

            'discount' => $discount,

            'total_amount' => $totalAmount,

            'invoice_date' => now(),

            'due_date' => now()->addDays(7),

            'status' => 'pending',
        ]);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with(
                'success',
                'Subscription assigned successfully'
            );
    }

    /**
     * EDIT FORM
     */
    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);

        $organizations = Organization::where(
            'status',
            true
        )->get();

        $plans = Plan::where(
            'status',
            true
        )->get();

        return view(
            'admin.subscription.subscriptions.edit',
            compact(
                'subscription',
                'organizations',
                'plans'
            )
        );
    }

    /**
     * UPDATE SUBSCRIPTION
     */
    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);

        $request->validate([

            'organization_id' => 'required',

            'plan_id' => 'required',

            'start_date' => 'required|date',

            'expiry_date' => 'required|date|after:start_date',
        ]);

        $subscription->update([

            'organization_id' => $request->organization_id,

            'plan_id' => $request->plan_id,

            'start_date' => $request->start_date,

            'expiry_date' => $request->expiry_date,

            'status' => $request->status,

            'auto_renew' => $request->has('auto_renew'),
        ]);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with(
                'success',
                'Subscription updated successfully'
            );
    }

    /**
     * DELETE SUBSCRIPTION
     */
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->delete();

        return back()->with(
            'success',
            'Subscription deleted successfully'
        );
    }
}