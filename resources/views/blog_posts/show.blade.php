@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : "Blog - " . config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')
    <!-- Section: inner-header -->
    <div class="main-content">
        <div class="main_title chart_bg">
            <div class="container text-center">
                <h2 class="title">Blog</h2>
            </div>
        </div>

        <section id="about">
            <div class="container pb-80">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="blog-post">
                                <h1 class="post-title h3-style">{{$blog_post->name}}</h1>
                                <p>by {{ $blog_post->author_name }}
                                    - {{Carbon\Carbon::parse($blog_post->publish_date)->format('M d, Y')}} @if($blog_post->getBlogCategoryName() != '')
                                    <small>in Category</small> {{$blog_post->getBlogCategoryName()}}
                                    @endif</p>
                                <hr/>
                                <div class="post-description">{!! $blog_post->post_content !!}</div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
