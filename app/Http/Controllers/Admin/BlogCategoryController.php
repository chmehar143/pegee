<?php

namespace App\Http\Controllers\Admin;

use App\BlogCategory;
use App\Http\Requests\AdminBlogCategoryRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BlogCategoryController extends Controller
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
        $this->page = 'blog-categories';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {

        $blog_categories = BlogCategory::orderBy('name', 'ASC')->get();
        return view('admin.blog_categories.index', [
            'blog_categories' => $blog_categories,
            'page' => $this->page
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function create()
    {
        $blog_category = new BlogCategory();
        $this->page = 'create-blog-category';
        return view('admin.blog_categories.create', [
            'page' => $this->page,
            'blog_category' => $blog_category
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function edit($id)
    {
        $blog_category = BlogCategory::findOrFail($id);
        return view('admin.blog_categories.edit', [
            'page' => $this->page,
            'blog_category' => $blog_category
        ]);
    }

    /**
     * @param AdminBlogPostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(AdminBlogCategoryRequest $request)
    {
        $blog_category = BlogCategory::create([
            'name' => $request->get('name'),
        ]);
        $blog_category->save();

        return redirect()->route('blog_categories.index')->with('success', 'Blog Category created successfully!');
    }

    /**
     * @param AdminBlogPostRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(AdminBlogCategoryRequest $request, $id)
    {
        $blog_category = BlogCategory::findOrFail($id);
        $blog_category->name = $request->get('name');
        $blog_category->slug = null;
        $blog_category->save();
        return redirect()->route('blog_categories.index')->with('success', 'Blog Category updated successfully!');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $blog_category = BlogCategory::findOrFail($id);
        return view('admin.blog_categories.show', [
            'page' => $this->page,
            'blog_category' => $blog_category
        ]);
    }

}
