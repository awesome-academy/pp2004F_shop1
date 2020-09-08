<header>
    <!-- Begin Header Top Area -->
    <div class="header-top">
        <div class="container">
            <div class="row">
                <!-- Begin Header Top Left Area -->
                <div class="col-lg-3 col-md-4">
                    <div class="header-top-left">
                        <ul class="phone-wrap">
                            <li><span>Telephone Enquiry:</span><a href="#">(+123) 123 321 345</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Header Top Left Area End Here -->
                <!-- Begin Header Top Right Area -->
                <div class="col-lg-9 col-md-8">
                    <div class="header-top-right">
                        <ul class="ht-menu">
                            <!-- Begin Language Area -->
                            <li>
                                <span class="language-selector-wrapper">Language :</span>
                                <div class="ht-language-trigger"><span>English</span></div>
                                <div class="language ht-language">
                                    <ul class="ht-setting-list">
                                        <li class="active"><a href="#"><img src="{{ asset('images/menu/flag-icon/1.jpg') }}" alt="">English</a></li>
                                        <li><a href="#"><img src="{{ asset('images/menu/flag-icon/2.jpg') }}" alt="">Tiếng Việt</a></li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Language Area End Here -->
                            <!-- Begin Setting Area -->
                            @if (Auth::check())
                            <li>
                                <div class="ht-setting-trigger"><span>Setting</span></div>
                                <div class="setting ht-setting">
                                    <ul class="ht-setting-list">
                                        <li><a href="{{ route('user.account') }}">My Account</a></li>
                                        <li><a href="#">Checkout</a></li>
                                        <li><a href="{{ route('logout') }}">Sign out</a></li>
                                        
                                    </ul>
                                </div>
                            </li>
                            <li>{{ Auth::user()->getFullName() }}</li>
                            @else
                            <li><a href="{{ url('login') }}">Sign in</a></li>
                            <li><a href="{{ url('register') }}">Register</a></li>
                            @endif
                            <!-- Setting Area End Here -->
                        </ul>
                    </div>
                </div>
                <!-- Header Top Right Area End Here -->
            </div>
        </div>
    </div>
    <!-- Header Top Area End Here -->
    <!-- Begin Header Middle Area -->
    <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
        <div class="container">
            <div class="row">
                <!-- Begin Header Logo Area -->
                <div class="col-lg-3">
                    <div class="logo pb-sm-30 pb-xs-30">
                        <a href="index.html">
                            <img src="{{ asset('images/menu/logo/1.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
                <!-- Header Logo Area End Here -->
                <!-- Begin Header Middle Right Area -->
                <div class="col-lg-9 pl-0 ml-sm-15 ml-xs-15">
                    <!-- Begin Header Middle Searchbox Area -->
                    <form action="{{ route('search.submit') }}" class="hm-searchbox" method="GET">
                        {{-- @csrf
                        @method('GET') --}}
                        <select class="nice-select select-search-category">
                            <option value="0">All</option>
                            <option value="10">Laptops</option>
                        </select>
                        <input type="text" name="q" placeholder="Enter your search key ..." required>
                        <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    <!-- Header Middle Searchbox Area End Here -->
                    <!-- Begin Header Middle Right Area -->
                    <div class="header-middle-right">
                        <ul class="hm-menu">
                            <!-- Header Middle Wishlist Area End Here -->
                            <!-- Begin Header Mini Cart Area -->
                            <li class="hm-minicart">
                                <div class="hm-minicart-trigger">
                                    <span class="item-icon"></span>
                                    <span class="item-text">
                                        <span class="cart-total">{{ (!empty($cart)) ? vnd_format($cart['total']) : 0 }}</span><sup> VNĐ</sup>
                                        <span class="cart-item-count">@if(session()->has('cart') && count(session()->get('cart')) > 0) {{ count(session()->get('cart')) }} @endif</span>
                                    </span>
                                </div>
                                <span></span>
                                <div class="minicart">
                                    <ul class="minicart-product-list">
                                    </ul>
                                    <p class="minicart-total">SUBTOTAL: 
                                        <span style="margin-left: 8px">VNĐ</span>
                                        <span>{{ (!empty($cart)) ? vnd_format($cart['total']) : 0 }}</span>
                                    </p>
                                    <div class="minicart-button">
                                        <a href="{{ url('cart') }}" class="li-button li-button-fullwidth li-button-dark">
                                            <span>View Full Cart</span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!-- Header Mini Cart Area End Here -->
                        </ul>
                    </div>
                    <!-- Header Middle Right Area End Here -->
                </div>
                <!-- Header Middle Right Area End Here -->
            </div>
        </div>
    </div>
    <!-- Header Middle Area End Here -->
    @include('frontpage_def.layouts.navbar')
    <!-- Begin Mobile Menu Area -->
    <div class="mobile-menu-area d-lg-none d-xl-none col-12">
        <div class="container">
            <div class="row">
                <div class="mobile-menu">
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu Area End Here -->
</header>
<!-- Header Area End Here -->
