@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : "Blog - " . config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')
    <!-- Section: inner-header -->
    <div class="main-content">
        <div class="main_title chart_bg">
            <div class="container text-center">
                <h1 class="title h2-style">Blog</h1>
            </div>
        </div>

        <section id="about">
            <div class="container pb-80">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-12">

                            @foreach($blog_posts as $blog_post)
                                <div class="blog-post">
                                    <h2 class="post-title h3-style"><a
                                                href="{{route('blog.show', ['slug' => $blog_post->slug])}}">{{$blog_post->name}}</a>
                                    </h2>
                                    @if($blog_post->getBlogCategoryName() != '')
                                    <p><small>in Category</small> {{$blog_post->getBlogCategoryName()}}</p>
                                    @endif
                                    <div class="post-description">{!! str_limit(strip_tags($blog_post->post_content), 500, '...') !!}</div>
                                    <p>by {{ $blog_post->author_name }}
                                        - {{Carbon\Carbon::parse($blog_post->publish_date)->format('M d, Y')}} </p>
                                    <hr/>
                                </div>

                            @endforeach
                                <div class="text-center">{{$blog_posts->links()}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
