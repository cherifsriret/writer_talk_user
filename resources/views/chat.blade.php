

@extends('layouts.main')
@section('title')
    Stories
@endsection
@section('content')
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
 -->
    <input type="hidden" id="user_dd" value="{{\Illuminate\Support\Facades\Auth::user()->uuid}}">
    <div style="height: 97%;" class="w-22 d-flex mx-auto">
        <div class="w-82">
            <div class=" chat-name pt-3">
                <h5 class="mt-0 main-name float-left pl-3" style="font-size: 16px">{{\Illuminate\Support\Facades\Auth::user()->name}}
                </h5>

                <div class="float-right">
                    <i class="fas fa-edit mr-2" style="font-weight:200" data-toggle="modal" data-target="#writeNewChatModal"></i>
                    <i class="fas fa-users group-users pointer"  data-toggle="modal" data-target="#exampleModal"></i>
                </div>
            </div>
            <!-- Button trigger modal -->


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <form class="create_group_form" action="{{route('create_group_new')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="creator_id" id="creator_id" value="{{ Auth::user()->uuid }}">
                    <input type="hidden" name="users" id="selected_group_users" value="">
                    <div class="modal-dialog modal-dialog-centered w-27" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="">
                                    <button type="button" class="close closing-popup" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                                    <div class="d-flex pt-2 justify-content-center">
                                        <div class="searchbar-posts mr-2">
                                            <input type="text" name="group_name" placeholder="Group Name" class="searchbar-input pl-3 search-box pt-2 pb-2 ">
                                        </div>
                                        <button class="btn-primary rounded pt-0 pb-1 px-2 mb-0 trigger_create_group" type="button">Create</button>
                                    </div>
                                    <div class=" pt-2">
                                        @if(sizeof($penpal_search) > 0)
                                            @foreach($penpal_search as $penpal)

                                                <div class="media group-chat-users my-2">
                                                    <img class="mx-2 single-user-name" src="{{asset('storage/'.$penpal->user->image)}}" alt="Generic placeholder image">
                                                    <div class="media-body mt-1 row">
                                                        <div class="col-md-9 px-0">
                                                            <h5 class="mt-0 main-name" style="font-weight:500;">{{$penpal->user->name}}</h5>
                                                        </div>

                                                        <div class="form-check col-md-3">
                                                            <input type="checkbox" class="zoom-checkbox form-check-input group_selected_user" pid="{{$penpal->user->uuid}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>



                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- New Chat Modal -->
            <div class="modal fade" id="writeNewChatModal" tabindex="-1" role="dialog" aria-labelledby="writeNewChatModalLabel" aria-hidden="true">
                <form action="{{url('write-new-message')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="creator_id" id="sender_id" value="{{ Auth::user()->uuid }}">
                    <input type="hidden" name="users" id="selected_users" value="">
                    <div class="modal-dialog modal-dialog-centered w-27" role="document">
                        <div class="modal-content">
                            <div class="modal-body">

                                    <div class="">
                                        <button type="button" class="close closing-popup" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="d-flex pt-2 justify-content-center">
                                        <div class="searchbar-posts mr-2">
                                            <input type="text" name="message" placeholder="Message" class="searchbar-input pl-3 search-box pt-2 pb-2">
                                        </div>
                                        <button class="btn-primary rounded pt-0 pb-1 px-2 mb-0 trigger_send_message" type="submit">Send</button>
                                    </div>
                                    <div class="pt-2">
                                        @if(sizeof($penpal_search) > 0)

                                            @foreach($penpal_search as $penpal)

                                                <div class="media group-chat-users my-2">
                                                    <img class="mx-2 single-user-name" src="{{asset('storage/'.$penpal->user->image)}}" alt="Generic placeholder image">
                                                    <div class="media-body mt-1 row">
                                                        <div class="col-md-9 px-0">
                                                            <h5 class="mt-0 main-name" style="font-weight:500;">{{$penpal->user->name}}</h5>
                                                        </div>

                                                        <div class="form-check col-md-3">
                                                            <input type="radio" name="receiver_id" class="zoom-checkbox form-check-input penpal_checkbox_new_message" value="{{$penpal->user->uuid}}" >
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>



                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div style="height: 93%;" class="chat-boxes mt-2 scroll-bar"  id="thumb-scroll1">
            
            <div class="tips shadow-xss">
	<ul class="nav nav-tabs shadow-xss" id="myTab" role="tablist">
		<li class="nav-item width" style="width:50%;"> <a class="nav-link active fontsize font-weight-bold text-center" id="writer-tab" data-toggle="tab" href="#writer" role="tab" aria-controls="Writers" aria-selected="true">Chats</a> </li>
		<li class="nav-item width" style="width:50%;"> <a class="nav-link fontsize font-weight-bold text-center" id="posts-tab" data-toggle="tab" href="#Posts" role="tab" aria-controls="Posts" aria-selected="false">Group Chats</a> </li>
	</ul>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade  style-1 show active" id="writer" role="tabpanel" aria-labelledby="writer-tab"> 
            @if(sizeof($user_connections) > 0)
             @foreach($user_connections as $conn)
			<div class="single-chat pt-2 pb-2 getChat" uid="{{$conn->uuid}}" receiver_id="{{$conn->user->uuid}}">
				<div class="media"> <img class="mr-3 single-user-name" src="{{asset('storage/'.$conn->user->image)}}" alt="Generic placeholder image">
					<div class="media-body mt-2">
						<h5 class="mt-0 main-name" style="font-weight:500;">{{$conn->user->name}}</h5> </div>
				</div>
			</div>
             @endforeach
             @endif 
            </div>
		<div class="tab-pane fade style-1" id="Posts" role="tabpanel" aria-labelledby="posts-tab">
        @if(sizeof($group_arr) > 0)
             @foreach($group_arr as $group)
			<div class="single-chat py-4 getGroupChat" uid="{{$group->uuid}}" >
				<div class="media row">
                    <div class="col-10">
                        <div class="media-body mt-2, px-5">
                            <h5 class="mt-0 main-name font-weight-bold" style="font-weight:500;">{{$group->name}}</h5>
                            <p class="mt-0" style="font-size: 12px; color: #808080;">{{$group->formatted_created_at}}</p>
                        </div>
                    </div>
                    <div class="">
                        <div style="border-radius: 25px; background-color: #00b8ff; width: 25px; height: 25px; text-align: center; color: #fff;">
                            {{@$group->message_count}}

                        </div>

                    </div>

				</div>
			</div>
             @endforeach
             @endif 
         </div>
	</div>
</div>


            </div>
        </div>

        <div class="praise_html"></div>

        <div class="w-92">
            <div class="chat-name">
                <div class="media">
                    @if(sizeof($user_connections) > 0)
                        <img style="object-fit: cover" class="mr-3 chat-user-name" src="{{asset($user_connections[0]->user->image)}}" alt="Generic placeholder image">
                        <div class="media-body">
                            <h5 class="mt-0 main-name">{{$user_connections[0]->user->name}}</h5>
                            {{--<div class="time last-seen">Active Yesterday</div>--}}
                        </div>
                    @endif

                </div>
            </div>
            <div style="height: 86%;" class="row no-gutters pr-2">
                <div class="col-lg-12">
                    <div style="height: 100%;" class="chat-wrapper pt-0 mt-2 w-100 bg-white scroll-bar2" id="thumb-scroll1">
                        <div class="chat-body pt-3 px-3 pb-0">
                            <div class="messages-content render_messages">
                                @if(sizeof($messages) > 0)
                                    @foreach($messages as $message)
                                        @if(\Illuminate\Support\Facades\Auth::user()->uuid != $message->sender_id)
                                            <div class="message-item">
                                                <div class="message-user">
                                                    <figure class="avatar">
                                                        <img style="object-fit: cover" src="{{asset($message->user_details->image)}}" alt="image">
                                                    </figure>
                                                    <div class="w-50">
                                                        <div class="message-wrap" id="message_wrap">{{$message->message}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="message-item outgoing-message">
                                                <div class="message-user">

                                                    <div style="max-width: 400px" class="message-content">
                                                        <div class="message-wrap">{{$message->message}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif


                            </div>
                        </div>
                    </div>
                    <div class="chat-bottom p-2 shadow-none w-100" >
                        <form class="chat-form">
                            <div class="form-group"><input class="message_user_text" type="text" placeholder="Message..."></div>
                            @if(sizeof($user_connections) > 0)
                                <div class="bg-blue trigger_send_user_message" type="chat"  rid="{{$user_connections[0]->uuid}}"><i class="fas fa-arrow-right send"></i></div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>



    <script>
        $(document).ready(function(){
            $('#comment-click').click(function(){
                $('#contact-section').toggle()

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            function getMessages(conn_id){
                var user_id = $("#user_dd").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type:"post",
                    url:"get-chats",
                    data: {conn_id:conn_id},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        console.log(user_id)
                        if(data.success){
                            $(".render_messages").html("");
                            let messages_arr = data.data;
                            if (messages_arr.length > 0){
                                $.map(messages_arr, function(message, message_index){
                                    let html = "";
                                    if (message.sender_id != user_id){
                                        html = "<div class=\"message-item\">\n" +
                                            "                                <div class=\"message-user\">\n" +
                                            "                                    <figure class=\"avatar\">\n" +
                                            "                                        <img style=\"object-fit: cover\" src='https://admin.writerstalkadmin.com/storage/"+message.user_details.image+"' alt=\"image\">\n" +
                                            "                                    </figure>\n" +
                                            "                                    <div class=\"w-50\">\n" +
                                            "                                    <div class=\"message-wrap\" id=\"message_wrap\">"+message.message+"</div>\n" +
                                            "                                </div>\n" +
                                            "                                </div>\n" +
                                            "                            </div>";
                                    }else{
                                        html = "<div class=\"message-item outgoing-message\">\n" +
                                            "                                <div class=\"message-user\">\n" +
                                            "                                    <div style=\"max-width: 400px\" class=\"message-content\">\n" +
                                            "                                    <div class=\"message-wrap\">"+message.message+"</div>\n" +
                                            "                                    </div>\n" +
                                            "                                </div>\n" +
                                            "                            </div>";
                                    }


                                    $(".render_messages").append(html);
                                })
                            }

                        }else{
                            console.log("Unable to get chats")
                        }
                        // if(data > 0)
                        // {
                        //     $.map(data, function(item, index){
                        //                     var praise_html = "<div class=/"w-92\">
                        //                     <div class=\"media\">
                        //                 <div class=\"chat-name\">
                        //                 <div class=\"media\">";

                        //     }
                        // }
                    }
                });
            }
            function getGroupMessages(group_id){
                var user_id = $("#user_dd").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type:"post",
                    url:"get-group-messages",
                    data: {group_id:group_id},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if(data.success){
                            $(".render_messages").html("");
                            let messages_arr = data.group_message;
                            if (messages_arr.length > 0){
                                $.map(messages_arr, function(message, message_index){
                                    let html = "";
                                    if (message.user_id != user_id){
                                        html = "<div class=\"message-item\">\n" +
                                            "                                <div class=\"message-user\">\n" +
                                            "                                    <figure class=\"avatar\">\n" +
                                            "                                        <img style=\"object-fit: cover\" src='https://admin.writerstalkadmin.com/storage/"+message.user_details.image+"' alt=\"image\">\n" +
                                            "                                    </figure>\n" +
                                            "                                    <div class=\"w-50\">\n" +
                                            "                                    <div class=\"message-wrap\" id=\"message_wrap\">"+message.message+"</div>\n" +
                                            "                                </div>\n" +
                                            "                                </div>\n" +
                                            "                            </div>";
                                    }else{
                                        html = "<div class=\"message-item outgoing-message\">\n" +
                                            "                                <div class=\"message-user\">\n" +
                                            "                                    <div style=\"max-width: 400px\" class=\"message-content\">\n" +
                                            "                                    <div class=\"message-wrap\">"+message.message+"</div>\n" +
                                            "                                    </div>\n" +
                                            "                                </div>\n" +
                                            "                            </div>";
                                    }


                                    $(".render_messages").append(html);
                                })
                            }

                        }else{
                            console.log("Unable to get chats")
                        }
                        // if(data > 0)
                        // {
                        //     $.map(data, function(item, index){
                        //                     var praise_html = "<div class=/"w-92\">
                        //                     <div class=\"media\">
                        //                 <div class=\"chat-name\">
                        //                 <div class=\"media\">";

                        //     }
                        // }
                    }
                });
            }
            $('.getChat').click(function() {
                let token   = $('meta[name="csrf-token"]').attr('content');
                var conn_id = $(this).attr('uid');
                var receiver_id = $(this).attr('receiver_id');
                $(".trigger_send_user_message").attr('rid',receiver_id)
                $(".trigger_send_user_message").attr('type','chat')

                getMessages(conn_id)
            });
                $(document).on('click','.getGroupChat',function(e) {
                var conn_id = $(this).attr('uid');
                $(".trigger_send_user_message").attr('rid',conn_id)
                $(".trigger_send_user_message").attr('type','group')
                getGroupMessages(conn_id)
            });
            $('.trigger_send_user_message').click(function() {
                var rid = $(this).attr('rid');
                var type = $(this).attr('type');
                var message = $(".message_user_text").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
if (type == "chat"){
    $.ajax({
        type:"post",
        url:"send-user-message",
        data: {receiver_id:rid,message:message},
        dataType: 'json',
        success: function (data) {
            if (data.success) {

                if (data.connection_id){
                    getMessages(data.connection_id);
                    $('.message_user_text').val('')
                }
            }

        }
    });
} else{
    $.ajax({
        type:"post",
        url:"store-message",
        data: {group_id:rid,message:message},
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                console.log("data.data")
                console.log(data.data)
                    getGroupMessages(data.data.group_id);
                    $('.message_user_text').val('')
            }

        }
    });
}


            });
            $('.trigger_send_message').click(function() {

            })
            $('.trigger_create_group').click(function() {
                let checked = $('.group_selected_user:checkbox:checked');
                let arr = [];
                checked.each(function( index,element ) {
                    let uuid = $(this).attr('pid');
                    arr.push(uuid)
                })
                $("#selected_group_users").val(JSON.stringify(arr))
                $(".create_group_form").submit();
//     var rid = $(this).attr('rid');
//     var message = $(".message_user_text").val();
//     $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });
//
//     $.ajax({
//         type:"post",
//         url:"send-user-message",
//         data: {receiver_id:rid,message:message},
//          dataType: 'json',
//         success: function (data) {
//         if (data.success) {
//
//             if (data.connection_id){
//                 getMessages(data.connection_id);
//                 $('.message_user_text').val('')
//             }
//         }
//
//         }
//     });

            });
        });
    </script>
@endpush

