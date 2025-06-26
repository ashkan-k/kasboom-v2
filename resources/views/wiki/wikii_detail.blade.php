@extends('wiki.master_wikiidea')

@section('Page_Title')
{{$idea->title}} بلاگ کسب بوم -
@endsection

@section('Page_CSS_Before')

@endsection

@section('Page_CSS_After')

@endsection

@section('SliderDiv')
@endsection


@section('Content')

<section class="container mt-5">
    <div class="row">
        <div class="col-lg-8 mb-5 order-1 order-lg-0">
            <div class="box p-4 text-justify">
                <h5 class="pt-3 IRANSansWeb_Medium">{{$idea->title}}</h5>
                <div class="item7-card-desc d-flex mb-2 mt-3">
                    <a class="text-muted IRANSansWeb_Light"><i class="fa fa-calendar-o ml-2"></i>{{$idea->registe_date}}</a>
                    <div class="mr-auto">
                        <a class="text-muted IRANSansWeb_Light"><i class="fa fa-comment-o ml-2"></i>{{count($comments)}} نظر</a>
                    </div>
                    <div class="mr-auto">
                        <a class="text-muted IRANSansWeb_Light"><i class="fa fa-eye ml-2"></i>{{$idea->view_count}} بازدید </a>
                    </div>
                    <div class="mr-auto">
                        <a class="text-danger IRANSansWeb_Light"><i class="fa fa-heart ml-2"></i>{{$idea->like_count}} پسند </a>
                    </div>
                    <div class="mr-auto">
                        <a class="text-warning IRANSansWeb_Light"><i class="fa fa-star ml-2"></i>{{$idea->score}} </a>
                    </div>
                </div>
                @if(($idea->cloud_url != '') or ($idea->intro_video != ''))
                @if (strpos($idea->cloud_url, 'aparat.com') !== false)
                <iframe style="width: 100%;height: 400px" src="{{$idea->cloud_url}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                @else
                @if($idea->intro_video != null)
                <video width="100%" height="100%" controls>
                    <source src="_upload_/_wikiideas_/{{$idea->code}}/{{$idea->intro_video}}" type="video/mp4">
                </video>
                @else
                <video autoplay="" controls="" style="cursor: pointer" poster="">
                    <source src="{{$idea->cloud_url}}" type="application/dash+xml">
                </video>
                @endif
                @endif
                @else
                <img src="_upload_/_wikiideas_/{{$idea->code}}/{{$idea->image}}" style="width: 100%" />
                @endif
                <p>
                <div class="tab-pane active" id="tab-1">
                    <h3 class="card-title mb-3 font-weight-bold">اطلاعات کلی ایده کسب و کار</h3>
                    <ul class="list-group mb-5">
                        <li class="mb-2 IRANSansWeb_Light"><i class="fa fa-check" aria-hidden="true"></i> گروه آموزشی : <span class="IRANSansWeb_Medium p-4">{{$idea->category->title}}</span></li>
                        <li class="mb-2 IRANSansWeb_Light"><i class="fa fa-check" aria-hidden="true"></i> کف سرمایه : <span class="IRANSansWeb_Medium p-4">{{number_format($idea->minimal_fund)}} تومان </span></li>
                        <li class="mb-2 IRANSansWeb_Light"><i class="fa fa-check" aria-hidden="true"></i> ریسک : <span class="IRANSansWeb_Medium p-7">{{$idea->risk}}</span></li>
                        <li class="mb-2 IRANSansWeb_Light"><i class="fa fa-check" aria-hidden="true"></i> سودآوری : <span class="IRANSansWeb_Medium p-6">{{$idea->profitability}}</span></li>
                        <li class="mb-2 IRANSansWeb_Light"><i class="fa fa-check" aria-hidden="true"></i> نیروی انسانی : <span class="IRANSansWeb_Medium p-4">{{$idea->manpower}}</span></li>
                        <li class="mb-2 IRANSansWeb_Light"><i class="fa fa-check" aria-hidden="true"></i> مقیاس : <span class="IRANSansWeb_Medium p-7">{{$idea->scale}}</span></li>
                    </ul>
                </div>
                </p>
                <p style="font-family: VazirMedium;font-size: larger">
                    {!! $idea->memo !!}
                </p>

                @if($idea->attach_file != null)
                <p>
                <h6 class="mt-0 mb-1 font-weight-bold"> دانلود فایل ضمیمه: <a href="_upload_/_wikiideas_/{{$idea->code}}/attach/{{$idea->attach_file}}" target="_blank"><i class="fa fa-download">&nbsp;دانلود</i> </a></h6>
                </p>
                @endif
                @if($idea->resource_name != null)
                <p>
                <h6 class="mt-0 mb-1 font-weight-bold"> منبع: {{$idea->resource_name}}</h6>
                </p>
                @endif

                <?php $hashtags = explode("#", $idea->hashtags); ?>
                <ul class="inline">
                    @foreach($hashtags as $hashtag)
                    @if($hashtag != null)
                    <li>
                        <a class="key-word">#{{$hashtag}}</a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-4 order-0 order-lg-1 ">

            <div class="box card text-center">
                <div id="prof" class="card-body relative">
                    <img class="pic90 rounded-circle absolute" src="_upload_/_users_/{{$idea->writer->id}}/personal/{{$idea->writer->image}}" alt="" style="top:-30px;right:40%">
                    <h6 class="IRANSansWeb_Medium mt-5">{{$idea->writer->name}}</h6>
                    <p class="bottom_p IRANSansWeb_Medium">{{$idea->writer->last_education}}</p>
                    <span class="bg-warning py-1 px-2 text-white text-shadow rad25 IRANSansWeb_Light">{{$idea->like_count}} <i class="fa fa-heart"></i> </span>
                    @if($idea->writer->like_count > 0)
                    - <span class="IRANSansWeb_Medium text-danger IRANSansWeb_Light">{{$idea->writer->like_count}} <i class="fa fa-eye"></i> </span>
                    @endif

                    {{--<div class="px-3 py-1 my-3 dash rad12 d-flex flex-row text-center">--}}
                    {{--<div class="flex-fill">--}}
                    {{--<p class="mb-0 IRANSansWeb_Medium">1245</p>--}}
                    {{--<span>تعداد بازدید</span>--}}
                    {{--</div>--}}
                    {{--<div class="flex-fill">--}}
                    {{--<p class="mb-0 IRANSansWeb_Medium">{{$idea->writer->regist_date}}</p>--}}
                    {{--<span>عضویت</span>--}}
                    {{--</div>--}}

                    {{--</div>--}}
                    <div class="d-flex flex-md-row flex-column">
                        <a href="wikiidea/writer/{{$idea->writer->id}}/{{gethttplink($idea->writer->name)}}" class="btn btn-success btn-block text-white m-2 rad25">سایر ایده های کاربر</a>

                    </div>


                </div>
            </div>

            <div class="blogpost text-right">
                <h5 class="IRANSansWeb_Medium p-3">ایده های مرتبط</h5>
                <ul class="box pt-3">
                    @foreach($related_ideas as $midea)
                    <?php $idea_title = str_replace(' ', '_', $midea->title); ?>
                    <li>
                        <div class="px-3 d-flex flex-row">
                            <a href="wikiidea/idea/{{$midea->id}}/{{$idea_title}}" class="bg-red rounded">
                                <img src="_upload_/_wikiideas_/{{$midea->code}}/small_{{$midea->image}}" class="img-fluid rounded " style="" />
                            </a>
                            <a href="wikiidea/idea/{{$midea->id}}/{{$idea_title}}" class="pr-3 flex-fill">
                                <h3 class="IRANSansWeb_Medium blog-item-title">{{$midea->title}}</h3>
                                <span class="float-right gray11">{{$midea->writer->name}}</span>
                                <span class="float-left gray11 IRANSansWeb_Light"><i class="fas fa-clock ml-1"></i>{{$midea->registe_date}}</span>
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>

            </div>

        </div>
    </div>

    <div class="row text-right">
        <div class="col-md-12 box mt-2 p-4 ">
            <h5 class="IRANSansWeb_Medium mb-4 bt-color">دیگر ایده های {{$idea->writer->name}}</h5>
            <div id="owl-toppost" class="owl-carousel text-right ">
                @foreach($user_ideas as $uidea)
                <?php $idea_title = str_replace(' ', '_', $uidea->title); ?>
                <div class="mx-2">
                    <a href="wikiidea/idea/{{$uidea->id}}/{{$idea_title}}">
                        <img src="_upload_/_wikiideas_/{{$uidea->code}}/medium_{{$uidea->image}}" class="img-fluid rad25 bigpic" alt="{{$uidea->title}}" />
                        <div class="blogdiv label-warning" style="padding:0 5px 0 5px">
                            <h6 class="IRANSansWeb_Medium text-white text-shadow">{{$uidea->title}}</h6>
                        </div>

                    </a>

                </div>
                @endforeach
            </div>

        </div>
    </div>

    <div class="row text-right">
        <div class="col-md-12 box mt-2 p-4 ">
            <h5 class="IRANSansWeb_Medium bg-light py-2 px-3  mb-4 rad25">نظرات کاربران</h5>

            <ul>
                @foreach($comments as $comment)
                <?php $user_name = str_replace(' ', '_', $comment->user->name); ?>
                <li>
                    <div class="d-flex flex-row flex-wrap justify-content-between dash rad25 m-md-3 m-1 p-3">
                        <div>
                            <span class="IRANSansWeb_Medium pl-4">
                                <a href="profile/{{$comment->user->id}}/{{$user_name}}">{{$comment->user->name}} </a>
                            </span>
                            <span class="IRANSansWeb_Light">
                                <i class="fa fa-star text-warning"></i> {{$comment->score}}
                            </span>
                            <p class="mb- IRANSansWeb_Light"> {{$comment->comment}}</p>
                        </div>

                        <div class="float-left">
                            <span class="IRANSansWeb_Light">{{$comment->registe_date}}</span>
                        </div>

                    </div>
                </li>


                @endforeach


            </ul>
            <div class="text-center" id="paginate">
                <ul class="pagination mt-3">
                    {{ $comments->links( "pagination::bootstrap-4") }}
                </ul>
            </div>

            <div class="py-3 px-sm-5 sencom">
                <h6 class="IRANSans-Bold pl-2 ml-3 IRANSansWeb_Medium">ارسال نظر :</h6>
                <img src="assets_consult/Images/avatar.jpg" class="img-fluid mb-2 rounded-circle" />
                <div class="form-group">
                    <select style="width: 100%" id="comment_score">
                        <option value="1">بد</option>
                        <option value="2">ضعیف</option>
                        <option value="3" selected>متوسط</option>
                        <option value="4">خوب</option>
                        <option value="5">عالی</option>
                    </select>
                </div>
                <div class="form-group ">
                    <textarea rows="6" style="width: 100%" name="example-textarea-input" id="comment_memo" maxlength="999" placeholder="متن نظر"></textarea>
                </div>
                @if(Auth::check())
                <button onclick="send_comment('idea',{{$idea->id}})" class="btn btn-primary">ارسال نظر</button>
                @else
                <button disabled readonly="" class="btn btn-primary">برای ارسال نظر وارد سایت شوید</button>
                @endif
            </div>
        </div>
    </div>
</section>


<section class="d-flex justify-content-center m-sm-4 m-3 " style="width: 100%">
</section>



@endsection


@section('Page_JS')
<script src="assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js"></script>

@endsection