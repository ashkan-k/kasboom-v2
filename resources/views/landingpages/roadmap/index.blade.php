@extends('layouts.front-master')

@section('Page_Title')
    آموزشگاه کسب بوم - نقشه راه
@endsection

@section('Page_CSS')

@endsection


@section('Content')


    <div class="landing-page-header">
        <div class="container">
            <div class="row align-items-center text-center text-md-start">
                <div class="col-lg-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <div class="text">
                        <h1>نقشه راه</h1>
                        <p>
                            اولین مرحله یک برنامه‌ریزی اصولی داشتن یک نقشه راه است؛ چه بخواهیم برای ایجاد و توسعه یک کسب
                            و کار برنامه‌ریز کنیم، چه برای یک سازمان کلان و یا مشاغل خانگی و حتی برنامه‌ریزی شخصی برای
                            رسیدن به اهداف فردی.

                            نقشه راه یعنی مطالعه و مشاهده همه ابعاد ممکن انجام یک کار با همه جزئیات به نحوی که به همه
                            سوالات پاسخ منطقی ارائه شود و اهداف پیش‌بینی شده محقق گردد.

                            باتوجه به اهمیت نقشه راه در ایجاد یک کسب و کار ، مجموعه کسبوم در نظر دارد یک دید کامل از
                            مشاغل و حرفه ها ارائه دهد تا شما با ابعاد مختلف یک مهارت آشنا شوید.
                        </p>
                        <a href="#" class="btn btn-default icon-left">مشاهده دوره ها<i
                                class="mdi mdi-arrow-left"></i></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="image">
                        <div class="img-inner">
                            <img src="/assets-v2/images/bg/500x50000.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="landing-section border-radius mb-8">
        <div class="container">
            <div class="default-title type-2">
                <h2 class="title">مراحل کارآفرینی</h2>
            </div>
            <div class="section-inner marginbotom-0">
                <div class="roadmap-content">
                    <div class="roadmap-inner">
                        <div class="grid-item">
                            <div class="circle">
                                <div class="number">1</div>
                                <span>وضعیت</span>
                            </div>
                        </div>
                        <div class="grid-item">
                            <div class="circle">
                                <div class="number">2</div>
                                <span>قوانین</span>
                            </div>
                        </div>
                        <div class="grid-item">
                            <div class="circle">
                                <div class="number">3</div>
                                <span>مهارت و پیش نیاز ها</span>
                            </div>
                        </div>
                        <div class="grid-item">
                            <div class="circle">
                                <div class="number">4</div>
                                <span>آموزش</span>
                            </div>
                        </div>
                        <div class="grid-item">
                            <div class="circle">
                                <div class="number">5</div>
                                <span>پشتیبان و تعاونی ها</span>
                            </div>
                        </div>
                        <div class="grid-item">
                            <div class="circle">
                                <div class="number">6</div>
                                <span>طرح توجیهی</span>
                            </div>
                        </div>
                        <div class="grid-item">
                            <div class="circle">
                                <div class="number">7</div>
                                <span>بازار</span>
                            </div>
                        </div>
                        <div class="grid-item">
                            <div class="circle">
                                <div class="number">8</div>
                                <span>ریسک</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="public-section pt-0">
        <div class="container">
            <div class="default-title type-2">
                <h2 class="title">نقشه راه کسب و کارها</h2>
            </div>
            <div class="section-inner">
                <div class="row">
                    @foreach($roadmaps as $roadmap)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                            <div class="card-course mb-4" title="نام دوره">
                                <a href="{{ url("roadmap/$roadmap->slug") }}">
                                    <div class="img-container">
                                        <div class="img-inner">
                                            <img src="{{url("_upload_/_roadmaps_/$roadmap->code/$roadmap->avatar")}}"
                                                 alt="course-name"/>
                                        </div>
                                    </div>
                                    <div class="card-b">
                                        <h2>{{$roadmap->title}}</h2>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection


@section('Page_JS')


@endsection
