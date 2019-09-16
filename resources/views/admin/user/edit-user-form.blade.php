@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Update User</div>
                <div class="panel-body">
                    <form class="" method="POST" action="{{ route('user.update') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{$user->id}}">

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="control-label">First Name</label>

                            <input id="first-name" type="text" class="form-control" name="first_name" value="{{ $errors->has('first_name') ? old('first_name') : $user->first_name }}" required autofocus>

                            @if ($errors->has('first_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="control-label">Last Name</label>

                            <input id="last-name" type="text" class="form-control" name="last_name" value="{{ $errors->has('last_name') ? old('last_name') : $user->last_name }}" required autofocus>

                            @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>

                            <input id="email" type="email" class="form-control" name="email" value="{{ $errors->has('email') ? old('email') : $user->email }}" required autofocus>

                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('phone_no') ? ' has-error' : '' }}">
                            <label for="phone-no" class="control-label">Phone No</label>

                            <input id="phone-no" type="text" class="form-control" name="phone_no" value="{{ $errors->has('phone_no') ? old('phone_no') : $user->phone_no }}" >

                            @if ($errors->has('phone_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone_no') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="control-label">Gender</label>

                            <input id="gender-male" type="radio" class="" name="gender" value="0" {{ $user->gender == 0 ? 'checked' : '' }} />Male
                            <input id="gender-female" type="radio" class="" name="gender" value="1" {{ $user->gender == 1 ? 'checked' : '' }} />Female
                            @if ($errors->has('gender'))
                            <span class="help-block">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                                <a href="{{route('users.list')}}" class="btn btn-info">
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
<script>
    $(document).ready(function ($) {
        $("#phone-no").mask("(999) 999-9999");

        $("#phone-no").on("blur", function () {
            var last = $(this).val().substr($(this).val().indexOf("-") + 1);

            if (last.length == 3) {
                var move = $(this).val().substr($(this).val().indexOf("-") - 1, 1);
                var lastfour = move + last;
                var first = $(this).val().substr(0, 9);

                $(this).val(first + '-' + lastfour);
            }
        });
    });

</script>
@endsection