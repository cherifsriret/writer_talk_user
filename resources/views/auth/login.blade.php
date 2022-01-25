{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Login') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    <form method="POST" action="{{ route('login') }}">--}}
{{--                        @csrf--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{--                                @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

{{--                                @error('password')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                                    <label class="form-check-label" for="remember">--}}
{{--                                        {{ __('Remember Me') }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row mb-0">--}}
{{--                            <div class="col-md-8 offset-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    {{ __('Login') }}--}}
{{--                                </button>--}}

{{--                                @if (Route::has('password.request'))--}}
{{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                        {{ __('Forgot Your Password?') }}--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}

@extends('layouts.auth_layout')
@section('title')
    Login
@endsection
@section('content')
    <div class="main-wrap">
        <div class="nav-header bg-transparent">
            <div class="nav-top">
                <a href="#">
                    <img style="width: 75px;" src="http://writerstalkadmin.com/public/assets/imgs/logo.png" alt="">
                </a>
                <a href="{{route('login')}}" class="header-btn bg-dark fw-500 text-white font-xsss  ms-auto w100 text-center rounded-xl">Login</a>
                <a href="{{route('register')}}" class="header-btn bg-primary fw-500 text-white font-xsss ml-2 w100 text-center  rounded-xl">Register</a>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-5 bg-image-cover bg-no-repeat" style="background-image: url(assets/imgs/img-bg1.png);"></div>
            <div class="col-7">
                <div class="card border-0 ml-auto mr-auto login-card mt-3">
                    <div class="card-body">
                        <h2 class="fw-700 mt-5 size mb-3 line-height-1">Login into <br>your account</h2>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group icon-input mb-2">
                                <i class="far fa-envelope font-sm text-grey-500"></i>
                                <input id="email" type="email" name="email" class="style2-input ps-2 form-control text-grey-900 font-xsss fw-600 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="off"  placeholder="Your Email Address">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group icon-input mb-1">
                                <input id="password" type="password"  class="style2-input ps-2 form-control text-grey-900 font-xss ls-3 @error('email') is-invalid @enderror" name="password" required autocomplete="off" placeholder="Password">
                                <i class="fas fa-lock font-sm text-grey-500"></i>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-check text-left mb-3">
                                <input type="checkbox" class="form-check-input1" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label font-xsss text-grey-500" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
{{--                                <label class="form-check-label font-xsss text-grey-500" for="exampleCheck5">Remember me</label>--}}
{{--                                @if (Route::has('password.request'))--}}
{{--                                <a href="{{ route('password.request') }}" class="fw-600 font-xsss text-grey-700 mt-1 float-right">--}}
{{--                                    {{ __('Forgot Your Password?') }}--}}
{{--                                </a>--}}
{{--                                @endif--}}
                            </div>

                            <div class="form-group mb-1">
                                <button type="submit"  class="form-control text-center style2-input text-white fw-600 bg-dark border-0 p-0 ">
                                    {{ __('Login') }}
                                </button>
                            </div>

                        </form>
                        <div class="col-sm-12 p-0">
                            <h6 class="text-grey-500 font-xsss fw-500 mt-0 mb-0 lh-32">Dont have account <a href="{{route('register')}}" class="fw-700 ms-1">Register</a></h6>
                        </div>
{{--                        <div class="col-sm-12 p-0 text-center mt-2">--}}
{{--                            <h6 class="mb-0 d-inline-block bg-white fw-500 font-xsss text-grey-500 mb-2 ml-4">Or, Sign in with your social account </h6>--}}
{{--                            <div class="form-group mb-1"><a href="#" class="form-control text-left style2-input text-white fw-600 bg-facebook border-0 p-0 mb-2"><img src="{{asset('assets/imgs/google.png')}}" alt="icon" class="ms-2 w40 mb-1 me-5"> Sign in with Google</a></div>--}}
{{--                            <div class="form-group mb-1"><a href="#" class="form-control text-left style2-input text-white fw-600 bg-twiiter border-0 p-0 "><img src="{{asset('assets/imgs/facebook.png')}}" alt="icon" class="ms-2 w40 mb-1 me-5"> Sign in with Facebook</a></div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
