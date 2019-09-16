<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductFeedback;
use App\ModelFilters\UserFilter\ProductFeedbackFilter;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFeedbackRequest;
use Illuminate\Support\Facades\Config;

class ProductFeedbackController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\ProductFeedback  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFeedbackRequest $request) {
        $productFeedback = ProductFeedback::create([
                    'rating' => $request->input('rating'),
                    'subject' => $request->input('subject'),
                    'product_feedback' => $request->input('product_feedback'),
                    'is_anonymous' => $request->input('is_anonymous', 2),
                    'user_id' => $request->input('user_id'),
                    'product_id' => $request->input('product_id'),
                    'review_date' => date('Y-m-d H:i:s')
        ]);
        $productFeedback->save();

        return redirect()->route('product', ['slug' => $request->input('product_slug')])->with('success', 'Review submitted successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Request $request) {
        $product = Product::where('slug', $slug)->first();
        if ($product){
            $feedbacks = ProductFeedback::where('is_approved', 1)
                ->where('product_id', $product->id)
                ->filter($request->all(), ProductFeedbackFilter::class)
                ->latest()
                ->paginateFilter(10);
            $ratings = Config::get('constants.RATING');
            return view('product-feedback.index', [
                'product' => $product,
                'feedbacks' => $feedbacks,
                'ratings' => $ratings,
                'title' => $product->name . ' - ' . ' Customer Reviews ',
            ]);
        }else{
            return redirect()->route('homepage')->with('error', 'The product you are looking for does not exists');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
