<?php

namespace App\Http\Controllers\Admin;

use App\Offer;
use App\Product;
use App\Category;
use App\ModelFilters\AdminFilters\OfferFilter;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Http\Requests\OfferRequest;
use App\Http\Controllers\Controller;

class OfferController extends Controller {

    public function __construct() {
        $this->middleware('admin.auth')->except('logout');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $status = NULL;
        if ($request->get('status') != "") {
            $status = array($request->get('status'));
        } else {
            $status = array(1, 3);
        }
        $page = 'index-offer';
        $products = Product::where('product_status', 1)->get();
        $offers = Offer::whereIn('offer_status', $status)->filter($request->all(), OfferFilter::class)->paginateFilter(10);
        $statuses = Config::get('constants.STATUS');
        return view('admin.offer.index', [
            'offers' => $offers,
            'products' => $products,
            'statuses' => $statuses,
            'page' => $page
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $page = 'create-offer';
        $products = Product::all();
        return view('admin.offer.create', ['products' => $products, 'page' => $page]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferRequest $request) {
        $offer_check = Offer::where('offer', $request->input('offer'))
                        ->where('quantity', $request->input('quantity'))
                        ->where('offer_status', 1)
                        ->where('product_id', $request->input('product_id'))->first();
        if (is_null($offer_check)) {
            $offer = Offer::create([
                        'offer' => $request->input('offer'),
                        'quantity' => $request->input('quantity'),
                        'product_id' => $request->input('product_id'),
            ]);
            $offer->save();
            return redirect()->route('offer.index')->with('success', 'Offer was successfully added!');
        } else {
            return redirect()->route('offer.index')->with('error', 'Offer already exists in our!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $offer = Offer::findOrFail($id);
        return view('admin.offer.show', ['offer' => $offer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $products = Product::all();
        $offer = Offer::findOrFail($id);
        return view('admin.offer.edit', ['products' => $products, 'offer' => $offer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OfferRequest $request, $id) {
        $offer = Offer::findOrFail($id);
        $offer->offer = $request->input('offer');
        $offer->quantity = $request->input('quantity');
        $offer->product_id = $request->input('product_id');
        if ($offer->save()) {
            return redirect()->route('offer.index')->with('success', 'Offer was successfully updated!');
        } else {
            return redirect()->route('offer.index')->with('error', 'Some error occour!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $offer = Offer::findOrFail($id);
        $offer->offer_status = 2;
        if ($offer->save()) {
            return redirect()->route('offer.index')->with('success', 'Offer was successfully removed!');
        } else {
            return redirect()->route('offer.index')->with('error', 'Some error occour!');
        }
    }

    public function getActivate($id) {
        if ($id != "") {
            $offer = Offer::findOrFail($id);
            $offer->offer_status = 1;
            $offer->save();
            return redirect()->route('offer.index')->with('success', 'Offer was successfully activated!');
        } else {
            return redirect()->route('offer.index')->with('error', 'Some error occour!');
        }
    }

    public function getDeactivate($id) {
        if ($id != "") {
            $offer = Offer::findOrFail($id);
            $offer->offer_status = 3;
            $offer->save();
            return redirect()->route('offer.index')->with('success', 'Offer was successfully deactivated!');
        } else {
            return redirect()->route('offer.index')->with('error', 'Some error occour!');
        }
    }

}
