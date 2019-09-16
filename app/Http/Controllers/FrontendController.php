<?php

namespace App\Http\Controllers;

use Auth;
use \Cart as Cart;
use App\MetaTag;
use Illuminate\Support\Facades\Redirect;
use App\Product;
use App\Slider;
use App\ProductFeedback;

class FrontendController extends Controller
{

    /**
     *
     * Frontend Return
     */
    public function home()
    {
        if (Auth::user()) {
            Cart::restore(Auth::user()->id);
            Cart::store(Auth::user()->id);
            if (Cart::count() == 0) {
                Cart::restore(Auth::user()->id);
            }
        }

        if (\Session::has('previous_url')) {
            $url = \Session::get('previous_url');
            \Session::forget('previous_url');
            \Session::forget('error');
            return Redirect::to($url);
        }
        $meta_tags = MetaTag::getMetas('home-page', 1);
        $page = "home";
        $home_sliders = Slider::where('slider_image_status', 1)
            ->get();
        $homepage_product = Product::where('product_status', 1)
            ->where('product_quantity', '>', 0)
            ->where('product_featured', 1)
            ->where('out_of_stock', 1)
                    ->limit(8)
            ->orderBy('weight')
            ->get();

  /*      $testimonials = ProductFeedback::where('is_approved', 1)
            ->where('rating', '=', 5)
            ->orderBy('review_date', 'DESC')
            ->limit(9)
            ->get();
*/

        return view('frontend.frontend',
            [
                'page' => $page,
                'title' => 'Homepage',
                'meta_tags' => $meta_tags,
                'homepage_product' => $homepage_product,
                'home_sliders' => $home_sliders,
//                'testimonials' => $testimonials
            ]);
    }

    public function shopperApprovedReviews(){
        return view('frontend.shopper_approved_reviews', [
            'page' => 'reviews-list'
        ]);
    }

}
