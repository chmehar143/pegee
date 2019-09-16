<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductFeedbackRequest;
use App\Product;
use App\ProductFeedback;
use App\User;
use App\ModelFilters\AdminFilters\ProductFeedbackFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ProductFeedbackController extends Controller {

    public function __construct() {
        $this->middleware('admin.auth')->except('logout');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
//        $status = 1;
//        if ($request->get('approved') != "") {
//            $status = $request->get('approved');
//        }
        $products = Product::where('product_status', 1)->get();
        $users = User::where('status', 1)->get();
        $feedbacks = ProductFeedback::filter($request->all(), ProductFeedbackFilter::class)->latest()->paginateFilter(10);
        $approved = Config::get('constants.ISAPPROVED');
        $anonymous = Config::get('constants.ISANONYMOUS');
        $rating = Config::get('constants.RATING');
        return view('admin.product-feedback.index', [
            'products' => $products,
            'users' => $users,
            'feedbacks' => $feedbacks,
            'approved' => $approved,
            'anonymous' => $anonymous,
            'rating' => $rating,
            'page' => 'index-feedback'
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $approved = Config::get('constants.ISAPPROVED');
        $anonymous = Config::get('constants.ISANONYMOUS');
        $rating = Config::get('constants.RATING');
        $feedback = ProductFeedback::findOrFail($id);
        return view('admin.product-feedback.show', [
            'feedback' => $feedback,
            'anonymous' => $anonymous,
            'rating' => $rating,
            'approved' => $approved
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $users = User::all();
        $products = Product::all();
        $feedback = ProductFeedback::findOrFail($id);
        return view('admin.product-feedback.edit', [
            'feedback' => $feedback,
            'users' => $users,
            'products' => $products

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFeedbackRequest $request, $id) {
        $feedback = ProductFeedback::findOrFail($id);
        $feedback->update($request->all());
        $feedback->is_approved = $request->get('is_approved', 2);
        $feedback->is_anonymous = $request->get('is_anonymous', 2);
        $feedback->save();

        $avg_rating = ProductFeedback::getAverageRating($feedback->product_id);
        $reviews_count = ProductFeedback::getReviewsCount($feedback->product_id);
        /**
         * Average rating and review count saved in product table
         */
        $product = Product::findOrFail($feedback->product_id);
        $product->avg_rating = round($avg_rating, 2);
        $product->reviews_count = $reviews_count;
        $product->save();

        return redirect()->route('product_feedback.show', $feedback->id)->with('success', "Product feedback updated successfully");

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

    public function getApproved($id) {
        if ($id != "") {
            $feedback = ProductFeedback::findOrFail($id);
            $feedback->is_approved = 1;
            $feedback->save();
            /**
             * Finding the average rating and reviews count
             */
            $avg_rating = ProductFeedback::getAverageRating($feedback->product_id);
            $reviews_count = ProductFeedback::getReviewsCount($feedback->product_id);
            /**
             * Average rating and review count saved in product table
             */
            $product = Product::findOrFail($feedback->product_id);
            $product->avg_rating = round($avg_rating, 2);
            $product->reviews_count = $reviews_count;
            $product->save();
            return redirect()->route('product_feedback.index')->with('success', 'Product Feedback was successfully approved!');
        } else {
            return redirect()->route('product_feedback.index')->with('error', 'Some error occour!');
        }
    }

    public function getDisapproved($id) {
        if ($id != "") {
            $feedback = ProductFeedback::findOrFail($id);
            $feedback->is_approved = 2;
            $feedback->save();
            /**
             * Finding the average rating and reviews count
             */
            $avg_rating = ProductFeedback::getAverageRating($feedback->product_id);
            $reviews_count = ProductFeedback::getReviewsCount($feedback->product_id);
            /**
             * Average rating and review count saved in product table
             */
            $product = Product::findOrFail($feedback->product_id);
            $product->avg_rating = round($avg_rating, 2);
            $product->reviews_count = $reviews_count;
            $product->save();
            return redirect()->route('product_feedback.index')->with('success', 'Product Feedback was successfully disapproved!');
        } else {
            return redirect()->route('product_feedback.index')->with('error', 'Some error occour!');
        }
    }

}
