@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-dark">
        <h5 class="text-light">Create New Permission</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('permissionsStore')}}" method="POST">
             @csrf
         <permissions-create></permissions-create>

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