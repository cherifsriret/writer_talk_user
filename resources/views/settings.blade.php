@extends('layouts.main')

@section('title')
    Settings
@endsection
@section('content')
    <div class="w-12">
    </div>
    <div class="w-13">
        <div class="card w-100 border-0 bg-white shadow-xs p-0 my-2">
            <div class="card-body px-5 py-4 w-100 border-0">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="font-xxl fw-700 mb-4 pb-2 font-md-xs">Settings</h4>
                        <div class="nav-caption fw-600 font-xssss text-grey-500 mb-2">Genaral</div>
                        <ul class="list-inline mb-4">
                            <li class="list-inline-item d-block border-bottom mr-0"><a href="{{route('editUserProfile')}}" class="pt-2 pb-2 d-flex align-items-center"><i class="btn-round-md bg-primary-gradiant text-white fas fa-home font-md me-3"></i> <h4 class="text-dark fw-600 font-xsss mb-0 mt-0">Acount Information</h4><i class="fas fa-angle-right font-xsss text-grey-500 ms-auto mt-3"></i></a></li>
{{--                            <li class="list-inline-item d-block border-bottom mr-0"><a href="#" class="pt-2 pb-2 d-flex align-items-center"><i class="btn-round-md bg-gold-gradiant text-white fas fa-map-marker-alt font-md me-3"></i> <h4 class="text-dark fw-600 font-xsss mb-0 mt-0">Saved Address</h4><i class="fas fa-angle-right font-xsss text-grey-500 ms-auto mt-3"></i></a></li>--}}
{{--                            <li class="list-inline-item d-block mr-0"><a href="#" class="pt-2 pb-2 d-flex align-items-center"><i class="btn-round-md bg-red-gradiant text-white fab fa-twitter font-md me-3"></i> <h4 class="text-dark fw-600 font-xsss mb-0 mt-0">Social Acount</h4><i class="fas fa-angle-right font-xsss text-grey-500 ms-auto mt-3"></i></a></li>--}}
                        </ul>
                        <div class="nav-caption fw-600 font-xsss text-grey-500 mb-2">Acount</div>
                        <ul class="list-inline mb-4">
{{--                            <li class="list-inline-item d-block border-bottom mr-0"><a href="#" class="pt-2 pb-2 d-flex align-items-center"><i class="btn-round-md bg-mini-gradiant text-white far fa-credit-card font-md me-3"></i> <h4 class="text-dark fw-600 font-xsss mb-0 mt-0">My Cards</h4><i class="fas fa-angle-right font-xsss text-grey-500 ms-auto mt-3"></i></a></li>--}}
                            <li class="list-inline-item d-block mr-0"><a href="{{route('changeUserPassword')}}" class="pt-2 pb-2 d-flex align-items-center"><i class="btn-round-md bg-blue-gradiant text-white fas fa-inbox font-md me-3"></i> <h4 class="text-dark fw-600 font-xsss mb-0 mt-0">Password</h4><i class="fas fa-angle-right font-xsss text-grey-500 ms-auto mt-3"></i></a></li>
                        </ul>
                        <div class="nav-caption fw-600 font-xsss text-grey-500 mb-2">Other</div>
                        <ul class="list-inline">
{{--                            <li class="list-inline-item d-block border-bottom mr-0"><a href="#" class="pt-2 pb-2 d-flex align-items-center"><i class="btn-round-md bg-gold-gradiant text-white far fa-bell font-md me-3"></i> <h4 class="text-dark fw-600 font-xsss mb-0 mt-0">Notification</h4><i class="fas fa-angle-right font-xsss text-grey-500 ms-auto mt-3"></i></a></li>--}}
{{--                            <li class="list-inline-item d-block border-bottom mr-0"><a href="#" class="pt-2 pb-2 d-flex align-items-center"><i class="btn-round-md bg-primary-gradiant text-white far fa-question-circle font-md me-3"></i> <h4 class="text-dark fw-600 font-xsss mb-0 mt-0">Help</h4><i class="fas fa-angle-right font-xsss text-grey-500 ms-auto mt-3"></i></a></li>--}}
                            <li class="list-inline-item d-block me-0"><a href="{{ route('logout') }}" class="pt-2 pb-2 d-flex align-items-center"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="btn-round-md bg-red-gradiant text-white fas fa-lock font-md me-3"></i> <h4 class="text-dark fw-600 font-xsss mb-0 mt-0">{{ __('Logout') }}</h4><i class="fas fa-angle-right font-xsss text-grey-500 ms-auto mt-3"></i></a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-14">
    </div>
@endsection
