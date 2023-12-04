<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Session;
use App\Rules\MatchOldPassword;
use Hash;
use Validator;

class ProfileController extends Controller
{
    public function index ()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name'  =>['required'],
        //     'email'  =>['required', 'email', 'unique:users,email,'.$id],
        // ]);

        $validation = Validator::make($request->all(), [
            'name'  =>['required'],
            'email'  =>['required', 'email', 'unique:users,email,'.$id],
        ]);


        if($validation->fails()){
            return redirect()->back()->withErrors($validation);
        };

        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        Session::flash('success-message', 'Information updated successfuly');
        return redirect()->route('profileIndex');

    }


    public function passwordUpdate(Request $request, $id)
    {   
        // $request->validate([
        //     'old_password'          => ['required', new MatchOldPassword],
        //     'password'              => ['required','confirmed'],
        //     'password_confirmation'  => ['required'],
        // ]);

        $validation = Validator::make($request->all(), [
            'old_password'          => ['required', new MatchOldPassword],
            'password'              => ['required','confirmed'],
            'password_confirmation'  => ['required'],
        ]);


        if($validation->fails()){
            return redirect()->back()->withErrors($validation);
        };

        User::find($id)->update([
            'password'  => Hash::make($request->password)
        ]);

        Session::flash('success-message', 'Password updated Successfully');
        return redirect()->route('profileIndex');


    }
}
