@extends('layouts.app_2')

@section('title')
FORGOT PASSWORD
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center pt-5 pb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Quên mật khẩu</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right" style="">Địa chỉ email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <div class="row" style="align-items: center;">
                                    <button type="submit" class="btn btn-primary mr-4" >
                                        {{ __('Gửi liên kết') }}
                                    </button>
                                    <a href="{{ route('login') }}" class="signup-image-link ">Đăng nhập</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection