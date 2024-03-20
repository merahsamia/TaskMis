<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class ApiController extends Controller
{

    public function getAllDepartments()
    {
        return response()->json(Department::all());
    }

    public function getAllRoles()
    {
        return response()->json(Role::all());
    }

    public function getAllPermissions()
    {
        return response()->json(Permission::all());
    }

    public function getAllUsers()
    {

        return response()->json(User::with('department')->with('roles')->with('permissions')->get());
    }

    public function getUnreadNotifications()
    {
        return response()->json(auth('api')->user()->unreadNotifications);
    }

    public function markNotificationAsRead()
    {
        $id = \Request::get('unread');

        if($id != 0) {  

            auth('api')->user()->notifications->where('id', $id)->markAsRead();
        } else {

            auth('api')->user()->notifications->markAsRead();

        };

        return response()->json('success');
    }
    

    public function getAllNotifications()
    {
        return response()->json(auth('api')->user()->notifications);
    }


    public function clearAllNotifications()
    {
        auth('api')->user()->notifications()->delete();
        return response()->json('success');

    }
    
}
