<!DOCTYPE html>

<html lang="fa" class="no-js" dir="rtl">

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
  <link rel="icon" href="assets/images/brand/fav.ico" type="image/x-icon" />
  @Yield('Page_CSS_Before')

  <link href="assets_consult/Css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets_consult/Css/bootstrap-rtl.min.css" rel="stylesheet" />
  <link href="assets_consult/Css/Style.css" rel="stylesheet" />

  <link href="css/fonts.css" rel="stylesheet" type="text/css" />
  <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />

  <!-- Style css -->
  <link href="assets/css/style-rtl.css" rel="stylesheet" />
  <link href="assets/css/skin-modes.css" rel="stylesheet" />

  <style>
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

  @Yield('Page_CSS_After')

</head>


<body>

  <!--Topbar-->
  <div class="header-main d-none d-lg-block" style="background-color: rgba(1, 72, 65, 0.8)">
    <div class="top-bar">
      <div class="container">
        <div class="row">
          <div class="col-xl-8 col-lg-8 col-sm-4 col-7">
            <div class="top-bar-right d-flex">
              <div class="clearfix">
                <ul class="socials">
                  <li style="margin: 5px 0 0 0;!important;">
                    <a href="#"> <img src="assets/images/brand/logo-yellow.png" width="40" class="header-brand-img" alt="کسب بوم - حمایت از کسب و کارهای بومی"></a>
                  </li>
                  <li style="padding-top: 15px;margin: 0;!important;">
                    <span class="h5 mega_menu text-white" style="font-family: VazirBold;">سامانه جامع توانمندسازی کسب و کارهای بومی</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-sm-8 col-5">
            <div class="top-bar-left">
              <ul class="custom">
                @if(!Auth::check())
                <li>
                  <a href="web" title="ورود / عضویت" class="text-white"><i class="fa fa-sign-in ml-1"></i> <span class="text-white">ورود / عضویت</span></a>
                </li>
                @else
                <li class="dropdown">
                  <span>
                    <a href="#" class="text-white" data-toggle="dropdown"><i class="fa fa-user mr-1"></i><span class="text-white">&nbsp;پنل کاربری<i class="fa fa-caret-down text-white mr-1"></i></span></a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                      <a href="{{Auth::user()->getLevelUrl()}}" class="dropdown-item">
                        <i class="dropdown-icon icon icon-user"></i> پنل کاربری
                      </a>
                      @if(Auth::user()->getLevelUrl()=="user")
                      <a class="dropdown-item" href="{{Auth::user()->getLevelUrl()}}/course">
                        <i class="dropdown-icon icon fa fa-mortar-board"></i>دوره های من
                      </a>
                      @elseif(Auth::user()->getLevelUrl()=="teacher")
                      <a class="dropdown-item" href="{{Auth::user()->getLevelUrl()}}/course   ">
                        <i class="dropdown-icon icon fa fa-mortar-board"></i>دوره های من
                      </a>
                      @endif
                      <a class="dropdown-item" href="{{Auth::user()->getLevelUrl()}}/message">
                        <i class="dropdown-icon icon icon-speech"></i> صندوق پیام
                      </a>
                      {{--<a class="dropdown-item" href="user/mynotification">--}}
                      {{--<i class="dropdown-icon icon icon-bell"></i> اطلاع رسانی--}}
                      {{--</a>--}}
                      <a href="{{Auth::user()->getLevelUrl()}}/settings" class="dropdown-item">
                        <i class="dropdown-icon  icon icon-settings"></i> تنظیمات کاربری
                      </a>
                      <a class="dropdown-item" href="logout">
                        <i class="dropdown-icon icon icon-power"></i> خروج
                      </a>
                    </div>
                  </span>
                </li>
                @endif
                <a href="#" title="صفحه نخست" class="text-white"><i class="fa fa-home ml-1"></i> <span class="text-white">صفحه نخست</span></a>
                </li>

              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/Topbar-->
  </div>

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


  <!-- Back to top -->
  {{--<a href="#top" id="back-to-top" ><i class="fa fa-long-arrow-up"></i></a>--}}

  <!-- JQuery js-->
  <script src="assets/js/jquery-3.2.1.min.js"></script>


  <script src="assets/plugins/horizontal-menu/horizontal-menu.js"></script>

  <!-- courser Js-->
  <script src="assets/js/kasboom.js"></script>

  <!-- Bootstrap js -->
  <script src="assets/plugins/bootstrap-4.3.1/js/popper.min.js"></script>
  <script src="assets/plugins/bootstrap-4.3.1/js/bootstrap.min.js"></script>


  @Yield('Page_JS')

</body>

</html>
