@extends('layouts.admin')

@section('content')
<div class="container">
    @if (session('success'))
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('success') }}
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('error') }}
    </div>
    @endif
    <div class="row">
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        Admin Users
                        <a class="btn btn-default" href="{{ route('admin.create') }}" data-toggle="tooltip" title="Create">
                            <i class="fa fa-plus-square fa-fw" aria-hidden="true"></i> <span>Create</span><span class=""> Admin</span>
                        </a>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if(count($admin_users) > 0)
                        <table class="table table-striped table-condensed data-table">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admin_users as $user)
                                <tr>
                                    <td><a href="mailto:{{ $user->email }}" title="email {{ $user->email }}">{{ $user->email }}</a></td>
                                    <td>{{$user->name}}</td>
                                    <td width="150">
                                        <a class="btn btn-sm btn-success btn-block" href="{{ route('admin.edit', $user->id) }}" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span>Edit</span><span class=""> Admin</span>
                                        </a>
                                        @if(Auth::guard('admin')->user()->id != $user->id)
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-danger btn-block" href="{{ route('admin.delete', $user->id) }}" data-toggle="tooltip" title="Delete">
                                            <i class="fa fa-trash fa-fw" aria-hidden="true"></i> <span class="">Delete</span><span class=""> Admin</span>
                                        </a>
                                        @else
                                        <a onclick="return false;" class="btn btn-sm btn-danger btn-block disabled" href="javascript:void(0)" data-toggle="tooltip" title="Delete">
                                            <i class="fa fa-trash fa-fw" aria-hidden="true"></i> <span class="">Delete</span><span class=""> Admin</span>
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Admin Users Found
                        </div>
                        @endif
                    </div>
                    <div class="text-center">
                        {{ $admin_users->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        Filters
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="GET" action="{{route('admins.list')}}">
                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <tr>
                                    <th>Name</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="name" type="text" class="form-control" name="name" value="{{ Input::get('name', '') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ Input::get('email', '') }}">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                            <a href="{{route('admins.list')}}" class="btn btn-default">
                                Reset Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection