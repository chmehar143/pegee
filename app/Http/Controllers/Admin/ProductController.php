<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\ProductImage;
use App\Category;
use App\ModelFilters\AdminFilters\ProductFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use File;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin.auth')->except('logout');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = NULL;
        if ($request->get('status') != "") {
            $status = array($request->get('status'));
        } else {
            $status = array(1, 3);
        }
        $page = 'index-product';
        $categories = Category::where('status', 1)->whereNull('parent_id')->get();
        $products = Product::whereIn('product_status', $status)->orderBy('weight')->filter($request->all(), ProductFilter::class)->paginateFilter(10);
        $statuses = Config::get('constants.STATUS');
        $stocks = Config::get('constants.STOCKS');
        $sampleRequests = Config::get('constants.SAMPLEREQUEST');
        return view('admin.product.index', [
            'products' => $products,
            'categories' => $categories,
            'statuses' => $statuses,
            'stocks' => $stocks,
            'sampleRequests' => $sampleRequests,
            'page' => $page
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = 'create-product';
        $categories = Category::where('status', 1)->whereNull('parent_id')->get();
        return view('admin.product.create', ['categories' => $categories, 'page' => $page]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $file_name = "";
        $product_featured = "";
        if (is_null($request->input('product_featured'))) {
            $product_featured = 0;
        } else {
            $product_featured = $request->input('product_featured');
        }
        if($request->input('out_of_stock')){
            $out_of_stock = 2;
        }
        else{
            $out_of_stock = 1;
        }

        $product = Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'product_quantity' => $request->input('product_quantity'),
            'product_description' => $request->input('product_description'),
            'short_description' => $request->input('short_description'),
            'product_height' => $request->input('product_height'),
            'product_width' => $request->input('product_width'),
            'product_packaging' => $request->input('product_packaging'),
            'product_code' => $request->input('product_code'),
            'product_featured' => $product_featured,
            'category_id' => $request->input('category_id'),
            'out_of_stock' => $out_of_stock,
            'out_of_stock_message' => $request->input('out_of_stock_message'),
            'weight' => $request->input('weight', 1)
            
        ]);

        $product->save();

        foreach ($request['product_picture'] as $key => $product_picture) {
            $featured_product = 0;
            if (($key + 1) == $request->get('featured_product')) {
                $featured_product = 1;
            }
            $thumbnail_path = public_path('uploads/product/thumbnail/');
            $original_path = public_path('uploads/product/original/');
            $file_name = 'product_' . $product->slug . '_' . str_random(32) . '.' . $product_picture->extension();

            File::makeDirectory($thumbnail_path, $mode = 0755, true, true);
            File::makeDirectory($original_path, $mode = 0755, true, true);
            Image::make($product_picture)
                ->resize(750, 750, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($original_path . $file_name)
                ->resize(260, 194)
                ->save($thumbnail_path . $file_name);
            $productImage = ProductImage::create([
                'product_image' => $file_name,
                'image_featured' => $featured_product,
                'product_image_status' => 1,
                'product_id' => $product->id
            ]);
            $productImage->save();
        }

        return redirect()->route('product.index')->with('success', 'Product was successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::where('status', 1)->whereNull('parent_id')->get();
        $product = Product::findOrFail($id);
        return view('admin.product.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->name = $request->input('name');
        $product->slug = NULL;
        $product->price = $request->input('price');
        $product->product_quantity = $request->input('product_quantity');
        $product->product_description = $request->input('product_description');
        $product->short_description = $request->input('short_description');
        $product->product_height = $request->input('product_height');
        $product->product_width = $request->input('product_width');
        $product->product_packaging = $request->input('product_packaging');
        $product->product_code = $request->input('product_code');
        $product->out_of_stock_message = $request->input('out_of_stock_message');
        $product->out_of_stock = $request->input('out_of_stock');
        $product->weight = $request->input('weight', 1);
        $product_featured = "";
        if (is_null($request->input('product_featured'))) {
            $product_featured = 0;
        } else {
            $product_featured = $request->input('product_featured');
        }
        $product->product_featured = $product_featured;
        $product->category_id = $request->input('category_id');

        $product->save();

        if (!is_null($request->file('product_picture'))) {

            $productUnFeatured = ProductImage::where('product_id', $product->id)->get();

            foreach ($productUnFeatured as $unFeatured) {
                $unFeatured->image_featured = 0;
                $unFeatured->save();
            }

            foreach ($request['product_picture'] as $key => $product_picture) {
                $featured_product = 0;
                if (($key + 1) == $request->get('featured_product')) {
                    $featured_product = 1;
                }
                $thumbnail_path = public_path('uploads/product/thumbnail/');
                $original_path = public_path('uploads/product/original/');
                $file_name = 'product_' . $product->slug . '_' . str_random(32) . '.' . $product_picture->extension();

                File::makeDirectory($thumbnail_path, $mode = 0755, true, true);
                File::makeDirectory($original_path, $mode = 0755, true, true);
                Image::make($product_picture)
                    ->resize(750, 750, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($original_path . $file_name)
                    ->resize(260, 194)
                    ->save($thumbnail_path . $file_name);
                $productImage = ProductImage::create([
                    'product_image' => $file_name,
                    'image_featured' => $featured_product,
                    'product_image_status' => 1,
                    'product_id' => $product->id
                ]);
                $productImage->save();
            }
        }

        return redirect()->route('product.index')->with('success', 'Product was successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->product_status = 2;
        if ($product->save()) {
            return redirect()->route('product.index')->with('success', 'Product was successfully removed!');
        } else {
            return redirect()->route('product.index')->with('error', 'Some error occour!');
        }
    }

    public function getActivate($id)
    {
        if ($id != "") {
            $product = Product::findOrFail($id);
            $product->product_status = 1;
            $product->save();
            return redirect()->route('product.index')->with('success', 'Product was successfully activated!');
        } else {
            return redirect()->route('product.index')->with('error', 'Some error occour!');
        }
    }

    public function getDeactivate($id)
    {
        if ($id != "") {
            $product = Product::findOrFail($id);
            $product->product_status = 3;
            $product->save();
            return redirect()->route('product.index')->with('success', 'Product was successfully deactivated!');
        } else {
            return redirect()->route('product.index')->with('error', 'Some error occour!');
        }
    }

    public function setFeaturedImage(Request $request, $id)
    {
        $productImage = ProductImage::where('id', $id)->firstOrFail();
        $productUnFeatured = ProductImage::where('product_id', $productImage->product_id)->get();

        foreach ($productUnFeatured as $unFeatured) {
            $unFeatured->image_featured = 0;
            $unFeatured->save();
        }

        $productImage->image_featured = $request->featureImage;
        $productImage->save();

        if ($productImage->save()) {
            session()->flash('success', 'Featured image successfully changed!');
            return response()->json(['success' => true]);
        } else {
            session()->flash('error', 'Some error occour!');
            return response()->json(['success' => false]);
        }
    }

    public function deleteImage(Request $request, $id)
    {
        $productImage = ProductImage::findOrFail($id);
        if (file_exists(public_path('uploads/product/thumbnail/' . $productImage->product_image))) {
            unlink(public_path('uploads/product/thumbnail/' . $productImage->product_image));
        }
        if (file_exists(public_path('uploads/product/original/' . $productImage->product_image))) {
            unlink(public_path('uploads/product/original/' . $productImage->product_image));
        }


        if ($productImage->delete()) {
            $product = ProductImage::where('product_id', $request->featureImage)->first();
            if ($product->count() > 0) {
                $product->image_featured = 1;
                $product->save();
            } else {
                $product = Product::findOrFail($request->featureImage);
                $product->product_status = 3;
                $product->save();
            }
            session()->flash('success', 'Product image successfully deleted!');
            return response()->json(['success' => true]);
        } else {
            session()->flash('error', 'Some error occour!');
            return response()->json(['success' => false]);
        }
    }

    public function getInStock($id)
    {
        if ($id != "") {
            $product = Product::findOrFail($id);
            $product->out_of_stock = 1;
            $product->save();
            return redirect()->route('product.index')->with('success', 'Product status succuessfully changed to in stock!');
        } else {
            return redirect()->route('product.index')->with('error', 'Some error occour!');
        }
    }

    public function getOutOfStock($id)
    {
        if ($id != "") {
            $product = Product::findOrFail($id);
            $product->out_of_stock = 2;
            $product->save();
            return redirect()->route('product.index')->with('success', 'Product status succuessfully changed to out of stock!');
        } else {
            return redirect()->route('product.index')->with('error', 'Some error occour!');
        }
    }

    public function setActiveVideo($id)
    {
        if ($id != "") {
            $product = Product::findOrFail($id);
            $product->show_video = 1;
            $product->save();
            return redirect()->route('product.index')->with('success', 'Product video succuessfully active!');
        } else {
            return redirect()->route('product.index')->with('error', 'Some error occour!');
        }
    }

    public function setDisableVideo($id)
    {
        if ($id != "") {
            $product = Product::findOrFail($id);
            $product->show_video = 2;
            $product->save();
            return redirect()->route('product.index')->with('success', 'Product video succuessfully disable!');
        } else {
            return redirect()->route('product.index')->with('error', 'Some error occour!');
        }
    }

    public function sampleProductEnable($id)
    {
        if ($id != "") {
            $product = Product::findOrFail($id);
            $product->sample_product = 1;
            $product->save();
            return redirect()->route('product.index')->with('success', 'Product added to sample request list!');
        } else {
            return redirect()->route('product.index')->with('error', 'Some error occour!');
        }
    }

    public function sampleProductDisable($id)
    {
        if ($id != "") {
            $product = Product::findOrFail($id);
            $product->sample_product = 2;
            $product->save();
            return redirect()->route('product.index')->with('success', 'Product removed from sample request list!');
        } else {
            return redirect()->route('product.index')->with('error', 'Some error occour!');
        }
    }

}
