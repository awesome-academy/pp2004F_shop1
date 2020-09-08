@extends('admin_master_def')

@section('title', '| Product Details')

@section('content')
    <div class="clearfix">
        <div class="col-xs-12">   
            <h3>Product Details</h3>
        </div>
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-body">
                    <div class="clearfix">
                        <div class="col-xs-12 col-md-3">
                            @if (count($product->images) > 1)
                                <div class="product-details-images slider-navigation-1 text-center">
                                    @foreach($product->images as $img)
                                    <div class="lg-image text-center">
                                        <img src="{{ $img->image }}" alt="product image" style="width: 100%; max-height: 330px">
                                    </div>
                                    @endforeach
                                </div>
                                <div class="product-details-thumbs slider-thumbs-1">                                        
                                    @foreach($product->images as $thumb)
                                    <div class="sm-image">
                                        <img src="{{ $product->getThumb($thumb->image) }}" class="img img-thumbnail" style="max-height: 120px">
                                    </div>
                                    @endforeach
                                </div>
                            @elseif (count($product->images) == 1)
                                <div class="sm-image text-center">
                                    <img src="{{ $product->images->first()->image }}" alt="" class="img img-responsive" style="max-height: 330px">    
                                </div>
                            @else
                                <p>Product Image Not Available</p>
                            @endif
                        </div>
                        <div class="col-xs-12 col-md-9">
                            <h3 class="box-title lead"><b>{{ $product->name }}</b></h3>
                            <div class="product-details">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th colspan="2">Details</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 30%">Product Code</th>
                                            <td>{{ $product->product_code }}</td>
                                        </tr>
                                        <tr>
                                            <th>Quantity In Stock</th>
                                            <td>{{ $product->quantity_in_stock }}</td>
                                        </tr>
                                        <tr>
                                            <th>Excerpt</th>
                                            <td>{{ $product->excerpt }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <th>Description</th>
                                            <td>{!! $product->description !!}</td>
                                        </tr> --}}
                                        <tr>
                                            <th>Brand</th>
                                            <td>{{ $product->brand->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Import Price</th>
                                            <td>{{ $product->buy_price }}.000 VNĐ</td>
                                        </tr>
                                        <tr>
                                            <th>Current price</th>
                                            <td>{{ $product->current_price }}.000 VNĐ</td>
                                        </tr>
                                        <tr>
                                            <th>Sale Off</th>
                                            <td>@isset($product->sale_off) {{ $product->sale_off}} @endisset</td>
                                        </tr>
                                        <tr>
                                            <th><span class="lead"><strong>Sales</strong></span></th>
                                            <td>{{ $product->getTotalSales() }}</td>
                                        </tr>
                                        <tr>
                                            <th><span class="lead"><strong>Total Amount</strong></span></th>
                                            <td>{{ vnd_format($product->getTotalAmount()) }} VNĐ</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Edit Product</a>
                                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Remove</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-lg-offset-3">
                            <h3>Product Specs</h3>
                            @if (!empty($product->properties))
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    @foreach ($product->getProps() as $key_group => $group)
                                        @php
                                            $group = collect($group)->sortKeys();
                                            $key_group = $product->getPropKey($key_group);
                                            $loop_id_group = $loop->index + 1;
                                        @endphp
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#group_{{$loop_id_group}}"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        <span class="lead">{{ __($key_group) }}</span>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="group_{{$loop_id_group}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('lib-css')
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
@endpush

@push('lib-js')
    <script src="{{ asset('js/slick.min.js') }}"></script>
@endpush

@push('js')
    <script>
        $('.product-details-images').each(function(){
            var $this = $(this);
            var $thumb = $this.siblings('.product-details-thumbs, .tab-style-left');
            $this.slick({
                arrows: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: 5000,
                dots: false,
                infinite: true,
                centerMode: true,
                centerPadding: 0,
                asNavFor: $thumb,
            });
        });
        $('.product-details-thumbs').each(function(){
            var $this = $(this);
            var $details = $this.siblings('.product-details-images');
            $this.slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: 5000,
                dots: false,
                infinite: true,
                focusOnSelect: true,
                centerMode: true,
                centerPadding: 0,
                prevArrow: '<span class="slick-prev"><i class="fa fa-angle-left"></i></span>',
                nextArrow: '<span class="slick-next"><i class="fa fa-angle-right"></i></span>',
                asNavFor: $details,
            });
        });
    </script>
@endpush