<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController;
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
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/', function() {
    return redirect('/login');
});
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');



Route::get('departments.index', [DepartmentController::class, 'index'])->name('departmentsIndex');
Route::get('departments/create', [DepartmentController::class, 'create'])->name('departmentsCreate');
Route::post('departments/store', [DepartmentController::class, 'store'])->name('departmentsStore');
Route::get('departments/edit/{id}', [DepartmentController::class, 'edit'])->name('departmentsEdit');
Route::post('departments/update/{id}', [DepartmentController::class, 'update'])->name('departmentsUpdate');
Route::post('departments/delete/{id}', [DepartmentController::class, 'delete'])->name('departmentsDelete');

Route::get('users.index', [UserController::class, 'index'])->name('usersIndex');

Route::get('roles/index', [RoleController::class, 'index'])->name('rolesIndex');
Route::get('roles/create', [RoleController::class, 'create'])->name('rolesCreate');
Route::post('roles/store', [RoleController::class, 'store'])->name('rolesStore');
Route::get('roles/edit/{id}', [RoleController::class, 'edit'])->name('rolesEdit');
Route::post('roles/update/{id}', [RoleController::class, 'update'])->name('rolesUpdate');
Route::post('roles/delete/{id}', [RoleController::class, 'delete'])->name('rolesDelete');


Route::get('permissions/index', [PermissionController::class, 'index'])->name('permissionsIndex');
Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissionsCreate');
Route::post('permissions/store', [PermissionController::class, 'store'])->name('permissionsStore');
Route::get('permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permissionsEdit');
Route::post('permissions/update/{id}', [PermissionController::class, 'update'])->name('permissionsUpdate');
Route::post('permissions/delete/{id}', [PermissionController::class, 'delete'])->name('permissionsDelete');
