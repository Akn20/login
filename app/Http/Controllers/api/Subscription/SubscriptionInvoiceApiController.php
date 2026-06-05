<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionInvoice;
use Illuminate\Http\Request;

class SubscriptionInvoiceApiController extends Controller
{
    public function index()
    {
        return response()->json(
            SubscriptionInvoice::with([
                'subscription.organization',
                'subscription.plan'
            ])->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $invoice = SubscriptionInvoice::create(
            $request->all()
        );

        return response()->json([
            'status' => true,
            'message' => 'Invoice created',
            'data' => $invoice
        ]);
    }

    public function show($id)
    {
        return response()->json(
            SubscriptionInvoice::findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $invoice = SubscriptionInvoice::findOrFail($id);

        $invoice->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Invoice updated'
        ]);
    }

    public function destroy($id)
    {
        SubscriptionInvoice::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Invoice deleted'
        ]);
    }
}