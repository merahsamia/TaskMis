@extends('layouts.master')

@section('content')
<h1>Update Department</h1>
<form action="{{ route('departmentsUpdate', $department->id)}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="{{$department->name}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="director_id">Director</label>
                <select name="director_id" class="form-control">
                    <option value="" selected>Select a person</option>
                    <option value="1" @if ($department->director_id == '1') selected @endif>IT Director</option>
                    <option value="2" @if($department->director_id == '2') selected @endif>HR Director</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <button type="submit" class="btn btn-success float-right">Save Changes</button>
            </div>
        </div>
    </div>
</form>
@endsection