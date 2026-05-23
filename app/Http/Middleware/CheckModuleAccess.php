<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleAccess
{
    /**
     * Handle incoming request
     */
    public function handle(
        Request $request,
        Closure $next,
        $moduleSlug
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | GET ORGANIZATION
        |--------------------------------------------------------------------------
        */

        $organizationId = session('organization_id');

        /*
        |--------------------------------------------------------------------------
        | SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        $subscription = Subscription::with(
            'plan.modules'
        )
        ->where(
            'organization_id',
            $organizationId
        )
        ->first();

        /*
        |--------------------------------------------------------------------------
        | NO SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        if (!$subscription) {

            abort(403, 'No subscription found');
        }

        /*
        |--------------------------------------------------------------------------
        | MODULE CHECK
        |--------------------------------------------------------------------------
        */

        $hasAccess = $subscription
            ->plan
            ->modules
            ->contains(
                'module_label',
                $moduleSlug
            );

        /*
        |--------------------------------------------------------------------------
        | ACCESS DENIED
        |--------------------------------------------------------------------------
        */

        if (!$hasAccess) {

            abort(
                403,
                'Module not included in your subscription plan'
            );
        }

        return $next($request);
    }
}