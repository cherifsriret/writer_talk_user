
@extends('layouts.main')
@section('title')
    Home
@endsection
@push('style')
    <style>
        .show-read-more .more-text{
            display: none;
        }

    </style>
@endpush
@section('content')
    <div class="w-2 d-none">
    </div>
    <div class="w-40 mx-auto pt-5">

        <!-- body -->

        <div class="home-demo pt-2 pb-1 mt-1">
            <div class="row mb-2">
                <div class="large-12 columns">
                    <div class="d-flex float right">
                        <!-- search box -->
                        <div class="search-box mr-2">
                            <button type="button" class="btn btn-light search-icon mb-0" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-search"></i>
                                {{-- <i class="fas fa-user-tie"></i> --}}
                            </button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                            <div class="modal-dialog  modal-dialog-centered" role="document">
                                <div class="modal-content m-5">

                                    <div class="modal-body w-100">
                                        <div class="">
                                            <button type="button" class="close closing-popup" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="text-center select-btns-search">
                                            <h2 class="font-weight-bold mb-3 p-0 text-dark" style="font-style: normal;">Search Type</h2>

                                            <button class="choose-search mb-0">Search 1</button>
                                            <button class="choose-search mb-0">Search 1</button>
                                            <button class="choose-search mb-0">Search 1</button>
                                        </div>
                                        <div class="select-input-seach">
                                            <h2 class="font-weight-bold mb-2 p-0 text-dark" style="font-style: normal;">HASHTAGS</h2>
                                            <form class="form-inline my-2 w-50">
                                                <i class="fas fa-search search-icon"></i>
                                                <input type="text" placeholder="Start typing to search.." class="w-100 search-box pt-2 pb-2">
                                            </form>

                                            <p class="p-2">#Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag
                                                #tag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag </p>
                                            <p class="p-2">#Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag
                                                #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag
                                                #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag
                                                #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag
                                                #tag #Hashtag #Hashtag #Hashtag #Hashtag #Hashtag </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- create post -->
                        <div class="craete-new-post mr-2">
                            <button type="button" class="btn btn-primary btn-new-post mb-0 p-0 pl-1" data-toggle="modal" data-target="#exampleModal1">
                                <i class="fas fa-edit"></i>
                            </button>


                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">

                                        <div class="modal-body p-0">

                                            <div class="card w-100 py-4 shadow-xss rounded-xxl border-0 ps-4 pt-3 pe-4 pb-3">
                                                <div class="">
                                                    <button type="button" class="close closing-popup" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form method="POST" action="{{route('submitUserPost')}}" id="addPostForm" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="file_type" id="FileExtension" value="">
                                                    <div class="card-body p-0 mt-0 position-relative">
                                                        <figure class="avatar position-absolute ml-2 mt-2 pt-1 pb-0 mb-0 top-5"><img src="{{asset('assets/imgs/2.jpg')}}" alt="image" class="shadow-sm rounded-circle w30"></figure>
                                                        {{-- <figure class="avatar position-absolute ml-2 mt-2 pt-1 top-5"><img src="{{asset('storage/'.\Illuminate\Support\Facades\Auth::user()->image)}}" alt="image" class="shadow-sm rounded-circle w30"></figure> --}}
                                                        <textarea name="description" id="postDescription" class="h100 bor-0 mb-0 mt-1 w-100 rounded-xxl p-2 pl-5 font-xssss text-grey-500 fw-500 border-light-md theme-dark-bg" cols="30" rows="10" placeholder="What's on your mind?"></textarea>
                                                    </div>
                                                    <div class="validate-msg-div" style="display: none">
                                                        <p class="text-danger pl-1 validate-msg" style="font-size: 12px; font-weight: bold">Select/Write some stuff to add post</p>
                                                    </div>
                                                    <div class="upload-vid-img"></div>
                                                    <div class="card-body d-flex p-0 mt-2">
                                                        <div class="pl-2 pt-2 pointer" >
                                                            <a href="#" class="p-rel d-flex align-items-center font-xssss fw-600 ls-1 text-grey-700 text-dark pe-4" >
                                                                <i class="far fa-file-image font-md text-success feather-image me-2"></i>
                                                                <span class="d-none-xs">Photo/Video</span>
                                                            </a>
                                                            <input type="file" name="post_file" class="mb-0 input-vid-img post_file" accept=".jpg,.jpeg.,.gif,.png,.mov,.mp4,.x-m4v" onchange="readFile(this)" />

                                                        </div>


                                                        <div class="ms-auto">
                                                            <input type="button" class="d-flex btn btn-primary btn-sm float-right" id="addPostBtn" value="Add Post">
                                                        </div>
                                                    </div>


                                                </form>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row bg-light pt-2 pb-1">
                <div class="large-12 columns ">
                    <input type="hidden" name="user_stories" id="userStoriesArr" value="{{json_encode([$user_stories])}}">

                    <div class="owl-carousel owl-carousel-tips">


                        {{--                        <div class="item">--}}
                        {{--                              <div class=" h200 d-block border-0 shadow-none rounded-xxxl bg-dark">--}}
                        {{--                                    <div class="story-profile">--}}
                        {{--                                        <a href="#">--}}
                        {{--                                            <span class="btn-round1 bg-white"><i class="fas fa-plus font-lg"></i></span>--}}
                        {{--                                            <div class="clearfix"></div>--}}
                        {{--                                        </a>--}}
                        {{--                                        <p class="add" style="font-size: 13px; padding-top: 5px;">Add Story</p>--}}
                        {{--                                        <input class="upload-story" name="story_file" id="userAddStory" type="file" onchange="add_story(this)">--}}
                        {{--                                    </div>--}}
                        {{--                              </div>--}}
                        {{--                        </div>--}}


                        <div class="item p-1">

                            <div class="py-3 d-block border-grey shadow-none rounded-xxxl p-rel">
                                <div class="text-center">
                                    <a href="#">
                                        <span class="text-dark"><i class="fas fa-plus font-sm" style="padding: 4px;"></i></span>
                                        {{-- <div class="clearfix"></div> --}}
                                    </a>
                                    <input class="upload-story mb-0" name="story_file" id="userAddStory" type="file" onchange="add_story(this)">
                                    {{-- <input class="upload-story" type="file"> --}}
                                </div>
                            </div>
                            <div class="story-profile">
                                <p class="add fw-700 text-center" >New Tips</p>
                            </div>

                        </div>


                        {{--                        @if(sizeof($user_stories) > 0)--}}

                        {{--                        @foreach($user_stories as $us=> $us_row)--}}

                        <div class="item">
                            <div class=""  data-toggle="modal" data-target="#exampleModal4">

                                {{--                                    @if($us_row->file_type == 'image')--}}
                                <img class="single-story" src="{{asset('storage/assets/imgs/download.jpg')}}">
                                {{--                                        <img class="single-story" src="{{asset('storage/'.$us_row->post->file)}}">--}}
                                {{--                                        @endif--}}
                                {{--                                        @if($us_row->file_type == 'video')--}}
                                <video class="single-story" muted style="height: 68px">
                                    <source src="{{asset('storage/assets/imgs/dummy_video.mp4')}}">
                                    {{--                                                 <source  src="{{asset('storage/'.$us_row->post->file)}}">--}}

                                </video>
                                {{--                                        @endif--}}
                            </div>
                            <div class="story-profile">
                                {{-- <img class="" src="http://127.0.0.1:8000/assets/imgs/2.jpg"> --}}
                                {{-- <img class="" src="{{asset('storage/'.@$us_row->user->image)}}"> --}}
                                <p class="text-truncate">Zeeshan Mughal</p>
                                {{--                                        <p class="text-truncate">{{ucfirst(@$us_row->user->name)}}</p>--}}
                            </div>
                        </div>
                        <!-- Button trigger modal -->
                        {{--                            @endforeach--}}
                        {{--                        @endif--}}

                        @if(sizeof($admin_stories) > 0)
                            @foreach($admin_stories as $as=> $as_row)
                                <div class="item">
                                    @if($as_row->file_type == 'image')

                                        <img class="single-story" src="http://127.0.0.1:8000/assets/imgs/2.jpg" >
                                        {{-- <img class="single-story" src="{{$admin.'storage/'.$as_row->file}}"> --}}
                                    @endif
                                    @if($as_row->file_type == 'video')

                                        <video class="single-story" muted >

                                            <source src="{{$admin.'storage/'.$as_row->file}}">
                                        </video>
                                    @endif
                                    <div class="story-profile">
                                        {{-- <img class="" src="http://127.0.0.1:8000/assets/imgs/2.jpg"> --}}
                                        {{-- <img class="" src="{{$admin.'storage/assets/logo.jpeg'}}"> --}}
                                        <p class="text-truncate">{{ucfirst(@$as_row->user->name)}}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if(sizeof($today_stories) > 0)
                            @foreach($today_stories as $ts=> $td_row)
                                <div class="item">
                                    @if($td_row->file_type == 'image')
                                        <div class=""  data-toggle="modal" data-target="#exampleModal4">
                                            <img class="single-story" src="{{$admin.'storage/'.$td_row->file}}">
                                            @endif
                                            @if($td_row->file_type == 'video')
                                                <video class="single-story" muted >
                                                    <source src="{{$admin.'storage/'.$td_row->file}}">
                                                </video>
                                            @endif
                                        </div>
                                        <div class="story-profile">
                                            {{-- <img class="" src="{{$admin.'storage/'.@$td_row->user->image}}"> --}}
                                            <p>{{ucfirst(@$td_row->user->name)}}</p>
                                        </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </div>



        @if(sizeof($posts) > 0)
            <input type="hidden" name="user_posts" id="userPostsArr" value="{{json_encode($posts)}}">
            <input type="hidden" name="user_id" id="userId" value="{{\Illuminate\Support\Facades\Auth::user()->uuid}}">
            @foreach($posts as $p => $p_row)
                <div class="card w-100 p-3 mb-0 mt-2 display_posts border-clr">
                    <div class="media mb-2">
                        <img class="mr-3 tip-profile rounded-circle" src="{{asset('assets/imgs/2.jpg')}}" alt="img">
                        <div class="media-body line-height-6 pt-1">
                            <h5 class="mt-0 font-weight-bold">{{@$p_row->user->name}}</h5>
                            <span class="post-time">{{@$p_row->created_at->diffForHumans()}}</span>

                        </div>
                        <a href="javascript:void(0)" class="ms-auto " id="shareStoryPostBtn" post_id="{{@$p_row->uuid}}" post_type="{{@$p_row->post_type}}" file_type="{{@$p_row->file_type}}"><i class="fas fa-share-alt text-grey-900 text-dark btn-round-sm"></i>
                            <span class="d-none-xs">Share as Story</span>
                        </a>
                    </div>
                    {{-- <img class="tip-post py-3" src="{{asset('assets/imgs/building2.jpg')}}" alt="Generic placeholder image"> --}}
                    {{--            <div class="card-body p-0 d-flex">

                            <a href="{{route('userProfile',['id'=> $p_row->user->uuid])}}">
                            <figure class="avatar me-3 m-0"><img src="{{asset('storage/'.$p_row->user->image)}}" alt="image" class="shadow-sm rounded-circle w45"></figure>
                            <h4 class="fw-700 text-grey-900 font-xssss mt-1 ml-2">{{@$p_row->user->name}}
                            </a>
                            <span class="d-block font-xssss fw-500 mt-1 lh-3 text-grey-500">{{(@$p_row->created_at)->diffForHumans()}}</span></h4>
                           <a href="#" class="ms-auto"><i class="far fa-bookmark text-grey-900  bg-greylight font-xss"></i></a>
                        </div>--}}
                    @if($p_row->description)
                        <div class="card-body p-0 me-lg-5">
                            <p class="fw-500 text-grey-500 lh-26 font-xssss w-100 show-read-more">{{@$p_row->description}}

                            </p>
                        </div>
                    @endif

                    @if($p_row->file)
                        @if($p_row->file_type == 'image')
                            <div class="card-body p-0 mb-3 mt-2 rounded-3 overflow-hidden">
                                <img src="{{asset('storage/'.$p_row->file)}}" class="float-right w-100" alt="">
                            </div>
                        @endif
                        @if($p_row->file_type == 'video')
                            <div class="card-body p-0 mb-3 mt-2 rounded-3 overflow-hidden">
                                <video autoplay="" loop="" class="float-right w-100" controls muted>
                                    <source src="{{asset('storage/'.$p_row->file)}}" type="video/mp4">
                                </video>
                            </div>
                        @endif

                    @endif
                    {{--
                    <div class="card-body d-flex p-0">
                        <a href="javascript:void(0)" class="d-flex align-items-center fw-600 text-grey-900 text-dark lh-26 font-xssss me-2 like_box" id="postLikeCount">
                            @if(@$p_row->is_like)
                                <i class="far fa-heart text-white bg-red-gradiant me-2 btn-round-xs font-xss post_like" postIndex="{{$p}}" ></i>
                            @else
                                <i class="far fa-heart text-white bg-primary-gradiant me-2 btn-round-xs font-xss post_like" postIndex="{{$p}}"></i>
                            @endif
                            <span class="like_count_val">{{$p_row->likes_count}} </span>   Like
                        </a>
                        <a href="#" class="d-flex align-items-center fw-600 text-grey-900 text-dark font-xssss"><i class="far fa-comment text-dark text-grey-900 btn-round-sm"></i><span class="d-none-xss">{{$p_row->comments_count}} Comment</span></a>

                        @if(@$p_row->file)
                            <a href="javascript:void(0)" class="ms-auto d-flex align-items-center fw-600 text-grey-900 text-dark font-xssss" id="shareStoryPostBtn" post_id="{{@$p_row->uuid}}" post_type="{{@$p_row->post_type}}" file_type="{{@$p_row->file_type}}">
                                <i class="fas fa-share-alt text-grey-900 text-dark btn-round-sm"></i>
                                <span class="d-none-xs">Share as Story</span>
                            </a>
                        @endif
                    </div>

                        <a href="javascript:void(0)" class="ms-auto d-flex align-items-center fw-600 text-grey-900 text-dark font-xssss" id="shareStoryPostBtn" post_id="{{@$p_row->uuid}}" post_type="{{@$p_row->post_type}}" file_type="{{@$p_row->file_type}}">
                            <i class="fas fa-share-alt text-grey-900 text-dark btn-round-sm"></i>
                            <span class="d-none-xs">Share as Story</span>
                        </a>
                    </div>--}}
                    <div class="card-body d-flex p-0">
                        <a href="javascript:void(0)" class=" px-1 d-flex align-items-center fw-600 text-grey-900 text-dark font-xssss like_box" id="postLikeCount">
                            @if(@$p_row->is_like)
                                <i class="fas fa-heart text-danger text-danger-900 f-21 mr-2 post_like" postIndex="{{$p}}"></i>
                            @else
                                <i class="far fa-heart text-dark text-grey-900 f-21 mr-2 post_like" postIndex="{{$p}}"></i>

                            @endif
                            <span class="d-none-xss">{{@$p_row->likes_count}} </span>
                        </a>

                        <a href="#" class="d-flex align-items-center fw-600 text-grey-900 text-dark font-xssss">
                            <i class="far fa-comment text-dark text-grey-900 btn-round-sm"></i>
                            <span class="d-none-xss">{{@$p_row->comment_count}} </span>
                        </a>
                    </div>
                    <hr class="my-2">

                    <div class="Comment-box l">

                        <div class="comments d-inline-flex">
                            <i class="fas fa-arrow-left mr-3 pt-1"></i>
                            <h3 class="ml-3">Comments</h3>
                        </div>
                    <<<<<<< HEAD
                    <<<<<<< HEAD
                                   <div class="user_comment_container">
                                       <div>
                                           @if(@$p_row->latest_comment)

                                               <div class="Comment-user pt-1 ">
                                                   <figure class="avatar">
                                                       <img src="{{asset('storage/'.$p_row->latest_comment->user->image)}}" alt="image">
                                                   </figure>
                                                   <div>
                                                       <div class="w-50">
                                                           <div class="Comment-wrap">
                                                               <p class="heading">{{$p_row->latest_comment->user->name}}</p>
                                                               <p class="comment">{{$p_row->latest_comment->comment}}</p>
                                                           </div>
                                                       </div>
                                                       <div class="reply-back d-flex mt-1 sub-comments">
                                                           <div class="time">{{$p_row->latest_comment->created_at->diffForHumans()}}</div>
                                                                                                   <div class="Like">Like </div>
                                                           <div class="Reply main_comment_reply_btn"  user_id="{{$p_row->latest_comment->user->uuid}}" post_id="{{@$p_row->uuid}}" comment_id="{{@$p_row->latest_comment->uuid}}" post_type="{{@$p_row->post_type}}" postIndex="{{$p}}">Reply </div>

                                                       </div>
                                                   </div>
                                               </div>
                                           @endif
                                               <div class="View-more-reply">



                                               @if(sizeof(@$p_row->latest_comment->comment_replies) > 0)
                                                       @foreach(@$p_row->latest_comment->comment_replies as $cr => $cr_row)

                                                           <div class="Comment-user pt-1 user_reply_container">
                                                               <figure class="avatar">
                                                                   <img src="{{asset('storage/'.@$cr_row->comment_reply_user->image)}}" class="more-reply-image" alt="image">
                                                               </figure>
                                                               <div>
                                                                   <div class="w-50">
                                                                       <div class="Comment-wrap" id="view-more-reply">
                                                                           <p class="heading">{{@$cr_row->comment_reply_user->name}}</p>
                                                                           <p class="comment">{{@$cr_row->comment}}</p>
                                                                       </div>
                                                                   </div>
                                                                   <div class="reply-back d-flex mt-1 sub-comments">
                                                                       <div class="time" id="time-ago">{{@$cr_row->created_at->diffForHumans()}}</div>
{{--                                                                                                           <div class="Like">Like </div>--}}
                                                                       <div class="Reply reply_btn" post_id="{{@$p_row->uuid}}" post_type="{{@$p_row->post_type}}" postIndex="{{$p}}">Reply </div>

                                                                   </div>
                                                               </div>
                                                           </div>
                                                       @endforeach

                                               @endif
                                           @endif
                                               </div>

                                       </div>

                                   </div>


                                   <div class="chat-bottom py-3 ml-5 shadow-none w-95 reply_input_div" style="display: none">
                                       <form class="chat-form">
                                           <div class="Comment-user">


                                           </div>
                                           <div class="form-group">
                                               <input type="text" name="reply_text" class="mb-0 reply_text_input" placeholder="Write a reply..." post_id="{{@$p_row->uuid}}"  post_type="{{@$p_row->post_type}}" postIndex="{{$p}}">
                                           </div>
                                           <div class="bg-arrow">
                                               <i class="fas fa-arrow-right right-icon reply_comment_btn" >
                                               </i>
                                           </div>
                                       </form>
                                   </div>

                                    <div class="chat-bottom py-3 shadow-none w-100 comment_input_div" >
                    =======
                                <div class="scroll-bar1" id="thumb-scroll">
                                               <div class="Comment-user pt-1">
                                                        <figure class="avatar">
                                                            <img src="assets/imgs/2.jpg" alt="image">
                                                        </figure>
                                                        <div>
                                                            <div class="w-50">
                                                            <div class="Comment-wrap">
                                                                <p class="heading">Heer E Bismil</p>
                                                                <p class="comment">Kambli Heer Where are you?</p>
                                                            </div>
                                                            </div>
                                                            <div class="reply-back d-flex mt-1 sub-comments">
                                                            <div class="time">18 sec ago</div>
                                                            <div class="Like">Like </div>
                                                            <div class="Reply">Reply </div>
                    =======







                    <!-- Button trigger modal -->
                        <div>
                            <button type="button" class="btn btn-light d-block comment-btn" data-toggle="modal" data-target=".bd-example-modal-lg">
                                View all comments
                            </button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">

                                    <div class="modal-body m-0 p-0 w-100" style="height:500px;">
                                        <div class="w-100">
                                            <button type="button" class="close closing-popup" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                            <div class="row">
                                                <div class="col-6 m-0 p-0">
                                                    <img class="sky-view"  src="{{asset('assets/imgs/sea1.jpg')}}" >
                                                </div>
                                                <div class="col-6 ">
                                                    <div class="chat-name">
                                                        <div class="media">
                                                            <img class="mr-2 comment-user-name" src="{{asset('assets/imgs/sky3.jpg')}}" alt="Generic placeholder image">
                                                            <div class="media-body">
                                                                <h5 class="mt-0 main-name p-2">lambasics . following</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="scroll-bar3" id="thumb-scroll">
                                                        <div class="Comment-user pt-1">
                                                            <figure class="avatar">
                                                                <img src="assets/imgs/2.jpg" alt="image">
                                                            </figure>
                                                            <div>
                                                                <div class="w-50">
                                                                    <div class="Comment-wrap">
                                                                        <p class="heading">Heer E Bismil</p>
                                                                        <p class="comment">Kambli Heer Where are you?</p>
                                                                    </div>
                                                                </div>
                                                                <div class="reply-back d-flex mt-1 sub-comments">
                                                                    <div class="time">18 sec ago</div>
                                                                    <div class="Like">Like </div>
                                                                    <div class="Reply">Reply </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="Comment-user pt-1">
                                                            <figure class="avatar">
                                                                <img src="assets/imgs/7.jpg" alt="image">
                                                            </figure>
                                                            <div>
                                                                <div class="w-50">
                                                                    <div class="Comment-wrap">
                                                                        <p class="heading">Anthony Daugloi</p>
                                                                        <p class="comment">How can I help you?</p>
                                                                    </div>
                                                                </div>
                                                                <div class="reply-back d-flex mt-1 sub-comments">
                                                                    <div class="time">18 h</div>
                                                                    <div class="Like">Like </div>
                                                                    <div class="Reply">Reply </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="View-more-reply">

                                                            <div class="Comment-user pt-1">
                                                                <figure class="avatar">
                                                                    <img src="assets/imgs/3.jpg" class="more-reply-image" alt="image">
                                                                </figure>
                                                                <div>
                                                                    <div class="w-50">
                                                                        <div class="Comment-wrap" id="view-more-reply">
                                                                            <p class="heading">Esha Rani</p>
                                                                            <p class="comment">here and u?</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reply-back d-flex mt-1 sub-comments">
                                                                        <div class="time" id="time-ago">7:25 PM</div>
                                                                        <div class="Like">Like </div>
                                                                        <div class="Reply">Reply </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="Comment-user pt-1">
                                                                <figure class="avatar">
                                                                    <img src="assets/imgs/2.jpg" class="more-reply-image" alt="image">
                                                                </figure>
                                                                <div>
                                                                    <div class="w-50">
                                                                        <div class="Comment-wrap" id="view-more-reply">
                                                                            <p class="heading">Heer E Bismil</p>
                                                                            <p class="comment">Are you ok?</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reply-back d-flex mt-1 sub-comments">
                                                                        <div class="time" id="time-ago">7:26PM</div>
                                                                        <div class="Like">Like </div>
                                                                        <div class="Reply">Reply </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="Comment-user pt-1">
                                                                <figure class="avatar">
                                                                    <img src="assets/imgs/3.jpg" class="more-reply-image" alt="image">
                                                                </figure>
                                                                <div>
                                                                    <div class="w-50">
                                                                        <div class="Comment-wrap" id="view-more-reply">
                                                                            <p class="heading">Esha Rani</p>
                                                                            <p class="comment">Yes fine!</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reply-back d-flex mt-1 sub-comments">
                                                                        <div class="time" id="time-ago">7:26PM</div>
                                                                        <div class="Like">Like </div>
                                                                        <div class="Reply">Reply </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="Comment-user pt-1">
                                                            <figure class="avatar">
                                                                <img src="assets/imgs/7.jpg" alt="image">
                                                            </figure>
                                                            <div>
                                                                <div class="w-50">
                                                                    <div class="Comment-wrap">
                                                                        <p class="heading">Anthony Daugloi</p>
                                                                        <p class="comment">How can I help you?</p>
                                                                    </div>
                                                                </div>
                                                                <div class="reply-back d-flex mt-1 sub-comments">
                                                                    <div class="time">18 h</div>
                                                                    <div class="Like">Like </div>
                                                                    <div class="Reply">Reply </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body d-flex pt-2 ml-0 pl-0 reaction">
                                                        <a href="#" class=" px-1 d-flex align-items-center fw-600 text-grey-900 text-dark font-xssss"><i class="far fa-heart text-dark text-grey-900 f-21 mr-2"></i></a>
                                                        <a href="#" class="d-flex align-items-center fw-600 text-grey-900 text-dark font-xssss"><i class="far fa-comment text-dark text-grey-900 btn-round-sm"></i></a>
                                                        <a href="#" class="ms-auto mr-2 d-flex align-items-center fw-600 text-grey-900 text-dark font-xssss"><i class="far fa-bookmark text-grey-900  font"></i></a>

                                                    </div>
                                                    <div class="d-block pt-0 ">
                                                        <h5 class="total-likes">570 likes </h5>
                                                        <h5 class="hours-ago pt-1">3 HOURS AGO  </h5>
                                                    </div>
                                                    <div class="chat-bottom py-3 pt-0 shadow-none w-100" >
                                                        <form class="chat-form">
                                                            <div class="form-group"><input type="text" class="mb-0" style="background-color:white!important;" placeholder="Add a comment..."></div>
                                                            <div class="bg-arrow"><i class="fas fa-arrow-right right-icon"></i></div>
                                                        </form>
                                                    </div>










                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>









                        <div class="scroll-bar1" id="thumb-scroll">
                            <div class="Comment-user pt-1">
                                <figure class="avatar">
                                    <img src="assets/imgs/2.jpg" alt="image">
                                </figure>
                                <div>
                                    <div class="w-50">
                                        <div class="Comment-wrap">
                                            <p class="heading">Heer E Bismil</p>
                                            <p class="comment">Kambli Heer Where are you?</p>
                                        </div>
                                    </div>
                                    <div class="reply-back d-flex mt-1 sub-comments">
                                        <div class="time">18 sec ago</div>
                                        <div class="Like">Like </div>
                                        <div class="Reply">Reply </div>

                                        {{-->>>>>>> d9bfbb87ee0167cf25253d3c476e2b8bd2287317--}}

                                        {{--                                    </div>--}}
                                        {{--                                 </div>--}}
                                        {{--                </div>--}}
                                        {{--                <div class="View-more-reply">--}}

                                        {{--                            <div class="Comment-user pt-1">--}}
                                        {{--                                <figure class="avatar">--}}
                                        {{--                                    <img src="assets/imgs/3.jpg" class="more-reply-image" alt="image">--}}
                                        {{--                                </figure>--}}
                                        {{--                                <div>--}}
                                        {{--                                    <div class="w-50">--}}
                                        {{--                                    <div class="Comment-wrap" id="view-more-reply">--}}
                                        {{--                                        <p class="heading">Esha Rani</p>--}}
                                        {{--                                        <p class="comment">here and u?</p>--}}
                                        {{--                                    </div>--}}
                                        {{--                                    </div>--}}
                                        {{--                                    <div class="reply-back d-flex mt-1 sub-comments">--}}
                                        {{--                                    <div class="time" id="time-ago">7:25 PM</div>--}}
                                        {{--                                    <div class="Like">Like </div>--}}
                                        {{--                                    <div class="Reply">Reply </div>--}}

                                        {{--                                </div>--}}
                                        {{--                                </div>--}}
                                        {{--                            </div>--}}
                                        {{--                            <div class="Comment-user pt-1">--}}
                                        {{--                                <figure class="avatar">--}}
                                        {{--                                    <img src="assets/imgs/2.jpg" class="more-reply-image" alt="image">--}}
                                        {{--                                </figure>--}}
                                        {{--                                <div>--}}
                                        {{--                                    <div class="w-50">--}}
                                        {{--                                    <div class="Comment-wrap" id="view-more-reply">--}}
                                        {{--                                        <p class="heading">Heer E Bismil</p>--}}
                                        {{--                                        <p class="comment">Are you ok?</p>--}}
                                        {{--                                    </div>--}}
                                        {{--                                    </div>--}}
                                        {{--                                    <div class="reply-back d-flex mt-1 sub-comments">--}}
                                        {{--                                    <div class="time" id="time-ago">7:26PM</div>--}}
                                        {{--                                    <div class="Like">Like </div>--}}
                                        {{--                                    <div class="Reply">Reply </div>--}}

                                        {{--                                </div>--}}
                                        {{--                                </div>--}}
                                        {{--                            </div>--}}
                                        {{--                            <div class="Comment-user pt-1">--}}
                                        {{--                                <figure class="avatar">--}}
                                        {{--                                    <img src="assets/imgs/3.jpg" class="more-reply-image" alt="image">--}}
                                        {{--                                </figure>--}}
                                        {{--                                <div>--}}
                                        {{--                                    <div class="w-50">--}}
                                        {{--                                    <div class="Comment-wrap" id="view-more-reply">--}}
                                        {{--                                        <p class="heading">Esha Rani</p>--}}
                                        {{--                                        <p class="comment">Yes fine!</p>--}}
                                        {{--                                    </div>--}}
                                        {{--                                    </div>--}}
                                        {{--                                    <div class="reply-back d-flex mt-1 sub-comments">--}}
                                        {{--                                    <div class="time" id="time-ago">7:26PM</div>--}}
                                        {{--                                    <div class="Like">Like </div>--}}
                                        {{--                                    <div class="Reply">Reply </div>--}}

                                        {{--                                </div>--}}
                                        {{--                                </div>--}}
                                        {{--                            </div>--}}
                                        {{--                </div>--}}
                                        {{--                <div class="Comment-user pt-1">--}}
                                        {{--                            <figure class="avatar">--}}
                                        {{--                                <img src="assets/imgs/7.jpg" alt="image">--}}
                                        {{--                            </figure>--}}
                                        {{--                            <div>--}}
                                        {{--                                <div class="w-50">--}}
                                        {{--                                <div class="Comment-wrap">--}}
                                        {{--                                    <p class="heading">Anthony Daugloi</p>--}}
                                        {{--                                    <p class="comment">How can I help you?</p>--}}
                                        {{--                                </div>--}}
                                        {{--                                </div>--}}
                                        {{--                                <div class="reply-back d-flex mt-1 sub-comments">--}}
                                        {{--                                <div class="time">18 h</div>--}}
                                        {{--                                <div class="Like">Like </div>--}}
                                        {{--                                <div class="Reply">Reply </div>--}}

                                        {{--                            </div>--}}
                                        {{--                      </div>--}}
                                        {{--                </div>--}}
                                        {{--            </div>--}}
                                        {{--                <div class="chat-bottom py-3 shadow-none w-100" >--}}
                                        {{-->>>>>>> c0092217733b6b154bedfb3bf686f36d9460cb8a--}}
                                        <form class="chat-form">
                                            <div class="Comment-user">
                                                {{--                                <figure class="avatar">--}}
                                                {{--                                    <img src="assets/imgs/9.jpg" alt="image">--}}
                                                {{--                                </figure>--}}

                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="comment_text" class="mb-0 comment_text_input" placeholder="Write a comment..." post_id="{{@$p_row->uuid}}"  post_type="{{@$p_row->post_type}}" postIndex="{{$p}}">
                                            </div>
                                            <div class="bg-arrow">
                                                <i class="fas fa-arrow-right right-icon add_comment_btn" >
                                                </i>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                            </div>



                            @endforeach
                            @else
                                <div class="card w-100 shadow-xss rounded-xxl border-0 p-4 mb-0 mt-2 display_posts  mb-5">
                                    <div class="card-body p-0 d-flex">

                                        <h5 class="font-weight-bold">Welcome to Writers Talk</h5>
                                    </div>
                                    <div class="card-body p-0 d-flex">
                                        <p>When you add penpals, you'll se the photos and videos they post here</p>
                                    </div>
                                    <a href="{{route('userFindPenpals')}}" class="btn btn-info ml-5 mr-5">Find Writers</a>
                                </div>
                            @endif

                        </div>


                    </div>
                    <div class="w-4 d-none">
                        <nav class="navigation">
                            <div class="nav-content ml-2">
                                <div class="Friend-request">
                                    <div class="card w-100 shadow-xss rounded-xxl border-0 mb-3 mt-2 friend-request-container">
                                        <div class="card-body d-flex align-items-center p-3">
                                            <h4 class="fw-700 mb-0 font-xssss text-grey-900">Friend Request</h4>
                                            <a href="#" class="fw-600 ms-auto font-xssss text-primary">See all</a>
                                        </div>
                                        @if(sizeof($auth_user_request) > 0)
                                            <input type="hidden" name="penpals_request_arr" id="penpalRequestArr" value="{{json_encode($auth_user_request)}}">
                                            @foreach($auth_user_request as $ar => $ar_row)
                                                <div class="penpal-remove-div">
                                                    <div class="card-body d-flex pt-4 ps-4 pe-4 pb-0 border-top-xs bor-0  ">
                                                        <a href="{{route('userProfile',['id'=> $ar_row->user->uuid])}}">
                                                            <figure class="avatar me-3"><img src="{{asset('storage/'.@$ar_row->user->image)}}" alt="image" class="shadow-sm rounded-circle w45"></figure>
                                                            <h4 class="fw-700 text-grey-900 font-xssss mt-1">{{@$ar_row->user->name}}<span class="d-block font-xssss fw-500 mt-1 lh-3 text-grey-500">
            {{--                                    12 mutual friends--}}
                                            </span>
                                                            </h4>
                                                        </a>
                                                    </div>
                                                    <div class="card-body d-flex align-items-center pt-0 ps-4 pe-4 pb-4 ">
                                                        <a href="javascript:void(0)" class="p-2 pl-3 pr-3 mr-2 lh-20 w100 bg-primary-gradiant me-2 text-white text-center font-xssss fw-600 ls-1 rounded-xl penpal-request-action-btn" penpal_uuid="{{@$ar_row->uuid}}"  request_for="Accept" penpal_index="{{$ar}}">
                                                            Confirm
                                                        </a>
                                                        <a href="javascript:void(0)" class="p-2 pl-3 pr-3 lh-20 w100 bg-grey text-grey-800 text-center font-xssss fw-600 ls-1 rounded-xl penpal-request-action-btn" penpal_uuid="{{@$ar_row->uuid}}"  request_for="Cancel" penpal_index="{{$ar}}">
                                                            Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card-body d-flex pt-4 ps-4 pe-4 pb-0 border-top-xs bor-0">
                                                {{--                                <figure class="avatar me-3"><img src="{{asset('storage/'.@$ar_row->user->image)}}" alt="image" class="shadow-sm rounded-circle w45"></figure>--}}
                                                <h4 class="fw-700 text-grey-900 font-xssss mt-1">No Requests
                                                    <span class="d-block font-xssss fw-500 mt-1 lh-3 text-grey-500">
{{--                                    12 mutual friends--}}
                                </span></h4>
                                            </div>
                                        @endif

                                    </div>

                                </div>
                                <div class="confirm-Friend">
                                    <div class="card w-100 shadow-xss rounded-xxl border-0 p-0 friend-card-container ">
                                        <div class="card-body d-flex align-items-center p-4 mb-0">
                                            <h4 class="fw-700 mb-0 font-xssss text-grey-900">Friends</h4>
                                            <a href="{{route('getUserPenpals')}}" class="fw-600 ms-auto font-xssss text-primary">See all</a>
                                        </div>
                                        @if(sizeof($auth_user_penpals)> 0)
                                            @foreach($auth_user_penpals as $p=> $p_row)

                                                <div class="card-body bg-transparent-card d-flex p-2 bg-greylight m-1 rounded-3">
                                                    <figure class="avatar mb-0">
                                                        <img @if($p_row->user->image)src="{{asset('storage/'.$p_row->user->image)}}"@else src="{{asset('storage/asset/imgs/user_avatar.png')}}" @endif alt="image" class="shadow-sm rounded-circle w45">
                                                    </figure>
                                                    <h4 class="fw-700 text-grey-900 font-xssss mt-2">{{$p_row->user->name}} <span class="d-block font-xssss fw-500 mt-1  text-grey-500">
{{--                                    12 mutual friends--}}
                                </span></h4>
                                                    {{--                            <a href="#" class="btn-round-sm bg-white text-grey-900 font-xss  mt-2"><i class="fas fa-chevron-right"></i></a>--}}
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card-body bg-transparent-card d-flex p-2 bg-greylight m-1 rounded-3">
                                                <h4 class="fw-700 text-grey-900 font-xssss mt-2">No Friends <span class="d-block font-xssss fw-500 mt-1  text-grey-500"></span></h4>
                                                {{--                                <a href="#" class="btn-round-sm bg-white text-grey-900 font-xss  mt-2"><i class="fas fa-chevron-right"></i></a>--}}
                                            </div>
                                        @endif
                                        {{--                        <div class="card-body bg-transparent-card d-flex p-2 bg-greylight m-1 rounded-3">--}}
                                        {{--                            <figure class="avatar mb-0"><img src="assets/imgs/2.jpg" alt="image" class="shadow-sm rounded-circle w45"></figure>--}}
                                        {{--                            <h4 class="fw-700 text-grey-900 font-xssss mt-2"> David Agfree  <span class="d-block font-xssss fw-500 mt-1 text-grey-500">12 mutual friends</span></h4>--}}
                                        {{--                            <a href="#" class="btn-round-sm bg-white text-grey-900 font-xss mt-2"><i class="fas fa-plus"></i></a>--}}
                                        {{--                        </div>--}}
                                        {{--                        <div class="card-body bg-transparent-card d-flex p-2 bg-greylight m-1 rounded-3">--}}
                                        {{--                            <figure class="avatar mb-0"><img src="assets/imgs/2.jpg" alt="image" class="shadow-sm rounded-circle w45"></figure>--}}
                                        {{--                            <h4 class="fw-700 text-grey-900 font-xssss mt-2">Hugury Daugloi <span class="d-block font-xssss fw-500 mt-1 text-grey-500">12 mutual friends</span></h4>--}}
                                        {{--                            <a href="#" class="btn-round-sm bg-white text-grey-900 font-xss mt-2"><i class="fas fa-plus"></i></a>--}}
                                        {{--                        </div>--}}

                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered  px-5" role="document">
                            <div class="modal-content px-3" style="background: transparent; border:0;">

                                <div class="modal-body p-0">
                                    <div class="" >
                                        <button type="button" style="z-index: 9" class="close closing-popup" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <section id="demos">
                                        <div class="row">
                                            <div class="large-12 columns p-0">
                                                <div class="owl-carousel owl-theme dot-style3 m-0">
                                                    <div class="item">
                                                        <img src="http://127.0.0.1:8000/storage/uploads/stories/post_37261636669137.jpg" alt="">
                                                    </div>
                                                    <div class="item">
                                                        <img src="http://127.0.0.1:8000/storage/uploads/stories/post_35561636676923.jpg" alt="">
                                                    </div>
                                                    <div class="item">
                                                        <img src="http://127.0.0.1:8000/storage/uploads/stories/post_80161636669120.jpg" alt="">
                                                    </div>
                                                    <div class="item">
                                                        <img src="http://127.0.0.1:8000/storage/uploads/stories/post_82601636669115.jpg" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-5 d-none" >
                    </div>
                    @include('partials.navigation_right')
                    @endsection
                    @push('js')
                        <script>
                            var owl = $('.owl-carousel.owl-carousel-tips');
                            owl.owlCarousel({
                                margin: 10,

                                loop: false,
                                responsive: {
                                    0: {
                                        items: 1
                                    },
                                    200: {
                                        items: 2
                                    },
                                    400: {
                                        items: 3
                                    },
                                    800: {
                                        items: 4
                                    },
                                    1000: {
                                        items: 7
                                    }
                                }
                            })
                        </script>
                        <script>
                            $(document).ready(function() {
                                //   var owl1 = $('.owl-carousel1');s
                                $('.owl-carousel').owlCarousel({
                                    items: 1,
                                    loop: true,
                                    dots:true,
                                    margin: 10,
                                    autoplay: true,
                                    autoplayTimeout: 3000,
                                    autoplayHoverPause: true
                                });
                                $('.play').on('click', function() {
                                    owl1.trigger('play.owl.autoplay', [1000])
                                })
                                $('.stop').on('click', function() {
                                    owl1.trigger('stop.owl.autoplay')
                                })
                            })
                        </script>

                        <!-- vendors -->
                        <script src="{{asset('assets/vendors/highlight.js')}}"></script>
                        <script src="{{asset('assets/js/app.js')}}"></script>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>


                        <script>
                            $(document).ready(function(){
                                $('#comment-click').click(function(){

                                    $('#contact-section').toggle()

                                });
                            });

                        </script>

                        <script>

                            $(document).on('click', '#addPostBtn', function (e){

                                e.preventDefault();
                                let description =   $('#postDescription').val()
                                let file = $('.post_file')[0].files[0];
                                console.log(file);
                                if (description || file){
                                    $('#addPostForm').submit();
                                }else{
                                    $('.validate-msg-div').show();
                                    $('.validate-msg').html('Select/Write some stuff to add post')

                                }
                            });
                        </script>
                        <script>
                            $(document).ready(function(){
                                var maxLength = 300;
                                $(".show-read-more").each(function(){
                                    var myStr = $(this).text();
                                    if($.trim(myStr).length > maxLength){
                                        var newStr = myStr.substring(0, maxLength);
                                        var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                                        $(this).empty().html(newStr);
                                        $(this).append(' <a href="javascript:void(0);" class="read-more">...read more</a>');
                                        $(this).append('<span class="more-text">' + removedStr + '</span>');
                                    }
                                });
                                $(".read-more").click(function(){
                                    $(this).siblings(".more-text").contents().unwrap();
                                    $(this).remove();
                                });
                            });
                        </script>
                        <script>
                            $(document).ready(function (){
                                videos = document.querySelectorAll("video");
                                for(video of videos) {
                                    video.pause();
                                }
                            })
                        </script>
                        <script>

                            $(document).on('click','.penpal-request-action-btn', function (e){
                                e.preventDefault();
                                var base_url = window.location.origin;
                                let toRemove =  $(this).closest(".penpal-remove-div");
                                let request_arr = $('#penpalRequestArr').val();
                                if (request_arr){
                                    JSON.parse(request_arr);
                                }
                                console.log(request_arr);

                                let request_index = $(this).attr('penpal_index')
                                console.log(request_index);
                                let request_for = $(this).attr('request_for')
                                console.log(request_for);

                                let penpal_uuid = $(this).attr('penpal_uuid')
                                var formData = {
                                    request_for : request_for,
                                    penpal_uuid: penpal_uuid,
                                    _token:$('meta[name="csrf-token"]').attr('content')
                                };
                                $.ajax({
                                    type: "POST",
                                    url:'{{route("updatePenpalStatus")}}',
                                    data: formData,
                                    success:function(data){
                                        console.log(data);

                                        let res = JSON.parse(data);
                                        console.log(res);

                                        if (res.success == true){
                                            if (res.data){
                                                $(toRemove).remove();
                                                var friendsFormData = {
                                                    // request_for : request_for,
                                                    // penpal_uuid: penpal_uuid,
                                                    _token:$('meta[name="csrf-token"]').attr('content')
                                                };
                                                $.ajax({
                                                    type: "POST",
                                                    url:'{{route("userPenpals")}}',
                                                    data: friendsFormData,
                                                    success: function (data){
                                                        console.log(data);
                                                        let res = JSON.parse(data)
                                                        console.log(res);
                                                        let html_body = '<div class="card-body d-flex align-items-center p-4 mb-0"> ' +
                                                            '<h4 class="fw-700 mb-0 font-xssss text-grey-900">Friends</h4> ' +
                                                            '<a href="" class="fw-600 ms-auto font-xssss text-primary">See all</a> ' +
                                                            '</div>';

                                                        $('.friend-card-container').html('');
                                                        if (res.data.length > 0){
                                                            $.map(res.data, function (val,index){
                                                                html_body += '<div class="card-body bg-transparent-card d-flex p-2 bg-greylight m-1 rounded-3"> ' +
                                                                    '<figure class="avatar mb-0">' +
                                                                    '<img src="'+base_url+'/storage/'+val.user.image+'" alt="image" class="shadow-sm rounded-circle w45">' +
                                                                    '</figure>'+
                                                                    '<h4 class="fw-700 text-grey-900 font-xssss mt-2">'+val.user.name+
                                                                    '<span class="d-block font-xssss fw-500 mt-1  text-grey-500"></span></h4></div>'
                                                            });
                                                        }else{
                                                            html_body += '<div class="card-body bg-transparent-card d-flex p-2 bg-greylight m-1 rounded-3">' +
                                                                '<h4 class="fw-700 text-grey-900 font-xssss mt-2">No Friends <span class="d-block font-xssss fw-500 mt-1  text-grey-500"></span></h4> ' +
                                                                '</div>';
                                                        }
                                                        $('.friend-card-container').append(html_body)
                                                    }
                                                });


                                            }
                                        }
                                    }
                                });
                            });
                        </script>

                        <script src="{{asset('assets/js/post.js')}}"></script>
                        <script>
                            document.getElementsByClassName('input-vid-img')[0].addEventListener('change', function(event) {

                                var file = event.target.files[0];
                                var fileReader = new FileReader();
                                if (file.type.match('image')) {
                                    fileReader.onload = function() {
                                        var img = document.createElement('img');
                                        img.src = fileReader.result;
                                        document.getElementsByClassName('upload-vid-img')[0].appendChild(img);
                                    };
                                    fileReader.readAsDataURL(file);
                                } else {
                                    fileReader.onload = function() {
                                        var blob = new Blob([fileReader.result], {type: file.type});
                                        var url = URL.createObjectURL(blob);
                                        var video = document.createElement('video');
                                        var timeupdate = function() {
                                            if (snapImage()) {
                                                video.removeEventListener('timeupdate', timeupdate);
                                                video.pause();
                                            }
                                        };
                                        video.addEventListener('loadeddata', function() {
                                            if (snapImage()) {
                                                video.removeEventListener('timeupdate', timeupdate);
                                            }
                                        });
                                        var snapImage = function() {
                                            var canvas = document.createElement('canvas');
                                            canvas.width = video.videoWidth;
                                            canvas.height = video.videoHeight;
                                            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                                            var image = canvas.toDataURL();
                                            var success = image.length > 100000;
                                            if (success) {
                                                var img = document.createElement('img');
                                                img.src = image;
                                                document.getElementsByClassName('upload-vid-img')[0].appendChild(img);
                                                URL.revokeObjectURL(url);
                                            }
                                            return success;
                                        };
                                        video.addEventListener('timeupdate', timeupdate);
                                        video.preload = 'metadata';
                                        video.src = url;
                                        // Load video in Safari / IE11
                                        video.muted = true;
                                        video.playsInline = true;
                                        video.play();
                                    };
                                    fileReader.readAsArrayBuffer(file);
                                }
                            });
                        </script>

                        <script>
                            function readFile(input) {
                                let reader;
                                let isImageExt = true;
                                let isVideoExt = true;
                                let  validImageExtensions = ["jpg","pdf","jpeg","gif","png"];
                                let  validVideoExtensions = ["mp4","mov", "x-m4v"];
                                $('#FileExtension').val('');
                                console.log(input.files)
                                console.log(input.files[0]);
                                if (input.files && input.files[0]) {
                                    let file_ext = input.files[0].name.split('.').pop().toLowerCase();
                                    console.log(file_ext);
                                    if (validImageExtensions.indexOf(file_ext) == -1){
                                        isImageExt = false;
                                    }
                                    if (validVideoExtensions.indexOf(file_ext) == -1){
                                        isVideoExt = false;
                                    }

                                    console.log('---------------Is Video --------------')
                                    console.log(isVideoExt)
                                    console.log('---------------Is Image --------------')
                                    console.log(isImageExt)

                                    if (isImageExt == true){
                                        reader = new FileReader();
                                        reader.onload = function(e) {
                                            $('#FileExtension').val('image');
                                            // $('.myVideo').hide();
                                            // $('.myImage').show();
                                            // $('.myImage').attr('src', e.target.result);
                                            // $('.myImage').css('opacity', 1);
                                            // $('.file-label').text(input.files[0].name)
                                        };
                                        reader.readAsDataURL(input.files[0]);

                                    }

                                    if (isVideoExt == true){
                                        reader = new FileReader();
                                        reader.onload = function(e) {
                                            $('#FileExtension').val('video');
                                            // $('.myImage').hide();
                                            // $('.myVideo').show();
                                            // $('.myVideo').attr('src', e.target.result);
                                            // $('.file-label').text(input.files[0].name)
                                        };
                                        reader.readAsDataURL(input.files[0]);

                                    }


                                }
                            }
                        </script>
    @endpush
