@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-dark">
        <h5 class="text-light">Create New Role</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('rolesStore')}}" method="POST">
             @csrf
           <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="display_name">Display Name</label>
                        <input type="text" class="form-control" name="display_name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" name="description">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection