<?php

use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;
// Auth
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\DashboardController;
// API Dashboard
use App\Http\Controllers\Api\Inventory\GrnApiController;
// Inventory API
use App\Http\Controllers\Api\Inventory\ItemApiController;
use App\Http\Controllers\Api\Inventory\PurchaseOrderApiController;
use App\Http\Controllers\Api\Inventory\StockAuditApiController;
use App\Http\Controllers\Api\Inventory\StockTransferApiController;
use App\Http\Controllers\Auth\SignInController;
// Masters
use App\Http\Controllers\BedController;
use App\Http\Controllers\BiometricController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\ControlledDrugController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ExpiryController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\HR\StaffManagementController;
// Leave management (masters)
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\LeaveManagement\HolidayController;
use App\Http\Controllers\LeaveManagement\LeaveMappingController;
// HR
use App\Http\Controllers\LeaveManagement\LeaveTypeController;
use App\Http\Controllers\LeaveManagement\WeekendController;
// Beds / Wards / Rooms
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ReligionController;
// Pharmacy / Inventory shared
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\WorkStatusController;
// Biometric
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public auth APIs (no sanctum)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('login', [SignInController::class, 'apiLogin']);
});


Route::prefix('/users')->middleware('auth:sanctum')->group(function () {

        Route::get('/notEnrolled', [UserController::class, 'notEnrolled']);
});
/*
|--------------------------------------------------------------------------
| Masters (Religion / JobType / WorkStatus / BloodGroup / Department / Designation / Leave)
|--------------------------------------------------------------------------
*/
Route::prefix('masters')->group(function () {

    // Religion
    Route::get('/religions', [ReligionController::class, 'apiIndex']);
    Route::post('/religions', [ReligionController::class, 'apiStore']);
    Route::put('/religions/{id}', [ReligionController::class, 'apiUpdate']);
    Route::delete('/religions/{id}', [ReligionController::class, 'apiDelete']);

    Route::get('/religions/deleted', [ReligionController::class, 'apiDeleted']);
    Route::put('/religions/{id}/restore', [ReligionController::class, 'apiRestore']);
    Route::delete('/religions/{id}/force-delete', [ReligionController::class, 'apiForceDelete']);

    // Job Types
    Route::get('/job-types', [JobTypeController::class, 'apiIndex']);
    Route::post('/job-types', [JobTypeController::class, 'apiStore']);
    Route::put('/job-types/{id}', [JobTypeController::class, 'apiUpdate']);
    Route::delete('/job-types/{id}', [JobTypeController::class, 'apiDelete']);

    Route::get('/job-types/deleted', [JobTypeController::class, 'apiDeleted']);
    Route::put('/job-types/{id}/restore', [JobTypeController::class, 'apiRestore']);
    Route::delete('/job-types/{id}/force-delete', [JobTypeController::class, 'apiForceDelete']);

    // Work Status
    Route::get('/work-status', [WorkStatusController::class, 'apiIndex']);
    Route::post('/work-status', [WorkStatusController::class, 'apiStore']);
    Route::put('/work-status/{id}', [WorkStatusController::class, 'apiUpdate']);
    Route::delete('/work-status/{id}', [WorkStatusController::class, 'apiDelete']);

    Route::get('/work-status/deleted', [WorkStatusController::class, 'apiDeleted']);
    Route::put('/work-status/{id}/restore', [WorkStatusController::class, 'apiRestore']);
    Route::delete('/work-status/{id}/force-delete', [WorkStatusController::class, 'apiForceDelete']);

    // Blood Groups
    Route::get('/blood-groups', [BloodGroupController::class, 'apiIndex']);
    Route::post('/blood-groups', [BloodGroupController::class, 'apiStore']);
    Route::put('/blood-groups/{id}', [BloodGroupController::class, 'apiUpdate']);
    Route::delete('/blood-groups/{id}', [BloodGroupController::class, 'apiDelete']);

    Route::get('/blood-groups/deleted', [BloodGroupController::class, 'apiDeleted']);
    Route::put('/blood-groups/{id}/restore', [BloodGroupController::class, 'apiRestore']);
    Route::delete('/blood-groups/{id}/force-delete', [BloodGroupController::class, 'apiForceDelete']);

    // Departments
    Route::get('/departments', [DepartmentController::class, 'apiIndex']);
    Route::post('/departments', [DepartmentController::class, 'apiStore']);
    Route::put('/departments/{id}', [DepartmentController::class, 'apiUpdate']);
    Route::delete('/departments/{id}', [DepartmentController::class, 'apiDelete']);

    Route::get('/departments/deleted', [DepartmentController::class, 'apiDeleted']);
    Route::put('/departments/{id}/restore', [DepartmentController::class, 'apiRestore']);
    Route::delete('/departments/{id}/force-delete', [DepartmentController::class, 'apiForceDelete']);

    // Designations
    Route::get('/designations', [DesignationController::class, 'apiIndex']);
    Route::post('/designations', [DesignationController::class, 'apiStore']);
    Route::put('/designations/{id}', [DesignationController::class, 'apiUpdate']);
    Route::delete('/designations/{id}', [DesignationController::class, 'apiDelete']);

    Route::get('/designations/deleted', [DesignationController::class, 'apiDeleted']);
    Route::put('/designations/{id}/restore', [DesignationController::class, 'apiRestore']);
    Route::delete('/designations/{id}/force-delete', [DesignationController::class, 'apiForceDelete']);

    // Leave Types
    Route::get('/leave-types', [LeaveTypeController::class, 'apiIndex']);
    Route::post('/leave-types', [LeaveTypeController::class, 'apiStore']);
    Route::get('/leave-types/{id}', [LeaveTypeController::class, 'apiShow']);
    Route::put('/leave-types/{id}', [LeaveTypeController::class, 'apiUpdate']);
    Route::delete('/leave-types/{id}', [LeaveTypeController::class, 'apiDestroy']);

    Route::get('/leave-types/deleted', [LeaveTypeController::class, 'apiDeleted']);
    Route::post('/leave-types/{id}/restore', [LeaveTypeController::class, 'apiRestore']);
    Route::delete('/leave-types/{id}/force-delete', [LeaveTypeController::class, 'apiForceDelete']);

    // Leave Mappings
    Route::get('/leave-mappings', [LeaveMappingController::class, 'apiIndex']);
    Route::get('/leave-mappings/deleted', [LeaveMappingController::class, 'apiDeleted']);
    Route::get('/leave-mappings/{id}', [LeaveMappingController::class, 'apiShow']);
    Route::post('/leave-mappings', [LeaveMappingController::class, 'apiStore']);
    Route::patch('/leave-mappings/{id}', [LeaveMappingController::class, 'apiUpdate']);
    Route::delete('/leave-mappings/{id}', [LeaveMappingController::class, 'apiDestroy']);
    Route::post('/leave-mappings/{id}/restore', [LeaveMappingController::class, 'apiRestore']);
    Route::delete('/leave-mappings/{id}/force-delete', [LeaveMappingController::class, 'apiForceDelete']);
});

/*
|--------------------------------------------------------------------------
| Organization / Institution / Module
|--------------------------------------------------------------------------
*/
Route::prefix('org')->group(function () {

    // Organizations
    Route::get('/organizations', [OrganizationController::class, 'apiIndex']);
    Route::post('/organizations', [OrganizationController::class, 'apiStore']);
    Route::get('/organizations/{id}', [OrganizationController::class, 'apiShow']);
    Route::put('/organizations/{id}', [OrganizationController::class, 'apiUpdate']);
    Route::put('/organizations/{id}/toggle-status', [OrganizationController::class, 'apiToggleStatus']);
    Route::delete('/organizations/{id}', [OrganizationController::class, 'apiDelete']);
    Route::delete('/organizations/{id}/force-delete', [OrganizationController::class, 'apiForceDelete']);

    // Institutions
    Route::get('/institutions', [InstitutionController::class, 'apiIndex']);
    Route::post('/institutions', [InstitutionController::class, 'apiStore']);
    Route::get('/institutions/{id}', [InstitutionController::class, 'apiShow']);
    Route::put('/institutions/{id}', [InstitutionController::class, 'apiUpdate']);
    Route::delete('/institutions/{id}', [InstitutionController::class, 'apiDelete']);
    Route::put('/institutions/{id}/toggle-status', [InstitutionController::class, 'apiToggleStatus']);
    Route::delete('/institutions/{id}/force-delete', [InstitutionController::class, 'apiForceDelete']);

    // Modules
    Route::get('/modules', [ModuleController::class, 'apiIndex']);
    Route::post('/modules', [ModuleController::class, 'apiStore']);
    Route::get('/modules/{id}', [ModuleController::class, 'apiShow']);
    Route::put('/modules/{id}', [ModuleController::class, 'apiUpdate']);
    Route::delete('/modules/{id}', [ModuleController::class, 'apiDelete']);
    Route::delete('/modules/{id}/force-delete', [ModuleController::class, 'apiForceDelete']);

    Route::get('/module-types', [ModuleController::class, 'getModuleTypes']);
});

/*
|--------------------------------------------------------------------------
| Weekends & Holidays
|--------------------------------------------------------------------------
*/
Route::prefix('calendar')->group(function () {

    // Weekends
    Route::get('/weekends', [WeekendController::class, 'index']);
    Route::post('/weekends', [WeekendController::class, 'store']);
    Route::patch('/weekends/{id}', [WeekendController::class, 'update']);
    Route::delete('/weekends/{id}', [WeekendController::class, 'destroy']);
    Route::get('/weekends/deleted', [WeekendController::class, 'deleted']);
    Route::post('/weekends/{id}/restore', [WeekendController::class, 'restore']);
    Route::delete('/weekends/{id}/force-delete', [WeekendController::class, 'forceDelete']);
    Route::patch('/weekends/{id}/toggle-status', [WeekendController::class, 'toggleStatus']);

    // Holidays
    Route::get('/holidays', [HolidayController::class, 'index']);
    Route::get('/holidays/{id}', [HolidayController::class, 'show']);
    Route::post('/holidays', [HolidayController::class, 'store']);
    Route::patch('/holidays/{id}', [HolidayController::class, 'update']);
    Route::get('/holidays/deleted', [HolidayController::class, 'deleted']);
    Route::delete('/holidays/{id}', [HolidayController::class, 'destroy']);
    Route::post('/holidays/{id}/restore', [HolidayController::class, 'restore']);
    Route::delete('/holidays/{id}/force-delete', [HolidayController::class, 'forceDelete']);
    Route::patch('/holidays/{id}/toggle-status', [HolidayController::class, 'toggleStatus']);
});

/*
|--------------------------------------------------------------------------
| HR: Staff / Employees
|--------------------------------------------------------------------------
*/
Route::prefix('hr')->group(function () {

    // Staff Management
    Route::get('/staff', [StaffManagementController::class, 'apiIndex']);
    Route::post('/staff', [StaffManagementController::class, 'apiStore']);
    Route::put('/staff/{id}', [StaffManagementController::class, 'apiUpdate']);
    Route::delete('/staff/{id}', [StaffManagementController::class, 'apiDestroy']);
    Route::get('/staff/deleted', [StaffManagementController::class, 'apiDeleted']);
    Route::post('/staff/{id}/restore', [StaffManagementController::class, 'apiRestore']);
    Route::delete('/staff/{id}/force-delete', [StaffManagementController::class, 'apiForceDelete']);

    // Employee list
    Route::get('/employee', [EmployeeController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| Pharmacy Stock (mobile APIs)
|--------------------------------------------------------------------------
*/
Route::prefix('pharmacy')->group(function () {

    // Stock
    Route::get('/stock', [StockController::class, 'apiIndex']);
    Route::get('/stock/low', [StockController::class, 'apiLowStock']);
    Route::get('/stock/{id}', [StockController::class, 'apiShow']);
    Route::post('/stock', [StockController::class, 'apiStore']);
    Route::put('/stock/{id}', [StockController::class, 'apiUpdate']);
    Route::delete('/stock/{id}', [StockController::class, 'apiDestroy']);

    Route::get('/stock-trash', [StockController::class, 'apiTrash']);
    Route::post('/stock-restore/{id}', [StockController::class, 'apiRestore']);
    Route::delete('/stock-force-delete/{id}', [StockController::class, 'apiForceDelete']);

    // GRN (PharmacyGrnController)
    Route::get('/grn', [PharmacyGrnController::class, 'apiIndex']);
    Route::post('/grn', [PharmacyGrnController::class, 'apiStore']);
    Route::get('/grn/{id}', [PharmacyGrnController::class, 'apiShow']);
    Route::put('/grn/{id}', [PharmacyGrnController::class, 'apiUpdate']);
    Route::delete('/grn/{id}', [PharmacyGrnController::class, 'apiDestroy']);

    Route::get('/grn-trash', [PharmacyGrnController::class, 'apiTrash']);
    Route::put('/grn-trash/{id}/restore', [PharmacyGrnController::class, 'apiRestore']);
    Route::delete('/grn-trash/{id}/force-delete', [PharmacyGrnController::class, 'apiForceDelete']);

    Route::post('/grn/{id}/verify', [PharmacyGrnController::class, 'apiVerify']);
    Route::post('/grn/{id}/reject', [PharmacyGrnController::class, 'apiReject']);
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
| Controlled Drugs: Dispense & Logs
|--------------------------------------------------------------------------
*/
Route::get('/controlled-drug-dispense', [ControlledDrugController::class, 'apiDispense']);
Route::post('/controlled-drug-dispense', [ControlledDrugController::class, 'apiStoreDispense']);
Route::get('/controlled-drug-log', [ControlledDrugController::class, 'apiDrugLog']);

/*
|--------------------------------------------------------------------------
| Vendor API
|--------------------------------------------------------------------------
*/
Route::prefix('vendors')->group(function () {
    Route::get('/', [VendorController::class, 'apiIndex']);
    Route::post('/', [VendorController::class, 'apiStore']);
    Route::get('/trash', [VendorController::class, 'apiTrash']);
    Route::get('/{id}', [VendorController::class, 'apiShow']);
    Route::put('/{id}', [VendorController::class, 'apiUpdate']);
    Route::delete('/{id}', [VendorController::class, 'apiDestroy']);
    Route::post('/restore/{id}', [VendorController::class, 'apiRestore']);
    Route::delete('/force-delete/{id}', [VendorController::class, 'apiForceDelete']);
});

// Active vendors dropdown
Route::get('/vendors-active', [VendorController::class, 'apiActiveVendors']);

// Helper vendor dropdown (simple list)
Route::get('/vendors', function () {
    return \App\Models\Vendor::select('id', 'vendor_name')->get();
});

/*
|--------------------------------------------------------------------------
| Inventory API
|--------------------------------------------------------------------------
*/
Route::prefix('inventory')->group(function () {

    // Items
    Route::get('/items', [ItemApiController::class, 'index']);
    Route::post('/items', [ItemApiController::class, 'store']);
    Route::get('/items/{id}', [ItemApiController::class, 'show']);
    Route::put('/items/{id}', [ItemApiController::class, 'update']);
    Route::delete('/items/{id}', [ItemApiController::class, 'destroy']);

    // Purchase Orders
    Route::get('/purchase-orders', [PurchaseOrderApiController::class, 'index']);
    Route::post('/purchase-orders', [PurchaseOrderApiController::class, 'store']);
    Route::get('/purchase-orders/approved', [PurchaseOrderApiController::class, 'approved']);
    Route::get('/purchase-orders/{id}', [PurchaseOrderApiController::class, 'show']);
    Route::put('/purchase-orders/{id}', [PurchaseOrderApiController::class, 'update']);
    Route::delete('/purchase-orders/{id}', [PurchaseOrderApiController::class, 'destroy']);
    Route::put('/purchase-orders/{id}/approve', [PurchaseOrderApiController::class, 'approve']);

    // GRNs
    Route::get('/grns', [GrnApiController::class, 'index']);
    Route::post('/grns', [GrnApiController::class, 'store']);

    // Optionally stock audits/transfers
    // Route::get('/stock-audits', [StockAuditApiController::class, 'index']);
    // Route::get('/stock-transfers', [StockTransferApiController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| Beds, Wards, Rooms
|--------------------------------------------------------------------------
*/

// Beds (admin/beds in original)
Route::prefix('admin')->group(function () {
    Route::get('/beds', [BedController::class, 'apiIndex']);
    Route::post('/beds', [BedController::class, 'apiStore']);
    Route::get('/beds/{id}', [BedController::class, 'apiShow']);
    Route::put('/beds/{id}', [BedController::class, 'apiUpdate']);
    Route::delete('/beds/{id}', [BedController::class, 'apiDestroy']);
    Route::delete('/beds/{id}/force-delete', [BedController::class, 'forceDeleteApi']);
});

// Wards
Route::prefix('wards')->group(function () {
    Route::get('/', [WardController::class, 'apiIndex']);
    Route::post('/', [WardController::class, 'apiStore']);
    Route::get('/trash', [WardController::class, 'apiTrash']);
    Route::put('/{id}/restore', [WardController::class, 'apiRestore']);
    Route::get('/{id}', [WardController::class, 'apiShow']);
    Route::put('/{id}', [WardController::class, 'apiUpdate']);
    Route::delete('/{id}', [WardController::class, 'apiDelete']);
    Route::delete('/{id}/force-delete', [WardController::class, 'apiForceDelete']);
    Route::put('/{id}/toggle-status', [WardController::class, 'apiToggleStatus']);
});

// Rooms
Route::prefix('rooms')->group(function () {
    Route::get('/', [RoomController::class, 'apiIndex']);
    Route::post('/', [RoomController::class, 'apiStore']);
    Route::get('/trash', [RoomController::class, 'apiTrash']);
    Route::put('/{id}/restore', [RoomController::class, 'apiRestore']);
    Route::get('/{id}', [RoomController::class, 'apiShow']);
    Route::put('/{id}', [RoomController::class, 'apiUpdate']);
    Route::delete('/{id}', [RoomController::class, 'apiDelete']);
    Route::delete('/{id}/force-delete', [RoomController::class, 'apiForceDelete']);
    Route::put('/{id}/toggle-status', [RoomController::class, 'apiToggleStatus']);
});

/*
|--------------------------------------------------------------------------
| Biometric (protected by Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')
    ->prefix('biometric')
    ->group(function () {
        Route::post('/enroll', [BiometricController::class, 'enroll']);
        Route::post('/match', [BiometricController::class, 'match']);
        Route::post('/check-in', [BiometricController::class, 'checkIn']);
        Route::post('/check-out', [BiometricController::class, 'checkOut']);
        Route::get('/check-status', [BiometricController::class, 'checkStatus']);
    });

/*
|--------------------------------------------------------------------------
| Misc
|--------------------------------------------------------------------------
*/
Route::get('/test-api', fn () => 'API working');
Route::get('/dashboard', [DashboardController::class, 'index']);
