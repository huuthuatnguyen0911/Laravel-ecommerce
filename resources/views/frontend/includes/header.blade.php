<!--Header Section Start-->
<div class="header-section d-none d-lg-block">
    <div class="main-header">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <div class="header-logo">
                        <a href="{{route('index')}}"><img src="{{asset('logo1.jpg')}}" alt="" style="width:100px;border-radius:50px; height: 70px; object-fit: cover;"></a>
                    </div>
                </div>
                <div class="col-lg-7 position-static">
                    <div class="site-main-nav">
                        <nav class="site-nav">
                            <ul>
                                <li><a href="{{route('index')}}" class="@yield('main_active_site_home')">TRANG CHỦ</a></li>
                                <li>
                                    <a href="{{route('store.index')}}" class="@yield('main_active_site_store')">CỬA HÀNG
                                        <!-- <span class="new">New</span> -->
                                    </a>

                                    <!-- <ul class="mega-sub-menu">
                                        <li class="mega-dropdown">
                                            <a class="mega-title" href="#">Shop</a>

                                            <ul class="mega-item">
                                                <li><a href="shop-grid-3.html">Shop Grid 3</a></li>
                                                <li><a href="shop-grid-4.html">Shop Grid 4</a></li>
                                                <li><a href="shop-list.html">Shop List</a></li>
                                                <li><a href="shop-grid-left-sidebar.html">Shop Grid Left Sidebar</a></li>
                                                <li><a href="shop-grid-right-sidebar.html">Shop Grid Right Sidebar</a></li>
                                                <li><a href="shop-list-left-sidebar.html">Shop List Left Sidebar</a></li>
                                                <li><a href="shop-list-right-sidebar.html">Shop List Right Sidebar</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-dropdown">
                                            <a class="mega-title" href="#">Shop Single</a>

                                            <ul class="mega-item">
                                                <li><a href="shop-single.html">Shop Single</a></li>
                                                <li><a href="shop-single-affiliate.html">Shop Single Affiliate</a></li>
                                                <li><a href="shop-single-variable.html">Shop Single Variable</a></li>
                                                <li><a href="shop-single-group.html">Shop Single Group</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-dropdown">
                                            <a class="mega-title" href="#">Tính năng</a>

                                            <ul class="mega-item">
                                                <li><a href="{{route('compare.index')}}">So sánh</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-dropdown">
                                            <a class="menu-banner" href="#">
                                                <img src="assets/images/menu-banner.jpg" alt="">
                                            </a>
                                        </li>
                                    </ul> -->
                                </li>
                                <li>
                                    <a href="{{route('community.index')}}" class="@yield('main_active_site_community')">Bài viết</a>
                                    <!-- <span class="sale">Sale</span> -->
                                    <!-- <ul class="sub-menu">
                                        <li><a href="about.html">About</a></li>
                                        <li><a href="cart.html">Cart</a></li>
                                        <li><a href="wishlist.html">Wishlist</a></li>
                                        <li><a href="compare.html">Compare</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                        <li><a href="empty-cart.html">Empty Cart</a></li>
                                        <li><a href="my-account.html">My Account</a></li>
                                        <li><a href="login.html">Login</a></li>
                                        <li><a href="register.html">Register</a></li>
                                    </ul> -->
                                </li>
                                <li><a href="{{route('contact.index')}}" class="@yield('main_active_site_contact')">LIÊN HỆ</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="header-meta-info">
                        <div class="header-search">
                            <form action="#">
                                <input type="text" placeholder="Tìm kiếm...">
                                <button><i class="icon-search"></i></button>
                            </form>
                        </div>
                        <div class="header-account">
                            <div class="header-account-list dropdown top-link">
                                <a href="#" role="button" data-toggle="dropdown"><i class="icon-user"></i></a>

                                <ul class="dropdown-menu ">
                                    @if(Auth::check())
                                    {{-- <li><a href="{{route('chatify')}}">Tin nhắn</a></li> --}}
                                    <li><a href="{{route('personal.messages.index')}}">{{Auth::check() ? Auth::user()->name : '' }}</a></li>
                                    <li><a href="{{route('wishlist.index')}}">Yêu thích của bạn</a></li>
                                    <li><a href="{{route('logout')}}" onclick="event.preventDefault();
                                        document.getElementById('form_logout').submit();">Đăng Xuất</a></li>
                                    <form id="form_logout" action="{{route('logout')}}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    @else
                                    <li><a href="{{route('login')}}">Đăng nhập</a></li>
                                    <li><a href="{{route('register')}}">Đăng kí</a></li>
                                    @endif


                                </ul>
                            </div>
                            <div class="header-account-list dropdown mini-cart">
                                <a href="#" role="button" id="icon_cart_pc">
                                    <i class="icon-shopping-bag"></i>
                                    @if(Auth::check())
                                    <span class="item-count " id="showQuantityCart"></span>
                                    @endif
                                </a>

                                <ul id="dropdownCart_pc" class=" dropdown-menu">
                                    <li class="product-cart" id="showCartList">
                                        <!-- list cart -->
                                    </li>
                                    <li class="product-total">
                                        <ul class="cart-total">
                                            <li> Tổng tiền : <span id="ShowTotalPrice"></span></li>
                                        </ul>
                                    </li>
                                    <li class="product-btn">
                                        <a href="{{route('cart.user.index')}}" class="btn btn-orange btn-block" style="line-height: unset ;">Xem giỏ hàng </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Header Section End-->

<!--Header Mobile Start-->
<div class="header-mobile d-lg-none">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6">
                <div class="header-logo">
                    <a href="index.html"><img src="{{asset('assets/frontends/images/logo/logo.png')}}" alt=""></a>
                </div>
            </div>
            <div class="col-6">
                <div class="header-meta-info">
                    <div class="header-account">
                        <div class="header-account-list dropdown top-link">
                            <a href="#" role="button" data-toggle="dropdown"><i class="icon-user"></i></a>

                            <ul class="dropdown-menu ">
                                @if(Auth::check())
                                <li><a href="#">{{Auth::check() ? Auth::user()->name : '' }}</a></li>
                                <li><a href="{{route('wishlist.index')}}">Yêu thích của bạn</a></li>
                                <li><a href="{{route('logout')}}" onclick="event.preventDefault();
                                        document.getElementById('form_logout').submit();">Đăng Xuất</a></li>
                                <form id="form_logout" action="{{route('logout')}}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                @else
                                <li><a href="{{route('login')}}">Đăng nhập</a></li>
                                <li><a href="{{route('register')}}">Đăng kí</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="header-account-list mini-cart">
                            <a href="#" id="icon_cart_mobile">
                                <i class="icon-shopping-bag"></i>
                                @isset($cart)
                                <span class="item-count ">3</span>
                                @endisset
                            </a>
                            <ul id="dropdownCart_mobile" class=" dropdown-menu">
                                <li class="product-cart">
                                    <div class="single-cart-box">
                                        <div class="cart-img">
                                            <a href="shop-single.html"><img src="assets/images/cart/cart-1.jpg" alt=""></a>
                                            <span class="pro-quantity">1x</span>
                                        </div>
                                        <div class="cart-content">
                                            <h6 class="title"><a href="shop-single.html">Rock Soapwort</a></h6>
                                            <div class="cart-price">
                                                <span class="sale-price">$70.00</span>
                                                <span class="regular-price">$80.00</span>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="del-icon"><i class="fa fa-trash"></i></a>
                                    </div>
                                    <div class="single-cart-box">
                                        <div class="cart-img">
                                            <a href="shop-single.html"><img src="assets/images/cart/cart-2.jpg" alt=""></a>
                                            <span class="pro-quantity">1x</span>
                                        </div>
                                        <div class="cart-content">
                                            <h6 class="title"><a href="shop-single.html">Rock Soapwort</a></h6>
                                            <div class="cart-price">
                                                <span class="sale-price">$70.00</span>
                                                <span class="regular-price">$80.00</span>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="del-icon"><i class="fa fa-trash"></i></a>
                                    </div>
                                    <div class="single-cart-box">
                                        <div class="cart-img">
                                            <a href="shop-single.html"><img src="assets/images/cart/cart-3.jpg" alt=""></a>
                                            <span class="pro-quantity">1x</span>
                                        </div>
                                        <div class="cart-content">
                                            <h6 class="title"><a href="shop-single.html">Rock Soapwort</a></h6>
                                            <div class="cart-price">
                                                <span class="sale-price">$70.00</span>
                                                <span class="regular-price">$80.00</span>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="del-icon"><i class="fa fa-trash"></i></a>
                                    </div>
                                </li>
                                <li class="product-total">
                                    <ul class="cart-total">
                                        <li> Total : <span>$189.00</span></li>
                                    </ul>
                                </li>
                                <li class="product-btn">
                                    <a href="{{route('cart.user.index')}}" class="btn btn-dark btn-block">Xem giỏ hàng</a>
                                </li>
                            </ul>
                        </div>
                        <div class="header-account-list mobile-menu-trigger">
                            <button id="menu-trigger">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Header Mobile End-->

<!--Header Mobile Menu Start-->
<div class="header-mobile-menu d-lg-none">

    <a href="javascript:void(0)" class="mobile-menu-close">
        <span></span>
        <span></span>
    </a>

    <div class="header-meta-info">
        <div class="header-search">
            <form action="#">
                <input type="text" placeholder="Search our store ">
                <button><i class="icon-search"></i></button>
            </form>
        </div>
    </div>

    <div class="site-main-nav">
        <nav class="site-nav">
            <ul class="navbar-mobile-wrapper">
                <li><a href="index.html">TRANG CHỦ</a></li>
                <li>
                    <a href="#">Shop <span class="new">New</span></a>
                    <ul class="mega-sub-menu">
                        <li class="mega-dropdown">
                            <a class="mega-title" href="#">CỬA HÀNG</a>

                            <ul class="mega-item">
                                <li><a href="shop-grid-3.html">Shop Grid 3</a></li>
                                <li><a href="shop-grid-4.html">Shop Grid 4</a></li>
                                <li><a href="shop-list.html">Shop List</a></li>
                                <li><a href="shop-grid-left-sidebar.html">Shop Grid Left Sidebar</a></li>
                                <li><a href="shop-grid-right-sidebar.html">Shop Grid Right Sidebar</a></li>
                                <li><a href="shop-list-left-sidebar.html">Shop List Left Sidebar</a></li>
                                <li><a href="shop-list-right-sidebar.html">Shop List Right Sidebar</a></li>
                            </ul>
                        </li>
                        <li class="mega-dropdown">
                            <a class="mega-title" href="#">CỘNG ĐỒNG</a>
                        </li>
                        <li class="mega-dropdown">
                            <a class="menu-banner" href="#">
                                <img src="assets/images/menu-banner.jpg" alt="">
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">DỊCH VỤ</a>

                    <!-- <ul class="sub-menu">
                        <li>
                            <a href="#">Blog</a>
                            <ul class="sub-menu">
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                                <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Blog Single</a>
                            <ul class="sub-menu">
                                <li><a href="blog-single-left-sidebar.html">Blog Single Left Sidebar</a></li>
                                <li><a href="blog-single-right-sidebar.html">Blog Single Right Sidebar</a></li>
                            </ul>
                        </li>
                    </ul> -->
                </li>
                <li>
                    <a href="#">BÀI VIẾT<span class="sale">Sale</span></a>
                    <!-- <ul class="sub-menu">
                        <li><a href="about.html">About</a></li>
                        <li><a href="cart.html">Cart</a></li>
                        <li><a href="wishlist.html">Wishlist</a></li>
                        <li><a href="compare.html">Compare</a></li>
                        <li><a href="checkout.html">Checkout</a></li>
                        <li><a href="empty-cart.html">Empty Cart</a></li>
                        <li><a href="my-account.html">My Account</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="register.html">Register</a></li>
                    </ul> -->
                </li>
                <li><a href="contact.html">LIÊN HỆ</a></li>
            </ul>
        </nav>
    </div>

    <div class="header-social">
        <ul class="social">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
        </ul>
    </div>

</div>
<!--Header Mobile Menu End-->

<div class="overlay"></div>
<!--Overlay-->

<!-- js -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('body').on('click', '#icon_cart_pc', function(e) {
            e.preventDefault();
            console.log('hello');
            if ('{{Auth::check()}}') {
                $('#dropdownCart_pc').toggle('slow');
            } else {
                $(".alert-warning .text_msg").text("Bạn phải đăng nhập mới sử dụng tính năng này!!!");
                $(".alert-warning").css({
                    right: "30px",
                    "z-index": "99999"
                });
                $(".alert-warning .btn-close").click(function() {
                    $(".alert-warning").css({
                        right: "-999px"
                    });
                });

                setTimeout(function() {
                    $(".alert-warning").css({
                        right: "-999px"
                    });
                }, 3000);
            }
        })

        $('body').on('click', '#icon_cart_mobile', function(e) {
            e.preventDefault();
            console.log('hello');
            if ('{{Auth::check()}}') {
                console.log('vào ròi nè')
                $('#dropdownCart_mobile').toggle('slow');
            } else {
                $(".alert-warning .text_msg").text("Bạn phải đăng nhập mới sử dụng tính năng này!!!");
                $(".alert-warning").css({
                    right: "30px",
                    "z-index": "99999"
                });
                $(".alert-warning .btn-close").click(function() {
                    $(".alert-warning").css({
                        right: "-999px"
                    });
                });

                setTimeout(function() {
                    $(".alert-warning").css({
                        right: "-999px"
                    });
                }, 3000);
            }
        })
    })
</script>