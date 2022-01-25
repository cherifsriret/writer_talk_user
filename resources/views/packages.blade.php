@extends('layouts.main') @section('title') Admin Posts @endsection

 @section('content')

 <div class="w-40 mx-auto pt-5">
 	<h3 class=" m-3">Your Trail Version has been expired</h3>
 	@if(sizeof($arr) >  0)
 	@foreach($arr as $array)
	<form action="{{url('buy-package')}}" method="post" class="submitForm trigger-buy-package">
		@csrf
		<input type="hidden" name="payment" value="{{$array->Payment}}">
		<input type="hidden" name="days" value="{{$array->days}}">

	<div class="shadow-xss m-2 w-50 p-2" class="payment_submit">
	
		<div class="media"> <img class=" tip-profile1 rounded-circle mr-3" src="{{asset('assets/imgs/logo.jpeg')}}" alt="Generic placeholder image">
			<div class="media-body align-self-center">
			<h5 class="mt-0">{{$array->duration}}</h5> <p class="post-time11 mt-2">{{$array->Payment}}</p> </div>	
		</div>
	</div>
	</form>
	<!-- <div class="shadow-xss m-2 mt-3 p-2 border-1 w-50">
		<div class="media"> <img class=" tip-profile1 rounded-circle mr-3" src="http://127.0.0.1:8000/assets/imgs/logo.jpeg" alt="Generic placeholder image">
			<div class="media-body align-self-center">
				<h5 class="mt-0">Yearly</h5> <p class="post-time11 mt-2">$ 4.99</p> </div>
		</div>
	</div> -->
	@endforeach
	@endif
</div>


 @endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="crossorigin="anonymous">
	
</script>
	<script type="text/javascript">
	  	 $(document).on('click','.trigger-buy-package',function(e) {
      $(this).submit();
    })
</script>
