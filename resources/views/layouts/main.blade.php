<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')

</head>

<body>

@include('partials.navbar')
<section class="main bg-white">

    @include('partials.navigation_left')


    @yield('content')



{{--    @include('partials.navigation_right')--}}
</section>


</body>

<script src="https://cdn.socket.io/4.3.2/socket.io.min.js" integrity="sha384-KAZ4DtjNhLChOB/hxXuKqhMLYvx3b5MlT55xPEiNmREKRzeEm+RVPlTnAn0ajQNs" crossorigin="anonymous"></script>
<script>

</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
    <script src="{{asset('assets/js/post_detail.js')}}" ></script>

@stack('js')

