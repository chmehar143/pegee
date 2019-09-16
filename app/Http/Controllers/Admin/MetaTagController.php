<?php

namespace App\Http\Controllers\Admin;

use App\BlogPost;
use App\Http\Requests\MetaTagRequest;
use App\Mail\RequestSample;
use App\ModelFilters\AdminFilters\MetaTagFilter;
use App\StaticPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MetaTag;
use App\Category;
use App\Product;

class MetaTagController extends Controller
{

    /**
     * @var array
     */
    public $data;

    /**
     * MetaTagController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin.auth')->except('logout');
        $this->data = [];
        $this->data['page'] = 'meta_tags';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->data['meta_tags'] = MetaTag::filter($request->all(), MetaTagFilter::class)->paginateFilter(10);
        $this->data['categories'] = Category::where('status', 1)->get();
        $this->data['products'] = Product::where('product_status', 1)->get();
        $this->data['static_pages'] = StaticPage::where('page_status', 1)->get();
        $this->data['blog_posts'] = BlogPost::all();

        return view('admin.meta_tags.index', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $resource_id = $request->get('resource_id');
        $resource_type = $request->get('resource_type');
        $meta_tag = MetaTag::where('resource_id', $resource_id)->where('resource_type', $resource_type)->first();
        if ($meta_tag) {
            return redirect()->route('meta_tags.edit', $meta_tag->id);
        } else {
            $meta_tag = new MetaTag();
            $meta_tag->resource_id = (int)$resource_id;
            $meta_tag->resource_type = $resource_type;
        }
        $this->data['meta_tag'] = $meta_tag;
        $this->data['categories'] = Category::all();
        $this->data['products'] = Product::all();
        $this->data['static_pages'] = StaticPage::all();
        $this->data['blog_posts'] = BlogPost::all();
        return view('admin.meta_tags.create', $this->data);
    }

    /**
     * @param MetaTagRequest $request
     */
    public function store(MetaTagRequest $request)
    {
        $resource_id = $request->get('resource_id');
        $resource_type = $request->get('resource_type');
        $meta_tag = MetaTag::where('resource_id', $resource_id)->where('resource_type', $resource_type)->first();
        if (!$meta_tag) {
            $meta_tag = new MetaTag();
            $meta_tag->resource_id = $resource_id;
            $meta_tag->resource_type = $resource_type;
        }
        $meta_tag->title = $request->get('title');
        $meta_tag->description = $request->get('description');
        $meta_tag->save();
        return redirect()->route('meta_tags.show', ['id' => $meta_tag->id])->with('success', 'Meta tag saved successfully');
    }

    /**
     * @param MetaTag $metaTag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Metatag $metaTag)
    {
        $this->data['meta_tag'] = $metaTag;
        return view('admin.meta_tags.show', $this->data);
    }

    public function edit(MetaTag $metaTag)
    {
        $this->data['meta_tag'] = $metaTag;
        $this->data['categories'] = Category::where('status', 1)->get();
        $this->data['products'] = Product::where('product_status', 1)->get();
        $this->data['static_pages'] = StaticPage::where('page_status', 1)->get();
        $this->data['blog_posts'] = BlogPost::all();
        return view('admin.meta_tags.edit', $this->data);
    }

    public function update(MetaTagRequest $request)
    {
        $resource_id = $request->get('resource_id');
        $resource_type = $request->get('resource_type');
        $meta_tag = MetaTag::where('resource_id', $resource_id)->where('resource_type', $resource_type)->first();
        if ($meta_tag) {
            $meta_tag->title = $request->get('title');
            $meta_tag->description = $request->get('description');
            $meta_tag->save();
            return redirect()->route('meta_tags.show', ['id' => $meta_tag->id])->with('success', 'Meta tag saved successfully');
        } else {
            return redirect()->route('meta_tags.index')->with('error', 'Meta tag not found');
        }

    }


}
