<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;

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
        Route::get('getAllUsers', 'getAllUsers')->middleware('permission:tasks-create');

        Route::get('getUnreadNotifications', 'getUnreadNotifications');
        Route::get('markNotificationAsRead', 'markNotificationAsRead');
        Route::get('getAllNotifications', 'getAllNotifications');
        Route::get('clearAllNotifications', 'clearAllNotifications');

        Route::get('getBarChartData/{year}', 'getBarChartData');
        Route::post('exportExcel', 'exportExcel');
    });
    
    
    Route::controller(UserController::class)->group(function(){
        
        Route::get('searchUser', 'searchUser')->middleware('permission:users-read');
        Route::post('storeUser', 'storeUser')->middleware('permission:users-create');
        Route::get('getUsers', 'getUsers')->middleware('permission:users-read');
        Route::post('updateUser/{id}', 'updateUser')->middleware('permission:users-update');
        Route::post('deleteUser/{id}', 'deleteUser')->middleware('permission:users-delete');

    });

    Route::controller(TaskController::class)->group(function() {

        Route::post('storeTask', 'storeTask')->middleware('permission:tasks-create');
        Route::get('getTasks', 'getTasks')->middleware('permission:tasks-read');
        Route::post('updateTask/{id}', 'updateTask')->middleware('permission:tasks-update');
        Route::post('deleteTask/{id}', 'deleteTask')->middleware('permission:tasks-delete');
        
        Route::get('getInboxTasks', 'getInboxTasks')->middleware('permission:inbox-read');
        Route::post('storePerformTask', 'storePerformTask')->middleware('permission:inbox-update');
        Route::get('getCompletedTasks', 'getCompletedTasks')->middleware('permission:completed-read');

        Route::get('searchTask',  'searchTask')->middleware('permission:tasks-read');
        Route::get('searchInbox',  'searchInbox')->middleware('permission:inbox-read');
        Route::get('searchCompleted',  'searchCompleted')->middleware('permission:completed-read');


    });


    Route::controller(CommentController::class)->group(function() {

        Route::post('storeComment', 'storeComment')->middleware('permission:comments-create');
        Route::get('getComments/{id}', 'getComments')->middleware('permission:comments-read');
        Route::post('updateComment/{id}', 'updateComment')->middleware('permission:comments-update');
        Route::post('deleteComment/{id}', 'deleteComment')->middleware('permission:comments-delete');
        


    });
    

});

Route::post('storeContact', [ApiController::class, 'storeContact']);


