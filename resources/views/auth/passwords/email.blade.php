@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="main-content">
    <div class="main_title chart_bg">
        <div class="container text-center">
            <h2 class="title">Reset Password</h2>
        </div>
    </div>


    <section class="divider">
        <div class="container">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="row">
                <div class="col-md-4 col-md-push-4">
                    <div class="widget border-1px p-30">
                        <h5 class="widget-title line-bottom line- font-20">Reset Password</h5>

                        <form id="send-password-req" class="login-form" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input placeholder="Enter Email" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group text-center">
                                <input name="form_botcheck" class="form-control" type="hidden" value="" />
                                <button type="submit" class="btn btn-theme-colored btn-sm mt-0 font-16" data-loading-text="Please wait...">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $('#send-password-req').submit(function () {
        $(this).find(':input[type=submit]').prop('disabled', true);
    });
</script>
@endsection
