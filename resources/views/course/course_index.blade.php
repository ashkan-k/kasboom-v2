@extends('layouts.front-master')

@section('Page_Title')
    آموزشگاه کسب بوم - دوره های آموزش مهارتی و کارآفرینی و مشاغل خانگی
@endsection

@section('Page_CSS')

@endsection


@section('Content')

    <!-- Education Carousel -->
    <div class="education-index">
        <div class="container-lg">
            <div class="swiper swiper-education-index" dir="rtl">
                <div class="swiper-wrapper">

                    @if($newst_courses->count() > 0)
                        @foreach($newst_courses->random(min(6, $newst_courses->count())) as $course)
                            <?php $title = str_replace(' ', '_', $course->title); ?>
                            <div class="swiper-slide">
                                <div class="item">
                                    <a href="course/{{$course->getSlug()}}">
                                        <picture>
                                            <source media="(max-width: 599px)"
                                                    srcset="{{$course->getMobileSlider()}}">
                                            <source media="(min-width: 600px)"
                                                    srcset="{{$course->getSlider()}}">
                                            <img src="{{$course->getSlider()}}"
                                                 alt="{{ $course->title }}">
                                        </picture>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <!-- Add Options -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>

    <!-- دوره های اختصاصی -->
    <div class="education-section">
        <div class="container-lg">
            <div class="title">
                <div class="title-inner">
                    <div class="shape"></div>
                    <h2>دوره‌های اختصاصی</h2>
                </div>
                <div class="see-more">
                    <a href="{{url('/skill/courses')}}">
                        <span class="text">مشاهده همه</span>
                        <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
                    </a>
                </div>
            </div>
            <div class="section-inner">
                <div class="swiper swiper-courses" dir="rtl">
                    <div class="swiper-wrapper">

                        @foreach($courses as $course)
                            @if($course->price >= 0)
                                    <?php $title = str_replace(' ', '_', $course->title);
                                    $img_src=$course->getThumbnail();
                                    $img_src="assets-v2/images/thumb.png";
                                    $slug= "course/".$course->getSlug();
                                    $teacher= $course->teacher ? $course->teacher->fullname : 'کسبوم';
                                    $time=$course->minutes > 0 ? $course->hour.':'.$course->minutes : $course->hour;
                                    ?>
                                <div class="swiper-slide">
                                    <div class="card-course" title="{{$course->title}}">
                                        <a href="{{$slug}}">
                                            <div class="img-container">
                                                <div class="img-inner">
                                                    <img src="{{$img_src}}" alt="{{$course->title}}" />
                                                </div>
                                                <div class="status">
                                                    @if($course->discount > 0)
                                                        <div class="percentage">{{$course->discount}}</div>
                                                    @endif
                                                    @if($course->have_certificate)
                                                        <div class="certificate">گواهینامه دارد</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-b">
                                                <h3 class="name">{{$course->title}}</h3>
                                                <div class="info">
                                                    <h4 class="teacher"><i class="mdi mdi-account-outline"></i>{{$teacher}}</h4>
                                                    <p class="duration"><i class="mdi mdi-clock-outline"></i>مدت زمان دوره :
                                                        <span>{{$time}}
                                                    ساعت</span>
                                                    </p>
                                                    @if($course->register_count  >0)
                                                        <p class="students"><i class="mdi mdi-school-outline"></i>هنرآموزان :
                                                            <span>{{$course->register_count}}
                                                    نفر</span>
                                                        </p>
                                                    @endif
                                                    <div class="price-content off-code">
                                                        <div class="price">
                                                            @if($course->old_price > 0)
                                                                @if($course->old_price <> $course->price)
                                                                    <div class="real">{{ number_format($course->old_price) }}</div>
                                                                @endif
                                                            @endif
                                                            @if($course->price > 0)
                                                                <div class="off">{{ number_format($course->price) }}</div>
                                                            @else
                                                                <div class="off">رایگان</div>
                                                            @endif
                                                        </div>
                                                        <div class="text">
                                                            @if($course->price > 0)
                                                                <span class="toman">تومان</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            @endif
                        @endforeach

                    </div>
                    <!-- Add Options -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- دوره های دوبله شده -->
    <div class="education-section">
        <div class="container-lg">
            <div class="title">
                <div class="title-inner">
                    <div class="shape"></div>
                    <h2>دوره‌های دوبله شده</h2>
                </div>
                <div class="see-more">
                    <a href="{{url('/skill/courses')}}">
                        <span class="text">مشاهده همه</span>
                        <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
                    </a>
                </div>
            </div>
            <div class="section-inner">
                <div class="swiper swiper-courses" dir="rtl">
                    <div class="swiper-wrapper">
                        @foreach($dbl_courses->random(min(6, $dbl_courses->count())) as $course)
                                <?php $title = str_replace(' ', '_', $course->title);
                                $img_src=$course->getThumbnail();
                                $img_src="assets-v2/images/thumb.png";
                                $slug= "course/".$course->getSlug();
                                $teacher= $course->teacher ? $course->teacher->fullname : 'کسبوم';
                                $time=$course->minutes > 0 ? $course->hour.':'.$course->minutes : $course->hour;
                                ?>
                        <div class="swiper-slide">
                            <div class="card-course" title="{{$course->title}}">
                                <a href="{{$slug}}">
                                    <div class="img-container">
                                        <div class="img-inner">
                                            <img src="{{$img_src}}" alt="{{$course->title}}" />
                                        </div>
                                        <div class="status">
                                            @if($course->discount > 0)
                                                <div class="percentage">{{$course->discount}}</div>
                                            @endif
                                            @if($course->have_certificate)
                                                <div class="certificate">گواهینامه دارد</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-b">
                                        <h3 class="name">{{$course->title}}</h3>
                                        <div class="info">
                                            <h4 class="teacher"><i class="mdi mdi-account-outline"></i>{{$teacher}}</h4>
                                            <p class="duration"><i class="mdi mdi-clock-outline"></i>مدت زمان دوره :
                                                <span>{{$time}}
                                                    ساعت</span>
                                            </p>
                                            @if($course->register_count >0)
                                            <p class="students"><i class="mdi mdi-school-outline"></i>هنرآموزان :
                                                <span>{{$course->register_count}}
                                                    نفر</span>
                                            </p>
                                            @endif
                                            <div class="price-content off-code">
                                                <div class="price">
                                                    @if($course->old_price > 0)
                                                        @if($course->old_price <> $course->price)
                                                            <div class="real">{{ number_format($course->old_price) }}</div>
                                                        @endif
                                                    @endif
                                                    @if($course->price > 0)
                                                        <div class="off">{{ number_format($course->price) }}</div>
                                                    @else
                                                        <div class="off">رایگان</div>
                                                    @endif
                                                </div>
                                                <div class="text">
                                                    @if($course->price > 0)
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

    <!-- دوره های زیرنویس -->
    <div class="education-section">
        <div class="container-lg">
            <div class="title">
                <div class="title-inner">
                    <div class="shape"></div>
                    <h2>دوره‌های زیرنویس</h2>
                </div>
            </div>
            <div class="section-inner">
                <nav>
                    <div class="nav nav-tabs tab-border" role="tablist">

                        @foreach($cats as $cat)
                            @if(count($cat->courses) >0)
                            <button class="nav-link @if($loop->index == 0) active @endif" data-bs-toggle="tab"
                                    data-bs-target="#nav-course-{{ $cat->id }}"
                                    role="tab">{{ $cat->title }}
                            </button>
                            @endif
                        @endforeach

                    </div>
                </nav>
                <div class="tab-content mt-4">

                    @foreach($cats as $cat)
                        @if(count($cat->courses) >0)
                        <div class="tab-pane fade @if($loop->index == 0) show active @endif"
                             id="nav-course-{{ $cat->id }}" role="tabpanel" tabindex="0">
                            <div class="swiper swiper-courses" dir="rtl">
                                <div class="swiper-wrapper">

                                    @foreach($cat->courses as $course)
                                        @if($course->type =="subtitle" && $course->status == 1)
                                            <?php $title = str_replace(' ', '_', $course->title);
                                            $img_src=$course->getThumbnail();
                                            $img_src="assets-v2/images/thumb.png";
                                            $slug= "course/".$course->getSlug();
                                            $teacher= $course->teacher ? $course->teacher->fullname : 'کسبوم';
                                            $time=$course->minutes > 0 ? $course->hour.':'.$course->minutes : $course->hour;
                                            ?>
                                          <div class="swiper-slide">
                                            <div class="card-course" title="{{$course->title}}">
                                                <a href="{{$slug}}">
                                                    <div class="img-container">
                                                        <div class="img-inner">
                                                            <img src="{{$img_src}}" alt="{{$course->title}}" />
                                                        </div>
                                                        <div class="status">
                                                            @if($course->discount > 0)
                                                                <div class="percentage">{{$course->discount}}</div>
                                                            @endif
                                                            @if($course->have_certificate)
                                                                <div class="certificate">گواهینامه دارد</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="card-b">
                                                        <h3 class="name">{{$course->title}}</h3>
                                                        <div class="info">
                                                            <h4 class="teacher"><i class="mdi mdi-account-outline"></i>{{$teacher}}</h4>
                                                            <p class="duration"><i class="mdi mdi-clock-outline"></i>مدت زمان دوره :
                                                                <span>{{$time}}
                                                    ساعت</span>
                                                            </p>
                                                            @if($course->register_count >0)
                                                                <p class="students"><i class="mdi mdi-school-outline"></i>هنرآموزان :
                                                                    <span>{{$course->register_count}}
                                                    نفر</span>
                                                                </p>
                                                            @endif
                                                            <div class="price-content off-code">
                                                                <div class="price">
                                                                    @if($course->old_price > 0)
                                                                        @if($course->old_price <> $course->price)
                                                                            <div class="real">{{ number_format($course->old_price) }}</div>
                                                                        @endif
                                                                    @endif
                                                                    @if($course->price > 0)
                                                                        <div class="off">{{ number_format($course->price) }}</div>
                                                                    @else
                                                                        <div class="off">رایگان</div>
                                                                    @endif
                                                                </div>
                                                                <div class="text">
                                                                    @if($course->price > 0)
                                                                        <span class="toman">تومان</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach

                                </div>
                                <!-- Add Options -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                      @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <!-- دوره های پیش ثبت نام -->
    <div class="education-section">
        <div class="container-lg">
            <div class="title">
                <div class="title-inner">
                    <div class="shape"></div>
                    <h2> پیش ثبت نام</h2>
                </div>
            </div>
            <div class="section-inner">
                <nav>
                    <div class="nav nav-tabs tab-border" role="tablist">

                        @foreach($cats as $cat)
                            @if(count($cat->courses) >0)
                            <button class="nav-link @if($loop->index == 0) active @endif" data-bs-toggle="tab"
                                    data-bs-target="#nav-course-{{ $cat->id }}"
                                    role="tab">{{ $cat->title }}
                            </button>
                            @endif
                        @endforeach

                    </div>
                </nav>
                <div class="tab-content mt-4">

                    @foreach($cats as $cat)
                        @if(count($cat->courses) >0)
                        <div class="tab-pane fade @if($loop->index == 0) show active @endif"
                             id="nav-course-{{ $cat->id }}" role="tabpanel" tabindex="0">
                            <div class="swiper swiper-courses" dir="rtl">
                                <div class="swiper-wrapper">

                                    @foreach($cat->courses as $course)
                                        @if($course->status == 2)
                                            <?php $title = str_replace(' ', '_', $course->title);
                                                $img_src=$course->getThumbnail();
                                                $img_src="assets-v2/images/thumb.png";
                                            $slug= "course/".$course->getSlug();
                                            $teacher= $course->teacher ? $course->teacher->fullname : 'کسبوم';
                                            $time=$course->minutes > 0 ? $course->hour.':'.$course->minutes : $course->hour;
                                            ?>
                                        <div class="swiper-slide">
                                            <div class="card-course" title="{{$course->title}}">
                                                <a href="{{$slug}}">
                                                    <div class="img-container">
                                                        <div class="img-inner">
                                                            <img src="{{$img_src}}" alt="{{$course->title}}" />
                                                        </div>
                                                        <div class="status">
                                                            @if($course->discount > 0)
                                                                <div class="percentage">{{$course->discount}}</div>
                                                            @endif
                                                            @if($course->have_certificate)
                                                                <div class="certificate">گواهینامه دارد</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="card-b">
                                                        <h3 class="name">{{$course->title}}</h3>
                                                        <div class="info">
                                                            <h4 class="teacher"><i class="mdi mdi-account-outline"></i>{{$teacher}}</h4>
                                                            <p class="duration"><i class="mdi mdi-clock-outline"></i>مدت زمان دوره :
                                                                <span>{{$time}}
                                                    ساعت</span>
                                                            </p>
                                                            @if($course->register_count >0)
                                                                <p class="students"><i class="mdi mdi-school-outline"></i>هنرآموزان :
                                                                    <span>{{$course->register_count}}
                                                    نفر</span>
                                                                </p>
                                                            @endif
                                                            <div class="price-content off-code">
                                                                <div class="price">
                                                                    @if($course->old_price > 0)
                                                                        @if($course->old_price <> $course->price)
                                                                            <div class="real">{{ number_format($course->old_price) }}</div>
                                                                        @endif
                                                                    @endif
                                                                    @if($course->price > 0)
                                                                        <div class="off">{{ number_format($course->price) }}</div>
                                                                    @else
                                                                        <div class="off">رایگان</div>
                                                                    @endif
                                                                </div>
                                                                <div class="text">
                                                                    @if($course->price > 0)
                                                                        <span class="toman">تومان</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                      @endif
                                    @endforeach

                                </div>
                                <!-- Add Options -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
@endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <!-- مدرس شوید -->
    <div class="education-section become-teacher-section">
        <div class="container-lg">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="become-teacher-content">
                        <div class="title">
                            <div class="title-inner">
                                <h2>مدرس شوید</h2>
                            </div>
                        </div>
                        <p class="mb-4">
                            اگر تخصص یا مهارتی دارید و علاقه‌مند هستید دانش خود را با دیگران به اشتراک بگذارید، به جمع
                            مدرسان کسبوم بپیوندید. با ثبت‌نام به عنوان مدرس، می‌توانید دوره‌های آموزشی خود را برگزار
                            کنید، درآمد کسب کنید و به رشد جامعه مهارت‌آموزان کمک نمایید.
                        </p>
                        <div class="btns-action">
                            <a href="#" class="btn btn-default icon-right"><i class="mdi mdi-check"></i>ثبت نام مدرس</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="become-teacher-image text-center">
                        <img src="/assets-v2/images/600x480.svg" alt="مدرس شوید" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Small Category -->
    <div class="small-category">
        <div class="container-lg">

            <div class="category-inner">
                @foreach($cats as $cat)
                <div class="item">
{{--                    <a href="skill/category/3/صنایع_نساجی_و__پوشاك">--}}
                    <a href="category/{{$cat->slug}}">
                        <div class="icon">
                            <img src="{{$cat->getImage()}}" alt="{{$cat->title}}">
                        </div>
                        <h3 class="text">{{$cat->title}}</h3>
                    </a>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- Banner Section -->
    <div class="banner-section">
        <div class="container-lg">
            <div class="section-inner">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="banner-item">
                            <a href="{{ url('work-with-us') }}">
                                <img src="/assets-v2/images/7.jpg" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="banner-item">
                            <a href="{{ url('skill/course_suggestion') }}">
                                <img src="/assets-v2/images/8.jpg" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- popular Course -->
    <div class="big-course-section" id="big-preview-section">
        <div class="container-lg">
            <div class="section-inner">
                <div class="grid-layout">
                    <div class="grid-title">
                        <div class="shape"></div>
                        <h2>تخفیف ویژه</h2>
                    </div>
                    <!-- Video Preview -->
                    <div class="grid-video-preview">
                        <div class="preview-inner">
                            <div class="swiper swiper-course-video">
                                <div class="swiper-wrapper">

                                    @foreach ($discount_courses_video as $course)

                                         <div class="swiper-slide">
                                        <div class="card-course-big">
                                            <div class="card-inner">
{{--                                                <div class="video-preview">--}}
{{--                                                    <video class="video" controls>--}}
{{--                                                        <source src="/assets-v2/videos/sample.mp4">--}}
{{--                                                    </video>--}}
{{--                                                </div>--}}
                                                <div class="video-preview">
                                                    <div class="r1_iframe_embed"> <iframe src="https://player.arvancloud.ir/index.html?config={{$course->cloud_json_url}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe> </div>
                                                </div>

                                                <div class="information">
                                                    <div class="info-inner">
                                                        <h2 class="name">{{ $course->title }}</h2>
                                                        <h3 class="teacher"><i class="mdi mdi-account-outline"></i>{{ $course->teacher?->fullname }}</h3>
                                                        <p class="duration"><i class="mdi mdi-clock-outline"></i>مدت
                                                            زمان دوره :
                                                            @if($course->hour)
                                                                <span>{{ $course->hour }}
                                                                ساعت</span>
                                                            @else
                                                                <span>{{ $course->minutes }}
                                                                دقیقه</span>
                                                                @endif
                                                        </p>
                                                        <p class="students"><i
                                                                class="mdi mdi-school-outline"></i>هنرآموزان :
                                                            <span>{{ $course->register_count }}
                                                                نفر</span>
                                                        </p>

                                                        <div class="price-content">
                                                            <h3>
                                                                @if($course->price > 0)
                                                                    {{ number_format($course->price) }}
                                                                    <span>تومان</span>
                                                                @else
                                                                    <span>رایگان</span> @endif
                                                            </h3>
                                                            @if($course->discount > 0)
                                                                <div class="percentage">{{ $course->discount }}%</div>
                                                            @endif
                                                        </div>

                                                        <div class="button-group">
                                                            <a href="skill/take_course/{{$course->id}}/{{str_replace(' ', '_', $course->title)}}" class="btn btn-secondary icon-right"><i
                                                                    class="mdi mdi-plus-circle-outline"></i>خرید
                                                                دوره</a>
                                                            <a href="course/{{ $course->getSlug() }}"
                                                               class="btn btn-default-outline icon-right">جزییات
                                                                بیشتر<i class="mdi mdi-eye"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="status">
                                                        <ul>
                                                            <li>
                                                                <span class="icon"><i
                                                                        class="mdi mdi-clock-outline"></i></span>
                                                                <span class="text">مدت دوره</span>
                                                                <span class="time">{{ $course->video_minutes <= 0 ? ((($course->hour) * 60) + ($course->minutes)) : $course->video_minutes }} دقیقه</span>
                                                            </li>
                                                            <li>
                                                                <span class="icon"><i
                                                                        class="mdi mdi-bookshelf"></i></span>
                                                                <span class="text">کتاب آموزشی</span>
                                                                <span class="time">{{ $course->book_pages > 0 ? $course->book_pages : 0 }} صفحه</span>
                                                            </li>
                                                            <li>
                                                                <span class="icon"><i
                                                                        class="mdi mdi-face-agent"></i></span>
                                                                <span class="text">پشتیبانی آنلاین</span>
                                                                <span class="time">30 روز</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Small Video -->
                    <div class="grid-small-video">
                        <div class="swiper swiper-course-thumb">
                            <div class="swiper-wrapper">

                                @foreach ($discount_courses_video as $course)

                                    <div class="swiper-slide">
                                        <div class="item">
                                            <div class="img-cover">
                                                <img src="_upload_/_courses_/{{$course->code}}/medium_{{$course->image}}" alt="{{$course->title}}">
                                            </div>
                                            <div class="name">{{ $course->title }}</div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Section -->
    <div class="banner-section my-4">
        <div class="container-lg">
            <div class="section-inner">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="banner-item">
                            <a href="https://instagram.com/kasboom" target="_blank">
                                <img src="/assets-v2/images/9.jpg" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <div class="banner-item">
                            <a href="{{ url('roadmap') }}" target="_blank">
                                <img src="/assets-v2/images/10.jpg" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <div class="banner-item">
                            <a href="{{ url('check-certificate') }}" target="_blank">
                                <img src="/assets-v2/images/11.jpg" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kasboom Status -->
    <div class="kasbom-status mb-0">
        <div class="container-lg">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="card-status">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                <path
                                    d="M60.21,20a2.17,2.17,0,0,1-1.55,1.34c-.68.2-1.34.48-2,.7a.46.46,0,0,0-.39.54q0,7.65,0,15.29a.55.55,0,0,0,.38.56,5,5,0,0,1,0,9,.62.62,0,0,0-.41.65c0,1.87,0,3.74,0,5.61a1.66,1.66,0,1,1-3.3,0c0-1.87,0-3.74,0-5.61a.61.61,0,0,0-.41-.65,5,5,0,0,1-.07-9c.26-.14.49-.21.48-.61q0-7.12,0-14.24a1.66,1.66,0,0,0,0-.24l-.86.29c-1,.34-2,.72-3,1a.61.61,0,0,0-.5.7c0,3.22,0,6.45,0,9.67A3.63,3.63,0,0,1,47,38.26a14,14,0,0,1-4.17,1.92,38.05,38.05,0,0,1-14.08,1.36,30.32,30.32,0,0,1-8.68-1.81,18.14,18.14,0,0,1-3.14-1.66,3.2,3.2,0,0,1-1.43-2.92c0-3.24,0-6.49,0-9.73a.68.68,0,0,0-.56-.77c-3.26-1.14-6.51-2.31-9.77-3.46a1.68,1.68,0,0,1-1.26-1.5A1.62,1.62,0,0,1,5.15,18l8.7-3.07q8.69-3.08,17.38-6.15a2.37,2.37,0,0,1,1.66,0q13,4.59,25.93,9.15a2.15,2.15,0,0,1,1.39,1.29Zm-49.68-.4.66.27,20.32,7.22a1.49,1.49,0,0,0,1.1,0L50.19,20.8l3.37-1.21-.41-.18Q42.83,15.77,32.5,12.14a1.43,1.43,0,0,0-.89,0q-6.49,2.27-13,4.57Zm8.31,6.49c0,.18-.05.29-.05.39,0,2.86,0,5.72,0,8.58a.86.86,0,0,0,.38.64,20.06,20.06,0,0,0,3,1.32,35.2,35.2,0,0,0,17.33.64,16.75,16.75,0,0,0,5.26-1.85,1,1,0,0,0,.54-1c0-2.7,0-5.39,0-8.08v-.67l-.7.23c-3.89,1.39-7.79,2.76-11.69,4.16a2.45,2.45,0,0,1-1.75,0c-3.08-1.12-6.17-2.21-9.26-3.3ZM54.58,41.26A1.64,1.64,0,0,0,53,42.91a1.66,1.66,0,1,0,1.63-1.65Z"/>
                            </svg>
                        </div>
                        <div class="info">
                            <h4>تعداد مهارت آموزان</h4>
                            <h6>{{$student_count}} نفر</h6>
                        </div>
                    </div>
                </div>
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-6">--}}
{{--                    <div class="card-status">--}}
{{--                        <div class="icon">--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">--}}
{{--                                <path--}}
{{--                                    d="M7.81,25.83A7,7,0,0,1,9,23.18a5.52,5.52,0,0,1,4.42-2.25c2.56,0,5.13-.06,7.69,0a5.25,5.25,0,0,1,4.78,3c1.72,3.38,3.41,6.79,5.1,10.19a1.88,1.88,0,0,1-1.2,2.79,1.9,1.9,0,0,1-2.17-1.11l-3.35-6.69c-.56-1.12-1.13-2.24-1.68-3.37a1.76,1.76,0,0,0-1.66-1h-7.4a1.84,1.84,0,0,0-1.89,1.88c0,3.43,0,6.85,0,10.28a1.87,1.87,0,0,0,1.83,1.89,1.88,1.88,0,0,1,1.93,2q0,6.65,0,13.3a1.89,1.89,0,1,1-3.77,0c0-3.8,0-7.61,0-11.41a.57.57,0,0,0-.4-.62,5.56,5.56,0,0,1-3.28-4.1c0-.14-.07-.27-.1-.4Z"/>--}}
{{--                                <path--}}
{{--                                    d="M18,7.81a7.45,7.45,0,0,1,2.57,1.08,5.65,5.65,0,1,1-4.39-1l.31-.1Zm-.72,3.77a1.89,1.89,0,1,0,1.85,1.93A1.89,1.89,0,0,0,17.28,11.58Z"/>--}}
{{--                                <path--}}
{{--                                    d="M36.66,11.58h8a7.55,7.55,0,0,1,7.71,7.69c0,2.77,0,5.53,0,8.3a1.89,1.89,0,1,1-3.77-.06c0-2.69,0-5.37,0-8.06a3.79,3.79,0,0,0-4.08-4.09H28.21a1.89,1.89,0,1,1,0-3.77Z"/>--}}
{{--                                <path--}}
{{--                                    d="M48.56,39.88c0-.94,0-1.82,0-2.7a1.89,1.89,0,1,1,3.77,0v2.55a1.5,1.5,0,0,0,0,.17c.62,0,1.26,0,1.9,0a1.86,1.86,0,0,1,1.79,1.46,1.84,1.84,0,0,1-.94,2.07,2.25,2.25,0,0,1-1,.23H28.61a1.88,1.88,0,1,1,.05-3.76h19.9Z"/>--}}
{{--                                <path--}}
{{--                                    d="M22.9,44.08c0,3.36,0,6.73,0,10.09a1.89,1.89,0,0,1-3.77.14c0-.36,0-.72,0-1.08q0-9.55,0-19.09a1.9,1.9,0,0,1,1.16-1.93A1.87,1.87,0,0,1,22.9,34C22.91,37.36,22.9,40.72,22.9,44.08Z"/>--}}
{{--                            </svg>--}}
{{--                        </div>--}}
{{--                        <div class="info">--}}
{{--                            <h4>تعداد مدرسان</h4>--}}
{{--                            <h6>{{$teachers_count}}</h6>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="card-status">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                <path
                                    d="M57.78,29.55c-.08-.66-.16-1.35-.28-2A25.66,25.66,0,0,0,45.19,9.73a24.51,24.51,0,0,0-13-3.64q-.66,0-1.32,0a25.43,25.43,0,0,0-18.35,8.79A24.71,24.71,0,0,0,6.23,29.39a25.3,25.3,0,0,0,7.64,21.08,25.28,25.28,0,0,0,14,7.11c.59.1,1.2.17,1.78.24l.84.09h3l.91-.12c.67-.08,1.36-.16,2-.28a25.49,25.49,0,0,0,14.82-8.24,25.71,25.71,0,0,0,6.51-14.66l.08-.76,0-.35v-3C57.86,30.18,57.82,29.87,57.78,29.55Zm-10,18.24A22.11,22.11,0,0,1,32,54.35H32a22.38,22.38,0,1,1,15.83-6.56Z"/>
                                <path
                                    d="M41.76,38.82A1.75,1.75,0,0,1,40.1,40a1.82,1.82,0,0,1-.9-.25,7,7,0,0,1-.59-.41l-.13-.1-2.31-1.74q-2.52-1.89-5.05-3.77a2.1,2.1,0,0,1-.92-1.81c0-1.67,0-3.35,0-5q0-3.36,0-6.72a1.83,1.83,0,0,1,1.75-2,1.92,1.92,0,0,1,.66.12,1.82,1.82,0,0,1,1.15,1.82c0,1.23,0,2.46,0,3.68v2.91c0,1.32,0,2.65,0,4a1,1,0,0,0,.44.88c2.28,1.7,4.55,3.4,6.82,5.12A1.75,1.75,0,0,1,41.76,38.82Z"/>
                            </svg>
                        </div>
                        <div class="info">
                            <h4>مجموع آموزش ها (دقیقه)</h4>
                            <h6>{{$total_learn_time}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="card-status">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                <path
                                    d="M55.76,44.18c-.6,0-1.19,0-1.74,0,.26-3.35.11-6.68.13-10v-3A12.83,12.83,0,1,0,35.73,18H12.54a6.24,6.24,0,0,0-2.19.37l-.35.15-.15.08a5,5,0,0,0-2,2,.67.67,0,0,0-.06.15,5.65,5.65,0,0,0-.53,2.54V39.85c0,1.43,0,2.85.08,4.33H5.83a2.93,2.93,0,0,0-3,3.11,8.17,8.17,0,0,0,8.14,8q12.27,0,24.54,0H50.19a8.16,8.16,0,0,0,8.35-7c0-.07.07-.12.09-.18V46.57A8.14,8.14,0,0,0,58,45.29,2.74,2.74,0,0,0,55.76,44.18ZM38.9,18a9.69,9.69,0,1,1,12,11.09,10,10,0,0,1-2.46.31,9.68,9.68,0,0,1-9.7-9.7A9.6,9.6,0,0,1,38.9,18Zm-28.41,5a1.72,1.72,0,0,1,1.72-1.71h23.5a12.82,12.82,0,0,0,12.74,11.3,13.32,13.32,0,0,0,2.46-.24v1.89a2,2,0,0,1,0,.23v7.85A1.69,1.69,0,0,1,49,44.17H26.24c0-1.67,0-3.27,0-4.87v-.18a4.9,4.9,0,0,0-1.1-3.24,6.76,6.76,0,0,0-.7-.72,1.74,1.74,0,0,1-.13-.15c1.59-2.75,1.28-5.41-.82-7.13A5.13,5.13,0,0,0,16.16,35s0,.08,0,.1a5.52,5.52,0,0,0-.79.82,5.14,5.14,0,0,0-1.12,3.24,4.68,4.68,0,0,0,0,.53c.07,1.48,0,3,0,4.5-.79,0-1.56.05-2.31,0a1.61,1.61,0,0,1-1.4-1.74V34.52a2,2,0,0,1,0-.34ZM23,44.16H17.51v-.52c0-1.52,0-3,0-4.51h0a1.75,1.75,0,0,1,.86-1.6,3.54,3.54,0,0,1,3.71,0,1.77,1.77,0,0,1,.9,1.63h0C22.94,40.8,23,42.45,23,44.16ZM18.39,31.83a1.85,1.85,0,1,1,1.79,1.87A1.84,1.84,0,0,1,18.39,31.83ZM50.76,52H11.06a4.89,4.89,0,0,1-5-4.3,2,2,0,0,1,0-.25H55.31A4.86,4.86,0,0,1,50.76,52Z"/>
                                <path
                                    d="M51.83,18.61a2,2,0,0,0-.43-.39l-3.52-2.43A1.69,1.69,0,0,0,46,15.6a1.66,1.66,0,0,0-.9,1.63v5a1.7,1.7,0,0,0,2.75,1.43c.93-.64,1.87-1.27,2.78-1.91l.75-.5A1.66,1.66,0,0,0,51.83,18.61Zm-4.1,2.62c-.19.12-.37.26-.56.39V17.78l.3.21L50,19.71Z"/>
                            </svg>
                        </div>
                        <div class="info">
                            <h4>تعداد دوره های آموزشی</h4>
                            <h6>{{$skill_count}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments -->
    <div class="comments-section mt-0 pb-5 no-bg">
        <div class="container-lg">
            <div class="title">
                <h1>نظرات کاربران</h1>
                <p>پیشنهادات، انتقادات و نظرات کاربران از دوره های آموزشی</p>
            </div>
            <div class="section-inner">
                <div class="swiper swiper-comments" dir="rtl">
                    <div class="swiper-wrapper">
                        @foreach($comments as $comment)
                            @if($comment->comment != '')
                                <div class="swiper-slide">
                                    <div class="comment-body">
                                        <div class="comment-header">
                                            <div class="user-img">
                                                <img src="/assets-v2/images/icons/user-comment.svg" />
                                            </div>
                                            <div class="user-info">

                                                <div class="date">
                                                    <div class="time">{{ $comment->regist_date }}</div>
                                                </div>
                                                <div class="text">
                                                    {{ $comment->comment }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <!-- Add Options -->
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- دوره‌های درخواستی -->
    <div class="education-section mt-5">
        <div class="container-lg">
            <div class="title">
                <div class="title-inner">
                    <div class="shape"></div>
                    <h2>دوره‌های درخواستی کاربران</h2>
                </div>
                <div class="title-desc">
                    <p>شما می‌توانید دوره های درخواستی خود را برای ارسال کنید یا در نظر سنجی دوره‌های درخواستی شرکت کنید</p>
                </div>
            </div>
            <div class="section-inner">
                <div class="swiper swiper-courses" dir="rtl">
                    <div class="swiper-wrapper">
                        @foreach($courseSuggestions as $suggest)
                            <div class="swiper-slide">
                                <div class="card-new-course" title="{{ $suggest->title }}">
                                    <div class="card-inner">
                                        <div class="img-container">
                                            <div class="img-inner">
                                                <img src="_upload_/_suggestions_/{{$suggest->id}}.jpg" alt="{{ $suggest->title }}" />
                                            </div>
                                        </div>
                                        <div class="information">
                                            <h2 class="name">{{ $suggest->title }}</h2>
                                            <div class="vote">
                                                <h6>تعداد آرا : <span id="spanRateId_{{$suggest->id}}">{{ $suggest->rate }} </span> رای</h6>
                                                <button id="buttonRateId_{{$suggest->id}}" data-id="{{ $suggest->id }}" type="button" class="btn-vote storeRate">
                                                    @if(in_array($suggest->id, $userSuggestions))
                                                        حذف رای
                                                    @else
                                                        رای دهید
                                                    @endif
                                                </button>
                                            </div>
                                        </div>
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

@endsection

@section('Page_JS')



@endsection
