var base_url = window.location.origin;

$(document).on('click','.reply_main_comment_trigger',function(e) {
    let post_id = $(this).attr('post_id');
    let comment_id = $(this).attr('comment_id');
    let post_type = $(this).attr('post_type');

})
$(document).on('click','.post_comment',function(e) {
    let _token   = $('meta[name="csrf-token"]').attr('content');
    let post_id = $(this).attr('post_id');
    let post_type = $(this).attr('post_type');
    let comment = $(".comment_text_input").val();
    $.ajax({
        type: "POST",
        url: '/save-user-commment',
        data:{
            post_id:post_id,
            post_type:post_type,
            comment:comment,
            _token: _token
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
if(data.success){
    location.reload();
}else{
    alert("Failed to post comment")
}

        }
    });
})
$(document).on('click','.post_like_trigger',function(e) {
    let _token   = $('meta[name="csrf-token"]').attr('content');
    let post_id = $(this).attr('post_id');
    let post_type = $(this).attr('post_type');
    $.ajax({
        type: "POST",
        url:'/save-post-like',
        data:{
            uuid:post_id,
            post_type:post_type,
            _token: _token
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
if(data.success){
    location.reload();
}else{
    alert("Failed to post comment")
}

        }
    });
})

