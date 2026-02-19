<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Module;

class DashboardController extends Controller
{
    public function index()
    {
        
        //Organizations Data
        $organizationCount = Organization::count();
        $activeOrganizations = Organization::where('status', 1)->count();
        $inactiveOrganizations = Organization::where('status', 0)->count();

        $activeOrganizationPercentage = $organizationCount > 0 
            ? ($activeOrganizations / $organizationCount) * 100 
            : 0;
        
        //Hospitals Data
        $InstitutionCount = Institution::count();
        $activeHospitals = Institution::where('status', '1')->count();
        $inactiveHospitals = Institution::where('status', '0')->count();

        $activeHospitalPercentage = $InstitutionCount > 0 
            ? ($activeHospitals / $InstitutionCount) * 100 
            : 0;


        //Modules Data
        $moduleCount = Module::count();
        $activeModules = Module::where('status', 1)->count();
        $inactiveModules = Module::where('status', 0)->count();

         $activeModulePercent = $moduleCount > 0 
                ? round(($activeModules / $moduleCount) * 100) 
                : 0;      

        //Users Data
        $userCount=User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        
        $activePercentage = $userCount > 0 ? round(($activeUsers / $userCount) * 100) : 0;
        
        //Organization& Institutions Growth Data
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


        $hospitalMonths = [];
        $hospitalCounts = [];

        foreach ($hospitalData as $data) {
            $hospitalMonths[] = \Carbon\Carbon::createFromFormat('Y-m', $data->month)->format('M Y');
            $hospitalCounts[] = $data->count;
        }

        //donut chart data for user roles
         
        $roleWiseUsers = User::select(
                'roles.name as role_name',
                DB::raw('COUNT(users.id) as total')
            )
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->groupBy('roles.name')
            ->get();


        //Hospital growth data 
      

        return view('dashboard', compact
        ('organizationCount',
        'InstitutionCount',
        'orgData', 'hospitalData','userCount','activeUsers',
        'inactiveUsers',
        'activePercentage',
        'activeHospitals',
        'inactiveHospitals',
        'activeHospitalPercentage',
        'activeOrganizations',
        'inactiveOrganizations',
        'activeOrganizationPercentage',
        'moduleCount',
        'activeModules',
        'inactiveModules',
        'activeModulePercent',
        'roleWiseUsers',
        'hospitalMonths',
        'hospitalCounts'

        ));
    }
}
