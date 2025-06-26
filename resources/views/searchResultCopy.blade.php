<!DOCTYPE html>
<html lang="fa" class="no-js" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#07c499" />
  <meta name="msapplication-navbutton-color" content="#07c499">
  <meta name="apple-mobile-web-app-status-bar-style" content="#07c499">
  <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
  <meta content="کسبوم - کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="description">
  <meta content="کسبوم - کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="کسبوم">
  <meta name="keywords" content="کسب بوم، کسب وکارهای بومی، تولید داخلی ، مشاغل خانگی ، پشتیبانی، حمایت ،کسبوم ، کسب بوم، آموزش مشاغل خانگی، توسعه کسب و کار، آموزش کسب و کار، آموزش و پشتیبانی کسب و کار ، تولید ، کاشت ، پرورش ، تدوین طرح توجیهی ، فروش محصولات بومی ، فروش محصولات خانگی ، غرفه محصولات ، ویکی ایده ، ایده های کسب و کار ، نیازمندی های کسب و کار ، استخدام یار" />

  <base href="{{asset('/')}}" />
  <title>کسبوم - جستجو</title>

  <link rel="stylesheet" href="/assets-v2/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="/assets-v2/scss/main.css">
  <link rel="stylesheet" href="/assets-v2/plugin/swiperjs/swiper-bundle.min.css">
  <link rel="stylesheet" href="/assets-v2/plugin/noUIslider/nouislider.css">

  <!-- Font Icons -->
  <link href="/assets-v2/css/materialdesignicons.min.css?10" media="all" rel="stylesheet" type="text/css">

  <!-- Favicon -->
  <link rel="icon" href="/assets-v2/images/small-icon.png">
  <link rel="apple-touch-icon" href="/assets-v2/images/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/assets-v2/images/logo-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/assets-v2/images/logo-114x114.png">

</head>

<body>

  @include ("master_header")

  <!-- Mobile Search -->
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
                    <a href="skill/course/{{$row->id}}/{{$title}}">
                      <div class="img-container">
                        <div class="img-inner">
                          <img src="_upload_/_courses_/{{$row->code}}/medium_{{$row->image}}" alt="{{$row->title}}" />
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
                          <h6>{{$row->teacher->fullname}}</h6>
                          <div class="price-content off-code">
                            <div class="price">
                              @if($row->old_price > 0)
                              <div class="real">{{ number_format($row->old_price) }}</div>
                              @endif
                              @if($row->price > 0)
                              <div class="off">{{ number_format($row->price) }}</div>
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
      @if (count($consults) > 0)
      <div class="education-section">
        <div class="container-lg">
          <div class="title">
            <div class="title-inner">
              <div class="shape"></div>
              <h1>مشاورین مرتبط</h1>
            </div>
            <div class="see-more">
              <a href="consult/consults?search={{request()->search_title}}">
                <span class="text">مشاهده همه</span>
                <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
              </a>
            </div>
          </div>
          <div class="section-inner">
            <div class="swiper swiper-courses" dir="rtl">
              <div class="swiper-wrapper">
                @foreach($consults as $row)
                <?php $title = str_replace(' ', '_', $row->fullname); ?>
                <div class="swiper-slide">
                  <div class="card-advice">
                    <a href="consult/profile/{{$row->id}}/{{$title}}">
                      <div class="card-h">
                        <div class="number-advice"><span class="titr">تعداد مشاوره</span>
                          <span class="number">{{ $row->consult_count }}</span>
                        </div>
                        <div class="rate">{{ $row->score }}<i class="mdi mdi-star"></i></div>
                        <div class="user-pic">
                          <img src="_upload_/_consult_/{{$row->code}}/small_{{$row->image}}" alt="{{$row->fullname}}" />
                        </div>
                        <h2 class="user-name">{{ $row->fullname }}</h2>
                        <h6 class="advice-area">{{ $row->consult_field }}</h6>
                      </div>
                      <div class="card-b">
                        <div class="card-button">
                          <div class="btn btn-gradient">دریافت مشاوره</div>
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
                                <img src="_upload_/_webinars_/{{$row->code}}/medium_{{$row->image}}" alt="{{$row->title}}">
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
                                <div class="real">{{ number_format($row->old_price) }}</div>
                                @endif
                                @if($row->price > 0)
                                <div class="off">{{ number_format($row->price) }}</div>
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

  @include ("master_footer")

  <!-- Scripts -->
  <script src="/assets-v2/js/jquery-3.5.1.min.js"></script>
  <script src="/assets-v2/js/bootstrap.bundle.min.js"></script>
  <script src="/assets-v2/plugin/swiperjs/swiper-bundle.min.js"></script>
  <script src="/assets-v2/plugin/swiperjs/swiper-initial.js"></script>
  <script src="/assets-v2/js/scripts.js"></script>
  <script src="/assets-v2/plugin/noUIslider/nouislider.min.js"></script>
  <script src="/assets-v2/plugin/noUIslider/nouislider.initial.js"></script>

  <!-- Scripts -->
  <script src="/assets-v2/js/jquery-3.5.1.min.js?11"></script>
  <script src="/assets-v2/js/bootstrap.bundle.min.js?11"></script>
  <script src="/assets-v2/js/scripts.js?11"></script>
  <script src="assets_admin/js/jquery.easing.1.3.js?11"></script>
  <script src="assets_admin/js/jquery.toast.js?11"></script>

</body>

</html>
