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
        $invoices = SubscriptionInvoice::with(
            'subscription.organization',
            'subscription.plan'
        )->latest()->paginate(10);

        return view(
            'admin.subscription.invoices.index',
            compact('invoices')
        );
    }

    /**
     * GENERATE INVOICE
     */
    public function generate($subscriptionId)
    {
        $subscription = Subscription::with('plan')
            ->findOrFail($subscriptionId);

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
}