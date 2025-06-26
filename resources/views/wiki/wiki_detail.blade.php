@extends('master')

@section('Page_Title')
{{$idea->title}} کسبوم - ایده های کسب و کار
@endsection

@section('Page_CSS_Before')

@endsection

@section('Page_CSS_After')

@endsection

@section('SliderDiv')
@endsection


@section('Content')
    <div class="sptb" >
        <div class="header-text1 mb-0">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-12 col-md-12 d-block mx-auto">
                        <div class="text-center text-white text-property">
                            <br>
                            <br>
                            <h3 class="" style="font-family: VazirBold">{{$idea->title}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /header-text -->
    </div>

    <!--Section-->
    <section class="sptb" style="background-image: url('img/islamic/bg4.png')">
        <br>
        <br>
        <div class="container" >
            <div class="row" >
                <!--/Left Side Content-->
                <div class="col-xl-2 col-lg-2 text-left">
                </div>
                <!--Coursed Lists-->
                <div class="col-xl-8 col-lg-8 col-md-12" >
                    <div class="card blog-detail" >
                        <div class="card overflow-hidden">
                            <div class="card-body" >
                                <div class="item-det">
                                    <div class="arrow-ribbon bg-primary">{{$idea->title}}</div>
                                    <br>
                                    <br>
                                    {{--<a  class="text-dark"><h3>{{$idea->title}}</h3></a>--}}
                                    <div class=" d-flex">
                                        <ul class="d-flex mb-0">
                                            <li class="ml-5"><a class="icons"><i class="fa fa-cube ml-1"></i>{{$idea->category->title}}</a></li>
                                        </ul>
                                        <div class="rating-stars d-flex ml-5">
                                            <input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value" id="rating-stars-value" value="{{$idea->score}}">
                                            <div class="rating-stars-container ml-2">
                                                <div class="rating-star sm">
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="rating-star sm">
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="rating-star sm">
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="rating-star sm">
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="rating-star sm">
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div> {{$idea->score}}
                                        </div>
                                        {{--<div class="rating-stars d-flex">--}}
                                            {{--<div class="rating-stars-container ml-2">--}}
                                                {{--<div class="rating-star sm">--}}
                                                    {{--<i class="fa fa-heart"></i>--}}
                                                {{--</div>--}}
                                            {{--</div> {{$idea->like_count}}--}}
                                        {{--</div>--}}
                                        <div class="mr-auto">
                                            <a class="text-muted"><i class="fa fa-eye ml-2"></i>{{$idea->view_count}} بازدید </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-center">

                                        @if($idea->cloud_url != '')
                                            <video autoplay="" controls="" style="cursor: pointer" poster="">
                                                <source src="{{$idea->cloud_url}}" type="application/dash+xml">
                                            </video>
                                        @else
                                            <img src="_upload_/_wikiideas_/{{$idea->code}}/{{$idea->image}}" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-0 mb-5">
                            <div class="wideget-user-tab wideget-user-tab3">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <ul class="nav" id="tab_menu">
                                            <li><a href="#tab-1" class="active" data-toggle="tab">اطلاعات کلی</a></li>
                                            <li><a href="#tab-2" data-toggle="tab" class="">توضیحات</a></li>
                                            <li><a href="#tab-4" data-toggle="tab" class="">نظرات</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content border-left border-right p-5 bg-white details-tab-content">
                                <div class="tab-pane active" id="tab-1">
                                    <h3 class="card-title mb-3 font-weight-bold">اطلاعات کلی ایده کسب و کار</h3>
                                    <ul class="list-group mb-5">
                                        <li class="mb-2"><i class="fa fa-check" aria-hidden="true"></i><span style="font-family: VazirMedium"> گروه آموزشی :  </span><span style="margin-right: 20px;font-family: VazirBold">{{$idea->category->title}}</span></li>
                                        <li class="mb-2"><i class="fa fa-check" aria-hidden="true"></i><span style="font-family: VazirMedium"> کف سرمایه :  </span><span style="margin-right: 25px;font-family: VazirBold">{{$idea->minimal_fund}} تومان </span></li>
                                        <li class="mb-2"><i class="fa fa-check" aria-hidden="true"></i><span style="font-family: VazirMedium"> ریسک :  </span><span style="margin-right: 52px;font-family: VazirBold">{{$idea->risk}}</span></li>
                                        <li class="mb-2"><i class="fa fa-check" aria-hidden="true"></i><span style="font-family: VazirMedium"> سودآوری :  </span><span style="margin-right: 38px;font-family: VazirBold">{{$idea->profitability}}</span></li>
                                        <li class="mb-2"><i class="fa fa-check" aria-hidden="true"></i><span style="font-family: VazirMedium"> نیروی انسانی :  </span><span style="margin-right: 15px;font-family: VazirBold">{{$idea->manpower}}</span></li>
                                        <li class="mb-2"><i class="fa fa-check" aria-hidden="true"></i><span style="font-family: VazirMedium"> مقیاس :  </span><span style="margin-right: 45px;font-family: VazirBold">{{$idea->scale}}</span></li>
                                    </ul>
                                    <h3 class="card-title mb-3 font-weight-bold">توضیح کوتاه</h3>
                                    <div class="mb-0">
                                        <p>
                                            {{$idea->abstractMemo}}
                                        </p>
                                    </div>

                                </div>
                                <div class="tab-pane" id="tab-2">
                                    <h3 class="card-title mb-3 font-weight-bold">محتوا و سرفصل های آموزشی</h3>
                                    <div class="mb-4">
                                        <p  style="font-family: VazirThin">
                                            {!! $idea->memo !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-4">
                                    {{--<div class="row">--}}
                                        {{--<div class="col-md-12">--}}
                                            {{--<div class="mb-4">--}}
                                                {{--<p class="mb-2">--}}
                                                    {{--<span class="fs-14 mr-2"><i class="fa fa-star text-yellow ml-2"></i>5</span>--}}
                                                {{--</p>--}}
                                                {{--<div class="progress progress-md mb-4 h-4">--}}
                                                    {{--<div class="progress-bar bg-success w-100">{{$idea->score5}}</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="mb-4">--}}
                                                {{--<p class="mb-2">--}}
                                                    {{--<span class="fs-14 mr-2"><i class="fa fa-star text-yellow ml-2"></i>4</span>--}}
                                                {{--</p>--}}
                                                {{--<div class="progress progress-md mb-4 h-4">--}}
                                                    {{--<div class="progress-bar bg-info w-80">{{$idea->score4}}</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="mb-4">--}}
                                                {{--<p class="mb-2">--}}
                                                    {{--<span class="fs-14 mr-2"><i class="fa fa-star text-yellow ml-2"></i>  3</span>--}}
                                                {{--</p>--}}
                                                {{--<div class="progress progress-md mb-4 h-4">--}}
                                                    {{--<div class="progress-bar bg-primary w-60">{{$idea->score3}}</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="mb-4">--}}
                                                {{--<p class="mb-2">--}}
                                                    {{--<span class="fs-14 mr-2"><i class="fa fa-star text-yellow ml-2"></i>  2</span>--}}
                                                {{--</p>--}}
                                                {{--<div class="progress progress-md mb-4 h-4">--}}
                                                    {{--<div class="progress-bar bg-secondary w-30">{{$idea->score2}}</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="mb-0">--}}
                                                {{--<p class="mb-2">--}}
                                                    {{--<span class="fs-14 mr-2"><i class="fa fa-star text-yellow ml-2"></i>  1</span>--}}
                                                {{--</p>--}}
                                                {{--<div class="progress progress-md mb-4 h-4">--}}
                                                    {{--<div class="progress-bar bg-orange w-20">{{$idea->score1}}</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="row">
                                        <div class="card">
                                            {{--<div class="card-header">--}}
                                                {{--<h3 class="card-title">نظرات کاربران</h3>--}}
                                            {{--</div>--}}
                                            <div class="p-0">
                                                @foreach($comments as $comment)
                                                    <?php $user_name=str_replace(' ','_',$comment->user->name); ?>
                                                    <div class="media p-4">
                                                        <div class="d-flex ml-3">
                                                            <a href="user/{{$comment->user->id}}/{{$user_name}}">
                                                                <img class="media-object brround" alt="{{$comment->user->name}}" src="_upload_/_users_/{{$comment->user->id}}/personal/{{$comment->user->image}}" />
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="mt-0 mb-1 font-weight-bold">{{$comment->user->name}}
                                                            </h4>
                                                            <span class="fs-14 ml-2 float-right"> {{$comment->score}}
                                                                <i class="fa fa-star text-yellow"></i>
											                </span>
                                                            <small class="text-muted"><i class="fa fa-calendar mr-3 ml-1"></i> {{$comment->regist_date}}  </small>
                                                            <p class="fs-15  mb-2 mt-2">
                                                                {{$comment->comment}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card mb-lg-0">
                        <div class="card-header">
                            <h3 class="card-title">ارسال نظر</h3>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <div>
                                    <div class="form-group">
                                        <select class="form-control" id="comment_score">
                                            <option  value="1">بد</option>
                                            <option value="2">ضعیف</option>
                                            <option selected value="3">متوسط</option>
                                            <option value="4">خوب</option>
                                            <option value="5">عالی</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <textarea class="form-control" name="example-textarea-input" id="comment_memo" maxlength="999" rows="6" placeholder="متن نظر"></textarea>
                                    </div>
                                    @if(Auth::check())
                                        <button onclick="send_comment('idea',{{$idea->id}})" class="btn btn-primary">ارسال نظر</button>
                                    @else
                                        <button disabled readonly="" class="btn btn-primary">برای ارسال نظر وارد سایت شوید</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <br>
                <!--/Coursed Lists-->
                <div class="col-xl-2 col-lg-2 text-left">
                    <div style="margin-bottom: 20px;margin-left: 10px">
                        <a href="blogs" class="btn btn-info"> برگشت به صفحه مطالب&nbsp;<i class="fa fa-backward"></i></a>
                    </div>
                </div>

            </div>
        </div>
        <br>
    </section>
    <!--Coursed Listing-->


@endsection


@section('Page_JS')
    <script src="assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js"></script>

    <!-- Swipe js-->
    <script src="assets/js/swipe.js"></script>
@endsection
