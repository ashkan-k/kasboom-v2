@extends('layouts.front-master')

@section('Page_Title')
کسب بوم - آمایش سرزمینی
@endsection

@section('Page_CSS')

@endsection


@section('Content')

<!-- Blogs Content -->
<div class="amayesh-details-content">
  <div class="container-lg">
    <div class="row">
      <div class="col-lg-9 col-md-12">
        <div class="amayesh-details">
          <div class="ayamesh-carousel">
            <div class="swiper swiper-education-index">
              <div class="swiper-wrapper">
                @foreach($landmedia as $image)
                <div class="swiper-slide">
                  <div class="item">
                    <a href="_upload_/_landuse_/{{$landinfo?->code}}/images/{{$image->file_path}}">
                      <img src="_upload_/_landuse_/{{$landinfo?->code}}/images/{{$image->file_path}}" alt="{{$image->caption}}" title="آمایش منطقه ای {{$state}}">
                    </a>
                  </div>
                </div>
                @endforeach
              </div>
              <!-- Add Navigation -->
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
          </div>
          <div class="amayesh-description">
            <p>
              {!! $landinfo?->abstract !!}
            </p>
          </div>
        </div>
        <div class="amayesh-tabs">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="area-tab" data-bs-toggle="tab" href="#area" role="tab" aria-controls="area" aria-selected="true">مزیت‌های منطقه</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="sarmaye-tab" data-bs-toggle="tab" href="#sarmaye" role="tab" aria-controls="sarmaye" aria-selected="false">اولویت‌های سرمایه گذاری</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="job-tab" data-bs-toggle="tab" href="#job" role="tab" aria-controls="job" aria-selected="false">رتبه بندی مشاغل</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <!-- مزیت‌های منظقه -->
            <div class="tab-pane fade show active" id="area" role="tabpanel" aria-labelledby="area-tab">
              <div class="tab-inner">
                <p>
                  {!! $landinfo?->content !!}
                </p>
                @if($landinfo?->cloud_url != '')
                <video class="full-video" tabindex="0" preload="yes" controls>
                  <source type="video/mp4" src="{{$landinfo?->cloud_url}}">
                  <p>مرورگر خود را بروز رسانی کنید! مرورگر شما این ویديو را پشتیبانی نمی کند</p>
                </video>
                @endif
              </div>
            </div>
            <!-- اولویت‌های سرمایه گذاری -->
            <div class="tab-pane fade" id="sarmaye" role="tabpanel" aria-labelledby="sarmaye-tab">
              <div class="tab-inner">
                <h2 class="tab-title">اولویت سرمایه گذاری استان</h2>
                {!! $landinfo?->jobs_prority !!}

              </div>
            </div>
            <!-- معرفی مشاغل -->
            <div class="tab-pane fade" id="job" role="tabpanel" aria-labelledby="job-tab">
              <div class="tab-inner">
                <h2 class="tab-title">رتبه بندی مشاغل استان</h2>
                {!! $landinfo?->jobs_score !!}

              </div>
            </div>
          </div>
          <div class="blog-tags">
            <div class="tag-title">
              <h6>برچسب‌ها : </h6>
            </div>
            <ul>
              <li>آمایش</li>
              <li>استان</li>
              <li>{{$state}}</li>
              <li>سرمایه گذاری</li>
              <li>رتبه بندی</li>
              <li>مزیت سنجی</li>
            </ul>
          </div>
          <div class="share-blogs">
            <ul class="list-share">
              <li><a href="instagram/kasboom_ir"><i class="mdi mdi-instagram"></i></a></li>
              {{-- <li><a href="kas"><i class="mdi mdi-telegram"></i></a></li>--}}
              {{-- <li><a href="#"><i class="mdi mdi-facebook"></i></a></li>--}}
              <li><a href="info@kasboomi.ir"><i class="mdi mdi-email-outline"></i></a></li>
              {{-- <li><a href="#"><i class="mdi mdi-pinterest"></i></a></li>--}}
            </ul>
            <div class="link-preview">
              <div class="link">https://kasboom.ir/landuseitem/{{$landinfo?->classname}}</div>
              <div class="icon"><button type="button" class="btn-copy"><i class="mdi mdi-link-variant"></i></button></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-12">
        <div class="amayesh-side">
          <div class="city-name">
            <h2>{{$state}}</h2>
            <div class="ostan-information">
              <ul>
                <li><span class="ostan-area">مساحت استان : </span><span class="number">{{$landinfo?->area}}</span></li>
                <li><span class="ostan-area">جمعیت استان : </span><span class="number">{{$landinfo?->population}}</span></li>
              </ul>
            </div>
            <div class="city-map">
              <img src="_upload_/_landuse_/{{$landinfo?->code}}/{{$landinfo?->image}}" alt="آمایش منطقه ای {{$state}}" />
            </div>
            <ul class="ostan-branch">
              @foreach($landcity as $city)
              <?php $title = str_replace(" ", "_", $city->name); ?>
              <li><a>{{$city->name}}</a></li>
              @endforeach
            </ul>
          </div>
          <div class="side-advice" style="display: none">
            <div class="title">کارآفرینان منطقه</div>
            <div class="side-inner">
              <div class="item">
                <a href="#">
                  <figure class="side-pic">
                    <div class="img-inner">
                      <img src="/assets-v2/images/consulant-img/user-img-1.png" alt="pic-name" />
                    </div>
                  </figure>
                  <div class="info">
                    <h4>نام کارآفرین</h4>
                    <h6>تخصص</h6>
                  </div>
                </a>
              </div>
              <div class="item">
                <a href="#">
                  <figure class="side-pic">
                    <div class="img-inner">
                      <img src="/assets-v2/images/consulant-img/user-img-2.png" alt="pic-name" />
                    </div>
                  </figure>
                  <div class="info">
                    <h4>نام کارآفرین</h4>
                    <h6>تخصص</h6>
                  </div>
                </a>
              </div>
              <div class="item">
                <a href="#">
                  <figure class="side-pic">
                    <div class="img-inner">
                      <img src="/assets-v2/images/consulant-img/user-img-3.png" alt="pic-name" />
                    </div>
                  </figure>
                  <div class="info">
                    <h4>نام کارآفرین</h4>
                    <h6>تخصص</h6>
                  </div>
                </a>
              </div>
              <div class="item">
                <a href="#">
                  <figure class="side-pic">
                    <div class="img-inner">
                      <img src="/assets-v2/images/consulant-img/user-img-4.png" alt="pic-name" />
                    </div>
                  </figure>
                  <div class="info">
                    <h4>نام کارآفرین</h4>
                    <h6>تخصص</h6>
                  </div>
                </a>
              </div>
              <div class="item">
                <a href="#">
                  <figure class="side-pic">
                    <div class="img-inner">
                      <img src="/assets-v2/images/consulant-img/user-img-5.png" alt="pic-name" />
                    </div>
                  </figure>
                  <div class="info">
                    <h4>نام کارآفرین</h4>
                    <h6>تخصص</h6>
                  </div>
                </a>
              </div>
              <div class="item">
                <a href="#">
                  <figure class="side-pic">
                    <div class="img-inner">
                      <img src="/assets-v2/images/consulant-img/user-img-6.png" alt="pic-name" />
                    </div>
                  </figure>
                  <div class="info">
                    <h4>نام کارآفرین</h4>
                    <h6>تخصص</h6>
                  </div>
                </a>
              </div>
              <div class="item">
                <a href="#">
                  <figure class="side-pic">
                    <div class="img-inner">
                      <img src="/assets-v2/images/consulant-img/user-img-7.png" alt="pic-name" />
                    </div>
                  </figure>
                  <div class="info">
                    <h4>نام کارآفرین</h4>
                    <h6>تخصص</h6>
                  </div>
                </a>
              </div>
              <div class="item">
                <a href="#">
                  <figure class="side-pic">
                    <div class="img-inner">
                      <img src="/assets-v2/images/consulant-img/user-img-8.png" alt="pic-name" />
                    </div>
                  </figure>
                  <div class="info">
                    <h4>نام کارآفرین</h4>
                    <h6>تخصص</h6>
                  </div>
                </a>
              </div>
              <div class="item">
                <a href="#">
                  <figure class="side-pic">
                    <div class="img-inner">
                      <img src="/assets-v2/images/consulant-img/user-img-9.png" alt="pic-name" />
                    </div>
                  </figure>
                  <div class="info">
                    <h4>نام کارآفرین</h4>
                    <h6>تخصص</h6>
                  </div>
                </a>
              </div>
            </div>
            {{-- <div class="see-more">--}}
            {{-- <a href="#" class="btn-link">مشاهده همه<i class="mdi mdi-chevron-left"></i></a>--}}
            {{-- </div>--}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="education-section">
  <div class="container-lg">
    @if(count($courses) >0)
    <div class="title">
      <div class="title-inner">
        <div class="shape"></div>
        <h1>دوره‌های مرتبط با منطقه {{$state}}</h1>
      </div>
    </div>
    <div class="section-inner">
      <div class="swiper swiper-courses" dir="rtl">
        <div class="swiper-wrapper">
          @foreach($courses as $course)
          <?php $title = str_replace(' ', '_', $course->title); ?>
          <div class="swiper-slide">
            <div class="card-course" title="{{$course->title}}">
              <a href="skill/course/{{$course->id}}/{{$title}}">
                <div class="img-container">
                  <div class="img-inner">
                    <img src="_upload_/_courses_/{{$course->code}}/{{$course->image}}" alt="{{$course->title}}" />
                  </div>
                  @if($course->have_certificate==1)
                  <div class="certificate"><img src="v4_assets/images/icons/cer.svg" alt="گواهی نامه معتبر پایان دوره"></div>
                  @endif
                  <!-- <div class="rating"><i class="mdi mdi-star"></i>{{$course->core}}</div> -->
                  <div class="percentage">{{$course->discount}}%</div>
                </div>
                <div class="card-b">
                  <h2>{{$course->title}}</h2>
                  <div class="info">
                    <h6>{{ $course->teacher->fullname }}</h6>
                    <div class="price-content off-code">
                      <div class="price">
                        <div class="real">
                          @if($course->price>0)
                          {{number_format($course->price)}}
                          @else
                          رایگان
                          @endif
                        </div>
                        @if($course->old_price>0)
                        <div class="off">{{number_format($course->old_price)}}</div>
                        @endif
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
          @endforeach
        </div>
        <!-- Add Options -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </div>
    @endif
  </div>
</div>

@if(count($consults) >0)
<div class="education-section">
  <div class="container-lg">
    <div class="title">
      <div class="title-inner">
        <div class="shape"></div>
        <h1>مشاورین کسب بوم در منطقه {{$state}}</h1>
      </div>
    </div>
    <div class="section-inner">
      <div class="swiper swiper-courses" dir="rtl">
        <div class="swiper-wrapper">
          @foreach($consults as $consult)
          <?php $name = str_replace(' ', '_', $consult->fullname); ?>
          <div class="swiper-slide">
            <div class="card-advice">
              <a href="consult/profile/{{$consult->id}}/{{$name}}">
                <div class="card-h">
                  <div class="number-advice"><span class="titr">تعداد مشاوره</span><span class="number">{{$consult->consult_count}}</span></div>
                  <div class="rate">{{$consult->score}}<i class="mdi mdi-star"></i></div>
                  <div class="user-pic">
                    <img src="_upload_/_consult_/{{$consult->code}}/small_{{$consult->image}}" alt="{{$consult->fullname}}" />
                  </div>
                  <h2 class="user-name">{{$consult->fullname}}</h2>
                  <h6 class="advice-area">{{$consult->consult_field}}</h6>
                </div>
                <div class="card-b">
                  <div class="card-button">
                    <div class="btn btn-gradient">مشاهده رزومه</div>
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

<!-- @if(count($ideas) >0) -->
<div class="education-section">
  <div class="container-lg">
    <div class="title">
      <div class="title-inner">
        <div class="shape"></div>
        <h1>ایده های کسب و کار مرتبط با منطقه {{$state}}</h1>
      </div>
    </div>
    <div class="section-inner">
      <div class="swiper swiper-courses" dir="rtl">
        <div class="swiper-wrapper">
          @foreach($ideas as $idea)
          <div class="swiper-slide">
            <?php $title = str_replace(' ', '_', $idea->title); ?>
            <div class="card-idea">
              <div class="card-inner">
                <a href="wikiidea/idea/{{$idea->id}}/{{$title}}" title="{{$idea->title}}">
                  <figure class="idea-pic">
                    <div class="img-inner">
                      <img src="_upload_/_wikiideas_/{{$idea->code}}/medium_{{$idea->image}}" alt="{{$idea->title}}" />
                    </div>
                  </figure>
                  <div class="card-b" title="{{$idea->abstractMemo}}">
                    <h2 class="name">{{$idea->title != null ? $idea->title : ''}}</h2>
                    <ul class="idea-property">
                      <li><i class="mdi mdi-shape"></i><span>{{$idea->category != null ? $idea->category->title : ''}}</span></li>
                      <li><i class="mdi mdi-wallet"></i><span>ریسک: {{$idea->risk}}</span></li>
                      <li><i class="mdi mdi-clock"></i><span>سودآوری: {{$idea->profitability}}</span></li>
                      <li><i class="mdi mdi-account-multiple"></i><span>نیروی انسانی: {{$idea->manpower}}</span></li>
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
<!-- @endif -->

@endsection


@section('Page_JS')

@endsection
