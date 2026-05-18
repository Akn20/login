<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | GET ORGANIZATION
        |--------------------------------------------------------------------------
        */

        $organizationId = session('organization_id');

        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION NOT FOUND
        |--------------------------------------------------------------------------
        */

        if (!$organizationId) {

            abort(403, 'Organization not found');
        }

        /*
        |--------------------------------------------------------------------------
        | GET SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        $subscription = Subscription::where(
            'organization_id',
            $organizationId
        )->first();

        /*
        |--------------------------------------------------------------------------
        | SUBSCRIPTION NOT FOUND
        |--------------------------------------------------------------------------
        */

        if (!$subscription) {

            abort(403, 'No active subscription found');
        }

        /*
        |--------------------------------------------------------------------------
        | BLOCK SUSPENDED
        |--------------------------------------------------------------------------
        */

        if ($subscription->status === 'suspended') {

            abort(403, 'Subscription suspended');
        }

        /*
        |--------------------------------------------------------------------------
        | BLOCK EXPIRED
        |--------------------------------------------------------------------------
        */

        if ($subscription->status === 'expired') {

            abort(403, 'Subscription expired');
        }

        /*
        |--------------------------------------------------------------------------
        | DATE EXPIRY CHECK
        |--------------------------------------------------------------------------
        */

        if (
            Carbon::parse($subscription->expiry_date)
                ->isPast()
        ) {

            /*
            |--------------------------------------------------------------------------
            | AUTO UPDATE STATUS
            |--------------------------------------------------------------------------
            */

            $subscription->update([
                'status' => 'expired'
            ]);

            abort(403, 'Subscription expired');
        }

        return $next($request);
    }
}