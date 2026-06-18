<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Hospital;

class UsageMonitoringController extends Controller
{
    /**
     * DISPLAY USAGE DASHBOARD
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | GET ORGANIZATIONS WITH SUBSCRIPTIONS
        |--------------------------------------------------------------------------
        */

        $subscriptions = Subscription::with(
            'organization',
            'plan'
        )->latest()->get();

        /*
        |--------------------------------------------------------------------------
        | BUILD USAGE DATA
        |--------------------------------------------------------------------------
        */

        $usageData = [];

        foreach ($subscriptions as $subscription) {

            $organization = $subscription->organization;

            $plan = $subscription->plan;

            /*
            |--------------------------------------------------------------------------
            | CURRENT USAGE
            |--------------------------------------------------------------------------
            */

            $currentUsers = User::count();

            $currentPatients = Patient::count();

            $currentHospitals = Hospital::count();

            /*
            |--------------------------------------------------------------------------
            | STORE DATA
            |--------------------------------------------------------------------------
            */

            $usageData[] = [

                'organization' => $organization->name ?? '-',

                'plan' => $plan->name ?? '-',

                'users_used' => $currentUsers,

                'users_limit' => $plan->max_users,

                'patients_used' => $currentPatients,

                'patients_limit' => $plan->max_patients,

                'hospitals_used' => $currentHospitals,

                'hospitals_limit' => $plan->max_hospitals,

                'subscription_status' => $subscription->status,
            ];
        }

        return view(
            'admin.subscription.usage.index',
            compact('usageData')
        );
    }
}