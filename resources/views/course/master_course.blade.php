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
  <link rel="stylesheet" href="/assets-v2/css/bootstrap.rtl.min.css?10">
  <link rel="stylesheet" href="/assets-v2/scss/main.css?11">

  <link rel="stylesheet" href="/assets-v2/plugin/swiperjs/swiper-bundle.min.css">

  <!-- Font Icons -->
  <link href="/assets-v2/css/materialdesignicons.min.css?10" media="all" rel="stylesheet" type="text/css">


  <!-- Favicon -->
  <link rel="icon" href="/assets-v2/images/small-icon.png?10">
  <link rel="apple-touch-icon" href="/assets-v2/images/apple-touch-icon.png?10">
  <link rel="apple-touch-icon" sizes="72x72" href="/assets-v2/images/logo-72x72.png?10">
  <link rel="apple-touch-icon" sizes="114x114" href="/assets-v2/images/logo-114x114.png?10">

  <script src="/assets/js/sweetalert2@9"></script>

  <!-- Notify -->
  <link rel="stylesheet" href="/assets_admin/css/jquery.toast.css?10" />
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

    #zarinpal {
      margin: auto
    }

    #zarinpal img {
      width: 65px;
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

  @include('master_header')

  @Yield('Content')

  @include('master_footer')



  <!-- Mobile Navbar -->
  @include ("master_mobile_navbar")


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

  <style>
    .crisp-client .cc-kv6t[data-full-view="true"] .cc-1xry .cc-unoo {
      bottom: 60px !important;
    }
  </style>



</body>

<body class="rtl-demo" style="font-family: VazirMedium;">



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

  <script src="/assets-v2/js/jquery-3.5.1.min.js"></script>
  <script src="/assets-v2/js/bootstrap.bundle.min.js"></script>
  <script src="/assets-v2/plugin/swiperjs/swiper-bundle.min.js"></script>
  <script src="/assets-v2/plugin/swiperjs/swiper-initial.js"></script>
  <script src="/assets-v2/js/scripts.js"></script>
  <script src="/assets-v2/plugin/noUIslider/nouislider.min.js"></script>
  <script src="/assets-v2/plugin/noUIslider/nouislider.initial.js"></script>
  <script src="/assets/js/kasboom.js?4"></script>
  <script src="/assets/js/public/public_skill.js?4"></script>
  <!-- Scripts -->

  <script src="/assets_admin/js/jquery.easing.1.3.js?11"></script>
  <script src="/assets_admin/js/jquery.toast.js?11"></script>

  @Yield('Page_JS')

</body>

</html>
