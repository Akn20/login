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
        $organizationCount = Organization::count();
        $activeOrganizations = 0;
        $inactiveOrganizations = 0;
        $activeOrganizationPercentage = 0;

        // Hospitals (hospitals table via Hospital model)
        $hospitalTotal = Hospital::count();
        $activeHospitals = 0;
        $inactiveHospitals = 0;
        $activeHospitalPercentage = 0;

        $hospitalData = Hospital::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $hospitalMonths = $hospitalData->pluck('month');
        $hospitalCounts = $hospitalData->pluck('count');

        // Users
        $userCount = User::count();
        $activeUsers = 0;
        $inactiveUsers = 0;
        $activePercentage = 0;

        // Modules
        $moduleCount = Module::count();
        $activeModules = 0;
        $inactiveModules = 0;
        $activeModulePercent = 0;

        // Role-wise users
        $roleWiseUsers = DB::table('roles')
            ->join('users', 'users.role_id', '=', 'roles.id')
            ->select('roles.name as role_name', DB::raw('COUNT(users.id) as total'))
            ->groupBy('roles.name')
            ->get();

        // Organizations growth per month
        $orgData = Organization::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard.index', compact(
            'organizationCount',
            'activeOrganizations',
            'inactiveOrganizations',
            'activeOrganizationPercentage',

            'hospitalTotal',
            'activeHospitals',
            'inactiveHospitals',
            'activeHospitalPercentage',
            'hospitalData',
            'hospitalMonths',
            'hospitalCounts',

            'userCount',
            'activeUsers',
            'inactiveUsers',
            'activePercentage',

            'moduleCount',
            'activeModules',
            'inactiveModules',
            'activeModulePercent',

            'roleWiseUsers',
            'orgData'
        ));
    }
}
