@extends('layouts.app')

@section('title')
SIGN IN
@endsection

@section('content')
<!-- Sing in  Form -->
<section class="sign-in">
    <div class="container">
        <div class="signin-content">
            <div class="signin-image">
                <a href="{{url('/')}}"><figure><img src="{{asset('assets/auth/images/signin-image.jpg')}}" alt="sing up image"></figure></a>
                <a href="{{ route('register') }}" class="signup-image-link">Tạo tài khoản</a>
            </div>

            <div class="signin-form">
                <h2 class="form-title">Đăng nhập</h2>
                <form method="POST" action="{{route('login.new') }}" class="" id="login-form">
                    @csrf
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <!-- <input type="text" name="your_name" id="your_name" placeholder="Your Email" /> -->
                        <div class="">
                            <input id="email" type="email" class="@error('email') is-invalid @enderror" placeholder="Email của bạn" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="zmdi zmdi-lock"></i></label>
                        <!-- <input type="password" name="your_pass" id="password" placeholder="Password" /> -->
                        <div class="">
                            <input id="password" type="password" class=" @error('password') is-invalid @enderror" placeholder="Mật khẩu của bạn" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>      
                    <div class="form-group" >
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="agree-term" />
                        <label for="remember" for="remember" style="display: flex; align-items: center;" class="label-agree-term"><span><span></span></span>Ghi nhớ mật khẩu</label>
                    </div>
                    <div class="form-group form-button">
                        <!-- <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" /> -->
                        <button type="submit" class="btn btn-primary">
                            <!-- {{ __('Login') }} -->
                            Đăng nhập
                        </button>

                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Quên mật khẩu?') }}
                        </a>
                        @endif
                    </div>
                </form>
                <div class="social-login">
                    <span class="social-label">Đăng nhập với</span>
                    <ul class="socials">
                        <li><a href="{{route('login.provider', 'facebook')}}"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                        <!-- <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li> -->
                        <li><a href="{{route('login.provider', 'google')}}"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection