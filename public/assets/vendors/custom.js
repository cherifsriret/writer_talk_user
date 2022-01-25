$(document).ready(function(){
    // $(".btn1").click(function(){
    // });
    $(".choose-search").click(function(){
        // alert("ok");
        $(".select-input-seach").show();
        $(".select-btns-search").hide();
    });
    $(".search-icon").click(function(){
        $(".select-btns-search").show();
        $(".select-input-seach").hide();
    });

  })
