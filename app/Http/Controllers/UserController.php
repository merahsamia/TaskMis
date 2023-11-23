<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('management.users.index');
    }


    public function storeUser(Request $request)
    {
    
        $request->validate([
            'name'      => 'required',
            'email'     => 'required',
            'password'  => 'required',
        ]);

        if($request->department_id != '') {
            $department_id = $request->department_id;
        } else
        {        
            $department_id = 0;
        }

        $user = User::create([
            'department_id'  => $department_id,
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
        ]);

        $user->syncRoles($request->selected_roles);
        $user->syncPermissions($request->selected_permissions);

        return response()->json('success');

       
    }
}
