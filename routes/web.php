<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect('/login');
});

Route::controller(AuthController::class)->group(function(){

    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
    Route::post('/register', 'register')->name('register');
});

Route::middleware(['auth'])->group(function() {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    Route::controller(DepartmentController::class)->group(function() {

        Route::get('departments.index', 'index')->name('departmentsIndex')->middleware('permission:departments-read');
        Route::get('departments/create', 'create')->name('departmentsCreate')->middleware('permission:departments-create');
        Route::post('departments/store',  'store')->name('departmentsStore')->middleware('permission:departments-create');
        Route::get('departments/edit/{id}',  'edit')->name('departmentsEdit')->middleware('permission:departments-update');
        Route::post('departments/update/{id}', 'update')->name('departmentsUpdate')->middleware('permission:departments-update');
        Route::post('departments/delete/{id}', 'delete')->name('departmentsDelete')->middleware('permission:departments-delete');
    });
    
    Route::get('users.index', [UserController::class, 'index'])->name('usersIndex')->middleware('permission:users-read');

    
    Route::controller(RoleController::class)->group(function(){
        
        Route::get('roles/index', 'index')->name('rolesIndex')->middleware('permission:roles-read');
        Route::get('roles/create', 'create')->name('rolesCreate')->middleware('permission:roles-create');
        Route::post('roles/store', 'store')->name('rolesStore')->middleware('permission:roles-create');
        Route::get('roles/edit/{id}', 'edit')->name('rolesEdit')->middleware('permission:roles-update');
        Route::post('roles/update/{id}', 'update')->name('rolesUpdate')->middleware('permission:roles-update');
        Route::post('roles/delete/{id}', 'delete')->name('rolesDelete')->middleware('permission:roles-delete');
        Route::post('roles/search', 'search')->name('rolesSearch')->middleware('permission:roles-read');
    });
    
    Route::controller(PermissionController::class)->group(function(){
        
        Route::get('permissions/index', 'index')->name('permissionsIndex')->middleware('permission:permissions-read');
        Route::get('permissions/create', 'create')->name('permissionsCreate')->middleware('permission:permissions-create');
        Route::post('permissions/store', 'store')->name('permissionsStore')->middleware('permission:permissions-create');
        Route::get('permissions/edit/{id}', 'edit')->name('permissionsEdit')->middleware('permission:permissions-update');
        Route::post('permissions/update/{id}', 'update')->name('permissionsUpdate')->middleware('permission:permissions-update');
        Route::post('permissions/delete/{id}', 'delete')->name('permissionsDelete')->middleware('permission:permissions-delete');
        Route::post('permissions/search', 'search')->name('permissionsSearch')->middleware('permission:permissions-read');
    });


    Route::controller(ProfileController::class)->group(function() {
        Route::get('profile/index', 'index')->name('profileIndex')->middleware('permission:profile-read');
        Route::post('profile/update/{id}', 'update')->name('profileUpdate')->middleware('permission:profile-update');
        Route::post('profile/password/update/{id}', 'passwordUpdate')->name('profilePasswordUpdate')->middleware('permission:profile-password-update');

    });

    Route::controller(TaskController::class)->group(function() {
        Route::get('tasks/index', 'tasksIndex')->name('tasksIndex')->middleware('permission:tasks-read');

    });

    
});



