@extends('layouts.master')

@section('content')

<div class="card">
    <div class="card-header bg-dark">
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-light">Roles</h5>
            </div>
            <div class="col-md-6">
                @can('roles-create')

                    <a href="{{route('rolesCreate')}}" class="btn btn-success float-right">Create New Role</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body">
  

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                                @canany('roles-update', 'roles-delete')
                                <th>Actions</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$role->name}}</td>
                                <td>{{$role->display_name}}</td>
                                <td>{{$role->description}}</td>
                                @canany('roles-update', 'roles-delete')
                                    <td>
                                    @can('roles-update')

                                        <div class="float-left mx-1">
                                            <a href="{{route('rolesEdit', $role->id)}}" class='btn btn-success'>
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                    @endcan
                                    @can('roles-delete')
                                        <div class="float-left mx-1">
                                            <!-- <form action="{{route('rolesDelete', $role->id)}}" method="post">
                                                @csrf
                                                <button class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form> -->

                                            @include('management.roles.delete')
                                        </div>
                                    @endcan

                                    </td>

                                @endcanany

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                {!!$roles->Links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
@endsection