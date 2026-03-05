<?php


use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\HR\StaffManagementController;
use App\Http\Controllers\LeaveManagement\HolidayController;
use App\Http\Controllers\LeaveManagement\WeekendController;
use App\Models\Staff;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\WorkStatusController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\api\Inventory\ItemApiController;
use App\Http\Controllers\api\Inventory\PurchaseOrderApiController;
use App\Http\Controllers\Api\Inventory\GrnApiController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;
use App\Http\Controllers\ControlledDrugController;
use App\Http\Controllers\ExpiryController;

/* Religion */

Route::get('/religions', [ReligionController::class, 'apiIndex']);
Route::post('/religions', [ReligionController::class, 'apiStore']);
Route::put('/religions/{id}', [ReligionController::class, 'apiUpdate']);
Route::delete('/religions/{id}', [ReligionController::class, 'apiDelete']);

/* Job Type */

Route::get('/job-types', [JobTypeController::class, 'apiIndex']);
Route::post('/job-types', [JobTypeController::class, 'apiStore']);
Route::put('/job-types/{id}', [JobTypeController::class, 'apiUpdate']);
Route::delete('/job-types/{id}', [JobTypeController::class, 'apiDelete']);

/* Work Status */

Route::get('/work-status', [WorkStatusController::class, 'apiIndex']);
Route::post('/work-status', [WorkStatusController::class, 'apiStore']);
Route::put('/work-status/{id}', [WorkStatusController::class, 'apiUpdate']);
Route::delete('/work-status/{id}', [WorkStatusController::class, 'apiDelete']);

/* Bloood Group */

Route::get('/blood-groups', [BloodGroupController::class, 'apiIndex']);
Route::post('/blood-groups', [BloodGroupController::class, 'apiStore']);
Route::put('/blood-groups/{id}', [BloodGroupController::class, 'apiUpdate']);
Route::delete('/blood-groups/{id}', [BloodGroupController::class, 'apiDelete']);

/* Department */

Route::get('/departments', [DepartmentController::class, 'apiIndex']);
Route::post('/departments', [DepartmentController::class, 'apiStore']);
Route::put('/departments/{id}', [DepartmentController::class, 'apiUpdate']);
Route::delete('/departments/{id}', [DepartmentController::class, 'apiDelete']);

/* Designation */

Route::get('/designations', [DesignationController::class, 'apiIndex']);
Route::post('/designations', [DesignationController::class, 'apiStore']);
Route::put('/designations/{id}', [DesignationController::class, 'apiUpdate']);
Route::delete('/designations/{id}', [DesignationController::class, 'apiDelete']);

/* Religion */

Route::get('religions/deleted', [ReligionController::class, 'apiDeleted']);
Route::put('religions/{id}/restore', [ReligionController::class, 'apiRestore']);
Route::delete('religions/{id}/force-delete', [ReligionController::class, 'apiForceDelete']);

/* Designation */

Route::get('designations/deleted', [DesignationController::class, 'apiDeleted']);
Route::put('designations/{id}/restore', [DesignationController::class, 'apiRestore']);
Route::delete('designations/{id}/force-delete', [DesignationController::class, 'apiForceDelete']);

/* JobType */

Route::get('job-types/deleted', [JobTypeController::class, 'apiDeleted']);
Route::put('job-types/{id}/restore', [JobTypeController::class, 'apiRestore']);
Route::delete('job-types/{id}/force-delete', [JobTypeController::class, 'apiForceDelete']);

/* WorkStatus */

Route::get('work-status/deleted', [WorkStatusController::class, 'apiDeleted']);
Route::put('work-status/{id}/restore', [WorkStatusController::class, 'apiRestore']);
Route::delete('work-status/{id}/force-delete', [WorkStatusController::class, 'apiForceDelete']);

/* BloodGroup */

Route::get('blood-groups/deleted', [BloodGroupController::class, 'apiDeleted']);
Route::put('blood-groups/{id}/restore', [BloodGroupController::class, 'apiRestore']);
Route::delete('blood-groups/{id}/force-delete', [BloodGroupController::class, 'apiForceDelete']);

/* Department */

Route::get('departments/deleted', [DepartmentController::class, 'apiDeleted']);
Route::put('departments/{id}/restore', [DepartmentController::class, 'apiRestore']);
Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'apiForceDelete']);

// ORGANIZATION API

Route::get('/organizations', [OrganizationController::class, 'apiIndex']);
Route::post('/organizations', [OrganizationController::class, 'apiStore']);
Route::get('/organizations/{id}', [OrganizationController::class, 'apiShow']);
Route::put('/organizations/{id}', [OrganizationController::class, 'apiUpdate']);
Route::put('/organizations/{id}/toggle-status', [OrganizationController::class, 'apiToggleStatus']);
Route::delete('/organizations/{id}', [OrganizationController::class, 'apiDelete']);
Route::delete('/organizations/{id}/force-delete', [OrganizationController::class, 'apiForceDelete']);

// INSTITUTION API

Route::get('/institutions', [InstitutionController::class, 'apiIndex']);
Route::post('/institutions', [InstitutionController::class, 'apiStore']);
Route::get('/institutions/{id}', [InstitutionController::class, 'apiShow']);
Route::put('/institutions/{id}', [InstitutionController::class, 'apiUpdate']);
Route::delete('/institutions/{id}', [InstitutionController::class, 'apiDelete']);
Route::put('/institutions/{id}/toggle-status', [InstitutionController::class, 'apiToggleStatus']);
Route::delete('/institutions/{id}/force-delete', [InstitutionController::class, 'apiForceDelete']);

// MODULE API

Route::get('/modules', [ModuleController::class, 'apiIndex']);
Route::post('/modules', [ModuleController::class, 'apiStore']);
Route::get('/modules/{id}', [ModuleController::class, 'apiShow']);
Route::put('/modules/{id}', [ModuleController::class, 'apiUpdate']);
Route::delete('/modules/{id}', [ModuleController::class, 'apiDelete']);
Route::delete('/modules/{id}/force-delete', [ModuleController::class, 'apiForceDelete']);

// Module Management Type Api
// Weekend
Route::get('/weekends', [WeekendController::class, 'index']);
Route::post('/weekends', [WeekendController::class, 'store']);
Route::patch('/weekends/{id}', [WeekendController::class, 'update']);
Route::delete('/weekends/{id}', [WeekendController::class, 'destroy']);
Route::get('/weekends/deleted', [WeekendController::class, 'deleted']);
Route::post('/weekends/{id}/restore', [WeekendController::class, 'restore']);
Route::delete('/weekends/{id}/force-delete', [WeekendController::class, 'forceDelete']);
Route::patch('/weekends/{id}/toggle-status', [WeekendController::class, 'toggleStatus']);

// Holiday
Route::get('/holidays', [HolidayController::class, 'index']);
Route::post('/holidays', [HolidayController::class, 'store']);
Route::get('/holidays/{id}', [HolidayController::class, 'show']);
Route::patch('/holidays/{id}', [HolidayController::class, 'update']);
Route::delete('/holidays/{id}', [HolidayController::class, 'destroy']);
Route::get('/holidays/deleted', [HolidayController::class, 'deleted']);
Route::post('/holidays/{id}/restore', [HolidayController::class, 'restore']);
Route::delete('/holidays/{id}/force-delete', [HolidayController::class, 'forceDelete']);
Route::patch('/holidays/{id}/toggle-status', [HolidayController::class, 'toggleStatus']);

// Staff Management
Route::get('/staff', [StaffManagementController::class, 'apiIndex']);
Route::post('/staff', [StaffManagementController::class, 'apiStore']);
Route::put('/staff/{id}', [StaffManagementController::class, 'apiUpdate']);
Route::delete('/staff/{id}', [StaffManagementController::class, 'apiDestroy']);
Route::get('/staff/deleted', [StaffManagementController::class, 'apiDeleted']);
Route::post('/staff/{id}/restore', [StaffManagementController::class, 'apiRestore']);
Route::delete('/staff/{id}/force-delete', [StaffManagementController::class, 'apiForceDelete']);

Route::get('/employee', [EmployeeController::class, 'index']);

Route::get('/module-types', [ModuleController::class, 'getModuleTypes']);

Route::get('/test-api', function () {
    return 'API working';
});

Route::get('/dashboard', [DashboardController::class, 'index']);

/* Pharmacy API */

Route::prefix('pharmacy')->group(function () {
    Route::get('/stock', [StockController::class, 'apiIndex']);
    Route::get('/stock/low', [StockController::class, 'apiLowStock']);
    Route::get('/stock/{id}', [StockController::class, 'apiShow']);
    Route::post('/stock', [StockController::class, 'apiStore']);
    Route::post('stock-restore/{id}', [StockController::class, 'apiRestore']);
    Route::put('stock/{id}', [StockController::class, 'apiUpdate']);
    Route::delete('stock/{id}', [StockController::class, 'apiDestroy']);
    Route::get('stock-trash', [StockController::class, 'apiTrash']);
    Route::delete('stock-force-delete/{id}', [StockController::class, 'apiForceDelete']);

});




/* Vendor API */

Route::prefix('vendors')->group(
    function () {

        Route::get('/', [VendorController::class, 'apiIndex']);

        Route::post('/', [VendorController::class, 'apiStore']);

        Route::get('/trash', [VendorController::class, 'apiTrash']);

        Route::get('/{id}', [VendorController::class, 'apiShow']);

        Route::put('/{id}', [VendorController::class, 'apiUpdate']);

        Route::delete('/{id}', [VendorController::class, 'apiDestroy']);

    }
);
// Route::get('/vendors', function () {
//     return \App\Models\Vendor::select('id', 'vendor_name')->get();
// });

// Bed

Route::prefix('admin')->group(function () {

    Route::get('beds', [BedController::class, 'apiIndex']);
    Route::post('beds', [BedController::class, 'apiStore']);
    Route::get('beds/{id}', [BedController::class, 'apiShow']);
    Route::put('beds/{id}', [BedController::class, 'apiUpdate']);
    Route::delete('beds/{id}', [BedController::class, 'apiDestroy']);
    Route::delete('beds/{id}/force-delete', [BedController::class, 'forceDeleteApi']);
});

// ================= WARD API =================

Route::get('/wards', [WardController::class, 'apiIndex']);
Route::post('/wards', [WardController::class, 'apiStore']);
Route::get('/wards/{id}', [WardController::class, 'apiShow']);
Route::put('/wards/{id}', [WardController::class, 'apiUpdate']);
Route::delete('/wards/{id}', [WardController::class, 'apiDelete']);
Route::delete('/wards/{id}/force-delete', [WardController::class, 'apiForceDelete']);
Route::put('/wards/{id}/toggle-status', [WardController::class, 'apiToggleStatus']);



//GRN APIS

Route::prefix('pharmacy')->group(function () {

    Route::get('/grn', [PharmacyGrnController::class, 'apiIndex']);      // list
    Route::post('/grn', [PharmacyGrnController::class, 'apiStore']);     // create
    Route::get('/grn/{id}', [PharmacyGrnController::class, 'apiShow']);  // single view
    Route::put('/grn/{id}', [PharmacyGrnController::class, 'apiUpdate']); // update
    Route::delete('/grn/{id}', [PharmacyGrnController::class, 'apiDestroy']); // soft delete

    Route::get('/grn-trash', [PharmacyGrnController::class, 'apiTrash']); // trash list
    Route::put('/grn-trash/{id}/restore', [PharmacyGrnController::class, 'apiRestore']); // restore
    Route::delete('/grn-trash/{id}/force-delete', [PharmacyGrnController::class, 'apiForceDelete']); // force delete

    Route::post('/grn/{id}/verify', [PharmacyGrnController::class, 'apiVerify']); // verify
    Route::post('/grn/{id}/reject', [PharmacyGrnController::class, 'apiReject']); // reject
});
/*
|--------------------------------------------------------------------------
| Expiry Management API
|--------------------------------------------------------------------------
*/
Route::prefix('expiry')->group(function () {
    Route::get('/', [ExpiryController::class, 'apiIndex']); 
    Route::get('/{batchId}', [ExpiryController::class, 'apiShow']);
    Route::post('/mark-expired/{batchId}', [ExpiryController::class, 'apiMarkExpired']);
    Route::post('/return-to-vendor/{batchId}', [ExpiryController::class, 'apiReturnToVendor']);
    Route::post('/approve/{batchId}', [ExpiryController::class, 'apiApprove']);
    Route::post('/complete/{batchId}', [ExpiryController::class, 'apiComplete']);
    
});



/*
|--------------------------------------------------------------------------
| Controlled Drugs API
|--------------------------------------------------------------------------
*/

Route::prefix('controlled-drugs')->group(function () {

    Route::get('/', [ControlledDrugController::class, 'apiIndex']);

    Route::get('/{id}', [ControlledDrugController::class, 'apiShow']);

    Route::post('/', [ControlledDrugController::class, 'apiStore']);

    Route::put('/{id}', [ControlledDrugController::class, 'apiUpdate']);

    Route::delete('/{id}', [ControlledDrugController::class, 'apiDestroy']);

    Route::get('/trash/list', [ControlledDrugController::class, 'apiTrash']);

    Route::post('/restore/{id}', [ControlledDrugController::class, 'apiRestore']);

    Route::delete('/force-delete/{id}', [ControlledDrugController::class, 'apiForceDelete']);
});


/*
|--------------------------------------------------------------------------
| Dispense API
|--------------------------------------------------------------------------
*/

Route::get(
    '/controlled-drug-dispense',
    [ControlledDrugController::class, 'apiDispense']
);

Route::post(
    '/controlled-drug-dispense',
    [ControlledDrugController::class, 'apiStoreDispense']
);


/*
|--------------------------------------------------------------------------
| Drug Logs API
|--------------------------------------------------------------------------
*/

Route::get(
    '/controlled-drug-log',
    [ControlledDrugController::class, 'apiDrugLog']
);


/*
|--------------------------------------------------------------------------
| Active Vendors for Dropdown
|--------------------------------------------------------------------------
*/

Route::get('/vendors-active', [VendorController::class, 'apiActiveVendors']);
