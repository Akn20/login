<?php


// Auth
use App\Http\Controllers\Admin\RoleController;
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
use App\Http\Controllers\WorkStatusController;

use App\Http\Controllers\ExpiryController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\HR\StaffManagementController;
// Leave management (masters)
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\JobTypeController;
// HR
use App\Http\Controllers\LeaveManagement\HolidayController;
use App\Http\Controllers\LeaveManagement\LeaveMappingController;
use App\Http\Controllers\LeaveManagement\LeaveAdjustmentController;
use App\Http\Controllers\LeaveManagement\LeaveTypeController;
use App\Http\Controllers\LeaveManagement\WeekendController;
use App\Http\Controllers\LeaveManagement\LeaveApprovalController;
use App\Http\Controllers\LeaveManagement\CompOffController;
// Beds / Wards / Rooms
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ReligionController;
// Pharmacy / Inventory shared
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;
use App\Http\Controllers\Admin\Pharmacy\SalesReturnController;
use App\Http\Controllers\Admin\Pharmacy\PrescriptionController;
//use App\Http\Controllers\WorkStatusController;

//surgery
use App\Http\Controllers\Api\Surgery\OTApiController;
use App\Http\Controllers\Api\Surgery\SurgeryApiController;
use App\Http\Controllers\Api\Surgery\PostOperativeApiController;

//added by sushan for api
use App\Http\Controllers\Admin\PatientController;
//added by sushan for api
    Route::get('/patients', [PatientController::class, 'apiIndex']);
use App\Http\Controllers\HR\ShiftSchedulingAPIController;
//DOCTOR(OPD)
use App\Http\Controllers\Doctor\ConsultationController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Attendance\AttendanceApiController;
//Receptionist
use App\Http\Controllers\TokenController;

//Nurse
use App\Http\Controllers\NurseNotesController;


/*|--------------------------------------------------------------------------
| Biometric (protected by Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:admin'])
    ->prefix('biometric')
    ->group(function () {
        Route::post('/enroll', [BiometricController::class, 'enroll']);
        Route::post('/check-in', [BiometricController::class, 'checkIn']);
        Route::post('/check-out', [BiometricController::class, 'checkOut']);
        Route::get('/check-status', [BiometricController::class, 'checkStatus']);
    });


Route::middleware('auth:sanctum')->group(function () {

    /*Users*/
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::patch('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::get('/deleted-users', [UserController::class, 'displayDeletedUsers']);
    Route::post('/restore-user/{id}', [UserController::class, 'restore']);
    Route::delete('/force-delete-user/{id}', [UserController::class, 'forceDeleteUser']);
    Route::get('/users/notEnrolled', [UserController::class, 'notEnrolled']);



    /*Roles*/
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/role', [RoleController::class, 'store']);
    Route::patch('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
    Route::get('/deleted-roles', [RoleController::class, 'displayDeletedRoles']);
    Route::post('/restore-role/{id}', [RoleController::class, 'restore']);
    Route::delete('/force-delete-role/{id}', [RoleController::class, 'forceDeleteRole']);

});
    



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
/*
|--------------------------------------------------------------------------
| Public auth APIs (no sanctum)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('login', [SignInController::class, 'apiLogin']);
    Route::post('send-otp', [SignInController::class, 'apiSendOtp']);
    Route::post('resend-otp', [SignInController::class, 'apiResendOtp']);
    Route::post('verify-otp', [SignInController::class, 'apiVerifyOtp']);
    Route::post('set-mpin', [SignInController::class, 'apiSetMpin']);
    Route::post('logout', [SignInController::class, 'apiLogout']);
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
| Leave Adjustments API
|--------------------------------------------------------------------------
*/
Route::prefix('leave-management')->group(function () {
    
    // Main Adjustment Routes
    Route::get('/adjustments', [LeaveAdjustmentController::class, 'apiIndex']);
    Route::post('/adjustments', [LeaveAdjustmentController::class, 'apiStore']);
    Route::get('/adjustments/{id}', [LeaveAdjustmentController::class, 'apiShow']);
    
    // The "Smart-Link" endpoint used by the UI to fetch balances when staff is selected
    Route::get('/adjustments/mapping/{staff_id}', [LeaveAdjustmentController::class, 'getLeaveMapping']);


    /*
    |--------------------------------------------------------------------------
    | Comp Off API
    |--------------------------------------------------------------------------
    */

    Route::get('/compoffs', [CompOffController::class, 'apiIndex']);
    Route::post('/compoffs', [CompOffController::class, 'apiStore']);
     Route::get('/compoffs/deleted', [CompOffController::class, 'apiDeleted']);
    Route::get('/compoffs/{id}', [CompOffController::class, 'apiShow']);
    Route::patch('/compoffs/{id}', [CompOffController::class, 'apiUpdate']);
    Route::delete('/compoffs/{id}', [CompOffController::class, 'apiDestroy']);

    Route::post('/compoffs/{id}/restore', [CompOffController::class, 'apiRestore']);
    Route::delete('/compoffs/{id}/force-delete', [CompOffController::class, 'apiForceDelete']);

    
});





/*
|--------------------------------------------------------------------------
| Leave Approval API
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->prefix('leave-approvals')->group(function () {
    Route::get('/', [LeaveApprovalController::class, 'apiIndex']);
    Route::get('/approved', [LeaveApprovalController::class, 'apiApprovedIndex']);
    Route::get('/{id}', [LeaveApprovalController::class, 'apiShow']);
    Route::post('/{id}/approve', [LeaveApprovalController::class, 'apiApprove']);
    Route::post('/{id}/reject', [LeaveApprovalController::class, 'apiReject']);
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
    //added by sushan for api
    Route::get('/surgeons', [StaffManagementController::class, 'getSurgeons']);
    Route::get('/assistant-doctors', [StaffManagementController::class, 'getAssistantDoctors']);
    Route::get('/anesthetists', [StaffManagementController::class, 'getAnesthetists']);

    Route::post('/staff', [StaffManagementController::class, 'apiStore']);
    Route::put('/staff/{id}', [StaffManagementController::class, 'apiUpdate']);
    Route::delete('/staff/{id}', [StaffManagementController::class, 'apiDestroy']);
    Route::get('/staff/deleted', [StaffManagementController::class, 'apiDeleted']);
    Route::post('/staff/{id}/restore', [StaffManagementController::class, 'apiRestore']);
    Route::delete('/staff/{id}/force-delete', [StaffManagementController::class, 'apiForceDelete']);
    Route::get('/doctors', [StaffManagementController::class, 'apiDoctors']);

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



    // SALES RETURN APIs
    Route::get('/sales-returns', [SalesReturnController::class, 'apiIndex']);                 // list + filters
    Route::get('/sales-returns/{id}', [SalesReturnController::class, 'apiShow']);            // single view
    Route::post('/sales-returns', [SalesReturnController::class, 'apiStore']);               // create
    Route::put('/sales-returns/{id}', [SalesReturnController::class, 'apiUpdate']);          // update
    Route::post('/sales-returns/{id}/approve', [SalesReturnController::class, 'apiApprove']); // approve
    Route::post('/sales-returns/{id}/reject', [SalesReturnController::class, 'apiReject']);   // reject

    // Helper for create screen: search bill by bill number
    Route::get('/sales-bills/search', [SalesReturnController::class, 'apiBillSearch']);

});

    // Prescription APIs
    



    Route::prefix('prescriptions')->group(function () {

        // List prescriptions
        Route::get('/', [PrescriptionController::class,'apiIndex']);

        // View prescription
        Route::get('/{id}', [PrescriptionController::class,'apiShow']);

        // Dispense medicines
        Route::post('/dispense/{id}', [PrescriptionController::class,'apiDispense']);

        // Reject prescription
        Route::post('/reject/{id}', [PrescriptionController::class,'apiReject']);

        // Bill details
        Route::get('/bill/{id}', [PrescriptionController::class,'apiBill']);

    });


/*
|--------------------------------------------------------------------------
| Surgery Management APIs
|--------------------------------------------------------------------------
*/


Route::prefix('surgery')->group(function () {

    // Main Surgery CRUD
    Route::get('/', [SurgeryApiController::class, 'index']);                    // List all surgeries with filters
    Route::post('/', [SurgeryApiController::class, 'store']);                   // Create new surgery
    Route::get('/{id}', [SurgeryApiController::class, 'show']);                 // Get single surgery with details
    Route::put('/{id}', [SurgeryApiController::class, 'update']);               // Update surgery
    Route::delete('/{id}', [SurgeryApiController::class, 'destroy']);           // Delete surgery

    // Additional endpoints
    Route::get('/patient/{patientId}', [SurgeryApiController::class, 'getByPatient']); // Get surgeries by patient
    Route::get('/date/{date}', [SurgeryApiController::class, 'getByDate']);
    
    // Get surgeries by date
});




Route::prefix('ot')->group(function () {

    Route::get('/', [OTApiController::class, 'index']);

    Route::post('/', [OTApiController::class, 'store']);

    Route::get('/{id}', [OTApiController::class, 'show']);

    Route::put('/{id}', [OTApiController::class, 'update']);

    Route::delete('/{id}', [OTApiController::class, 'destroy']);

    Route::post('/{id}/toggle-status', [OTApiController::class, 'toggleStatus']);

});

Route::prefix('post-operative')->group(function () {

    Route::get('/', [PostOperativeApiController::class, 'index']);

    Route::post('/', [PostOperativeApiController::class, 'store']);

    Route::get('/{id}', [PostOperativeApiController::class, 'show']);

    Route::put('/{id}', [PostOperativeApiController::class, 'update']);

    Route::delete('/{id}', [PostOperativeApiController::class, 'destroy']);

    Route::get('/surgery/{surgeryId}', [PostOperativeApiController::class, 'getBySurgery']);

});

// DOCTOR(OPD) API
Route::prefix('consultations')->group(function () {
    Route::get('/medicines', [ConsultationController::class, 'apiMedicines']);

    // APPOINTMENTS FIRST
    Route::prefix('appointments')->group(function () {
        Route::get('/', [AppointmentController::class, 'apiIndex']);
        Route::get('/trash', [AppointmentController::class, 'apiTrash']);
        Route::get('/patients', [AppointmentController::class, 'apiGetPatients']);
        Route::get('/departments', [AppointmentController::class, 'apiGetDepartments']);
        Route::get('/doctors/{department_id}', [AppointmentController::class, 'apiDoctors']);
        Route::get('/{id}', [AppointmentController::class, 'apiShow']);
        Route::post('/', [AppointmentController::class, 'apiStore']);
        Route::put('/{id}', [AppointmentController::class, 'apiUpdate']);
        Route::delete('/{id}', [AppointmentController::class, 'apiDestroy']);
        Route::put('/{id}/restore', [AppointmentController::class, 'apiRestore']);
        Route::delete('/{id}/force-delete', [AppointmentController::class, 'apiForceDelete']);
    });

    // CONSULTATION ROUTES
    Route::get('/', [ConsultationController::class, 'apiIndex']);
    Route::get('/{id}', [ConsultationController::class, 'apiShow']);
    Route::post('/', [ConsultationController::class, 'apiStore']);
    Route::put('/{id}', [ConsultationController::class, 'apiUpdate']);
    Route::delete('/{id}', [ConsultationController::class, 'apiDelete']);
    Route::get('/{id}/summary', [ConsultationController::class, 'apiSummary']);
    Route::get('/patient/{patientId}', [ConsultationController::class, 'apiPatientHistory']);
    Route::get('/{id}/prescriptions', [ConsultationController::class, 'apiPrescriptions']);
    Route::get('/{id}/tests', [ConsultationController::class, 'apiTests']);
    Route::get('/{id}/referral', [ConsultationController::class, 'apiReferral']);
});
//Apportionment APIs


Route::prefix('appointments')->group(function () {
    Route::get('/', [AppointmentController::class, 'apiIndex']);
    Route::get('/trash', [AppointmentController::class, 'apiTrash']);
    Route::get('/patients', [AppointmentController::class, 'apiGetPatients']);
    Route::get('/departments', [AppointmentController::class, 'apiGetDepartments']);
    Route::get('/doctors/{department_id}', [AppointmentController::class, 'apiDoctors']);
    Route::get('/{id}', [AppointmentController::class, 'apiShow']);
    Route::post('/', [AppointmentController::class, 'apiStore']);
    Route::put('/{id}', [AppointmentController::class, 'apiUpdate']);
    Route::delete('/{id}', [AppointmentController::class, 'apiDestroy']);
    Route::put('/{id}/restore', [AppointmentController::class, 'apiRestore']);
    Route::delete('/{id}/force-delete', [AppointmentController::class, 'apiForceDelete']);
});

    

