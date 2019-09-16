<?php

namespace App\Http\Controllers;

use App\Product;
use App\MetaTag;

class ProductController extends Controller {

    /**
     * 
     * @param type $slug
     * @param Product
     */
    public function product($slug) {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('product_quantity', '>', 0)
                ->where('product_status', 1)
                ->where('out_of_stock', 1)
                ->where('category_id', $product->category_id)
                ->latest()
                ->get();
        $meta_tags = MetaTag::getMetas('product', $product->id);
        return view('product.product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'page' => 'shop',
            'title' => $product->name,
            'meta_tags' => $meta_tags
        ]);
    }

}
