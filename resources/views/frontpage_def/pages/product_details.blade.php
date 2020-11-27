@extends('frontpage_master_def')

@section('title', '| Product Details')

@section('content')
<div class="content-wraper">
    <div class="container">
        <div class="row single-product-area">
            <div class="col-lg-5 col-md-6 pt-50">
                <!-- Product Details Left -->
                <div class="product-details-left">
                    @if (count($product->images) > 1)
                    <div class="product-details-images slider-navigation-1">
                        @foreach ($product->images as $img)
                        <div class="lg-image">
                            <a class="popup-img venobox vbox-item" href="{{ $img->image }}" data-gall="myGallery">
                                <img src="{{ $img->image }}" alt="product image">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div class="product-details-thumbs slider-thumbs-1">
                        @foreach ($product->images as $img)
                        <div class="sm-image"><img src="{{ $product->getThumb($img->image) }}" alt="{{ $product->name }}"></div>
                        @endforeach
                    </div>
                    @endif
                    @if (count($product->images) == 1)
                        <div class="lg-image">
                            <a class="popup-img venobox vbox-item" href="{{ $product->images->first()->image }}" data-gall="myGallery">
                                <img src="{{ $product->images->first()->image }}" alt="product image" class="img-responsive">
                            </a>
                        </div>
                    @endif
                </div>
                <!--// Product Details Left -->
            </div>

            <div class="col-lg-7 col-md-6">
                <div class="product-details-view-content pt-60">
                    <div class="product-info">
                        <h2>{{ $product->name }}</h2>
                        <span class="product-details-ref">Product by: 
                            <strong style="font-size: 1.2em"><a href="{{ route('brand', $product->brand_id) }}">{{ $product->brand->name }}</a></strong>
                        </span>
                        <div class="rating-box pt-20">
                            <ul class="rating rating-with-review-item">
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                <li class="review-item"><a href="#">Read Review</a></li>
                                <li class="review-item"><a href="#">Write Review</a></li>
                            </ul>
                        </div>
                        <div class="price-box pt-20">
                            <span class="new-price new-price-2">{{ $product->vnd_format() }} VNĐ</span>
                        </div>
                        <div class="product-desc">
                            <p>
                                <span>{{ $product->excerpt }}
                                </span>
                            </p>
                        </div>
                        <div class="single-add-to-cart">
                            <form action="#" class="cart-quantity">
                                <div class="quantity">
                                    <label>Quantity</label>
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" value="1" type="text">
                                        <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                        <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                    </div>
                                </div>
                                <button class="add-to-cart" data-request="{{ $product->id }}">Add to cart</button>
                            </form>
                        </div>
                        <div class="product-additional-info pt-25">
                            <div class="product-social-sharing pt-25">
                                <ul>
                                    <li class="facebook"><a href="#"><i class="fa fa-facebook"></i>Facebook</a></li>
                                    <li class="twitter"><a href="#"><i class="fa fa-twitter"></i>Twitter</a></li>
                                    <li class="instagram"><a href="#"><i class="fa fa-instagram"></i>Instagram</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="block-reassurance">
                            <ul>
                                <li>
                                    <div class="reassurance-item">
                                        <div class="reassurance-icon">
                                            <i class="fa fa-check-square-o"></i>
                                        </div>
                                        <p>Security policy (edit with Customer reassurance module)</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="reassurance-item">
                                        <div class="reassurance-icon">
                                            <i class="fa fa-truck"></i>
                                        </div>
                                        <p>Delivery policy (edit with Customer reassurance module)</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="reassurance-item">
                                        <div class="reassurance-icon">
                                            <i class="fa fa-exchange"></i>
                                        </div>
                                        <p> Return policy (edit with Customer reassurance module)</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wraper end -->
<!-- Begin Product Area -->
<div class="product-area pt-35">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                        <li><a class="active" data-toggle="tab" href="#description"><span>Description</span></a></li>
                        <li><a data-toggle="tab" href="#product-details"><span>Product Details</span></a></li>
                        <li><a data-toggle="tab" href="#reviews"><span>Reviews</span></a></li>
                    </ul>
                </div>
                <!-- Begin Li's Tab Menu Content Area -->
            </div>
        </div>
        <div class="tab-content">
            <div id="description" class="tab-pane active show" role="tabpanel">
                <div class="product-description">
                    <span>{!! $product->description !!}</span>
                </div>
            </div>
            <div id="product-details" class="tab-pane" role="tabpanel">
                <div class="product-details-manufacturer">
                    @if (!empty($product->properties))
                        <div class="accordion" id="accordionExample">
                            @foreach ($product->getProps() as $key_group => $group)
                                @php
                                    $group = collect($group)->sortKeys();
                                    $key_group = $product->getPropKey($key_group);
                                    $loop_id_group = $loop->index + 1;
                                @endphp
                                <div class="card">
                                    <div class="card-header" id="heading_{{$loop_id_group}}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                                data-target="#collapse_{{$loop_id_group}}" aria-expanded="true" aria-controls="collapse_{{$loop_id_group}}">
                                                <span class="lead">{{ __($key_group) }}</span>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapse_{{$loop_id_group}}" class="collapse{{ $loop_id_group == 1 ? ' show' : '' }}" aria-labelledby="heading_{{$loop_id_group}}" data-parent="#accordionExample">
                                        <div class="card-body">
                                        <table class="table">
                                            @foreach ($group as $key_prop => $prop)
                                                @php
                                                    $key_prop = $product->getPropKey($key_prop);
                                                    $loop_id_prop = $loop->index + 1;
                                                    $name = "properties[{$loop_id_group}.{$key_group}][{$loop_id_prop}.{$key_prop}]";
                                                @endphp
                                                <tr>
                                                    <td width="30%"><strong>{{ __($key_group . '.' . $key_prop) }}</strong></td>
                                                    <td>{{ $prop }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div id="reviews" class="tab-pane" role="tabpanel">
                <div class="product-reviews">
                    <div class="product-details-comment-block">
                        <div class="comment-review">
                            <span>Grade</span>
                            <ul class="rating">
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                            </ul>
                        </div>
                        <div class="comment-author-infos pt-25">
                            <span>HTML 5</span>
                            <em>01-12-18</em>
                        </div>
                        <div class="comment-details">
                            <h4 class="title-block">Demo</h4>
                            <p>Plaza</p>
                        </div>
                        <div class="review-btn">
                            <a class="review-links" href="#" data-toggle="modal" data-target="#mymodal">Write Your Review!</a>
                        </div>
                        <!-- Begin Quick View | Modal Area -->
                        <div class="modal fade modal-wrapper" id="mymodal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h3 class="review-page-title">Write Your Review</h3>
                                        <div class="modal-inner-area row">
                                            <div class="col-lg-6">
                                                <div class="li-review-product">
                                                    <img src="{{ asset('images/product/large-size/3.jpg') }}" alt="Li's Product">
                                                    <div class="li-review-product-desc">
                                                        <p class="li-product-name">Today is a good day Framed poster</p>
                                                        <p>
                                                            <span>Beach Camera Exclusive Bundle - Includes Two Samsung Radiant 360 R3 Wi-Fi Bluetooth Speakers. Fill The Entire Room With Exquisite Sound via Ring Radiator Technology. Stream And Control R3 Speakers Wirelessly With Your Smartphone. Sophisticated, Modern Design </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="li-review-content">
                                                    <!-- Begin Feedback Area -->
                                                    <div class="feedback-area">
                                                        <div class="feedback">
                                                            <h3 class="feedback-title">Our Feedback</h3>
                                                            <form action="#">
                                                                <p class="your-opinion">
                                                                    <label>Your Rating</label>
                                                                    <span>
                                                                        <select class="star-rating">
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                            <option value="5">5</option>
                                                                        </select>
                                                                    </span>
                                                                </p>
                                                                <p class="feedback-form">
                                                                    <label for="feedback">Your Review</label>
                                                                    <textarea id="feedback" name="comment" cols="45" rows="8" aria-required="true"></textarea>
                                                                </p>
                                                                <div class="feedback-input">
                                                                    <p class="feedback-form-author">
                                                                        <label for="author">Name<span class="required">*</span>
                                                                        </label>
                                                                        <input id="author" name="author" value="" size="30" aria-required="true" type="text">
                                                                    </p>
                                                                    <p class="feedback-form-author feedback-form-email">
                                                                        <label for="email">Email<span class="required">*</span>
                                                                        </label>
                                                                        <input id="email" name="email" value="" size="30" aria-required="true" type="text">
                                                                        <span class="required"><sub>*</sub> Required fields</span>
                                                                    </p>
                                                                    <div class="feedback-btn pb-15">
                                                                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">Close</a>
                                                                        <a href="#">Submit</a>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- Feedback Area End Here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Quick View | Modal Area End Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Area End Here -->
<!-- Begin Li's Laptop Product Area -->
<section class="product-area li-laptop-product pt-30 pb-50">
    <div class="container">
        <div class="row">
            <!-- Begin Li's Section Area -->
            <div class="col-lg-12">
                <div class="li-section-title">
                    <h2>
                        <span>Other products in the same brand:</span>
                    </h2>
                </div>
                <div class="row product-{{ count($relates) > 5 ? 'active owl-carousel' : 'list' }}">
                    @if (!empty($relates))
                    @foreach ($relates as $product)
                    <div class="{{ count($relates) > 5 ? 'col-lg-12' : 'col-lg-3' }}">
                        <div class="single-product-wrap">
                            <div class="product-image">
                                <a href="{{ url('product/' . $product->id) }}">
                                    <img src="{{ $product->getThumb() }}" alt="{{ $product->name }}" class="img">
                                </a>
                                <span class="sticker">New</span>
                            </div>
                            <div class="product_desc">
                                <div class="product_desc_info">
                                    <div class="product-review">
                                        <h5 class="manufacturer">
                                            <a href="{{ url('brand/' . $product->brand->id) }}">{{ $product->brand->name }}</a>
                                        </h5>
                                        <div class="rating-box">
                                            <ul class="rating">
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <h4><a class="product_name" href="{{ url('product/' . $product->id) }}">{{ $product->name }}</a></h4>
                                    <div class="price-box">
                                        <span class="new-price">{{ $product->vnd_format() }} VNĐ</span>
                                    </div>
                                </div>
                                <div class="add-actions">
                                    <ul class="add-actions-link">
                                        <li class="add-cart active"><a data-request="{{ $product->id }}">Add to cart</a></li>
                                        <li><a href="#" title="quick view" class="quick-view-btn" data-toggle="modal" 
                                            data-target="#productPreview" data-request="{{ $product->id }}"><i class="fa fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- single-product-wrap end -->
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <!-- Li's Section Area End Here -->
        </div>
    </div>
</section>
@include('frontpage_def.layouts.modal')
@endsection
