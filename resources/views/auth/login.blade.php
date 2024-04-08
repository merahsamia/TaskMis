@extends('layouts.auth')
@section('content')
<div class="auth-card">
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">Login to Task Tracking MIS</h3>
            <div class="card">
                <div class="card-header bg-secondary">
                    <h5 class="text-center text-light">Login</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('login')}}" method="POST">
                        @csrf
                        <div class=" form-group my-1">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="email" required autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class=" form-group my-1">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{old('password')}}" placeholder="password" autocomplete="new-password" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group my-1">
                                    <a href="{{route('password.request')}}">
                                        Forgot Password
                                    </a>
                                </div>
                            </div>
                        </div> -->

                        <div class="d-flex justify-content-between mt-3">
                            <a class="text-secondary" href="{{route('password.request')}}">Forgot Password</a>

                            <contact-component></contact-component>
                        </div>

                        <div class="d-flex justify-content-between mt-3">

                            <button type="submit" class=" btn 
                            btn-warning">Login</button>

                            <a href="{{ route('register')}}" class="btn btn-dark">
                                Go to Register
                            </a>
                        </div>
                     
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection