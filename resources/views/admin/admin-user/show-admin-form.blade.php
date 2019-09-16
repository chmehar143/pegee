@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create New Admin</div>
                <div class="panel-body">
                    <form class="" method="POST" action="{{ route('admin.save') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">Name</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>

                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                            <label for="confirm_password" class="control-label">Confirm Password</label>

                            <input id="confirm_password" type="password" class="form-control" name="confirm_password" required>

                            @if ($errors->has('confirm_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('confirm_password') }}</strong>
                            </span>
                            @endif

                        </div>

                        <!--                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                                    <label for="role" class="col-md-4 control-label">Role</label>
                        
                                                    <div class="col-md-6">
                                                        <select class="form-control">
                                                            <option id="" value="0">Select Role</option>
                                                            <option id="" value="1">Super Admin</option>
                                                            <option id="" value="2">Admin</option>
                                                            <option id="" value="3">Asst Admin</option>
                                                        </select>
                        
                                                        @if ($errors->has('role'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('role') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>-->

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                                <a href="{{route('admins.list')}}" class="btn btn-info">
                                    Back
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection