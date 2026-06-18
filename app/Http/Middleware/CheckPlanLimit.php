<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Patient;
use App\Models\Hospital;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlanLimit
{
    /**
     * Handle incoming request
     */
    public function handle(
        Request $request,
        Closure $next,
        $type
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION
        |--------------------------------------------------------------------------
        */

        $organizationId = session('organization_id');

        /*
        |--------------------------------------------------------------------------
        | SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        $subscription = Subscription::with('plan')
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

            abort(403, 'Subscription not found');
        }

        $plan = $subscription->plan;

        /*
        |--------------------------------------------------------------------------
        | CHECK LIMIT TYPE
        |--------------------------------------------------------------------------
        */

        switch ($type) {

            /*
            |--------------------------------------------------------------------------
            | USERS LIMIT
            |--------------------------------------------------------------------------
            */

            case 'users':

                $currentUsage = User::count();

                $limit = $plan->max_users;

                break;

            /*
            |--------------------------------------------------------------------------
            | PATIENTS LIMIT
            |--------------------------------------------------------------------------
            */

            case 'patients':

                $currentUsage = Patient::count();

                $limit = $plan->max_patients;

                break;

            /*
            |--------------------------------------------------------------------------
            | HOSPITALS LIMIT
            |--------------------------------------------------------------------------
            */

            case 'hospitals':

                $currentUsage = Hospital::count();

                $limit = $plan->max_hospitals;

                break;

            default:

                abort(403, 'Invalid plan limit type');
        }

        /*
        |--------------------------------------------------------------------------
        | UNLIMITED SUPPORT
        |--------------------------------------------------------------------------
        */

        if ($limit == -1) {

            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | LIMIT EXCEEDED
        |--------------------------------------------------------------------------
        */

        if ($currentUsage >= $limit) {

            abort(
                403,
                ucfirst($type) . ' limit exceeded for your plan'
            );
        }

        return $next($request);
    }
}