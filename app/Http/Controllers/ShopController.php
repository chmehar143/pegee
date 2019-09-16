<?php

namespace App\Http\Controllers;

use App\Product;
use App\ModelFilters\UserFilter\SearchFilter;
use Illuminate\Http\Request;
use App\MetaTag;

class ShopController extends Controller {

    /**
     * 
     * @param Request $request
     * @param Product
     * @return type
     */
    public function shop(Request $request) {
        $products = Product::where('product_quantity', '>', 0)
                ->where('product_status', 1)
                ->filter($request->all(), SearchFilter::class)
                ->orderBy('weight')
                ->paginateFilter(6);
        $meta_tags = MetaTag::getMetas('shop-page', 1);
        return view('shop.shop', [
            'products' => $products,
            'page' => 'shop',
            'title' => 'Shop',
            'meta_tags' => $meta_tags
        ]);
    }

}
