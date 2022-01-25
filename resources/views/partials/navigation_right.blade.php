<div class="w-6 d-none" id="contact-section" style="display:none;">
    <nav class="navigation">
        <div class="nav-content">
            <div class="nav-wrap mr-1 ml-1 rounded-xxl shadow-xss">
                <div class="contact">
                    <h4 class="heading pb-2">CONTACTS</h4>
                    <ul class="list-group">

                    @if(sizeof(@$auth_user_penpals) > 0)
                            @foreach(@$auth_user_penpals as $ap => $ap_row)
                        <li class="bg-transparent">
                            <figure class="avatar">
                                <img src="{{asset('storage/'.@$ap_row->user->image)}}" alt="image" class="img">
                            </figure>
                            <h3 class="f-heading">
                                <a class="model-popup" href="{{route('userProfile',['id'=>$ap_row->user->uuid])}}">{{@$ap_row->user->name}}</a>
                            </h3>
{{--                            <span class="ms-auto badge badge-primary badge-pill">2</span>--}}
                        </li>
                            @endforeach
                        @else
                            <li class="bg-transparent">

                                <h3 class="f-heading">
                                    <a class="model-popup">No Contacts Available</a>
                                </h3>
                                {{--                            <span class="ms-auto badge badge-primary badge-pill">2</span>--}}
                            </li>
                        @endif
{{--                        <li class="bg-transparent">--}}
{{--                            <figure class="avatar">--}}
{{--                                <img src="{{asset('assets/imgs/1.jpg')}}" alt="image" class="img">--}}
{{--                            </figure>--}}
{{--                            <h3 class="f-heading">--}}
{{--                                <a class="model-popup" href="#">Victor Exrixon</a>--}}
{{--                            </h3>--}}
{{--                            <span class="bg-success ms-auto btn-round-xss"></span>--}}
{{--                        </li>--}}
{{--                        <li class="bg-transparent">--}}
{{--                            <figure class="avatar">--}}
{{--                                <img src="{{asset('assets/imgs/2.jpg')}}" alt="image" class="img">--}}
{{--                            </figure>--}}
{{--                            <h3 class="f-heading">--}}
{{--                                <a class="model-popup" href="#">Surfiya Zakir</a>--}}
{{--                            </h3>--}}
{{--                            <span class="bg-warning ms-auto btn-round-xss"></span>--}}
{{--                        </li>--}}
{{--                        <li class="bg-transparent">--}}
{{--                            <figure class="avatar">--}}
{{--                                <img src="{{asset('assets/imgs/4.jpg')}}" alt="image" class="img">--}}
{{--                            </figure>--}}
{{--                            <h3 class="f-heading">--}}
{{--                                <a class="model-popup" href="#">Goria Coast</a>--}}
{{--                            </h3>--}}
{{--                            <span class="bg-success ms-auto btn-round-xss"></span>--}}
{{--                        </li>--}}
{{--                        <li class="bg-transparent">--}}
{{--                            <figure class="avatar">--}}
{{--                                <img src="{{asset('assets/imgs/5.jpg')}}" alt="image" class="img">--}}
{{--                            </figure>--}}
{{--                            <h3 class="f-heading">--}}
{{--                                <a class="model-popup" href="#">Hurin Seary</a>--}}
{{--                            </h3>--}}
{{--                            <span class="ms-auto  badge  text-grey-500 badge-pill">4:09 pm</span>--}}
{{--                        </li>--}}
{{--                        <li class="bg-transparent">--}}
{{--                            <figure class="avatar">--}}
{{--                                <img src="{{asset('assets/imgs/6.png')}}" alt="image" class="img">--}}
{{--                            </figure>--}}
{{--                            <h3 class="f-heading">--}}
{{--                                <a class="model-popup" href="#">David Goria</a>--}}
{{--                            </h3>--}}
{{--                            <span class="ms-auto badge  text-grey-500 badge-pill ">2 days</span>--}}
{{--                        </li>--}}
{{--                        <li class="bg-transparent">--}}
{{--                            <figure class="avatar">--}}
{{--                                <img src="{{asset('assets/imgs/7.jpg')}}" alt="image" class="img">--}}
{{--                            </figure>--}}
{{--                            <h3 class="f-heading">--}}
{{--                                <a class="model-popup" href="#">Seary Victor</a>--}}
{{--                            </h3>--}}
{{--                            <span class="bg-success ms-auto btn-round-xss"></span>--}}
{{--                        </li>--}}
{{--                        <li class="bg-transparent">--}}
{{--                            <figure class="avatar">--}}
{{--                                <img src="{{asset('assets/imgs/8.jpg')}}" alt="image" class="img">--}}
{{--                            </figure>--}}
{{--                            <h3 class="f-heading">--}}
{{--                                <a class="model-popup" href="#">Ana Seary</a>--}}
{{--                            </h3>--}}
{{--                            <span class="bg-success ms-auto btn-round-xss"></span>--}}
{{--                        </li>--}}
                    </ul>
                </div>
                <div class="Groups">
                    <h4 class="heading">GROUPS</h4>
                    <ul class="list-group">


                    @if(sizeof(@$auth_user_groups) > 0)
                            @foreach($auth_user_groups as $a => $a_row)
                        <li class="bg-transparent">
                            <span class="btn-round-sm bg-primary-gradiant me-3 ls-3 text-white  fw-700">
                                {{strtoupper(@$a_row->group->name[0])}}</span>
                            <h3 class="fw-700 mb-0">
                                <a class="group-chat" href="#">{{@$a_row->group->name}}</a>
                            </h3>
{{--                            <span class="badge  text-grey-500 badge-pill ms-auto ">2 min</span>--}}
                        </li>
                            @endforeach
                        @else
                            <li class="bg-transparent">
{{--                                <span class="btn-round-sm bg-primary-gradiant me-3 ls-3 text-white  fw-700">UD</span>--}}
                                <h3 class="fw-700 mb-0">
                                    <a class="group-chat">No Group Available</a>
                                </h3>
                            </li>
                        @endif
{{--                        <li class="bg-transparent">--}}
{{--                            <span class="btn-round-sm bg-gold-gradiant me-3 ls-3 text-white  fw-700">AR</span>--}}
{{--                            <h3 class="fw-700 mb-0">--}}
{{--                                <a class="group-chat" href="#">Armany Design</a>--}}
{{--                            </h3>--}}
{{--                            <span class="ms-auto mr-3 bg-warning  btn-round-xss"></span>--}}
{{--                        </li>--}}
{{--                        <li class="bg-transparent">--}}
{{--                            <span class="btn-round-sm bg-mini-gradiant me-3 ls-3 text-white font-xssss fw-700">UD</span>--}}
{{--                            <h3 class="fw-700 mb-0 mt-0">--}}
{{--                                <a class="group-chat" href="#">De fabous</a>--}}
{{--                            </h3>--}}
{{--                            <span class="bg-success ms-auto mr-3 btn-round-xss"></span>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </div>
    </nav>
</div>
