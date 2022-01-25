@extends('layouts.main')
@push('style')
<style>
    .chat-row{
        margin: 50px;
    }
    ul{
        margin:0;
        padding: 0;
        list-style: none;
    }

    ul li {
        padding: 8px;
        background-color: #928787;
        margin-bottom: 20px;
    }
    ul li:nth-child(2n-2){
        background: #c3c5c5;
    }

    .chat-input{
        border:1px solid lightgray;
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
        padding: 8px 10px;
        color: white;
    }
</style>
@endpush
@section('content')
    <div class="w-2">
    </div>
    <div class="w-3 pt-4">

        <!-- body -->
        <div class="home-demo py-3 mt-2">

    <div class="row ">
        <div class="large-12 columns ">
        <div class="chat-content">
            <ul>

            </ul>
        </div>
        <div class="chat-section">
            <div class="chat-box">
                <div class="chat-input bg-primary" id="chatInput" contenteditable=""></div>
            </div>
        </div>
        </div>
    </div>
        </div>
    </div>
@endsection
