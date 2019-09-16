<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use \Cart as Cart;
use App\Category;
use App\Product;
use App\Offer;
use Validator;

class WishlistController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('wishlist.index');
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
    public function store(CartRequest $request) {
        if (trim($request->input('product_slug')) != "") {
            $product = Product::where('slug', trim($request->input('product_slug')))->firstOrFail();
            $quantity = trim($request->input('quantity'));

            $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($product) {
                return $cartItem->id === $product->id;
            });

            if (!$duplicates->isEmpty()) {
                return redirect()->route('wishlist.index')->with('error', 'Item is already in your wishlist!');
            }
            /* if ($product->getOffers->count() > 0) {
              foreach ($product->getOffers as $offers) {
              if ($offers->quantity == $quantity) {
              $cart_product = $product->price * $quantity;
              $discount = ($cart_product * $offers->offer) / 100;
              $discounted = $cart_product - $discount;
              echo $discounted;
              }
              }
              } */
            Cart::instance('wishlist')->add($product->id, $product->name, $quantity, $product->price)->associate('App\Product');
            return redirect()->route('wishlist.index')->with('success', 'Item was added to your wishlist!');
        } else {
            return redirect()->route('wishlist.index')->with('error', 'Some Error Occour!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
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
        if (trim($id) != "") {
            Cart::instance('wishlist')->remove($id);
            return redirect()->route('wishlist.index')->with('success', 'Item has been removed!');
        } else {
            return redirect()->route('wishlist.index')->with('error', 'Some Error Occour!');
        }
    }

    public function emptyWishlist() {
        Cart::instance('wishlist')->destroy();
        return redirect()->route('wishlist.index')->with('success', 'Your wishlist has been cleared!');
    }

    public function switchToCart($id) {
        if (trim($id) != "") {
            $item = Cart::instance('wishlist')->get($id);

            Cart::instance('wishlist')->remove($id);

            $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($id) {
                return $cartItem->id === $id;
            });

            if (!$duplicates->isEmpty()) {
                return redirect()->route('cart.index')->with('success', 'Item is already in your shopping cart!');
            }

            Cart::instance('default')->add($item->id, $item->name, $item->qty, $item->price)
                    ->associate('App\Product');

            return redirect()->route('wishlist.index')->with('success', 'Item has been moved to your shopping cart!');
        } else {
            return redirect()->route('wishlist.index')->with('error', 'Some Error Occour!');
        }
    }

}
