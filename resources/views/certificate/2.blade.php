<!DOCTYPE html>
<html lang="fa" class="no-js" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <link rel="stylesheet" href="{{ asset('assets/certificate/css/main.css') }}">
</head>
<body>
<div class="certificate-wrapper">
    <div class="certificate-content">
        <div class="certificate-kasboom">
            <div class="cert-inner">
                <div class="logo">
                    <div class="img-inner">
                        <img src="{{ asset('assets/certificate/images/logo-fill.svg') }}" alt="logo">
                    </div>
                    <div class="text">
                        <h4>سامانه جامع توانمند‌سازی</h4>
                        <h4>کسب و کار‌های بومی</h4>
                    </div>
                </div>
                <div class="cert-name">
                    <h1 class="name">گواهینامه پایان دوره آموزشی</h1>
                    <div class="qr">
                        <div class="qr-inner">
                            <img src="{{ asset('assets/certificate/images/qr-code.jpg.png') }}" alt="qr-code">
                        </div>
                    </div>
                    <div class="date-content">
                        <h4 class="date">&nbsp; تاریخ : ۹۹/۱۲/۲۱</h4>
                        <h4 class="number">&nbsp;شماره : ۱۲۴/ق/۹۹</h4>
                    </div>
                </div>
                <div class="cert-text">
                    بدینوسیله گواهی می‌شود<br>
                    <p>
                        آقا/خانم<span class="fill-text">{{ $user->name }}</span>با کد ملی<span class="fill-text">{{ $user->nationalid }}</span>دوره آموزشی<span class="fill-text">مهارت قالیبافی</span>را به مدت<span class="fill-text">50</span>ساعت آموزشی با کسب نمره<span class="fill-text">80</span>(عدد)<span class="fill-text">هشتاد</span>(حرف) از صد در این سامانه با موفقیت به پایان رسانده‌اند
                    </p>
                </div>
                <div class="cert-sign">
                    <h5>معاونت آموزش سامانه کسب بوم</h5>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
