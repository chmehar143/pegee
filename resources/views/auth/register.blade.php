@extends('layouts.app')

@section('title', $title)

@section('content')

<div class="main-content">
    <div class="main_title chart_bg">
        <div class="container text-center">
            <h2 class="title">Sign Up</h2>
        </div>
    </div>

    <section class="divider">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-push-4">
                    <div class="widget border-1px p-30">
                        <h5 class="widget-title line-bottom line- font-20">Sign Up</h5>
                        <form id="signup_form" name="login_form" class="signup-form" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <input id="first-name" name="first_name" value="{{ old('first_name') }}" class="form-control" type="text" placeholder="First Name" required autofocus>
                                @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <input id="last-name" name="last_name" value="{{ old('last_name') }}" class="form-control" type="text" placeholder="Last Name" required autofocus>
                                @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" name="email" value="{{ old('email') }}" class="form-control" type="email"  placeholder="Enter Email" required>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" name="password" class="form-control" type="password" placeholder="Enter Password" required>

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input id="password_confirmation" name="password_confirmation" class="form-control" type="password" placeholder="Re-Enter Password" required>
                            </div>
                            <div class="form-group{{ $errors->has('profile_picture') ? ' has-error' : '' }}">
                                <input id="profile_picture" name="profile_picture" class="form-control" type="file" placeholder="">

                                @if ($errors->has('profile_picture'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('profile_picture') }}</strong>
                                </span>
                                @endif
                                <label for="dont's" class="control-label text-warning"> <small>Optional</small> </label>
                            </div>
                            <div class="form-group{{ $errors->has('phone_no') ? ' has-error' : '' }}">
                                <input id="phone-no" name="phone_no" value="{{ old('phone_no') }}" class="form-control" type="text" placeholder="Enter Phone No" >

                                @if ($errors->has('phone_no'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone_no') }}</strong>
                                </span>
                                @endif
                                <label for="dont's" class="control-label text-warning"> <small>Optional</small> </label>
                            </div>
                            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                <input id="gender-male" type="radio" class="" name="gender" value="0" {{ old('gender') == 0 ? 'checked' : '' }} />Male<br/>
                                <input id="gender-female" type="radio" class="" name="gender" value="1" {{ old('gender') == 1 ? 'checked' : '' }} />Female
                                       @if ($errors->has('gender'))
                                       <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group text-center">
                                <input name="form_botcheck" class="form-control" type="hidden" value="" />
                                <button type="submit" class="btn btn-theme-colored btn-sm mt-0 font-16" data-loading-text="Please wait...">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> 
</div>

<script type="text/javascript">
    $('#signup_form').submit(function () {
        $(this).find(':input[type=submit]').prop('disabled', true);
    });
    $(window).load(function ()
    {
        var phones = [{"mask": "(###) ###-####"}];
        $('#phone-no').inputmask({
            mask: phones,
            greedy: false,
            definitions: {'#': {validator: "[0-9]", cardinality: 1}}});
    });
</script>
@endsection
