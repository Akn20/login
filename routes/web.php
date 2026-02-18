<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Organization
|--------------------------------------------------------------------------
*/
Route::get('/', [OrganizationController::class, 'index']);

Route::get('/organization/create', [OrganizationController::class, 'create'])
    ->name('organization.create');

// Deleted list
Route::get('/organization/deleted', [OrganizationController::class, 'deleted'])
    ->name('organization.deleted');

// Restore
Route::get('/organization/restore/{id}', [OrganizationController::class, 'restore'])
    ->name('organization.restore');

// Force delete
Route::delete('/organization/force-delete/{id}', [OrganizationController::class, 'forceDelete'])
    ->name('organization.forceDelete');

// Resource route (ONLY ONCE)
Route::resource('organization', OrganizationController::class);

Route::patch(
    'organization/{id}/toggle-status',
    [OrganizationController::class, 'toggleStatus']
)->name('organization.toggleStatus');



/*
|--------------------------------------------------------------------------
| Institutions
|--------------------------------------------------------------------------
*/
Route::get('/', [InstitutionController::class, 'index']);
// Deleted list
Route::get('/institutions/deleted', [InstitutionController::class, 'deleted'])
    ->name('institutions.deleted');

// Restore
Route::get('/institutions/restore/{id}', [InstitutionController::class, 'restore'])
    ->name('institutions.restore');

// Force delete
Route::delete('/institutions/force-delete/{id}', [InstitutionController::class, 'forceDelete'])
    ->name('institutions.forceDelete');



// Resource route
Route::resource('institutions', InstitutionController::class);

Route::patch(
    'institutions/{id}/toggle-status',
    [InstitutionController::class, 'toggleStatus']
)->name('institutions.toggleStatus');



/*
|--------------------------------------------------------------------------
| Modules
|--------------------------------------------------------------------------
*/
Route::get('/', [ModuleController::class, 'index']);
Route::get('modules/deleted', [ModuleController::class, 'deleted'])
    ->name('modules.deleted');

Route::get('modules/restore/{id}', [ModuleController::class, 'restore'])
    ->name('modules.restore');

Route::delete('modules/force-delete/{id}', [ModuleController::class, 'forceDelete'])
    ->name('modules.forceDelete');
Route::resource('modules', ModuleController::class);

Route::patch(
    'modules/{id}/toggle-status',
    [ModuleController::class, 'toggleStatus']
)
    ->name('modules.toggleStatus');
