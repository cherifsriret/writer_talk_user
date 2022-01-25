
@extends('layouts.main')
@section('title')
    Change Password
@endsection
@section('content')
    <div class="w-12">
    </div>
    <div class="w-13">
        <div class="card w-100 border-0 bg-white shadow-xs p-0 mb-4 mt-2">
            <div class="card-body p-4 w-100 bg-primary border-0 d-flex rounded-3 ">
                <a href="{{route('userSetting')}}" class="d-inline-block mt-2"><i class="fas fa-arrow-left font-sm text-white"></i></a>
                <h4 class="font-xs text-white fw-600 ms-4 mb-0 mt-1">Change Password</h4>
            </div>
            <div class="card-body p-lg-5 p-4 w-100 border-0">
                <form action="{{route('userChangePassword')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            @include('partials.flash_message')
                            <div class="form-gorup">
                                <label class="mont-font fw-600 font-xssss">Current Password</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="form-gorup">
                                <label class="mont-font fw-600 font-xssss">Change Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="form-gorup">
                                <label class="mont-font fw-600 font-xssss">Confirm Change Password</label>
                                <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" required>
                                @error('confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-0">
                            <button type="submit" class="bg-primary text-center text-white font-xsss fw-600 p-3 w175 rounded-3 d-inline-block">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="w-14">
    </div>
@endsection
@push('js')

@endpush
