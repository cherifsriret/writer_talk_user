

@extends('layouts.main')
@section('title')
    Penpals
@endsection
@section('content')
    <div class="w-40 mt-6 pt-1 mx-auto">
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow-xss border-0 p-3 mb-3">
                    <div class="card-body d-flex align-items-center p-0">
                        <h2 class="fw-700 mb-0 mt-0 font-md text-grey-900">Friends</h2>
                        <div class="search-form-2 ms-auto">
                            <i class="fas fa-search font-xss"></i>
                            <input type="text" class="form-control text-grey-500 mb-0 bg-greylight border-0" placeholder="Search here.">
                        </div>
                        <a href="#" class="btn-round-md ms-2 bg-greylight rounded-3"><i class="fas fa-filter font-xss text-grey-500"></i></a>
                    </div>
                </div>

                <div class="row ps-2 pe-2">
                    @if(sizeof($user_penpals) > 0)
                        @foreach($user_penpals as $up => $up_row)
                            <div class="col-md-3 col-sm-4 pe-2 ps-2">
                                <div class="card border-0 shadow-xss rounded-3 mb-3">
                                    <div class="card-body ps-3 pe-3 pb-4 text-center">
                                        <a href="{{route('userProfile',['id'=>$up_row->user->uuid])}}">

                                            <figure class="avatar ms-auto me-auto mb-0 "><img src="{{asset('storage/'.$up_row->user->image)}}" alt="image" class="h20 p-0 ml rounded-circle w65 shadow-xss"></figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xsss mt-3 mb-1">{{ucwords($up_row->user->name)}} </h4>
                                        </a>

                                        <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-3">{{$up_row->user->email}}</p>
                                        <a href="#" class="mt-0 btn pt-2 pb-2 ps-3 pe-3 lh-24 ms-1 ls-3 rounded-xl bg-danger font-xsssss fw-700  text-white">Friends</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4>No Penpals</h4>
                    @endif

                </div>
            </div>
        </div>

    </div>

@endsection
@push('js')

@endpush
