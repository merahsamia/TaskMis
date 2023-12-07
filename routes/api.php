<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['forcetojson', 'auth:api'])->group(function(){

    Route::controller(DepartmentController::class)->group(function(){

        Route::post('storeDepartment',  'storeDepartment')->middleware('permission:departments-create');
        Route::get('getDepartments',  'getDepartments')->middleware('permission:departments-read');
        Route::get('searchDepartment',  'searchDepartment')->middleware('permission:departments-read');
        Route::post('updateDepartment/{id}',  'updateDepartment')->middleware('permission:departments-update');
        Route::post('deleteDepartment/{id}',  'deleteDepartment')->middleware('permission:departments-delete');
    });


    Route::controller(ApiController::class)->group(function(){

        Route::get('getAllDepartments', 'getAllDepartments')->middleware('permission:departments-read');
        Route::get('getAllRoles', 'getAllRoles')->middleware('permission:roles-read');
        Route::get('getAllPermissions', 'getAllPermissions')->middleware('permission:permissions-read');
    });
    
    
    Route::controller(UserController::class)->group(function(){
        
        Route::get('searchUser', 'searchUser')->middleware('permission:users-read');
        Route::post('storeUser', 'storeUser')->middleware('permission:users-create');
        Route::get('getUsers', 'getUsers')->middleware('permission:users-read');
        Route::post('updateUser/{id}', 'updateUser')->middleware('permission:users-update');
        Route::post('deleteUser/{id}', 'deleteUser')->middleware('permission:users-delete');

    });
    
});


