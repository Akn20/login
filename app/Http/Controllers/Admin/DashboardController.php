<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Hospital;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Organizations
        $organizationCount = 0;
        $activeOrganizations = 0;
        $inactiveOrganizations = 0;
        $activeOrganizationPercentage = 0;

        try {
            $organizationCount = Organization::count();
            $activeOrganizations = Organization::where('status', 1)->count();
            $inactiveOrganizations = $organizationCount - $activeOrganizations;
            $activeOrganizationPercentage = $organizationCount > 0
                ? round(($activeOrganizations / $organizationCount) * 100, 2)
                : 0;
        } catch (\Exception $e) {
        }

        // Hospitals – totals for cards
        $hospitalTotal = 0;
        $activeHospitals = 0;
        $inactiveHospitals = 0;
        $activeHospitalPercentage = 0;

        try {
            $hospitalTotal = Hospital::count();
            $activeHospitals = Hospital::where('status', 1)->count();
            $inactiveHospitals = $hospitalTotal - $activeHospitals;
            $activeHospitalPercentage = $hospitalTotal > 0
                ? round(($activeHospitals / $hospitalTotal) * 100, 2)
                : 0;
        } catch (\Exception $e) {
        }

        // Hospitals 
        $hospitalMonths = [];
        $hospitalCounts = [];
        $hospitalData = collect();

        try {
            $hospitalData = Hospital::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
                ->where('created_at', '>=', now()->subMonths(12))
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $hospitalMonths = $hospitalData->pluck('month')->values()->all();
            $hospitalCounts = $hospitalData->pluck('count')->values()->all();
        } catch (\Exception $e) {
        }

        // Users
        $userCount = 0;
        $activeUsers = 0;
        $inactiveUsers = 0;
        $activePercentage = 0;

        try {
            $userCount = User::count();
            $activeUsers = User::where('status', 'active')->count();
            $inactiveUsers = $userCount - $activeUsers;
            $activePercentage = $userCount > 0
                ? round(($activeUsers / $userCount) * 100, 2)
                : 0;
        } catch (\Exception $e) {
        }

        // Modules
        $moduleCount = 0;
        $activeModules = 0;
        $inactiveModules = 0;
        $activeModulePercent = 0;

        try {
            $moduleCount = Module::count();
            $activeModules = Module::where('status', 1)->count();
            $inactiveModules = $moduleCount - $activeModules;
            $activeModulePercent = $moduleCount > 0
                ? round(($activeModules / $moduleCount) * 100, 2)
                : 0;
        } catch (\Exception $e) {
        }

        // Role-wise users (donut)
        $roleWiseUsers = collect();

        try {
            $roleWiseUsers = DB::table('roles')
                ->leftJoin('users', 'users.role_id', '=', 'roles.id')
                ->select('roles.name as role_name', DB::raw('COUNT(users.id) as total'))
                ->groupBy('roles.name')
                ->get();
        } catch (\Exception $e) {
        }

        // Organizations growth 
        $orgData = collect();

        try {
            $orgData = Organization::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
                ->where('created_at', '>=', now()->subMonths(12))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } catch (\Exception $e) {
        }

        $pendingApprovals = 0;

        return view('admin.dashboard.index', compact(
            'organizationCount',
            'activeOrganizations',
            'inactiveOrganizations',
            'activeOrganizationPercentage',

            'hospitalTotal',
            'activeHospitals',
            'inactiveHospitals',
            'activeHospitalPercentage',
            'hospitalMonths',
            'hospitalCounts',
            'hospitalData',

            'userCount',
            'activeUsers',
            'inactiveUsers',
            'activePercentage',

            'moduleCount',
            'activeModules',
            'inactiveModules',
            'activeModulePercent',

            'roleWiseUsers',
            'orgData',
            'pendingApprovals'
        ));
    }
}
