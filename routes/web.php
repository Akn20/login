<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controller Imports
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminBiometricEnrollController;
use App\Http\Controllers\Admin\FinancialYearController;
use App\Http\Controllers\Admin\FinancialYearMappingController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\Pharmacy\PharmacyGrnController;
use App\Http\Controllers\Admin\Pharmacy\PrescriptionController;
use App\Http\Controllers\Admin\Pharmacy\SalesReturnController;
use App\Http\Controllers\Admin\Inventory\GrnController;
use App\Http\Controllers\Admin\Inventory\InventoryVendorController;
use App\Http\Controllers\Admin\Inventory\ItemController;
use App\Http\Controllers\Admin\Inventory\PurchaseOrderController;
use App\Http\Controllers\Admin\Inventory\ReportController;
use App\Http\Controllers\Admin\Inventory\StockAuditController;
use App\Http\Controllers\Admin\Inventory\StockTransferController;
use App\Http\Controllers\Doctor\ConsultationController;
use App\Http\Controllers\Doctor\ViewAppointmentController;
use App\Http\Controllers\Doctor\ViewPatientController;
use App\Http\Controllers\doctor\surgery\OTController;
use App\Http\Controllers\doctor\surgery\PostOperativeController;
use App\Http\Controllers\doctor\surgery\SurgeryController;
use App\Http\Controllers\HR\HRDashboardController;
use App\Http\Controllers\HR\StaffManagementController;
use App\Http\Controllers\ShiftSchedulingController;
use App\Http\Controllers\LeaveManagement\HolidayController;
use App\Http\Controllers\LeaveManagement\LeaveMappingController;
use App\Http\Controllers\LeaveManagement\LeaveApplicationController;
use App\Http\Controllers\LeaveManagement\CompOffController;
use App\Http\Controllers\LeaveManagement\LeaveAdjustmentController;
use App\Http\Controllers\LeaveManagement\LeaveApprovalController;
use App\Http\Controllers\LeaveManagement\LeaveTypeController;
use App\Http\Controllers\LeaveManagement\WeekendController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\ControlledDrugController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ExpiryController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\WorkStatusController;

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

/*
|--------------------------------------------------------------------------
| 2. Doctor / OPD Routes
|--------------------------------------------------------------------------
| Features for Doctors: Consultations, Surgery scheduling, and Patient views.
*/
Route::middleware(['auth', 'role:doctor,admin'])->prefix('doctor')->group(function () {
    Route::get('/view-patient/{id}', [ViewPatientController::class, 'viewPatientProfile'])->name('doctor.view-patient-profile');
    Route::get('/consultation-summary/{id}', [ConsultationController::class, 'summary'])->name('doctor.consultation-summary');
    Route::get('/appointments', [ViewAppointmentController::class, 'index'])->name('doctor.view-appointment');
    
    // Consultation Operations
    Route::get('/consultation/{id}', [ConsultationController::class, 'index'])->name('doctor.consultation');
    Route::get('/view-consultations', [ConsultationController::class, 'viewConsultations'])->name('doctor.view-consultations');
    Route::post('/consultation/save', [ConsultationController::class, 'store'])->name('doctor.save-consultation');
    Route::post('/consultation/store', [ConsultationController::class, 'store'])->name('doctor.consultation.store');
    Route::get('/consultation/edit/{id}', [ConsultationController::class, 'edit'])->name('doctor.edit-consultation');
    Route::post('/consultation/update/{id}', [ConsultationController::class, 'update'])->name('doctor.update-consultation');
    Route::get('/print-prescription/{id}', [ConsultationController::class, 'printPrescription'])->name('doctor.print-prescription');

    // Surgery & OT Management
    Route::get('/surgery', [SurgeryController::class, 'index'])->name('surgery.index');
    Route::get('/surgery/create', [SurgeryController::class, 'create'])->name('surgery.create');
    Route::post('/surgery/store', [SurgeryController::class, 'store'])->name('surgery.store');
    Route::get('/surgery/{id}/edit', [SurgeryController::class, 'edit'])->name('surgery.edit');
    Route::put('/surgery/{id}', [SurgeryController::class, 'update'])->name('surgery.update');
    Route::delete('/surgery/{id}', [SurgeryController::class, 'destroy'])->name('surgery.destroy');

    Route::get('/ot', [OTController::class, 'index'])->name('ot.index');
    Route::get('/ot/create', [OTController::class, 'create'])->name('ot.create');
    Route::post('/ot/store', [OTController::class, 'store'])->name('ot.store');
    Route::get('/ot/{id}/edit', [OTController::class, 'edit'])->name('ot.edit');
    Route::put('/ot/{id}', [OTController::class, 'update'])->name('ot.update');
    Route::delete('/ot/{id}', [OTController::class, 'destroy'])->name('ot.destroy');
    Route::post('/ot/{id}/toggle-status', [OTController::class, 'toggleStatus'])->name('ot.toggle-status');

    // Post-Operative Notes
    Route::get('/postoperative', [PostOperativeController::class, 'index'])->name('post.index');
    Route::get('/surgery/{id}/postoperative', [PostOperativeController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostOperativeController::class, 'store'])->name('post.store');
    Route::get('/postoperative/{id}/edit', [PostOperativeController::class, 'edit'])->name('post.edit');
    Route::put('/postoperative/{id}', [PostOperativeController::class, 'update'])->name('post.update');
    Route::delete('/postoperative/{id}', [PostOperativeController::class, 'destroy'])->name('post.destroy');

    // Pharmacy Integration for Doctors
    Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
        Route::get('/', [PrescriptionController::class, 'index'])->name('index');
        Route::get('/create', [PrescriptionController::class, 'createOffline'])->name('offline.create');
        Route::post('/store', [PrescriptionController::class, 'storeOffline'])->name('offline.store');
        Route::get('/dispense/{id}', [PrescriptionController::class, 'dispense'])->name('dispense');
        Route::post('/dispense/{id}', [PrescriptionController::class, 'storeDispense'])->name('dispense.store');
    });
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

    Route::prefix('religion')->name('religion.')->group(function() {
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

    Route::prefix('job-type')->name('job-type.')->group(function() {
        Route::get('/', [JobTypeController::class, 'index'])->name('index');
        Route::get('/create', [JobTypeController::class, 'create'])->name('create');
        Route::post('/store', [JobTypeController::class, 'store'])->name('store');
        Route::post('/update/{id}', [JobTypeController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [JobTypeController::class, 'destroy'])->name('delete');
    });

    Route::prefix('work-status')->name('work-status.')->group(function() {
        Route::get('/', [WorkStatusController::class, 'index'])->name('index');
        Route::post('/store', [WorkStatusController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [WorkStatusController::class, 'destroy'])->name('delete');
    });

    Route::prefix('designation')->name('designation.')->group(function() {
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
    Route::prefix('vendors')->name('vendors.')->group(function() {
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

    Route::prefix('pharmacy')->name('grn.')->group(function() {
        Route::get('/grn', [PharmacyGrnController::class, 'index'])->name('index');
        Route::get('/grn/create', [PharmacyGrnController::class, 'create'])->name('create');
        Route::post('/grn', [PharmacyGrnController::class, 'store'])->name('store');
        Route::get('/trash', [PharmacyGrnController::class, 'trash'])->name('trash');
        Route::get('/edit/{id}', [PharmacyGrnController::class, 'edit'])->name('edit');
        Route::delete('/delete/{id}', [PharmacyGrnController::class, 'delete'])->name('delete');
        Route::get('/grn/{id}', [PharmacyGrnController::class, 'show'])->name('show');
        Route::get('/grn/{id}/verify', [PharmacyGrnController::class, 'verify'])->name('verify');
    });

    Route::prefix('stock')->name('stock.')->group(function() {
        Route::get('/', [StockController::class, 'index'])->name('index');
        Route::get('/create', [StockController::class, 'create'])->name('create');
        Route::post('/store', [StockController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [StockController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [StockController::class, 'update'])->name('update');
        Route::get('/trash', [StockController::class, 'trash'])->name('trash');
        Route::delete('/delete/{id}', [StockController::class, 'delete'])->name('delete');
        Route::put('/toggle-status/{id}', [StockController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('/low-stock', [StockController::class, 'lowStock'])->name('low');
    });

    Route::prefix('expiry')->name('expiry.')->group(function() {
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

    Route::prefix('controlledDrug')->name('controlledDrug.')->group(function() {
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

    Route::prefix('inventory')->name('inventory.')->group(function() {
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

    Route::prefix('inventory-vendors')->name('inventory-vendors.')->group(function() {
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
    Route::prefix('modules')->name('modules.')->group(function() {
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

    Route::prefix('beds')->name('beds.')->group(function() {
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
    Route::prefix('patients')->name('patients.')->group(function() {
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

    Route::prefix('appointments')->name('appointments.')->group(function() {
        Route::get('/', [AppointmentController::class, 'index'])->name('index');
        Route::get('/create', [AppointmentController::class, 'create'])->name('create');
        Route::post('/store', [AppointmentController::class, 'store'])->name('store');
        Route::get('/trash', [AppointmentController::class, 'trash'])->name('trash');
        Route::put('/{id}/restore', [AppointmentController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [AppointmentController::class, 'forceDelete'])->name('forceDelete');
        Route::get('/get-doctors/{department_id}', [AppointmentController::class, 'getDoctors'])->name('getDoctors');
    });

    // --- Admin Pharmacy Actions ---
    Route::resource('salesReturn', SalesReturnController::class);
    Route::post('salesReturn/{id}/approve', [SalesReturnController::class, 'approve'])->name('salesReturn.approve');
    
    Route::prefix('prescriptions')->name('prescriptions.')->group(function() {
        Route::get('/', [PrescriptionController::class, 'index'])->name('index');
        Route::get('/create', [PrescriptionController::class, 'createOffline'])->name('offline.create');
        Route::post('/store' , [PrescriptionController::class, 'storeOffline'])->name('offline.store');
        Route::get('/dispense/{id}', [PrescriptionController::class, 'dispense'])->name('dispense');
        Route::get('/verify/{id}', [PrescriptionController::class, 'verify'])->name('verify');
        Route::get('/bill/{id}', [PrescriptionController::class, 'showBill'])->name('bill');
        Route::get('/{id}', [PrescriptionController::class, 'show'])->name('show');
    });

    // --- SHIFT SCHEDULING (From Team Branch) ---
    Route::prefix('shifts')->name('shifts.')->group(function () {
        Route::get('/', [ShiftSchedulingController::class, 'shiftIndex'])->name('index');
        Route::get('/create', [ShiftSchedulingController::class, 'shiftCreate'])->name('create');
        Route::post('/', [ShiftSchedulingController::class, 'shiftStore'])->name('store');
        Route::get('/{id}/edit', [ShiftSchedulingController::class, 'shiftEdit'])->name('edit');
        Route::put('/{id}', [ShiftSchedulingController::class, 'shiftUpdate'])->name('update');
        Route::delete('/{id}', [ShiftSchedulingController::class, 'shiftDelete'])->name('destroy');
        Route::patch('/{id}/toggle-status', [ShiftSchedulingController::class, 'toggleShiftStatus'])->name('toggleStatus');
        Route::get('/deleted', [ShiftSchedulingController::class, 'deletedShifts'])->name('deleted');
        Route::put('/{id}/restore', [ShiftSchedulingController::class, 'restoreShift'])->name('restore');
        Route::delete('/{id}/force-delete', [ShiftSchedulingController::class, 'forceDeleteShift'])->name('forceDelete');
        Route::get('/{id}', [ShiftSchedulingController::class, 'shiftShow'])->name('show');
    });

    Route::prefix('shift-assignments')->name('shift-assignments.')->group(function () {
        Route::get('/', [ShiftSchedulingController::class, 'assignmentIndex'])->name('index');
        Route::get('/create', [ShiftSchedulingController::class, 'assignmentCreate'])->name('create');
        Route::post('/', [ShiftSchedulingController::class, 'assignmentStore'])->name('store');
        Route::get('/{id}/edit', [ShiftSchedulingController::class, 'assignmentEdit'])->name('edit');
        Route::get('/deleted', [ShiftSchedulingController::class, 'deletedAssignments'])->name('deleted');
        Route::put('/{id}/restore', [ShiftSchedulingController::class, 'restoreAssignment'])->name('restore');
        Route::delete('/{id}/force-delete', [ShiftSchedulingController::class, 'forceDeleteAssignment'])->name('forceDelete');
        Route::get('/{id}', [ShiftSchedulingController::class, 'assignmentShow'])->name('show');
        Route::delete('/{id}', [ShiftSchedulingController::class, 'assignmentDelete'])->name('destroy');
    });

    Route::prefix('shift-rotations')->name('shift-rotations.')->group(function () {
        Route::get('/', [ShiftSchedulingController::class, 'rotationIndex'])->name('index');
        Route::get('/create', [ShiftSchedulingController::class, 'rotationCreate'])->name('create');
        Route::post('/', [ShiftSchedulingController::class, 'rotationStore'])->name('store');
        Route::get('/{id}/edit', [ShiftSchedulingController::class, 'rotationEdit'])->name('edit');
        Route::put('/{id}', [ShiftSchedulingController::class, 'rotationUpdate'])->name('update');
        Route::delete('/{id}', [ShiftSchedulingController::class, 'rotationDelete'])->name('destroy');
        Route::get('/deleted', [ShiftSchedulingController::class, 'deletedRotations'])->name('deleted');
        Route::put('/{id}/restore', [ShiftSchedulingController::class, 'restoreRotation'])->name('restore');
        Route::delete('/{id}/force-delete', [ShiftSchedulingController::class, 'forceDeleteRotation'])->name('forceDelete');
        Route::get('/{id}', [ShiftSchedulingController::class, 'rotationShow'])->name('show');
    });

    Route::prefix('weekly-offs')->name('weekly-offs.')->group(function () {
        Route::get('/', [ShiftSchedulingController::class, 'weeklyOffIndex'])->name('index');
        Route::get('/create', [ShiftSchedulingController::class, 'weeklyOffCreate'])->name('create');
        Route::post('/', [ShiftSchedulingController::class, 'weeklyOffStore'])->name('store');
        Route::get('/{id}/edit', [ShiftSchedulingController::class, 'weeklyOffEdit'])->name('edit');
        Route::put('/{id}', [ShiftSchedulingController::class, 'weeklyOffUpdate'])->name('update');
        Route::delete('/{id}', [ShiftSchedulingController::class, 'weeklyOffDelete'])->name('destroy');
        Route::get('/deleted', [ShiftSchedulingController::class, 'deletedWeeklyOffs'])->name('deleted');
        Route::put('/{id}/restore', [ShiftSchedulingController::class, 'restoreWeeklyOff'])->name('restore');
        Route::delete('/{id}/force-delete', [ShiftSchedulingController::class, 'forceDeleteWeeklyOff'])->name('forceDelete');
        Route::get('/{id}', [ShiftSchedulingController::class, 'weeklyOffShow'])->name('show');
    });

    Route::get('/shift-conflicts', [ShiftSchedulingController::class, 'conflictIndex'])->name('shift-conflicts.index');
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
    Route::resource('staff-management', StaffManagementController::class);

    // --- Weekends ---
    Route::prefix('weekends')->name('weekends.')->group(function() {
        Route::get('/deleted', [WeekendController::class, 'deleted'])->name('deleted');
        Route::post('/{id}/restore', [WeekendController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [WeekendController::class, 'forceDelete'])->name('forceDelete');
        Route::patch('/{id}/toggle-status', [WeekendController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('/', [WeekendController::class, 'index'])->name('index');
        Route::get('/create', [WeekendController::class, 'create'])->name('create');
        Route::post('/', [WeekendController::class, 'store'])->name('store');
        Route::get('/{id}', [WeekendController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [WeekendController::class, 'edit'])->name('edit');
        Route::put('/{id}', [WeekendController::class, 'update'])->name('update');
        Route::delete('/{id}', [WeekendController::class, 'destroy'])->name('delete'); 
    });

    // --- Holidays ---
    Route::prefix('holidays')->name('holidays.')->group(function() {
        Route::get('/deleted', [HolidayController::class, 'deleted'])->name('deleted');
        Route::post('/{id}/restore', [HolidayController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [HolidayController::class, 'forceDelete'])->name('forceDelete');
        Route::get('/', [HolidayController::class, 'index'])->name('index');
        Route::get('/create', [HolidayController::class, 'create'])->name('create');
        Route::get('/show', [HolidayController::class, 'show'])->name('show');
        Route::post('/', [HolidayController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [HolidayController::class, 'edit'])->name('edit');
        Route::put('/{id}', [HolidayController::class, 'update'])->name('update');
        Route::delete('/{id}', [HolidayController::class, 'destroy'])->name('delete'); 
        Route::post('/{id}/toggleStatus', [HolidayController::class, 'toggleStatus'])->name('toggleStatus');
    });

    // --- Leave Types ---
    Route::prefix('leave-type')->name('leave-type.')->group(function() {
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
    Route::prefix('leave-mappings')->name('leave-mappings.')->group(function() {
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
    Route::prefix('compoffs')->name('compoffs.')->group(function() {
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

    Route::prefix('leave-application')->name('leave-application.')->group(function() {
        Route::get('/', [LeaveApplicationController::class, 'index'])->name('index');
        Route::get('/create', [LeaveApplicationController::class, 'create'])->name('create');
        Route::post('/store', [LeaveApplicationController::class, 'store'])->name('store');
        Route::post('/withdraw/{id}', [LeaveApplicationController::class, 'withdraw'])->name('withdraw');
        Route::get('/show/{id}', [LeaveApplicationController::class, 'show'])->name('show');
    });

    Route::prefix('leave-adjustments')->name('leave-adjustments.')->group(function() {
        Route::get('/', [LeaveAdjustmentController::class, 'index'])->name('index');
        Route::post('/store', [LeaveAdjustmentController::class, 'store'])->name('store');
        Route::get('/mapping/{staff}', [LeaveAdjustmentController::class, 'getLeaveMapping'])->name('mapping');
    });

    Route::prefix('leave-approvals')->name('leave-approvals.')->group(function() {
        Route::get('/', [LeaveApprovalController::class, 'index'])->name('index');
        Route::get('/approved', [LeaveApprovalController::class, 'approvedIndex'])->name('approved');
        Route::post('/{id}/approve', [LeaveApprovalController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [LeaveApprovalController::class, 'reject'])->name('reject');
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
});