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
  <meta content="کسبوم - کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="description">
  <meta content="کسبوم - کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="کسبوم">
  <meta name="keywords" content="کسب بوم، کسب وکارهای بومی، تولید داخلی ، مشاغل خانگی ، پشتیبانی، حمایت ،کسبوم ، کسب بوم، آموزش مشاغل خانگی، توسعه کسب و کار، آموزش کسب و کار، آموزش و پشتیبانی کسب و کار ، تولید ، کاشت ، پرورش ، تدوین طرح توجیهی ، فروش محصولات بومی ، فروش محصولات خانگی ، غرفه محصولات ، ویکی ایده ، ایده های کسب و کار ، نیازمندی های کسب و کار ، استخدام یار" />
  <link rel="stylesheet" href="v4_assets/css/bootstrap.rtl.min.css?10">
  <link rel="stylesheet" href="v4_assets/scss/main.css?10">
  <link rel="stylesheet" href="v4_assets/plugin/noUIslider/nouislider.css?10">

  <!-- Font Icons -->
  <link href="v4_assets/css/materialdesignicons.min.css?10" media="all" rel="stylesheet" type="text/css">

  <!-- Favicon -->
  <link rel="icon" href="v4_assets/images/small-icon.png">
  <link rel="apple-touch-icon" href="v4_assets/images/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="v4_assets/images/logo-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="v4_assets/images/logo-114x114.png">

  <script src="assets/js/sweetalert2@9"></script>

  <!-- Notify -->
  <link rel="stylesheet" href="assets_admin/css/jquery.toast.css" />
  <style>
    .r1_iframe_embed {
      position: relative;
      overflow: hidden;
      width: 100%;
      height: auto;
      padding-top: 56.25%;
    }

    .r1_iframe_embed iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: 0;
    }
  </style>

  @Yield('Page_CSS')

  {{-- <script type="text/javascript">--}}
  {{-- window.$crisp = [];--}}
  {{-- window.CRISP_WEBSITE_ID = "212a49dc-4f00-4c95-8625-5303a79de631";--}}
  {{-- (function () {--}}
  {{-- d = document;--}}
  {{-- s = d.createElement("script");--}}
  {{-- s.src = "https://client.crisp.chat/l.js";--}}
  {{-- s.async = 1;--}}
  {{-- d.getElementsByTagName("head")[0].appendChild(s);--}}
  {{-- })();--}}
  {{-- </script>--}}

</head>


<body>

  <!-- Header -->
  <header class="mynavbar">
    <div class="container">
      <div class="navbar-inner">
        <div class="mobile-links">
          <button type="button" class="btn-mobile-menu">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
          </button>
          <!--<button type="button" class="btn-mobile-menu"><i class="mdi mdi-menu"></i></button>-->
          <!-- Sidebar Menu -->
          <div id="sidebar-menu">
            <div class="sidebar-header">
              <div class="sidebar-logo">
                <a href="#">
                  <img src="v4_assets/images/kasboom.svg" class="sidebarlogo" alt="سامانه جامع توانمندسازی کسب و کارهای بومی و مشاغل خانگی">
                </a>
              </div>
              <div class="sidebar-close">
                <button class="btn-close-menu anim-2s"><i class="mdi mdi-close"></i></button>
              </div>
            </div>
            <ul class="sidebar-list">
              <li class="item"><a href="skill"><i class="mdi mdi-google-classroom"></i>آموزشگاه کسب بوم</a>
              <li class="item"><a href="skill/courses"><i class="mdi mdi-account-group"></i>دوره های آموزشی</a>
              <li class="item"><a href="skill/webinars"><i class="mdi mdi-view-list-outline"></i>وبینارهای آموزشی</a>
              <li class="item"><a href="skill/class"><i class="mdi mdi-frequently-asked-questions"></i>کلاس های حضوری</a>
              <li class="item"><a href="skill/workshops"><i class="mdi mdi-clipboard-text-search"></i>کارگاه های کاروزی</a>
              <li class="item"><a href="skill/certificates"><i class="mdi mdi-bookshelf"></i>گواهی نامه ها</a>
              <li class="item"><a href="work-with-us"><i class="mdi mdi-bookshelf"></i>همکاری در آموزش</a>
            </ul>

          </div>
          <div class="overlay-back"></div>
        </div>
        <div class="logo">
          <a href="#"><span></span></a>
        </div>
        <div class="search">
          <div class="inner">
            <form action="skill/public_search" method="POST" style="margin-top: 0">
              {{csrf_field()}}
              <input type="text" minlength="3" required id="search_title" maxlength="50" name="search_title" placeholder="جستجو در آموزشگاه کسبوم">
              <select style="display: none" class="form-select" name="search_type" aria-label="Default select example">
                <option value="course" selected>دوره های آموزشی</option>
              </select>
              <div class="icon"><i class="mdi mdi-magnify"></i></div>
            </form>
          </div>
        </div>
        <div class="links">
          <ul class="links-list">
            <li class="item"><a href="skill">دوره های آموزشی</a></li>
            <li class="item"><a href="help">مرکز راهنما</a></li>
          </ul>
        </div>
        <!-- Mobile Search -->
        <div class="mobile-search" id="btn-search-mobile">
          <div class="icon"><i class="mdi mdi-magnify"></i></div>
        </div>

        <div class="user-login">
          @if(!Auth::check())
          <!-- Desktop Login -->
          <div class="desktop-login-content active">
            <a href="web" class="btn btn-white icon-right">
              <i class="mdi mdi-login-variant"></i>ورود
            </a>
            <a href="register" class="btn btn-default icon-right">
              <i class="mdi mdi-account-plus-outline"></i>ثبت نام
            </a>

          </div>
          @else
          <!-- Desktop Signin -->
          <div class="desktop-sign-content active">
            <div class="user-info-link">
              <i class="mdi mdi-account-circle-outline"></i>
              <span>{{Auth::user()->name}}</span>
              <i class="mdi mdi-chevron-down"></i>
            </div>
            <ul class="user-menu">
              <li>
                <a href="{{Auth::user()->getLevelUrl()}}">
                  <i class="mdi mdi-account-circle-outline"></i>
                  حساب من
                </a>
              <li>
                @if(Auth::user()->getLevelUrl()=="user")
                <a class="dropdown-item " href="{{Auth::user()->getLevelUrl()}}/course">
                  <i class="mdi mdi-umbrella-outline"></i>دوره های من
                </a>
                @elseif(Auth::user()->getLevelUrl()=="teacher")
                <a class="dropdown-item" href="{{Auth::user()->getLevelUrl()}}/course   ">
                  <i class="mdi mdi-umbrella-outline"></i>دوره های من
                </a>
                @endif
              </li>
              <li>
                <a class="dropdown-item" href="{{Auth::user()->getLevelUrl()}}/message">
                  <i class="mdi mdi-email"></i> صندوق پیام
                </a>
              </li>
              {{-- <li>--}}
              {{-- <a class="dropdown-item" href="user/mynotification">--}}
              {{-- <i class="mdi mdi-cellphone-information"></i> اطلاع رسانی--}}
              {{-- </a>--}}
              {{-- </li>--}}
              <li>
                <a href="{{Auth::user()->getLevelUrl()}}/settings" class="dropdown-item">
                  <i class="mdi mdi-tools"></i> تنظیمات کاربری
                </a>
              </li>
              <li> <a class="dropdown-item " href="logout">
                  <i class="mdi mdi-power"></i> خروج
                </a>
              </li>
            </ul>
          </div>
          @endif

        </div>
      </div>
    </div>
  </header>

  <!-- Mobile Search -->
  <div id="mobile-search-content">
    <div class="ms-inner">
      <div class="search-input">
        <form action="skill/public_search" method="POST" style="margin-top: 0">
          {{csrf_field()}}
          <select style="display: none" class="form-select" name="search_type" aria-label="Default select example">
            <option value="course" selected>دوره های آموزشی</option>
          </select>
          <input type="text" minlength="3" required id="search_title" maxlength="50" name="search_title" class="mobile-search-input" placeholder="جستجو در آموزشگاه کسبوم">
          <button type="submit" class="btn-search arrow-back"><i class="mdi mdi-arrow-left"></i></button>
          <button type="button" class="btn-search clear"><i class="mdi mdi-close"></i></button>
        </form>
      </div>
      <div class="list-result">
        <ul class="tags">
          <!--<li><a href="#">نگهدارنده گوشی</a></li>-->
        </ul>
        <ul class="result">
          <!--<li><a href="#"><i class="mdi mdi-shape-outline"></i><span>دسته بندی موبایل</span>A52</a></li>-->
        </ul>
      </div>
    </div>
  </div>

  @Yield('Content')

  <!-- footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-12">
          <div class="info">
            <img src="v4_assets/images/kasboom.svg" alt="سامانه توانمندسازی کسب و کارهای بومی و مشاغل خانگی" />
            <p>سامانه جامع «کسب بوم»، امکانی است برای کارآفرین شدن. اگر به دنبال تقویت مهارت ،ایجاد و توسعه
              کسب و
              کار و حتی فروش و صادرات محصولات تون هستید روی کمک کسب بوم حساب کنید. اینجا
              یک چرخه
              کامل ایده تا فروش طراحی شده است تا بدون دغدغه و نگرانی کار و حرفه خود را شروع کنید و در کنار
              کسب علم
              و دانش به یک درآمد پایدار برسید </p>
          </div>
        </div>
        <div class="col-lg-3 col-md-4">
          <div class="links">
            <h1>دسترسی سریع</h1>
            <ul>
              <li><a href="news">اخبار کسب بوم</a></li>
              <li><a href="work-with-us">فرصت های شغلی</a></li>
              <li><a href="faq">سوالات متداول</a></li>
              <li><a href="about">درباره ما</a></li>
              <li><a href="contactus">تماس با ما</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-md-4">
          <div class="call">
            <h1>اطلاعات تماس</h1>
            <div class="item">
              <div class="icon"><i class="mdi mdi-home-outline"></i></div>
              <h4>قزوین، پارک علم و فن آوری</h4>
            </div>
            <div class="item">
              <div class="icon"><i class="mdi mdi-email-outline"></i></div>
              <h4>kasboom.ir@gmail.com</h4>
            </div>
            <div class="item">
              <div class="icon"><i class="mdi mdi-phone-outline"></i></div>
              <h4>31200 - 025</h4>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-4">
          <div class="certificate">
            <ul class="list">
              <li>
                <div id="zarinpal">
                  <script src="https://www.zarinpal.com/webservice/TrustCode" type="text/javascript"></script>
                </div>
              </li>
              <!--<li><a href="#"><img src="images/e-logo-3.png" alt="e-nemad" /></a></li>-->
              <li>
                <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=187230&amp;Code=fClIpoxv7ECnUUm0sj53"> <img referrerpolicy="origin" src="v4_assets/images/e-logo-3.png" alt="نماد اعتماد الکترونیکی" style="cursor:pointer" id="fClIpoxv7ECnUUm0sj53"></a>
              </li>

              <!--<li><a href="#"><img src="images/zarin.svg" alt="e-nemad" /></a></li>-->

            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright"><span>طراحی و توسعه توسط شرکت ایده نگاران همگام . حق کپی محفوظ است © 1399</span></div>
  </footer>

  <!-- Mobile Navbar -->
  @include ("master_mobile_navbar")

  <style>
    .crisp-client .cc-kv6t[data-full-view="true"] .cc-1xry .cc-unoo {
      bottom: 60px !important;
    }

    #zarinpal {
      margin: auto
    }

    #zarinpal img {
      width: 65px;
    }
  </style>



</body>

<body>


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

  <!-- Scripts -->
  <script src="v4_assets/js/jquery-3.5.1.min.js"></script>
  <script src="v4_assets/js/bootstrap.bundle.min.js"></script>
  <script src="v4_assets/js/scripts.js"></script>
  <script src="assets_admin/js/jquery.easing.1.3.js"></script>
  <script src="assets_admin/js/jquery.toast.js"></script>
  <script src="assets/js/kasboom.js"></script>
  <script src="assets/js/public/public_skill.js?1"></script>

  @Yield('Page_JS')

</body>

</html>
