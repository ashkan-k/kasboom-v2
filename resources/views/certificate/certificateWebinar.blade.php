<!DOCTYPE html>
<html lang="fa" class="no-js" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <title>گواهی نامه حضور در وبینار</title>
    <base href="{{asset('/')}}" />
    <link rel="stylesheet" href="css/certificate/main.css?3">
    <link rel="stylesheet" href="css/certificate/print.css?3">
</head>

<body>

<div class="certificate-wrapper">
     <div class="button-action">
            <button type="button" id="btn-print" onclick="javascript:window.print()" value="print">پرینت فاکتور</button>
        </div>
    <div class="certificate-content">
       
        <div class="certificate-kasboom breds">
            <div class="crt-header">
                <div class="logo">
                    <img src="css/certificate/images/logo.svg" alt="logo">
                </div>
                <div class="title">
                    <h1> گواهینامه حضور در وبینار آموزشی آنلاین</h1>
                </div>
            </div>
            <div class="crt-body">
                <div class="shape-content">
                    <div class="shape-right"></div>
                    <div class="shape-left"></div>
                </div>
                <div class="qr-code">
                    <div class="image"><img src="{{$url}}" alt="qr"></div>
                    <div class="date">تاریخ صدور : {{$webinar->webinar->webinar_date}}</div>
                    <div class="number">شماره گواهینامه : {{$webinar->name_certificate}}</div>
                </div>
                <div class="description persian">
                    <h5>بدینوسیله گواهی می‌شود آقا / خانم  </h5>
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
                            در وبینار آنلاین آموزشی
                            <span class="fill-text">{{$webinar->webinar->title}}</span> به مدت <span class="fill-text">{{ $time }}</span> @if($minutes === '00') ساعت @else دقیقه @endif
                            آموزشی در تاریخ  <span class="fill-text">{{ $webinar->webinar->webinar_date }}</span> توسط سامانه کسب بوم برگزار شده است، شرکت نموده اند.
                        </p>
                    </div>
                </div>
                <div class="sign-content">
                    <div class="sign">
                        <div class="image">
                            <img src="css/certificate/images/certificate-sign-kasboom.png" alt="sign-image">
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
                            <img src="css/certificate/images/logo-gharargah.png" alt="sign-image">
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
