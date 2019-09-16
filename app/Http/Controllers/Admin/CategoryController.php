<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Category;
use App\Product;
use App\ModelFilters\AdminFilters\CategoryFilter;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller {

    public function __construct() {
        $this->middleware('admin.auth')->except('logout');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $status = NULL;
        if ($request->get('status') != "") {
            $status = array($request->get('status'));
        } else {
            $status = array(1, 3);
        }
        $page = 'index-category';
        $categories_select = Category::where('status', 1)->whereNull('parent_id')->oldest('weight')->get();
        $categories = Category::whereIn('status', $status)->oldest('weight')->whereNull('parent_id')->filter($request->all(), CategoryFilter::class)->paginateFilter(10);
        $statuses = Config::get('constants.STATUS');
        return view('admin.category.index', [
            'categories' => $categories,
            'categories_select' => $categories_select,
            'statuses' => $statuses,
            'page' => $page
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $page = 'create-category';
        $categories = Category::where('status', 1)->whereNull('parent_id')->get();
        $default_weight = Category::getDefaultWeight();
        return view('admin.category.create', ['categories' => $categories, 'page' => $page, 'default_weight' => $default_weight]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request) {
        $parent_id = NULL;
        if ($request->input('parent_id') != "") {
            $parent_id = $request->input('parent_id');
        }
        $category = Category::create([
                    'name' => $request->input('name'),
                    'parent_id' => $parent_id,
                    'weight' => $request->input('weight', Category::getDefaultWeight())
        ]);
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category was successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $categories = Category::where('status', 1)->whereNull('parent_id')->get();
        $category = Category::findOrFail($id);
        $default_weight = Category::getDefaultWeight();
        return view('admin.category.edit', ['category' => $category, 'categories' => $categories, 'default_weight' => $default_weight]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id) {
        $category = Category::findOrFail($id);
        $parent_id = NULL;
        if ($request->input('parent_id') != "") {
            $parent_id = $request->input('parent_id');
        }
        $category->name = $request->input('name');
        $category->weight = $request->input('weight', Category::getDefaultWeight());
        $category->slug = NULL;
        $category->parent_id = $parent_id;
        if ($category->save()) {
            return redirect()->route('category.index')->with('success', 'Category was successfully updated!');
        } else {
            return redirect()->route('category.index')->with('error', 'Some error occour!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $category = Category::findOrFail($id);
        $category->status = 2;
        if ($category->save()) {
            $products = Product::where('category_id', $id)->get();
            foreach ($products as $product) {
                $product->product_status = 2;
                $product->save();
            }
            return redirect()->route('category.index')->with('success', 'Category was successfully removed!');
        } else {
            return redirect()->route('category.index')->with('error', 'Some error occour!');
        }
    }

    public function getActivate($id) {
        if ($id != "") {
            $category = Category::findOrFail($id);
            $category->status = 1;
            $category->save();
            $products = Product::where('category_id', $id)->get();
            if ($products->count() > 0) {
                foreach ($products as $product) {
                    $product->product_status = 1;
                    $product->save();
                }
            }
            $childCategories = Category::where('parent_id', $id)->get();
            if ($childCategories->count() > 0) {
                foreach ($childCategories as $child) {
                    $child->status = 1;
                    $child->save();
                    $chidProducts = Product::where('category_id', $child->id)->get();
                    if ($chidProducts->count() > 0) {
                        foreach ($chidProducts as $chidProduct) {
                            $chidProduct->product_status = 1;
                            $chidProduct->save();
                        }
                    }
                    $schildCategories = Category::where('parent_id', $child->id)->get();
                    if ($schildCategories->count() > 0) {
                        foreach ($schildCategories as $schild) {
                            $schild->status = 1;
                            $schild->save();
                            $schidProducts = Product::where('category_id', $schild->id)->get();
                            if ($schidProducts->count() > 0) {
                                foreach ($schidProducts as $schidProduct) {
                                    $schidProduct->product_status = 1;
                                    $schidProduct->save();
                                }
                            }
                        }
                    }
                }
            }
            return redirect()->route('category.index')->with('success', 'Category was successfully activated!');
        } else {
            return redirect()->route('category.index')->with('error', 'Some error occour!');
        }
    }

    public function getDeactivate($id) {
        if ($id != "") {
            $category = Category::findOrFail($id);
            $category->status = 3;
            $category->save();
            $products = Product::where('category_id', $id)->get();
            if ($products->count() > 0) {
                foreach ($products as $product) {
                    $product->product_status = 3;
                    $product->save();
                }
            }
            $childCategories = Category::where('parent_id', $id)->get();
            if ($childCategories->count() > 0) {
                foreach ($childCategories as $child) {
                    $child->status = 3;
                    $child->save();
                    $chidProducts = Product::where('category_id', $child->id)->get();
                    if ($chidProducts->count() > 0) {
                        foreach ($chidProducts as $chidProduct) {
                            $chidProduct->product_status = 3;
                            $chidProduct->save();
                        }
                    }
                    $schildCategories = Category::where('parent_id', $child->id)->get();
                    if ($schildCategories->count() > 0) {
                        foreach ($schildCategories as $schild) {
                            $schild->status = 3;
                            $schild->save();
                            $schidProducts = Product::where('category_id', $schild->id)->get();
                            if ($schidProducts->count() > 0) {
                                foreach ($schidProducts as $schidProduct) {
                                    $schidProduct->product_status = 3;
                                    $schidProduct->save();
                                }
                            }
                        }
                    }
                }
            }
            return redirect()->route('category.index')->with('success', 'Category was successfully deactivated!');
        } else {
            return redirect()->route('category.index')->with('error', 'Some error occour!');
        }
    }

}
