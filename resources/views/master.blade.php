<!DOCTYPE html>
<html lang="fa">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <!-- Meta data -->

    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <base href="{{asset('/')}}" />
    <title>
        @Yield('Page_Title')
    </title>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="description">
    <meta content="کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="author">
    <meta name="keywords" content="کسب بوم، کسب وکارهای بومی، تولید داخلی ، مشاغل خانگی ، پشتیبانی، حمایت ، آموزش مشاغل خانگی، توسعه کسب و کار، آموزش کسب و کار، آموزش و پشتیبانی کسب و کار ، تولید ، کاشت ، پرورش ، تدوین طرح توجیهی ، فروش محصولات بومی ، فروش محصولات خانگی ، غرفه محصولات ، ویکی ایده ، ایده های کسب و کار ، نیازمندی های کسب و کار ، استخدام یار" />
    <meta name="theme-color" content="#07c499" />
    <meta name="msapplication-navbutton-color" content="#07c499">
    <meta name="apple-mobile-web-app-status-bar-style" content="#07c499">

    <!-- Favicon -->
    <link rel="icon" href="assets/images/brand/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/brand/favicon.ico" />
    <style>
        .islam_pattern {
            .data-image-src: "img/islamic/bg4.png";
        }

        .menu_item_rotate {
            margin-bottom: 5px;
            color: white;
            cursor: pointer;
            -webkit-transition: -webkit-transform .5s ease-in-out;
            -ms-transition: -ms-transform .5s ease-in-out;
            transition: transform .5s ease-in-out;
        }

        .menu_item_rotate:hover {
            transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -webkit-transform: rotate(360deg);
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    @Yield('Page_CSS_Before')

    <link href="assets_consult/Css/persianFonts.css" rel="stylesheet" />

    {{--<link href="assets_consult/Css/animate.css" rel="stylesheet" />--}}
    {{--<link href="assets_consult/Css/Style.css" rel="stylesheet" />--}}
    <link href="assets_consult/Css/sina-nav.min.css" rel="stylesheet" />
    <script src="assets_consult/Js/jquery-2.0.0.min.js"></script>

    <!-- Star Rating Js-->
    <script src="assets/plugins/rating/jquery.rating-stars.js"></script>

    <script src="assets_consult/Js/custom.js"></script>
    <script src="assets_consult/Js/sina-nav.min.js"></script>

    <!-- Owl Theme css-->
    <link href="assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />

    <!-- Style css -->
    <link href="assets/css/style-rtl.css" rel="stylesheet" />
    <link href="assets/css/skin-modes.css" rel="stylesheet" />


    <!-- Bootstrap css -->
    {{--<link href="assets/plugins/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" />--}}

    <!-- Font-awesome  css -->
    <link href="assets/css/icons.css" rel="stylesheet" />

    <!--Horizontal Menu css -->
    <link href="assets/plugins/horizontal-menu/horizontal-menu-rtl.css" rel="stylesheet" />

    <!-- Notify -->
    <link rel="stylesheet" href="assets_admin/css/jquery.toast.css" />

    <script src="assets/js/sweetalert2@9"></script>



    <link href="css/fonts.css" rel="stylesheet" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />

    <!-- Color Skin css -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/color-skins/color5.css" />


    <style>
        @media screen and (max-width: 600px) {
            .hidden_mobile {
                visibility: hidden;
                display: none;
            }
        }


        .mfooter {
            /*background-image: url('img/back.jpg');*/
        }
    </style>
    @Yield('Page_CSS_After')

</head>


<body class="rtl-demo" style="font-family: VazirMedium;">
    <!--Loader-->
    {{--<div id="global-loader">--}}
    {{--<img src="assets/images/loader.svg" class="loader-img" alt="img">--}}
    {{--</div><!--/Loader-->--}}


    @Yield('SliderDiv')


    <!--Topbar-->
    <div class="header-main d-none d-lg-block" style="/*background-color: rgba(1, 72, 65, 0.8)*/ background-color:white;height: 60px;">
        <div class="top-bar" style="background-color:white;color: #3e3e3e;border-bottom:0;">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-sm-4 col-7">
                        <div class="top-bar-right d-flex">
                            <div class="clearfix">
                                <ul class="socials">
                                    <li style="margin: 5px 0 0 0;!important;">
                                        <a href="#"> <img src="assets/images/brand/logo_kasboom.png" style="width: 70px;height: 45px" class="header-brand-img" alt="کسب بوم - حمایت از کسب و کارهای بومی"></a>
                                    </li>
                                    <li style="padding-top: 15px;margin: 0;!important;">
                                        <span class="h5 mega_menu" style="font-family: VazirBold;">سامانه جامع توانمندسازی کسب و کارهای بومی</span>
                                    </li>
                                    <li style="width: 300px">
                                        <form action="skill/public_search" method="post" style="margin-top: 0">
                                            {{csrf_field()}}
                                            <div class="input-group">
                                                <input type="text" class="form-control" minlength="3" required id="course_title" maxlength="50" name="course_title" placeholder="جستجو ...">
                                                <div class="input-group-append ">
                                                    <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-search"></i> </button>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-sm-8 col-5">
                        <div class="top-bar-left">
                            <ul class="custom">
                                @if(!Auth::check())
                                <li style="text-align: center">
                                    <a href="web" title="ورود / عضویت" class="text-muted">
                                        <i class="fa fa-sign-in ml-1 text-muted fa-lg"></i>
                                        <br>
                                        <span class="mega_menu">ورود / عضویت</span>
                                    </a>
                                </li>

                                @else
                                <li class="dropdown text-center" style="margin-left: 0">
                                    <span>
                                        <a href="#" class="text-white" data-toggle="dropdown">
                                            <i class="fa fa-user mr-1 fa-lg mega_menu"></i>
                                            <br>
                                            <span class="" style="">&nbsp;پنل کاربری<i class="fa fa-caret-down text-white mr-1 fa-lg mega_menu"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a href="{{Auth::user()->getLevelUrl()}}" class="dropdown-item mega_menu">
                                                <i class="dropdown-icon icon icon-user mega_menu"></i> پنل کاربری
                                            </a>
                                            @if(Auth::user()->getLevelUrl()=="user")
                                            <a class="dropdown-item mega_menu" href="{{Auth::user()->getLevelUrl()}}/course">
                                                <i class="dropdown-icon icon fa fa-mortar-board mega_menu"></i>دوره های من
                                            </a>
                                            @elseif(Auth::user()->getLevelUrl()=="teacher")
                                            <a class="dropdown-item mega_menu" href="{{Auth::user()->getLevelUrl()}}/course">
                                                <i class="dropdown-icon icon fa fa-mortar-board mega_menu"></i>دوره های من
                                            </a>
                                            @endif
                                            <a class="dropdown-item" href="{{Auth::user()->getLevelUrl()}}/message">
                                                <i class="dropdown-icon icon icon-speech mega_menu"></i> صندوق پیام
                                            </a>
                                            {{--<a class="dropdown-item" href="user/mynotification">--}}
                                            {{--<i class="dropdown-icon icon icon-bell"></i> اطلاع رسانی--}}
                                            {{--</a>--}}
                                            <a href="{{Auth::user()->getLevelUrl()}}/settings" class="dropdown-item mega_menu">
                                                <i class="dropdown-icon  icon icon-settings mega_menu"></i> تنظیمات کاربری
                                            </a>
                                            <a class="dropdown-item mega_menu" href="logout">
                                                <i class="dropdown-icon icon icon-power mega_menu"></i> خروج
                                            </a>
                                        </div>
                                    </span>
                                </li>
                                @endif
                                <li style=" border-right:1px solid;border-color: #dfeaea;text-align: center;padding-right: 10px">
                                    <a href="#" title="صفحه نخست" class="text-muted">
                                        <i class="fa fa-home ml-1 fa-lg mega_menu"></i>
                                        <br>
                                        <span class="mega_menu">صفحه نخست</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <!--/Topbar-->
    </div>

    <!-- mobile header -->
    <div class="sticky text-white">
        <div class="horizontal-header clearfix cover-image sptb bg-background-color">
            <div class="content-text mb-0 text-white info">
                <div class="container">
                    <a id="horizontal-navtoggle" class="animated-arrow"><span></span></a>
                    <a href=""> <span class="smllogo"><img src="assets/images/brand/logo1.png" width="120" alt="img" /></span></a>
                    {{--<span class="smllogo-white"><img src="assets/images/brand/logo.png" width="120" alt="img"/></span>--}}
                    @if(Auth::check())
                    <a href="{{Auth::user()->getLevelUrl()}}" title="پنل کاربری" class="callusbtn text-white" style="padding-left: 40px"><i class="fa fa-user ml-1"></i> </a>
                    <a href="logout" title="خروج" class="callusbtn text-white"><i class="fa fa-sign-out" aria-hidden="true" title="خروج"></i></a>
                    @else
                    <a href="web" title="ورود" class="callusbtn"><i class="fa fa-sign-in " aria-hidden="true"></i></a>
                    <a href="#" class="callusbtn" title="صفحه نخست" style="padding-left: 70px"><i class="fa fa-home ml-1"></i> </a>

                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="horizontal-header clearfix cover-image sptb bg-background-color" style="height: 0px;!important;">
        <nav class="horizontalMenu clearfix d-md-flex">
            <ul class="horizontalMenu-list">
                <li aria-haspopup="true"><a href="skill">
                        <p style="border-right: none;margin: 0;!important;">آموزشگاه کسب بوم</p>
                    </a>
                </li>
                <li aria-haspopup="true"><a href="consult">
                        <p style="border-right: none;margin: 0;!important;">اتاق مشاوره</p>
                    </a>
                </li>
                <li aria-haspopup="true"><a href="comming?shop">
                        <p style="border-right: none;margin: 0;!important;">فروشگاه محصولات</p>
                    </a>
                </li>
                <li aria-haspopup="true"><a href="wikiidea">
                        <p style="border-right: none;margin: 0;!important;">ایده های کسب و کار</p>
                    </a>
                </li>

                <li aria-haspopup="true"><a href="blogs">
                        <p style="border-right: none;margin: 0;!important;">مجله کسب بوم</p>
                    </a>
                </li>
                <li aria-haspopup="true"><a href=hires>
                        <p style="border-right: none;margin: 0;!important;">استخدام یار</p>
                    </a></li>
                {{-- <li aria-haspopup="true" ><a href="lives">--}}
                {{-- <p style="border-right: none;margin: 0;!important;">پخش زنده</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}

            </ul>

        </nav>
    </div>

    <header class="nav-container d-none d-lg-block">
        <nav class="sina-nav mobile-sidebar navbar-fixed" data-top="60" style="border-bottom:0;min-height:0;position: relative;background-color: #fff">
            <div class="container">

                <div class="sina-nav-header">
                    {{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">--}}
                    {{--<i class="fa fa-bars"></i>--}}
                    {{--</button>--}}
                    <a class="sina-brand pl-4" href="#">
                        {{--<img src="assets_consult/Images/logo.png" class="img-fluid" />--}}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="navbar-menu" style="height: 60px">
                    <ul class="sina-menu sina-menu-center IRANSansWeb">
                        <li><a href="skill" class="text-muted menu_item text-center" style="margin: 12px 8px;font-family: VazirRegular">آموزشگاه کسب بوم</a></li>
                        <li><a href="consult" class="text-muted menu_item" style="margin: 12px 8px">اتاق مشاوره</a></li>
                        <li><a href="shopp" class="text-muted menu_item" style="margin: 12px 8px">فروشگاه محصولات</a></li>
                        <li><a href="wikiidea" class="text-muted menu_item" style="margin: 12px 8px">ایده های کسب و کار</a></li>
                        <li><a href="hires" class="text-muted menu_item" style="margin: 12px 8px">استخدام یار</a></li>
                        <li><a href="blogs" class="text-muted menu_item" style="margin: 12px 8px">مجله کسب بوم</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    @Yield('Content')



    <div id="waiting_modal" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-family: VazirMedium">
                        <label id="waitingTitle">در حال پردازش</label>
                    </h5>
                </div>
                <div class="modal-body" style="text-align: center; float:top">
                    <img id="WaitingImage" src="" height="200p" width="200px" />
                    <br>
                    <label class="label-warning" id="waitingMess">در حال پردازش درخواست می باشد لطفا شکیبا باشید</label>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="quran_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="examplecontactLongTitle">ثبت نکته</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">لغو</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_add_note">ثبت نکته</button>
                </div>
            </div>
        </div>
    </div><!-- /Message Modal -->

    <footer class="footer type-2">
        <div class="container">
            <div class="info">
                <img src="v4_assets/images/logo.svg" alt="سامانه توانمندسازی کسب و کارهای بومی و مشاغل خانگی" />
                <p>سامانه جامع «کسب بوم»، امکانی است برای کارآفرین شدن. اگر به دنبال تقویت مهارت ،ایجاد و توسعه کسب و کار مورد علاقه تون و یا حتی فروش و صادرات محصولات تون هستید روی کمک کسب بوم حساب کنید. اینجا یک چرخه کامل ایده تا فروش طراحی شده است تا بدون دغدغه و نگرانی کار و حرفه خود را شروع کنید و در کنار کسب علم و دانش به یک درآمد پایدار برسید </p>
            </div>
            <div class="links">
                <ul>
                    <li><a href="news">اخبار کسب بوم</a></li>
                    <li><a href="work-with-us">فرصت های شغلی</a></li>
                    <li><a href="faq">سوالات متداول</a></li>
                    <li><a href="about">درباره ما</a></li>
                    <li><a href="contactus">تماس با ما</a></li>
                </ul>
            </div>
            {{-- <div class="download-app">--}}
            {{-- <ul>--}}
            {{-- <li><a href="#" ><img src="v4_assets/images/download-app/badge-new.png" alt="download from bazar" /></a></li>--}}
            {{-- <li><a href="#"><img src="v4_assets/images/download-app/get1-fa.png" alt="download from myket" /></a></li>--}}
            {{-- <li><a href="#"><img src="v4_assets/images/download-app/google-play-badge.png" alt="download from google play" /></a></li>--}}
            {{-- </ul>--}}
            {{-- </div>--}}
            <div class="call-content">
                <div class="call">
                    <div class="item">
                        <div class="icon"><i class="mdi mdi-home-outline"></i></div>
                        <!--<h4>قزوین، پارک علم و فن آوری امام خمینی (ره)</h4>-->
                    </div>
                    <div class="item">
                        <div class="icon"><i class="mdi mdi-email-outline"></i></div>
                        <h4>info@kasboom.ir</h4>
                    </div>
                    <div class="item">
                        <div class="icon"><i class="mdi mdi-phone-outline"></i></div>
                        <h4>31200 - 025</h4>
                    </div>
                </div>
                <div class="certificate">
                    <ul class="list">
                        {{-- <li><a href="#"><img src="v4_assets/images/e-logo-1.png" alt="e-nemad" /></a></li>--}}
                        {{-- <li><a href="#"><img src="v4_assets/images/e-logo-2.png" alt="e-nemad" /></a></li>--}}
                        <li>
                            {{-- <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=187230&amp;Code=fClIpoxv7ECnUUm0sj53"><img src="v4_assets/images/e-logo-3.png" alt="نماد اعتماد الکترونیکی" style="cursor:pointer" id="fClIpoxv7ECnUUm0sj53" /></a>--}}
                            <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=187230&amp;Code=fClIpoxv7ECnUUm0sj53"> <img referrerpolicy="origin" src="v4_assets/images/e-logo-3.png" alt="نماد اعتماد الکترونیکی" style="cursor:pointer" id="fClIpoxv7ECnUUm0sj53"></a>
                        </li>
                        <li>
                            <div id="zarinpal">
                                <script src="https://www.zarinpal.com/webservice/TrustCode" type="text/javascript"></script>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright"><span>طراحی و توسعه توسط شرکت ایده نگاران همگام . حق کپی محفوظ است © 1399</span></div>
    </footer>



    <div id="waiting_modal" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-family: VazirMedium">
                        <label id="waitingTitle">در حال پردازش</label>
                    </h5>
                </div>
                <div class="modal-body" style="text-align: center; float:top">
                    <img id="WaitingImage" src="" height="200p" width="200px" />
                    <br>
                    <label class="label-warning" id="waitingMess">در حال پردازش درخواست می باشد لطفا شکیبا باشید</label>
                </div>
            </div>
        </div>
    </div>



    <!-- Back to top -->
    <a href="#top" id="back-to-top"><i class="fa fa-long-arrow-up"></i></a>


    <script src="assets/js/dash.all.min.js"></script>

    <!-- Notify js -->
    <script src="assets_admin/js/jquery.easing.1.3.js"></script>
    <script src="assets_admin/js/jquery.toast.js"></script>

    <!--Owl Carousel js -->
    <script src="assets/plugins/owl-carousel/owl.carousel.js"></script>
    <script src="assets/js/owl-carousel-rtl.js"></script>

    <script src="assets/plugins/horizontal-menu/horizontal-menu.js"></script>

    <script src="assets/js/kasboom.js"></script>

    <!-- Bootstrap js -->
    <script src="assets/plugins/bootstrap-4.3.1/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap-4.3.1/js/bootstrap.min.js"></script>


    <script src="assets_consult/Js/sina-nav.min.js"></script>

    @Yield('Page_JS')

</body>

</html>
