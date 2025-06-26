<!DOCTYPE html>


<html lang="fa" class="no-js" dir="rtl">

<head>
  <!-- Meta data -->

  <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

  <base href="{{asset('/')}}" />
  <title>
    @Yield('Page_Title')
  </title>

  <meta content="کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="description">
  <meta content="کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="author">
  <meta name="keywords" content="کسب بوم، کسب وکارهای بومی، تولید داخلی ، مشاغل خانگی ، پشتیبانی، حمایت ، آموزش مشاغل خانگی، توسعه کسب و کار، آموزش کسب و کار، آموزش و پشتیبانی کسب و کار ، تولید ، کاشت ، پرورش ، تدوین طرح توجیهی ، فروش محصولات بومی ، فروش محصولات خانگی ، غرفه محصولات ، ویکی ایده ، ایده های کسب و کار ، نیازمندی های کسب و کار ، استخدام یار" />


  <meta charset="UTF-8">
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

  <link rel="stylesheet" href="v4_assets/css/bootstrap.rtl.min.css?4">
  <link rel="stylesheet" href="v4_assets/scss/main.css?4">
  <link rel="stylesheet" href="v4_assets/plugin/swiperjs/swiper-bundle.min.css">

  <!-- Font Icons -->
  <link href="v4_assets/css/materialdesignicons.min.css?4" media="all" rel="stylesheet" type="text/css">

  <!-- Favicon -->
  <link rel="icon" href="v4_assets/images/small-icon.png?4">
  <link rel="apple-touch-icon" href="v4_assets/images/apple-touch-icon.png?4">
  <link rel="apple-touch-icon" sizes="72x72" href="v4_assets/images/logo-72x72.png?4">
  <link rel="apple-touch-icon" sizes="114x114" href="v4_assets/images/logo-114x114.png?4">


  <!-- Notify -->
  <link rel="stylesheet" href="assets_admin/css/jquery.toast.css?4" />

  <script src="assets/js/sweetalert2@9"></script>

{{--  <script type="text/javascript">--}}
{{--    window.$crisp = [];--}}
{{--    window.CRISP_WEBSITE_ID = "212a49dc-4f00-4c95-8625-5303a79de631";--}}
{{--    (function() {--}}
{{--      d = document;--}}
{{--      s = d.createElement("script");--}}
{{--      s.src = "https://client.crisp.chat/l.js";--}}
{{--      s.async = 1;--}}
{{--      d.getElementsByTagName("head")[0].appendChild(s);--}}
{{--    })();--}}
{{--  </script>--}}

  @Yield('Page_CSS')
  <style>
    .islam_pattern {
      .data-image-src: "img/islamic/bg4.png";
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

    @media screen and (min-width: 600px) {
      .hidden_mobile {
        visibility: hidden;
        display: none;
      }
    }

    #zarinpal {
      margin: auto
    }

    #zarinpal img {
      width: 65px;
    }

    .risp-client .cc-kv6t {
      z-index: 100;
       !important;
    }
  </style>
</head>

{{--<div class="off-banner" style="background-image: url(v4_assets/images/offbanner/offbanner-1.jpg);">--}}
{{-- <div class="info">--}}
{{-- <div class="off-code">--}}
{{-- <button type="button" class="btn-copy" onclick="copyFunction()"><i class="mdi mdi-content-copy"></i>کپی کد تخفیف</button>--}}
{{-- <div class="code coupon-code-copy">fetr50</div>--}}
{{-- </div>--}}
{{-- <div class="countdown-content countdown for-banner" data-time="may 15, 2021 00:00:00">--}}
{{-- <div class="countdown-inner">--}}
{{-- <div class="box">--}}
{{-- <h2 id="seconds">00</h2>--}}
{{-- </div>--}}
{{-- <span class="dot"> : </span>--}}
{{-- <div class="box">--}}
{{-- <h2 id="minutes">00</h2>--}}
{{-- </div>--}}
{{-- <span class="dot"> : </span>--}}
{{-- <div class="box">--}}
{{-- <h2 id="hours">00</h2>--}}
{{-- </div>--}}
{{-- <span class="dot"> : </span>--}}
{{-- <div class="box">--}}
{{-- <h2 id="days">000</h2>--}}
{{-- </div>--}}
{{-- </div>--}}
{{-- <div class="countdown-alert">--}}
{{-- <h1 class="alert-title">تمام شد!</h1>--}}
{{-- </div>--}}
{{-- </div>--}}
{{-- </div>--}}
{{--</div>--}}


<body>



  {{--<!-- Alert -->--}}
  {{--<div class="my-header-alert alert alert-warning alert-dismissible fade show" role="alert">--}}
  {{-- <div class="container">--}}
  {{-- <a href="https://csis.ir" target="_blank">--}}
  {{-- <img src="v4_assets/images/logo-markaz-w.png" alt="" />--}}
  {{-- <strong></strong>--}}
  {{-- </a>--}}
  {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i--}}
  {{-- class="mdi mdi-close"></i></button>--}}
  {{-- </div>--}}
  {{--</div>--}}


  @include("master_header")

  @Yield('Content')


  @include("master_footer")




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


{{--  <style>--}}
{{--    .crisp-client .cc-kv6t[data-full-view="true"] .cc-1xry .cc-unoo {--}}
{{--      bottom: 60px !important;--}}
{{--      z-index: 100;--}}
{{--       !important;--}}
{{--    }--}}
{{--  </style>--}}
  <!-- Scripts -->
  <script src="v4_assets/js/jquery-3.5.1.min.js?4"></script>
  <script src="v4_assets/js/bootstrap.bundle.min.js?4"></script>
  <script src="v4_assets/js/scripts.js"></script>
  <script src="v4_assets/plugin/swiperjs/swiper-bundle.min.js"></script>
  <script src="v4_assets/plugin/swiperjs/swiper-initial.js"></script>



  <!-- Notify js -->
  <script src="assets_admin/js/jquery.easing.1.3.js?4"></script>
  <script src="assets_admin/js/jquery.toast.js?4"></script>

  <script src="assets/js/kasboom.js?7"></script>

  @Yield('Page_JS')

</body>

</html>
<script>
  import SettingsPage from "../../public_html/web-src/src/pages/Settings/Settings";
  export default {
    components: {
      SettingsPage
    }
  }
</script>

{{--<script src="v4_assets/js/countdown.js?4"></script>--}}
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0C9YTMX14W"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'G-0C9YTMX14W');
</script>
