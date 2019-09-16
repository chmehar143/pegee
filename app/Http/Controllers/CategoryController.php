<?php

namespace App\Http\Controllers;

use App\Category;
use App\MetaTag;
class CategoryController extends Controller {

    /**
     * 
     * @param type $slug
     * @param Category
     */
    public function category($slug) { 

        $category = Category::where('slug', $slug)->firstOrFail();  
        $meta_tags = MetaTag::getMetas('category', $category->id);
        $category = Category::find($category->id);
        $products = $category->getProduct($category);
        
        return view('category.category', [
            'category' => $category,
            'page' => $slug,
            'title' => $category->name,
            'meta_tags' => $meta_tags,
            'products' => $products,
            'isCategoryPage' => true
        ]);
    }
    

}
