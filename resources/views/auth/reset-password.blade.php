@extends('layouts.auth')
@section('content')
<div class="row mt-5 pt-5">
    <div class="col-md-12">
        <h3>Reset your password!</h3>
        <div class="card">
            <div class="card-header bg-secondary">
                <h5 class="text-center text-light">Reset Password</h5>
            </div>
            <div class="card-body">
                <form action="{{url('reset-password')}}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{$request->token}}">

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
                                btn-warning float-start">Reset Password</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection