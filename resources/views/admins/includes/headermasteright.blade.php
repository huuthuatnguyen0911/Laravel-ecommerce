<!-- header section start-->
<div class="header-section">
    <!--logo and logo icon start-->
    <div class="logo">
        <a href="index.html">
            <span class="logo-img">
                <img src="{{ asset('logo.png') }}" alt="" height="50">
            </span>
            <!--<i class="fa fa-maxcdn"></i>-->
            <!-- <span class="brand-name">Syntra</span> -->
        </a>
    </div>

    <!--toggle button start-->
    <a class="toggle-btn"><i class="ti ti-menu"></i></a>
    <!--toggle button end-->

    <!--mega menu end-->

    <div class="notification-wrap">
        <!--right notification start-->
        <div class="right-notification">
            <ul class="notification-menu">
                <li>
                    <a href="javascript:;" data-toggle="dropdown">
                        <img src="{{asset(Auth::user()->avatar)}}" alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-menu">
                        <a class="dropdown-item" href="{{route('admin.profile.index')}}"><i class="mdi mdi-account-circle m-r-5 text-muted"></i>Hồ sơ</a>
                        <!-- <a class="dropdown-item" href="#"><span class="badge badge-success pull-right">5</span><i class="mdi mdi-settings m-r-5 text-muted"></i> Settings</a> -->
                        <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5 text-muted"></i> Lock screen</a> -->
                        <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('form_logout').submit();"><i class="mdi mdi-logout m-r-5 text-muted"></i> Đăng xuất</a>
                        <form id="form_logout" action="{{route('logout')}}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>

                </li>
            </ul>
        </div>
        <!--right notification end-->
    </div>
</div>