<?php

// Auth
use App\Http\Controllers\Admin\DashboardController;
// Admin controllers
use App\Http\Controllers\Admin\FinancialYearController;
use App\Http\Controllers\Admin\FinancialYearMappingController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\Inventory\GrnController;
use App\Http\Controllers\Admin\Inventory\ItemController;
use App\Http\Controllers\Admin\Inventory\PurchaseOrderController;
// Masters controllers
use App\Http\Controllers\Admin\Inventory\ReportController;
use App\Http\Controllers\Admin\Inventory\StockAuditController;
use App\Http\Controllers\Admin\Inventory\StockTransferController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\DepartmentController;
// HR controllers
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\HR\HRDashboardController;
use App\Http\Controllers\HR\StaffManagementController;
use App\Http\Controllers\InstitutionController;
// Module/Institution/Organization controllers
use App\Http\Controllers\JobTypeController;
// HR controllers
use App\Http\Controllers\LeaveManagement\HolidayController;
use App\Http\Controllers\LeaveManagement\WeekendController;
// Pharmacy(GRN)
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\WorkStatusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpiryController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ControlledDrugController;
use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;

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
| ADMIN-ONLY routes  (role = admin)
|--------------------------------------------------------------------------
|
| Admin = Superuser: system setup, masters, institutions, hospitals,
| financial year, modules, etc.
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

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
            ->name('roles.toggle-status');

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
            ->name('users.toggle-status');

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
            ->name('financial-years.toggle-status');

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
            Route::delete('/force-delete/{id}', [WorkStatusController::class, 'forceDelete'])->name('forceDelete');
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
        | Pharmacy: Vendor Management
        |----------------------------------------------------------------------
        */

        Route::prefix('vendors')->name('vendors.')->group(function () {
            Route::get('/', [VendorController::class, 'index'])->name('index');
            Route::get('/create', [VendorController::class, 'create'])->name('create');
            Route::post('/store', [VendorController::class, 'store'])->name('store');
            Route::get('/show/{id}', [VendorController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [VendorController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [VendorController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [VendorController::class, 'destroy'])->name('delete');
            Route::get('/trash', [VendorController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [VendorController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [VendorController::class, 'forceDelete'])->name('forceDelete');
        });

        // ============================
        // PHARMACY -> GRN
        // ============================

        Route::prefix('pharmacy')->name('grn.')->group(function () {

            Route::get('/grn', [GrnController::class, 'index'])->name('index');
            Route::get('/grn/create', [GrnController::class, 'create'])->name('create');
            Route::post('/grn', [GrnController::class, 'store'])->name('store');

    Route::get('/grn', [PharmacyGrnController::class, 'index'])->name('index');
    Route::get('/grn/create', [PharmacyGrnController::class, 'create'])->name('create');
    Route::post('/grn', [PharmacyGrnController::class, 'store'])->name('store');

    Route::get('/grn/{id}', [PharmacyGrnController::class, 'show'])->name('show');
    Route::get('/grn/{id}/edit', [PharmacyGrnController::class, 'edit'])->name('edit');
    Route::put('/grn/{id}', [PharmacyGrnController::class, 'update'])->name('update');
    Route::get('/grn/{id}/verify', [PharmacyGrnController::class, 'verify'])->name('verify');
    Route::post('/grn/{id}/verify', [PharmacyGrnController::class, 'verifyStore'])->name('verify.store');

    Route::post('/grn/{id}/reject', [PharmacyGrnController::class, 'rejectStore'])->name('reject.store');

    Route::get('/grn/{id}/print', [PharmacyGrnController::class, 'print'])
    ->name('print');
    
    Route::get('/grn-trash', [PharmacyGrnController::class, 'trash'])->name('trash');
    Route::delete('/grn/{id}', [PharmacyGrnController::class, 'destroy'])->name('destroy');
    Route::put('/grn-trash/{id}/restore', [PharmacyGrnController::class, 'restore'])->name('restore');
    Route::delete('/grn-trash/{id}/force-delete', [PharmacyGrnController::class, 'forceDelete'])->name('forceDelete');
         });
        /*
|--------------------------------------------------------------------------
| Pharmacy: Controlled Drug Management
|--------------------------------------------------------------------------
*/

        Route::prefix('controlledDrug')->name('controlledDrug.')->group(function () {

            Route::get('/', [ControlledDrugController::class, 'index'])->name('index');

            Route::get('/create', [ControlledDrugController::class, 'create'])->name('create');
            Route::post('/store', [ControlledDrugController::class, 'store'])->name('store');

            Route::get('/edit/{id}', [ControlledDrugController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [ControlledDrugController::class, 'update'])->name('update');

            Route::get('/show/{id}', [ControlledDrugController::class, 'show'])->name('show');
            Route::delete('/delete/{id}', [ControlledDrugController::class, 'destroy'])->name('delete');
            Route::get('/trash', [ControlledDrugController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [ControlledDrugController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [ControlledDrugController::class, 'forceDelete'])->name('forceDelete');

            Route::get('/log', [ControlledDrugController::class, 'log'])->name('log');

            Route::get('/dispense', [ControlledDrugController::class, 'dispenseIndex'])->name('dispenseIndex');
            Route::get('/dispense/create', [ControlledDrugController::class, 'dispenseCreate'])->name('dispenseCreate');
            Route::post('/dispense/store', [ControlledDrugController::class, 'dispenseStore'])->name('dispenseStore');

        });
        /*
        ----------------------------------------------------------------------
        | Pharmacy: stock management
        |----------------------------------------------------------------------
        */

        Route::prefix('stock')->name('stock.')->group(function () {

            Route::get('/', [StockController::class, 'index'])->name('index');

            Route::get('/create', [StockController::class, 'create'])->name('create');
            Route::post('/store', [StockController::class, 'store'])->name('store');

            Route::get('/show/{id}', [StockController::class, 'show'])->name('show');

            Route::get('/edit/{id}', [StockController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [StockController::class, 'update'])->name('update');

            Route::delete('/delete/{id}', [StockController::class, 'destroy'])->name('delete');

            Route::get('/trash', [StockController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [StockController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [StockController::class, 'forceDelete'])->name('forceDelete');

            Route::get('/low-stock', [StockController::class, 'lowStock'])->name('low');

        });

        /*
        |----------------------------------------------------------------------
        | Pharmacy: Expiry
        |----------------------------------------------------------------------
        */

       Route::prefix('expiry')->name('expiry.')->group(function () {

        Route::get('/', [ExpiryController::class, 'index'])->name('index');
        Route::get('/show/{id}', [ExpiryController::class, 'show'])->name('show');
        Route::delete('/delete/{id}', [ExpiryController::class, 'destroy'])->name('delete');
        Route::get('/trash', [ExpiryController::class, 'trash'])->name('trash');
        Route::get('/restore/{id}', [ExpiryController::class, 'restore'])->name('restore');
        Route::get('/force-delete/{id}', [ExpiryController::class, 'forceDelete'])->name('forceDelete');

        // Extra actions (as per requirement)
        Route::post('/mark-expired/{id}', [ExpiryController::class, 'markExpired'])->name('markExpired');
        Route::post('/return-to-vendor/{id}', [ExpiryController::class, 'returnToVendor'])->name('returnToVendor');
        Route::post('/approve/{id}', [ExpiryController::class, 'approve'])->name('approve');
        Route::post('/complete/{id}', [ExpiryController::class, 'complete'])->name('complete');

    });

        /*
        |----------------------------------------------------------------------
        | Pharmacy: Return
        |----------------------------------------------------------------------
        */
        Route::prefix('returns')->name('returns.')->group(function () {
            Route::get('/', [ReturnController::class, 'index'])->name('index');
            Route::get('/create', [ReturnController::class, 'create'])->name('create');
            Route::post('/store', [ReturnController::class, 'store'])->name('store');
            Route::get('/show/{id}', [ReturnController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [ReturnController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [ReturnController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ReturnController::class, 'destroy'])->name('delete');
            Route::get('/trash', [ReturnController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [ReturnController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [ReturnController::class, 'forceDelete'])->name('forceDelete');
        });

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

        Route::get(
            'inventory/reports',
            [ReportController::class, 'index']
        )->name('inventory.reports');

        Route::prefix('inventory')->name('inventory.')->group(function () {

            // ITEMS
            Route::get('/', [ItemController::class, 'index'])->name('index');
            Route::get('/create', [ItemController::class, 'create'])->name('create');
            Route::post('/store', [ItemController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [ItemController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ItemController::class, 'destroy'])->name('delete');

            // PURCHASE ORDERS
            Route::get('purchase-orders', [PurchaseOrderController::class, 'index'])
                ->name('purchase-orders.index');
            Route::get('purchase-orders/deleted', [PurchaseOrderController::class, 'deleted'])
                ->name('purchase-orders.deleted');
            Route::put('purchase-orders/{id}/restore', [PurchaseOrderController::class, 'restore'])
                ->name('purchase-orders.restore');
            Route::delete('purchase-orders/{id}/force-delete', [PurchaseOrderController::class, 'forceDelete'])
                ->name('purchase-orders.forceDelete');
            Route::resource('purchase-orders', PurchaseOrderController::class);

            // GRNS
            Route::resource('grns', GrnController::class);
            Route::resource('stock-transfers', StockTransferController::class);
            Route::resource('stock-audits', StockAuditController::class);

            // Route::get('reports', [ReportController::class, 'index'])->name('inventory.reports');

        });
        /*
        |----------------------------------------------------------------------
        | Weekends (Leave management master)
        |----------------------------------------------------------------------
        */

        Route::prefix('weekends')->name('weekends.')->group(function () {
            Route::get('/', [WeekendController::class, 'index'])->name('index');
            Route::get('/create', [WeekendController::class, 'create'])->name('create');
            Route::post('/store', [WeekendController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [WeekendController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [WeekendController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [WeekendController::class, 'destroy'])->name('delete');
            Route::get('/deleted', [WeekendController::class, 'deleted'])->name('deleted');
            Route::post('/restore/{id}', [WeekendController::class, 'restore'])->name('restore');
            Route::delete('/force-delete/{id}', [WeekendController::class, 'forceDelete'])->name('forceDelete');

            Route::patch('/toggle-status/{id}', [WeekendController::class, 'toggleStatus'])->name('toggleStatus');
        });

        Route::prefix('holidays')->name('holidays.')->group(function () {

            Route::get('/', [HolidayController::class, 'index'])->name('index');
            Route::get('/create', [HolidayController::class, 'create'])->name('create');
            Route::post('/store', [HolidayController::class, 'store'])->name('store');
            Route::get('/show/{id}', [HolidayController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [HolidayController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [HolidayController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [HolidayController::class, 'destroy'])->name('delete');

            Route::get('/deleted', [HolidayController::class, 'deleted'])->name('deleted');
            Route::post('/restore/{id}', [HolidayController::class, 'restore'])->name('restore');
            Route::delete('/force-delete/{id}', [HolidayController::class, 'forceDelete'])->name('forceDelete');

            Route::patch('/toggle-status/{id}', [HolidayController::class, 'toggleStatus'])->name('toggleStatus');
        });
        /*
        |----------------------------------------------------------------------
        | Beds
        |----------------------------------------------------------------------
        */

        Route::get('beds/deleted', [BedController::class, 'deleted'])
            ->name('beds.deleted');

        Route::put('beds/{id}/restore', [BedController::class, 'restore'])
            ->name('beds.restore');

        Route::delete('beds/{id}/force-delete', [BedController::class, 'forceDelete'])
            ->name('beds.forceDelete');

        Route::get('beds/generate-code/{ward}', [BedController::class, 'generateCode'])
            ->name('beds.generateCode');
        Route::resource('beds', BedController::class);

    });

});

/*
|--------------------------------------------------------------------------
| HR MODULE routes  (role = hr OR admin)
|--------------------------------------------------------------------------
|
| HR = staff management. Admin can also access (superuser).
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:hr,admin'])
    ->prefix('hr')
    ->name('hr.')
    ->group(function () {

        // HR Dashboard (create later)
        Route::get('/dashboard', [HRDashboardController::class, 'index'])
            ->name('dashboard');

        // Staff management (employee master) – moved here for HR
        Route::get('staff-management/deleted', [StaffManagementController::class, 'deleted'])
            ->name('staff-management.deleted');

        Route::put('staff-management/{id}/restore', [StaffManagementController::class, 'restore'])
            ->name('staff-management.restore');

        Route::delete('staff-management/{id}/force-delete', [StaffManagementController::class, 'forceDelete'])
            ->name('staff-management.forceDelete');

        Route::patch('staff-management/{id}/toggleStatus', [StaffManagementController::class, 'toggleStatus'])
            ->name('staff-management.toggleStatus');

        Route::resource('staff-management', StaffManagementController::class);
    });

Route::prefix('stock')->group(function () {

    Route::get('stock', [StockController::class, 'apiIndex']);
    Route::get('stock/low', [StockController::class, 'apiLowStock']);
    Route::get('stock/{id}', [StockController::class, 'apiShow']);

    Route::post('stock', [StockController::class, 'apiStore']);
    Route::put('stock/{id}', [StockController::class, 'apiUpdate']);

    Route::delete('stock/{id}', [StockController::class, 'apiDestroy']);

    Route::get('stock-trash', [StockController::class, 'apiTrash']);
    Route::post('stock-restore/{id}', [StockController::class, 'apiRestore']);
    Route::delete('stock-force-delete/{id}', [StockController::class, 'apiForceDelete']);
 });