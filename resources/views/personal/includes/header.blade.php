<!-- header for desktop begin -->
<div id="sidebar-content" class="sc-dark text-center">
    <div class="sc-inner">

        <div class="box_backToHome mb-2">
            <ul class="ul_backToHome">
                <li>
                    <a class="change_light" href="{{route('index')}}">
                        <i class="fa fa-chevron-left"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li class="icon_toggle_light">
                    <div class="toggle-btn" id="_1st-toggle-btn">
                        <input class="toggle_light" type="checkbox">
                        <span></span>
                    </div>
                </li>
            </ul>

        </div>

        <!-- logo begin -->
        <div id="sc-logo">
            <a href="index.html">
                <img src="{{asset(Auth::user()->avatar)}}" class="img-fluid" alt="">
                <h1 class="change_light">{{ Auth::user()->name }}</h1>
            </a>
        </div>
        <!-- logo close -->

        <!-- mainmenu begin -->
        <ul id="menuside" class="scrollnav">
            <!-- <li>
                <a href="{{route('personal.home.index')}}" class="change_light @yield('active_page_main_home') ">Của tôi</a>
            </li> -->
            <li>
                <a href="{{route('personal.messages.index')}}" class="change_light  @yield('active_page_main_messages')">Tin nhắn</a>
            </li>
            <li>
                <a href="{{route('personal.ordermy.index')}}" class="change_light  @yield('active_page_main_order-my')">Đơn hàng</a>
            </li>
            <li>
                <a href="{{route('personal.post.index')}}" class="change_light @yield('active_page_main_posts')">Bài viết</a>
            </li>
            <li>
                <a href="{{route('personal.setting.index')}}" class="change_light @yield('active_page_main_setting')">Thiết lập</a>
            </li>
            <li style="margin-top:20px;">
                <a href="{{route('personal.page.index', Auth::user()->id)}}" class="btn-custom scroll-to wow fadeInUp animated ">Trang của tôi</a>
            </li>
        </ul>
        <!-- mainmenu close -->

        <div class="social-icons">
            <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
            <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
            <a href="#"><i class="fa fa-linkedin fa-lg"></i></a>
            <a href="#"><i class="fa fa-instagram fa-lg"></i></a>
        </div>
    </div>

    <div class="sc-bg"></div>
</div>
<!-- header for desktop close -->