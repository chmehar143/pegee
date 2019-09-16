@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')
<div class="main-content">
    <div class="main_title chart_bg">
        <div class="container text-center">
            <h2 class="title">Your Cart</h2>
        </div>
    </div>

    <section class="divider">
        <div class="container">
            @if (session('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('success') }}
            </div>
            @elseif(session('error'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('error') }}
            </div>
            @endif
            <div class="section-content">
                <div class="row">
                    @if (sizeof(Cart::content()) > 0)
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered tbl-shopping-cart">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Photo</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $item)
                                    <tr class="cart_item">
                                        <td class="product-remove">
                                            <a title="Remove this item" class="remove" onclick="
                                                    event.preventDefault();
                                                    document.getElementById('cart.destroy-<?php echo $item->rowId ?>').submit();" href="{{ route('cart.destroy', $item->rowId) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            <form id="cart.destroy-{{$item->rowId}}" action="{{ route('cart.destroy', $item->rowId) }}" method="POST" style="display: none;" onsubmit="return confirm('Are You Sure')">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                            </form>
                                        </td>
                                        <td class="product-thumbnail"><a href="{{ route('product', ['slug' => $products[$item->id]->slug] ) }}"><img alt="member" src="{{ asset('uploads/product/thumbnail/'. $products[$item->id]->getFeaturedImage()->product_image) }}"></a></td>
                                        <td class="product-name">
                                            <a href="{{ route('product', ['slug' => $products[$item->id]->slug] ) }}">{{ $item->name }}</a>
                                            @if(isset($products[$item->id]) && $products[$item->id]->getActiveAutoShip())
                                            <ul class="variation">
                                                <li class="variation-size"><span class="autoship_n"><img src="{{ asset('images/ship1.png') }}" width="20" alt="" class="autoship-save"> Autoship & Save </span> {{ $products[$item->id]->getActiveAutoShip()->autoship_percentage }}&#37 off at checkout</li>
                                            </ul>
                                            @endif
                                        </td>
                                        <td class="product-price">
                                            <span class="amount">&#36;{{ number_format($products[$item->id]->price, 2) }}</span>
                                            @if($products[$item->id]->getApllyingOffer($item->qty))
                                            <ul class="variation">
                                                <li class="variation-size">Saved {{ $products[$item->id]->getApllyingOffer($item->qty)->offer }}&#37</li>
                                            </ul>
                                            @endif
                                        </td>
                                        <td class="product-quantity">
                                            <div class="quantity buttons_added cart_table">
                                                <input type="button" class="minus quantityCart" value="-">
                                                <input class="input-text qty text quantityValue" type="number" name="quantity" value="{{ $item->qty }}" size="4" min="1" data-id="{{ $item->rowId }}" />
                                                <input type="button" class="plus quantityCart" value="+">
                                            </div>
                                        </td>
                                        <td class="product-subtotal"><span class="amount">&#36;{{ number_format($products[$item->id]->price * $item->qty, 2) }}</span></td>
                                    </tr>
                                    @endforeach
                                    <tr class="cart_item">
                                        <td class="text-right" colspan="6">
                                            <a class="btn btn-theme-colored btn-circled" href="{{ route('shop') }}">Continue Shopping</a>
                                            <a class="btn btn-theme-colored btn-circled" href="{{ route('empty.cart') }}" onclick="
                                                    event.preventDefault();
                                                    document.getElementById('empty-cart').submit();" >Empty Cart</a>
                                            <form id="empty-cart" action="{{ route('empty.cart') }}" method="POST" style="display: none;" onsubmit="return confirm('Are You Sure')">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 mt-30">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <h4>Cart Totals</h4>
                                <table class="table table-bordered tbl-shopping-cart">
                                    <tbody>
                                        <tr>
                                            <td>Sub-total</td>
                                            <td align='right'><span class="amount">${{ number_format(round($price, 2), 2) }}</span></td>
                                        </tr>
                                        @if($discount > 0)
                                        <tr>
                                            <td>Discounts</td>
                                            <td align='right'><span class="amount">-${{ number_format(round($discount, 2), 2) }}</span></td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Shipping FREE</td>
                                            <td align='right'><span class="amount">-${{ number_format(0, 2)}}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Grand Total</td>
                                            <td align='right'><span class="amount">${{ number_format(round(($price - $discount), 2), 2) }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="index-cart-satisfaction">
                                    <small>100% SATISFACTION & MONEY BACK GUARANTEED</small>
                                </div>
                                <div class="text-left">
                                    <a href="{{ route('checkout') }}" class="btn btn-theme-colored btn-circled">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <a href="#" class="close" data-dismiss="alert"></a> Your Cart is Empty
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    (function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.quantityValue').on('change', function () {
            var val = $(this).val();
            var id = $(this).attr('data-id');

            $.ajax({
                type: "PATCH",
                url: '{{ url("shop/cart") }}' + '/' + id,
                data: {
                    'quantity': val,
                },
                success: function (data) {
                    window.location.href = '{{ route("cart.index") }}';
                }
            });
        });

    })();

</script>
@endsection
