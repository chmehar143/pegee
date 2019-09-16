<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Product;
use Excel;
use App\Http\Requests\ImportCSVRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImportController extends Controller {

    /**
     * Admin authentication 
     */
    public function __construct() {
        $this->middleware('admin.auth')->except('logout');
    }

    /**
     * 
     * Show import form
     */
    public function importForm() {
        $page = "import";
        return view('admin.import.import-form', ['page' => $page]);
    }

    /**
     * 
     * @param ImportCSVRequest $request
     * @return type
     */
    public function importFile(ImportCSVRequest $request) {

        if ($request->hasFile('csv_excel')) {
            $path = $request->file('csv_excel')->getRealPath();

            $data = Excel::load($path, function($reader) {
                        
                    })->get();

            if (!empty($data) && $data->count()) {

                foreach ($data->toArray() as $key => $v) {
                    $selected_category = null;
                    if ($v['category'] != "") {
                        $category = Category::where('name', $v['category'])->where('parent_id', NULL)->first();
                        if (is_null($category)) {
                            $category = Category::create([
                                        'name' => $v['category'],
                                        'parent_id' => NULL,
                            ]);
                            $category->save();
                        }
                        $selected_category = $category;

                        if (isset($category) && $v['sub_category'] != "") {
                            $sub_category = Category::where('name', $v['sub_category'])->where('parent_id', $category->id)->first();
                            if (is_null($sub_category)) {
                                $sub_category = Category::create([
                                            'name' => $v['sub_category'],
                                            'parent_id' => $category->id,
                                ]);
                                $sub_category->save();
                            }
                            $selected_category = $sub_category;
                        }

                        if (isset($sub_category) && $v['sub_category_1'] != "") {
                            $sub_category_1 = Category::where('name', $v['sub_category_1'])->where('parent_id', $sub_category->id)->first();
                            if (is_null($sub_category_1)) {
                                $sub_category_1 = Category::create([
                                            'name' => $v['sub_category_1'],
                                            'parent_id' => $sub_category->id,
                                ]);
                                $sub_category_1->save();
                            }
                            $selected_category = $sub_category_1;
                        }

                        if (isset($sub_category_1) && $v['sub_category_2'] != "") {
                            $sub_category_2 = Category::where('name', $v['sub_category_2'])->where('parent_id', $sub_category_1->id)->first();
                            if (is_null($sub_category_2)) {
                                $sub_category_2 = Category::create([
                                            'name' => $v['sub_category_2'],
                                            'parent_id' => $sub_category_1->id,
                                ]);
                                $sub_category_2->save();
                            }
                            $selected_category = $sub_category_2;
                        }

                        if (isset($sub_category_2) && $v['sub_category_3'] != "") {
                            $sub_category_3 = Category::where('name', $v['sub_category_3'])->where('parent_id', $sub_category_2->id)->first();
                            if (is_null($sub_category_3)) {
                                $sub_category_3 = Category::create([
                                            'name' => $v['sub_category_3'],
                                            'parent_id' => $sub_category_2->id,
                                ]);
                                $sub_category_3->save();
                            }
                            $selected_category = $sub_category_3;
                        }
                    } else {
                        $category = Category::where('status', 1)->first();
                        if (!$category) {
                            $category = Category::create([
                                        'name' => 'Default Category',
                                        'parent_id' => NULL
                            ]);
                            $category->save();
                        }
                        $selected_category = $category;
                    }

                    if ($v['product_name'] != "") {
                        $product = Product::where('product_code', $v['product_code'])->first();
                        if (is_null($product)) {
                            $product = Product::create([
                                        'name' => $v['product_name'],
                                        'price' => $v['price'],
                                        'product_quantity' => $v['product_quantity'],
                                        'product_description' => $v['product_description'],
                                        'product_height' => $v['product_height'],
                                        'product_width' => $v['product_width'],
                                        'product_packaging' => $v['product_packaging'],
                                        'product_code' => $v['product_code'],
                                        'category_id' => $selected_category,
                            ]);
                            $product->save();
                        }
                    }
                }
                return redirect()->route('admin.home.home')->with('success', 'File imported successfully!');
            }
        }
        return redirect()->route('admin.home.home')->with('error', 'Some error occour!');
    }

}
