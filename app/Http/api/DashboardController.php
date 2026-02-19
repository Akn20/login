<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Institution;
use App\Models\User;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Organizations
        $organizationCount = Organization::count();
        $activeOrganizations = Organization::where('status', 1)->count();
        $inactiveOrganizations = Organization::where('status', 0)->count();

        // Hospitals
        $InstitutionCount = Institution::count();
        $activeHospitals = Institution::where('status', 1)->count();
        $inactiveHospitals = Institution::where('status', 0)->count();

        // Modules
        $moduleCount = Module::count();
        $activeModules = Module::where('status', 1)->count();
        $inactiveModules = Module::where('status', 0)->count();

        // Users
        $userCount = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();

        // Organization & Hospital Growth
        $orgData = Organization::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw("COUNT(*) as count")
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('month')
            ->get();

        $hospitalData = Institution::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw("COUNT(*) as count")
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('month')
            ->get();

        // Role Wise Users
        $roleWiseUsers = User::select(
                'roles.name as role_name',
                DB::raw('COUNT(users.id) as total')
            )
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->groupBy('roles.name')
            ->get();

        return response()->json([
            'organizations' => [
                'total' => $organizationCount,
                'active' => $activeOrganizations,
                'inactive' => $inactiveOrganizations
            ],
            'hospitals' => [
                'total' => $InstitutionCount,
                'active' => $activeHospitals,
                'inactive' => $inactiveHospitals
            ],
            'modules' => [
                'total' => $moduleCount,
                'active' => $activeModules,
                'inactive' => $inactiveModules
            ],
            'users' => [
                'total' => $userCount,
                'active' => $activeUsers,
                'inactive' => $inactiveUsers,
                'roles' => $roleWiseUsers
            ],
            'graphs' => [
                'orgGrowth' => $orgData,
                'hospitalGrowth' => $hospitalData
            ]
        ]);
    }
}
