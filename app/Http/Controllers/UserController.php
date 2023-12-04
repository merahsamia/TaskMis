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

    public function getUsers()
    {

        return response()->json(User::with('department')->with('roles')->with('permissions')->paginate(1));
    }

    public function updateUser(Request $request, $id)
    
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required',
        ]);

        $user = User::findOrFail($id);

        if($request->department_id != '') {
            $department_id = $request->department_id;
        } else
        {        
            $department_id = 0;
        }

        if($request->password === null) {
            $password = $user->password;

        }
        else {
            $password = Hash::make($request->password);
        }
        User::where('id',$id)->update([
            'department_id'  => $department_id,
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => $password,
        ]);

        $user->syncRoles($request->selected_roles);
        $user->syncPermissions($request->selected_permissions);

        return response()->json('success');
    }


    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->permissions()->detach();
        $user->delete();
        return response()->json('success');
    }
}
