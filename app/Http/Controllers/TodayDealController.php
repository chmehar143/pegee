<?php

namespace App\Http\Controllers;

use App\Product;
use App\ModelFilters\UserFilter\SearchFilter;
use Illuminate\Http\Request;
use App\MetaTag;

class TodayDealController extends Controller {

    /**
     * @param Product 
     * @param Request $request
     * @return type
     */
    public function index(Request $request) {
        $products = Product::getProductWithOffers($request->all(), SearchFilter::class);
        $meta_tags = MetaTag::getMetas('deals-page', 1);
        return view('today-deal.index', [
            'products' => $products,
            'page' => 'deal',
            'title' => 'Today Deals',
            'meta_tags' => $meta_tags
        ]);
    }

}
