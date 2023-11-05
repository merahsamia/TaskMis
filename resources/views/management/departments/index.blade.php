@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6">
        <h1>Departments</h1>
    </div>
    <div class="col-md-6">
        <a href="{{route('departmentsCreate')}}" class="btn btn-dark mt-2 float-right">Create New Department</a>
    </div>
</div>
@endsection