@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-dark">
                <h5 class="text-light">Update Profile</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('profileUpdate', $user->id) }}" method="post">
                    @csrf
        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{$user->email}}">
                                </div>
                            </div>
        
                        </div>
        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>


        <div class="card mt-2">
            <div class="card-header bg-dark">
                <h5 class="text-light">Update Password</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('profilePasswordUpdate', $user->id) }}" method="post">
                    @csrf
        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="old_password">Old Password</label>
                                    <input type="password" class="form-control" name="old_password">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
        
                        </div>
        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Change Password</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
@endsection