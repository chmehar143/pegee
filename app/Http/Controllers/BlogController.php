<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\MetaTag;
use App\ModelFilters\AdminFilters\BlogPostFilter;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blog_posts = BlogPost::where('is_published', true)
            ->orderBy('publish_date', 'DESC')
            ->filter($request->all(), BlogPostFilter::class)
            ->paginateFilter(10);
        $meta_tags = MetaTag::getMetas('blog_post-page', 1);

        return view('blog_posts.index', [
            'blog_posts' => $blog_posts,
            'meta_tags' => $meta_tags,
            'page' => 'blog'
        ]);
    }

    public function show($slug)
    {

        $blog_post = BlogPost::where('slug', '=', $slug)->firstOrFail();

        $meta_tags = MetaTag::getMetas('blog_post', $blog_post->id);

        return view('blog_posts.show', [
            'blog_post' => $blog_post,
            'meta_tags' => $meta_tags,
            'page' => 'blog'
        ]);
    }
}
