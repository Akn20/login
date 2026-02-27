<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WorkStatusController;
use Illuminate\Support\Facades\Route;

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

/* Module */

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