@extends('layouts.front-master')

@section('Page_Title')کسب بوم - ایده های کسب و کار@endsection

@section('Page_CSS_Before')@endsection

@section('Page_CSS_After')@endsection

@section('Content')
    <!-- Ideas Header -->
    <div class="ideas-header">
        <div class="idea-inner">
            <img src="/assets-v2/images/idea_banner.jpg" alt="ایده های کسب و کار کسب بوم">
        </div>
    </div>
    <!-- Small Category -->
    <div class="small-category">
        <div class="container-lg">
            <div class="category-inner">
                <div class="item">
                    <a href="wikiidea/cat/صنایع_فرش__و_قالی">
                        <div class="icon">
                            <img src="/assets-v2/images/small-category/category-carpet.png" alt="category">
                        </div>
                        <h3 class="text">فرش و قالی</h3>
                    </a>
                </div>

                <div class="item">
                    <a href="wikiidea/cat/صنایع_نساجی_و__پوشاك">
                        <div class="icon">
                            <img src="/assets-v2/images/small-category/category-cloth.png" alt="category">
                        </div>
                        <h3 class="text">نساجی و پوشاک</h3>
                    </a>
                </div>

                <div class="item">
                    <a href="wikiidea/cat/صنایع_دستی">
                        <div class="icon">
                            <img src="/assets-v2/images/small-category/category-dasti.png" alt="category">
                        </div>
                        <h3 class="text">صنایع دستی</h3>
                    </a>
                </div>

                <div class="item">
                    <a href="wikiidea/cat/کشاورزی؛گیاهی_و_غذایی">
                        <div class="icon">
                            <img src="/assets-v2/images/small-category/category-farm.png" alt="category">
                        </div>
                        <h3 class="text">صنایع تبدیلی</h3>
                    </a>
                </div>

                <div class="item">
                    <a href="wikiidea/cat/دام_و_طیور_و_شیلات">
                        <div class="icon">
                            <img src="/assets-v2/images/small-category/category-dam-tior.png" alt="category">
                        </div>
                        <h3 class="text">دام و طیور</h3>
                    </a>
                </div>

                <div class="item">
                    <a href="wikiidea/cat/کشاورزی؛گیاهی_و_غذایی">
                        <div class="icon">
                            <img src="/assets-v2/images/small-category/category-cake.png" alt="category">
                        </div>
                        <h3 class="text">صنایع غذایی</h3>
                    </a>
                </div>

                <div class="item">
                    <a href="wikiidea/cat/_فرهنگی_و_هنری">
                        <div class="icon">
                            <img src="/assets-v2/images/small-category/category-cinema.png" alt="category">
                        </div>
                        <h3 class="text">فرهنگی هنری</h3>
                    </a>
                </div>

                <div class="item">
                    <a href="skill/category/8/فنی_و_خدماتی">
                        <div class="icon">
                            <img src="/assets-v2/images/small-category/category-fani.png" alt="category">
                        </div>
                        <h3 class="text">فنی و خدماتی</h3>
                    </a>
                </div>

                <div class="item">
                    <a href="wikiidea/cat/فناوری_اطلاعات">
                        <div class="icon">
                            <img src="/assets-v2/images/small-category/category-it.png" alt="category">
                        </div>
                        <h3 class="text">رسانه و IT</h3>
                    </a>
                </div>

                <div class="item">
                    <a href="wikiidea/cat/مهارت_های_نرم_فردی">
                        <div class="icon">
                            <img src="/assets-v2/images/small-category/category-brain.png" alt="category">
                        </div>
                        <h3 class="text">مهارت فردی</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>



    <!-- Idea mainContent -->
    <div class="education-section">
        <div class="container-lg">
            <div class="title">
                <div class="title-inner">
                    <div class="shape"></div>
                    <h1>ایده های کسب و کار</h1>
                </div>
                <div class="see-more">
                    <a href="{{url('wikiidea/cat/getAllCat')}}">
                        <span class="text">مشاهده همه</span>
                        <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
                    </a>
                </div>
            </div>
            <div class="idea-grid-layout">
                <div class="layout-inner">
                    @foreach($ideas as $idea)
                        <div class="card-idea">
                            <div class="card-inner">
                                <a href="{{url('wikiidea/details/' . $idea->id)}}" title="{{$idea->title}}">
                                    <figure class="idea-pic">
                                        <div class="img-inner">
                                            <img src="_upload_/_wikiideas_/{{$idea->code}}/medium_{{$idea->image}}"
                                                 alt="{{$idea->title}}"/>
                                        </div>
                                    </figure>
                                    <div class="card-b" title="{{$idea->abstractMemo}}">
                                        <h2 class="name">{{$idea->title}}</h2>
                                        <ul class="idea-property">
                                            <li><i class="mdi mdi-shape"></i><span>{{$idea->category?->title}}</span>
                                            </li>
                                            <li><i class="mdi mdi-wallet"></i><span>ریسک: {{$idea->risk}}</span></li>
                                            <li>
                                                <i class="mdi mdi-clock"></i><span>سودآوری: {{$idea->profitability}}</span>
                                            </li>
                                            <li>
                                                <i class="mdi mdi-account-multiple"></i><span>نیروی انسانی: {{$idea->manpower}}</span>
                                            </li>
                                        </ul>
                                        <div class="price">
                                            <h6>کف سرمایه : </h6>
                                            <div class="number">{{number_format($idea->minimal_fund)}}</div>
                                            <div class="toman">تومان</div>
                                        </div>
                                        <div class="other-info">
                                            <ul class="status-list">
                                                <li><i class="mdi mdi-eye-outline"></i>
                                                    {{$idea->view_count != null ? $idea->view_count : 0}}
                                                </li>
                                                <li><i class="mdi mdi-heart-outline"></i>
                                                    {{$idea->like_count != null ? $idea->like_count : 0}}
                                                </li>
                                                <li><i class="mdi mdi-star-outline"></i>
                                                    {{$idea->score != null ? $idea->score : 0}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Idea Big Banner -->
    <div class="idea-big-banner">
        <div class="box-bg right-box">
            <div class="box-inner blurred-container">
                <h2>ثبت ایده</h2>
                <p>ایده کسب و کار خود را جهت به اشتراک گذاری ثبت کنید</p>
                <div class="link">
                    <a href="{{url('web')}}" class="btn btn-white icon-right"><i class="mdi mdi-lightbulb-on"></i>ثبت
                        ایده</a>
                </div>
            </div>
        </div>
        <div class="box-bg left-box">
            <div class="box-inner blurred-container">
                <h2>آمایش سرزمینی</h2>
                <p>کسب و کار منظقه زندگی خودت رو بشناسید</p>
                <div class="link">
                    <a href="{{url('landuse')}}" class="btn btn-white icon-right"><i class="mdi mdi-eye"></i>مشاهده</a>
                </div>
            </div>
        </div>
    </div>

    @if(false)
        <!-- Idea Teammate -->
        <div class="education-section">
            <div class="container-lg">
                <div class="title">
                    <div class="title-inner">
                        <div class="shape"></div>
                        <h1>هم‌تیمی شور</h1>
                    </div>
                    <div class="see-more">
                        <a href="ideas-teammate-list.html">
                            <span>مشاهده همه</span>
                            <div class="icon"><i class="mdi mdi-arrow-left"></i></div>
                        </a>
                    </div>
                </div>
                <div class="teammate-inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card-teammate">
                                <div class="card-inner">
                                    <a href="ideas-details.html">
                                        <figure class="idea-pic">
                                            <div class="img-inner">
                                                <img src="images/blogs/blog-01.jpg" alt="pic-name"/>
                                            </div>
                                        </figure>
                                        <div class="user-pic">
                                            <img src="images/consulant-img/user-img-1.png" alt="user name"/>
                                        </div>
                                        <div class="card-b">
                                            <h1>تولید برق از منابع طبیعی و جاذبه زمین</h1>
                                            <ul>
                                                <li><span>ایده پرداز : </span>سمیر دغاغله</li>
                                                <li><span>سرمایه اولیه : </span>200,000,000 تومان</li>
                                            </ul>
                                        </div>
                                        <div class="card-f">
                                            <ul class="status-list">
                                                <li><i class="mdi mdi-eye-outline"></i>619</li>
                                                <li><i class="mdi mdi-heart-outline"></i>22</li>
                                            </ul>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Comments -->
    <div class="comments-section">
        <div class="container-lg">
            <div class="title">
                <h1>نظرات کاربران</h1>
                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ است</p>
            </div>
            <div class="section-inner">
                <div class="swiper swiper-comments" dir="rtl">
                    <div class="swiper-wrapper">
                        @foreach($comments as $comment)
                            <div class="swiper-slide">
                                <div class="comment-body">
                                    <div class="comment-header">
                                        <div class="user-img">
                                            <img src="/assets-v2/images/icons/user-comment.svg"/>
                                        </div>
                                        <div class="user-info">
                                            <h4>{{$comment->user?->name}}</h4>
                                            <div class="date">
                                                <div class="time">{{$comment->regist_date}}</div>
                                            <!-- <div class="rate">{{$comment->score}}<i class="mdi mdi-star"></i></div> -->
                                            </div>
                                            <div class="text"> {{$comment->comment}} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach()
                    </div>
                    <!-- Add Options -->
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('Page_JS')@endsection
