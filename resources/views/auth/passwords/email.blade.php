{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Reset Password') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    <form method="POST" action="{{ route('password.email') }}">--}}
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

{{--                        <div class="form-group row mb-0">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    {{ __('Send Password Reset Link') }}--}}
{{--                                </button>--}}
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
    Reset Password
@endsection
@section('content')
    <div class="main-wrap">
        <div class="nav-header bg-transparent">
            <div class="nav-top">
                <a href="index.html"><i class="fas fa-bolt text-success display1-size mr-2"></i><span class="d-inline-block fw-600 font logo-text">Writers Talk </span> </a>
                <a href="{{route('login')}}" class="header-btn bg-dark fw-500 text-white font-xsss  ms-auto w100 text-center rounded-xl">Login</a>
                <a href="{{route('register')}}" class="header-btn bg-primary fw-500 text-white font-xsss ml-2 w100 text-center  rounded-xl">Register</a>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-5 bg-image-cover bg-no-repeat" style="background-image: url({{asset('assets/imgs/img-bg1.png')}});"></div>
            <div class="col-7 mt-5" style="background: white;">
                <div class="card border-0 ml-auto mr-auto login-card mt-5">
                    <div class="card-body">
                        <h2 class="fw-700 mt-5 size mb-3 line-height-1">{{ __('Reset Password') }}</h2>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group row">

                            <div class="form-group icon-input mb-3">
                                <i class="far fa-envelope font-sm text-grey-500"></i>
                                <input id="email" type="email"  class="style2-input ps-2 form-control text-grey-900 font-xss ls-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus  placeholder="Email Address">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-check text-left mb-3">
                                <input type="checkbox" class="form-check-input mt-2" id="exampleCheck5">
                                <label class="form-check-label font-xsss text-grey-500" for="exampleCheck5">Accept Term and Conditions</label>
                            </div>
                                <div class="col-sm-12 p-0">
                                    <div class="form-group mb-1">
                                        <button type="submit"  class="form-control text-center style2-input text-white fw-600 bg-dark border-0 p-0 ">
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                    </div>
                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
