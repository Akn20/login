<?php

use App\Http\Controllers\Admin\Nurse\PatientMonitoringController;
/*
|--------------------------------------------------------------------------
| Controller Imports
|--------------------------------------------------------------------------
*/

// Auth
use App\Http\Controllers\Admin\PatientController;
// Admin
use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;
use App\Http\Controllers\Admin\Pharmacy\PrescriptionController;
use App\Http\Controllers\Admin\Pharmacy\SalesReturnController;
// Admin > Nurse
use App\Http\Controllers\Admin\RoleController;
// Admin > Pharmacy
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\Attendance\AttendanceApiController;
use App\Http\Controllers\Api\EDM\EmployeeDocumentApiController;
// Api > Attendance
use App\Http\Controllers\Api\Surgery\OTApiController;
// Api > EDM
use App\Http\Controllers\Api\Surgery\PostOperativeApiController;
// Api > Surgery
use App\Http\Controllers\Api\Surgery\SurgeryApiController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\attendance\AttendanceController;
// Doctor
use App\Http\Controllers\Auth\SignInController;
// HR
use App\Http\Controllers\BiometricController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\ControlledDrugController;
use App\Http\Controllers\DepartmentController;
// Leave Management
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\HR\Payroll\PayrollAllowanceController;
use App\Http\Controllers\WorkStatusController;

use App\Http\Controllers\Doctor\ConsultationController;
use App\Http\Controllers\EmergencyCaseController;
use App\Http\Controllers\ExpiryController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\HR\PayrollDeductionController;
use App\Http\Controllers\HR\Payroll\HourlyPayController;
use App\Http\Controllers\HR\Payroll\DeductionRuleSetController;
use App\Http\Controllers\HR\ShiftSchedulingAPIController;
use App\Http\Controllers\HR\StaffManagementController;
// Attendance
use App\Http\Controllers\InstitutionController;
// Root-level Controllers (alphabetical)
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\LeaveManagement\CompOffController;
use App\Http\Controllers\LeaveManagement\HolidayController;
use App\Http\Controllers\LeaveManagement\LeaveAdjustmentController;
use App\Http\Controllers\LeaveManagement\LeaveApprovalController;
use App\Http\Controllers\LeaveManagement\LeaveMappingController;
use App\Http\Controllers\LeaveManagement\LeaveReportController;
use App\Http\Controllers\LeaveManagement\LeaveTypeController;
use App\Http\Controllers\LeaveManagement\WeekendController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NurseNotesController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PharmacyDashboardController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Test / Misc
|--------------------------------------------------------------------------
*/

Route::get('/test-api', function () {
    return 'API working';
});

// added by sushan for api
Route::get('/patients', [PatientController::class, 'apiIndex']);

/*
|--------------------------------------------------------------------------
| 1. Public Auth APIs (no sanctum)
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
| 2. Sanctum-Protected Routes (Users, Roles, Biometric)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /* Biometric */
    Route::prefix('biometric')->group(function () {
        Route::post('/enroll', [BiometricController::class, 'enroll']);
        Route::post('/check-in', [BiometricController::class, 'checkIn']);
        Route::post('/check-out', [BiometricController::class, 'checkOut']);
        Route::get('/check-status', [BiometricController::class, 'checkStatus']);
    });

    /* Users (admin only) */
    Route::middleware('role:admin')->group(function () {

        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::patch('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        Route::get('/deleted-users', [UserController::class, 'displayDeletedUsers']);
        Route::post('/restore-user/{id}', [UserController::class, 'restore']);
        Route::delete('/force-delete-user/{id}', [UserController::class, 'forceDeleteUser']);
        Route::get('/users/notEnrolled', [UserController::class, 'notEnrolled']);

        /* Roles */
        Route::get('/roles', [RoleController::class, 'index']);
        Route::post('/role', [RoleController::class, 'store']);
        Route::patch('/roles/{id}', [RoleController::class, 'update']);
        Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
        Route::get('/deleted-roles', [RoleController::class, 'displayDeletedRoles']);
        Route::post('/restore-role/{id}', [RoleController::class, 'restore']);
        Route::delete('/force-delete-role/{id}', [RoleController::class, 'forceDeleteRole']);
    });
});

/*
|--------------------------------------------------------------------------
| 3. Masters (standalone, no prefix)
|--------------------------------------------------------------------------
| Religion / JobType / WorkStatus / BloodGroup / Department / Designation
*/

/* Religion */
Route::get('/religions', [ReligionController::class, 'apiIndex']);
Route::post('/religions', [ReligionController::class, 'apiStore']);
Route::put('/religions/{id}', [ReligionController::class, 'apiUpdate']);
Route::delete('/religions/{id}', [ReligionController::class, 'apiDelete']);
Route::get('religions/deleted', [ReligionController::class, 'apiDeleted']);
Route::put('religions/{id}/restore', [ReligionController::class, 'apiRestore']);
Route::delete('religions/{id}/force-delete', [ReligionController::class, 'apiForceDelete']);

/* Job Type */
Route::get('/job-types', [JobTypeController::class, 'apiIndex']);
Route::post('/job-types', [JobTypeController::class, 'apiStore']);
Route::put('/job-types/{id}', [JobTypeController::class, 'apiUpdate']);
Route::delete('/job-types/{id}', [JobTypeController::class, 'apiDelete']);
Route::get('job-types/deleted', [JobTypeController::class, 'apiDeleted']);
Route::put('job-types/{id}/restore', [JobTypeController::class, 'apiRestore']);
Route::delete('job-types/{id}/force-delete', [JobTypeController::class, 'apiForceDelete']);

/* Work Status */
Route::get('/work-status', [WorkStatusController::class, 'apiIndex']);
Route::post('/work-status', [WorkStatusController::class, 'apiStore']);
Route::put('/work-status/{id}', [WorkStatusController::class, 'apiUpdate']);
Route::delete('/work-status/{id}', [WorkStatusController::class, 'apiDelete']);
Route::get('work-status/deleted', [WorkStatusController::class, 'apiDeleted']);
Route::put('work-status/{id}/restore', [WorkStatusController::class, 'apiRestore']);
Route::delete('work-status/{id}/force-delete', [WorkStatusController::class, 'apiForceDelete']);

/* Blood Group */
Route::get('/blood-groups', [BloodGroupController::class, 'apiIndex']);
Route::post('/blood-groups', [BloodGroupController::class, 'apiStore']);
Route::put('/blood-groups/{id}', [BloodGroupController::class, 'apiUpdate']);
Route::delete('/blood-groups/{id}', [BloodGroupController::class, 'apiDelete']);
Route::get('blood-groups/deleted', [BloodGroupController::class, 'apiDeleted']);
Route::put('blood-groups/{id}/restore', [BloodGroupController::class, 'apiRestore']);
Route::delete('blood-groups/{id}/force-delete', [BloodGroupController::class, 'apiForceDelete']);

/* Department */
Route::get('/departments', [DepartmentController::class, 'apiIndex']);
Route::post('/departments', [DepartmentController::class, 'apiStore']);
Route::put('/departments/{id}', [DepartmentController::class, 'apiUpdate']);
Route::delete('/departments/{id}', [DepartmentController::class, 'apiDelete']);
Route::get('departments/deleted', [DepartmentController::class, 'apiDeleted']);
Route::put('departments/{id}/restore', [DepartmentController::class, 'apiRestore']);
Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'apiForceDelete']);

/* Designation */
Route::get('/designations', [DesignationController::class, 'apiIndex']);
Route::post('/designations', [DesignationController::class, 'apiStore']);
Route::put('/designations/{id}', [DesignationController::class, 'apiUpdate']);
Route::delete('/designations/{id}', [DesignationController::class, 'apiDelete']);
Route::get('designations/deleted', [DesignationController::class, 'apiDeleted']);
Route::put('designations/{id}/restore', [DesignationController::class, 'apiRestore']);
Route::delete('designations/{id}/force-delete', [DesignationController::class, 'apiForceDelete']);

/*
|--------------------------------------------------------------------------
| 4. Masters (prefixed /masters)
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
| 5. Organization / Institution / Module
|--------------------------------------------------------------------------
*/

// Standalone (no prefix)
Route::get('/organizations', [OrganizationController::class, 'apiIndex']);
Route::post('/organizations', [OrganizationController::class, 'apiStore']);
Route::get('/organizations/{id}', [OrganizationController::class, 'apiShow']);
Route::put('/organizations/{id}', [OrganizationController::class, 'apiUpdate']);
Route::put('/organizations/{id}/toggle-status', [OrganizationController::class, 'apiToggleStatus']);
Route::delete('/organizations/{id}', [OrganizationController::class, 'apiDelete']);
Route::delete('/organizations/{id}/force-delete', [OrganizationController::class, 'apiForceDelete']);

Route::get('/institutions', [InstitutionController::class, 'apiIndex']);
Route::post('/institutions', [InstitutionController::class, 'apiStore']);
Route::get('/institutions/{id}', [InstitutionController::class, 'apiShow']);
Route::put('/institutions/{id}', [InstitutionController::class, 'apiUpdate']);
Route::delete('/institutions/{id}', [InstitutionController::class, 'apiDelete']);
Route::put('/institutions/{id}/toggle-status', [InstitutionController::class, 'apiToggleStatus']);
Route::delete('/institutions/{id}/force-delete', [InstitutionController::class, 'apiForceDelete']);

Route::get('/modules', [ModuleController::class, 'apiIndex']);
Route::post('/modules', [ModuleController::class, 'apiStore']);
Route::get('/modules/{id}', [ModuleController::class, 'apiShow']);
Route::put('/modules/{id}', [ModuleController::class, 'apiUpdate']);
Route::delete('/modules/{id}', [ModuleController::class, 'apiDelete']);
Route::delete('/modules/{id}/force-delete', [ModuleController::class, 'apiForceDelete']);

Route::get('/module-types', [ModuleController::class, 'getModuleTypes']);

// Prefixed /org
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
| 6. Weekends & Holidays (standalone)
|--------------------------------------------------------------------------
*/

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
Route::post('/holidays', [HolidayController::class, 'store']);
Route::get('/holidays/{id}', [HolidayController::class, 'show']);
Route::patch('/holidays/{id}', [HolidayController::class, 'update']);
Route::delete('/holidays/{id}', [HolidayController::class, 'destroy']);
Route::get('/holidays/deleted', [HolidayController::class, 'deleted']);
Route::post('/holidays/{id}/restore', [HolidayController::class, 'restore']);
Route::delete('/holidays/{id}/force-delete', [HolidayController::class, 'forceDelete']);
Route::patch('/holidays/{id}/toggle-status', [HolidayController::class, 'toggleStatus']);

// Prefixed /calendar
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
| 7. HR: Staff / Employees
|--------------------------------------------------------------------------
*/

// Standalone
Route::get('/staff', [StaffManagementController::class, 'apiIndex']);
Route::post('/staff', [StaffManagementController::class, 'apiStore']);
Route::put('/staff/{id}', [StaffManagementController::class, 'apiUpdate']);
Route::delete('/staff/{id}', [StaffManagementController::class, 'apiDestroy']);
Route::get('/staff/deleted', [StaffManagementController::class, 'apiDeleted']);
Route::post('/staff/{id}/restore', [StaffManagementController::class, 'apiRestore']);
Route::delete('/staff/{id}/force-delete', [StaffManagementController::class, 'apiForceDelete']);

Route::get('/employee', [EmployeeController::class, 'index']);

// Prefixed /hr
Route::prefix('hr')->group(function () {

    // Staff Management
    Route::get('/staff', [StaffManagementController::class, 'apiIndex']);
    Route::get('/shifts', [ShiftSchedulingAPIController::class, 'shiftindex']);
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
| 8. Attendance
|--------------------------------------------------------------------------
*/

Route::get('/attendance', [AttendanceApiController::class, 'index']);
Route::post('/attendance', [AttendanceApiController::class, 'store']);
Route::delete('/attendance/{id}', [AttendanceApiController::class, 'destroy']);
Route::put('/attendance/{id}', [AttendanceApiController::class, 'update']);
Route::get('/attendance/late-entries', [AttendanceApiController::class, 'lateEntries']);
Route::get('/attendance/overtime', [AttendanceController::class, 'overtimeRecords']);
Route::get('/attendance/report', [AttendanceApiController::class, 'report']);

/*
|--------------------------------------------------------------------------
| 9. Leave Management
|--------------------------------------------------------------------------
*/

Route::prefix('leave-management')->group(function () {

    // Adjustments
    Route::get('/adjustments', [LeaveAdjustmentController::class, 'apiIndex']);
    Route::post('/adjustments', [LeaveAdjustmentController::class, 'apiStore']);
    Route::get('/adjustments/{id}', [LeaveAdjustmentController::class, 'apiShow']);
    Route::get('/adjustments/mapping/{staff_id}', [LeaveAdjustmentController::class, 'getLeaveMapping']);

    // Comp Offs
    Route::get('/compoffs', [CompOffController::class, 'apiIndex']);
    Route::post('/compoffs', [CompOffController::class, 'apiStore']);
    Route::get('/compoffs/deleted', [CompOffController::class, 'apiDeleted']);
    Route::get('/compoffs/{id}', [CompOffController::class, 'apiShow']);
    Route::patch('/compoffs/{id}', [CompOffController::class, 'apiUpdate']);
    Route::delete('/compoffs/{id}', [CompOffController::class, 'apiDestroy']);
    Route::post('/compoffs/{id}/restore', [CompOffController::class, 'apiRestore']);
    Route::delete('/compoffs/{id}/force-delete', [CompOffController::class, 'apiForceDelete']);

    // Leave Report
    Route::get('/leave-report', [LeaveReportController::class, 'apiIndex']);
    Route::get('/leave-report/compoff', [LeaveReportController::class, 'apiCompoff']);
});

/*
|--------------------------------------------------------------------------
| 10. Leave Approval (sanctum)
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
| 11. Pharmacy
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/pharmacy/dashboard', [PharmacyDashboardController::class, 'dashboardApi']);

// Stock, GRN, Verify/Reject
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

    // GRN
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
| 12. Expiry Management
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
| 13. Controlled Drugs & Sales Returns
|--------------------------------------------------------------------------
*/

Route::prefix('controlled-drugs')->group(function () {

    // CRUD
    Route::get('/', [ControlledDrugController::class, 'apiIndex']);
    Route::get('/{id}', [ControlledDrugController::class, 'apiShow']);
    Route::post('/', [ControlledDrugController::class, 'apiStore']);
    Route::put('/{id}', [ControlledDrugController::class, 'apiUpdate']);
    Route::delete('/{id}', [ControlledDrugController::class, 'apiDestroy']);

    // GRN under controlled drugs
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

    // Sales Returns
    Route::get('/sales-returns', [SalesReturnController::class, 'apiIndex']);
    Route::get('/sales-returns/{id}', [SalesReturnController::class, 'apiShow']);
    Route::post('/sales-returns', [SalesReturnController::class, 'apiStore']);
    Route::put('/sales-returns/{id}', [SalesReturnController::class, 'apiUpdate']);
    Route::post('/sales-returns/{id}/approve', [SalesReturnController::class, 'apiApprove']);
    Route::post('/sales-returns/{id}/reject', [SalesReturnController::class, 'apiReject']);
    Route::get('/sales-bills/search', [SalesReturnController::class, 'apiBillSearch']);
});

/*
|--------------------------------------------------------------------------
| 14. Prescriptions
|--------------------------------------------------------------------------
*/

Route::prefix('prescriptions')->group(function () {
    Route::get('/', [PrescriptionController::class, 'apiIndex']);
    Route::get('/{id}', [PrescriptionController::class, 'apiShow']);
    Route::post('/dispense/{id}', [PrescriptionController::class, 'apiDispense']);
    Route::post('/reject/{id}', [PrescriptionController::class, 'apiReject']);
    Route::get('/bill/{id}', [PrescriptionController::class, 'apiBill']);
});

/*
|--------------------------------------------------------------------------
| 15. Surgery Management
|--------------------------------------------------------------------------
*/

Route::prefix('surgery')->group(function () {
    Route::get('/', [SurgeryApiController::class, 'index']);
    Route::post('/', [SurgeryApiController::class, 'store']);
    Route::get('/{id}', [SurgeryApiController::class, 'show']);
    Route::put('/{id}', [SurgeryApiController::class, 'update']);
    Route::delete('/{id}', [SurgeryApiController::class, 'destroy']);
    Route::get('/patient/{patientId}', [SurgeryApiController::class, 'getByPatient']);
    Route::get('/date/{date}', [SurgeryApiController::class, 'getByDate']);
});




/*
|--------------------------------------------------------------------------
| 16. OT (Operation Theatre)
|--------------------------------------------------------------------------
*/


Route::prefix('ot')->group(function () {
    Route::get('/', [OTApiController::class, 'index']);
    Route::post('/', [OTApiController::class, 'store']);
    Route::get('/{id}', [OTApiController::class, 'show']);
    Route::put('/{id}', [OTApiController::class, 'update']);
    Route::delete('/{id}', [OTApiController::class, 'destroy']);
    Route::post('/{id}/toggle-status', [OTApiController::class, 'toggleStatus']);
});

/*
|--------------------------------------------------------------------------
| 17. Post-Operative Care
|--------------------------------------------------------------------------
*/

Route::prefix('post-operative')->group(function () {
    Route::get('/', [PostOperativeApiController::class, 'index']);
    Route::post('/', [PostOperativeApiController::class, 'store']);
    Route::get('/{id}', [PostOperativeApiController::class, 'show']);
    Route::put('/{id}', [PostOperativeApiController::class, 'update']);
    Route::delete('/{id}', [PostOperativeApiController::class, 'destroy']);
    Route::get('/surgery/{surgeryId}', [PostOperativeApiController::class, 'getBySurgery']);
});

/*
|--------------------------------------------------------------------------
| 18. Doctor (OPD) — Consultations & Appointments
|--------------------------------------------------------------------------
*/

Route::prefix('consultations')->group(function () {

    Route::get('/medicines', [ConsultationController::class, 'apiMedicines']);

    // Appointments (nested under consultations)
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

    // Consultation CRUD
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

/*
|--------------------------------------------------------------------------
| 19. Appointments (standalone)
|--------------------------------------------------------------------------
*/

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

Route::prefix('payroll/allowance')->group(function () {
    Route::get('/', [PayrollAllowanceController::class, 'index']);
    Route::post('/', [PayrollAllowanceController::class, 'store']);
    Route::get('/deleted', [PayrollAllowanceController::class, 'deleted']);
    Route::post('/{id}/restore', [PayrollAllowanceController::class, 'restore']);
    Route::delete('/{id}/force-delete', [PayrollAllowanceController::class, 'forceDelete']);
    Route::put('/{id}', [PayrollAllowanceController::class, 'update']);
    Route::delete('/{id}', [PayrollAllowanceController::class, 'destroy']);
    Route::patch('/{id}/toggle-status', [PayrollAllowanceController::class, 'toggleStatus']);
});
/*
|--------------------------------------------------------------------------
| 20. Employee Document Management (EDM)
|--------------------------------------------------------------------------
*/

Route::prefix('edm')->group(function () {
    Route::get('/', [EmployeeDocumentApiController::class, 'index']);
    Route::post('/', [EmployeeDocumentApiController::class, 'store']);
    Route::get('/{id}', [EmployeeDocumentApiController::class, 'show']);
    Route::post('/update/{id}', [EmployeeDocumentApiController::class, 'update']);
    Route::delete('/{id}', [EmployeeDocumentApiController::class, 'destroy']);
    Route::get('/download/{id}', [EmployeeDocumentApiController::class, 'download']);
    Route::get('/file/{id}', [EmployeeDocumentApiController::class, 'file']);
});

/*
|--------------------------------------------------------------------------
| 21. Reception: Tokens & Doctors
|--------------------------------------------------------------------------
*/

Route::prefix('tokens')->group(function () {
    Route::get('/', [TokenController::class, 'apiIndex']);
    Route::post('/', [TokenController::class, 'apiStore']);
    Route::get('/{id}', [TokenController::class, 'apiShow']);
    Route::patch('{id}/skip', [TokenController::class, 'apiSkip']);
    Route::patch('{id}/complete', [TokenController::class, 'apiComplete']);
    Route::patch('{id}/reassign', [TokenController::class, 'apiReassign']);
});

Route::get('/doctors', [TokenController::class, 'apiDoctors']);

/*
|--------------------------------------------------------------------------
| 22. Nurse: Patient Monitoring (Vitals)
|--------------------------------------------------------------------------
*/

Route::prefix('vitals')->group(function () {
    // Specific routes FIRST (before /{id} wildcard)
    Route::get('/trash', [PatientMonitoringController::class, 'apiTrash']);
    Route::get('/patients', [PatientMonitoringController::class, 'apiGetPatients']);
    Route::get('/nurses', [PatientMonitoringController::class, 'apiGetNurses']);

    // Dynamic routes SECOND
    Route::get('/', [PatientMonitoringController::class, 'apiIndex']);
    Route::get('/{id}', [PatientMonitoringController::class, 'apiShow']);
    Route::post('/', [PatientMonitoringController::class, 'apiStore']);
    Route::put('/{id}', [PatientMonitoringController::class, 'apiUpdate']);
    Route::delete('/{id}', [PatientMonitoringController::class, 'apiDestroy']);
    Route::put('/{id}/restore', [PatientMonitoringController::class, 'apiRestore']);
    Route::delete('/{id}/force-delete', [PatientMonitoringController::class, 'apiForceDelete']);
});

/*
|--------------------------------------------------------------------------
| 23. Nursing Notes
|--------------------------------------------------------------------------
*/

Route::prefix('nursing-notes')->group(function () {
    Route::get('/', [NurseNotesController::class, 'apiIndex']);
    Route::post('/', [NurseNotesController::class, 'apiStore']);
    Route::get('/deleted', [NurseNotesController::class, 'apiDeleted']);
    Route::get('/form/{id?}', [NurseNotesController::class, 'apiForm']);
    Route::get('/{id}', [NurseNotesController::class, 'apiShow']);
    Route::put('/{id}', [NurseNotesController::class, 'apiUpdate']);
    Route::delete('/{id}', [NurseNotesController::class, 'apiDelete']);
    Route::post('/{id}/restore', [NurseNotesController::class, 'apiRestore']);
    Route::delete('/{id}/force-delete', [NurseNotesController::class, 'apiForceDelete']);
});

/*
|--------------------------------------------------------------------------
| 24. Emergency Cases
|--------------------------------------------------------------------------
*/

Route::prefix('emergency-cases')->group(function () {
    Route::get('/patients', [EmergencyCaseController::class, 'getPatientsApi']);
    Route::post('/emergency', [EmergencyCaseController::class, 'storeApi']);
});

/*
|--------------------------------------------------------------------------
| 25. Payroll: Deductions
|--------------------------------------------------------------------------
*/

Route::prefix('payroll/deductions')->group(function () {
    Route::get('/', [PayrollDeductionController::class, 'apiIndex']);
    Route::get('/deleted', [PayrollDeductionController::class, 'apiDeleted']);
    Route::get('/{id}', [PayrollDeductionController::class, 'apiShow']);
    Route::post('/', [PayrollDeductionController::class, 'apiStore']);
    Route::put('/{id}', [PayrollDeductionController::class, 'apiUpdate']);
    Route::delete('/{id}', [PayrollDeductionController::class, 'apiDestroy']);
    Route::post('/{id}/restore', [PayrollDeductionController::class, 'apiRestore']);
    Route::put('/{id}/status', [PayrollDeductionController::class, 'apiToggleStatus']);
});


/*
|--------------------------------------------------------------------------
| 26. Payroll: Hourly Pay
|--------------------------------------------------------------------------
*/



Route::prefix('hourly-pay')->group(function () {

    Route::get('/', [HourlyPayController::class, 'apiIndex']);
    Route::post('/', [HourlyPayController::class, 'apiStore']);


    Route::get('/deleted', [HourlyPayController::class, 'apiDeleted']);

    Route::get('/{id}', [HourlyPayController::class, 'apiShow']);
    Route::put('/{id}', [HourlyPayController::class, 'apiUpdate']);
    Route::delete('/{id}', [HourlyPayController::class, 'apiDestroy']);

    Route::post('/restore/{id}', [HourlyPayController::class, 'apiRestore']);
    Route::delete('/force-delete/{id}', [HourlyPayController::class, 'apiForceDelete']);
});
/*
|--------------------------------------------------------------------------
| 26. Payroll: deduction rule set
|--------------------------------------------------------------------------
*/
Route::prefix('deduction-rule-sets')->group(function () {

    Route::get('/', [DeductionRuleSetController::class, 'apiIndex']);
    Route::post('/', [DeductionRuleSetController::class, 'apiStore']);

    // ✅ MUST be before /{id}
    Route::get('/deleted', [DeductionRuleSetController::class, 'apiDeleted']);
    Route::post('/restore/{id}', [DeductionRuleSetController::class, 'apiRestore']);
    Route::delete('/force-delete/{id}', [DeductionRuleSetController::class, 'apiForceDelete']);

    // ✅ These LAST, no whereNumber
    Route::get('/{id}', [DeductionRuleSetController::class, 'apiShow']);
    Route::put('/{id}', [DeductionRuleSetController::class, 'apiUpdate']);
    Route::delete('/{id}', [DeductionRuleSetController::class, 'apiDestroy']);

});