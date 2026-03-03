<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\WorkStatusController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Admin\Pharmacy\GrnController;

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

//For After  deleted records

// Religion
Route::get('religions/deleted', [ReligionController::class, 'apiDeleted']);
Route::put('religions/{id}/restore', [ReligionController::class, 'apiRestore']);
Route::delete('religions/{id}/force-delete', [ReligionController::class, 'apiForceDelete']);

// Designation
Route::get('designations/deleted', [DesignationController::class, 'apiDeleted']);
Route::put('designations/{id}/restore', [DesignationController::class, 'apiRestore']);
Route::delete('designations/{id}/force-delete', [DesignationController::class, 'apiForceDelete']);

// JobType
Route::get('job-types/deleted', [JobTypeController::class, 'apiDeleted']);
Route::put('job-types/{id}/restore', [JobTypeController::class, 'apiRestore']);
Route::delete('job-types/{id}/force-delete', [JobTypeController::class, 'apiForceDelete']);

// WorkStatus
Route::get('work-status/deleted', [WorkStatusController::class, 'apiDeleted']);
Route::put('work-status/{id}/restore', [WorkStatusController::class, 'apiRestore']);
Route::delete('work-status/{id}/force-delete', [WorkStatusController::class, 'apiForceDelete']);

// BloodGroup
Route::get('blood-groups/deleted', [BloodGroupController::class, 'apiDeleted']);
Route::put('blood-groups/{id}/restore', [BloodGroupController::class, 'apiRestore']);
Route::delete('blood-groups/{id}/force-delete', [BloodGroupController::class, 'apiForceDelete']);

// Department
Route::get('departments/deleted', [DepartmentController::class, 'apiDeleted']);
Route::put('departments/{id}/restore', [DepartmentController::class, 'apiRestore']);
Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'apiForceDelete']);



//Module Management Type Api

Route::get('/module-types', [ModuleController::class, 'getModuleTypes']);

Route::get('/test-api', function () {
    return 'API working';
});


Route::get('/dashboard', [DashboardController::class, 'index']);

//Vendor api


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

//GRN APIS

Route::prefix('pharmacy')->group(function () {

    Route::get('/grn', [GrnController::class, 'apiIndex']);      // list
    Route::post('/grn', [GrnController::class, 'apiStore']);     // create
    Route::get('/grn/{id}', [GrnController::class, 'apiShow']);  // single view
    Route::put('/grn/{id}', [GrnController::class, 'apiUpdate']); // update
    Route::delete('/grn/{id}', [GrnController::class, 'apiDestroy']); // soft delete

    Route::get('/grn-trash', [GrnController::class, 'apiTrash']); // trash list
    Route::put('/grn-trash/{id}/restore', [GrnController::class, 'apiRestore']); // restore
    Route::delete('/grn-trash/{id}/force-delete', [GrnController::class, 'apiForceDelete']); // force delete

    Route::post('/grn/{id}/verify', [GrnController::class, 'apiVerify']); // verify
    Route::post('/grn/{id}/reject', [GrnController::class, 'apiReject']); // reject
});