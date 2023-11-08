@extends('layouts.auth')
@section('content')
<div class="row mt-5 pt-5">
    <div class="col-md-12">
        <h3>Register to Task Tracking MIS</h3>
        <div class="card">
            <div class="card-header bg-secondary">
                <h5 class="text-center text-light">Register</h5>
            </div>
            <div class="card-body">
                <form action="{{route('register')}}" method="POST">
                    @csrf
                    <div class=" form-group my-1">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="email" required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group my-1">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Name" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group my-1">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{old('password')}}" placeholder="password" autocomplete="new-password" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class=" form-group my-1">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{old('password_confirmation')}}" autocomplete="new-password" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class=" row">
                        <div class="col-md-6">
                            <div class="form-group my-1">
                                <button type="submit" class=" btn 
                                btn-warning float-start">Register</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('login')}}" class="btn btn-dark float-end my-1">
                                Go to Login
                            </a>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection