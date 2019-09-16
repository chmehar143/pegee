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
                        Users List
                    </div>
                </div>
                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if(count($users) > 0)
                        <table class="table table-striped table-condensed data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Profile Picture</th>
                                    <th>Phone No</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$user->first_name}}</td>
                                    <td><a href="mailto:{{ $user->email }}" title="email {{ $user->email }}">{{ $user->email }}</a></td>
                                    <td><img src="{{ asset('uploads/propic/thumbnail/'. $user->profile_picture) }}" alt="{{$user->name}}"></td>
                                    <td>{{$user->phone_no}}</td>
                                    <td>
                                        @if($user->gender == 0)
                                        {{"Male"}}
                                        @elseif($user->gender == 1)
                                        {{"Female"}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->status == -1)
                                        {{"Deactivated"}}
                                        @elseif($user->status == 1)
                                        {{"Active"}}
                                        @elseif($user->status == 0)
                                        {{"Block"}}
                                        @elseif($user->status == 2)
                                        {{"Pending"}}
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-success btn-block" href="{{ route('user.edit', $user->id) }}" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span>Edit</span><span class=""> User</span>
                                        </a>
                                        @if($user->status != 1)
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-info btn-block" href="{{ route('user.activate', $user->id) }}" data-toggle="tooltip" title="Activate">
                                            <i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i> <span class="">Activate</span></span>
                                        </a>
                                        @else
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-warning btn-block" href="{{ route('user.deactivate', $user->id) }}" data-toggle="tooltip" title="Deactivate">
                                            <i class="fa fa-ban fa-fw" aria-hidden="true"></i> <span class="">Deactivate</span></span>
                                        </a>
                                        @endif
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-danger btn-block {{ $user->status == 0 ? " disabled" : "" }}" href="{{ route('user.block', $user->id) }}" data-toggle="tooltip" title="Block">
                                            <i class="fa fa-trash fa-fw" aria-hidden="true"></i> <span class="">Block</span></span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Users Found
                        </div>
                        @endif
                    </div>
                    <div class="text-center">
                        {{ $users->links() }}
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
                    <form class="form-horizontal" method="GET" action="{{route('users.list')}}">
                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <tr>
                                    <th>First Name</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="firstname" type="text" class="form-control" name="firstname" value="{{ Input::get('firstname', '') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="lastname" type="text" class="form-control" name="lastname" value="{{ Input::get('lastname', '') }}">
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
                                <tr>
                                    <th>Phone No</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="phone-no" type="text" class="form-control" name="phoneno" value="{{ Input::get('phoneno', '') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="gender" class="form-control">
                                            <option value="" >Please select</option>
                                            <option value="1" {{ Input::get('gender') == "1" ? 'selected' : '' }}>Male</option>
                                            <option value="0" {{ Input::get('gender') == "0" ? 'selected' : '' }}>Female</option>
                                        </select>    
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="status" class="form-control">
                                            <option value="" >Please select</option>
                                            <option value="1" {{ Input::get('status') == "1" ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ Input::get('status') == "0" ? 'selected' : '' }}>Block</option>
                                            <option value="-1" {{ Input::get('status') == "-1" ? 'selected' : '' }}>Deactivated</option>
                                            <option value="2" {{ Input::get('status') == "2" ? 'selected' : '' }}>Pending</option>
                                        </select>    
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                            <a href="{{route('users.list')}}" class="btn btn-default">
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