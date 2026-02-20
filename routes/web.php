<?php

use Illuminate\Support\Facades\Route;

// Auth & Admin controllers
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FinancialYearController;
use App\Http\Controllers\Admin\FinancialYearMappingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HospitalController;

// Masters controllers
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\WorkStatusController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ModuleController;


/*
|--------------------------------------------------------------------------
| Public (guest) routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'auth.login')->name('login');
Route::view('/forgot-mpin', 'auth.forgot-mpin')->name('forgot.mpin');
Route::view('/set-mpin', 'auth.set-mpin')->name('set.mpin');
Route::view('/otp', 'auth.otp')->name('otp');
Route::get('/create-default-admin', [SignInController::class, 'createDefaultAdmin'])
    ->name('admin.create.default');
/*
|--------------------------------------------------------------------------
| Auth-related POST actions
|--------------------------------------------------------------------------
*/

Route::post('/login', [SignInController::class, 'login'])->name('login.submit');
Route::post('/send-otp', [SignInController::class, 'sendOtp'])->name('forgot.mpin.submit');
Route::post('/resend-otp', [SignInController::class, 'resendOtp'])->name('otp.resend');
Route::post('/verify-otp', [SignInController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/set-mpin', [SignInController::class, 'setMpin'])->name('mpin.store');

/*
|--------------------------------------------------------------------------
| Authenticated + Admin-only routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    // Logout
    Route::post('/logout', [SignInController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Admin prefix & name prefix
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->name('admin.')->group(function () {

        /*
        |----------------------------------------------------------------------
        | Dashboard
        |----------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |----------------------------------------------------------------------
        | Roles & Users
        |----------------------------------------------------------------------
        */

        // Roles CRUD (resource, except show)
        Route::resource('roles', RoleController::class)->except(['show']);

        // Roles extra routes (deleted, restore, force delete)
        Route::get('roles/deleted', [RoleController::class, 'displayDeletedRoles'])->name('roles.deleted');
        Route::put('roles/{id}/restore', [RoleController::class, 'restore'])->name('roles.restore');
        Route::delete('roles/{id}/force-delete', [RoleController::class, 'forceDeleteRole'])->name('roles.forceDelete');

        // Users CRUD (resource, except show)
        Route::resource('users', UserController::class)->except(['show']);

        // Users extra routes (deleted, restore, force delete)
        Route::get('users/deleted', [UserController::class, 'displayDeletedUser'])->name('users.deleted');
        Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('users/{id}/force-delete', [UserController::class, 'forceDeleteUser'])->name('users.forceDelete');

        /*
        |----------------------------------------------------------------------
        | Financial Years & Mapping
        |----------------------------------------------------------------------
        */

        // Financial Years CRUD (resource, except show)
        Route::resource('financial-years', FinancialYearController::class)->except(['show']);

        // Financial Year Mapping
        Route::get('financial-years/mapping', [FinancialYearMappingController::class, 'index'])
            ->name('financial-years.mapping');
        Route::post('financial-years/mapping', [FinancialYearMappingController::class, 'store'])
            ->name('financial-years.mapping.store');

        /*
        |----------------------------------------------------------------------
        | Masters: Religion
        |----------------------------------------------------------------------
        */

        Route::prefix('religion')->name('religion.')->group(function () {
            Route::get('/', [ReligionController::class, 'index'])->name('index');
            Route::get('/create', [ReligionController::class, 'create'])->name('create');
            Route::post('/store', [ReligionController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ReligionController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [ReligionController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ReligionController::class, 'destroy'])->name('delete');

            Route::get('/trash', [ReligionController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [ReligionController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [ReligionController::class, 'forceDelete'])->name('forceDelete');
        });

        /*
        |----------------------------------------------------------------------
        | Masters: Job Type
        |----------------------------------------------------------------------
        */

        Route::prefix('job-type')->name('job-type.')->group(function () {
            Route::get('/', [JobTypeController::class, 'index'])->name('index');
            Route::get('/create', [JobTypeController::class, 'create'])->name('create');
            Route::post('/store', [JobTypeController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [JobTypeController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [JobTypeController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [JobTypeController::class, 'destroy'])->name('delete');

            Route::get('/trash', [JobTypeController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [JobTypeController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [JobTypeController::class, 'forceDelete'])->name('forceDelete');
        });

        /*
        |----------------------------------------------------------------------
        | Masters: Work Status
        |----------------------------------------------------------------------
        */

        Route::prefix('work-status')->name('work-status.')->group(function () {
            Route::get('/', [WorkStatusController::class, 'index'])->name('index');
            Route::get('/create', [WorkStatusController::class, 'create'])->name('create');
            Route::post('/store', [WorkStatusController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [WorkStatusController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [WorkStatusController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [WorkStatusController::class, 'destroy'])->name('delete');

            Route::get('/trash', [WorkStatusController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [WorkStatusController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [WorkStatusController::class, 'forceDelete'])->name('forceDelete');
        });

        /*
        |----------------------------------------------------------------------
        | Masters: Blood Group (resource-style)
        |----------------------------------------------------------------------
        */

        Route::prefix('masters')->group(function () {
            Route::resource('blood-groups', BloodGroupController::class)->except(['show']);
        });

        Route::get('blood-groups/deleted/history', [BloodGroupController::class, 'deletedHistory'])
            ->name('blood-groups.deleted');
        Route::put('blood-groups/{id}/restore', [BloodGroupController::class, 'restore'])
            ->name('blood-groups.restore');
        Route::delete('blood-groups/{id}/force-delete', [BloodGroupController::class, 'forceDelete'])
            ->name('blood-groups.forceDelete');

        /*
        |----------------------------------------------------------------------
        | Masters: Designation
        |----------------------------------------------------------------------
        */

        Route::prefix('designation')->name('designation.')->group(function () {
            Route::get('/', [DesignationController::class, 'index'])->name('index');
            Route::get('/create', [DesignationController::class, 'create'])->name('create');
            Route::post('/store', [DesignationController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [DesignationController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [DesignationController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [DesignationController::class, 'destroy'])->name('delete');

            Route::get('/trash', [DesignationController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [DesignationController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [DesignationController::class, 'forceDelete'])->name('forceDelete');
        });

        /*
        |----------------------------------------------------------------------
        | Masters: Department
        |----------------------------------------------------------------------
        */

        Route::resource('departments', DepartmentController::class);
        Route::get('departments/deleted/history', [DepartmentController::class, 'deletedHistory'])
            ->name('departments.deleted');
        Route::put('departments/{id}/restore', [DepartmentController::class, 'restore'])
            ->name('departments.restore');
        Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'forceDelete'])
            ->name('departments.forceDelete');

        /*
        |----------------------------------------------------------------------
        | Hospitals, Organization, Institutions, Modules
        |----------------------------------------------------------------------
        */

        Route::resource('organization', OrganizationController::class);
        Route::resource('institutions', InstitutionController::class);
        Route::resource('hospitals', HospitalController::class)->except(['show']);

        // Deleted Institutions
        Route::get(
            'institutions/deleted',
            [InstitutionController::class, 'deleted']
        )->name('institutions.deleted');

        Route::put(
            'institutions/{id}/restore',
            [InstitutionController::class, 'restore']
        )->name('institutions.restore');

        Route::delete(
            'institutions/{id}/force-delete',
            [InstitutionController::class, 'forceDelete']
        )->name('institutions.forceDelete');

        Route::resource('modules', ModuleController::class);

        Route::prefix('modules')->name('modules.')->group(function () {
            Route::get('/', [ModuleController::class, 'index'])->name('index');
            Route::get('/create', [ModuleController::class, 'create'])->name('create');
            Route::get('/edit/{id}', [ModuleController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [ModuleController::class, 'update'])->name('update');
             Route::get('/deleted/history', [ModuleController::class, 'deletedHistory'])->name('deleted');
             Route::put('/{id}/restore', [ModuleController::class, 'restore'])->name('restore');
             Route::delete('/{id}/force-delete', [ModuleController::class, 'forceDelete'])->name('forceDelete');
        });
        /*
        |----------------------------------------------------------------------
        | Toggle Status Routes
        |----------------------------------------------------------------------
        */

        Route::patch(
            'modules/{id}/toggle-status',
            [ModuleController::class, 'toggleStatus']
        )
            ->name('modules.toggleStatus');

        Route::patch(
            'financial-years/{financial_year}/toggle-status',
            [FinancialYearController::class, 'toggleStatus']
        )->name('financial-years.toggle-status');

        Route::patch(
            'roles/{role}/toggle-status',
            [RoleController::class, 'toggleStatus']
        )->name('roles.toggle-status');

        Route::patch(
            'users/{user}/toggle-status',
            [UserController::class, 'toggleStatus']
        )->name('users.toggle-status');

        Route::patch(
            'institutions/{id}/toggle-status',
            [InstitutionController::class, 'toggleStatus']
        )->name('institutions.toggleStatus');

        Route::patch(
            'hospitals/{id}/toggle-status',
            [HospitalController::class, 'toggleStatus']
        )->name('hospitals.toggle-status');

    });
});
