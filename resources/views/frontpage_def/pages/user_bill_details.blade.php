@extends('frontpage_master_def')

@section('title', '| Bill Details')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ route('homepage') }}">Home</a></li>
                <li>Billing</li>
                <li class="active">Bill Details</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!--Checkout Area Strat-->
<div class="checkout-area pt-60 pb-30">
    <div class="container">
        <div class="row">
            @include('frontpage_def.layouts.user_sidenav')
            <div class="col-lg-8 col-md-9 col-12 user-account-right">
                <span class="page-title bg-warning text-white">Bill Details</span>
                <table class="table table-borderless table-user-order">
                    <tbody>
                        @if (!empty($bill))
                            <tr>
                                <th scope="row" class="w-25">Products</th>
                                <td>
                                    <ul>
                                    @foreach ($bill->orderedProducts as $product)
                                        <li>
                                            <span class="product-thumb d-inline-block mr-10">
                                                <a href="{{ route('product.details', $product->id) }}" target="_blank">
                                                    <img src="{{ $product->getThumb() }}" alt="" class="img img-thumbnail">
                                                </a>
                                            </span>
                                            <a href="{{ route('product.details', $product->id) }}" target="_blank"><strong>{{ $product->name }}</strong></a>
                                                --> {{ vnd_format($product->pivot->price, 1, 1100) }} VNĐ &times; {{ $product->pivot->quantity_ordered }}
                                        </li>
                                    @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Check Number</th>
                                <td>{{ $bill->bill->check_number }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Created at</th>
                                <td>{{ $bill->created_at }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Completed at</th>
                                <td>{{ $bill->log->count() ? $bill->log->last()->updated_at : '' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Notes</th>
                                <td>{{ $bill->comment ?? '' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Shipping Address</th>
                                <td>{{ $bill->ship_to_address ?? '' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Subtotal</th>
                                <td>{{ vnd_format($bill->getAmount()) }} VNĐ</td>
                            </tr>
                            <tr>
                                <th scope="row">Total (VAT required)</th>
                                <td>{{ vnd_format($bill->getAmount(true)) }} VNĐ</td>
                            </tr>
                            <tr>
                                <th colspan=2>
                                    <a href="javascript: history.back()" class="btn-cart">&times; Cancel</a>
                                </th>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Checkout Area End-->
@endsection
