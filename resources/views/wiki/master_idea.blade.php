<!DOCTYPE html>
<html lang="fa" class="no-js" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta content="کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="description">
  <meta content="کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="author">
  <meta name="keywords" content="کسب بوم، کسب وکارهای بومی، تولید داخلی ، مشاغل خانگی ، پشتیبانی، حمایت ، آموزش مشاغل خانگی، توسعه کسب و کار، آموزش کسب و کار، آموزش و پشتیبانی کسب و کار ، تولید ، کاشت ، پرورش ، تدوین طرح توجیهی ، فروش محصولات بومی ، فروش محصولات خانگی ، غرفه محصولات ، ویکی ایده ، ایده های کسب و کار ، نیازمندی های کسب و کار ، استخدام یار" />
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#07c499" />
  <meta name="msapplication-navbutton-color" content="#07c499">
  <meta name="apple-mobile-web-app-status-bar-style" content="#07c499">

  <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

  <base href="{{asset('/')}}" />
  <title>
    @Yield('Page_Title')
  </title>

  @Yield('Page_CSS_Before')
  <link rel="stylesheet" href="v4_assets/css/bootstrap.rtl.min.css?1">
  <link rel="stylesheet" href="v4_assets/scss/main.css?1">
  <link rel="stylesheet" href="v4_assets/plugin/swiperjs/swiper-bundle.min.css">
  <link rel="stylesheet" href="v4_assets/plugin/noUIslider/nouislider.css">

  <!-- Font Icons -->
  <link href="v4_assets/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css">

  <!-- Favicon -->
  <link rel="icon" href="v4_assets/images/small-icon.png">
  <link rel="apple-touch-icon" href="v4_assets/images/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="v4_assets/images/logo-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="v4_assets/images/logo-114x114.png">

  <script src="assets/js/sweetalert2@9"></script>

  <!-- Notify -->
  <link rel="stylesheet" href="assets_admin/css/jquery.toast.css" />

  <link rel="stylesheet" href="assets/plugins/hls/plyr.css" />

  <style>
    #zarinpal {
      margin: auto
    }

    #zarinpal img {
      width: 65px;
    }
  </style>
  <script type="text/javascript">
    window.$crisp = [];
    window.CRISP_WEBSITE_ID = "212a49dc-4f00-4c95-8625-5303a79de631";
    (function() {
      d = document;
      s = d.createElement("script");
      s.src = "https://client.crisp.chat/l.js";
      s.async = 1;
      d.getElementsByTagName("head")[0].appendChild(s);
    })();
  </script>
  <style>

  </style>

  @Yield('Page_CSS_After')

</head>

<body>

  @include("master_header")

  <!-- Mobile Search -->
  <form method="get" action="https://kasboom.ir/search" id="desktop-search-content" class="">
    <div class="search-inner">
      <div class="search-input">
        <input name="search_title" type="text" class="desktop-search-input" placeholder="جستجو در کسبوم">
        <button type="button" class="btn-arrow-back">
          <span class="text">خروج از جستجو</span>
          <span class="icon">
            <i class="mdi mdi-arrow-left"></i>
          </span>
        </button>
        <button type="button" class="btn-clear"><i class="mdi mdi-close"></i></button>
      </div>
      <div class="list-result">
        <ul class="tags">
          <!--<li><a href="#">گوشی موبایل</a></li>-->

        </ul>
        <ul class="result">
          <!--<li><a href="#"><i class="mdi mdi-shape-outline"></i><span>دسته بندی موبایل</span>A52</a></li>-->
          <!--<li><a href="#"><i class="mdi mdi-shape-outline"></i><span>قاب و نگهدارنده مویابل</span>A52</a></li>-->

        </ul>
      </div>
    </div>
  </form>
  @Yield('Content')

  <!-- Mobile Navbar -->
  @include ("master_mobile_navbar")

  @include("master_footer")

  <!-- Scripts -->
  <script src="v4_assets/js/jquery-3.5.1.min.js"></script>
  <script src="v4_assets/js/bootstrap.bundle.min.js"></script>
  <script src="v4_assets/js/scripts.js"></script>
  <script src="v4_assets/plugin/noUIslider/nouislider.min.js"></script>
  <script src="v4_assets/plugin/noUIslider/nouislider.initial.js"></script>
  <script src="v4_assets/plugin/swiperjs/swiper-bundle.min.js"></script>
  <script src="v4_assets/plugin/swiperjs/swiper-initial.js"></script>
  <script src="assets_admin/js/jquery.toast.js"></script>
  <script src="assets/js/kasboom.js"></script>
  <script src="assets/js/public/public_wiki2.js"></script>


  @Yield('Page_JS')

</body>

</html>
