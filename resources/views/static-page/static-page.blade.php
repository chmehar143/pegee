@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')
<!-- Section: inner-header -->
<div class="main-content">
    <div class="main_title chart_bg">
        <div class="container text-center">
            <h2 class="title">{{ $staticpage->page_name }}</h2>
        </div>
    </div>

    @if(isset($staticpage) && $staticpage->slug == "contact-us")
    <!-- Section: Contact -->
    <section data-bg-img="images/pattern/p4.png"> 
        <div class="container">
            <!--        <div class="section-title text-center">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <h2 class="text-uppercase font-28 mt-0"><span class="text-theme-colored">Contact</span> Us</h2>
                            </div>
                        </div>
                    </div>-->
            @if (session('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('success') }}
            </div>
            @elseif(session('error'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('error') }}
            </div>
            @endif
            <div class="section-content">          
                <div class="row">
                    <div class="col-md-12">

                        <!-- Contact Form -->
                        <form class="contact-form-transparent" id="contact-form" action="{{ route('message.contact') }}" name="contact-form" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <input type="text" placeholder="Enter Name" id="contact-form-name" name="name" value="{{ old('name') }}" required class="form-control" autofocus />
                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <input type="email" placeholder="Enter Email" id="contact-form-email" name="email" value="{{ old('email') }}" class="form-control required email" required />
                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                        <input type="text" placeholder="Enter Subject" id="contact-form-subject" name="subject" value="{{ old('subject') }}" class="form-control required" required />
                                        @if ($errors->has('subject'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('subject') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                <textarea rows="5" placeholder="Enter Message" id="contact-form-message" name="bodyMessage" class="form-control required" required>{{ old('bodyMessage') }}</textarea>
                                @if ($errors->has('message'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div id="contact-form-result" class="alert alert-success" role="alert" style="display: none;">
                            </div>
                            <div class="form-group text-center mb-0">
                                <input type="hidden" id="contact-form-botcheck" name="contact-form-botcheck" value="" class="form-control">
                                <button data-loading-text="Please wait..." class="btn btn-colored btn-rounded btn-theme-colored pl-30 pr-30" type="submit">Send your message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- Section: About/ Faq's/ Contact Us -->
    {!! html_entity_decode($staticpage->page_description) !!}
</div>
@endsection
