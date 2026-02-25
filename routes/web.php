<?php

use App\Http\Controllers\Admin\DashboardController;
// Auth & Admin controllers
use App\Http\Controllers\Admin\FinancialYearController;
use App\Http\Controllers\Admin\FinancialYearMappingController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\BloodGroupController;
// Masters controllers
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\WorkStatusController;

use App\Http\Controllers\BedController;
use App\Http\Controllers\WardController;
use Illuminate\Support\Facades\Route;

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

    Route::post('/logout', [SignInController::class, 'logout'])->name('logout');

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
        | Roles
        |----------------------------------------------------------------------
        */

        Route::get('roles/deleted', [RoleController::class, 'displayDeletedRoles'])
            ->name('roles.deleted');
        Route::put('roles/{id}/restore', [RoleController::class, 'restore'])
            ->name('roles.restore');
        Route::delete('roles/{id}/force-delete', [RoleController::class, 'forceDeleteRole'])
            ->name('roles.forceDelete');
        Route::patch('roles/{id}/toggle-status', [RoleController::class, 'toggleStatus'])
            ->name('roles.toggleStatus');

        Route::resource('roles', RoleController::class)->except(['show']);

        /*
        |----------------------------------------------------------------------
        | Users
        |----------------------------------------------------------------------
        */

        Route::get('users/deleted', [UserController::class, 'displayDeletedUser'])
            ->name('users.deleted');
        Route::put('users/{id}/restore', [UserController::class, 'restore'])
            ->name('users.restore');
        Route::delete('users/{id}/force-delete', [UserController::class, 'forceDeleteUser'])
            ->name('users.forceDelete');
        Route::patch('users/{id}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggleStatus');

        Route::resource('users', UserController::class)->except(['show']);

        /*
        |----------------------------------------------------------------------
        | Financial Years & Mapping
        |----------------------------------------------------------------------
        */

        Route::get('financial-years/mapping', [FinancialYearMappingController::class, 'index'])
            ->name('financial-years.mapping');
        Route::post('financial-years/mapping', [FinancialYearMappingController::class, 'store'])
            ->name('financial-years.mapping.store');
        Route::patch('financial-years/{id}/toggle-status', [FinancialYearController::class, 'toggleStatus'])
            ->name('financial-years.toggleStatus');

        Route::resource('financial-years', FinancialYearController::class)->except(['show']);

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
        | Masters: Blood Group
        |----------------------------------------------------------------------
        */

        Route::get('blood-groups/deleted/history', [BloodGroupController::class, 'deletedHistory'])
            ->name('blood-groups.deleted');
        Route::put('blood-groups/{id}/restore', [BloodGroupController::class, 'restore'])
            ->name('blood-groups.restore');
        Route::delete('blood-groups/{id}/force-delete', [BloodGroupController::class, 'forceDelete'])
            ->name('blood-groups.forceDelete');

        Route::prefix('masters')->group(function () {
            Route::resource('blood-groups', BloodGroupController::class)->except(['show']);
        });

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

        Route::get('departments/deleted/history', [DepartmentController::class, 'deletedHistory'])
            ->name('departments.deleted');
        Route::put('departments/{id}/restore', [DepartmentController::class, 'restore'])
            ->name('departments.restore');
        Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'forceDelete'])
            ->name('departments.forceDelete');

        Route::resource('departments', DepartmentController::class);

        /*
        |----------------------------------------------------------------------
        | Organization
        |----------------------------------------------------------------------
        */

        Route::get('organization/deleted', [OrganizationController::class, 'deleted'])
            ->name('organization.deleted');
        Route::put('organization/{id}/restore', [OrganizationController::class, 'restore'])
            ->name('organization.restore');
        Route::delete('organization/{id}/force-delete', [OrganizationController::class, 'forceDelete'])
            ->name('organization.forceDelete');
        Route::patch('organization/{id}/toggle-status', [OrganizationController::class, 'toggleStatus'])
            ->name('organization.toggleStatus');

        Route::resource('organization', OrganizationController::class);

        /*
|--------------------------------------------------------------------------
| Wards
|--------------------------------------------------------------------------
*/

        Route::get('ward/deleted', [WardController::class, 'deleted'])
            ->name('ward.deleted');

        Route::put('ward/{id}/restore', [WardController::class, 'restore'])
            ->name('ward.restore');

        Route::delete('ward/{id}/force-delete', [WardController::class, 'forceDelete'])
            ->name('ward.forceDelete');

        Route::patch('ward/{id}/toggle-status', [WardController::class, 'toggleStatus'])
            ->name('ward.toggleStatus');

        Route::resource('ward', WardController::class);

        /*
        |----------------------------------------------------------------------
        | Institutions
        |----------------------------------------------------------------------
        */

        Route::get('institutions/deleted', [InstitutionController::class, 'deleted'])
            ->name('institutions.deleted');
        Route::put('institutions/{id}/restore', [InstitutionController::class, 'restore'])
            ->name('institutions.restore');
        Route::delete('institutions/{id}/force-delete', [InstitutionController::class, 'forceDelete'])
            ->name('institutions.forceDelete');
        Route::patch('institutions/{id}/toggle-status', [InstitutionController::class, 'toggleStatus'])
            ->name('institutions.toggleStatus');

        Route::resource('institutions', InstitutionController::class);

        /*
        |----------------------------------------------------------------------
        | Hospitals
        |----------------------------------------------------------------------
        */

        Route::get('hospitals/deleted', [HospitalController::class, 'deleted'])
            ->name('hospitals.deleted');
        Route::put('hospitals/{id}/restore', [HospitalController::class, 'restore'])
            ->name('hospitals.restore');
        Route::delete('hospitals/{id}/force-delete', [HospitalController::class, 'forceDelete'])
            ->name('hospitals.forceDelete');
        Route::patch('hospitals/{id}/toggle-status', [HospitalController::class, 'toggleStatus'])
            ->name('hospitals.toggleStatus');

        Route::resource('hospitals', HospitalController::class)->except(['show']);

        /*
        |----------------------------------------------------------------------
        | Modules
        |----------------------------------------------------------------------
        */

        Route::prefix('modules')->name('modules.')->group(function () {

            Route::get('/', [ModuleController::class, 'index'])->name('index');

            Route::get('/create', [ModuleController::class, 'create'])->name('create');
            Route::post('/store', [ModuleController::class, 'store'])->name('store');

            Route::get('/show/{id}', [ModuleController::class, 'show'])->name('show');

            Route::get('/edit/{id}', [ModuleController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [ModuleController::class, 'update'])->name('update');

            Route::delete('/delete/{id}', [ModuleController::class, 'destroy'])->name('delete');

            Route::get('/deleted', [ModuleController::class, 'deleted'])->name('deleted');
            Route::post('/restore/{id}', [ModuleController::class, 'restore'])->name('restore');
            Route::delete('/force-delete/{id}', [ModuleController::class, 'forceDelete'])->name('forceDelete');

            Route::patch('/toggle-status/{id}', [ModuleController::class, 'toggleStatus'])->name('toggleStatus');

        });
         /*
        |----------------------------------------------------------------------
        | Beds
        |----------------------------------------------------------------------
        */
        Route::prefix('beds')->name('beds.')->group(function () {

                    Route::get('/', [BedController::class, 'index'])->name('index');

                    Route::get('/create', [BedController::class, 'create'])->name('create');
                    Route::post('/store', [BedController::class, 'store'])->name('store');

                    Route::get('/show/{id}', [BedController::class, 'show'])->name('show');

                    Route::get('/edit/{id}', [BedController::class, 'edit'])->name('edit');
                    Route::put('/update/{id}', [BedController::class, 'update'])->name('update');

                    Route::delete('/delete/{id}', [BedController::class, 'destroy'])->name('delete');
        });           

    });
});
