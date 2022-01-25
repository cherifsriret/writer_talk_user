@extends('layouts.main')
@section('title')
    Home
@endsection
@section('content')
    {{--@include('partials.navigation_right')--}}
    <div class="comment-page" style="margin-top: 55px">

        <div class="row ">
            <div class="col-6 m-0 p-0 post_detail_asset">
                @if($posts->file)
                    @if($posts->file_type == 'image')
                        <img class="sky-view"  src="{{asset('storage/'.$posts->file)}}" >
                    @endif
                    @if($posts->file_type == 'video')
                        <video class="sky-view" controls>
                            <source src="{{asset('storage/'.$posts->file)}}">
                        </video>
                    @endif
                @endif
            </div>
            <div class="col-6 ">
                <div class="chat-name">
                    <div class="media"><img style="object-fit: cover" class="mr-2 comment-user-name"
                                            @if(@$posts->user->image) src="{{asset('storage/'.$posts->user->image)}}"
                                            @else  src="{{asset('assets/imgs/user_avatar.png')}}"
                                            @endif alt="Generic placeholder image">
                        <div class="media-body">
                            <h5 class="mt-0 main-name p-2">{{$posts->user->name}}</h5>
                        </div>
                    </div>
                </div>
                <div class="scroll-bar3 " id="thumb-scroll">
                    @if(sizeof($posts->post_comments) > 0 )
                        @foreach($posts->post_comments as $pc => $pc_row)

                        <div class="Comment-user pt-1 modal_user_comment_container ">
                        <figure class="avatar"><img
                                    src="{{asset('storage/'.$pc_row->user->image)}}"
                                    alt="image"></figure>
                        <div>
                            <div class="w-50">
                                <div class="Comment-wrap">
                                    <p class="heading">{{ucwords($pc_row->user->name)}}</p>
                                    <p class="comment">{{$pc_row->comment}}</p>
                                </div>
                            </div>
                            <div class="reply-back d-flex mt-1 sub-comments">
                                <div class="time">{{$pc_row->created_at->diffForHumans()}}</div>
                                <div class="Reply reply_main_comment_trigger"
                                     user_id="{{$pc_row->user->uuid}}" post_id="{{@$pc_row->post_id}}" comment_id="{{@$pc_row->uuid}}" post_type="{{@$pc_row->post_type}}" commentIndex="{{$pc}}">Reply
                                </div>
                            </div>
                        </div>
                    </div>
                            @if(sizeof($pc_row->replies) > 0)
                    <div class="View-more-reply">
                        @foreach($pc_row->replies as $pr=> $pr_row)
                            <div class="Comment-user pt-1 modal_user_reply_container">
                                <figure class="avatar">
                                    <img src="{{asset('storage/'.$pr_row->user->image)}}" class="more-reply-image" alt="image">
                                </figure>
                                <div>
                                    <div class="w-50">
                                        <div class="Comment-wrap" id="view-more-reply">
                                            <p class="heading">{{ucwords($pr_row->user->name)}}</p>
                                            <p class="comment">{{$pr_row->comment}}</p>
                                        </div>
                                    </div>
                                    <div class="reply-back d-flex mt-1 sub-comments">
                                        <div class="time" id="time-ago">{{$pr_row->created_at->diffForHumans()}}</div>
                                        {{--                                                                        <div class="Like">Like </div>--}}
                                        <div class="Reply reply_btn" post_id="{{@$posts->uuid}}" post_type="{{@$posts->post_type}}">Reply </div>

                                    </div>
                                </div>
                            </div>

                            {{--Reply Input --}}

                            <div class="chat-bottom py-2 ml-5 shadow-none w-95 modal_reply_input_div" style="display: none">
                                <form class="chat-form">
                                    <div class="Comment-user">


                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="reply_text" class="mb-0 modal_reply_text_input" placeholder="Write a reply..." post_id="{{@$posts->uuid}}"  post_type="{{@$posts->post_type}}" >
                                    </div>
                                    <div class="bg-arrow">
                                        <i class="fas fa-arrow-right right-icon modal_reply_comment_btn" >
                                        </i>
                                    </div>
                                </form>
                            </div>

                        @endforeach
                    </div>
                        @endif
                  @endforeach

                        @endif
                </div>
                <div class="card-body d-flex pt-3 ml-0 p-0 reaction">
                    <a href="#" class=" px-1 d-flex align-items-center fw-600 text-grey-900 text-dark font-xssss">
                        @if(@$posts->is_like)
                            <i class="fas fa-heart text-danger text-danger-900 f-21 mr-2 post_like_trigger" post_id="{{$posts->uuid}}" post_type="{{@$posts->post_type}}"></i>
                        @else
                            <i class="far fa-heart text-dark text-grey-900 f-21 mr-2 post_like_trigger" post_id="{{$posts->uuid}}" post_type="{{@$posts->post_type}}"></i>
                        @endif
                    </a>
                    <a href="#" class="d-flex align-items-center fw-600 text-grey-900 text-dark font-xssss">
                        <i class="far fa-comment text-dark text-grey-900 btn-round-sm"></i>
                    </a>
                    <a href="#" class="ms-auto mr-2 d-flex align-items-center fw-600 text-grey-900 text-dark font-xssss">
                        <i class="far fa-bookmark text-grey-900  font"></i>
                    </a>
                </div>
                <div class="d-block pt-0 ">
                    <h5 class="total-likes">{{$posts->likes_count}} likes </h5>
                    <h5 class="hours-ago pt-1">{{$posts->created_at->diffForHumans()}} </h5></div>
                <div class="chat-bottom py-2 pt-0 shadow-none w-100 comment_input_div">
                    <form class="chat-form">
                        <div class="form-group">
                            <input type="text" name="comment_text" class="mb-0 comment_text_input"
                                   placeholder="Write a comment..."  ></div>
                        <div class="bg-arrow"><i class="fas fa-arrow-right right-icon post_comment" post_id="{{@$posts->uuid}}"  post_type="{{@$posts->post_type}}"></i></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
