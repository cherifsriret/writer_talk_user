var base_url = window.location.origin;
    // LIKE BUTTON

function initiateOwl(){
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
}

    $(document).on('click','.post_like',function(e){
    e.preventDefault();
    // console.log($(this).siblings().find('span').text());
    var post_index = $(this).attr('postIndex');
    // console.log($(this).attr('postIndex'));
    var post_arr =  $('#userPostsArr').val();
    post_arr = JSON.parse(post_arr);
    // console.log(post_arr[post_index])
    var index_object = post_arr[post_index];
    // console.log(index_object);
    var formData = {
    uuid : index_object.uuid,
    post_type: 'user',
    _token:$('meta[name="csrf-token"]').attr('content')
};

    $.ajax({
    type: "POST",
    url:'/save-post-like',
    data: formData,
    success:function(data){
    var res = JSON.parse(data);
    if(res.success == true){
    var new_obj = post_arr[post_index].like_counts = res.like_count
    var current_obj_pointer = $(".display_posts")[post_index]
        // console.log(current_obj_pointer);
    $(current_obj_pointer).find('.like_box').html('')
    var html_body = "";
    if(res.is_like){
    html_body += '<i class="fas fa-heart text-danger text-danger-900 f-21 mr-2 post_like" postIndex="'+post_index+'"></i>';
}
    else{
    html_body += '<i class="far fa-heart text-dark text-grey-900 f-21 mr-2 post_like" postIndex="'+post_index+'"></i>';

}
    html_body += '<span class="like_count_val">'+res.likes_count+'</span> '
        console.log($(current_obj_pointer).find('.like_box'));
    $(current_obj_pointer).find('.like_box').html(html_body)
    console.log('------');
    console.log('res.is_like');
    console.log(res.is_like);
    console.log(res.likes_count);
    console.log(post_index);
    console.log(post_arr);
}



}
})


})

    //Save Comment
$(document).on('click','.add_comment_btn',function (e){
    e.preventDefault();
    var post_array = $('#userPostsArr').val();
    var comment_input_pointer = $(this).parent().prev('div').find('.comment_text_input');
    if (post_array){

        post_array = JSON.parse(post_array);
    }
    var post_index = $(comment_input_pointer).attr('postIndex');
    var index_object = post_array[post_index];


    var comment = $(comment_input_pointer).val();
    console.log(comment);
    var post_id = $(comment_input_pointer).attr('post_id');
    var post_type = $(comment_input_pointer).attr('post_type');
    console.log('-----------------------');
    console.log(post_index);
    console.log(comment);
    console.log(post_id);
    console.log(post_type);
    console.log('-----------------------');

    var formData = {
        post_id : index_object.uuid,
        comment: comment,
        post_type: post_type,
        _token:$('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: "POST",
        url: '/save-user-commment',
        data: formData,
        success: function (data) {
            console.log(data);
            var res = JSON.parse(data)
            if (res.success == true){
                var current_obj_pointer = $(".scroll-bar1.user_comment_container")[post_index];
                console.log(current_obj_pointer);
               get_post_latest_comment(index_object.uuid ,post_index, current_obj_pointer );

            }

        }
    });

});

$(document).on('click','.add_modal_comment_btn',function (e){
    e.preventDefault();
    var post_array = $('#userPostsArr').val();
    var comment_input_pointer = $(this).parent().prev('div').find('.comment_text_input');
    if (post_array){

        post_array = JSON.parse(post_array);
    }
    var post_index = $(comment_input_pointer).attr('postIndex');
    var index_object = post_array[post_index];
    console.log(index_object.uuid);
    var comment = $(comment_input_pointer).val();
    var post_id = $(comment_input_pointer).attr('post_id');
    var post_type = $(comment_input_pointer).attr('post_type');
    console.log('-----------------------');
    console.log(post_index);
    console.log(comment);
    console.log(post_id);
    console.log(post_type);
    console.log('-----------------------');

    var formData = {
        post_id : index_object.uuid,
        comment: comment,
        post_type: post_type,
        _token:$('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: "POST",
        url: '/save-user-commment',
        data: formData,
        success: function (data) {
            console.log(data);
            var res = JSON.parse(data)
            if (res.success == true){
                var current_obj_pointer = $(".scroll-bar3.user_comment_container")[post_index];

               get_post_comments(index_object.uuid ,post_index, current_obj_pointer );

            }

        }
    });

});

    //Save Comment
$(document).on('click','.reply_comment_btn',function (e){
    e.preventDefault();
    var post_array = $('#userPostsArr').val();
    var reply_input_pointer = $(this).parent().prev('div').find('.reply_text_input');
    if (post_array){

        post_array = JSON.parse(post_array);
    }
    var post_index = $(reply_input_pointer).attr('postIndex');
    var index_object = post_array[post_index];
    console.log(index_object.uuid);
    var comment = $(reply_input_pointer).val();
    var post_id = $(reply_input_pointer).attr('post_id');
    var post_type = $(reply_input_pointer).attr('post_type');
    var comment_id = $(reply_input_pointer).attr('comment_id');
    console.log('-----------------------');
    console.log(post_index);
    console.log(comment);
    console.log(post_id);
    console.log(post_type);
    console.log('-----------------------');

    var formData = {
        post_id : index_object.uuid,
        comment: comment,
        comment_id: comment_id,
        post_type: post_type,
        _token:$('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: "POST",
        url: '/save-user-commment-reply',
        data: formData,
        success: function (data) {
            console.log(data);
            var res = JSON.parse(data)
            if (res.success == true){
                var current_obj_pointer = $(".scroll-bar1.user_comment_container")[post_index];
                get_post_latest_comment(index_object.uuid , post_index, current_obj_pointer);

            }

        }
    });

});

$(document).on('click','.modal_reply_comment_btn',function (e){
    e.preventDefault();
    var post_array = $('#userPostsArr').val();
    var reply_input_pointer = $(this).parent().prev('div').find('.modal_reply_text_input');
    if (post_array){

        post_array = JSON.parse(post_array);
    }
    var post_index = $(reply_input_pointer).attr('postIndex');
    var index_object = post_array[post_index];
    console.log(index_object.uuid);
    var comment = $(reply_input_pointer).val();
    var post_id = $(reply_input_pointer).attr('post_id');
    var post_type = $(reply_input_pointer).attr('post_type');
    var comment_id = $(reply_input_pointer).attr('comment_id');
    console.log('-----------------------');
    console.log(post_index);
    console.log(comment);
    console.log(post_id);
    console.log(post_type);
    console.log('-----------------------');

    var formData = {
        post_id : index_object.uuid,
        comment: comment,
        comment_id: comment_id,
        post_type: post_type,
        _token:$('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: "POST",
        url: '/save-user-commment-reply',
        data: formData,
        success: function (data) {
            console.log(data);
            var res = JSON.parse(data)
            if (res.success == true){
                var current_obj_pointer = $(".scroll-bar3.user_comment_container")[post_index];
                get_post_latest_comment(index_object.uuid , post_index, current_obj_pointer);

            }

        }
    });

});

    $(document).on('click','.main_comment_reply_btn', function (e){
        var user_id = $(this).attr('user_id');
        var comment_id = $(this).attr('comment_id');
        var post_array = $('#userPostsArr').val();
        if (post_array){
            post_array = JSON.parse(post_array);
        }
        var post_index = $(this).attr('postIndex');
        var index_object = post_array[post_index];
        $.ajax({
            type: "GET",
            url: '/get_comment_user/'+user_id,
            success:function (data){
                console.log(data)
                var res = JSON.parse(data);
                console.log(res);
                var current_obj_pointer = $(".scroll-bar1.user_comment_container")[post_index];
                $(current_obj_pointer).siblings('div.reply_input_div').show();
                var comment_input_pointer = $(current_obj_pointer).siblings('div.reply_input_div').find('input.reply_text_input');
                var comment_btn_pointer = $(current_obj_pointer).siblings('div.reply_input_div').find('.reply_comment_btn');
                $(comment_input_pointer).val('@'+res.data.name+' ')
                $(comment_input_pointer).attr('comment_id',comment_id)
            }
        });
    })



$(document).on('click','.modal_main_comment_reply_btn', function (e){
        var user_id = $(this).attr('user_id');
        var comment_id = $(this).attr('comment_id');
        var post_array = $('#userPostsArr').val();
        var comment_array = $('#postCommentArr').val();
        if (post_array){
            post_array = JSON.parse(post_array);
        }
        if (comment_array){
            comment_array = JSON.parse(comment_array);
        }
        // var post_index = $(this).attr('postIndex');
        var comment_index = $(this).attr('commentIndex');
        var index_object = comment_array[comment_index];
        $.ajax({
            type: "GET",
            url: '/get_comment_user/'+user_id,
            success:function (data){
                console.log(data)
                var res = JSON.parse(data);
                console.log(res);
                var current_obj_pointer = $(".modal_user_comment_container")[comment_index];
                console.log($(current_obj_pointer).find('.modal_user_reply_container'));
                console.log(comment_index);
                $(current_obj_pointer).siblings().find('div.modal_reply_input_div').css({'display':'block'});

                // var comment_input_pointer = $(current_obj_pointer).siblings('div.modal_reply_input_div').find('input.modal_reply_text_input');
                // var comment_btn_pointer = $(current_obj_pointer).siblings('div.modal_reply_input_div').find('.modal_reply_comment_btn');
                // $(comment_input_pointer).val('@'+res.data.name+' ')
                // $(comment_input_pointer).attr('comment_id',comment_id)
            }
        });
    })



function get_post_comments(post_id , post_index, current_obj_pointer ){
    $.ajax({
        type: "GET",
        url: '/get_post_comments/'+post_id,
        success:function (data){
            $(current_obj_pointer).html('')
            var html_body = ''
            var res = JSON.parse(data);
            console.log(res.data);

            if (res.success == true){
                    if (res.data){
                        $.map(res.data, function (val,index){
                            html_body += '<div class="Comment-user pt-1">\n' +
                                '          <figure class="avatar">\n' +
                                '              <img src="'+base_url+'/public/storage/'+val.user.image+'" alt="image">\n' +
                                '           </figure>\n' +
                                '           <div>\n' +
                                '           <div class="w-50">\n' +
                                '               <div class="Comment-wrap">\n' +
                                '                   <p class="heading">'+val.user.name+'</p>\n' +
                                '                   <p class="comment">'+val.comment+'</p>\n' +
                                '               </div>\n' +
                                '           </div>\n' +
                                '           <div class="reply-back d-flex mt-1 sub-comments">\n' +
                                '               <div class="time">'+val.formatted_created_at+'</div>\n' +
                                '               <div class="Reply main_comment_reply_btn" user_id="'+val.user.uuid+'" post_id="'+val.post_id+'" comment_id="'+val.uuid+'" post_type="'+val.post_type+'" postIndex="'+post_index+'">Reply </div>\n' +
                                '           </div>\n' +
                                '       </div>\n' +
                                '   </div>';

                            if (val.replies){
                                if (val.replies.length > 0){
                                    html_body += ' <div class="View-more-reply">';
                                    $.map(val.replies, function (rep_val,index){
                                        console.log(rep_val);
                                            html_body += '<div class="Comment-user pt-1 user_reply_container">\n' +
                                                        '     <figure class="avatar">\n' +
                                                        '         <img src="'+base_url+'/public/storage/'+rep_val.user.image+'" class="more-reply-image" alt="image">\n' +
                                                        '     </figure>\n' +
                                                        '     <div>\n' +
                                                        '         <div class="w-50">\n' +
                                                        '             <div class="Comment-wrap" id="view-more-reply">\n' +
                                                        '                 <p class="heading">'+rep_val.user.name+'</p>\n' +
                                                        '                 <p class="comment">'+rep_val.comment+'</p>\n' +
                                                        '             </div>\n' +
                                                        '         </div>\n' +
                                                        '         <div class="reply-back d-flex mt-1 sub-comments">\n' +
                                                        '             <div class="time" id="time-ago">'+rep_val.formatted_created_at+'</div>\n' +
                                                        '             <div class="Reply reply_btn" post_id="'+rep_val.post_id+'" post_type="'+rep_val.post_type+'" postIndex="'+post_index+'">Reply </div>\n' +
                                                        '         </div>\n' +
                                                        '     </div>\n' +
                                                        ' </div>';
                                    });
                                    html_body += '</div>';
                                }
                            }

                        });
                    }
                $(current_obj_pointer).append(html_body)
                console.log(current_obj_pointer);
                var comment_input_pointer = $(current_obj_pointer).siblings('div.comment_input_div').find('input.comment_text_input');
                var reply_input_pointer = $(current_obj_pointer).siblings('div.reply_input_div').find('input.reply_text_input');
                $(comment_input_pointer).val('')
                $(reply_input_pointer).val('')
                $(current_obj_pointer).siblings('div.reply_input_div').hide()


            }
        }
    })
}

    function get_post_latest_comment(post_id , post_index, current_obj_pointer ){

        $.ajax({
            type: "GET",
            url: '/get_post_latest_comment/'+post_id,
            success:function (data){
                $(current_obj_pointer).html('')
                var html_body = ''
                var res = JSON.parse(data);
                console.log(res);

                if (res.success == true){
                    if (res.data){
                        html_body += "<div>";
                        html_body += '<div class="Comment-user pt-1 ">\n' +
                            '                                    <figure class="avatar">\n' +
                            '                                        <img src="'+base_url+'/public/storage/'+res.data.user.image+'" alt="image">\n' +
                            '                                    </figure>\n' +
                            '                                    <div>\n' +
                            '                                        <div class="w-50">\n' +
                            '                                        <div class="Comment-wrap">\n' +
                            '                                            <p class="heading">'+res.data.user.name+'</p>\n' +
                            '                                            <p class="comment">'+res.data.comment+'</p>\n' +
                            '                                        </div>\n' +
                            '                                        </div>\n' +
                            '                                        <div class="reply-back d-flex mt-1 sub-comments">\n' +
                            '                                        <div class="time">'+res.data.formatted_created_at+'</div>\n' +
                            '                                        <div class="Reply main_comment_reply_btn"  user_id="'+res.data.user.uuid+'" post_id="'+res.data.post_id+'" comment_id="'+res.data.uuid+'" post_type="'+res.data.post_type+'" postIndex="'+post_index+'">Reply </div>\n' +
                            '\n' +
                            '                                    </div>\n' +
                            '                                 </div>\n' +
                            '                </div>\n';
                    }
                    if (res.data){
                        if (res.data.comment_replies){
                            html_body += "<div class='View-more-reply'>";
                            $.map(res.data.comment_replies, function (val,index){
                                console.log(val);
                                html_body += '         <div class="Comment-user pt-1 user_reply_container">\n' +
                                    '                                <figure class="avatar">\n' +
                                    '                                    <img src="'+base_url+'/public/storage/'+val.comment_reply_user.image+'" class="more-reply-image" alt="image">\n' +
                                    '                                </figure>\n' +
                                    '                                <div>\n' +
                                    '                                    <div class="w-50">\n' +
                                    '                                        <div class="Comment-wrap" id="view-more-reply">\n' +
                                    '                                            <p class="heading">'+val.comment_reply_user.name+'</p>\n' +
                                    '                                            <p class="comment">'+val.comment+'</p>\n' +
                                    '                                        </div>\n' +
                                    '                                    </div>\n' +
                                    '                                    <div class="reply-back d-flex mt-1 sub-comments">\n' +
                                    '                                    <div class="time" id="time-ago">'+val.formatted_created_at+'</div>\n' +
                                    '                                    <div class="Reply reply_btn" post_id="'+val.post_id+'" post_type="'+val.post_type+'" postIndex="'+post_index+'">Reply </div>\n' +
                                    '\n' +
                                    '                                </div>\n' +
                                    '                                </div>\n' +
                                    '                            </div>'
                            });
                            html_body += "</div>";
                        }
                    }
                    html_body += "</div>";
                    $(current_obj_pointer).append(html_body)
                    console.log(current_obj_pointer);
                    var comment_input_pointer = $(current_obj_pointer).siblings('div.comment_input_div').find('input.comment_text_input');
                    var reply_input_pointer = $(current_obj_pointer).siblings('div.reply_input_div').find('input.reply_text_input');
                    $(comment_input_pointer).val('')
                    $(reply_input_pointer).val('')
                    $(current_obj_pointer).siblings('div.reply_input_div').hide()


                }
            }
        })
    }
    // Share As Story

    $(document).on('click','#shareStoryPostBtn', function(e){
        e.preventDefault();
        var user_stories = $('#userStoriesArr').val();
        if (user_stories){

            user_stories = JSON.parse(user_stories);
        }

        var post_id = $(this).attr('post_id');
        var file_type = $(this).attr('file_type');
        var user_id = $('#userId');
        var formData = {
            post_id : post_id,
            post_type: 'user',
            file_type: file_type,
            _token:$('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
            type: "POST",
            url:'/share-post-story',
            data: formData,
            success:function (data){
                    if (data){
                        // console.log(data);
                        // console.log(JSON.parse(data))
                        // var res = JSON.parse(data);
                        // console.log(res.data.post_data);
                        $("html, body").animate({ scrollTop: 0 }, 500);
                        get_user_stories()
                    // window.location.reload()
                    }

            }
        });

    });

  function add_story(input){
      var file = input.files[0];
      var file_name = file.name;
      var file_type = '';
      if (file.type == 'image/jpeg' || file.type == 'image/jpg' || file.type == 'image/png' || file.type == 'image/gif'){
          file_type = 'image';
      }else{
          file_type = 'video';
      }
      var post_type = 'user';
        console.log(file);
        var formData = new FormData();
        formData.append('file',file);
        formData.append('post_type','user');
        formData.append('file_type',file_type);
        formData.append('_token',$('meta[name="csrf-token"]').attr('content'));
      $.ajax({
          type: "POST",
          url:'/share-post-story',
          data: formData,
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
          processData: false,
          success:function (data){
      //         if (data){
      //             // console.log(data);
      //             // console.log(JSON.parse(data))
      //             // var res = JSON.parse(data);
      //             // console.log(res.data.post_data);
                  $("html, body").animate({ scrollTop: 0 }, 500);
                  // get_user_stories();
              window.location.reload;
      //
      //         }
      //
          }
      });
  }



function get_user_stories(){
    $.ajax({
        type: "get",
        url:'/get-user-stories',
        cache: false,
        dataType: "json",
        success: function (data) {
            console.log(data);
            //Auth User Stories
            var res = data.data;
                var html_body = '';
                if(res.auth_user_stories.stories.length > 0){
                        html_body += '                        <div class="item">\n' +
                            $.map(res.auth_user_stories.stories, function (val,index){
                                html_body +='<div class="auth_stories_container">\n' +
                                                '<input type="hidden" name="auth_user_stories" class="auth_user_stories" post="'+val.post+'" value="'+val.tip_type+'">\n' +
                                            '</div>\n';
                            })

                            '\n' +
                            '                                <div class="authUserStoryModalTrigger" data-toggle="modal" data-target="#exampleModal4" >\n' +
                            '                                    <img class="single-story" src="{{asset(\'storage/\'.@$get_auth_user->image)}}">\n' +
                            '\n' +
                            '                                        </div>\n' +
                            '                                        <div class="story-profile">\n' +
                            '\n' +
                            '                                            <p class="text-truncate">{{ucfirst(@$get_auth_user->name)}}</p>\n' +
                            '                                        </div>\n' +
                            '                                </div>'
                }



        }
    });
}
