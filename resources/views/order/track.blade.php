@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')
<div class="main-content">
    <div class="main_title chart_bg">
        <div class="container text-center">
            <h2 class="title">Track Order</h2>
        </div>
    </div>

    <section class="divider">
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
                <div class="col-md-4 col-md-push-4">
                    <div class="widget border-1px p-30">
                        <h5 class="widget-title line-bottom line- font-20">Track Order</h5>
                        <form id="reset-password" class="login-form" method="POST" action="{{ route('order.track') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('track') ? ' has-error' : '' }}">


                                <input id="track" placeholder="Order No" type="number" class="form-control" name="track" value="{{ old('track') }}" required autofocus>

                                @if ($errors->has('track'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('track') }}</strong>
                                </span>
                                @endif

                            </div>

                            <div class="form-group text-center">
                                <input name="form_botcheck" class="form-control" type="hidden" value="" />
                                <button type="submit" class="btn btn-theme-colored btn-sm mt-0 font-16" data-loading-text="Please wait...">
                                    Track
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
    $('#reset-password').submit(function () {
        $(this).find(':input[type=submit]').prop('disabled', true);
    });
</script>
@endsection
