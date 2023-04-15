@extends('layouts.app')

@section('title')
SIGN UP
@endsection

@section('content')
<!-- Sign up form -->
<section class="signup">
    <div class="container">
        <div class="signup-content">
            <div class="signup-form">
                <h2 class="form-title">Đăng kí</h2>
                <form method="POST" class="{{ route('register') }}" id="register-form">
                    @csrf

                    <div class="form-group">
                        <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <!-- <input type="text" name="name" id="name" placeholder="Your Name" /> -->
                        <div class="">
                            <input id="name" type="text" placeholder="Tên của bạn" class=" @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-email"></i></label>
                        <!-- <input type="email" name="email" id="email" placeholder="Your Email" /> -->

                        <div class="">
                            <input id="email" type="email" placeholder="Email của bạn" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password"><i class="zmdi zmdi-lock"></i></label>
                        <div class="">
                            <input id="password" type="password" placeholder="Mật khẩu" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm"><i class="zmdi zmdi-lock-outline"></i></label>
                        <!-- <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password" /> -->
                        <div class="">
                            <input id="password-confirm" type="password" class="" placeholder="Nhập lại mật khẩu" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                        <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in <a href="#" class="term-service">Terms of service</a></label>
                    </div> -->
                    <div class="form-group form-button">
                        <!-- <input type="submit" name="signup" id="signup" class="form-submit" value="Register" /> -->
                        <button type="submit" class="btn btn-primary">
                            {{ __('Đăng kí') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="signup-image">
                <a href="{{ url('/')}}"><figure><img src="{{asset('assets/auth/images/signup-image.jpg')}}" alt="sing up image"></figure></a>
                <a href="{{ route('login') }}" class="signup-image-link">Tôi đã là thành viên</a>
            </div>
        </div>
    </div>
</section>
@endsection