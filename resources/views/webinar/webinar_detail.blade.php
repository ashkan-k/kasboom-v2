@extends('layouts.front-master')

@section('Page_Title')
کسبوم - {{$webinar->title}}
@endsection

@section('Page_CSS')

@endsection


@section('Content')

<?php $cours_title = str_replace(' ', '_', $webinar->title); ?>
qweqwe
<!-- Education Header -->
<div class="education-header">
    @if($webinar->type <5)
        <div class="education-cover" style="background-image: url('_upload_/_webinars_/default.jpg')">
    @else
        <div class="education-cover" style="background-image: url('_upload_/_webinars_/{{$webinar->code}}/big_banner.jpg')">
    @endif
    <div class="overlay"></div>
    <div class="container-lg">
      <div class="education-details">
        <div class="details-inner">
          <div class="data">
          <!--  <div class="rating">-->
          <!--    <ul id="ulrate"></ul>-->
          <!--    {{-- <div class="user-rate">({{$webinar->comment_count}})-->
          <!--  </div>--}}-->
          <!--  <div class="number">{{$webinar->score}}</div>-->
          <!--</div>-->
          <h2 class="course-name">{{$webinar->title}}</h2>

          <div class="list-score">
            <ul>
              <li><i class="mdi mdi-eye"></i><span>{{$webinar->view_count}}</span></li>
              <li><i class="mdi mdi-comment-text"></i><span>{{$webinar->comment_count}}</span></li>
              <li><i class="mdi mdi-thumb-up"></i><span>{{$webinar->like_count}}</span></li>
            </ul>
          </div>

          <div class="teacher-info">
            <a href="#">
              <div class="image">
                <img src="_upload_/_teachers_/{{$teacher != null ? $teacher->code : ''}}/medium_{{ $teacher != null ? $teacher->image : ''}}" alt="{{ $teacher != null ? $teacher->fullname : ''}}" />
              </div>
              <div class="info">
                <h2 class="teacher-name">{{$teacher != null ? $teacher->fullname : ''}}</h2>
                <!--<h4 class="area">{{$webinar->category?->title}}</h4>-->
              </div>
              <div class="arrow-icon"><i class="mdi mdi-arrow-left"></i></div>
            </a>
          </div>


          <!-- <div class="description">
            <p>{{$webinar->abstractMemo}}</p>
          </div>
          @if($webinar->have_certificate)
          <div class="property">
            <ul>
              <li>{{$webinar->certificate_memo}}</li>
            </ul>
          </div>
          @endif -->

        </div>
      </div>
      <div class="details-footer">
        <!-- <div class="education-price">

          <div class="price-content off-code">
            <div class="price">
              @if($webinar->old_price>0)
              <div class="real">{{number_format($webinar->old_price)}}</div>
              @endif
              <div class="off">
                @if($webinar->price>0)
                {{number_format($webinar->price)}}
                <span class="toman">تومان</span>
                @else
                رایگان
                @endif
              </div>
            </div>
            <div class="text">
              @if($webinar->discount >0)
              <div class="precentage">{{$webinar->discount}}%</div>
              @endif
            </div>
          </div>
          <div class="buy-link">

            @if($taked_webinar==false)
            @if($webinar->register_count <=$webinar->capacity_register)
              <a href="skill/take_webinar/{{$webinar->id}}/{{$cours_title}}" class="btn btn-white icon-left"><i class="mdi mdi-chevron-left"></i>ثبت نام وبینار</a>
              @else
              <a class="btn btn-white icon-left"><i class="mdi mdi-chevron-left"></i>ظرفیت وبینار تکمیل شده است...</a>
              @endif
              @else
              @if($webinar->status==2)
              @if($webinar->have_video==true)
              <a href="{{$webinar->cloud_url}}" target="_blank" class="btn btn-white icon-left"><i class="mdi mdi-chevron-left"></i>دانلود فیلم وبینار</a>
              @endif
              @else
              <a href="{{$taked_webinar->user_url}}" target="_blank" class="btn btn-white icon-left"><i class="mdi mdi-chevron-left"></i>شرکت در وبینار</a>
              @endif
              @endif
          </div>

        </div> -->
          <div class="education-liked">
            @if($taked_webinar==false)
              @if($webinar->webinar_date >= jdate()->format('Y/m/d') || $webinar->have_video === 1 )
                <a href="skill/take_webinar/{{$webinar->id}}/{{$cours_title}}" class="btn btn-default icon-right"><i class="mdi mdi-credit-card-outline"></i>ثبت نام</a>
              @endif
            @else
              <a href="{{$taked_webinar->user_url}}" class="btn btn-default icon-right"><i class="mdi mdi-video"></i>مشاهده وبینار </a>
            @endif
          <!--<button class="btn-glass" id="btn_add_favorite"><i class="mdi mdi-bookmark-outline"></i>دنبال کردن</button>-->
            <!--<button class="btn-like"><i class="mdi mdi-thumb-up-outline"></i></button>-->
            <!--<button class="btn-like"><i class="mdi mdi-thumb-down-outline"></i></button>-->
          </div>
      </div>
    </div>
  </div>
</div>
</div>

<input type="hidden" id="scoree" value="{{$webinar->score}}" readonly disabled>


<!-- Education Info -->
<div class="education-info">
  <div class="container-lg">
    <div class="grid-layout">
      <div class="grid-description">
        <div class="grid-inner">
          <div class="courses-tab">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#tabpanel1"><i class="mdi mdi-format-list-checks"></i><span>توضیحات</span></a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#tabpanel2"><i class="mdi mdi-format-list-checks"></i><span>فایل‌های ضمیمه</span></a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#tabpanel3"><i class="mdi mdi-format-list-checks"></i><span>نظرات کاربران</span></a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="tabpanel1" role="tabpanel">
                <div class="tab-inner">
                  <!-- Alert -->
{{--                  <div class="myalert alert-danger">--}}
{{--                    <div class="icon"><i class="mdi mdi-information-outline"></i></div>--}}
{{--                    @if($webinar->type === 5)--}}
{{--                    <div class="text">دقت داشته باشید که زمان شروع کلاس ها بعد از تکمیل ظرفیت دوره اطلاع رسانی و شروع می شود</div>--}}
{{--                    @else--}}
{{--                    <div class="text">با توجه به اینکه ظرفیت ثبت نام محدود می باشد.اولویت با کسانی می باشد که زودتر ثبت نام کرده باشند</div>--}}
{{--                    @endif--}}

{{--                  </div>--}}
{{--                  @if($webinar->register_count > $webinar->capacity_register)--}}
{{--                  <div class="myalert alert-danger">--}}
{{--                    <div class="icon"><i class="mdi mdi-information-outline"></i></div>--}}
{{--                    <div class="text">ظرفیت این کارگاه آموزشی تکمیل شده است. در صورتی که کارگاه جدیدی با این موضوع آموزشی برگزار گردد اطلاع رسانی می شود</div>--}}
{{--                  </div>--}}
{{--                  @endif--}}
                  <!--<div class="myalert alert-info">-->
                  <!--  <div class="icon"><i class="mdi mdi-information-outline"></i></div>-->
                  <!--  <div class="text">به مناسبت عید غدیر این وبینار علاوه بر اینکه به صورت رایگان برگزار می گردد به شرکت کنندگان در این وبینار نیز کد تخفیف ۵۰ درصدی برای خرید دوره های آموزشی کسبوم که به صورت استودیویی ضبط شده است تقدیم می شود.</div>-->
                  <!--</div>-->
                  <div class="text">
                    {!! $webinar->content !!}
                  </div>
                </div>
              </div>
              <div class="tab-pane fade " id="tabpanel2" role="tabpanel">
                <div class="tab-inner">
                  <div class="course-item">
                    @foreach($attachs as $attach)
                    <div class="collapse-header" aria-expanded="false" aria-controls="">
                      <div class="icon"><i class="mdi mdi-chevron-left"></i></div>
                      <div class="name">{{$attach->attach_title}}</div>
                      <div class="time"> <a href="_upload_/_webinars_/{{$webinar->code}}/attachs/{{$attach->code}}/{{$attach->attach_filename}}" target="_blank"> دانلود</a></div>
                      <!--<div class="lock"><i class="mdi mdi-map-legend"></i></div>-->
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="tab-pane fade " id="tabpanel3" role="tabpanel">
                <div class="tab-inner">
                  <div class="send-comment">
                    @if($taked_webinar!=null)
                    <h6>با نظر دادن می توانید کمک کنید تا دیگران آگاهانه خرید کنند</h6>
                    <!--<a href="send-feedback.html" class="btn btn-gradient icon-right"><i-->
                    <!--    class="mdi mdi-chat-outline"></i>ارسال نظر</a>-->
                    @else
                    <h6>بعد از ثبت نام در دوره می توانید نظر خود را ارسال نمائید</h6>
                    @endif
                  </div>
                  <div class="comments-list">
                    @foreach($comments as $comment)
                    <div class="comment-item">
                      <div class="user-image">
                        <img src="v4_assets/images/icons/user-comment.svg" />
                      </div>
                      <div class="user-info">
                        <h6 class="name">{{$comment->user->name}}</h6>
                        <div class="date">{{$comment->regist_date}}</div>
                        <div class="text">
                          {{$comment->comment}}
                        </div>
                        <div class="rate">
                          <span>{{$comment->score}}</span>
                          <i class="mdi mdi-star"></i>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                  <div class="my-pagination mt-5">
                    <nav aria-label="Page navigation">
                      <ul class="pagination">
                        {{ $comments->links( "pagination::bootstrap-4") }}
                      </ul>
                    </nav>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="grid-sell">
        <div class="grid-inner">
          <div class="information">
            <!-- Price -->
            <div class="price-content have-discount">
              <div class="price-inner">
                <div class="price">
                  @if($webinar->old_price > 0)
                  <div class="real">{{ number_format($webinar->old_price) }}</div>
                  @endif
                  @if($webinar->price > 0)
                  <div class="off">{{ number_format($webinar->price) }}</div>
                  @else
                  <div class="off">رایگان</div>
                  @endif
                </div>
                <div class="text">
                  @if($webinar->price > 0)
                  <span class="toman">تومان</span>
                  @endif
                </div>
              </div>
              <div class="apply-button">
                @if($taked_webinar==false)
                  @if($webinar->webinar_date >= jdate()->format('Y/m/d') || $webinar->have_video === 1 )
                    <a href="skill/take_webinar/{{$webinar->id}}/{{$cours_title}}" class="btn btn-default icon-right"><i class="mdi mdi-credit-card-outline"></i>ثبت نام</a>
                  @endif
                @else
                  <a href="{{$taked_webinar->user_url}}" class="btn btn-default icon-right"><i class="mdi mdi-video"></i>مشاهده وبینار </a>
                @endif
              </div>
              <div class="percentage">{{ $webinar->discount }}%</div>
            </div>
            <div class="video-preview">
              @if($webinar->intro_video != '')
              <video class="full-video" poster="{{$webinar->poster_url}}" tabindex="0" preload="yes" controls>
                <source type="video/mp4" src="{{$webinar->cloud_mp4_url}}">
              </video>
              @else
              <div class="education-cover-image">
                <div class="img-inner">
                  <img src="_upload_/_webinars_/{{$webinar->code}}/{{$webinar->image}}" alt="{{$webinar->title}}">
                </div>
              </div>
              @endif
            </div>
            <div class="property">
              <h2>ویژگی های وبینار</h2>
              <ul>
                <li><i class="mdi mdi-tools"></i>کارگاه آنلاین</li>
                <li><i class="mdi mdi-clock-outline"></i>زمان یادگیری آزاد</li>
                <li><i class="mdi mdi-forum-outline"></i>پرسش و پاسخ</li>
                @if($webinar->have_certificate)
                <li><i class="mdi mdi-file-certificate-outline"></i>گواهینامه حضور</li>
                @endif
                @if($webinar->price <=0) <li><i class="mdi mdi-cash"></i>هزینه : رایگان</li>
                  @else
                  <li><i class="mdi mdi-cash"></i>هزینه معقول</li>
                  @endif
                  <li><i class="mdi mdi-cellphone-iphone"></i>نمایش با موبایل</li>
                  <li><i class="mdi mdi-quality-high"></i>محتوی کارگاه با کیفیت مناسب</li>
                  <li><i class="mdi mdi-calendar-range-outline"></i>دسترسی به فیلم وبینار</li>
              </ul>
            </div>
            <div class="tags">
              {{-- <h2>برچسب</h2>--}}
              @php($hashtags = explode("#", $webinar->hashtags))
              <ul>
                @foreach($hashtags as $hashtag)
                @if($hashtag != null)
                <li><a>{{$hashtag}}</a></li>
                @endif
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- <div class="info-inner">
        <div class="education-video">
          @if($webinar->intro_video != '')
          <div class="r1_iframe_embed"> <iframe src="https://player.arvancloud.ir/index.html?config={{$webinar->intro_video}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe> </div>
          @else
          <img src="_upload_/_webinars_/{{$webinar->code}}/{{$webinar->image}}" class="cover-image" />
          @endif
        </div>
      </div> -->




@if(count($related_webinars)>0)
<div class="education-section">
  <div class="container">
    <div class="title">
      <div class="title-inner">
        <div class="shape"></div>
        <h1>وبینارهای آموزشی</h1>
      </div>
    </div>
    <div class="section-inner">
      <div class="swiper swiper-workshop" dir="rtl">
        <div class="swiper-wrapper">
          @foreach($related_webinars as $webinar)
          <?php $title = str_replace(' ', '_', $webinar->title); ?>
          <div class="swiper-slide">
            <div class="card-webinar" title="{{$webinar->title}}">
              <div class="card-inner">
                <a href="skill/webinar/{{$webinar->id}}/{{$title}}">
                  <div class="cover">
                    <div class="img-container">
                      <div class="img-inner">
                        <img src="_upload_/_webinars_/{{$webinar->code}}/medium_{{$webinar->image}}" alt="{{$webinar->title}}" />
                        <!-- <img src="v4_assets/images/courses/1.jpg" alt=""> -->
                      </div>
                    </div>
                    @if($webinar->discount>0)
                    <div class="percentage">{{$webinar->discount}}%</div>
                    @endif
                  </div>
                  <div class="info">
                    <h6 class="teacher">{{$webinar->teacher_name}}</h6>
                    <!-- <h2>{{$webinar->title}}</h2> -->
                    <div class="date-content">
                      <div class="date">
                        <span>{{$webinar->webinar_date}}</span>
                      </div>
                      <div class="time">
                        <span>16:00 - 18:00</span>
                      </div>
                    </div>
                    <div class="price-content off-code">
                      <div class="price">
                        @if($webinar->old_price > 0)
                        <div class="real">{{number_format($webinar->old_price)}}</div>
                        @endif
                        @if($webinar->price > 0)
                        <div class="off">{{number_format($webinar->price)}}</div>
                        @endif
                      </div>
                      <div class="text">
                        @if($webinar->price > 0)
                        <span class="toman">تومان</span>
                        @else
                        <span class="toman">رایگان</span>
                        @endif
                      </div>
                    </div>
                  </div>
                  @if($webinar->have_certificate ==1)
                  <div class="certificate">گواهینامه دارد</div>
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
@endif

<input type="hidden" id="favorite_type" value="course" readonly disabled>
<input type="hidden" id="favorite_id_target" value="{{$webinar->id}}" readonly disabled>
@endsection


@section('Page_JS')


<script>
  @if($favorite_status == false)
  $("#btn_add_favorite").show();
  $("#btn_remove_favorite").hide();
  @else
  $("#btn_add_favorite").hide();
  $("#btn_remove_favorite").show();
  @endif

  function starr(rateData) {
    ul = "";
    for (var i = 0; i < Math.round(rateData); i++) {
      ul = ul + '<li class="active"><i class="mdi mdi-star"></i></li>';
    }

    for (var i = 0; i < 5 - Math.round(rateData); i++) {
      ul = ul + '<li class=""><i class="mdi mdi-star"></i></li>';
    }
    $("#ulrate").append(ul);
  }

  starr($("#scoree").val());
</script>
@endsection
