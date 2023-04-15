<div class="sidebar-left-info">

    <div class="user-box">
        <div class="d-flex justify-content-center">
            <img src="{{asset(Auth::user()->avatar)}}" alt="" class="img-fluid rounded-circle">
        </div>
        <div class="text-center text-white mt-2">
            <h6> {{Auth::user()->name}}</h6>
            <p class="text-muted m-0 ">{{Auth::user()->getInfRole->roleName}}</p>
        </div>
    </div>

    <!--sidebar nav start-->
    <ul class="side-navigation">
        <li class=" @yield('status_avtive_nav_dashboard') ">
            <a href="{{ route('dashboard.index') }}"><i class="mdi mdi-gauge"></i> <span>Thống kê</span></a>
        </li>
        <li class="@yield('status_avtive_nav_slide') showList">
            <a href="javascript():void(0)" class="display_row_center" style="display:flex">
                <div><i class="fa fa-area-chart"></i> <span>Quản lý giao diện</span></div>
                <i class="fa  fa-chevron-down"></i>
            </a>
            <ul class="@yield('status_activeShowDropdown_slide') child-list ">
                <li class="@yield('status_list_slide_1')"><a href="{{route('slide.index')}}">Slide</a></li>
            </ul>
        </li>
        @if(Auth::user()->role_id == 1)
        <!-- <li>
            <h3 class="navigation-title">Quản lý sản phẩm</h3>
        </li> -->
        <li class="@yield('status_avtive_nav_category')">
            <a href="{{route('category.index')}}"><i class="fa fa-th-large"></i> <span>Thể loại</span></a>
        </li>
        <li class="@yield('status_avtive_nav') showList">
            <a href="javascript():void(0)" class="display_row_center" style="display:flex">
                <div><i class="fa fa-dropbox"></i> <span>Quản lý sản phẩm</span></div>
                <i class="fa  fa-chevron-down"></i>
            </a>
            <ul class="@yield('status_activeShowDropdown') child-list ">
                <li class="@yield('status_list_1')"><a href="{{route('products.index')}}">Sản phẩm</a></li>
                <!-- <li class="@yield('status_list_4')"><a href="{{route('item.index')}}">Vật dụng thú cưng</a></li> -->
                <li class="@yield('status_list_2')"><a href="{{route('products.addproduct')}}">Thêm sản phẩm</a></li>
                <li class="@yield('status_list_3')"><a href="{{route('imageproduct.index')}}">Ảnh sản phẩm</a></li>
            </ul>
        </li>
        <li class="@yield('status_avtive_nav_archive') showList">
            <a href="javascript():void(0)" class="display_row_center" style="display:flex">
                <div><i class="fa fa-home"></i> <span>Quản lý kho</span> </div>
                <i class="fa  fa-chevron-down"></i>
            </a>
            <ul class="@yield('status_activeShowDropdown_archive') child-list ">
                <li class="@yield('status_list_archive_1')"><a href="{{route('archive.index')}}">Kho hàng</a></li>
            </ul>
        </li>
        <li class="@yield('status_avtive_nav_user') showList">
            <a href="javascript():void(0)" class="display_row_center" style="display:flex">
                <div><i class="fa fa-users"></i> <span>Quản lý người dùng</span> </div>
                <i class="fa  fa-chevron-down"></i>
            </a>
            <ul class="@yield('status_activeShowDropdown_user') child-list ">
                <li class="@yield('status_list_user_0')"><a href="{{route('user.staff.index')}}">Nhân viên</a></li>
                <li class="@yield('status_list_user_1')"><a href="{{route('user.customer.index')}}">Khách hàng</a></li>
            </ul>
        </li>
        @endif
        <li class="@yield('status_avtive_nav_order') showList">
            <a href="javascript():void(0)" class="display_row_center" style="display:flex">
                <div><i class="fa fa-shopping-cart"></i> <span>Quản lí đơn hàng</span></div>
                <i class="fa  fa-chevron-down"></i>
            </a>
            <ul class="@yield('status_activeShowDropdown_order') child-list ">
                <li class="@yield('status_list_order_0')"><a href="{{route('order.index.new')}}">Đơn hàng</a></li>
            </ul>
        </li>
        <li class="@yield('status_avtive_nav_post') showList">
            <a href="javascript():void(0)" class="display_row_center" style="display:flex">
                <div><i class="fa fa-file-word-o"></i> <span>Quản lí bài viết</span></div>
                <i class="fa  fa-chevron-down"></i>
            </a>
            <ul class="@yield('status_activeShowDropdown_post') child-list ">
                <li class="@yield('status_list_post_1')"><a href="{{route('admin.post.index')}}">Bài viết</a></li>
            </ul>
        </li>
        <li class="@yield('status_avtive_nav_comment') showList">
            <a href="javascript():void(0)" class="display_row_center" style="display:flex">
                <div><i class="fa fa-comment-o"></i> <span>Quản lí bình luận</span></div>
                <i class="fa  fa-chevron-down"></i>
            </a>
            <ul class="@yield('status_activeShowDropdown_comment') child-list ">
                <li class="@yield('status_list_comment_1')"><a href="{{route('admin.comment.index')}}">Bình luận</a></li>
            </ul>
        </li>

    </ul>
    <!--sidebar nav end-->
</div>