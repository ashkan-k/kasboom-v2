@extends('layouts.front-mastermaster_course')

@section('Page_Title')
    آموزشگاه کسب بوم - نقشه راه
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <!-- Roadmap Header -->
    <div class="roadmap-section">
        <div class="section-inner">
            <div class="container">
                <div class="roadmap-header">
                    <div class="img-container">
                        <div class="img-inner">
                            <img src="{{url("_upload_/_roadmaps_/$roadmap->code/$roadmap->banner")}}"
                                 alt="{{$roadmap->title}}">
                        </div>
                        <div class="overlay">
                            <span>{{$roadmap->title}}</span>
                        </div>
                    </div>
                </div>
                <div class="roadmap-body">
                    <div class="grid-layout" id="main-steps">
                        <div class="side">
                            <div class="side-inner">
                                <ul class="steps-list">
                                    @foreach($contents as $content)
                                        <li class="step-item"><span>{{$content->title}}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="side-overlay"></div>
                        </div>
                        <div class="main">
                            <div class="show-slide">
                                <button type="button" class="btn btn-secondary icon-right" id="btnshow-side">
                                    <i class="mdi mdi-format-list-numbered-rtl"></i>
                                    نمایش مراحل
                                </button>
                            </div>
                            <div class="section-media">
                                <div class="media-inner">
                                    <div class="media">
                                        <a href="{{$roadmap->link_consult}}">
                                            <span class="icon"><i class="mdi mdi-message-text"></i></span>
                                            <span class="name">مشاوره‌ها</span>
                                        </a>
                                    </div>
                                    <div class="media">
                                        <a href="{{$roadmap->link_video}}">
                                            <span class="icon"><i class="mdi mdi-video-outline"></i></span>
                                            <span class="name">ویدئوها</span>
                                        </a>
                                    </div>
                                    <div class="media">
                                        <a href="{{$roadmap->link_course}}">
                                            <span class="icon"><i class="mdi mdi-school-outline"></i></span>
                                            <span class="name">دوره‌ها</span>
                                        </a>
                                    </div>
                                    <div class="media">
                                        <a href="{{$roadmap->link_webinar}}">
                                            <span class="icon"><i class="mdi mdi-video-wireless-outline"></i></span>
                                            <span class="name">وبینارها</span>
                                        </a>
                                    </div>
                                    <div class="media">
                                        <a href="{{$roadmap->link_store}}">
                                            <span class="icon"><i class="mdi mdi-storefront-outline"></i></span>
                                            <span class="name">فروشگاه</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @foreach($contents as $content)
                                <div class="text-section">
                                    <div class="title">
                                        <div class="shape"></div>
                                        <h2>{{$content->title}} - {{$content->number}}</h2>
                                    </div>
                                    <div class="text-inner">
                                        {!! $content->content !!}
                                    </div>
                                </div>
                            @endforeach

                            <div class="buttons-control-steps">
                                <div class="buttons-inner">
                                    <a href="#main-steps" class="btn-step btn-prev-step" onclick="nextStepsRoadMap(-1)">
                                        <span class="icon"><i class="mdi mdi-arrow-right"></i></span>
                                        <span class="name">مرحله قبلی</span>
                                    </a>
                                    <a href="#main-steps" class="btn-step btn-next-step" onclick="nextStepsRoadMap(1)">
                                        <span class="name">مرحله بعدی</span>
                                        <span class="icon"><i class="mdi mdi-arrow-left"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="education-section">
        <div class="container-lg">
            <div class="title">
                <div class="title-inner">
                    <div class="shape"></div>
                    <h1><a href="#">پرطرفدارترین دوره‌ها</a></h1>
                </div>
                <div class="see-more">
                    <a href="#">
                        <span class="text">مشاهده همه</span>
                        <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
                    </a>
                </div>
            </div>
            <div class="section-inner">
                <div class="swiper swiper-courses" dir="rtl">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card-course" title="نام دوره">
                                <a href="education-details.html">
                                    <div class="img-container">
                                        <div class="img-inner">
                                            <img src="/assets-v2/images/courses/1.jpg" alt="course-name"/>
                                        </div>
                                        <div class="certificate">گواهینامه دارد</div>
                                        <div class="percentage">30%</div>
                                    </div>
                                    <div class="card-b">
                                        <h2>آموزش پیشرفته چرم دوزی</h2>
                                        <div class="info">
                                            <h6>مرضیه افشار</h6>
                                            <div class="price-content off-code">
                                                <div class="price">
                                                    <div class="real">169,000</div>
                                                    <div class="off">100,000</div>
                                                </div>
                                                <div class="text">
                                                    <span class="toman">تومان</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card-course" title="نام دوره">
                                <a href="education-details.html">
                                    <div class="img-container">
                                        <div class="img-inner">
                                            <img src="/assets-v2/images/courses/2.jpg" alt="course-name"/>
                                        </div>
                                        <div class="certificate">گواهینامه دارد</div>
                                        <div class="percentage">30%</div>
                                    </div>
                                    <div class="card-b">
                                        <h2>آموزش پیشرفته چرم دوزی</h2>
                                        <div class="info">
                                            <h6>مرضیه افشار</h6>
                                            <div class="price-content off-code">
                                                <div class="price">
                                                    <div class="real">169,000</div>
                                                    <div class="off">100,000</div>
                                                </div>
                                                <div class="text">
                                                    <span class="toman">تومان</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card-course" title="نام دوره">
                                <a href="education-details.html">
                                    <div class="img-container">
                                        <div class="img-inner">
                                            <img src="/assets-v2/images/courses/3.jpg" alt="course-name"/>
                                        </div>
                                        <div class="certificate">گواهینامه دارد</div>
                                        <div class="percentage">30%</div>
                                    </div>
                                    <div class="card-b">
                                        <h2>آموزش پیشرفته چرم دوزی</h2>
                                        <div class="info">
                                            <h6>مرضیه افشار</h6>
                                            <div class="price-content off-code">
                                                <div class="price">
                                                    <div class="real">169,000</div>
                                                    <div class="off">100,000</div>
                                                </div>
                                                <div class="text">
                                                    <span class="toman">تومان</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card-course" title="نام دوره">
                                <a href="education-details.html">
                                    <div class="img-container">
                                        <div class="img-inner">
                                            <img src="/assets-v2/images/courses/course-04.jpg" alt="course-name"/>
                                        </div>
                                        <div class="certificate">گواهینامه دارد</div>
                                        <div class="percentage">30%</div>
                                    </div>
                                    <div class="card-b">
                                        <h2>آموزش پیشرفته چرم دوزی</h2>
                                        <div class="info">
                                            <h6>مرضیه افشار</h6>
                                            <div class="price-content off-code">
                                                <div class="price">
                                                    <div class="real">169,000</div>
                                                    <div class="off">100,000</div>
                                                </div>
                                                <div class="text">
                                                    <span class="toman">تومان</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card-course" title="نام دوره">
                                <a href="education-details.html">
                                    <div class="img-container">
                                        <div class="img-inner">
                                            <img src="/assets-v2/images/courses/course-05.jpg" alt="course-name"/>
                                        </div>
                                        <div class="certificate">گواهینامه دارد</div>
                                        <div class="percentage">30%</div>
                                    </div>
                                    <div class="card-b">
                                        <h2>آموزش پیشرفته چرم دوزی</h2>
                                        <div class="info">
                                            <h6>مرضیه افشار</h6>
                                            <div class="price-content off-code">
                                                <div class="price">
                                                    <div class="real">169,000</div>
                                                    <div class="off">100,000</div>
                                                </div>
                                                <div class="text">
                                                    <span class="toman">تومان</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card-course" title="نام دوره">
                                <a href="education-details.html">
                                    <div class="img-container">
                                        <div class="img-inner">
                                            <img src="/assets-v2/images/courses/course-06.jpg" alt="course-name"/>
                                        </div>
                                        <div class="certificate">گواهینامه دارد</div>
                                        <div class="percentage">30%</div>
                                    </div>
                                    <div class="card-b">
                                        <h2>آموزش پیشرفته چرم دوزی</h2>
                                        <div class="info">
                                            <h6>مرضیه افشار</h6>
                                            <div class="price-content off-code">
                                                <div class="price">
                                                    <div class="real">169,000</div>
                                                    <div class="off">100,000</div>
                                                </div>
                                                <div class="text">
                                                    <span class="toman">تومان</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Add Options -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('Page_JS')

@endsection
