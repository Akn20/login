<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionInvoiceController extends Controller
{
    /**
     * LIST INVOICES
     */
    public function index()
    {
        $invoices = SubscriptionInvoice::with([
            'subscription.organization',
            'subscription.plan'
        ])
        ->latest()
        ->paginate(10);

        return view(
            'admin.subscription.invoices.index',
            compact('invoices')
        );
    }

    /**
     * CREATE FORM
     */
    public function create()
    {
        $subscriptions = Subscription::with([
            'organization',
            'plan'
        ])->latest()->get();

        return view(
            'admin.subscription.invoices.create',
            compact('subscriptions')
        );
    }

    /**
     * STORE INVOICE
     */
    public function store(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        $subscription = Subscription::with([
            'organization',
            'plan'
        ])->findOrFail($request->subscription_id);

        $amount = $subscription->plan->monthly_price;

        $tax = ($amount * 18) / 100;

        $discount = 0;

        $totalAmount = $amount + $tax - $discount;

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
            ->route('admin.subscription.invoices.index')
            ->with(
                'success',
                'Invoice created successfully'
            );
    }

    /**
     * GENERATE INVOICE
     */
    public function generate($subscriptionId)
    {
        $subscription = Subscription::with([
            'organization',
            'plan'
        ])->findOrFail($subscriptionId);

        $amount = $subscription->plan->monthly_price;

        $tax = ($amount * 18) / 100;

        $discount = 0;

        $totalAmount = $amount + $tax - $discount;

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

        return back()->with(
            'success',
            'Invoice generated successfully'
        );
    }

    /**
     * EDIT FORM
     */
    public function edit($id)
    {
        $invoice = SubscriptionInvoice::with([
            'subscription.organization',
            'subscription.plan'
        ])->findOrFail($id);

        return view(
            'admin.subscription.invoices.edit',
            compact('invoice')
        );
    }

    /**
     * UPDATE INVOICE
     */
    public function update(Request $request, $id)
    {
        $invoice = SubscriptionInvoice::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,paid,overdue,cancelled'
        ]);

        $invoice->update([
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.subscription.invoices.index')
            ->with(
                'success',
                'Invoice updated successfully'
            );
    }

    /**
     * DELETE INVOICE
     */
    public function destroy($id)
    {
        $invoice = SubscriptionInvoice::findOrFail($id);

        $invoice->delete();

        return back()->with(
            'success',
            'Invoice deleted successfully'
        );
    }
}