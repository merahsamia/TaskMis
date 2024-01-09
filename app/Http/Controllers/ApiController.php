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

}
