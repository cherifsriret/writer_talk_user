@extends('layouts.main')

@section('title')
    Edit Profile
@endsection

@section('content')
    <div class="w-12">
    </div>
    <div class="w-13">
        <div class="card w-100 border-0 bg-white shadow-xs p-0 mb-4 mt-2">
            <div class="card-body p-4 w-100 bg-primary border-0 d-flex rounded-3">
                <a href="{{route('userSetting')}}" class="d-inline-block mt-2"><i class="fas fa-arrow-left font-sm text-white"></i></a>
                <h4 class="font-xs text-white fw-600 ms-4 mb-0 mt-1">Account Details</h4>
            </div>
            <div class="card-body p-lg-5 p-4 w-100 border-0 ">
                <div class="row justify-content-center">
                    <div class="col-lg-4 text-center">
                        <figure class="avatar ms-auto me-auto mb-0 mt-2 w100"><img src="{{asset('storage/'.@$auth_user->image)}}" alt="image" class="shadow-sm rounded-3 ml-4 w-100"></figure></div></div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 text-center mr-4">
                        <h2 class="fw-700 font-sm text-grey-900 mt-3">{{@$auth_user->name}}</h2>
                        <h4 class="text-grey-500 fw-500 mb-3 font-xsss mb-4" >{{@$auth_user->favorite_genres}}</h4>

                    </div>
                </div>
                <form action="{{route('updateUserProfile')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="auth_user_uuid" value="{{@$auth_user->uuid}}">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="form-group">
                                <label class="mont-font fw-600 font-xsss">Name</label>
                                <input type="text" class="form-control" name="name" value="{{@$auth_user->name}}">
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-group">
                                <label class="mont-font fw-600 font-xsss">Email</label>
                                <input type="email" class="form-control" name="email" value="{{@$auth_user->email}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="form-group">
                                <label class="mont-font fw-600 font-xsss">Phone</label>
                                <input type="text" class="form-control" name="contact_no" value="{{@$auth_user->contact_no}}">
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-group">
                                <label class="mont-font fw-600 font-xsss">Genres</label>

                                <select name="favorite_genres" class="form-control">
                                  <option selected disabled>Select Favourite Genres</option>
                              @if(sizeof($genres)>0)
                                      @foreach($genres as $g => $g_row)
                                    <option @if($g_row->genres == $auth_user->favorite_genres) selected @endif value="{{$g_row->genres}}">{{@$g_row->genres}}</option>
                                      @endforeach
                                  @endif
                              </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-12 mb-3">
                            <div class="card mt-3 border-0">
                                <div class="card-body d-flex justify-content-between align-items-end p-0">
                                    <div class="form-group mb-0 w-100">
                                        <input type="file" name="file" id="file" class="input-file">
                                        <label for="file" class="rounded-3 text-center bg-white btn-tertiary js-labelFile p-4 w-100 border-dashed">
                                            <i class="fas fa-cloud-download-alt large-icon me-3 d-block"></i>
                                            <span class="js-fileName"> Click to replace profile picture</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="mont-font fw-600 font-xsss">Description</label>
                            <textarea name="bio" class="form-control mb-0 p-3 h100 bg-greylight lh-16" rows="5" placeholder="Write your message..." spellcheck="false">{{@$auth_user->bio}}</textarea>
                        </div>
                        <div class="col-lg-12">
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
