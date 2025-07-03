@extends('layouts.front-master')

@section('Page_Title')
کسبوم - {{$course->title}}
@endsection

@section('Page_CSS')

@endsection


@section('Content')


<?php $cours_title = str_replace(' ', '_', $course->title);
$price_new=$course->price;
$price_old=$course->old_price;
$idddd=$course->id;
?>


<!-- Education Header -->
<div class="education-header">
  <div class="education-cover" style="background-image: url('_upload_/_courses_/{{$course->code}}/{{$course->img_big_banner}}')">
    <div class="overlay"></div>
    <div class="container-lg">
      <div class="education-details">
        <div class="details-inner">
          <div class="data">
            <div class="rating">
              <ul id="ulrate"></ul>
              {{-- <div class="user-rate">({{$course->comment_count}})
            </div>--}}
            <div class="number">{{$course->score}}</div>
          </div>
          <h2 class="course-name">{{$course->title}}</h2>
          <div class="list-score">
            <ul>
              <li><i class="mdi mdi-eye"></i><span>{{number_format($course->view_count)}}</span></li>
              <!--<li><i class="mdi mdi-comment-text"></i><span>{{number_format($course->comment_count)}}</span></li>-->
              <!--<li><i class="mdi mdi-thumb-up"></i><span>{{number_format($course->like_count)}}</span></li>-->
            </ul>
          </div>
          <div class="teacher-info">
            <a href="#">
              <div class="image">
                <img src="images/consulant-img/user-img-9.png" alt="{{$teacher?->fullname}}" />
              </div>
              <div class="info">
                <h2 class="teacher-name">{{$teacher?->fullname}}</h2>
                <h4 class="area">{{$course->category?->title}}</h4>
              </div>
              <div class="arrow-icon"><i class="mdi mdi-arrow-left"></i></div>
            </a>
          </div>
        </div>
      </div>
      <div class="details-footer">
        <div class="education-liked">
          <button class="btn-glass" id="btn_add_favorite"><i class="mdi mdi-bookmark-outline"></i>دنبال کردن</button>
          <button class="btn-glass" id="btn_remove_favorite"><i class="mdi mdi-bookmark"></i>حذف علاقه مندی</button>
          <button class="btn-like"><i class="mdi mdi-thumb-up-outline"></i></button>
          <button class="btn-like"><i class="mdi mdi-thumb-down-outline"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<input type="hidden" id="scoree" value="{{$course->score}}" readonly disabled>


<!-- Education Info -->
<div class="education-info">
  <div class="container-lg">
    <div class="grid-layout">
      <div class="grid-description">
        <div class="grid-inner">
          <!-- Tabs -->
          <div class="courses-tab">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="courses-tab" data-bs-toggle="tab" href="#courses"><i class="mdi mdi-format-list-checks"></i><span>سرفصل‌ها</span></a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="description-tab" data-bs-toggle="tab" href="#description"><i class="mdi mdi-pencil"></i><span>توضیحات
                    دوره</span></a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="file-tab" data-bs-toggle="tab" href="#file"><i class="mdi mdi-paperclip"></i><span>فایل
                    ها</span></a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="comment-tab" data-bs-toggle="tab" href="#comment"><i class="mdi mdi-message-text-outline"></i><span>نظرات
                    کاربران</span></a>
              </li>
            </ul>
            <div class="tab-content">
              <!-- توضیحات دوره آموزشی -->
               <div class="tab-pane fade " id="description" role="tabpanel" aria-labelledby="description-tab">
                <div class="tab-inner">
                  <!-- Alert message -->
                  <!-- alert-success >>> alert-info >>> alert-warning >>> alert-danger
                  @if($course->price >0 and $course->have_certificate)
                  <div class="myalert alert-info">
                    <div class="icon"><i class="mdi mdi-check-circle-outline"></i></div>
                    <div class="text">این دوره، شامل وبینارهای آموزشی و رفع اشکال به صورت دوره ای می باشد تا مطالب جدیدی ارائه گردد.شرکت در وبینارهای آینده این دوره آموزشی برای مهارت آموزان این دوره، رایگان می باشد</div>
                  </div>
                  @endif -->
                  <div class="table-requirements">
                    <ul>
                      <li><span class="name">گروه آموزشی</span><span class="desc">{{$course->category?->title}}</span></li>
                      <li><span class="name">کف سرمایه</span><span class="desc">{{number_format($course->minimal_fund)}}
                          تومان</span>
                      </li>
                      <li><span class="name">ریسک</span><span class="desc">{{$course->risk}}</span></li>
                      <li><span class="name">سودآوری</span><span class="desc">{{$course->profitability}} </span></li>
                      <li><span class="name">نیروی انسانی</span><span class="desc">{{$course->manpower}}</span></li>
                      <li><span class="name">مقیاس</span><span class="desc">{{$course->scale}}</span></li>
                    </ul>
                  </div>
                  <div class="info-details">
                    <h2 class="title">توضیحات دوره آموزشی</h2>
                    <div class="text" id="">
                      <p>
                        {!! $course->content !!}
                      </p>
                    </div>
                  </div>
                  <div class="property">
                    <h2>ویژگی های دوره</h2>
                    <ul>
                      <li><i class="mdi mdi-tools"></i>مهارت حرفه ای</li>
                      <li><i class="mdi mdi-clock-outline"></i>زمان یادگیری آزاد</li>
                      @if($course->have_certificate)
                      <li><i class="mdi mdi-file-document-edit-outline"></i>آزمون انلاین</li>
                      @endif
                      <li><i class="mdi mdi-forum-outline"></i>اتاق گفتگو</li>
                      @if($course->have_certificate)
                      <li><i class="mdi mdi-file-certificate-outline"></i>دریافت گواهینامه</li>
                      @endif
                      <li><i class="mdi mdi-cash"></i>هزینه معقول</li>
                      <li><i class="mdi mdi-cellphone-iphone"></i>نمایش با موبایل</li>
                      <li><i class="mdi mdi-quality-high"></i>محتوی ویدویی با کیفیت بالا</li>
                      <!--<li><i class="mdi mdi-face-agent"></i>پشتیبانی آموزشی</li>-->
                      <li><i class="mdi mdi-calendar-range-outline"></i>دسترسی طولانی مدت به دوره</li>
                    </ul>
                  </div>
                </div>
              </div>


               <div class="tab-pane fade " id="file" role="tabpanel" aria-labelledby="file-tab">
                <div class="tab-inner">
                  <div class="tab-inner">
                      <div class="tab-inner">
                    	@if(count($attach_dic)>0)
                    	<?php $cnt = 0; ?>
                    	@foreach($attach_dic as $key => $attachs)
                    	<?php $cnt = $cnt + 1; ?>
                    	<div class="course-item">
                    	  <div class="collapse-header collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-file-{{$cnt}}" role="button" aria-expanded="false" aria-controls="collapse-file-{{$cnt}}">
                    		<div class="icon"><i class="mdi mdi-chevron-left"></i></div>
                    		<div class="name">{{$key}}</div>
                    		<div class="time">{{count($attachs)}} عدد</div>
                    		<div class="lock"><i class="mdi mdi-map-legend"></i></div>
                    	  </div>
                    	  <div class="collapse" id="collapse-file-{{$cnt}}">
                    		<div class="files-list">
                    		  @foreach($attachs as $attach)
                    		  <div class="file-item">
                    			<figure class="file-pic">
                    			  <div class="img-inner">
                    				<img src="_upload_/_courses_/{{$course->code}}/attachs/{{$attach->code}}/{{$attach->image}}" class="file-preview-image" alt="{{$attach->title}}" />
                    			  </div>
                    			</figure>
                    			<div class="file-details">
                    			  <div class="info">
                    				<h5>{{$attach->title}}</h5>
                    				<div class="desc">{{$attach->memo}}</div>
                    			  </div>
                    			  @if($taked_course!=null)
                    			  <div class="download">
                    				<a href="_upload_/_courses_/{{$course->code}}/attachs/{{$attach->code}}/{{$attach->attachment_file}}" class="btn btn-gradient icon-right"><i class="mdi mdi-download-outline"></i>دانلود</a>
                    			  </div>
                    			  @endif
                    			</div>
                    		  </div>
                    		  @endforeach
                    		</div>
                    	  </div>
                    	</div>
                    	@endforeach
                    	@else
                    	<div></div>
                    	@endif
                      </div>
                    </div>
                </div>
              </div>

              <div class="tab-pane fade " id="comment" role="tabpanel" aria-labelledby="comment-tab">
                <div class="tab-inner">
                  <div class="tab-inner">
                  <!-- Course Rating Progress -->
                  <div class="course-rating-progress">
                    <div class="rating-title">
                      <div class="rate-inner">
                        <h2>{{$course->score}}<i class="mdi mdi-star"></i></h2>
                        <div class="rate">
                          <div class="number"> <span>(از {{$course->comment_count}} رای)</span></div>
                        </div>
                      </div>
                    </div>
                    <div class="progress-group">
                      @foreach($kasboomSurveyField as $survey)
                      <div class="progress-item">
                        <label>{{ $survey->title }}</label>
                        <div class="progress-inner">
                          <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$kasboomSurveys[$survey->id]['score']}}%" aria-valuenow="{{$kasboomSurveys[$survey->id]['score']}}" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <div class="percentage">%{{$kasboomSurveys[$survey->id]['score']}}</div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                  <!-- Send Comment -->
                  {{-- <div class="send-comment">--}}
                  {{-- <h6>شما میتوانید نطر خود را راجع به این دوره بیان کنید</h6>--}}
                  {{-- <a href="send-feedback.html" class="btn btn-default icon-right"><i--}}
                  {{-- class="mdi mdi-chat-outline"></i>ارسال نظر</a>--}}
                  {{-- </div>--}}
                  <div class="comments-list">
                    @foreach($comments as $comment)
                    <div class="comment-item bg-gray">
                      <div class="user-image">
                        <img src="v4_assets/images/icons/user-comment.svg" />
                      </div>
                      <div class="user-info">
                        @if(isset($comment->user))
                            <h6 class="name">{{$comment->user->name}}</h6>
                        @endif
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
                        {{ $comments->fragment('comments')->appends(['comments' => ''])->links( "pagination::bootstrap-4") }}
                      </ul>
                    </nav>
                  </div>
                </div>
                </div>
              </div>
              ---
               <!-- سرفصل ها -->
               <div class="tab-pane fade show active" id="courses" role="tabpanel" aria-labelledby="courses-tab">
                <div class="course-video-preview">
                  <video class="full-video" poster="{{$course->poster_url}}" tabindex="0" preload="yes" controls>
                    <source type="video/mp4" src="{{$course->cloud_mp4_url}}">
                  </video>
                  <div class="video-info">
                    <div class="vid-name"></div>
                    <div class="vid-season">فصل اول</div>
                  </div>
                </div>
                <!-- @if(($course->id > 140 and $course->id < 148) or $course->id == 149)
                  <div class="myalert alert-danger">
                    <div class="icon"><i class="mdi mdi-check-circle-outline"></i></div>
                    <div class="text">
                      <a href="icdl">
                      جهت دریافت گواهینامه بین المللی بنیاد ICDL کشور کلیک کنید
                      </a>
                    </div>

                  </div>
                @endif
                <hr> -->
                @if($taked_course==true)
                  <div class="myalert alert-info">
                    <div class="icon"><i class="mdi mdi-check-circle-outline"></i></div>
                    <div class="text">
                      <a href="web/learning/learningDetails/{{$idddd}}">
                      جهت مشاهد کامل دوره بر روی همین متن کلیک کنید
                      </a>
                    </div>

                  </div>
                @endif
                <div class="tab-inner">
                    @foreach($lessons_seasons_group  as  $season => $seasonLessons)
                    <div class="course-item">
                      <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#collapse-course-{{$seasonLessons->season}}" role="button" aria-expanded="false" aria-controls="collapse-course-{{$seasonLessons->season}}">
                      <div class="icon-static text-right"><i class="mdi mdi-format-list-bulleted"></i></div>
                      <div class="name"> فصل {{$seasonLessons->season}} </div>
{{--                      <div class="time">{{($seasonLessons)}} درس</div>--}}
                      <div class="icon-rotate text-left">
                        <div class="icon-inner">
                          <i class="mdi mdi-chevron-left"></i>
                        </div>
                      </div>
                    </div>
                      <div class="collapse {{$seasonLessons->season == 1 ? 'show' : ''}}" id="collapse-course-{{$seasonLessons->season}}">
                         <div class="card card-body">
                             <?php
                             $test = '';
                             $last_lesson_number = 0;
                             $last_lesson_title = '';
                             ?>
                           @foreach($lessons as $lesson)
                             @if($lesson->season === $seasonLessons->season)
                             <div class="sub-item">
                               <div class="item-header">
                                 <div class="sub-collapse-header">
                                   @if($lesson->isFree==1 or $taked_course==true)
                                     <div class="sub-info" data-video-src="{{$lesson->cloud_mp4_url}}">
                                       @else
                                         <div class="sub-info" data-video-src="{{$course->cloud_mp4_url}}">
                                           @endif
                                           <div class="name">{{$lesson->lesson_number}} - {{$lesson->title}}</div>
                                           <div class="time">{{$lesson->hour}}:{{$lesson->minutes}}</div>
                                           @if($lesson->isFree==1 or $taked_course==true)
                                             <div class="icon-static text-left active">
                                               <div class="icon-inner">
                                                 <i class="mdi mdi-play"></i>
                                               </div>
                                             </div>
                                           @else
                                             <div class="icon-static text-left deactive">
                                               <div class="icon-inner">
                                                 <i class="mdi mdi-lock-outline"></i>
                                               </div>
                                             </div>
                                           @endif
                                         </div>
                                         <div class="desc collapsed" data-bs-toggle="collapse" data-bs-target="#sub-collapse-course-{{$lesson->lesson_number}}" role="button" aria-expanded="false" aria-controls="sub-collapse-course-{{$lesson->lesson_number}}">
                                           <span>توضیحات</span>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="collapse sub-collapse" id="sub-collapse-course-{{$lesson->lesson_number}}">
                                   <div class="card card-body sub-card">
                                     <p>{{$lesson->memo}}</p>
                                   </div>
                                 </div>
                             </div>
                               @endif
                           @endforeach
                        </div>
                      </div>
                    </div>
                    @endforeach
                </div>
              </div>
              </div>






            </div>
          </div>
        </div>
        <div class="grid-sell">
          <div class="grid-inner">
            <div class="information">
              <div class="price-content have-discount">
                <div class="price-inner">
                  <div class="price">
                    @if($price_new >0 )
                        @if($price_old <> $price_new)
                        <div class="real">{{number_format($price_old)}}</div>
                        @endif
                    <div class="off">{{number_format($price_new)}}</div>
                    @else
                    رایگان
                    @endif
                  </div>
                  <div class="text">
                    @if($price_new >0 )
                    <span class="toman">تومان</span>
                    @endif
                  </div>
                </div>
                <div class="apply-button">
                  @if($course->status == 2)
                        @if($pre_registrated_course==false)
                            <a href="skill/course/pre-registration/submit/{{$course->getSlug()}}" class="btn btn-default icon-right"><i class="mdi mdi-credit-card-outline"></i>پیش ثبت نام</a>
                        @else
                            <a class="btn btn-default icon-right"><i class="mdi mdi-lock-open"></i>قبلا این دوره را پیش ثبت نام کرده اید</a>
                        @endif
                    @else
                        @if($taked_course==false)
                            <a href="course/take_course/{{$idddd}}/{{$course->getSlug()}}" class="btn btn-default icon-right"><i class="mdi mdi-credit-card-outline"></i>خرید
                                دوره</a>
                        @else
                            <a href="web/learning/learningDetails/{{$idddd}}" class="btn btn-default icon-right"><i class="mdi mdi-chevron-left"></i>مشاهده کامل دوره</a>
                        @endif
                  @endif
                </div>
                @if($course->discount > 0)
                    <div class="percentage">{{$course->discount}}%</div>
                @endif
              </div>
              <div class="video-preview">
                @if($course->cloud_mp4_url != '')
                <video class="full-video" poster="{{$course->poster_url}}" tabindex="0" preload="yes" controls>
                  <source type="video/mp4" src="{{$course->cloud_mp4_url}}">
                </video>
                @else
                <div class="education-cover-image">
                  <div class="img-inner">
                    <img src="_upload_/_courses_/{{$course->code}}/{{$course->image}}" alt="{{$course->title}}">
                  </div>
                </div>
                @endif
              </div>
              <div class="courses-info">
                <div class="side-title">اطلاعات کلی دوره</div>
                <?php
                  $tim = ((($course->hour) * 60) + ($course->minutes));
                ?>
                <ul>
                  <li><span class="name"><i class="mdi mdi-equalizer-outline"></i>سطح
                      آموزشی</span>
                    <span class="desc">
                      @if($course->level =='level1')
                      مقدماتی
                      @elseif($course->level =='level2')
                      متوسطه
                      @elseif($course->level =='level3')
                      پیشرفته
                      @endif
                    </span>
                  </li>

                  <li><span class="name"><i class="mdi mdi-book-outline"></i>تعداد درس‌ها</span><span class="desc">{{count($lessons)}} درس</span></li>
                  <li><span class="name"><i class="mdi mdi-clock-outline"></i>ویدئو آموزشی</span><span class="desc">{{$tim}} دقیقه </span></li>
                  <?php
                        $total_learning =    0;
                        $total_learning_hour=0;
                  $total_learning_minutes=0;
                        if($course->book_pages > 0)
                          $total_learning +=  ($course->book_pages  * 2);
                        if($course->video_minutes > 0)
                          $total_learning += $course->video_minutes;

                        $total_learning = $total_learning + $tim;
                        $total_learning_hour = $total_learning / 60;
                        $total_learning_hour = (int) round($total_learning_hour, 0, PHP_ROUND_HALF_DOWN);
                        $total_learning_minutes = $total_learning % 60;

                  ?>
                  @if ($total_learning_hour > 0)
                    <li><span class="name"><i class="mdi mdi-clock-outline"></i>مدت زمان
                      آموزش</span><span class="desc">
                        معادل
                        {{$total_learning_minutes}}  : {{$total_learning_hour}}  ساعت
                      </span></li>
                  @endif
                  <li><span class="name"><i class="mdi mdi-account-outline"></i>تعداد
                      هنرآموز</span><span class="desc">{{$course->register_count}} نفر</span></li>
                  <li><span class="name"><i class="mdi mdi-bookshelf"></i>کتاب‌های
                      آموزشی</span><span class="desc">{{$course->book_pages ? $course->book_pages : 0}} صفحه</span></li>
                  <li><span class="name"><i class="mdi mdi-play-circle-outline"></i>ویدیوی
                      کمک آموزشی</span><span class="desc"> {{$course->video_minutes >0 ? $course->video_minutes: 0}}  دقیقه  </span></li>
                  <!--@if($course->have_certificate)-->
                  <!--<li><span class="name"><i class="mdi mdi-face-agent"></i>پشتیبانی مدرس</span><span class="desc">30 روز</span></li>-->
                  <!--@endif-->
                </ul>
              </div>
              <div class="tags">
                <h2>برچسب</h2>
                <ul>
                  @php($hashtags = explode("#", $course->hashtags))
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


  <!-- popular Course -->
  <div class="education-section">
    <div class="container-lg">
      <div class="title">
        <div class="title-inner">
          <div class="shape"></div>
          <h2>دوره های مرتبط</h2>
        </div>
        <div class="see-more">
          {{-- <a href="#">--}}
          {{-- <span class="text">مشاهده همه</span>--}}
          {{-- <span class="icon"><i class="mdi mdi-chevron-left"></i></span>--}}
          {{-- </a>--}}
        </div>
      </div>
      <div class="section-inner">
        <div class="swiper swiper-courses" dir="rtl">
          <div class="swiper-wrapper">
            @foreach($related_course as $rel_course)
                      <?php $title = str_replace(' ', '_', $rel_course->title);
                      $img_src=$rel_course->getThumbnail();
                      $img_src="assets-v2/images/thumb.png";
                      $slug= "course/".$rel_course->getSlug();
                      $teacher= $rel_course->teacher ? $rel_course->teacher->fullname : 'کسبوم';
                      $time=$rel_course->minutes > 0 ? $rel_course->hour.':'.$rel_course->minutes : $rel_course->hour;
                      ?>
                  <div class="swiper-slide">
                      <div class="card-course" title="{{$rel_course->title}}">
                          <a href="{{$slug}}">
                              <div class="img-container">
                                  <div class="img-inner">
                                      <img src="{{$img_src}}" alt="{{$rel_course->title}}" />
                                  </div>
                                  <div class="status">
                                      @if($rel_course->discount > 0)
                                          <div class="percentage">{{$rel_course->discount}}</div>
                                      @endif
                                      @if($rel_course->have_certificate)
                                          <div class="certificate">گواهینامه دارد</div>
                                      @endif
                                  </div>
                              </div>
                              <div class="card-b">
                                  <h3 class="name">{{$rel_course->title}}</h3>
                                  <div class="info">
                                      <h4 class="teacher"><i class="mdi mdi-account-outline"></i>{{$teacher}}</h4>
                                      <p class="duration"><i class="mdi mdi-clock-outline"></i>مدت زمان دوره :
                                          <span>{{$time}}
                                                    ساعت</span>
                                      </p>
                                      @if($rel_course->register_count  >0)
                                          <p class="students"><i class="mdi mdi-school-outline"></i>هنرآموزان :
                                              <span>{{$rel_course->register_count}}
                                                    نفر</span>
                                          </p>
                                      @endif
                                      <div class="price-content off-code">
                                          <div class="price">
                                              @if($rel_course->old_price > 0)
                                                  @if($rel_course->old_price <> $rel_course->price)
                                                      <div class="real">{{ number_format($rel_course->old_price) }}</div>
                                                  @endif
                                              @endif
                                              @if($rel_course->price > 0)
                                                  <div class="off">{{ number_format($rel_course->price) }}</div>
                                              @else
                                                  <div class="off">رایگان</div>
                                              @endif
                                          </div>
                                          <div class="text">
                                              @if($rel_course->price > 0)
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


  <!-- Mobile Paying Bottom -->
  <div class="mobile-paying-bottom">
    <div class="container-lg">
      <div class="section-inner">
        <div class="button-group">

            @if($course->status == 2)
                @if($pre_registrated_course==false)
                    <a href="skill/course/pre-registration/submit/{{$course->getSlug()}}" class="btn btn-default icon-right"><i class="mdi mdi-credit-card-outline"></i>پیش ثبت نام</a>
                @else
                    <a class="btn btn-default icon-right"><i class="mdi mdi-lock-open"></i>پیش ثبت نام کرده اید</a>
                @endif
            @else
                @if($taked_course==false)
                    <a href="course/take_course/{{$idddd}}/{{$course->getSlug()}}" class="btn btn-default icon-right"><i class="mdi mdi-credit-card-outline"></i>خرید
                        دوره</a>
                @else
                    <a href="web/learning/learningDetails/{{$idddd}}" class="btn btn-default icon-right"><i class="mdi mdi-chevron-left"></i>مشاهده دوره</a>
                @endif
            @endif


        </div>
        <div class="price-content have-discount">

          <div class="price">
            @if($price_new >0 )
            @if($price_old <> $price_new)
                <div class="real">{{number_format($price_old)}}</div>
            @endif
            <div class="off">{{number_format($price_new)}}</div>
            @else
            رایگان
            @endif
          </div>
          <div class="text">
            @if($price_new >0 )
            <span class="toman">تومان</span>
            @endif
          </div>
          @if($course->discount > 0)
          <div class="percentage">{{$course->discount}}%</div>
          @endif
        </div>
      </div>
    </div>

  </div>

    {{-- ToastMessage --}}
    <div id="toastmessage-content"></div>

  <input type="hidden" id="favorite_type" value="course" readonly disabled>
  <input type="hidden" id="favorite_id_target" value="{{$course->id}}" readonly disabled>
  @endsection

  @section('Page_JS')


  <script>
    $("#mobilemainfooter").hide();

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
        @if (session()->has('course_pre_registration_success_message'))
            <script>
                $(document).ready(function () {
                    toastMessage('پیام موفقیت', '{{ session('course_pre_registration_success_message') }}', 'success');
                });
            </script>
        @endif
  @endsection
