<?php

use App\Http\Controllers\Admin\DashboardController;
// Auth Controller
use App\Http\Controllers\Admin\FinancialYearController;
// Dashboard
use App\Http\Controllers\Admin\FinancialYearMappingController;
use App\Http\Controllers\Admin\Inventory\GrnController;
// Masters
use App\Http\Controllers\Admin\Inventory\ItemController;
use App\Http\Controllers\Admin\Inventory\PurchaseOrderController;
use App\Http\Controllers\Admin\Inventory\ReportController;
use App\Http\Controllers\Admin\Inventory\StockAuditController;
use App\Http\Controllers\Admin\Inventory\StockTransferController;
use App\Http\Controllers\Admin\InventoryVendorController;
// Organization / Institution
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\SignInController;
// HR
use App\Http\Controllers\BedController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\DepartmentController;
// Inventory
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\HR\HRDashboardController;
use App\Http\Controllers\HR\StaffManagementController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\LeaveManagement\HolidayController;
use App\Http\Controllers\LeaveManagement\WeekendController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ReligionController;
// Role & User
use App\Http\Controllers\StockController;
use App\Http\Controllers\VendorController;
// Beds / Wards / Patients
use App\Http\Controllers\WardController;
use App\Http\Controllers\WorkStatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public (Guest) Routes
|--------------------------------------------------------------------------
*/
Route::view('/', 'auth.login')->name('login');
Route::view('/forgot-mpin', 'auth.forgot-mpin')->name('forgot.mpin');
Route::view('/set-mpin', 'auth.set-mpin')->name('set.mpin');
Route::view('/otp', 'auth.otp')->name('otp');

Route::get('/create-default-admin', [SignInController::class, 'createDefaultAdmin'])->name('admin.create.default');

Route::post('/login', [SignInController::class, 'login'])->name('login.submit');
Route::post('/send-otp', [SignInController::class, 'sendOtp'])->name('forgot.mpin.submit');
Route::post('/resend-otp', [SignInController::class, 'resendOtp'])->name('otp.resend');
Route::post('/verify-otp', [SignInController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/set-mpin', [SignInController::class, 'setMpin'])->name('mpin.store');

/*
|--------------------------------------------------------------------------
| Authenticated Admin Routes (includes HR + Inventory + Masters)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Logout
    Route::post('/logout', [SignInController::class, 'logout'])->name('logout');

    // Dashboards
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/hr/dashboard', [HRDashboardController::class, 'index'])->name('hr.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Role & User Management
    |--------------------------------------------------------------------------
    */
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('users', UserController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | Financial Years & Mapping
    |--------------------------------------------------------------------------
    */
    Route::resource('financial-years', FinancialYearController::class)->except(['show']);
    Route::get('financial-years/mapping', [FinancialYearMappingController::class, 'index'])->name('financial-years.mapping');
    Route::post('financial-years/mapping', [FinancialYearMappingController::class, 'store'])->name('financial-years.mapping.store');

    /*
    |--------------------------------------------------------------------------
    | Masters
    |--------------------------------------------------------------------------
    */
    Route::resources([
        'religion' => ReligionController::class,
        'job-type' => JobTypeController::class,
        'work-status' => WorkStatusController::class,
        'designation' => DesignationController::class,
        'departments' => DepartmentController::class,
    ]);

    Route::resource('masters/blood-groups', BloodGroupController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | Organizations, Institutions, Hospitals
    |--------------------------------------------------------------------------
    */
    Route::resources([
        'organization' => OrganizationController::class,
        'institutions' => InstitutionController::class,
        'hospitals' => HospitalController::class,
        'modules' => ModuleController::class,
    ]);

    /*
    |--------------------------------------------------------------------------
    | HR: Staff, Weekends, Holidays
    |--------------------------------------------------------------------------
    */
    Route::resource('staff-management', StaffManagementController::class);
    Route::resource('weekends', WeekendController::class);
    Route::resource('holidays', HolidayController::class);

    /*
    |--------------------------------------------------------------------------
    | Wards, Beds, Patients
    |--------------------------------------------------------------------------
    */
    Route::resource('ward', WardController::class);
    Route::resource('beds', BedController::class);
    Route::get('beds/generate-code/{ward}', [BedController::class, 'generateCode'])->name('beds.generateCode');

    Route::resource('patients', PatientController::class);
    Route::get('patients/duplicates', [PatientController::class, 'duplicates'])->name('patients.duplicates');
    Route::post('patients/merge', [PatientController::class, 'merge'])->name('patients.merge');

    /*
    |--------------------------------------------------------------------------
    | Inventory Management (Pharmacy)
    |--------------------------------------------------------------------------
    */
    Route::prefix('inventory')->name('inventory.')->group(function () {

        // Vendors
        Route::resources([
            'vendors' => VendorController::class,
            'inventory-vendors' => InventoryVendorController::class,
        ]);

        // Items, PO, GRN, Transfers, Audit
        Route::resources([
            'items' => ItemController::class,
            'purchase-orders' => PurchaseOrderController::class,
            'grns' => GrnController::class,
            'stock-transfers' => StockTransferController::class,
            'stock-audits' => StockAuditController::class,
        ]);

        Route::get('reports', [ReportController::class, 'index'])->name('reports');
    });

    /*
    |--------------------------------------------------------------------------
    | Stock Management (shared)
    |--------------------------------------------------------------------------
    */
    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('index');
        Route::get('/low-stock', [StockController::class, 'lowStock'])->name('low');
        Route::resource('manage', StockController::class)->except(['show']);
    });

    /*
    |--------------------------------------------------------------------------
    | Stock API endpoints (optional internal use)
    |--------------------------------------------------------------------------
    */
    Route::prefix('api/stock')->name('api.stock.')->group(function () {
        Route::get('/', [StockController::class, 'apiIndex'])->name('index');
        Route::get('/low', [StockController::class, 'apiLowStock'])->name('low');
        Route::get('/{id}', [StockController::class, 'apiShow'])->name('show');
        Route::post('/', [StockController::class, 'apiStore'])->name('store');
        Route::put('/{id}', [StockController::class, 'apiUpdate'])->name('update');
        Route::delete('/{id}', [StockController::class, 'apiDestroy'])->name('delete');
        Route::get('/trash', [StockController::class, 'apiTrash'])->name('trash');
        Route::post('/restore/{id}', [StockController::class, 'apiRestore'])->name('restore');
        Route::delete('/force-delete/{id}', [StockController::class, 'apiForceDelete'])->name('forceDelete');
    });
});
