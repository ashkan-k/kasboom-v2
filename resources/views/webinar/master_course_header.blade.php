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

  <header class="mynavbar type-2">
    <div class="container">
      <div class="navbar-inner">
        <div class="nav-links">
          <button type="button" class="btn-services-menu">
            <i class="mdi mdi-dots-grid"></i>
            <span>سایر سرویس‌ها</span>
          </button>
          <ul>
            <li><a href="help"><i class="mdi mdi-help-circle-outline"></i>مرکز راهنما</a></li>
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
                  <img src="v4_assets/images/icons/kasbom-services/online-learning.svg" alt="image">
                </div>
                <div class="text">آموزشگاه</div>
              </a>
            </div>
            <div class="service-item">
              <a href="consult">
                <div class="icon">
                  <img src="v4_assets/images/icons/kasbom-services/chat.png" alt="image">
                </div>
                <div class="text">مشاوره</div>
              </a>
            </div>
            <div class="service-item">
              <a href="shop">
                <div class="icon">
                  <img src="v4_assets/images/icons/kasbom-services/store.png" alt="image">
                </div>
                <div class="text">فروشگاه</div>
              </a>
            </div>
            <div class="service-item">
              <a href="wikiidea">
                <div class="icon">
                  <img src="v4_assets/images/icons/kasbom-services/idea.svg" alt="image">
                </div>
                <div class="text">ایده ها</div>
              </a>
            </div>
            <div class="service-item">
              <a href="blogs">
                <div class="icon">
                  <img src="v4_assets/images/icons/kasbom-services/news.svg" alt="image">
                </div>
                <div class="text">مجله</div>
              </a>
            </div>
            <div class="service-item">
              <a href="landuse">
                <div class="icon">
                  <img src="v4_assets/images/icons/kasbom-services/iran.svg" alt="image">
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


  @Yield('Content')



  <!-- footer -->
  <footer class="footer type-2">
    <div class="container">
      <div class="info">
        <img src="v4_assets/images/kasboom-type-2.svg" alt="سامانه توانمندسازی کسب و کارهای بومی و مشاغل خانگی" />
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
            <h4>قزوین، پارک علم و فن آوری امام خمینی (ره)</h4>
          </div>
          <div class="item">
            <div class="icon"><i class="mdi mdi-email-outline"></i></div>
            <h4>info@kasboom.ir</h4>
          </div>
          <div class="item">
            <div class="icon"><i class="mdi mdi-phone-outline"></i></div>
            <h4>8892281 - 0991 / 28422767 - 021</h4>

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
  <script src="assets/js/public/public_webinar.js?1"></script>

  @Yield('Page_JS')

</body>

</html>
