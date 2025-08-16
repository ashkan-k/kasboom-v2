<!DOCTYPE html>
<html lang="fa" class="no-js" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <link rel="stylesheet" href="{{ asset('assets/certificate/css/main.css?' . mt_rand()) }}">
</head>

<body>
    <div class="certificate-wrapper">
        <div class="certificate-content">
            <div class="certificate">
                <div class="cert-inner">
                    <div class="logo">
                        <div class="logo-inner">
                            <img src="{{ asset('assets/certificate/images/logo-sazman.png') }}" alt="logo-sazman">
                        </div>
                    </div>
                    <table style="width: 100%">
                        <tbody>
                        <tr>
                            <td>
                                <div class="qr">
                                    <div class="qr-inner">
                                        <img src="{{ url('qrcode?string=https://kasboom.ir/backend/public/certificate/' . $user_course->code) }}" alt="qr-code">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="name-of-organization">
                                    <div class="name-inner">
                                        <h4>مرکز خدمات حوزه‌های علمیه کشور</h4>
                                        <h5>قرارگاه جهادی حضرت خدیجه<span><img src="{{ asset('assets/certificate/images/salam.png') }}" alt="salam"></span></h5>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="date-content">
                                    <h4 class="date">&nbsp; تاریخ : {{ tr_num($user_course->last_date_take_quize, 'fa') }}</h4>
                                    <h5 class="number">&nbsp;شماره : ۱۲۴/ق/۹۹</h5>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="certificate-name">
                        <h1>گواهینامه پایان دوره آموزشی</h1>
                        <div class="user-image">
                            <img style="border-radius: 12px;" src="{{ $user_image }}" alt="user-image">
                        </div>
                    </div>
                    <div class="cert-text">
                        بدینوسیله گواهی می‌شود<br>
                        <div>
                            <span>آقا/خانم</span> <span class="fill-text">{{ $user->name }}</span>
                            <span>فرزند</span> <span class="fill-text">{{ $user->fathername }}</span>
                            <span>با کد ملی</span> <span class="fill-text">{{ tr_num($user->nationalid, 'fa') }}</span>
                            <span>متولد</span> <span class="fill-text">{{ tr_num(substr($user->birthdate, 0, 4), 'fa') }}</span>
                            <span>دوره‌آموزشی</span> <span class="fill-text">{{ $course->title }}</span><br>
                            <span>را به مدت</span> <span class="fill-text">۲۰</span>
                            <span>ساعت نظری و</span> <span class="fill-text">۳۰</span>
                            <span>ساعت عملی با کسب نمره</span> <span class="fill-text">۸۰</span>
                            <span>(عدد)</span> <span class="fill-text">هشتاد</span>
                            <span> (حرف) از صد در این قرارگاه با موفقیت به پایان رسانده‌اند.</span>
                        </div>
                    </div>
                    <div class="cert-sign" style="margin-top: 5mm">
                        <div class="text">
                            <h6>اداره کل معشیت و توانمندسازی</h6>
                            <h6>مرکز خدمات حوزه‌های علمیه</h6>
                        </div>
                        <div class="sign">
                            <img src="{{ asset('assets/certificate/images/certificate-sign.png') }}" alt="sign">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
