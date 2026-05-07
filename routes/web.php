<?php

use App\Http\Controllers\Admin\AdminBiometricEnrollController;
/*
|--------------------------------------------------------------------------
| Controller Imports
|--------------------------------------------------------------------------
*/

// Auth
use App\Http\Controllers\Admin\DashboardController;
// Admin
use App\Http\Controllers\Admin\FinancialYearController;
use App\Http\Controllers\Admin\FinancialYearMappingController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\InsuranceConsentController;
use App\Http\Controllers\Admin\Inventory\GrnController;
use App\Http\Controllers\Admin\Inventory\InventoryVendorController;
use App\Http\Controllers\Admin\Inventory\ItemController;
use App\Http\Controllers\Admin\Inventory\PurchaseOrderController;
use App\Http\Controllers\Admin\Inventory\ReportController;

// Admin > Inventory
use App\Http\Controllers\Admin\Inventory\StockAuditController;
use App\Http\Controllers\Admin\Inventory\StockTransferController;
use App\Http\Controllers\Admin\LabTestController;
use App\Http\Controllers\Admin\LabDashboardController;
use App\Http\Controllers\Admin\Nurse\InfectionControlController;
use App\Http\Controllers\Admin\Nurse\MedicationAdministrationController;
use App\Http\Controllers\Admin\Nurse\PatientMonitoringController;
use App\Http\Controllers\Admin\Nurse\NurseShiftsController;
use App\Http\Controllers\Admin\Nurse\DischargePreparationController;
use App\Http\Controllers\Admin\Nurse\NurseReportController;

// Admin > Pharmacy
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\PatientPortal\PatientEmrController;
use App\Http\Controllers\Admin\PatientPortal\PatientPortalController;
use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;
// Admin > Laboratory
use App\Http\Controllers\Admin\Radiology\RadiologyController;
use App\Http\Controllers\Admin\Radiology\RadiologyHistoryController;
use App\Http\Controllers\Admin\Radiology\RadiologyReportController;
use App\Http\Controllers\Admin\Radiology\RadiologyReviewController;
use App\Http\Controllers\Admin\Radiology\ScanRequestController;
use App\Http\Controllers\Admin\Radiology\ScanScheduleController;
use App\Http\Controllers\Admin\Radiology\ScanTypeController;
use App\Http\Controllers\Admin\Radiology\ScanUploadController;
use App\Http\Controllers\Admin\ResultEntryController;
// Admin > Nurse
use App\Http\Controllers\Admin\Pharmacy\PrescriptionController;
// Admin > Pharmacy
use App\Http\Controllers\Admin\Pharmacy\SalesReturnController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SampleCollectionController;
use App\Http\Controllers\Admin\Pharmacy\PharmacyReportController;

// Attendance
use App\Http\Controllers\Admin\UserController;
// Doctor
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\ControlledDrugController;
use App\Http\Controllers\Doctor\IpdController;

// HR
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\Doctor\ConsultationController;
use App\Http\Controllers\Doctor\NotificationController;
use App\Http\Controllers\doctor\surgery\OTController;
use App\Http\Controllers\doctor\surgery\PostOperativeController;
// Leave Management
use App\Http\Controllers\doctor\surgery\SurgeryController;
use App\Http\Controllers\Doctor\ViewAppointmentController;
use App\Http\Controllers\Doctor\ViewPatientController;
use App\Http\Controllers\EmergencyCaseController;
use App\Http\Controllers\EmergencyRecordController;
use App\Http\Controllers\ExpiryController;
use App\Http\Controllers\HR\HRDashboardController;
use App\Http\Controllers\HR\Payroll\PayrollAllowanceController;
use App\Http\Controllers\HR\Payroll\HourlyPayController;
use App\Http\Controllers\HR\Payroll\HourlyPayApprovalController;
use App\Http\Controllers\HR\Payroll\DeductionRuleSetController;
use App\Http\Controllers\HR\Payroll\StatutoryDeductionController;
use App\Http\Controllers\HR\Payroll\EmployeeSalaryAssignmentController;
use App\Http\Controllers\HR\Payroll\SalaryStructureController;
use App\Http\Controllers\HR\Payroll\PrePayrollAdjustmentController;
use App\Http\Controllers\HR\Payroll\PayrollResultEarningController;
use App\Http\Controllers\HR\Payroll\PayrollResultDeductionController;
use App\Http\Controllers\HR\PayrollDeductionController;
use App\Http\Controllers\HR\Payroll\StatutoryContributionController;
use App\Http\Controllers\HR\Payroll\PayrollResultController;
use App\Http\Controllers\HR\Payroll\RateEmployeeMappingController;




use App\Http\Controllers\HR\Reports\AttendanceReportController;
use App\Http\Controllers\HR\Reports\DepartmentSalaryReportController;
use App\Http\Controllers\HR\Reports\OvertimeReportController;
use App\Http\Controllers\HR\Reports\PayrollReportController;
use App\Http\Controllers\HR\Reports\ReportsDashboardController;
use App\Http\Controllers\HR\Reports\StaffStrengthReportController;



use App\Http\Controllers\HR\ShiftSchedulingController;
// Root-level Controllers (alphabetical)
use App\Http\Controllers\HR\StaffManagementController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\LeaveManagement\CompOffController;
use App\Http\Controllers\LeaveManagement\HolidayController;
use App\Http\Controllers\LeaveManagement\LeaveAdjustmentController;
use App\Http\Controllers\LeaveManagement\LeaveApplicationController;
use App\Http\Controllers\LeaveManagement\LeaveApprovalController;
use App\Http\Controllers\LeaveManagement\LeaveMappingController;
use App\Http\Controllers\LeaveManagement\LeaveReportController;
use App\Http\Controllers\LeaveManagement\LeaveTypeController;
use App\Http\Controllers\LeaveManagement\WeekendController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NurseNotesController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PatientApiController;
use App\Http\Controllers\Admin\PatientPortal\DataUsageConsentController;
use App\Http\Controllers\PharmacyDashboardController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\WorkStatusController;
//use App\Http\Controllers\ExpiryController;
use App\Http\Controllers\ReturnController;
//use App\Http\Controllers\attendance\AttendanceController;
use App\Http\Controllers\IPDAdmissionController;

use App\Http\Controllers\ReceptionistReportController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\EquipmentMaintenanceController;
use App\Http\Controllers\Admin\EquipmentCalibrationController;
use App\Http\Controllers\Admin\EquipmentBreakdownController;
use App\Http\Controllers\Admin\PreventiveMaintenanceController;

use App\Http\Controllers\Admin\ParameterController;
use App\Http\Controllers\Admin\TestParameterController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\InventoryItemController;
use App\Http\Controllers\Admin\InventoryUsageController;
use App\Http\Controllers\Admin\InventoryAlertController;
use App\Http\Controllers\Admin\InventoryExpiryController;
// use App\Http\Controllers\ExpiryController;
// use App\Http\Controllers\ControlledDrugController;
// use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;
// use App\Http\Controllers\Admin\Pharmacy\SalesReturnController;
// use App\Http\Controllers\Admin\Pharmacy\PrescriptionController;

use App\Http\Controllers\Admin\Nurse\IsolationController;
use App\Http\Controllers\Admin\Nurse\PpeComplianceController;
use App\Http\Controllers\Admin\Nurse\LabReportController;

// use App\Http\Controllers\ExpiryController;
// use App\Http\Controllers\ControlledDrugController;
// use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;
// use App\Http\Controllers\Admin\Pharmacy\SalesReturnController;
// use App\Http\Controllers\Admin\Pharmacy\PrescriptionController;

//use App\Http\Controllers\ReceptionistReportController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\BasicBillingController;
use App\Http\Controllers\Admin\Pharmacy\PharmacyBillingController;
use App\Http\Controllers\Doctor\Surgery\ConsentController;

use App\Http\Controllers\ReceptionistDashboardController;

//Accountant
use App\Http\Controllers\AccountantBillingController;
use App\Http\Controllers\Admin\Accountant\AccountantPaymentController;


//use App\Http\Controllers\Admin\Nurse\MedicationAdministrationController;

//use App\Http\Controllers\Admin\Nurse\PatientMonitoringController;
//nurse
// use App\Http\Controllers\NurseNotesController;
// use Illuminate\Support\Facades\Route;

// use App\http\Controllers\attendance\AttendanceController;
//use App\Http\Controllers\ExpiryController;

#use App\Http\Controllers\ControlledDrugController;
#use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;
#use App\Http\Controllers\Admin\Pharmacy\SalesReturnController;
#use App\Http\Controllers\Admin\Pharmacy\PrescriptionController;

// use App\Http\Controllers\ExpiryController;
// use App\Http\Controllers\ControlledDrugController;
// use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;
// use App\Http\Controllers\Admin\Pharmacy\SalesReturnController;
// use App\Http\Controllers\Admin\Pharmacy\PrescriptionController;

/*
|--------------------------------------------------------------------------
| 1. Public & Guest Routes
|--------------------------------------------------------------------------
| Routes accessible without logging in (Login, OTP, Set MPIN).
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

Route::middleware(['auth', 'role:doctor,admin'])->group(function () {
    // Prefix 'doctor.' for legacy/specific doctor routes
    Route::prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/view-patient/{id}', [ViewPatientController::class, 'viewPatientProfile'])->name('view-patient-profile');
        Route::get('/consultation-summary/{id}', [ConsultationController::class, 'summary'])->name('consultation-summary');
        Route::get('/appointments', [ViewAppointmentController::class, 'index'])->name('view-appointment');

        // Consultation Page
        Route::get('/consultation/{id}', [ConsultationController::class, 'index'])->name('consultation');
        Route::get('/view-consultations', [ConsultationController::class, 'viewConsultations'])->name('view-consultations');
        Route::post('/consultation/save', [ConsultationController::class, 'store'])->name('save-consultation');
        Route::post('/consultation/store', [ConsultationController::class, 'store'])->name('consultation.store');
        Route::get('/consultation/edit/{id}', [ConsultationController::class, 'edit'])->name('edit-consultation');
        Route::post('/consultation/update/{id}', [ConsultationController::class, 'update'])->name('update-consultation');
        Route::get('/print-prescription/{id}', [ConsultationController::class, 'printPrescription'])->name('print-prescription');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    });

    // These names match the sidebar EXACTLY (no doctor. prefix)
    Route::get('/surgery', [SurgeryController::class, 'index'])->name('surgery.index');
    Route::get('/surgery/create', [SurgeryController::class, 'create'])->name('surgery.create');
    Route::post('/surgery/store', [SurgeryController::class, 'store'])->name('surgery.store');
    Route::get('/surgery/{id}/edit', [SurgeryController::class, 'edit'])->name('surgery.edit');
    Route::put('/surgery/{id}', [SurgeryController::class, 'update'])->name('surgery.update');
    Route::delete('/surgery/{id}', [SurgeryController::class, 'destroy'])->name('surgery.destroy');

    Route::get('/ot', [OTController::class, 'index'])->name('ot.index');
    Route::get('/ot/create', [OTController::class, 'create'])->name('ot.create');
    Route::post('/ot/store', [OTController::class, 'store'])->name('ot.store');

    Route::get('/postoperative', [PostOperativeController::class, 'index'])->name('post.index');
    Route::get('/postoperative/create/{id}', [PostOperativeController::class, 'create'])->name('post.create');
    Route::post('/postoperative/store', [PostOperativeController::class, 'store'])->name('post.store');
    Route::get('/postoperative/{id}/edit', [PostOperativeController::class, 'edit'])->name('post.edit');
    Route::put('/postoperative/{id}', [PostOperativeController::class, 'update'])->name('post.update');
    Route::delete('/postoperative/{id}', [PostOperativeController::class, 'destroy'])->name('post.destroy');
});

/*
|--------------------------------------------------------------------------
| 3. ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


    // ================= HR REPORTS =================
        Route::prefix('reports')->name('reports.')->group(function () {

            Route::get('/dashboard', [ReportsDashboardController::class, 'index'])->name('dashboard');

            Route::get('/staff-strength', [StaffStrengthReportController::class, 'index'])->name('staff-strength');

            Route::get('/attendance', [AttendanceReportController::class, 'index'])->name('attendance');

            Route::get('/leave', [LeaveReportController::class, 'index'])->name('leave');

            Route::get('/payroll', [PayrollReportController::class, 'index'])->name('payroll');

            Route::get('/overtime', [OvertimeReportController::class, 'index'])->name('overtime');

            Route::get('/department-salary', [DepartmentSalaryReportController::class, 'index'])->name('department-salary');

        });

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
            Route::get('/force-delete/{id}', [DesignationController::class, 'forceDelete'])->name('forceDelete');
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
        | Pharmacy: Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/pharmacy/dashboard', [PharmacyDashboardController::class, 'index'])->name('pharmacy.dashboard');

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

            Route::delete('/delete/{id}', [StockController::class, 'destroy'])->name('delete');

            Route::get('/trash', [StockController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [StockController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [StockController::class, 'forceDelete'])->name('forceDelete');

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

        Route::prefix('pharmacy/reports')->group(function () {

    Route::get('/sales', [PharmacyReportController::class, 'sales'])->name('reports.sales');
    Route::get('/medicine', [PharmacyReportController::class, 'medicine'])->name('reports.medicine');
    Route::get('/batch', [PharmacyReportController::class, 'batch'])->name('reports.batch');
    Route::get('/expiry', [PharmacyReportController::class, 'expiry'])->name('reports.expiry');
    Route::get('/low-stock', [PharmacyReportController::class, 'lowStock'])->name('reports.lowstock');
    Route::get('/controlled-drugs', [PharmacyReportController::class, 'controlled'])->name('reports.controlled');
    Route::get('/vendor', [PharmacyReportController::class, 'vendor'])->name('reports.vendor');
    Route::get('/grn', [PharmacyReportController::class, 'grn'])->name('reports.grn');
    Route::get('/billing', [PharmacyReportController::class, 'billing'])->name('reports.billing');

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
        Route::resource('tokens', TokenController::class);
        Route::get('/', [TokenController::class, 'index'])->name('index');

        Route::patch('tokens/{id}/skip', [TokenController::class, 'skip'])
            ->name('tokens.skip');

        Route::patch('tokens/{id}/complete', [TokenController::class, 'complete'])
            ->name('tokens.complete');

        /*
        |--------------------------------------------------------------------------
        | Reception: Emergency Handling
        |--------------------------------------------------------------------------
        */
        Route::get('/emergency/create', [EmergencyCaseController::class, 'create'])->name('emergency.create');
        Route::post('/emergency/store', [EmergencyCaseController::class, 'store'])->name('emergency.store');
    });

// Appointments routes

// --------------------------------------------------------------------------
// End of initial Admin/HR/Doctor sections. Redundant intermediate blocks removed.
// --------------------------------------------------------------------------


// ================= HR PAYROLL ROUTES =================
Route::middleware(['auth'])
    ->prefix('hr')
    ->name('hr.')
    ->group(function () {

        Route::prefix('payroll')->name('payroll.')->group(function () {

            Route::resource('statutory-deduction', StatutoryDeductionController::class);
            // Deleted records
            Route::get('statutory-deduction/deleted', [StatutoryDeductionController::class, 'deleted'])
                ->name('statutory-deduction.deleted');

            // Restore
            Route::put('statutory-deduction/{id}/restore', [StatutoryDeductionController::class, 'restore'])
                ->name('statutory-deduction.restore');

            // Force delete
            Route::delete('statutory-deduction/{id}/force-delete', [StatutoryDeductionController::class, 'forceDelete'])
                ->name('statutory-deduction.force-delete');
            Route::resource('salary-structure', SalaryStructureController::class);

                        // Deleted records
            Route::get('salary-structure/deleted', [SalaryStructureController::class, 'deleted'])
                ->name('salary-structure.deleted');

            // Restore
            Route::put('salary-structure/{id}/restore', [SalaryStructureController::class, 'restore'])
                ->name('salary-structure.restore');

            // Force delete
            Route::delete('salary-structure/{id}/force-delete', [SalaryStructureController::class, 'forceDelete'])
                ->name('salary-structure.force-delete');
            Route::resource('hourly-pay-approval', HourlyPayApprovalController::class);
            Route::resource('allowance', PayrollAllowanceController::class);
            Route::resource('deduction-rule-set', DeductionRuleSetController::class);
            Route::resource('employee-salary-assignment', EmployeeSalaryAssignmentController::class);

            // Deleted records
            Route::get('employee-salary-assignment/deleted', [EmployeeSalaryAssignmentController::class, 'deleted'])
                ->name('employee-salary-assignment.deleted');

            // Restore
            Route::put('employee-salary-assignment/{id}/restore', [EmployeeSalaryAssignmentController::class, 'restore'])
                ->name('employee-salary-assignment.restore');

            // Force delete
            Route::delete('employee-salary-assignment/{id}/force-delete', [EmployeeSalaryAssignmentController::class, 'forceDelete'])
                ->name('employee-salary-assignment.force-delete');

            Route::resource('statutory-contribution', StatutoryContributionController::class);

            Route::resource('pre-payroll', PrePayrollAdjustmentController::class);

            Route::post(
                    'pre-payroll/{id}/approve',
                    [PrePayrollAdjustmentController::class, 'approve']
                )->name('pre-payroll.approve');
                        });

                        Route::get(
                            'pre-payroll/deleted',
                            [PrePayrollAdjustmentController::class, 'deleted']
                        )->name('pre-payroll.deleted');

                        Route::put(
                            'pre-payroll/{id}/restore',
                            [PrePayrollAdjustmentController::class, 'restore']
                        )->name('pre-payroll.restore');

                        Route::delete(
                            'pre-payroll/{id}/force-delete',
                            [PrePayrollAdjustmentController::class, 'forceDelete']
                        )->name('pre-payroll.force-delete');

                        Route::get(
                        'hourly-pay-approval/trash',
                        [HourlyPayApprovalController::class, 'trash']
                    )->name('hourly-pay-approval.trash');

                    Route::put(
                    'hourly-pay-approval/{id}/restore',
                    [HourlyPayApprovalController::class, 'restore']
                )->name('hourly-pay-approval.restore');

                Route::delete(
                    'hourly-pay-approval/{id}/force-delete',
                    [HourlyPayApprovalController::class, 'forceDelete']
                )->name('hourly-pay-approval.force-delete');

    });


// shift scheduling

/*
|--------------------------------------------------------------------------
| SHIFT SCHEDULING (Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Shift Types
    Route::get('/shifts', [ShiftSchedulingController::class, 'shiftIndex'])->name('shifts.index');
    Route::get('/shifts/create', [ShiftSchedulingController::class, 'shiftCreate'])->name('shifts.create');
    Route::post('/shifts', [ShiftSchedulingController::class, 'shiftStore'])->name('shifts.store');
    Route::get('/shifts/{id}/edit', [ShiftSchedulingController::class, 'shiftEdit'])->name('shifts.edit');
    Route::put('/shifts/{id}', [ShiftSchedulingController::class, 'shiftUpdate'])->name('shifts.update');
    Route::delete('/shifts/{id}', [ShiftSchedulingController::class, 'shiftDelete'])->name('shifts.destroy');
    Route::patch('/shifts/{id}/toggle-status', [ShiftSchedulingController::class, 'toggleShiftStatus'])->name('shifts.toggleStatus');
    Route::get('/shifts/deleted', [ShiftSchedulingController::class, 'deletedShifts'])->name('shifts.deleted');
    Route::put('/shifts/{id}/restore', [ShiftSchedulingController::class, 'restoreShift'])->name('shifts.restore');
    Route::delete('/shifts/{id}/force-delete', [ShiftSchedulingController::class, 'forceDeleteShift'])->name('shifts.forceDelete');
    Route::get('/shifts/{id}', [ShiftSchedulingController::class, 'shiftShow'])->name('shifts.show');

    // Shift Assignments
    Route::get('/shift-assignments', [ShiftSchedulingController::class, 'assignmentIndex'])->name('shift-assignments.index');
    Route::get('/shift-assignments/create', [ShiftSchedulingController::class, 'assignmentCreate'])->name('shift-assignments.create');
    Route::post('/shift-assignments', [ShiftSchedulingController::class, 'assignmentStore'])->name('shift-assignments.store');
    Route::get('/shift-assignments/{id}/edit', [ShiftSchedulingController::class, 'assignmentEdit'])->name('shift-assignments.edit');
    Route::get('/shift-assignments/deleted', [ShiftSchedulingController::class, 'deletedAssignments'])->name('shift-assignments.deleted');
    Route::put('/shift-assignments/{id}/restore', [ShiftSchedulingController::class, 'restoreAssignment'])->name('shift-assignments.restore');
    Route::delete('/shift-assignments/{id}/force-delete', [ShiftSchedulingController::class, 'forceDeleteAssignment'])->name('shift-assignments.forceDelete');
    Route::get('/shift-assignments/{id}', [ShiftSchedulingController::class, 'assignmentShow'])->name('shift-assignments.show');
    Route::delete('/shift-assignments/{id}', [ShiftSchedulingController::class, 'assignmentDelete'])->name('shift-assignments.destroy');

    // Rotational Shifts
    Route::get('/shift-rotations', [ShiftSchedulingController::class, 'rotationIndex'])->name('shift-rotations.index');
    Route::get('/shift-rotations/create', [ShiftSchedulingController::class, 'rotationCreate'])->name('shift-rotations.create');
    Route::post('/shift-rotations', [ShiftSchedulingController::class, 'rotationStore'])->name('shift-rotations.store');
    Route::get('/shift-rotations/{id}/edit', [ShiftSchedulingController::class, 'rotationEdit'])->name('shift-rotations.edit');
    Route::put('/shift-rotations/{id}', [ShiftSchedulingController::class, 'rotationUpdate'])->name('shift-rotations.update');
    Route::delete('/shift-rotations/{id}', [ShiftSchedulingController::class, 'rotationDelete'])->name('shift-rotations.destroy');
    Route::get('/shift-rotations/deleted', [ShiftSchedulingController::class, 'deletedRotations'])->name('shift-rotations.deleted');
    Route::put('/shift-rotations/{id}/restore', [ShiftSchedulingController::class, 'restoreRotation'])->name('shift-rotations.restore');
    Route::delete('/shift-rotations/{id}/force-delete', [ShiftSchedulingController::class, 'forceDeleteRotation'])->name('shift-rotations.forceDelete');
    Route::get('/shift-rotations/{id}', [ShiftSchedulingController::class, 'rotationShow'])->name('shift-rotations.show');

    // Weekly Offs
    Route::get('/weekly-offs', [ShiftSchedulingController::class, 'weeklyOffIndex'])->name('weekly-offs.index');
    Route::get('/weekly-offs/create', [ShiftSchedulingController::class, 'weeklyOffCreate'])->name('weekly-offs.create');
    Route::post('/weekly-offs', [ShiftSchedulingController::class, 'weeklyOffStore'])->name('weekly-offs.store');
    Route::get('/weekly-offs/{id}/edit', [ShiftSchedulingController::class, 'weeklyOffEdit'])->name('weekly-offs.edit');
    Route::put('/weekly-offs/{id}', [ShiftSchedulingController::class, 'weeklyOffUpdate'])->name('weekly-offs.update');
    Route::delete('/weekly-offs/{id}', [ShiftSchedulingController::class, 'weeklyOffDelete'])->name('weekly-offs.destroy');
    Route::get('/weekly-offs/deleted', [ShiftSchedulingController::class, 'deletedWeeklyOffs'])->name('weekly-offs.deleted');
    Route::put('/weekly-offs/{id}/restore', [ShiftSchedulingController::class, 'restoreWeeklyOff'])->name('weekly-offs.restore');
    Route::delete('/weekly-offs/{id}/force-delete', [ShiftSchedulingController::class, 'forceDeleteWeeklyOff'])->name('weekly-offs.forceDelete');
    Route::get('/weekly-offs/{id}', [ShiftSchedulingController::class, 'weeklyOffShow'])->name('weekly-offs.show');

    // Conflicts
    Route::get('/shift-conflicts', [ShiftSchedulingController::class, 'conflictIndex'])->name('shift-conflicts.index');
});

/*
|--------------------------------------------------------------------------
| 3. Admin Area
|--------------------------------------------------------------------------
| Core System Administration: User management, Infrastructure, and Settings.
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [SignInController::class, 'logout'])->name('logout');

    // --- Access Control (Roles & Users) ---
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::get('roles-deleted', [RoleController::class, 'displayDeletedRoles'])->name('roles.deleted');
    Route::put('roles/{id}/restore', [RoleController::class, 'restore'])->name('roles.restore');
    Route::delete('roles/{id}/force-delete', [RoleController::class, 'forceDeleteRole'])->name('roles.forceDelete');
    Route::patch('roles/{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('roles.toggle-status');

    Route::resource('users', UserController::class)->except(['show']);
    Route::get('users-deleted', [UserController::class, 'displayDeletedUser'])->name('users.deleted');
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDeleteUser'])->name('users.forceDelete');
    Route::patch('users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('users/biometrics', [AdminBiometricEnrollController::class, 'biometrics'])->name('users.biometrics');
    Route::post('users/{user}/biometrics/upload', [AdminBiometricEnrollController::class, 'upload'])->name('users.biometrics.upload');
    Route::delete('users/biometrics/images/{imageId}', [AdminBiometricEnrollController::class, 'delete'])->name('users.biometrics.delete');

    // --- Masters & System Config ---
    Route::resource('financial-years', FinancialYearController::class)->except(['show']);
    Route::get('financial-years/mapping', [FinancialYearMappingController::class, 'index'])->name('financial-years.mapping');
    Route::post('financial-years/mapping', [FinancialYearMappingController::class, 'store'])->name('financial-years.mapping.store');
    Route::patch('financial-years/{id}/toggle-status', [FinancialYearController::class, 'toggleStatus'])->name('financial-years.toggle-status');

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

    Route::prefix('job-type')->name('job-type.')->group(function () {
        Route::get('/', [JobTypeController::class, 'index'])->name('index');
        Route::get('/create', [JobTypeController::class, 'create'])->name('create');
        Route::post('/store', [JobTypeController::class, 'store'])->name('store');
        Route::post('/update/{id}', [JobTypeController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [JobTypeController::class, 'destroy'])->name('delete');
    });

    Route::prefix('work-status')->name('work-status.')->group(function () {
        Route::get('/', [WorkStatusController::class, 'index'])->name('index');
        Route::post('/store', [WorkStatusController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [WorkStatusController::class, 'destroy'])->name('delete');
    });

    Route::prefix('designation')->name('designation.')->group(function () {
        Route::get('/', [DesignationController::class, 'index'])->name('index');
        Route::post('/store', [DesignationController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [DesignationController::class, 'destroy'])->name('delete');
    });

    Route::resource('departments', DepartmentController::class);
    Route::get('departments-deleted', [DepartmentController::class, 'deletedHistory'])->name('departments.deleted');
    Route::put('departments/{id}/restore', [DepartmentController::class, 'restore'])->name('departments.restore');

    Route::resource('blood-groups', BloodGroupController::class);
    Route::get('blood-groups-deleted', [BloodGroupController::class, 'deletedHistory'])->name('blood-groups.deleted');

    // --- Infrastructure Management ---
    Route::resource('organization', OrganizationController::class);
    Route::get('organization-deleted', [OrganizationController::class, 'deleted'])->name('organization.deleted');
    Route::put('organization/{id}/restore', [OrganizationController::class, 'restore'])->name('organization.restore');
    Route::post('organization/{id}/force-delete', [OrganizationController::class, 'forceDelete'])->name('organization.forceDelete');
    Route::post('organization/{id}/toggleStatus', [OrganizationController::class, 'toggleStatus'])->name('organization.toggleStatus');

    Route::resource('ward', WardController::class);
    Route::get('ward-deleted', [WardController::class, 'deletedHistory'])->name('ward.deleted');
    Route::put('ward/{id}/restore', [WardController::class, 'restore'])->name('ward.restore');
    Route::post('ward/{id}/force-delete', [WardController::class, 'forceDelete'])->name('ward.forceDelete');
    Route::post('ward/{id}/toggleStatus', [WardController::class, 'toggleStatus'])->name('ward.toggleStatus');

    Route::resource('institutions', InstitutionController::class);
    Route::get('institutions-deleted', [InstitutionController::class, 'deleted'])->name('institutions.deleted');
    Route::put('institutions/{id}/restore', [InstitutionController::class, 'restore'])->name('institutions.restore');
    Route::post('institutions/{id}/force-delete', [InstitutionController::class, 'forceDelete'])->name('institutions.forceDelete');
    Route::post('institutions/{id}/toggleStatus', [InstitutionController::class, 'toggleStatus'])->name('institutions.toggleStatus');

    Route::resource('hospitals', HospitalController::class)->except(['show']);
    Route::get('hospitals-deleted', [HospitalController::class, 'deletedHistory'])->name('hospitals.deleted');
    Route::put('hospitals/{id}/restore', [HospitalController::class, 'restore'])->name('hospitals.restore');
    Route::post('hospitals/{id}/force-delete', [HospitalController::class, 'forceDelete'])->name('hospitals.forceDelete');
    Route::post('hospitals/{id}/toggleStatus', [HospitalController::class, 'toggleStatus'])->name('hospitals.toggleStatus');

    // --- Pharmacy & Inventory (Admin Level) ---
    Route::prefix('vendors')->name('vendors.')->group(function () {
        Route::get('/', [VendorController::class, 'index'])->name('index');
        Route::get('/create', [VendorController::class, 'create'])->name('create');
        Route::post('/store', [VendorController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [VendorController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [VendorController::class, 'show'])->name('show');
        Route::put('/update/{id}', [VendorController::class, 'update'])->name('update');
        Route::get('/trash', [VendorController::class, 'trash'])->name('trash');
        Route::delete('/delete/{id}', [VendorController::class, 'delete'])->name('delete');
        Route::put('/toggle-status/{id}', [VendorController::class, 'toggleStatus'])->name('toggleStatus');
    });

    Route::prefix('pharmacy')->name('grn.')->group(function () {
        Route::get('/grn', [PharmacyGrnController::class, 'index'])->name('index');
        Route::get('/grn/create', [PharmacyGrnController::class, 'create'])->name('create');
        Route::post('/grn', [PharmacyGrnController::class, 'store'])->name('store');
        Route::get('/trash', [PharmacyGrnController::class, 'trash'])->name('trash');
        Route::get('/edit/{id}', [PharmacyGrnController::class, 'edit'])->name('edit');
        Route::delete('/delete/{id}', [PharmacyGrnController::class, 'delete'])->name('delete');
        Route::get('/grn/{id}', [PharmacyGrnController::class, 'show'])->name('show');
        Route::get('/grn/{id}/verify', [PharmacyGrnController::class, 'verify'])->name('verify');
    });

    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('index');
        Route::get('/create', [StockController::class, 'create'])->name('create');
        Route::post('/store', [StockController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [StockController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [StockController::class, 'update'])->name('update');
        Route::get('/trash', [StockController::class, 'trash'])->name('trash');
        Route::delete('/delete/{id}', [StockController::class, 'destroy'])->name('delete');
        Route::put('/toggle-status/{id}', [StockController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('/low-stock', [StockController::class, 'lowStock'])->name('low');
    });

    Route::prefix('expiry')->name('expiry.')->group(function () {
        Route::get('/', [ExpiryController::class, 'index'])->name('index');
        Route::get('/create', [ExpiryController::class, 'create'])->name('create');
        Route::post('/store', [ExpiryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ExpiryController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ExpiryController::class, 'update'])->name('update');
        Route::get('/trash', [ExpiryController::class, 'trash'])->name('trash');
        Route::delete('/delete/{id}', [ExpiryController::class, 'delete'])->name('delete');
        Route::put('/toggle-status/{id}', [ExpiryController::class, 'toggleStatus'])->name('toggleStatus');
        Route::post('/mark-expired/{id}', [ExpiryController::class, 'markExpired'])->name('markExpired');
    });

    Route::prefix('controlledDrug')->name('controlledDrug.')->group(function () {
        Route::get('/', [ControlledDrugController::class, 'index'])->name('index');
        Route::get('/log', [ControlledDrugController::class, 'log'])->name('log');
        Route::get('/trash', [ControlledDrugController::class, 'trash'])->name('trash');

        Route::get('/create', [ControlledDrugController::class, 'create'])->name('create');
        Route::post('/store', [ControlledDrugController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ControlledDrugController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ControlledDrugController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ControlledDrugController::class, 'delete'])->name('delete');
        Route::put('/toggle-status/{id}', [ControlledDrugController::class, 'toggleStatus'])->name('toggleStatus');

        Route::get('/dispense', [ControlledDrugController::class, 'dispenseIndex'])->name('dispenseIndex');
        Route::get('/dispenseCreate', [ControlledDrugController::class, 'dispenseCreate'])->name('dispenseCreate');
        Route::post('/dispenseStore', [ControlledDrugController::class, 'dispenseStore'])->name('dispenseStore');
    });

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('index');
        Route::get('/create', [ItemController::class, 'create'])->name('create');
        Route::post('/store', [ItemController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ItemController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ItemController::class, 'delete'])->name('delete');
        Route::put('/toggle-status/{id}', [ItemController::class, 'toggleStatus'])->name('toggleStatus');

        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::resource('grns', GrnController::class);

        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    });

    Route::prefix('inventory-vendors')->name('inventory-vendors.')->group(function () {
        Route::get('/', [InventoryVendorController::class, 'index'])->name('index');
        Route::get('/create', [InventoryVendorController::class, 'create'])->name('create');
        Route::post('/store', [InventoryVendorController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [InventoryVendorController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [InventoryVendorController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [InventoryVendorController::class, 'delete'])->name('delete');
        Route::get('/trash', [InventoryVendorController::class, 'trash'])->name('trash');
        Route::put('/toggle-status/{id}', [InventoryVendorController::class, 'toggleStatus'])->name('toggleStatus');
    });

    // --- Dynamic Modules & Sidebar Builder ---
    Route::prefix('modules')->name('modules.')->group(function () {
        Route::get('/', [ModuleController::class, 'index'])->name('index');
        Route::get('/create', [ModuleController::class, 'create'])->name('create');
        Route::post('/store', [ModuleController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [ModuleController::class, 'destroy'])->name('delete'); // FIXED: Added {id}
        Route::get('/show/{id}', [ModuleController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [ModuleController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ModuleController::class, 'update'])->name('update');
        Route::patch('/toggle-status/{id}', [ModuleController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('/deleted', [ModuleController::class, 'deleted'])->name('deleted');
        Route::put('/{id}/restore', [ModuleController::class, 'restore'])->name('restore');
        Route::post('/{id}/force-delete', [ModuleController::class, 'forceDelete'])->name('forceDelete');
    });

    // --- Patient Utilities ---

    Route::prefix('beds')->name('beds.')->group(function () {
        Route::get('/', [BedController::class, 'index'])->name('index');
        Route::get('/create', [BedController::class, 'create'])->name('create');
        Route::post('/store', [BedController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [BedController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [BedController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [BedController::class, 'delete'])->name('delete');
        Route::get('/deleted', [BedController::class, 'deleted'])->name('deleted');
        Route::get('/generate-code/{ward}', [BedController::class, 'generateCode'])->name('generateCode');
        Route::put('/{id}/restore', [BedController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [BedController::class, 'forceDelete'])->name('forceDelete');
    });
    Route::resource('beds', BedController::class);

    // --- Patient Management ---
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/duplicates', [PatientController::class, 'duplicates'])->name('duplicates');
        Route::post('/merge', [PatientController::class, 'merge'])->name('merge');
        Route::get('/deleted', [PatientController::class, 'deleted'])->name('deleted');
        Route::put('/{id}/restore', [PatientController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [PatientController::class, 'forceDelete'])->name('forceDelete');
        Route::post('/{id}/toggle-status', [PatientController::class, 'toggleStatus'])->name('toggleStatus');
        Route::post('/{id}/toggle-vip', [PatientController::class, 'toggleVip'])->name('toggleVip');
        Route::resource('/', PatientController::class)->parameters(['' => 'patient']);
    });

    // --- Receptionist Tools ---
    Route::resource('tokens', TokenController::class);
    Route::patch('tokens/{id}/skip', [TokenController::class, 'skip'])->name('tokens.skip');
    Route::patch('tokens/{id}/complete', [TokenController::class, 'complete'])->name('tokens.complete');

    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [AppointmentController::class, 'index'])->name('index');
        Route::get('/create', [AppointmentController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [AppointmentController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [AppointmentController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AppointmentController::class, 'delete'])->name('delete');
        Route::get('/show/{id}', [AppointmentController::class, 'show'])->name('show');
        Route::post('/store', [AppointmentController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AppointmentController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [AppointmentController::class, 'show'])->name('show');
        Route::put('/update/{id}', [AppointmentController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AppointmentController::class, 'destroy'])->name('delete');

        Route::get('/trash', [AppointmentController::class, 'trash'])->name('trash');
        Route::put('/{id}/restore', [AppointmentController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [AppointmentController::class, 'forceDelete'])->name('forceDelete');
        Route::get('/get-doctors/{department_id}', [AppointmentController::class, 'getDoctors'])->name('getDoctors');
    });

    // --- Admin Pharmacy & Sales Return ---

    Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
        Route::get('/', [PrescriptionController::class, 'index'])->name('index');
        Route::get('/create', [PrescriptionController::class, 'createOffline'])->name('offline.create');
        Route::post('/store', [PrescriptionController::class, 'storeOffline'])->name('offline.store');
        Route::get('/dispense/{id}', [PrescriptionController::class, 'dispense'])->name('dispense');
        Route::get('/verify/{id}', [PrescriptionController::class, 'verify'])->name('verify');
        Route::get('/bill/{id}', [PrescriptionController::class, 'showBill'])->name('bill');
        Route::get('/{id}', [PrescriptionController::class, 'show'])->name('show');
    });

    // Laboratory Management
    Route::prefix('laboratory')->name('laboratory.')->group(function () {


        Route::get('/tests', [LabTestController::class, 'index'])->name('tests.index');

        Route::get('/tests/create', [LabTestController::class, 'create'])->name('tests.create');

        Route::post('/tests/store', [LabTestController::class, 'store'])->name('tests.store');

        Route::get('/sample-collection', [SampleCollectionController::class, 'index'])->name('sample-collection');

        Route::post('/sample/collect/{id}', [SampleCollectionController::class, 'collect'])->name('sample.collect');

        Route::post('/sample/process/{id}', [SampleCollectionController::class, 'startProcessing'])->name('sample.process');

        Route::post('/sample/complete/{id}', [SampleCollectionController::class, 'complete'])->name('sample.complete');

        Route::post('/sample/reject/{id}', [SampleCollectionController::class, 'reject'])->name('sample.reject');


        // Equipment Management

        Route::get('/equipment/deleted', [EquipmentController::class, 'deleted'])
            ->name('equipment.deleted');

        Route::put('/equipment/{id}/restore', [EquipmentController::class, 'restore'])
            ->name('equipment.restore');

        Route::delete('/equipment/{id}/force-delete', [EquipmentController::class, 'forceDelete'])
            ->name('equipment.forceDelete');

        Route::post('/equipment/{id}/toggle-status', [EquipmentController::class, 'toggleStatus'])
            ->name('equipment.toggleStatus');

        Route::resource('equipment', EquipmentController::class);

        // 🔧 Equipment Maintenance
        Route::get('/maintenance', [EquipmentMaintenanceController::class, 'show'])
            ->name('maintenance.show');
        Route::get('/maintenance/deleted', [EquipmentMaintenanceController::class, 'deleted'])
            ->name('maintenance.deleted');

        Route::put('/maintenance/{id}/restore', [EquipmentMaintenanceController::class, 'restore'])
            ->name('maintenance.restore');

        Route::delete('/maintenance/{id}/force-delete', [EquipmentMaintenanceController::class, 'forceDelete'])
            ->name('maintenance.forceDelete');

        Route::resource('maintenance', EquipmentMaintenanceController::class);



        Route::get('/calibration/deleted', [EquipmentCalibrationController::class, 'deleted'])
            ->name('calibration.deleted');

        Route::put('/calibration/{id}/restore', [EquipmentCalibrationController::class, 'restore'])
            ->name('calibration.restore');

        Route::delete('/calibration/{id}/force-delete', [EquipmentCalibrationController::class, 'forceDelete'])
            ->name('calibration.forceDelete');

        Route::resource('calibration', EquipmentCalibrationController::class);


        Route::get('/breakdown/deleted', [EquipmentBreakdownController::class, 'deleted'])
            ->name('breakdown.deleted');

        Route::put('/breakdown/{id}/restore', [EquipmentBreakdownController::class, 'restore'])
            ->name('breakdown.restore');

        Route::delete('/breakdown/{id}/force-delete', [EquipmentBreakdownController::class, 'forceDelete'])
            ->name('breakdown.forceDelete');

        Route::resource('breakdown', EquipmentBreakdownController::class);


        Route::get('/preventive/deleted', [PreventiveMaintenanceController::class, 'deleted'])
            ->name('preventive.deleted');

        Route::put('/preventive/{id}/restore', [PreventiveMaintenanceController::class, 'restore'])
            ->name('preventive.restore');

        Route::delete('/preventive/{id}/force-delete', [PreventiveMaintenanceController::class, 'forceDelete'])
            ->name('preventive.forceDelete');

        Route::resource('preventive', PreventiveMaintenanceController::class);

        // ================= PARAMETERS =================
        Route::resource('parameters', ParameterController::class);


        // ================= TEST PARAMETER MAPPING =================
        Route::resource('test-parameters', TestParameterController::class);

        // ✅ PARAMETER MAPPING (ONLY ONE MODULE)
        Route::get('/parameter-mapping', [TestParameterController::class, 'create'])
            ->name('test-parameters.index');

        Route::post('/parameter-mapping/store', [TestParameterController::class, 'store'])
            ->name('test-parameters.store');
        // ✅ RESULT ENTRY ROUTES
        Route::get('/result-entry', [ResultEntryController::class, 'index'])->name('result-entry');

        Route::post('/result/save-draft/{id}', [ResultEntryController::class, 'saveDraft'])->name('result.saveDraft');

        Route::post('/result/submit/{id}', [ResultEntryController::class, 'submit'])->name('result.submit');

        // ================= REPORT UPLOAD =================

        Route::get('/report', [AdminReportController::class, 'index'])->name('report.index');
        Route::get('/report/create', [AdminReportController::class, 'create'])->name('report.create');
        Route::post('/report/store', [AdminReportController::class, 'store'])->name('report.store');
        Route::get('/report/deleted', [AdminReportController::class, 'deleted'])->name('report.deleted');
        Route::get('/report/{id}', [AdminReportController::class, 'show'])->name('report.show');
        Route::get('/report/{id}/edit', [AdminReportController::class, 'edit'])->name('report.edit');
        Route::post('/report/{id}/update-files', [AdminReportController::class, 'updateFiles'])->name('report.updateFiles');
        Route::delete('/report/{id}', [AdminReportController::class, 'destroy'])->name('report.destroy');

        Route::put('/report/{id}/restore', [AdminReportController::class, 'restore'])->name('report.restore');

        Route::delete('/report/{id}/force-delete', [AdminReportController::class, 'forceDelete'])->name('report.forceDelete');


        Route::post('/report/{id}/verify', [AdminReportController::class, 'verify'])
            ->name('report.verify');

        Route::post('/report/{id}/reject', [AdminReportController::class, 'reject'])
            ->name('report.reject');

        Route::post('/report/{id}/sign', [AdminReportController::class, 'sign'])
            ->name('report.sign');

        Route::post('/report/{id}/finalize', [AdminReportController::class, 'finalize'])
            ->name('report.finalize');

            
        Route::get('dashboard', [LabDashboardController::class, 'index'])
            ->name('dashboard.index');

        Route::prefix('alerts')->group(function () {

            Route::get('/', [AlertController::class, 'index'])
                ->name('alerts.index');

            Route::post('/{id}/ack', [AlertController::class, 'acknowledge'])
                ->name('alerts.ack');

        }); 

    Route::prefix('reports')->name('reports.')->group(function () {

    Route::get('/daily', [AdminReportController::class, 'dailyReport'])->name('daily');
    Route::get('/daily/export', [AdminReportController::class, 'dailyReportExport'])->name('daily.export');
    Route::get('/pending', [AdminReportController::class, 'pendingReport'])->name('pending');
    Route::get('/summary', [AdminReportController::class, 'completionSummary'])->name('summary');
    Route::get('/critical', [AdminReportController::class, 'criticalReport'])->name('critical');
    Route::get('/critical/{id}/resolve', [AdminReportController::class, 'resolveCritical'])->name('critical.resolve');
    Route::get('/maintenance', [AdminReportController::class, 'maintenanceReport'])->name('maintenance');
    Route::get('/reagent', [AdminReportController::class, 'reagentUsageReport'])->name('reagent');

});

        Route::prefix('inventory') ->name('inventory.')->group(function () {

        // Dashboard
        Route::get('/', [InventoryController::class, 'index'])
            ->name('dashboard');

        Route::post('use/{id}', [InventoryController::class, 'useItem'])
    ->name('use');

        Route::resource('items', InventoryItemController::class);

        // Usage Logs
        Route::get('usage', [InventoryUsageController::class, 'index'])
            ->name('usage.index');

        // Alerts
        Route::get('alerts', [InventoryAlertController::class, 'index'])
            ->name('alerts.index');

        Route::post('alerts/{id}/acknowledge', [InventoryAlertController::class, 'acknowledge'])
            ->name('alerts.acknowledge');

        Route::post('alerts/{id}/resolve', [InventoryAlertController::class, 'resolve'])
            ->name('alerts.resolve');

        // Expiry
        Route::get('expiry', [InventoryExpiryController::class, 'index'])
            ->name('expiry.index');
    
        });
    });

});



/*
|--------------------------------------------------------------------------
| 4. HR & Leave Management
|--------------------------------------------------------------------------
| Roles: HR, Admin, Manager, HOD.
*/
/*
|--------------------------------------------------------------------------
| 4. HR & Leave Management
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:hr,admin,manager,hod'])->prefix('hr')->name('hr.')->group(function () {

    Route::get('/dashboard', [HRDashboardController::class, 'index'])->name('dashboard');

    Route::get('staff-management/deleted', [StaffManagementController::class, 'deleted'])->name('staff-management.deleted');
    Route::post('staff-management/{id}/restore', [StaffManagementController::class, 'restore'])->name('staff-management.restore');
    Route::delete('staff-management/{id}/force-delete', [StaffManagementController::class, 'forceDelete'])
        ->name('staff-management.forceDelete');
    Route::resource('staff-management', StaffManagementController::class);

    // --- Attendance ---
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/create', [AttendanceController::class, 'create'])->name('create');
        Route::post('/', [AttendanceController::class, 'store'])->name('store');
        Route::get('/late-entries', [AttendanceController::class, 'lateEntries'])->name('lateEntries');
        Route::get('/overtime', [AttendanceController::class, 'overtime'])->name('overtime');
        Route::get('/report/daily', [AttendanceController::class, 'dailyReport'])->name('dailyReport');
        Route::get('/report/monthly', [AttendanceController::class, 'monthlyReport'])->name('monthlyReport');
        Route::get('/get-designations/{department_id}', [AttendanceController::class, 'getDesignations'])->name('getDesignations');
        Route::get('/get-employees/{designation_id}', [AttendanceController::class, 'getEmployees'])->name('getEmployees');
        Route::get('/get-shift-time/{id}', [AttendanceController::class, 'getShiftTime'])->name('getShiftTime');
        Route::get('/{id}', [AttendanceController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AttendanceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AttendanceController::class, 'update'])->name('update');
        Route::delete('/{id}', [AttendanceController::class, 'destroy'])->name('destroy');
    });

    // --- Weekends ---
    Route::prefix('weekends')->name('weekends.')->group(function () {
        Route::get('/deleted', [WeekendController::class, 'deleted'])->name('deleted');
        Route::post('/{id}/restore', [WeekendController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [WeekendController::class, 'forceDelete'])->name('forceDelete');
        Route::patch('/{id}/toggle-status', [WeekendController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('/staff-by-roles', [WeekendController::class, 'getStaffByRoles'])->name('staff-by-roles');
        Route::get('/', [WeekendController::class, 'index'])->name('index');
        Route::get('/create', [WeekendController::class, 'create'])->name('create');
        Route::post('/', [WeekendController::class, 'store'])->name('store');
        Route::get('/{id}', [WeekendController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [WeekendController::class, 'edit'])->name('edit');
        Route::put('/{id}', [WeekendController::class, 'update'])->name('update');
        Route::delete('/{id}', [WeekendController::class, 'destroy'])->name('delete');
    });

    // --- Holidays ---
    Route::prefix('holidays')->name('holidays.')->group(function () {
        Route::get('/deleted', [HolidayController::class, 'deleted'])->name('deleted');
        Route::post('/{id}/restore', [HolidayController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [HolidayController::class, 'forceDelete'])->name('forceDelete');
        Route::get('/', [HolidayController::class, 'index'])->name('index');
        Route::get('/create', [HolidayController::class, 'create'])->name('create');
        Route::get('/show/{id}', [HolidayController::class, 'show'])->name('show');
        Route::post('/', [HolidayController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [HolidayController::class, 'edit'])->name('edit');
        Route::put('/{id}', [HolidayController::class, 'update'])->name('update');
        Route::delete('/{id}', [HolidayController::class, 'destroy'])->name('delete');
        Route::post('/{id}/toggleStatus', [HolidayController::class, 'toggleStatus'])->name('toggleStatus');
    });

    // --- Leave Types ---
    Route::prefix('leave-type')->name('leave-type.')->group(function () {
        Route::get('/deleted', [LeaveTypeController::class, 'deleted'])->name('deleted');
        Route::post('/{id}/restore', [LeaveTypeController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [LeaveTypeController::class, 'forceDelete'])->name('forceDelete');
        Route::get('/', [LeaveTypeController::class, 'index'])->name('index');
        Route::get('/create', [LeaveTypeController::class, 'create'])->name('create');
        Route::post('/', [LeaveTypeController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [LeaveTypeController::class, 'edit'])->name('edit');
        Route::put('/{id}', [LeaveTypeController::class, 'update'])->name('update');
        Route::delete('/{id}', [LeaveTypeController::class, 'destroy'])->name('delete');
    });

    // --- Leave Mappings ---
    Route::prefix('leave-mappings')->name('leave-mappings.')->group(function () {
        Route::get('/deleted', [LeaveMappingController::class, 'deleted'])->name('deleted');
        Route::post('/{id}/restore', [LeaveMappingController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [LeaveMappingController::class, 'forceDelete'])->name('forceDelete');
        Route::get('/', [LeaveMappingController::class, 'index'])->name('index');
        Route::get('/create', [LeaveMappingController::class, 'create'])->name('create');
        Route::post('/', [LeaveMappingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [LeaveMappingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [LeaveMappingController::class, 'update'])->name('update');
        Route::delete('/{id}', [LeaveMappingController::class, 'destroy'])->name('delete');
    });

    // --- Comp Offs ---
    Route::prefix('compoffs')->name('compoffs.')->group(function () {
        Route::get('/deleted', [CompOffController::class, 'deleted'])->name('deleted');
        Route::post('/{id}/restore', [CompOffController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [CompOffController::class, 'forceDelete'])->name('forceDelete');
        Route::get('/', [CompOffController::class, 'index'])->name('index');
        Route::get('/create', [CompOffController::class, 'create'])->name('create');
        Route::post('/', [CompOffController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CompOffController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CompOffController::class, 'update'])->name('update');
        Route::delete('/{id}', [CompOffController::class, 'destroy'])->name('delete');
    });

    Route::prefix('leave-application')->name('leave-application.')->group(function () {
        Route::get('/', [LeaveApplicationController::class, 'index'])->name('index');
        Route::get('/create', [LeaveApplicationController::class, 'create'])->name('create');
        Route::post('/store', [LeaveApplicationController::class, 'store'])->name('store');
        Route::post('/withdraw/{id}', [LeaveApplicationController::class, 'withdraw'])->name('withdraw');
        Route::get('/show/{id}', [LeaveApplicationController::class, 'show'])->name('show');


    });

    Route::prefix('leave-adjustments')->name('leave-adjustments.')->group(function () {
        Route::get('/', [LeaveAdjustmentController::class, 'index'])->name('index');
        Route::get('/create', [LeaveAdjustmentController::class, 'create'])->name('create');
        Route::post('/store', [LeaveAdjustmentController::class, 'store'])->name('store');
        Route::get('/show/{id}', [LeaveAdjustmentController::class, 'show'])->name('show');
        Route::get('/mapping/{staff}', [LeaveAdjustmentController::class, 'getLeaveMapping'])->name('mapping');
    });

    Route::prefix('leave-approvals')->name('leave-approvals.')->group(function () {
        Route::get('/', [LeaveApprovalController::class, 'index'])->name('index');
        Route::get('/{id}/show', [LeaveApprovalController::class, 'show'])->name('show');
        Route::get('/approved', [LeaveApprovalController::class, 'approvedIndex'])->name('approved');
        Route::post('/{id}/approve', [LeaveApprovalController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [LeaveApprovalController::class, 'reject'])->name('reject');
    });

    // Employee Document Management (EDM)
    Route::prefix('edm')->name('edm.')->group(function () {

        Route::get('/', [\App\Http\Controllers\HR\EDM\EmployeeDocumentController::class, 'index'])
            ->name('index');

        Route::get('/create', [\App\Http\Controllers\HR\EDM\EmployeeDocumentController::class, 'create'])
            ->name('create');

        Route::post('/store', [\App\Http\Controllers\HR\EDM\EmployeeDocumentController::class, 'store'])
            ->name('store');

        Route::get('/download/{id}', [\App\Http\Controllers\HR\EDM\EmployeeDocumentController::class, 'download'])
            ->name('download');

        Route::delete('/delete/{id}', [\App\Http\Controllers\HR\EDM\EmployeeDocumentController::class, 'destroy'])
            ->name('delete');

        Route::get('/edit/{id}', [\App\Http\Controllers\HR\EDM\EmployeeDocumentController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [\App\Http\Controllers\HR\EDM\EmployeeDocumentController::class, 'update'])->name('update');
    });
    // Leave report
    Route::prefix('leave-report')->name('leave-report.')->group(function () {
        Route::get('/', [LeaveReportController::class, 'index'])->name('index');
    });

    // Payroll - Allowance

    Route::prefix('payroll/allowance')
        ->name('payroll.allowance.')
        ->group(function () {
            Route::get('/', [PayrollAllowanceController::class, 'index'])->name('index');
            Route::get('/create', [PayrollAllowanceController::class, 'create'])->name('create');
            Route::post('/', [PayrollAllowanceController::class, 'store'])->name('store');
            Route::get('/deleted/list', [PayrollAllowanceController::class, 'deleted'])->name('deleted');
            Route::post('/restore/{id}', [PayrollAllowanceController::class, 'restore'])->name('restore');
            Route::delete('/force-delete/{id}', [PayrollAllowanceController::class, 'forceDelete'])->name('forceDelete');
            Route::get('/{id}/edit', [PayrollAllowanceController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PayrollAllowanceController::class, 'update'])->name('update');
            Route::delete('/{id}', [PayrollAllowanceController::class, 'destroy'])->name('destroy');
        });
    // Payroll - Deduction
    Route::prefix('payroll/deduction')->name('payroll.deduction.')->group(function () {
        Route::get('/', [PayrollDeductionController::class, 'index'])->name('index');
        Route::get('/create', [PayrollDeductionController::class, 'create'])->name('create');
        Route::post('/store', [PayrollDeductionController::class, 'store'])->name('store');
        Route::get('/deleted', [PayrollDeductionController::class, 'deleted'])->name('deleted');
        Route::get('/{id}/show', [PayrollDeductionController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PayrollDeductionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PayrollDeductionController::class, 'update'])->name('update');
        Route::delete('/{id}', [PayrollDeductionController::class, 'destroy'])->name('delete');
        Route::post('/{id}/restore', [PayrollDeductionController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [PayrollDeductionController::class, 'forceDelete'])->name('forceDelete');
    });
    // Payroll - Hourly Pay

    Route::prefix('payroll/hourly-pay')
        ->name('payroll.hourly-pay.')
        ->group(function () {

            Route::get('/', [HourlyPayController::class, 'index'])->name('index');
            Route::get('/create', [HourlyPayController::class, 'create'])->name('create');
            Route::post('/', [HourlyPayController::class, 'store'])->name('store');
            Route::get('/{id}', [HourlyPayController::class, 'show'])->name('show');

            Route::get('/deleted/list', [HourlyPayController::class, 'deleted'])->name('deleted');
            Route::post('/restore/{id}', [HourlyPayController::class, 'restore'])->name('restore');
            Route::delete('/force-delete/{id}', [HourlyPayController::class, 'forceDelete'])->name('forceDelete');

            Route::get('/{id}/edit', [HourlyPayController::class, 'edit'])->name('edit');
            Route::put('/{id}', [HourlyPayController::class, 'update'])->name('update');
            Route::delete('/{id}', [HourlyPayController::class, 'destroy'])->name('destroy');
        });
    // ----------------------------------------
// Payroll - Hourly Pay Approval
// ----------------------------------------

    Route::prefix('payroll/hourly-pay-approval')
        ->name('payroll.hourly-pay-approval.')
        ->group(function () {

            Route::get(
                '/',
                [HourlyPayApprovalController::class, 'index']
            )->name('index');

            Route::get(
                '/create',
                [HourlyPayApprovalController::class, 'create']
            )->name('create');

            Route::post(
                '/store',
                [HourlyPayApprovalController::class, 'store']
            )->name('store');

            Route::get(
                '/edit/{id}',
                [HourlyPayApprovalController::class, 'edit']
            )->name('edit');

            Route::put(
                '/update/{id}',
                [HourlyPayApprovalController::class, 'update']
            )->name('update');

            Route::delete(
                '/delete/{id}',
                [HourlyPayApprovalController::class, 'destroy']
            )->name('destroy');


            // Trash View
            Route::get(
                '/trash',
                [HourlyPayApprovalController::class, 'trash']
            )->name('trash');


            // Restore
            Route::post(
                '/restore/{id}',
                [HourlyPayApprovalController::class, 'restore']
            )->name('restore');


            // ✅ NEW — Permanent Delete
            Route::delete(
                '/force-delete/{id}',
                [HourlyPayApprovalController::class, 'forceDelete']
            )->name('forceDelete');

        });

    //---------Payroll -Deduction rule set-----------//

    Route::prefix('payroll/deduction-rule-set')
        ->name('payroll.deduction-rule-set.')
        ->group(function () {
            Route::get('/', [DeductionRuleSetController::class, 'index'])->name('index');
            Route::get('/create', [DeductionRuleSetController::class, 'create'])->name('create');
            Route::post('/store', [DeductionRuleSetController::class, 'store'])->name('store');
            Route::get('/{id}/show', [DeductionRuleSetController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [DeductionRuleSetController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DeductionRuleSetController::class, 'update'])->name('update');
            Route::delete('/{id}', [DeductionRuleSetController::class, 'destroy'])->name('delete');
            Route::get('/deleted', [DeductionRuleSetController::class, 'deleted'])->name('deleted');
            Route::post('/{id}/restore', [DeductionRuleSetController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [DeductionRuleSetController::class, 'forceDelete'])->name('forceDelete');

        });




// --- Payroll Statutory Contribution ---

// --- Payroll Statutory Contribution ---

Route::prefix('payroll/statutory-contribution')
    ->name('payroll.statutory-contribution.')
    ->group(function () {

    // INDEX

    Route::get('/',
        [StatutoryContributionController::class, 'index']
    )->name('index');


    // CREATE

    Route::get('/create',
        [StatutoryContributionController::class, 'create']
    )->name('create');

    Route::post('/store',
        [StatutoryContributionController::class, 'store']
    )->name('store');


    // ⭐ STATIC ROUTES FIRST

    Route::get('/deleted',
        [StatutoryContributionController::class, 'deleted']
    )->name('deleted');


    // SHOW

    Route::get('/{id}/show',
        [StatutoryContributionController::class, 'show']
    )->name('show');


    // EDIT

    Route::get('/{id}/edit',
        [StatutoryContributionController::class, 'edit']
    )->name('edit');


    // UPDATE

    Route::put('/{id}',
        [StatutoryContributionController::class, 'update']
    )->name('update');


    // DELETE (Soft)

    Route::delete('/{id}',
        [StatutoryContributionController::class, 'destroy']
    )->name('destroy');


    // RESTORE

    Route::post('/{id}/restore',
        [StatutoryContributionController::class, 'restore']
    )->name('restore');


    // PERMANENT DELETE

    Route::delete('/{id}/force-delete',
        [StatutoryContributionController::class, 'forceDelete']
    )->name('forceDelete');

});

//---------Payroll - Payroll Result-----------//

Route::prefix('payroll/payroll-result')
    ->name('payroll.payroll-result.')
    ->group(function () {

    Route::get('/',
        [PayrollResultController::class, 'index']
    )->name('index');

    Route::get('/{id}/show',
        [PayrollResultController::class, 'show']
    )->name('show');

    // Generate Payroll Results
    Route::get('/generate',
        [PayrollResultController::class, 'generate']
    )->name('generate');

});


// --- Payroll Rate Employee Mapping --- //

Route::prefix('payroll/rate-employee-mapping')
    ->name('payroll.rate-employee-mapping.')
    ->group(function () {

    // INDEX
    Route::get('/',
        [RateEmployeeMappingController::class, 'index']
    )->name('index');

    // CREATE
    Route::get('/create',
        [RateEmployeeMappingController::class, 'create']
    )->name('create');

    Route::post('/store',
        [RateEmployeeMappingController::class, 'store']
    )->name('store');


    // STATIC ROUTES FIRST
    Route::get('/deleted',
        [RateEmployeeMappingController::class, 'deleted']
    )->name('deleted');


    // SHOW
    Route::get('/{id}/show',
        [RateEmployeeMappingController::class, 'show']
    )->name('show');


    // EDIT
    Route::get('/{id}/edit',
        [RateEmployeeMappingController::class, 'edit']
    )->name('edit');


    // UPDATE
    Route::put('/{id}',
        [RateEmployeeMappingController::class, 'update']
    )->name('update');


    // DELETE (Soft)
    Route::delete('/{id}',
        [RateEmployeeMappingController::class, 'destroy']
    )->name('destroy');


    // RESTORE
    Route::post('/{id}/restore',
        [RateEmployeeMappingController::class, 'restore']
    )->name('restore');


    // FORCE DELETE
    Route::delete('/{id}/force-delete',
        [RateEmployeeMappingController::class, 'forceDelete']
    )->name('forceDelete');

});


    //---------Payroll -Statutory deduction-----------//
Route::prefix('payroll/statutory-deduction')
    ->name('payroll.statutory-deduction.')
    ->group(function () {

    Route::get('/', [StatutoryDeductionController::class, 'index'])->name('index');
    Route::get('/create', [StatutoryDeductionController::class, 'create'])->name('create');
    Route::post('/store', [StatutoryDeductionController::class, 'store'])->name('store');

    // Static
    Route::get('/deleted', [StatutoryDeductionController::class, 'deleted'])->name('deleted');

    // Dynamic
    Route::get('/{id}/show', [StatutoryDeductionController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [StatutoryDeductionController::class, 'edit'])->name('edit');
    Route::put('/{id}', [StatutoryDeductionController::class, 'update'])->name('update');
    Route::delete('/{id}', [StatutoryDeductionController::class, 'destroy'])->name('delete');

    Route::post('/{id}/restore', [StatutoryDeductionController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force-delete', [StatutoryDeductionController::class, 'forceDelete'])->name('forceDelete');
    });





//---------Payroll - Salary Structure-----------//

Route::prefix('payroll/salary-structure')
    ->name('payroll.salary-structure.')
    ->group(function () {

    Route::get('/', [SalaryStructureController::class, 'index'])->name('index');

    Route::get('/create', [SalaryStructureController::class, 'create'])->name('create');

    Route::post('/store', [SalaryStructureController::class, 'store'])->name('store');

    Route::get('/{id}/show', [SalaryStructureController::class, 'show'])->name('show');
    
    Route::get('/{id}/edit', [SalaryStructureController::class, 'edit'])->name('edit');

    Route::put('/{id}', [SalaryStructureController::class, 'update'])->name('update');

    Route::delete('/{id}', [SalaryStructureController::class, 'destroy'])->name('delete');
    Route::get('/deleted', [SalaryStructureController::class, 'deleted'])->name('deleted');

    Route::post('/{id}/restore', [SalaryStructureController::class, 'restore'])->name('restore');

    Route::delete('/{id}/force-delete', [SalaryStructureController::class, 'forceDelete'])->name('forceDelete');
});
 //---------Payroll - Employee Salary assignment-----------//
Route::prefix('payroll/employee-salary-assignment')
    ->name('payroll.employee-salary-assignment.')
    ->group(function () {

    Route::get('/', [EmployeeSalaryAssignmentController::class, 'index'])->name('index');
    Route::get('/create', [EmployeeSalaryAssignmentController::class, 'create'])->name('create');
    Route::post('/store', [EmployeeSalaryAssignmentController::class, 'store'])->name('store');

    // static
    Route::get('/deleted', [EmployeeSalaryAssignmentController::class, 'deleted'])->name('deleted');

    // restore + force delete
    Route::post('/{id}/restore', [EmployeeSalaryAssignmentController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force-delete', [EmployeeSalaryAssignmentController::class, 'forceDelete'])->name('forceDelete');

    // dynamic
    Route::get('/{id}/show', [EmployeeSalaryAssignmentController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [EmployeeSalaryAssignmentController::class, 'edit'])->name('edit');
    Route::put('/{id}', [EmployeeSalaryAssignmentController::class, 'update'])->name('update');
    Route::delete('/{id}', [EmployeeSalaryAssignmentController::class, 'destroy'])->name('delete');
});



//---------Payroll - Pre-Payroll Adjustment-----------//
Route::prefix('pre-payroll')->group(function () {

    Route::get('/', [PrePayrollAdjustmentController::class, 'index'])
        ->name('pre-payroll.index');

    Route::get('/create', [PrePayrollAdjustmentController::class, 'create'])
        ->name('pre-payroll.create');

    Route::post('/', [PrePayrollAdjustmentController::class, 'store'])
        ->name('pre-payroll.store');
        Route::post('/approve/{id}', [PrePayrollAdjustmentController::class, 'approve'])
    ->name('pre-payroll.approve');
    Route::get('pre-payroll/{id}/edit', 
    [PrePayrollAdjustmentController::class, 'edit']
)->name('pre-payroll.edit');
Route::put('pre-payroll/{id}', 
    [PrePayrollAdjustmentController::class, 'update']
)->name('pre-payroll.update');
});
 
//---------Payroll - Payroll Result -earnings breakdown-----------//
Route::prefix('payroll/payroll-result-earnings')
    ->name('payroll.payroll-result-earnings.')
    ->group(function () {
    Route::get('/', [PayrollResultEarningController::class, 'index'])->name('index');

    Route::get('/create', [PayrollResultEarningController::class, 'create'])->name('create');
    Route::post('/', [PayrollResultEarningController::class, 'store'])->name('store');

    Route::get('/deleted', [PayrollResultEarningController::class, 'deleted'])->name('deleted');

    Route::get('/{id}', [PayrollResultEarningController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PayrollResultEarningController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PayrollResultEarningController::class, 'update'])->name('update');

    Route::delete('/{id}', [PayrollResultEarningController::class, 'destroy'])->name('delete');

    Route::post('/restore/{id}', [PayrollResultEarningController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [PayrollResultEarningController::class, 'forceDelete'])->name('forceDelete');
});

//---------Payroll - Payroll Result -deduction breakdown-----------//
Route::prefix('payroll/payroll-result-deductions')
    ->name('payroll.payroll-result-deductions.')
    ->group(function () {

    Route::get('/', [PayrollResultDeductionController::class, 'index'])
        ->name('index');

    Route::get('/create', [PayrollResultDeductionController::class, 'create'])
        ->name('create');

    Route::post('/', [PayrollResultDeductionController::class, 'store'])
        ->name('store');

    Route::get('/{id}', [PayrollResultDeductionController::class, 'show'])
        ->name('show');

    Route::get('/{id}/edit', [PayrollResultDeductionController::class, 'edit'])
        ->name('edit');

    Route::put('/{id}', [PayrollResultDeductionController::class, 'update'])
        ->name('update');

    Route::delete('/{id}', [PayrollResultDeductionController::class, 'destroy'])
        ->name('delete');

});
});


/*
|--------------------------------------------------------------------------
| 5. Inventory API routes
|--------------------------------------------------------------------------
| External or internal JS access to stock data.
*/
Route::prefix('stock')->group(function () {
    Route::get('stock', [StockController::class, 'apiIndex']);
    Route::get('stock/low', [StockController::class, 'apiLowStock']);
    Route::post('stock', [StockController::class, 'apiStore']);
    Route::put('stock/{id}', [StockController::class, 'apiUpdate']);
    Route::delete('stock/{id}', [StockController::class, 'apiDestroy']);
    Route::get('stock-trash', [StockController::class, 'apiTrash']);
    Route::post('stock-restore/{id}', [StockController::class, 'apiRestore']);
    Route::delete('stock-force-delete/{id}', [StockController::class, 'apiForceDelete']);
});

/*
|--------------------------------------------------------------------------
| Nursing Notes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('nursing-notes')->name('nursing-notes.')->group(function () {
        Route::get('/', [NurseNotesController::class, 'index'])->name('index');
        Route::get('/create', [NurseNotesController::class, 'create'])->name('create');
        Route::post('/', [NurseNotesController::class, 'store'])->name('store');

        Route::get('/trash', [NurseNotesController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [NurseNotesController::class, 'restore'])->name('restore');

        Route::get('/{id}/edit', [NurseNotesController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [NurseNotesController::class, 'update'])->name('update');
        Route::delete('/{id}', [NurseNotesController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [NurseNotesController::class, 'show'])->name('show');
    });
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        // ==============================
// RECEPTIONIST REPORTS
// ==============================
Route::prefix('receptionist')->name('receptionist.')->group(function () {

    Route::prefix('reports')->name('reports.')->group(function () {

        Route::get('registration', [ReceptionistReportController::class, 'registration'])
            ->name('registration');

        Route::get('appointment', [ReceptionistReportController::class, 'appointment'])
            ->name('appointment');

        Route::get('token', [ReceptionistReportController::class, 'token'])
            ->name('token');

        Route::get('collection', [ReceptionistReportController::class, 'collection'])
            ->name('collection');

        Route::get('admission', [ReceptionistReportController::class, 'admission'])
            ->name('admission');

    });

});
        /*
        |--------------------------------------------------------------------------
        | Sales Return Module
        |--------------------------------------------------------------------------
        */

        Route::resource('salesReturn', SalesReturnController::class);

        Route::get(
            'salesReturn/{id}/print',
            [SalesReturnController::class, 'print']
        )->name('salesReturn.print');

        Route::post(
            'salesReturn/{id}/approve',
            [SalesReturnController::class, 'approve']
        )->name('salesReturn.approve');

        Route::post(
            'salesReturn/{id}/reject',
            [SalesReturnController::class, 'reject']
        )->name('salesReturn.reject');


        

    });

/*
|--------------------------------------------------------------------------
| surgery routes (doctor)
|--------------------------------------------------------------------------
*/

Route::prefix('doctor')->group(function () {

    Route::get('/surgery', [SurgeryController::class, 'index'])->name('surgery.index');

    Route::get('/surgery/create', [SurgeryController::class, 'create'])->name('surgery.create');

    Route::post('/surgery/store', [SurgeryController::class, 'store'])->name('surgery.store');

    Route::get('/surgery/{id}/edit', [SurgeryController::class, 'edit'])->name('surgery.edit');

    Route::delete('/surgery/{id}', [SurgeryController::class, 'destroy'])->name('surgery.destroy');

    Route::put('/surgery/{id}', [SurgeryController::class, 'update'])->name('surgery.update');

    Route::get('/ot', [OTController::class, 'index'])->name('ot.index');

    Route::get('/ot/create', [OTController::class, 'create'])->name('ot.create');

    Route::post('/ot/store', [OTController::class, 'store'])->name('ot.store');

    Route::get('/ot/{id}/edit', [OTController::class, 'edit'])->name('ot.edit');

    Route::put('/ot/{id}', [OTController::class, 'update'])->name('ot.update');

    Route::delete('/ot/{id}', [OTController::class, 'destroy'])->name('ot.destroy');

    Route::post('/ot/{id}/toggle-status', [OTController::class, 'toggleStatus'])->name('ot.toggle-status');

    Route::get('/postoperative', [PostOperativeController::class, 'index'])->name('post.index');
    Route::prefix('prescriptions')->name('prescriptions.')->group(function () {

        Route::get('/surgery/{id}/postoperative', [PostOperativeController::class, 'create'])->name('post.create');

        Route::post('/post/store', [PostOperativeController::class, 'store'])->name('post.store');

        Route::get('/postoperative/{id}/edit', [PostOperativeController::class, 'edit'])->name('post.edit');

        Route::put('/postoperative/{id}', [PostOperativeController::class, 'update'])->name('post.update');

        Route::delete('/postoperative/{id}', [PostOperativeController::class, 'destroy'])->name('post.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Prescripion
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::prefix('prescriptions')->name('prescriptions.')->group(function () {

            Route::get('/', [PrescriptionController::class, 'index'])
                ->name('index');
            Route::get('/create', [PrescriptionController::class, 'createOffline'])
                ->name('create');
            Route::post('/store', [PrescriptionController::class, 'storeOffline'])
                ->name('offline.store');
            Route::get('/verify/{id}', [PrescriptionController::class, 'verify'])
                ->name('verify');
            Route::post('/reject/{id}', [PrescriptionController::class, 'reject'])
                ->name('reject');
            Route::get('/dispense/{id}', [PrescriptionController::class, 'dispense'])
                ->name('dispense');
            Route::post('/dispense/{id}', [PrescriptionController::class, 'storeDispense'])
                ->name('dispense.store');
            Route::get('/bill/{id}', [PrescriptionController::class, 'showBill'])
                ->name('bill');
            Route::get('/print/{id}', [PrescriptionController::class, 'print'])
                ->name('print');
            Route::get('/{id}', [PrescriptionController::class, 'show'])
                ->name('show');

        });

    });
});

// Nurse: Patient Monitoring routes

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('patientMonitoring', [PatientMonitoringController::class, 'index'])
        ->name('patientMonitoring.index');

    Route::get('patientMonitoring/create', [PatientMonitoringController::class, 'create'])
        ->name('patientMonitoring.create');

    Route::post('patientMonitoring/store', [PatientMonitoringController::class, 'store'])
        ->name('patientMonitoring.store');

    Route::get('patientMonitoring/show/{id}', [PatientMonitoringController::class, 'show'])
        ->name('patientMonitoring.show');

    Route::get('patientMonitoring/edit/{id}', [PatientMonitoringController::class, 'edit'])
        ->name('patientMonitoring.edit');

    Route::post('patientMonitoring/update/{id}', [PatientMonitoringController::class, 'update'])
        ->name('patientMonitoring.update');

    Route::delete('patientMonitoring/delete/{id}', [PatientMonitoringController::class, 'delete'])
        ->name('patientMonitoring.delete');

    Route::get('patientMonitoring/trash', [PatientMonitoringController::class, 'trash'])
        ->name('patientMonitoring.trash');

    Route::get('patientMonitoring/restore/{id}', [PatientMonitoringController::class, 'restore'])
        ->name('patientMonitoring.restore');

    Route::get('patientMonitoring/forceDelete/{id}', [PatientMonitoringController::class, 'forceDelete'])
        ->name('patientMonitoring.forceDelete');

});

Route::prefix('admin/medication')->name('admin.medication.')->group(function () {

    Route::get('/', [MedicationAdministrationController::class, 'index'])->name('index');

    Route::post('/administer', [MedicationAdministrationController::class, 'administer'])->name('administer');

    Route::post('/missed', [MedicationAdministrationController::class, 'markMissed'])->name('missed');

});

Route::prefix('admin/infection')->name('admin.infection.')->group(function () {

    Route::get('/', [InfectionControlController::class, 'index'])->name('index');
    Route::get('/create', [InfectionControlController::class, 'create'])->name('create');
    Route::post('/store', [InfectionControlController::class, 'store'])->name('store');

    Route::get('/edit/{id}', [InfectionControlController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [InfectionControlController::class, 'update'])->name('update');

    Route::post('/delete/{id}', [InfectionControlController::class, 'destroy'])->name('delete');

    Route::get('/trash', [InfectionControlController::class, 'trash'])->name('trash');
    Route::get('/restore/{id}', [InfectionControlController::class, 'restore'])->name('restore');
    Route::get('/force-delete/{id}', [InfectionControlController::class, 'forceDelete'])->name('forceDelete');
});

Route::prefix('admin/isolation')->name('admin.isolation.')->group(function () {

    Route::get('/', [IsolationController::class, 'index'])->name('index');
    Route::get('/create', [IsolationController::class, 'create'])->name('create');
    Route::post('/store', [IsolationController::class, 'store'])->name('store');

    Route::get('/edit/{id}', [IsolationController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [IsolationController::class, 'update'])->name('update');

    Route::post('/delete/{id}', [IsolationController::class, 'destroy'])->name('delete');

    Route::get('/trash', [IsolationController::class, 'trash'])->name('trash');
    Route::get('/restore/{id}', [IsolationController::class, 'restore'])->name('restore');
    Route::get('/force-delete/{id}', [IsolationController::class, 'forceDelete'])->name('forceDelete');
});


Route::prefix('admin/ppe')->name('admin.ppe.')->group(function () {

    Route::get('/', [PpeComplianceController::class, 'index'])->name('index');
    Route::get('/create', [PpeComplianceController::class, 'create'])->name('create');
    Route::post('/store', [PpeComplianceController::class, 'store'])->name('store');

    Route::get('/edit/{id}', [PpeComplianceController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [PpeComplianceController::class, 'update'])->name('update');

    Route::post('/delete/{id}', [PpeComplianceController::class, 'destroy'])->name('delete');

    Route::get('/trash', [PpeComplianceController::class, 'trash'])->name('trash');
    Route::get('/restore/{id}', [PpeComplianceController::class, 'restore'])->name('restore');
    Route::get('/force-delete/{id}', [PpeComplianceController::class, 'forceDelete'])->name('forceDelete');
});
/* ----------------------------------
        Pharmacy Billing 
        -----------------------------------*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('pharmacy')->name('pharmacy.')->group(function () {

        Route::get('billing', [PharmacyBillingController::class, 'index'])
            ->name('billing.index');

        Route::get('billing/create', [PharmacyBillingController::class, 'create'])
            ->name('billing.create');

        Route::post('billing/store', [PharmacyBillingController::class, 'store'])
            ->name('billing.store');

        Route::get('billing/view/{id}', [PharmacyBillingController::class, 'view'])
            ->name('billing.view');

        Route::get('/billing/{bill_id}/edit', [PharmacyBillingController::class, 'edit'])
            ->name('billing.edit');

        Route::put('/billing/{bill_id}', [PharmacyBillingController::class, 'update'])
            ->name('billing.update');

        Route::get('billing/print/{bill_id}', [PharmacyBillingController::class, 'print'])
            ->name('billing.print');
    });
});

/*
|--------------------------------------------------------------------------
| Nurse: shift Management
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('nurse-shifts')->name('nurse-shifts.')->group(function () {
        Route::get('/', [NurseShiftsController::class, 'index'])->name('index');
        Route::get('/{id}/create', [NurseShiftsController::class, 'create'])->name('create');
        Route::post('/store', [NurseShiftsController::class, 'store'])->name('store');
        Route::get('/{id}', [NurseShiftsController::class, 'show'])->name('show');
        Route::post('/handover/{id}/complete', [NurseShiftsController::class, 'markComplete'])->name('complete');
    });



    /*
    |--------------------------------------------------------------------------
    | Radiology Module
    |--------------------------------------------------------------------------
    */

    Route::prefix('radiology')->name('radiology.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [RadiologyController::class, 'dashboard'])->name('dashboard');

        // Scan Type
        Route::get('/scan-types', [ScanTypeController::class, 'index'])->name('scan-types.index');
        Route::get('/scan-types/create', [ScanTypeController::class, 'create'])->name('scan-types.create');
        Route::post('/scan-types/store', [ScanTypeController::class, 'store'])->name('scan-types.store');
        Route::get('/scan-types/edit/{id}', [ScanTypeController::class, 'edit'])->name('scan-types.edit');
        Route::post('/scan-types/update/{id}', [ScanTypeController::class, 'update'])->name('scan-types.update');
        Route::delete('/scan-types/delete/{id}', [ScanTypeController::class, 'destroy'])->name('scan-types.delete');

        // Scan Request
        Route::get('/scan-requests', [ScanRequestController::class, 'index'])->name('scan-requests.index');
        Route::get('/scan-requests/create', [ScanRequestController::class, 'create'])->name('scan-requests.create');
        Route::post('/scan-requests/store', [ScanRequestController::class, 'store'])->name('scan-requests.store');
        Route::get('/scan-requests/edit/{id}', [ScanRequestController::class, 'edit'])->name('scan-requests.edit');
        Route::post('/scan-requests/update/{id}', [ScanRequestController::class, 'update'])->name('scan-requests.update');
        Route::delete('/scan-requests/delete/{id}', [ScanRequestController::class, 'destroy'])->name('scan-requests.delete');

        // Scheduling
        Route::get('/schedule', [ScanScheduleController::class, 'index'])->name('schedule.index');
        Route::post('/schedule/store', [ScanScheduleController::class, 'store'])->name('schedule.store');
        Route::get('/schedule/edit/{id}', [ScanScheduleController::class, 'edit'])->name('schedule.edit');
        Route::post('/schedule/update/{id}', [ScanScheduleController::class, 'update'])->name('schedule.update');
        Route::delete('/schedule/delete/{id}', [ScanScheduleController::class, 'destroy'])->name('schedule.delete');
        Route::post('/schedule/quick', [ScanScheduleController::class, 'quickSchedule'])
            ->name('schedule.quick');

        // Upload
        Route::get('/upload', [ScanUploadController::class, 'index'])->name('upload.index');
        Route::post('/upload/store', [ScanUploadController::class, 'store'])->name('upload.store');
        Route::get('/upload/view/{id}', [ScanUploadController::class, 'view'])->name('upload.view');


        // Review

        Route::get('/review', [RadiologyReviewController::class, 'index'])->name('review.index');
        Route::get('/review/{id}', [RadiologyReviewController::class, 'show'])->name('review.show');
        Route::post('/review/store', [RadiologyReviewController::class, 'store'])->name('review.store');

        // Report
        Route::get('/reports', [RadiologyReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{id}', [RadiologyReportController::class, 'show'])->name('reports.show');

        // History
        Route::get('/history', [RadiologyHistoryController::class, 'index'])->name('history.index');

    });


});

Route::prefix('admin')->name('admin.')->group(function () {
    /*
   |--------------------------------------------------------------------------
   | HR Reports Module
   |--------------------------------------------------------------------------
   */
    Route::prefix('reports')->name('reports.')->group(function () {

        Route::get('/', [ReportsDashboardController::class, 'index'])->name('dashboard');

        Route::get('/staff-strength', [StaffStrengthReportController::class, 'index'])->name('staff-strength');

        Route::get('/attendance', [AttendanceReportController::class, 'index'])->name('attendance');

        Route::get('/leave', [LeaveReportController::class, 'index'])->name('leave');

        Route::get('/payroll', [PayrollReportController::class, 'index'])->name('payroll');

        Route::get('/overtime', [OvertimeReportController::class, 'index'])->name('overtime');

        Route::get('/department-salary', [DepartmentSalaryReportController::class, 'index'])->name('department-salary');

        Route::get('/payslip/{id}', [PayrollReportController::class, 'payslip'])
        ->name('payslip');

        });
});

  

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
                /*
        |--------------------------------------------------------------------------
        | Emergency Records (Patient Module)
        |--------------------------------------------------------------------------
        */

        Route::get('/patients-emergency-records', 
            [EmergencyRecordController::class, 'index']
        )->name('patients.emergency.list');

        Route::get('/patients/{id}/basic-info', 
            [PatientApiController::class, 'basicInfo']);

        Route::get('/patients/{id}/emergency-record', 
            [EmergencyRecordController::class, 'show']
        )->name('patients.emergency');

        Route::get('/patients/{id}/emergency-view', 
            [EmergencyRecordController::class, 'viewEmergency']
        )->name('patients.emergency.view');


        Route::prefix('patient-portal')->name('patient.portal.')->group(function () {

    Route::get('/', [PatientPortalController::class, 'dashboard'])->name('dashboard');

    Route::get('/appointments', [PatientPortalController::class, 'appointments'])->name('appointments');

    Route::get('/lab-reports', [PatientPortalController::class, 'labReports'])->name('lab');

    Route::get('/radiology-reports', [PatientPortalController::class, 'radiology'])->name('radiology');

    Route::get('/profile', [PatientPortalController::class, 'profile'])->name('profile');

    Route::post('/profile/update', [PatientPortalController::class, 'updateProfile'])->name('profile.update');
      
    Route::get('/billing', [PatientPortalController::class, 'billing'])
                ->name('billing');
        });

        /*
|--------------------------------------------------------------------------
| Data Usage Consent
|--------------------------------------------------------------------------
*/

Route::prefix('data-consent')
    ->name('data-consent.')
    ->group(function () {

        Route::get('/',
            [DataUsageConsentController::class, 'index'])
            ->name('index');

        Route::get('/create',
            [DataUsageConsentController::class, 'create'])
            ->name('create');

        Route::post('/store',
            [DataUsageConsentController::class, 'store'])
            ->name('store');

        Route::get('/show/{id}',
            [DataUsageConsentController::class, 'show'])
            ->name('show');

        Route::get('/history/{patient_id}',
            [DataUsageConsentController::class, 'history'])
            ->name('history');

    });

});


//insurance (Receptionist)

Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('insurance')->name('insurance.')->group(function () {

        Route::get('/', [InsuranceController::class, 'index'])->name('index');

        Route::get('/create', [InsuranceController::class, 'create'])->name('create');

        Route::post('/store', [InsuranceController::class, 'store'])->name('store');

        Route::get('/edit/{id}', [InsuranceController::class, 'edit'])->name('edit');

        Route::put('/update/{id}', [InsuranceController::class, 'update'])->name('update');

        Route::get('/show/{id}', [InsuranceController::class, 'show'])->name('show');

    });

    Route::prefix('billing')->name('billing.')->group(function () {

        Route::get('/', [BasicBillingController::class, 'index'])->name('index');
        Route::get('/create', [BasicBillingController::class, 'create'])->name('create');
        Route::post('/store', [BasicBillingController::class, 'store'])->name('store');
        Route::get('/show/{id}', [BasicBillingController::class, 'show'])->name('show');
        Route::get('/receipt/{id}', [BasicBillingController::class, 'receipt'])->name('receipt');

    });
});
 

//IPD
Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('receptionist')->name('receptionist.')->group(function () {

        // IPD Admission Routes

        Route::get('ipd', [IPDAdmissionController::class, 'index'])
            ->name('ipd.index');

        Route::get('ipd/create', [IPDAdmissionController::class, 'create'])
            ->name('ipd.create');

        Route::post('ipd/store', [IPDAdmissionController::class, 'store'])
            ->name('ipd.store');

        Route::get('ipd/show/{id}', [IPDAdmissionController::class, 'view'])
            ->name('ipd.view');

        Route::get('ipd/{id}/edit', [IPDAdmissionController::class, 'edit'])
            ->name('ipd.edit');

        Route::put('ipd/{id}', [IPDAdmissionController::class, 'update'])
            ->name('ipd.update');

        Route::get('ipd/print/{id}', [IPDAdmissionController::class, 'print'])
            ->name('ipd.print');
        
        Route::get('get-patient/{id}', [IPDAdmissionController::class, 'getPatient']);

    });

});

/*
|--------------------------------------------------------------------------
| Nurse: Lab & Reports view
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('nurse-lab-reports')->name('nurse-lab-reports.')->group(function () {
        Route::get('/', [LabReportController::class, 'index'])->name('index');
        Route::get('/{type}/{id}', [LabReportController::class, 'show'])->name('show');
    });

    Route::prefix('billing')->name('billing.')->group(function () {

        Route::get('/', [BasicBillingController::class, 'index'])->name('index');
        Route::get('/create', [BasicBillingController::class, 'create'])->name('create');
        Route::post('/store', [BasicBillingController::class, 'store'])->name('store');
        Route::get('/show/{id}', [BasicBillingController::class, 'show'])->name('show');
        Route::get('/receipt/{id}', [BasicBillingController::class, 'receipt'])->name('receipt');

    });
    
});
 

//Receptionist dashboard

Route::prefix('admin')->group(function () {
    Route::get('/receptionist-dashboard', [ReceptionistDashboardController::class, 'index'])
        ->name('receptionist.dashboard');
});

//IPD
Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('receptionist')->name('receptionist.')->group(function () {

        // ==============================
        // IPD ROUTES
        // ==============================
        Route::get('/', [IPDAdmissionController::class, 'index'])->name('ipd.index');

        Route::get('ipd/create', [IPDAdmissionController::class, 'create'])->name('ipd.create');
        Route::post('ipd/store', [IPDAdmissionController::class, 'store'])->name('ipd.store');
        Route::get('ipd/show/{id}', [IPDAdmissionController::class, 'view'])->name('ipd.view');
        Route::get('ipd/{id}/edit', [IPDAdmissionController::class, 'edit'])->name('ipd.edit');
        Route::put('ipd/{id}', [IPDAdmissionController::class, 'update'])->name('ipd.update');
        Route::get('ipd/print/{id}', [IPDAdmissionController::class, 'print'])->name('ipd.print');
        Route::get('get-patient/{id}', [IPDAdmissionController::class, 'getPatient']);

    });

});

/*
|--------------------------------------------------------------------------
| Nurse: Lab & Reports view
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('nurse-lab-reports')->name('nurse-lab-reports.')->group(function () {
        Route::get('/', [LabReportController::class, 'index'])->name('index');
        Route::get('/{type}/{id}', [LabReportController::class, 'show'])->name('show');
      //  Route::get('/department-salary', [DepartmentSalaryReportController::class, 'index'])->name('department-salary');
    });
});


// admin billing
Route::prefix('admin')->name('admin.')->group(function () {
Route::prefix('billing')->name('billing.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\BillingController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\Admin\BillingController::class, 'create'])->name('create');
    Route::post('/store', [\App\Http\Controllers\Admin\BillingController::class, 'store'])->name('store');
    Route::get('/{id}', [\App\Http\Controllers\Admin\BillingController::class, 'show'])->name('show');
    Route::get('/receipt/{id}', [\App\Http\Controllers\Admin\BillingController::class, 'receipt'])->name('receipt');
});
});
    



/*
|--------------------------------------------------------------------------
| Nurse: shift Management
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('nurse-shifts')->name('nurse-shifts.')->group(function () {
        Route::get('/', [NurseShiftsController::class, 'index'])->name('index');
        Route::get('/{id}/create', [NurseShiftsController::class, 'create'])->name('create');
        Route::post('/store', [NurseShiftsController::class, 'store'])->name('store');
        Route::get('/{id}', [NurseShiftsController::class, 'show'])->name('show');
        Route::post('/handover/{id}/complete', [NurseShiftsController::class, 'markComplete'])->name('complete');
    });
});

/*
|--------------------------------------------------------------------------
| Nurse: Lab & Reports view
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('nurse-reports')->name('nurse-reports.')->group(function () {
        Route::get('/vitals', [NurseReportController::class, 'vitals'])->name('vitals');
        Route::get('/medications', [NurseReportController::class, 'medications'])->name('medications');
        Route::get('/shift', [NurseReportController::class, 'shiftReport'])->name('shift');
        Route::get('/patient-summary', [NurseReportController::class, 'patientSummary'])->name('patient-summary');
    });
});
// Accountant Billing

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin/accountant/billing')
        ->name('admin.accountant.billing.')
        ->group(function () {

            Route::get('/', [AccountantBillingController::class, 'index'])->name('index');
            Route::get('/create', [AccountantBillingController::class, 'create'])->name('create');
            Route::post('/store', [AccountantBillingController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [AccountantBillingController::class, 'edit'])->name('edit');
            Route::get('/view/{id}', [AccountantBillingController::class, 'show'])->name('view');
            Route::put('/update/{id}', [AccountantBillingController::class, 'update'])->name('update');
        });

});
//IPD (Doctor Module)

Route::prefix('doctor/ipd')->group(function () {

    // 🔹 INDEX
    Route::get('/', [IpdController::class, 'index'])
        ->name('doctor.ipd.index');

    // 🔹 SHOW
    Route::get('/{id}', [IpdController::class, 'show'])
        ->name('doctor.ipd.show');

    // 🔹 NOTES
    Route::post('/{id}/note', [IpdController::class, 'storeNote'])
        ->name('doctor.ipd.storeNote');

    // 🔹 TREATMENT
    Route::post('/{id}/treatment', [IpdController::class, 'updateTreatment'])
        ->name('doctor.ipd.updateTreatment');

    // 🔹 PRESCRIPTION
    Route::post('/{id}/prescription', [IpdController::class, 'storePrescription'])
        ->name('doctor.ipd.storePrescription');

    // 🔹 LAB TEST
    //Route::post('/{id}/lab', [IpdController::class, 'storeLabTest'])
    //    ->name('doctor.ipd.storeLabTest');

    // 🔹 RADIOLOGY (OPTIONAL – if you add later)
    //Route::post('/{id}/scan', [IpdController::class, 'storeScan'])
    //    ->name('doctor.ipd.storeScan');

    // 🔹 DISCHARGE FORM
    Route::get('/{id}/discharge', [IpdController::class, 'dischargeForm'])
        ->name('doctor.ipd.discharge');

    // 🔹 DISCHARGE SUBMIT
    Route::post('/{id}/discharge', [IpdController::class, 'dischargeSubmit'])
        ->name('doctor.ipd.dischargeSubmit');

    Route::post('/{id}/lab-radiology', [IpdController::class, 'storeLabRadiology'])
    ->name('doctor.ipd.storeLabRadiology');
});




// Patient EMR - Discharge Summary

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

       Route::prefix('patient-portal')->name('patient.portal.')->group(function () {

    // ✅ LIST PAGE (must be first)
    Route::get('/discharge', 
        [PatientEmrController::class, 'index']
    )->name('discharge.list');

    // ✅ DETAIL PAGE
    Route::get('/discharge/{ipd_id}', 
        [PatientEmrController::class, 'dischargeSummary']
    )->name('discharge');

    // ✅ PDF DOWNLOAD
    Route::get('/discharge/{ipd_id}/pdf', 
        [PatientEmrController::class, 'download']
    )->name('discharge.pdf');

    Route::get('/doctor-notes/{ipd_id}', 
        [PatientEmrController::class, 'doctorNotes']
    )->name('doctor.notes');

});

    });
Route::middleware(['auth', 'role:doctor,admin'])->group(function () {
    /*
|--------------------------------------------------------------------------
| Surgery Consent
|--------------------------------------------------------------------------
*/

Route::get('/surgery-consent', [ConsentController::class, 'index'])
    ->name('consent.index');
Route::get('/surgery-consent/create',
    [ConsentController::class, 'create'])
    ->name('consent.create');
Route::get('/surgery-consent/create/{surgery_id}', [ConsentController::class, 'create'])
    ->name('consent.create');

Route::post('/surgery-consent/store', [ConsentController::class, 'store'])
    ->name('consent.store');

Route::get('/surgery-consent/{id}', [ConsentController::class, 'show'])
    ->name('consent.show');

Route::get('/surgery-consent/history/{patient_id}', [ConsentController::class, 'history'])
    ->name('consent.history');
});
/*
|--------------------------------------------------------------------------
| Accountant: Payment Management
|--------------------------------------------------------------------------
*/
Route::prefix('admin/accountant')->group(function () {

    Route::get('payment/{bill_id}', [AccountantPaymentController::class, 'create'])->name('admin.accountant.payment.create');
    Route::post('payment/store', [AccountantPaymentController::class, 'store'])->name('admin.accountant.payment.store');
    Route::get('/billing/{id}', [AccountantBillingController::class, 'show'])->name('admin.accountant.billing.show');
    Route::get('payment/receipt/{id}',[AccountantPaymentController::class, 'receipt'])->name('admin.accountant.payment.receipt');

});
    /*
|--------------------------------------------------------------------------
| Nurse: Discharge Preparation
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('nurse-discharge')->name('nurse-discharge.')->group(function () {
        Route::get('/', [DischargePreparationController::class, 'index'])->name('index');
        Route::get('/{ipd_id}', [DischargePreparationController::class, 'form'])->name('form');
        Route::post('/save', [DischargePreparationController::class, 'save'])->name('save');
        Route::get('/ready/{id}', [DischargePreparationController::class, 'markReady'])->name('ready');
        Route::get('/view/{ipd_id}', [DischargePreparationController::class, 'view'])->name('view');
    });
});


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        /*
|--------------------------------------------------------------------------
| Insurance Consent
|--------------------------------------------------------------------------
*/

Route::prefix('insurance-consent')
    ->name('insurance-consent.')
    ->group(function () {

        Route::get('/',
            [InsuranceConsentController::class, 'index'])
            ->name('index');

        Route::get('/create',
            [InsuranceConsentController::class, 'create'])
            ->name('create');

        Route::post('/store',
            [InsuranceConsentController::class, 'store'])
            ->name('store');

        Route::get('/show/{id}',
            [InsuranceConsentController::class, 'show'])
            ->name('show');

        Route::get('/edit/{id}',
            [InsuranceConsentController::class, 'edit'])
            ->name('edit');

        Route::put('/update/{id}',
            [InsuranceConsentController::class, 'update'])
            ->name('update');

        Route::delete('/delete/{id}',
            [InsuranceConsentController::class, 'destroy'])
            ->name('delete');
    });
    });
