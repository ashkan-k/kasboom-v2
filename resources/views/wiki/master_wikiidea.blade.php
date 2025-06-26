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
    <meta name="keywords" content="کسب بوم، کسب وکارهای بومی، تولید داخلی ، مشاغل خانگی ، پشتیبانی، حمایت ، آموزش مشاغل خانگی، توسعه کسب و کار، آموزش کسب و کار، آموزش و پشتیبانی کسب و کار ، تولید ، کاشت ، پرورش ، تدوین طرح توجیهی ، فروش محصولات بومی ، فروش محصولات خانگی ، غرفه محصولات ، ویکی ایده ، ایده های کسب و کار ، نیازمندی های کسب و کار ، استخدام یار"/>


    <!-- Favicon -->
    <link rel="icon" href="assets/images/brand/favicon.ico" type="image/x-icon"/>
    <style>
        .islam_pattern {
            .data-image-src:"img/islamic/bg4.png";
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
            transform:rotate(360deg);
            -ms-transform:rotate(360deg);
            -webkit-transform:rotate(360deg);
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

    {{--<link href="assets_consult/Css/animate.css" rel="stylesheet" />--}}
    <link href="assets_consult/Css/Style.css" rel="stylesheet" />
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
    <link href="assets/css/icons.css" rel="stylesheet"/>

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


<header class="mynavbar type-2">
        <div class="container">
            <div class="navbar-inner">
                <div class="nav-links">
                    <button type="button" class="btn-services-menu">
                        <i class="mdi mdi-dots-grid"></i>
                        <span>سایر سرویس‌ها</span>
                    </button>
                    <ul>
                        <li><a href=""><i class="mdi mdi-help-circle-outline"></i>مرکز راهنما</a></li>
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
							@if(!Auth::check())
								<a href="web" class="btn-nav ">
							@else
								<a href="web" class="btn-nav active">
							@endif
                                <span class="icon"><i class="mdi mdi-account-outline"></i></span>
                                <span class="text">حساب من</span>
                            </a>
							@if(Auth::check())
								<ul class="user-menu">
									<li><a href="web"><i class="mdi mdi-account-circle-outline"></i>پنل کاربری</a></li>
									<li><a href="web/message"><i class="mdi mdi-email-outline"></i>صندوق پیام</a>
									</li>
									<li><a href="web/setting"><i class="mdi mdi-cog-outline"></i>تنظیمات کاربری</a></li>
									<li><a href="logout" data-bs-toggle="modal" data-bs-target="#modal-exit"><i class="mdi mdi-exit-to-app"></i>خروج</a></li>
								</ul>
							@endif
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
                    <div class="services-list">
                        <div class="service-item">
                            <a href="skill">
                                <div class="icon">
                                    <img src="assets-v2/images/icons/kasbom-services/online-learning.svg" alt="image">
                                </div>
                                <div class="text">آموزشگاه</div>
                            </a>
                        </div>
                        <div class="service-item">
                            <a href="consult">
                                <div class="icon">
                                    <img src="assets-v2/images/icons/kasbom-services/chat.png" alt="image">
                                </div>
                                <div class="text">مشاوره</div>
                            </a>
                        </div>
                        <div class="service-item">
                            <a href="#">
                                <div class="icon">
                                    <img src="assets-v2/images/icons/kasbom-services/store.png" alt="image">
                                </div>
                                <div class="text">فروشگاه</div>
                            </a>
                        </div>
                        <div class="service-item">
                            <a href="wikiidea">
                                <div class="icon">
                                    <img src="assets-v2/images/icons/kasbom-services/idea.svg" alt="image">
                                </div>
                                <div class="text">ایده ها</div>
                            </a>
                        </div>
                        <div class="service-item">
                            <a href="blogs">
                                <div class="icon">
                                    <img src="assets-v2/images/icons/kasbom-services/news.svg" alt="image">
                                </div>
                                <div class="text">مجله</div>
                            </a>
                        </div>
                        <div class="service-item">
                            <a href="landuse">
                                <div class="icon">
                                    <img src="assets-v2/images/icons/kasbom-services/iran.svg" alt="image">
                                </div>
                                <div class="text">آمایش سرزمینی</div>
                            </a>
                        </div>
                    </div>
                    <div class="sidebar-text mt-4">
                        <h6>لینک های مفید</h6>
                    </div>
                    <ul class="sidebar-list">
                        <li class="item"><a href="about"><i class="mdi mdi-forum-outline"></i>درباره‌ی ما</a>
                        <li class="item"><a href="work-with-us"><i class="mdi mdi-forum-outline"></i>دعوت به همکاری</a>
						<li class="item"><a href="faq"><i class="mdi mdi-forum-outline"></i>سوالات متداول</a>
                        <li class="item"><a href="contactus"><i class="mdi mdi-forum-outline"></i>تماس با ما</a>
                    </ul>
                </div>
                <div class="overlay-sidebar"></div>
            </div>
        </div>
    </header>


<!-- mobile header -->
<div class="sticky text-white" >
    <div class="horizontal-header clearfix cover-image sptb bg-background-color">
        <div class="content-text mb-0 text-white info">
            <div class="container">
                <a id="horizontal-navtoggle" class="animated-arrow"><span></span></a>
                <a href="wikiidea"> <span class="smllogo"><img src="assets/images/brand/logo-yellow.png" width="40" alt="img"/></span></a>
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
            <li aria-haspopup="true" ><a href="#">
                    <p style="border-right: none;margin: 0;!important;">صفحه نخست</p>
                </a>
            </li>
            <li aria-haspopup="true" ><a href="wikiidea">
                    <p style="border-right: none;margin: 0;!important;">لیست ایده</p>
                </a>
            </li>
            <li aria-haspopup="true" ><a href="landuse">
                    <p style="border-right: none;margin: 0;!important;">آمایش سرزمینی</p>
                </a>
            </li>
            <li aria-haspopup="true" ><a href="wikiidea/share">
                    <p style="border-right: none;margin: 0;!important;">اشتراک گذاری ایده</p>
                </a>
            </li>
            <li aria-haspopup="true" ><a href="wikiidea/best">
                    <p style="border-right: none;margin: 0;!important;">ایده های محبوب</p>
                </a>
            </li>
            <li aria-haspopup="true" ><a href="wikiidea/view">
                    <p style="border-right: none;margin: 0;!important;">ایده های پربازدید</p>
                </a>
            </li>
        </ul>

    </nav>
</div>




<header class="nav-container d-none d-lg-block" >
    <nav class="sina-nav mobile-sidebar navbar-fixed" data-top="60" style="border-bottom:0;min-height:0;position: relative;background-color: #fff">
        <div class="container">

            <div class="sina-nav-header">
            </div>

            <div class="collapse navbar-collapse" id="navbar-menu" style="height: 60px">
                <ul class="sina-menu sina-menu-center IRANSansWeb">
                    <li ><a href="wikiidea" class="text-muted menu_item text-center" style="margin: 12px 8px;font-family: VazirRegular">لیست ایده</a></li>
                    <li><a href="landuse" class="text-muted menu_item" style="margin: 12px 8px">آمایش سرزمینی</a></li>
                    <li><a href="wikiidea/share" class="text-muted menu_item" style="margin: 12px 8px">اشتراک گذاری ایده</a></li>
                    <li><a href="wikiidea/best" class="text-muted menu_item" style="margin: 12px 8px">ایده های محبوب</a></li>
                    <li><a href="wikiidea/view" class="text-muted menu_item" style="margin: 12px 8px">ایده های پربازدید</a></li>
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
                    <label id="waitingTitle" >در حال پردازش</label></h5>
            </div>
            <div class="modal-body" style="text-align: center; float:top">
                <img id="WaitingImage" src="" height="200p" width="200px" />
                <br>
                <label class="label-warning" id="waitingMess">در حال پردازش درخواست می باشد لطفا شکیبا باشید</label>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="quran_modal" tabindex="-1" role="dialog"  aria-hidden="true">
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


<section>
  <footer class="bg-white" style="/*background-image: linear-gradient(to right, #3f8d74 , #3f8d74)background-image: url('assets/images/footer.jpg');background-repeat: repeat;#*/">
    <div class="footer-main text-dark">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-12">
            <h6>کسب بوم</h6>
            <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto">
            <p class="text-justify text-dark" style="font-family: VazirRegular">
              سامانه جامع «کسب بوم»، امکانی است برای کارآفرین شدن. اگر به دنبال تقویت مهارت ،ایجاد و توسعه کسب و کار مورد علاقه تون و یا حتی فروش و صادرات محصولات تون هستید روی کمک کسب بوم حساب کنید. در کسب بوم یک چرخه کامل ایده تا تولید طراحی شده است تا بدون دغدغه و نگرانی کار و حرفه خود را شروع کنید و به یک درآمد پایدار برسید.
            </p>
          </div>
          <div class="col-lg-2  col-md-12">
            <h6>خدمات ما</h6>
            <hr class="deep-purple  text-primary accent-2 mb-4 mt-0 d-inline-block mx-auto">
            <ul class="list-unstyled mb-0">
              <li><a href="news" class="text-dark" style="font-family: VazirRegular">اخبار کسب بوم</a></li>
              <li><a href="work-with-us"  style="font-family: VazirRegular"  class="text-dark">فرصت های شغلی</a></li>
              <li ><a href="faq"  style="font-family: VazirRegular" class="text-dark">سوالات متداول</a></li>
              <li ><a href="about"  style="font-family: VazirRegular" class="text-dark">درباره ما</a></li>
              <li ><a href="contactus"  style="font-family: VazirRegular" class="text-dark">تماس با ما</a></li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-12">
            <h6>تماس</h6>
            <hr class="deep-purple  text-primary accent-2 mb-4 mt-0 d-inline-block mx-auto">
            <ul class="list-unstyled mb-0">
              <li>
                <a style="font-family: VazirRegular"><i class="fa fa-home ml-3 text-primary"></i> قزوین، پارک علم و فناوری امام خمینی(ره) </a>
              </li>
              <li>
                <a href="mailto:info@kasboom.ir" style="font-family: VazirRegular" class="text-dark"><i class="fa fa-envelope ml-3 text-primary"></i> info@kasboom.ir</a></li>
              <li>
                <a href="tel:02833694208"  class="IRANSansWeb_Light text-dark" style="font-family: VazirRegular"><i class="fa fa-phone ml-3 text-primary"></i>8892281 0991</a>
              </li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-12">
            <h6>عضویت در خبرنامه کسب بوم</h6>
            <hr class="deep-purple  text-primary accent-2 mb-4 mt-0 d-inline-block mx-auto">
            <div class="clearfix"></div>
            <form>
              <div class="input-group w-100">
                <input type="number" class="form-control input-lg w3-border" minlength="11" required pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" id="newletter_phonenumber" maxlength="11" name="newletter_phonenumber" placeholder="شماره موبایل  - 09121234567">
                <div class="input-group-append ">
                  <button type="button" id="btn_send_news_letter" class="btn btn-primary br-tr-3  br-br-3"> عضویت </button>
                </div>
              </div>
            </form>
            <ul class="list-unstyled list-inline">
              <li class="list-inline-item">
                <a class="rgba-white-slight mx-1 waves-effect waves-light">
                  <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=187230&amp;Code=fClIpoxv7ECnUUm0sj53"> <img referrerpolicy="origin" src="assets/images/certs/enamad.png" alt="" style="cursor:pointer" id="fClIpoxv7ECnUUm0sj53"></a>
                </a>
              </li>
              <li class="list-inline-item">
                <div id="zarinpal">
                  <script src="https://www.zarinpal.com/webservice/TrustCode" type="text/javascript"></script>
                </div>
              </li>
            </ul>

          </div>
        </div>
      </div>
    </div>
    <div class="p-0" style="background-color: #eee">
      <div class="container">
        <div class="row d-flex">
          <div class="col-lg-12 col-sm-12 mt-3 mb-3 text-center">
            <a href="#" class="fs-14" style="color: #3e3e3e">طراحی و توسعه توسط  شرکت  ایده نگاران همگام . حق کپی محفوظ است © 1399</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</section>


<div id="waiting_modal" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-family: VazirMedium">
                    <label id="waitingTitle" >در حال پردازش</label></h5>
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
<a href="#top" id="back-to-top" ><i class="fa fa-long-arrow-up"></i></a>


<script src="assets/js/dash.all.min.js"></script>


<!-- Bootstrap js -->
<script src="assets/plugins/bootstrap-4.3.1/js/popper.min.js"></script>
<script src="assets/plugins/bootstrap-4.3.1/js/bootstrap.min.js"></script>

<!-- Notify js -->
<script src="assets_admin/js/jquery.easing.1.3.js"></script>
<script src="assets_admin/js/jquery.toast.js"></script>

<!--Owl Carousel js -->
<script src="assets/plugins/owl-carousel/owl.carousel.js"></script>
{{--<script src="assets/js/owl-carousel-rtl.js"></script>--}}

<script src="assets/plugins/horizontal-menu/horizontal-menu.js"></script>


<script src="assets/js/kasboom.js"></script>
<script src="assets/js/public/public_wiki.js"></script>

<script src="assets_consult/Js/sina-nav.min.js"></script>



@Yield('Page_JS')

</body>

</html>
