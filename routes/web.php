<?php

use App\Http\Controllers\Admin\AdminBiometricEnrollController;
/*
|--------------------------------------------------------------------------
| Controller Imports
|--------------------------------------------------------------------------
*/

// Auth / Dashboard
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FinancialYearController;
// Admin: users / roles / FY / hospitals
use App\Http\Controllers\Admin\FinancialYearMappingController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\Inventory\GrnController;
use App\Http\Controllers\Admin\Inventory\InventoryVendorController;
use App\Http\Controllers\Admin\Inventory\ItemController;
// Masters
use App\Http\Controllers\Admin\Inventory\PurchaseOrderController;
use App\Http\Controllers\Admin\Inventory\ReportController;
use App\Http\Controllers\Admin\Inventory\StockAuditController;
use App\Http\Controllers\Admin\Inventory\StockTransferController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\BedController;
// Inventory (admin)
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\ControlledDrugController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ExpiryController;
use App\Http\Controllers\HR\HRDashboardController;
use App\Http\Controllers\HR\StaffManagementController;
// Pharmacy
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\LeaveManagement\HolidayController;
use App\Http\Controllers\LeaveManagement\LeaveMappingController;
use App\Http\Controllers\LeaveManagement\LeaveAdjustmentController;
use App\Http\Controllers\ModuleController;
// Beds / Wards / Patients
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\StockController;
// HR
use App\Http\Controllers\TokenController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\WorkStatusController;
// Reception / Tokens
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
| ADMIN AREA (auth + role:admin, prefix admin, name admin.)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard + Logout
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/logout', [SignInController::class, 'logout'])
            ->name('logout');

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | User Biometrics Enrollment
        |--------------------------------------------------------------------------
        */
        Route::get('users/biometrics', [AdminBiometricEnrollController::class, 'biometrics'])
            ->name('users.biometrics');

        Route::post('users/{user}/biometrics/upload', [AdminBiometricEnrollController::class, 'upload'])
            ->name('users.biometrics.upload');

        Route::delete('users/biometrics/images/{imageId}', [AdminBiometricEnrollController::class, 'delete'])
            ->name('users.biometrics.delete');

        /*
        |--------------------------------------------------------------------------
        | Financial Years & Mapping
        |--------------------------------------------------------------------------
        */

        Route::get('financial-years/mapping', [FinancialYearMappingController::class, 'index'])
            ->name('financial-years.mapping');
        Route::post('financial-years/mapping', [FinancialYearMappingController::class, 'store'])
            ->name('financial-years.mapping.store');
        Route::patch('financial-years/{id}/toggle-status', [FinancialYearController::class, 'toggleStatus'])
            ->name('financial-years.toggle-status');

        Route::resource('financial-years', FinancialYearController::class)->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Masters: Religion
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | Masters: Job Type
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | Masters: Work Status
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | Masters: Blood Group
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | Masters: Designation
        |--------------------------------------------------------------------------
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
            Route::get('/force-delete/{id>', [DesignationController::class, 'forceDelete'])->name('forceDelete');
        });

        /*
        |--------------------------------------------------------------------------
        | Masters: Department
        |--------------------------------------------------------------------------
        */

        Route::get('departments/deleted/history', [DepartmentController::class, 'deletedHistory'])
            ->name('departments.deleted');
        Route::put('departments/{id}/restore', [DepartmentController::class, 'restore'])
            ->name('departments.restore');
        Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'forceDelete'])
            ->name('departments.forceDelete');

        Route::resource('departments', DepartmentController::class);

        /*
        |--------------------------------------------------------------------------
        | Organization
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | Institutions
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | Hospitals
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | Pharmacy: Vendor Management
        |--------------------------------------------------------------------------
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

        /*
        |--------------------------------------------------------------------------
        | Pharmacy: GRN (PharmacyGrnController only)
        |--------------------------------------------------------------------------
        */

        Route::prefix('pharmacy')->name('grn.')->group(function () {
            Route::get('/grn', [PharmacyGrnController::class, 'index'])->name('index');
            Route::get('/grn/create', [PharmacyGrnController::class, 'create'])->name('create');
            Route::post('/grn', [PharmacyGrnController::class, 'store'])->name('store');

            Route::get('/grn/{id}', [PharmacyGrnController::class, 'show'])->name('show');
            Route::get('/grn/{id}/edit', [PharmacyGrnController::class, 'edit'])->name('edit');
            Route::put('/grn/{id}', [PharmacyGrnController::class, 'update'])->name('update');
            Route::get('/grn/{id}/verify', [PharmacyGrnController::class, 'verify'])->name('verify');
            Route::post('/grn/{id}/verify', [PharmacyGrnController::class, 'verifyStore'])->name('verify.store');

            Route::post('/grn/{id}/reject', [PharmacyGrnController::class, 'rejectStore'])->name('reject.store');
            Route::get('/grn/{id}/print', [PharmacyGrnController::class, 'print'])->name('print');

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
        |--------------------------------------------------------------------------
        | Pharmacy: Stock Management
        |--------------------------------------------------------------------------
        */

        Route::prefix('stock')->name('stock.')->group(function () {
            Route::get('/', [StockController::class, 'index'])->name('index');

            Route::get('/create', [StockController::class, 'create'])->name('create');
            Route::post('/store', [StockController::class, 'store'])->name('store');

            Route::get('/show/{id}', [StockController::class, 'show'])->name('show');

            Route::get('/edit/{id}', [StockController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [StockController::class, 'update'])->name('update');

            Route::delete('/delete/{id>', [StockController::class, 'destroy'])->name('delete');

            Route::get('/trash', [StockController::class, 'trash'])->name('trash');
            Route::get('/restore/{id>', [StockController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id>', [StockController::class, 'forceDelete'])->name('forceDelete');

            Route::get('/low-stock', [StockController::class, 'lowStock'])->name('low');
        });

        /*
        |--------------------------------------------------------------------------
        | Pharmacy: Expiry
        |--------------------------------------------------------------------------
        */

        Route::prefix('expiry')->name('expiry.')->group(function () {
            Route::get('/', [ExpiryController::class, 'index'])->name('index');
            Route::get('/show/{id}', [ExpiryController::class, 'show'])->name('show');
            Route::delete('/delete/{id}', [ExpiryController::class, 'destroy'])->name('delete');
            Route::get('/trash', [ExpiryController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [ExpiryController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [ExpiryController::class, 'forceDelete'])->name('forceDelete');

            Route::post('/mark-expired/{id}', [ExpiryController::class, 'markExpired'])->name('markExpired');
            Route::post('/return-to-vendor/{id}', [ExpiryController::class, 'returnToVendor'])->name('returnToVendor');
            Route::post('/approve/{id}', [ExpiryController::class, 'approve'])->name('approve');
            Route::post('/complete/{id}', [ExpiryController::class, 'complete'])->name('complete');
        });

        /*
        |--------------------------------------------------------------------------
        | Modules
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | Inventory (admin web)
        |--------------------------------------------------------------------------
        */

        Route::get('inventory/reports', [ReportController::class, 'index'])
            ->name('inventory.reports');

        Route::prefix('inventory')->name('inventory.')->group(function () {

            // Items
            Route::get('/', [ItemController::class, 'index'])->name('index');
            Route::get('/create', [ItemController::class, 'create'])->name('create');
            Route::post('/store', [ItemController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [ItemController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ItemController::class, 'destroy'])->name('delete');
            Route::patch('/toggle-status/{id}', [ItemController::class, 'toggleStatus'])->name('toggleStatus');

            // Purchase Orders
            Route::get('purchase-orders', [PurchaseOrderController::class, 'index'])
                ->name('purchase-orders.index');
            Route::get('purchase-orders/deleted', [PurchaseOrderController::class, 'deleted'])
                ->name('purchase-orders.deleted');
            Route::put('purchase-orders/{id}/restore', [PurchaseOrderController::class, 'restore'])
                ->name('purchase-orders.restore');
            Route::delete('purchase-orders/{id}/force-delete', [PurchaseOrderController::class, 'forceDelete'])
                ->name('purchase-orders.forceDelete');
            Route::resource('purchase-orders', PurchaseOrderController::class);

            // GRNs, transfers, audits
            Route::resource('grns', GrnController::class);
            Route::resource('stock-transfers', StockTransferController::class);
            Route::resource('stock-audits', StockAuditController::class);
        });

        /*
        |--------------------------------------------------------------------------
        | Inventory Vendors (for sidebar Vendors under Inventory)
        |--------------------------------------------------------------------------
        */

        Route::prefix('inventory-vendors')->name('inventory-vendors.')->group(function () {
            Route::get('/', [InventoryVendorController::class, 'index'])->name('index');
            Route::get('/create', [InventoryVendorController::class, 'create'])->name('create');
            Route::post('/store', [InventoryVendorController::class, 'store'])->name('store');
            Route::get('/show/{id}', [InventoryVendorController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [InventoryVendorController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [InventoryVendorController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [InventoryVendorController::class, 'delete'])->name('delete');
            Route::get('/trash', [InventoryVendorController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [InventoryVendorController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [InventoryVendorController::class, 'forceDelete'])->name('forceDelete');
        });

        /*
        |--------------------------------------------------------------------------
        | Weekends (Leave management master)
        |--------------------------------------------------------------------------
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

        /*
        |--------------------------------------------------------------------------
        | Holidays (Leave management master)
        |--------------------------------------------------------------------------
        */

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
        |--------------------------------------------------------------------------
        | Leave Types (Leave management master)
        |--------------------------------------------------------------------------
        */

        Route::prefix('leave-type')->name('leave-type.')->group(function () {
            Route::get('/', [LeaveTypeController::class, 'index'])->name('index');
            Route::get('/create', [LeaveTypeController::class, 'create'])->name('create');
            Route::post('/store', [LeaveTypeController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [LeaveTypeController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [LeaveTypeController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [LeaveTypeController::class, 'destroy'])->name('delete');
            Route::get('/deleted', [LeaveTypeController::class, 'deleted'])->name('deleted');
            Route::post('/restore/{id}', [LeaveTypeController::class, 'restore'])->name('restore');
            Route::delete('/force-delete/{id}', [LeaveTypeController::class, 'forceDelete'])->name('forceDelete');
        });

        /*
        |--------------------------------------------------------------------------
        | Leave Mappings (Leave management master)
        |--------------------------------------------------------------------------
        */

        Route::prefix('leave-mappings')->name('leave-mappings.')->group(function () {
            Route::get('/', [LeaveMappingController::class, 'index'])->name('index');
            Route::get('/create', [LeaveMappingController::class, 'create'])->name('create');
            Route::post('/store', [LeaveMappingController::class, 'store'])->name('store');
            Route::get('/show/{id}', [LeaveMappingController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [LeaveMappingController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [LeaveMappingController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [LeaveMappingController::class, 'destroy'])->name('delete');

            Route::get('/deleted', [LeaveMappingController::class, 'deleted'])->name('deleted');
            Route::post('/restore/{id}', [LeaveMappingController::class, 'restore'])->name('restore');
            Route::delete('/force-delete/{id}', [LeaveMappingController::class, 'forceDelete'])->name('forceDelete');
            Route::patch('/toggle-status/{id}', [LeaveMappingController::class, 'toggleStatus'])->name('toggleStatus');
        });



        // |----------------------------------------------------------------------
        // | Leave Adjustment
        // |----------------------------------------------------------------------
Route::prefix('leave-adjustments')->name('leave-adjustments.')->group(function () {

    Route::get('/', [LeaveAdjustmentController::class, 'index'])->name('index');

    Route::get('/create', [LeaveAdjustmentController::class, 'create'])->name('create');

    Route::post('/store', [LeaveAdjustmentController::class, 'store'])->name('store');

    Route::get('/mapping/{staff}', [LeaveAdjustmentController::class, 'getLeaveMapping'])->name('mapping');
    Route::get('/show/{id}', [LeaveAdjustmentController::class, 'show'])
    ->name('show');
});

        /*
        |--------------------------------------------------------------------------
        | Beds
        |--------------------------------------------------------------------------
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

        /*
        |--------------------------------------------------------------------------
        | Patients (admin web)
        |--------------------------------------------------------------------------
        */

        Route::get('patients/duplicates', [PatientController::class, 'duplicates'])
            ->name('patients.duplicates');
        Route::post('patients/merge', [PatientController::class, 'merge'])
            ->name('patients.merge');
        Route::get('patients/deleted', [PatientController::class, 'deleted'])
            ->name('patients.deleted');
        Route::put('patients/{id}/restore', [PatientController::class, 'restore'])
            ->name('patients.restore');
        Route::delete('patients/{id}/force-delete', [PatientController::class, 'forceDelete'])
            ->name('patients.forceDelete');
        Route::patch('patients/{id}/toggle-status', [PatientController::class, 'toggleStatus'])
            ->name('patients.toggleStatus');
        Route::patch('patients/{id}/toggle-vip', [PatientController::class, 'toggleVip'])
            ->name('patients.toggleVip');

        Route::resource('patients', PatientController::class);

        /*
        |--------------------------------------------------------------------------
        | Reception: Tokens / Queue
        |--------------------------------------------------------------------------
        */

        Route::prefix('tokens')->name('tokens.')->group(function () {
            Route::get('/', [TokenController::class, 'index'])->name('index');
            Route::get('/create', [TokenController::class, 'create'])->name('create');
            Route::post('/store', [TokenController::class, 'store'])->name('store');
        });
    });

/*
|--------------------------------------------------------------------------
| HR MODULE routes (role = hr OR admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:hr,admin'])
    ->prefix('hr')
    ->name('hr.')
    ->group(function () {

        Route::get('/dashboard', [HRDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('staff-management', [StaffManagementController::class, 'index'])
            ->name('staff-management.index');
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

/*
|--------------------------------------------------------------------------
| Stock API routes (no auth middleware)
|--------------------------------------------------------------------------
*/

Route::prefix('stock')->group(function () {
    // (your existing stock API routes here if any; the commented
    // temporary Leave Type UI routes have been removed to avoid conflicts)
});
