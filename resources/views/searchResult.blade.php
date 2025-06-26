@extends('layouts.front-master')

@section('Page_Title')
    کسبوم - جستجو
@endsection

@section('Content')
    <div class="page-background">
        <div class="text">
            <div class="text-inner">
                <h2>نتایج جستجو</h2>
            </div>
        </div>
    </div>

    {{-- content --}}
    <div class="search-result-section">
        <div class="result-inner">
            <!-- دوره -->
            @if (count($courses) > 0)
                <div class="education-section">
                    <div class="container-lg">
                        <div class="title">
                            <div class="title-inner">
                                <div class="shape"></div>
                                <h1>جستجو در دوره ها</h1>
                            </div>
                            <div class="see-more">
                                <a href="skill/category/0?search={{request()->search_title}}">
                                    <span class="text">مشاهده همه</span>
                                    <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
                                </a>
                            </div>
                        </div>
                        <div class="section-inner">
                            <div class="swiper swiper-courses" dir="rtl">
                                <div class="swiper-wrapper">
                                    @foreach($courses as $row)
                                        <?php $title = str_replace(' ', '_', $row->title); ?>
                                        <div class="swiper-slide">
                                            <div class="card-course" title="{{$row->title}}">
                                                <a href="course/{{$row->getSlug()}}">
                                                    <div class="img-container">
                                                        <div class="img-inner">
                                                            <img
                                                                src="_upload_/_courses_/{{$row->code}}/medium_{{$row->image}}"
                                                                alt="{{$row->title}}"/>
                                                        </div>
                                                        @if($row->have_certificate === 1)
                                                            <div class="certificate">گواهینامه دارد</div>
                                                        @endif
                                                        @if($row->discount>0)
                                                            <div class="percentage">{{$row->discount}}%</div>
                                                        @endif

                                                    </div>
                                                    <div class="card-b">
                                                        <h2>{{ $row->title }}</h2>
                                                        <div class="info">
                                                            <h6>{{$row->teacher?->fullname}}</h6>
                                                            <div class="price-content off-code">
                                                                <div class="price">
                                                                    @if($row->old_price > 0)
                                                                        <div
                                                                            class="real">{{ number_format($row->old_price) }}</div>
                                                                    @endif
                                                                    @if($row->price > 0)
                                                                        <div
                                                                            class="off">{{ number_format($row->price) }}</div>
                                                                    @else
                                                                        <div class="off">رایگان</div>
                                                                    @endif
                                                                </div>
                                                                <div class="text">
                                                                    @if($row->price > 0)
                                                                        <span class="toman">تومان</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Add Options -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        <!-- مشاور -->

        <!-- وبینار -->
            @if (count($webinars) > 0)
                <div class="education-section">
                    <div class="container-lg">
                        <div class="section-container" style="margin-bottom: 0;">
                            <div class="title">
                                <div class="title-inner">
                                    <div class="shape"></div>
                                    <h1>جستجو در وبینارها</h1>
                                </div>
                                <div class="see-more">
                                    <a href="skill/webinars?search={{request()->search_title}}">
                                        <span class="text">مشاهده همه</span>
                                        <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
                                    </a>
                                </div>
                            </div>
                            <div class="section-inner">
                                <div class="swiper swiper-courses" dir="rtl">
                                    <div class="swiper-wrapper">
                                        @foreach($webinars as $row)
                                            <?php $title = str_replace(' ', '_', $row->title); ?>
                                            <div class="swiper-slide">
                                                <div class="card-webinar">
                                                    <div class="card-inner">
                                                        <a href="skill/webinar/{{ $row->id }}/{{ $title }}">
                                                            <div class="cover">
                                                                <div class="img-container">
                                                                    <div class="img-inner">
                                                                        <img
                                                                            src="_upload_/_webinars_/{{$row->code}}/medium_{{$row->image}}"
                                                                            alt="{{$row->title}}">
                                                                    </div>
                                                                </div>
                                                                @if($row->discount>0)
                                                                    <div class="percentage">{{$row->discount}}%</div>
                                                                @endif
                                                            </div>
                                                            <div class="info">
                                                                <h6 class="teacher">{{$row->teacher_name}}</h6>
                                                                <div class="date-content">
                                                                    <div class="date">
                                                                        <span>{{ $row->webinar_date }}</span>
                                                                    </div>
                                                                    <div class="time">
                                                                        <span>{{ $row->webinar_start_time_hour }}:00 - {{ $row->webinar_end_time_hour }}:00</span>
                                                                    </div>
                                                                </div>
                                                                <div class="price-content off-code">
                                                                    <div class="price">
                                                                        @if($row->old_price > 0)
                                                                            <div
                                                                                class="real">{{ number_format($row->old_price) }}</div>
                                                                        @endif
                                                                        @if($row->price > 0)
                                                                            <div
                                                                                class="off">{{ number_format($row->price) }}</div>
                                                                        @else
                                                                            <div class="off">رایگان</div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="text">
                                                                        @if($row->price > 0)
                                                                            <span class="toman">تومان</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if($row->have_video == 1)
                                                                <div class="certificate">فیلم دارد</div>
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Add Options -->
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        <!-- ایده ها -->
            @if (count($ideas) > 0)
                <div class="education-section">
                    <div class="container-lg">
                        <div class="title">
                            <div class="title-inner">
                                <div class="shape"></div>
                                <h1>جستجو در ایده ها</h1>
                            </div>
                            <div class="see-more">
                                <a href="wikiidea/cat/getAllCat?search={{request()->search_title}}">
                                    <span class="text">مشاهده همه</span>
                                    <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
                                </a>
                            </div>
                        </div>
                        <div class="section-inner">
                            <div class="swiper swiper-workshop" dir="rtl">
                                <div class="swiper-wrapper">
                                    @foreach($ideas as $row)
                                        <?php $title = str_replace(' ', '_', $row->title); ?>
                                        <div class="swiper-slide">
                                            <div class="card-teammate">
                                                <div class="card-inner">
                                                    <a href="wikiidea/details/{{$row->id}}">
                                                        <figure class="idea-pic">
                                                            <div class="img-inner">
                                                                <img src="_upload_/_wikiideas_/{{$row->code}}/medium_{{$row->image}}" alt="{{$row->title}}">
                                                            </div>
                                                        </figure>
                                                        <div class="user-pic">
                                                            @if ($row->writer?->code && $row->writer?->image)
                                                                <img src="_upload_/_users_/{{$row->writer->code}}/personal/{{$row->writer->image}}" alt="{{$row->writer?->name}}" />
                                                            @else
                                                                <img src="user/avatar" alt="{{$row->writer?->name}}" />
                                                            @endif
                                                        </div>
                                                        <div class="card-b">
                                                            <h1>{{ $row->abstractMemo }}</h1>
                                                            <ul>
                                                                <li><span>ایده پرداز : </span>{{ $row->writer?->name }}</li>
                                                                <li><span>سرمایه اولیه : </span>{{number_format($row->minimal_fund)}} تومان </li>
                                                                <li><span>نیروی انسانی : </span>{{ $row->manpower }}</li>
                                                                <li><span>ریسک : </span>{{ $row->risk }}</li>
                                                            </ul>
                                                        </div>
                                                        <div class="card-f">
                                                            <ul class="status-list">
                                                                <li>
                                                                    <i class="mdi mdi-eye-outline"></i>
                                                                    {{$row->view_count != null ? $row->view_count : 0}}
                                                                </li>
                                                                <li>
                                                                    <i class="mdi mdi-heart-outline"></i>
                                                                    {{$row->like_count != null ? $row->like_count : 0}}
                                                                </li>
                                                                <li>
                                                                    <i class="mdi mdi-star-outline"></i>
                                                                    {{$row->score != null ? $row->score : 0}}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Add Options -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        <!-- اخبار -->
            {{-- @if (count($news) > 0)--}}
            {{-- <div class="education-section margin-botom">--}}
            {{-- <div class="container-lg">--}}
            {{-- <div class="title">--}}
            {{-- <div class="title-inner">--}}
            {{-- <div class="shape"></div>--}}
            {{-- <h1>جدیدترین خبرها</h1>--}}
            {{-- </div>--}}
            {{-- <div class="see-more">--}}
            {{-- <a href="#">--}}
            {{-- <span class="text">مشاهده همه</span>--}}
            {{-- <span class="icon"><i class="mdi mdi-chevron-left"></i></span>--}}
            {{-- </a>--}}
            {{-- </div>--}}
            {{-- </div>--}}
            {{-- <div class="section-inner">--}}
            {{-- <div class="swiper swiper-workshop">--}}
            {{-- <div class="swiper-wrapper">--}}
            {{-- @foreach($news as $row)--}}
            {{-- <div class="swiper-slide">--}}
            {{-- <div class="card-news">--}}
            {{-- <a href="{{url('blogs/news/details/' . $row->id)}}" title="{{$row->title}}">--}}
            {{-- <figure class="news-pic">--}}
            {{-- <div class="img-inner">--}}
            {{-- <img src="_upload_/_news_/{{$row->code}}/medium_{{$row->image}}" alt="{{$row->title}}" />--}}
            {{-- </div>--}}
            {{-- </figure>--}}
            {{-- <div class="card-b">--}}
            {{-- <h2 class="titr">{{$row->title}}</h2>--}}
            {{-- <p class="desc">{{$row->abstractMemo}}</p>--}}
            {{-- </div>--}}
            {{-- <div class="card-f">--}}
            {{-- <ul class="status-list">--}}
            {{-- <li><i class="mdi mdi-eye-outline"></i>{{$row->view_count}}</li>--}}
            {{-- <li><i class="mdi mdi-clock-outline"></i>{{$row->regist_date}}</li>--}}
            {{-- </ul>--}}
            {{-- </div>--}}
            {{-- <div class="category">{{$row->category->title}}
          </div>--}}
            {{-- </a>--}}
            {{-- </div>--}}
            {{-- </div>--}}
            {{-- @endforeach--}}
            {{-- </div>--}}
            {{-- <!-- Add Options -->--}}
            {{-- <div class="swiper-button-next"></div>--}}
            {{-- <div class="swiper-button-prev"></div>--}}
            {{-- </div>--}}
            {{-- </div>--}}
            {{-- </div>--}}
            {{-- </div>--}}
            {{-- @endif--}}
        </div>
    </div>
@endsection
