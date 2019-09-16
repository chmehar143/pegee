<?php

namespace App\Http\Controllers\Admin;

use App\BlogCategory;
use App\Http\Requests\AdminBlogPostRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BlogPost;
use App\ModelFilters\AdminFilters\BlogPostFilter;

class BlogPostController extends Controller
{

    /**
     * @var string
     */
    protected $page;

    /**
     * BlogPostController constructor.
     */
    public function __construct()
    {
        $this->page = 'blog-posts';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {

        $blog_posts = BlogPost::orderBy('id', 'DESC')->filter($request->all(), BlogPostFilter::class)->paginateFilter(10);
        $blog_categories = BlogCategory::orderBy('name')->get();
        return view('admin.blog_posts.index', [
            'blog_posts' => $blog_posts,
            'page' => $this->page,
            'blog_categories' => $blog_categories
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function create()
    {

        $blog_post = new BlogPost();
        $blog_categories = BlogCategory::orderBy('name')->get();
        $blog_post->author_name = "Alan Rafael";
        $this->page = 'create-blog';
        return view('admin.blog_posts.create', [
            'page' => $this->page,
            'blog_post' => $blog_post,
            'blog_categories' => $blog_categories
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function edit($id)
    {
        $blog_post = BlogPost::findOrFail($id);
        $blog_categories = BlogCategory::orderBy('name')->get();
        return view('admin.blog_posts.edit', [
            'page' => $this->page,
            'blog_post' => $blog_post,
            'blog_categories' => $blog_categories
        ]);
    }

    /**
     * @param AdminBlogPostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function store(AdminBlogPostRequest $request)
    {
        $blog_post = BlogPost::create([
            'name' => $request->get('name'),
            'blog_category_id' => $request->get('blog_category_id'),
            'post_content' => $request->get('post_content'),
            'publish_date' => $request->get('publish_date'),
            'author_name' => $request->get('author_name'),
            'is_published' => $request->get('is_published') ? true : false,
        ]);
        $blog_post->save();

        return redirect()->route('blog_posts.index')->with('success', 'Blog post created successfully!');
    }

    /**
     * @param AdminBlogPostRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(AdminBlogPostRequest $request, $id)
    {
        $blog_post = BlogPost::findOrFail($id);
        $blog_post->name = $request->get('name');
        $blog_post->blog_category_id = $request->get('blog_category_id');
        $blog_post->post_content = $request->get('post_content');
        $blog_post->publish_date = $request->get('publish_date');
        $blog_post->author_name = $request->get('author_name');
        $blog_post->slug = null;
        $blog_post->is_published = $request->get('is_published') ? true : false;
        $blog_post->save();
        return redirect()->route('blog_posts.index')->with('success', 'Blog post updated successfully!');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $blog_post = BlogPost::findOrFail($id);
//        dd($blog_post->getBlogCategory);
        return view('admin.blog_posts.show', [
            'page' => $this->page,
            'blog_post' => $blog_post
        ]);
    }


}
