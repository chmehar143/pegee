<?php

namespace App\Http\Controllers;

use App\StaticPage;
use App\MetaTag;

class StaticPageController extends Controller {

    /**
     * 
     * @param type $slug
     * @return StaticPage
     */
    public function staticPage($slug) {
        $staticpage = StaticPage::where('slug', $slug)
                ->where('page_status', 1)
                ->first();
        if ($staticpage) {
            $meta_tags = MetaTag::getMetas('static-page', $staticpage->id);
            return view('static-page.static-page', [
                'staticpage' => $staticpage,
                'page' => $slug,
                'title' => $staticpage->page_name,
                'meta_tags' => $meta_tags

            ]);
        } else {
            return redirect()->route('homepage');
        }
    }

}
