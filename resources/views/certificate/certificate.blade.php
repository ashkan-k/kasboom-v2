<!DOCTYPE html>
<html lang="fa" class="no-js" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <title>گواهی نامه</title>
    <base href="{{asset('/')}}" />
    <link rel="stylesheet" href="/certificate/main.css?1">
    <link rel="stylesheet" href="/certificate/print.css?1">
</head>

<body>

<div class="certificate-wrapper">
    <div class="button-action">
            <button type="button" id="btn-print" onclick="javascript:window.print()" value="print">پرینت
                فاکتور</button>
        </div>
    <div class="certificate-content">

        <div class="certificate-kasboom breds">
            <div class="crt-header">
                <div class="logo">
                    <img src="/certificate/images/logo.svg" alt="logo">
                </div>
                <div class="title">
                    <h1>گواهینامه حضور در دوره آموزشی مجازی</h1>
                </div>
            </div>
            <div class="crt-body">
                <div class="shape-content">
                    <div class="shape-right"></div>
                    <div class="shape-left"></div>
                </div>
                <div class="qr-code">
                    <div class="image"><img src="{{$url}}" alt="qr"></div>
                    <div class="date">تاریخ صدور : {{$course->last_date_take_quize}}</div>
                    <div class="number">شماره گواهینامه : {{$course->name_certificate}}</div>
                </div>
                <div class="description persian">
                    <h5>بدینوسیله گواهی می‌شود</h5>
                    <div class="name">
                        <h4>
                            @if ($user->name === null || $user->name === '')
                                {{ $user->firstname }} {{ $user->lastname }}
                            @else
                                {{ $user->name }}
                            @endif
                        </h4>
                    </div>
                    <div class="text">
                        <p>
                            با کد ملی<span class="fill-text">{{ $user->nationalid }}</span> در دوره آموزشی <span class="fill-text">{{$level}}</span> مهارت
                            <span class="fill-text">{{$course->course->title}}</span> به مدت <span class="fill-text">{{ $time }}</span>  ساعت
                            آموزش آنلاین در سامانه کسب بوم شرکت نموده و با
                            کسب نمره ارزشیابی <span class="fill-text">{{ $course->quiz_score }}</span> این دوره را با موفقیت به پایان
                            رسانده است.
                        </p>
                    </div>
                </div>
                <div class="sign-content">
                    <div class="sign">
                        <div class="image">
                            <img src="/certificate/images/certificate-sign-kasboom.png" alt="sign-image">
                        </div>
                        <h5>حسن نجفی - مدیرعامل سامانه جامع کسبوم</h5>
                    </div>
                    <div class="hologram">
                        <div class="holo-inner">
                            <span>محل درج هولوگرام</span>
                        </div>
                    </div>
                    <div class="sign">
                        <div class="image">
                            <img src="/certificate/images/logo-gharargah.png" alt="sign-image">
                        </div>
                        <h5>قرارگاه جهادی حضرت خدیجه<span>(سلام‌الله‌علیها)</span></h5>
                    </div>
                </div>
                <div class="alert">
                    <h6 class="hidden">گواهینامه بدون هولوگرام و مهر برجسته فاقد اعتبار است</h6>
                    <h6>برای اعتبار سنجی گواهینامه به سایت Kasboom.ir مراجعه فرمایید یا کد QR فوق را اسکن نمایید
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 420*297 -->

</body>

</html>
