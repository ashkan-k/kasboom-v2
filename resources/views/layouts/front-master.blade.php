<!DOCTYPE html>
<html lang="fa" class="no-js" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#68c4b4"/>
    <meta name="msapplication-navbutton-color" content="#68c4b4">
    <meta name="apple-mobile-web-app-status-bar-style" content="#68c4b4">
    <title>@yield('Page_Title', 'آموزشگاه کسبوم') کسبوم ‍| </title>

    <link rel="stylesheet" href="/assets-v2/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="/assets-v2/scss/main.css">
    <link rel="stylesheet" href="/assets-v2/plugin/swiperjs/swiper-bundle.min.css">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <base href="{{asset('/')}}"/>

    <!-- Font Icons -->
    <link href="/assets-v2/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css">

    @Yield('Page_CSS_Before')

    <!-- Favicon -->
    <link rel="icon" href="/assets-v2/images/small-icon.png">
    <link rel="apple-touch-icon" href="/assets-v2/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets-v2/images/logo-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets-v2/images/logo-114x114.png">

    <link rel="stylesheet" href="/assets_admin/css/jquery.toast.css?4" />

    <script src="/assets/js/sweetalert2@9"></script>

    @Yield('Page_CSS')

    @Yield('Page_CSS_After')

</head>

<body>
<!-- Loading -->
<div class="wrapper-loading">
    <div class="inner">
        <div class="load-image">
            <img src="/assets-v2/images/loading.svg" alt="">
        </div>
    </div>
</div>

<!-- Header -->
<header class="mynavbar type-2">
    <div class="navbar-banner-top">
        <a href="#" class="text">🎉 به آموزشگاه کسبوم خوش آمدید! از دوره‌های جدید
            دیدن
            کنید.</a>
        <button id="close-banner-top" type="button" aria-label="بستن بنر">
            &times;
        </button>
    </div>
    <div class="container-lg">
        <div class="navbar-inner">
            <div class="nav-links">
                <button type="button" class="btn-services-menu">
                    <i class="mdi mdi-dots-grid"></i>
                    <span>سایر سرویس‌ها</span>
                </button>
                <ul>
                    <li><a href="web/invite-teacher"><i class="mdi mdi-pencil-circle-outline"></i>مدرس شوید</a></li>
                </ul>
            </div>
            <div class="nav-logo">
                <a href="/"><span></span></a>
            </div>
            <div class="nav-actions-group">
                <div class="item search-content">
                    <div class="item-inner">
                        <button type="button" class="btn-nav" id="btn-desktop-search">
                            <span class="icon"><i class="mdi mdi-magnify"></i></span>
                            <span class="text">جستجو</span>
                        </button>
                    </div>
                </div>
                <div class="item users-content">
                    <div class="item-inner">
                        @auth
                            <div class="btn-nav active" data-bs-toggle="modal" data-bs-target="#modal-sign">
                                <span class="icon"><i class="mdi mdi-account-outline"></i></span>
                                <span class="text">حساب من</span>
                            </div>
                            <ul class="user-menu">
                                <li><a href="web"><i class="mdi mdi-account-circle-outline"></i>پنل
                                        کاربری</a></li>
                                <li><a href="web/message"><i class="mdi mdi-email-outline"></i>صندوق پیام</a>
                                </li>
                                <li><a href="web/setting"><i class="mdi mdi-cog-outline"></i>تنظیمات کاربری</a></li>
                                <li><a href="logout" data-bs-toggle="modal" data-bs-target="#modal-exit"><i
                                            class="mdi mdi-exit-to-app"></i>خروج</a></li>
                            </ul>
                        @else
                            <a href="web">
                                <div class="btn-nav active">
                                    <span class="icon"><i class="mdi mdi-account-outline"></i></span>
                                    <span class="text">حساب من</span>
                                </div>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar-wrapper" id="sidebar-wrapper">
            <!-- Sidebar Menu -->
            <div id="sidebar-menu" class="">
                <div class="sidebar-header">
                    <div class="sidebar-text">
                        <h6>سرویس‌های کسبوم</h6>
                    </div>
                    <div class="sidebar-close">
                        <button class="btn-close-menu anim-2s"><i class="mdi mdi-close"></i></button>
                    </div>
                </div>
                <div class="sidebar-text orange mt-4">
                    <h6>لینک های مفید</h6>
                </div>
                <ul class="sidebar-list">
                    <li class="item"><a href="about"><i class="mdi mdi-forum-outline"></i>درباره‌ی ما</a>
                    <li class="item"><a href="work-with-us"><i class="mdi mdi-forum-outline"></i>دعوت به همکاری</a>
                    <li class="item"><a href="contactus"><i class="mdi mdi-forum-outline"></i>تماس با ما</a>
                </ul>
            </div>
            <div class="overlay-sidebar"></div>
        </div>
    </div>
</header>

<!-- Desktop Search -->
<div id="desktop-search-content" class="">
    <div class="search-inner">
        <button type="button" class="btn-arrow-back">
            <i class="mdi mdi-close"></i>
        </button>
        <div class="search-input">
            <form action="search" method="get" class="search-input">
                <input type="text" name="search_title" class="desktop-search-input" placeholder="جستجو در کسبوم">
                <button type="button" class="btn-clear"><i class="mdi mdi-close"></i></button>
                <button type="submit" class="btn-search"><i class="mdi mdi-magnify"></i>جستجو</button>
            </form>
        </div>
        <div class="list-result">
            <ul class="tags">
                <li><a href="#">گوشی موبایل</a></li>
                <li><a href="#">سامسونگ M62</a></li>
                <li><a href="#">تلویزیون ال‌جی</a></li>
                <li><a href="#">پیراهن مردانه</a></li>
                <li><a href="#">نگهدارنده گوشی</a></li>
            </ul>
            <ul class="result">
                <li><a href="#"><i class="mdi mdi-shape-outline"></i><span>دسته بندی موبایل</span>A52</a></li>
                <li><a href="#"><i class="mdi mdi-shape-outline"></i><span>قاب و نگهدارنده مویابل</span>A52</a></li>
                <li><a href="#"><i class="mdi mdi-clock-outline"></i>تی شرت مردانه</a></li>
                <li><a href="#"><i class="mdi mdi-clock-outline"></i>کوشی موبایل</a></li>
                <li><a href="#"><i class="mdi mdi-clock-outline"></i>تی شرت مردانه</a></li>
                <li><a href="#"><i class="mdi mdi-shape-outline"></i><span>دسته بندی موبایل</span>A52</a></li>
                <li><a href="#"><i class="mdi mdi-shape-outline"></i><span>قاب و نگهدارنده مویابل</span>A52</a></li>
                <li><a href="#"><i class="mdi mdi-clock-outline"></i>تی شرت مردانه</a></li>
                <li><a href="#"><i class="mdi mdi-clock-outline"></i>کوشی موبایل</a></li>
                <li><a href="#"><i class="mdi mdi-clock-outline"></i>تی شرت مردانه</a></li>
            </ul>
        </div>
    </div>
</div>

@yield('Content')

<!-- footer -->
<footer class="footer">
    <div class="container-lg">
        <div class="property">
            <ul class="property-list">
                <li>
                    <div class="icon">
                        <img src="/assets-v2/images/icons/footer-icon-quality.svg" alt="icon">
                    </div>
                    <h6> کیفیت Full HD</h6>
                </li>
                <li>
                    <div class="icon">
                        <img src="/assets-v2/images/icons/footer-icon-certificate.svg" alt="icon">
                    </div>
                    <h6>گواهینامه</h6>
                </li>
                <li>
                    <div class="icon">
                        <img src="/assets-v2/images/icons/footer-icon-support.svg" alt="icon">
                    </div>
                    <h6>پشتیبانی مدرس</h6>
                </li>
                <li>
                    <div class="icon">
                        <img src="/assets-v2/images/icons/footer-icon-files.svg" alt="icon">
                    </div>
                    <h6>فایل‌های کمک آموزشی</h6>
                </li>
            </ul>
            <div class="mobile-call-content">
                <h6>شماره تماس</h6>
                <ul class="call-list">
                    <li>02128422767</li>
                    <li>02842083369</li>
                </ul>
            </div>
        </div>
        <div class="links-group">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="item-group">
                        <h3 class="title">با کسبوم</h3>
                        <ul class="links-list">
                            <li><a href="work-with-us">فرصت‌های شغلی</a></li>
                            <li><a href="faq">سوالات متداول</a></li>
                            <li><a href="about">درباره‌ی ما</a></li>
                            <li><a href="contactus">تماس با ما</a></li>
                            <li><a href="help">راهنمای سایت</a></li>
                            <li><a href="skill/courses">دوره‌های آموزشی</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="item-group">
                        <h3 class="title">خدمات مشتریان</h3>
                        <ul class="links-list">
                            <li><a href="work-with-us">فرصت‌های شغلی</a></li>
                            <li><a href="faq">سوالات متداول</a></li>
                            <li><a href="about">درباره‌ی ما</a></li>
                            <li><a href="contactus">تماس با ما</a></li>
                            <li><a href="help">راهنمای سایت</a></li>
                            <li><a href="skill/courses">دوره‌های آموزشی</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="item-group">
                        <h3 class="title">راه های ارتباطی</h3>
                        <ul class="social-icons">
                            <li><a href="https://instagram.com/kasboom"><i class="mdi mdi-instagram"></i></a></li>
                            <li><a href="https://wa.me/989918892281"><i class="mdi mdi-whatsapp"></i></a></li>
                            <li><a href="kasboom.ir@gmail.com"><i class="mdi mdi-email-outline"></i></a></li>
                            <li><a href="https://web.eitaa.com/#/im?p=@kasboom_support">
                                    <svg viewBox="0 0 64 64">
                                        <path d="M45.6,61c-8.8,0-17.7,0-26.5,0c-0.2,0-0.3-0.1-0.5-0.1c-3.6-0.3-6.8-1.7-9.5-4.2c-3.5-3.2-5.4-7.1-5.4-11.9 c0-8.9,0-17.8,0-26.6c0-2,0.4-3.9,1.1-5.8C7.2,6.2,13.2,2.1,20,2.1c8.2,0,16.4,0,24.6,0c4.3,0,8.1,1.5,11.2,4.4 c3,2.8,4.9,6.3,5.2,10.4c0.2,3.3,0.1,6.6,0.1,10c0,0.2-0.2,0.5-0.4,0.6c-0.8,0.7-1.8,1.3-2.6,2c-2,2-4,4.1-6,6.1 c-2.5,2.6-5,5-8.1,6.9c-3.9,2.4-8,3.2-12.4,1.9c-0.4-0.1-0.6,0-0.7,0.3c-0.3,0.7-0.6,1.4-0.7,2.1c-0.3,1.2-0.4,2.4-0.6,3.6 c-0.1,0-0.3,0-0.5,0c-3.9-0.9-7.3-5-7.3-9c0-0.6-0.2-1-0.7-1.4c-3.5-3.1-4.2-7.1-1.8-11.1c1.2-2,2.8-3.7,4.7-5.1 c4.6-3.4,9.6-5.5,15.4-4.9c2.9,0.3,5.3,1.6,7,4.1c0.6,0.9,0.6,1.6-0.1,2.4c-0.4,0.5-0.9,1-1.4,1.3c-3.9,2.5-8.2,3.7-12.8,3.1 c-2.4-0.3-4.3-1.7-3.7-4.9c0-0.1,0-0.3,0-0.5c-2,0.7-3.2,2.1-3.8,3.9c-1,2.5-0.3,4.6,1.7,6.4c-1.7,2.1-2.7,4.4-2.3,7.2 c0.4,2.9,2.7,5.5,4.3,6.1c0-0.2,0.1-0.4,0.1-0.6c0.3-2.9,1.7-5.3,3.9-7.2c1.8-1.5,4-2.6,6.1-3.6c2.2-1,4.4-2,6.5-3.2 c2.8-1.5,4.7-3.9,5.8-6.9c0.5-1.5,0.8-3,0.8-4.6c0.1-2.5-0.2-4.9-1.3-7.2c-2.6-5.6-8.8-7.9-14.5-7C32.9,7.9,30.4,9,28,10.4 c-6.6,4-11.2,9.7-14.1,16.7c-2.1,5-3,10.2-2,15.6c0.9,4.7,3.4,8.5,7.6,11c2.6,1.5,5.4,2.4,8.4,2.7c4.9,0.5,9.5-0.6,13.6-3.3 c2.4-1.6,4.6-3.5,6.5-5.8c2.4-3,4.7-6.1,7.1-9.1c1.5-1.9,3.1-3.8,4.7-5.7c0.3-0.3,0.7-0.6,1.1-0.9c0,0.3,0,0.5,0,0.7 c0,4.2,0,8.4,0,12.6c0,0.7,0,1.3-0.1,2c-0.9,6.7-6,12.3-12.6,13.7C47.4,60.7,46.5,60.8,45.6,61z" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                        <ul class="address">
                            <li><i class="mdi mdi-map-marker"></i>قزوین، پارک علم و فن آوری</li>
                            <li><i class="mdi mdi-phone"></i>
                                <h6>02833694208</h6>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <ul class="certificate">
                        <li><a href="https://www.zarinpal.com/trustPage/kasboom.ir"><img src="/assets-v2/images/zarinpal.svg" alt="e-nemad" /></a></li>
                        <li><a href="https://trustseal.enamad.ir/?id=187230&Code=fClIpoxv7ECnUUm0sj53"><img src="/assets-v2/images/e-logo-3.png" alt="e-nemad" /></a></li>
                        <li><a ><img src="/assets-v2/images/e-logo-1.png" alt="e-nemad" /></a></li>
                        <li><a ><img src="/assets-v2/images/e-logo-2.png" alt="e-nemad" /></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright"><span>طراحی و توسعه توسط شرکت ایده نگاران همگام . حق کپی محفوظ است © 1399</span>
    </div>
{{--    <div class="other-services">--}}
{{--        <ul>--}}
{{--            <li><a href="skill/courses">--}}
{{--                    <img src="/assets-v2/images/icons/kasbom-services/online-learning.svg" alt="آموزشگاه">--}}
{{--                    <h6>آموزشگاه</h6>--}}
{{--                </a></li>--}}
{{--            <li><a href="wikiidea">--}}
{{--                    <img src="/assets-v2/images/icons/kasbom-services/idea.svg" alt="ایده‌ها">--}}
{{--                    <h6>ایده‌ها</h6>--}}
{{--                </a></li>--}}
{{--            <li><a href="landuse">--}}
{{--                    <img src="/assets-v2/images/icons/kasbom-services/iran.svg" alt="آمایش سرزمینی">--}}
{{--                    <h6>آمایش سرزمینی</h6>--}}
{{--                </a></li>--}}
{{--            <li><a href="/">--}}
{{--                    <img src="/assets-v2/images/icons/kasbom-services/supplier.svg" alt="تامین کننده‌ها">--}}
{{--                    <h6>تامین کننده‌ها</h6>--}}
{{--                </a></li>--}}
{{--            <li><a href="roadmap">--}}
{{--                    <img src="/assets-v2/images/icons/kasbom-services/direction.png" alt="نقشه راه">--}}
{{--                    <h6>نقشه راه</h6>--}}
{{--                </a></li>--}}
{{--        </ul>--}}
{{--    </div>--}}
</footer>
<!-- Mobile Navbar -->
<div class="mobile-bottom-navbar">
    <div class="navbar-inner">
        <div class="item active">
            <a href="/">
                <div class="icon home">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                         viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                            <path d="M0,32.9c0-0.6,0-1.2,0-1.8c0.4-1.9,1.6-3.2,2.9-4.5c7.9-7.9,15.8-15.8,23.7-23.7c1.3-1.3,2.6-2.5,4.5-2.9
                        		c0.6,0,1.2,0,1.8,0c1.9,0.4,3.2,1.6,4.5,2.9c7.9,8,15.9,15.9,23.8,23.8c1.3,1.3,2.5,2.6,2.8,4.6c0,0.5,0,1,0,1.5
                        		c0,0.1-0.1,0.2-0.1,0.3c-0.6,2.9-2.9,4.8-5.8,4.8c-0.3,0-0.6,0-0.9,0c0,0.3,0,0.6,0,0.8c0,6.2,0,12.4,0,18.5c0,2.9-2,5.5-4.8,6.4
                        		c-0.4,0.1-0.8,0.2-1.2,0.3c-3.8,0-7.7,0-11.5,0c-1.1-0.4-1.5-1.2-1.5-2.4c0-4.8,0-9.5,0-14.3c0-2.1-1.3-3.4-3.4-3.4
                        		c-1.8,0-3.5,0-5.3,0c-2.3,0-3.6,1.2-3.6,3.5c0,4.7,0,9.4,0,14.2c0,1.2-0.4,2-1.5,2.4c-3.8,0-7.7,0-11.5,0c-0.1,0-0.1-0.1-0.2-0.1
                        		c-3-0.4-5.9-3.1-5.9-7.2c0.1-6,0-12,0-18.1c0-0.2,0-0.5,0-0.8c-0.4,0-0.8,0-1.1,0c-2.3-0.1-4-1.2-5.1-3.2C0.4,34.1,0.2,33.5,0,32.9
                        		z"/>
                        </svg>
                </div>
                <div class="text">خانه</div>
            </a>
        </div>
        <div class="item">
            <a href="">
                <div class="icon store">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                        <path
                            d="M32,29.76c-9.7,0-19.4,0-29.1,0-1.83,0-3-.92-2.92-2.94.11-2.36,0-4.72,0-7.08a13.81,13.81,0,0,1,3.63-9.53c2-2.17,3.94-4.32,5.89-6.49a5.93,5.93,0,0,1,4.65-2q18.3,0,36.61,0a5.89,5.89,0,0,1,4.91,2.36c1.68,2.12,3.39,4.23,5.09,6.34A14,14,0,0,1,64,19.47c0,2.59,0,5.18,0,7.78a2.28,2.28,0,0,1-2.53,2.51ZM23.6,27.49c0-2.9,0-5.72,0-8.55a15.74,15.74,0,0,1,.08-1.68A33,33,0,0,1,26,8.65c.62-1.56,1.3-3.09,2-4.7-1.31,0-2.56,0-3.82,0a.92.92,0,0,0-.93.54,29.17,29.17,0,0,0-4.16,14.86c0,2.46,0,4.91,0,7.37v.78ZM37.16,4C38,6.05,38.87,8,39.64,10.07a26.43,26.43,0,0,1,1.93,10.74c-.1,2,0,4,0,6v.7h4.56c-.07-3.71,0-7.39-.26-11a27,27,0,0,0-4.05-12A.92.92,0,0,0,41.18,4C39.85,3.93,38.52,4,37.16,4Z"/>
                        <path
                            d="M5.64,33.15H59.51v22A6.75,6.75,0,0,1,52.4,62.3h-12v-.82c0-3.9,0-7.8,0-11.71a7.84,7.84,0,0,0-15.68,0c-.05,3.88,0,7.76,0,11.64v.88h-12a6.74,6.74,0,0,1-7-7V33.15Z"/>
                    </svg>
                </div>
                <div class="text">فروشگاه</div>
            </a>
        </div>
        <div class="item">
            <a href="#">
                <div class="icon advice">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                        <path
                            d="M22,.06h3.37a3.11,3.11,0,0,0,.41.11c1.33.24,2.68.38,4,.73A23.61,23.61,0,0,1,46.55,29.2a23.34,23.34,0,0,1-22.3,17.9,23.39,23.39,0,0,1-10.52-2.18,2.32,2.32,0,0,0-2.85.45,8.7,8.7,0,0,1-1.33,1,9.94,9.94,0,0,1-8.29,1.17,1.55,1.55,0,0,1,0-.18c.05-.13.11-.26.17-.4A19,19,0,0,0,1.7,32.13,21.93,21.93,0,0,1,.39,20C2.26,10.06,8.13,3.7,17.77.84A38.19,38.19,0,0,1,22,.06ZM39.63,23.71A3.42,3.42,0,1,0,36.2,27.1,3.43,3.43,0,0,0,39.63,23.71Zm-12.58,0a3.4,3.4,0,1,0-3.42,3.39A3.4,3.4,0,0,0,27.05,23.71ZM7.68,23.66a3.4,3.4,0,1,0,3.42-3.38A3.41,3.41,0,0,0,7.68,23.66Z"/>
                        <path
                            d="M64,40.73c-.19,1.21-.29,2.44-.59,3.62-.48,1.95-1.11,3.86-1.63,5.81A18.91,18.91,0,0,0,62.69,63c.07.15.12.3.21.52a9,9,0,0,1-3.93.41,9.9,9.9,0,0,1-5.8-2.62,2.3,2.3,0,0,0-2.8-.37A23.59,23.59,0,0,1,22.3,54.5c-.83-1-1.54-2.1-2.4-3.29,9.45.91,17.52-1.68,24-8.48s8.61-15,7.24-24.21a2.91,2.91,0,0,1,.46.19A22.83,22.83,0,0,1,63.73,35.9c.08.48.16,1,.23,1.46Z"/>
                    </svg>
                </div>
                <div class="text">مشاوره</div>
            </a>
        </div>
        <div class="item">
            <a href="#">
                <div class="icon profile">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                         viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                            <path d="M15.2,64c-0.7-0.2-1.5-0.3-2.2-0.5c-4.6-1.3-7.4-4.8-7.6-9.6C5.2,49,5.8,44.1,7.6,39.5c1.2-3,3-5.6,5.9-7.2
                        		c1.8-1,3.8-1.4,5.8-1.4c0.6,0,1.3,0.3,1.9,0.7c0.9,0.5,1.8,1.2,2.7,1.7c5.3,3.3,10.7,3.3,16,0c0.7-0.5,1.5-0.9,2.2-1.4
                        		c1.3-1,2.7-1.1,4.2-0.9c4.1,0.6,7.1,2.9,9,6.5c1.8,3.2,2.6,6.8,2.9,10.4c0.2,1.9,0.3,3.7,0.2,5.6c-0.1,5.6-3.9,9.7-9.4,10.4
                        		c-0.1,0-0.3,0.1-0.4,0.1C37.6,64,26.4,64,15.2,64z"/>
                        <path
                            d="M33.1,0c0.8,0.2,1.7,0.3,2.5,0.5C41.2,1.8,46.1,7.2,46.8,13c0.5,3.8-0.1,7.4-2.2,10.6c-2.9,4.3-6.8,6.8-12,7.1
                        		c-6.9,0.5-12.5-3.6-15.1-9.1c-2.4-5.1-1.4-12,2.3-16.3C22.2,2.8,25,1,28.4,0.3C29,0.2,29.6,0.1,30.2,0C31.2,0,32.1,0,33.1,0z"/>
                        </svg>
                </div>
                <div class="text">پروفایل</div>
            </a>
        </div>
    </div>
</div>

<!-- Modal Sign -->
<div class="modal fade" id="modal-sign" tabindex="-1" aria-labelledby="modal-sign-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-sign-title"><i class="fi fi-rr-sign-in"></i>ورود / ثبت نام</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Sign -->
                <div class="modal-signin active">
                    <h3 class="message">برای ورود یا ثبت نام شماره همراه خود را وارد کنید</h3>
                    <form action="">
                        <div class="form-item">
                            <div class="input-group phone-number">
                                <input type="text" class="form-control" placeholder="91xxxxxxxx">
                                <span class="group-text">98+</span>
                            </div>
                            <span class="input-msg">بدون صفر وارد کنید. مثال 9918892281</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">خروج</button>
                            <button type="button" class="btn btn-default btn-sign">تایید و ورود</button>
                        </div>
                    </form>
                </div>
                <!-- First Code -->
                <div class="modal-code">
                    <h3 class="message">شما قبلا ثبت نام کرده اید<br><span>09195556663</span></h3>
                    <form action="">
                        <div class="form-item">
                            <div class="inputgroup nopadding">
                                <input type="password" class="myinput text-center" placeholder="رمز عبور"
                                       autocomplete="off"/>
                            </div>
                        </div>
                    </form>
                    <div class="links-sign">
                        <div class="resend">
                            <button type="button" class="btn-send-code"><i class="fi fi-rr-refresh"></i>ورود با
                                رمز یکبار مصرف
                            </button>
                        </div>
                        <div class="change-number">
                            <button type="button" class="btn-change-number"><i class="fi fi-rr-pencil"></i>تغییر
                                شماره همراه
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">خروج</button>
                        <button type="button" class="btn btn-default btn-login">تایید پیامک</button>
                    </div>
                </div>
                <!-- Password -->
                <div class="modal-password">
                    <h3 class="message">رمز عبور یکبار مصرف ارسال شده به شماره همراه را وارد
                        کنید<br><span>09195556663</span></h3>
                    <form action="">
                        <div class="form-item">
                            <div class="inputgroup nopadding">
                                <input type="password" class="myinput text-center" placeholder="رمز عبور"
                                       autocomplete="off"/>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">خروج</button>
                        <button type="button" class="btn btn-default">ورود به حساب من</button>
                    </div>
                </div>
                <!-- Loading -->
                <div class="loader fix-height active">
                    <div class="load-content"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="/assets-v2/js/jquery-3.5.1.min.js"></script>
<script src="/assets-v2/js/bootstrap.bundle.min.js"></script>
<script src="/assets-v2/plugin/swiperjs/swiper-bundle.min.js"></script>
<script src="/assets-v2/plugin/swiperjs/swiper-initial.js"></script>
<script src="/assets-v2/js/scripts.js"></script>
<script src="/assets-v2/plugin/noUIslider/nouislider.min.js"></script>
<script src="/assets-v2/plugin/noUIslider/nouislider.initial.js"></script>
<script src="/assets/js/kasboom.js?4"></script>
<script src="/assets_admin/js/jquery.easing.1.3.js?11"></script>
<script src="/assets_admin/js/jquery.toast.js?11"></script>
<script src="/assets/js/public/public_skill.js?4"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var btn = document.getElementById('close-banner-top');
        if (btn) {
            btn.addEventListener('click', function () {
                btn.parentElement.style.display = 'none';
            });
        }
    });
</script>

@Yield('Page_JS')

</body>

</html>
