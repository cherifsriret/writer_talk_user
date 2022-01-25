<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Writers Talk</title>
	<!-- Additional CSS Files -->
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style>
	#bg-video {
		min-width: 100%;

        min-height: 82vh;
        max-width: 100%;
        max-height: 82vh;
		object-fit: cover;
		z-index: -1;
	}

	.video-overlay {
		position: absolute;
		top: 0;
		left: 0;
		bottom: 7px;
		width: 100%;
	}

	.main-banner {
		position: relative;
	}

	.main-banner .caption {
		text-align: center;
		position: absolute;
		width: 80%;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
	}


	.index-service i {
		font-size: 40px;
		margin-bottom: 10px;
		color: #303ef7;
	}
	.index-service {
		text-align: center;
		padding: 25px 10px;
		font-size: 14px;
		cursor: pointer;
        line-height: 1.3;
		background: transparent;
	}
	.trail-button a {
    display: inline-block;
    font-size: 15px;
    padding: 12px 20px;
	border-radius: 79px;
    background-color: #137CBD;
    color: #fff;
    text-align: center;
    font-weight: 400;
}
.sign-up-button a{
	background-color: #10486b!important;
	margin-bottom: 10px;
	border-radius: 5px;
}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg main-screen navbar-light bg-light container">
		<a class="navbar-brand" href="#">
			<img style="width: 75px;" src="http://writerstalkadmin.com/public/assets/imgs/logo.png" alt="">

		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active"> <a class="nav-link" href="#">About <span class="sr-only">(current)</span></a> </li>
				<li class="nav-item"> <a class="nav-link" href="#">Privacy</a> </li>
				<li class="nav-item"> <a class="nav-link" href="{{url('login')}}">Sign In</a> </li>
			</ul>
			<form class="form-inline my-2 my-lg-0 ml-3">
				{{-- <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Sign Up</button> --}}
				<a style="color: #fff;" href="{{url("https://play.google.com/store/apps/details?id=com.WritersTalk.app")}}" class=" my-2 my-sm-0 download-btn-header" >Download the App</a>
			</form>
		</div>
	</nav>
	<div class="main-banner" id="top">
		<video autoplay muted loop id="bg-video">
			<source src="{{asset('assets/imgs/main-video.mp4')}}" type="video/mp4" /> </video>
		<div class="video-overlay header-text">
			<div class="caption">
				<h2 class="text-white">Help and Encouragment</h2>
				<h6 class="text-white">for Writers</h6> </div>
		</div>
	</div>
	<div class="youtube-vedio p-3">
	<iframe width="100%" height="650" src="https://www.youtube.com/embed/Mc4pCwSWFrA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
	</div>
	
	<div class="container">

		<div class="row">
			<div class="col-md-4 col-4 index-service">
                {{-- <i class="fas fa-laptop-code"></i> --}}
                <img src="{{asset('assets/imgs/s2.png')}}" class="icons-size">
                <div class="py-2">
                    <h3 class="">Learn From Pros</h3>
                    <p>Watch daily instructional videos from professionals. Any writing topic you could need</p>
                </div>
			</div>
			<div class="col-md-4 col-4 index-service">
                <img src="{{asset('assets/imgs/s1.png')}}" class="icons-size">
                <div class="py-2">
                    <h3>Boost Creativity</h3>
                    <p>Learn to come up with ideas on the spot</p>
                </div>
			</div>
			<div class="col-md-4 col-4 index-service">
                <img src="{{asset('assets/imgs/s3.png')}}" class="icons-size">
                <div class="py-2">
                    <h3>Share Stories</h3>
                    <p>Share stories for peers to read and review</p>
                </div>
			</div>
		</div>
	</div>
	<div class="caption1 text-center">
				<h2 class="p-2">81% of people want to write a book</h2>
				<h5 class="p-2">Only 5% do</h5>
				<h4 class="p-2">Don’t be a Statistic</h4>
				<h6 class="p-2">$4.99 monthly or $29.99 annually</h6>
			 </div>
			 <div class="trail-button text-center m-2">
                    <a href="{{url('register')}}">START FREE TRAIL</a>
                </div>
				<div class="trail-button sign-up-button mb-5 text-right m-3">
                    <a href="{{url('login')}}">Sign In</a>
                </div>
	<nav class="navbar fixed-bottom navbar-dark main-screen-footer">
		<a href="{{url("https://play.google.com/store/apps/details?id=com.WritersTalk.app")}}" class="btn btn-light text-primary mx-auto px-3 font-weight-bold" >Download Writers Talk</a>
	</nav>
</body>

</html>
