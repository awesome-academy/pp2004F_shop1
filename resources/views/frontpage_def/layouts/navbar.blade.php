<div class="header-bottom mb-0 header-sticky d-none d-lg-block d-xl-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Begin Header Bottom Menu Area -->
                <div class="hb-menu">
                    <nav>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            @if (!empty($menuList))
                            @foreach ($menuList as $key => $menu)
                            @if ($key === 'others') @break @endif
                            <li class="dropdowned megamenu-static-holder"><a>{{ $key }}</a>
                                <ul class="row megamenu hb-megamenu">
                                    @foreach ($menu as $product)
                                        <div class="col-lg-4 col-md-6 col-12 mb-20">
                                            <div class="row">
                                                <div class="col-3">
                                                    <a href="{{ url('product/' . $product->id) }}"><img src="{{ $product->getThumb() }}" class="img"></a>
                                                </div>
                                                <a href="{{ url('product/' . $product->id) }}" class="pt-10">
                                                    <span>{{ $product->name }}</span>
                                                    <p style="font-size: 0.9em">{{ $product->vnd_format() }} VNĐ</p>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                            @endif
                            @if (!empty($others))
                            <li class="dropdowned megamenu-static-holder"><a href="#">Others</a>
                                <ul class="megamenu hb-megamenu">
                                    <div class="col-lg-2 col-md-12 col-12">
                                        <div class="row">
                                            <ul>
                                                <li>
                                                    <a><h6>Brand</h6></a>
                                                </li>
                                                @foreach ($others as $brand)
                                                <li>
                                                    <a href="{{ url('brand/' . $brand->id) }}"><h6>{{ $brand->name }}</h6></a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-12">
                                        <div class="row">
                                            @foreach ($menuList['others'] as $product)
                                                <div class="col-lg-4 col-md-6 col-12 mb-20">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{ url('product/' . $product->id) }}"><img src="{{ $product->getThumb() }}" class="img"></a>
                                                        </div>
                                                        <a href="{{ url('product/' . $product->id) }}" class="pt-10">
                                                            <span>{{ $product->name }}</span>
                                                            <p style="font-size: 0.9em">{{ $product->vnd_format() }} VNĐ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </ul>
                            </li>
                            @endif
                            <li><a href="{{ url('about') }}">About Us</a></li>
                            <li><a href="{{ route('contact_index') }}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Header Bottom Menu Area End Here -->
            </div>
        </div>
    </div>
</div>
