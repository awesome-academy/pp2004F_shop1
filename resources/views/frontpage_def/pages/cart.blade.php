@extends('frontpage_master_def')

@section('title', '| Cart')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!--Shopping Cart Area Strat-->
<div class="Shopping-cart-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="#">
                    <div class="table-content table-responsive">
                        <table class="table table-cart">
                            <thead>
                                <tr>
                                    <th class="li-product-remove">remove</th>
                                    <th class="li-product-thumbnail">images</th>
                                    <th class="cart-product-name">Product</th>
                                    <th class="li-product-price">Unit Price</th>
                                    <th class="li-product-quantity">Quantity</th>
                                    <th class="li-product-subtotal">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($products))
                                    @foreach($products as $product)
                                    @php
                                        $quantity = ($product->cartQuantity() ? $product->cartQuantity() : 1);
                                        $quantity = (int)$quantity;
                                    @endphp
                                        <tr class="cart-item" data-request="{{ $product->id }}" data-quantity="{{ $quantity }}">
                                            <td class="li-product-remove"><a href="#"><i class="fa fa-times"></i></a></td>
                                            <td class="li-product-thumbnail">
                                                <a href="#"><img src="{{ $product->getThumb() }}" alt="{{ $product->name }}" class="img"></a>
                                            </td>
                                            <td class="li-product-name"><a href="#">{{ $product->name }}</a></td>
                                            <td class="li-product-price">
                                                <span class="amount">{{ $product->vnd_format() ?? 0 }}</span>
                                                <input type="hidden" name="" class="amount" value="{{ $product->current_price }}">
                                            </td>
                                            <td class="quantity">
                                                <label>Quantity</label>
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" value="{{ $quantity }}" type="text">
                                                    <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                                    <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal"><span class="amount">{{ vnd_format($product->current_price, $quantity) ?? 0 }}</span></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="coupon-all">
                                <div class="coupon2">
                                    <button id="empty-cart" class="btn-cart">Reset Cart</button>
                                    <button class="btn-cart btn-update-cart">Update Cart</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 ml-auto">
                            <div class="cart-page-total">
                                <h2>Cart totals</h2>
                                <ul>
                                    <li class="cart-subtotal">Subtotal 
                                        <span style="margin-left: 8px">VNĐ</span>
                                        <span>{{ isset($product) ? vnd_format($cart['total']) : 0 }}</span>
                                    </li>
                                    <li class="cart-total">Total (10% VAT required)
                                        <span style="margin-left: 8px">VNĐ</span>
                                        <span>{{ isset($product) ? vnd_format($cart['total'], 1, 1100) : 0 }}</span>
                                    </li>
                                </ul>
                                <a href="{{ url('checkout') }}">Proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
