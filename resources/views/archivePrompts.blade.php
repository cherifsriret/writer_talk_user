@extends('layouts.main') @section('title') Admin Posts @endsection

 @section('content')

<div class="w-40 mx-auto pt-5">
	<div class="archive">
		<h3 class="modal-title99 p-3 fw-600">Archive</h3>
     </div>
	<form>
		<div class="row">
			<div class="col">
				<input type="text" class="form-control text-center search_by_name" value="" placeholder="Search by Name">
                <i class="fas fa-search search-icon"></i>
             </div>
			<div class="col">
				<input type="date"  class="form-control text-center datepicker" value="">
            </div>
		</div>
	</form>
	<div class="gallery popup row mx-0 display_fetch_data">
        @if(sizeof($quick) > 0)
        @foreach($quick as $quickData)
        <div class="col-md-6">
            <div class="row no-gutters">
                <div class=" col-md-12">
                    <div class="galleryVid">
                        <video width="100%" height="200vh" class="videoTag">
                            <source src="{{asset('storage/'.@$quickData->file)}}" type="video/mp4"> </video>
                        <div class="desc">Add a description of the image here</div>
                    </div>
                </div>
                <div class="col-md-12">
                  <a href="{{ url('profile/'.$quickData->user_details->uuid) }}">    
                <div class="media m-1">
                            <img class=" tip-profile rounded-circle mr-0" src="{{asset('storage/'.@$quickData->user_details->image)}}" alt="Generic placeholder image">
                        <div class="media-body ml-2" style="align-self:center;">
                        <h5 class="mt-0 font-weight-bold">{{$quickData->user_details->name}}</h5>
                        <span class="post-time">{{ \Carbon\Carbon::parse($quickData->created_at)->diffForHumans()}}</span>
                        </div>
                    </div>
                </a>
                </div>
            </div>
        </div>
        @endforeach
        @endif

	</div>
	<!-- The Modal -->
	<div class="showvideo">
		<div class="overlay"></div>
		<div class="vid-show"> <span class="close">X</span>
			<video width="800" controls>
				<source src="" type="video/mp4"> </video>
		</div>
	</div>
</div>
</div>

 @endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(function() {
	"use strict";
	$(".galleryVid .videoTag").click(function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
		var $srcvid = $(this).find("source").attr("src");
		$(".showvideo").fadeIn();
		$(".vid-show video").attr("src", $srcvid);
		$(this).play();
	});
	$(".close, .overlay").click(function() {
		$(".showvideo").fadeOut();
		$('video').trigger('pause');
	});
});
//match height of news cards
var maxHeight = 0;
$(".galleryVid").each(function() {
	if($(this).height() > maxHeight) {
		maxHeight = $(this).height();
	}
});
$(".galleryVid").height(maxHeight);
</script>
<script type="text/javascript">

    $(document).ready(function(){
        function fetchPrompts(){
             var query = $('.search_by_name').val();
             var queryDate = $('.datepicker').val();
             var _token   = $('meta[name="csrf-token"]').attr('content');
             $.ajax({
                url:'/fetch-prompt',
                type: 'post',
                data: {search:query,
                       queryDate:queryDate, 
                         _token:_token},
                         dataType:"json",
                success:function(result){
                $('.display_fetch_data').html('');
                   if (result.length > 0) {
                    $.map(result,function(item,index){
                        console.log(item)
                        let html ='<div class="col-md-6">'+
            '<div class="row no-gutters">'+
                '<div class=" col-md-12">'+
                    '<div class="galleryVid">'+
                        '<video width="100%" height="200vh" class="videoTag">'+
                        '<source src="http://writerstalkadmin.com/public/storage/'+item.file+'" type="video/mp4"></video>'+
                        // '<div class="desc">Add a description of the image here</div>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12">'+
                 
                '<a href="http://writerstalkadmin.com/profile/'+item.user_details.uuid+'" class="media m-1">'+
                '<img class=" tip-profile rounded-circle mr-0" src="http://writerstalkadmin.com/public/storage/'+item.user_details.image+'" alt="Generic placeholder image">'+
                '<div class="media-body ml-2" style="align-self:center;">'+
                '<h5 class="mt-0 font-weight-bold">'+item.user_details.name+'</h5>'+
                '<span class="post-time">'+item.formated_date+'</span>'+
                '</div>'+
                 '</a>'+
                 
                '</div>'+
            '</div>'+
        '</div>';
                $('.display_fetch_data').append(html);
                    });
                    }
                }

             });
        }
        $('.search_by_name').on('keyup',function(){
            fetchPrompts();
        });
         $('.datepicker').on('change',function(){
            fetchPrompts();
        });
    });

</script>