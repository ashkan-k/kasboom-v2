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
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/brand/favicon.ico" />

    <!-- Bootstrap css -->
    <link href="assets/plugins/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Sidemenu Css -->
    <link href="assets/plugins/sidemenu/sidemenu-rtl.css" rel="stylesheet" />

    <!-- Dashboard Css -->
    <link href="assets/css/style-rtl.css" rel="stylesheet" />
    <link href="assets/css/admin-custom.css" rel="stylesheet" />

    <!-- c3.js Charts Plugin -->
    <link href="assets/plugins/charts-c3/c3-chart.css" rel="stylesheet" />

    <!-- Custom scroll bar css-->
    <link href="assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

    <!-- Data table css -->
    <link href="assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/jquery.dataTables.min.css" rel="stylesheet" />


    <!---Font icons-->
    <link href="assets/css/icons.css" rel="stylesheet"/>

    <!-- Switcher css -->
    <link  href="assets/switcher/css/switcher-rtl.css" rel="stylesheet" id="switcher-css" type="text/css" media="all"/>

    <!-- Color Skin css -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/color-skins/color6.css" />

    <!-- WYSIWYG Editor css -->
    <link href="assets/plugins/wysiwyag/richtext.css" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="assets/images/brand/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/brand/favicon.ico" />
    <link href="assets_admin/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />

    @Yield('Page_CSS_Before')


    <!-- Notify -->
    <link rel="stylesheet" href="assets_admin/css/jquery.toast.css" />

    <script src="assets/js/sweetalert2@9"></script>


    <link href="css/fonts.css" rel="stylesheet" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />

    @Yield('Page_CSS_After')

</head>


<body class="app sidebar-mini">
<!--Loader-->
<div id="global-loader">
    <img src="assets/images/loader.svg" class="loader-img" alt="">
</div>
<!--Loader-->

<!--Page-->
<div class="page">
    <div class="page-main h-100">

        <!--App-Header-->
        <div class="app-header1 header py-1 d-flex">
            <div class="container-fluid">
                <div class="d-flex">
                    <a class="header-brand" href="#">
                        <img src="assets/images/brand/logo.png" class="header-brand-img" alt="کسب بوم">
                    </a>
                    <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
                    <div class="header-navicon">
                        <a href="#" data-toggle="search" class="nav-link d-lg-none navsearch-icon">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>
                    <div class="header-navsearch">
                        <a href="#" class=" "></a>
                        <form class="form-inline mr-auto">
                            <div class="nav-search">
                                <input type="search" class="form-control header-search" placeholder="جستجو ..." aria-label="جستجو" >
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex order-lg-2 mr-auto">
                        <div class="dropdown d-none d-md-flex" >
                            <a  class="nav-link icon full-screen-link">
                                <i class="fe fe-maximize-2"  id="fullscreen-button"></i>
                            </a>
                        </div>
                        <div class="dropdown d-none d-md-flex country-selector">
                            <a href="#" class="d-flex nav-link leading-none" data-toggle="dropdown">
                                <img src="assets/images/flags/ir.svg" alt="کسب بوم" class="avatar avatar-xs ml-1 align-self-center">
                                <div>
                                    <strong class="text-dark">فارسی</strong>
                                </div>
                            </a>
                            {{--<div class="language-width dropdown-menu dropdown-menu-left dropdown-menu-arrow">--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<img src="assets/images/flags/french_flag.jpg"  alt="flag-img" class="avatar  ml-3 align-self-center" >--}}
                                    {{--<div>--}}
                                        {{--<strong>French</strong>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<img src="assets/images/flags/germany_flag.jpg"  alt="flag-img" class="avatar  ml-3 align-self-center" >--}}
                                    {{--<div>--}}
                                        {{--<strong>Germany</strong>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<img src="assets/images/flags/italy_flag.jpg"  alt="flag-img" class="avatar  ml-3 align-self-center" >--}}
                                    {{--<div>--}}
                                        {{--<strong>Italy</strong>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<img src="assets/images/flags/russia_flag.jpg"  alt="flag-img" class="avatar  ml-3 align-self-center" >--}}
                                    {{--<div>--}}
                                        {{--<strong>Russia</strong>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<img src="assets/images/flags/spain_flag.jpg"  alt="flag-img" class="avatar  ml-3 align-self-center" >--}}
                                    {{--<div>--}}
                                        {{--<strong>Spain</strong>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        </div>
                        {{--<div class="dropdown d-none d-md-flex">--}}
                            {{--<a class="nav-link icon" data-toggle="dropdown">--}}
                                {{--<i class="fa fa-bell-o"></i>--}}
                                {{--<span class=" nav-unread badge badge-danger  badge-pill">4</span>--}}
                            {{--</a>--}}
                            {{--<div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow">--}}
                                {{--<a href="#" class="dropdown-item text-center">اطلاع رسانی : 4 مورد</a>--}}
                                {{--<div class="dropdown-divider"></div>--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<div class="notifyimg">--}}
                                        {{--<i class="fa fa-envelope-o"></i>--}}
                                    {{--</div>--}}
                                    {{--<div>--}}
                                        {{--<strong>2 پیام جدید</strong>--}}
                                        {{--<div class="small text-muted"> ساعت 17:50</div>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<div class="notifyimg">--}}
                                        {{--<i class="fa fa-comment-o"></i>--}}
                                    {{--</div>--}}
                                    {{--<div>--}}
                                        {{--<strong> 3 نظر جدید</strong>--}}
                                        {{--<div class="small text-muted">05:34 ق.ظ</div>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<div class="notifyimg">--}}
                                        {{--<i class="fa fa-exclamation-triangle"></i>--}}
                                    {{--</div>--}}
                                    {{--<div>--}}
                                        {{--<strong> تکمیل پروفایل</strong>--}}
                                        {{--<div class="small text-muted">13:45 Pm</div>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                                {{--<div class="dropdown-divider"></div>--}}
                                {{--<a href="#" class="dropdown-item text-center">نمایش همه</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="dropdown d-none d-md-flex">--}}
                            {{--<a class="nav-link icon" data-toggle="dropdown">--}}
                                {{--<i class="fa fa-envelope-o"></i>--}}
                                {{--<span class=" nav-unread badge badge-warning  badge-pill">3</span>--}}
                            {{--</a>--}}
                            {{--<div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow">--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<img src="" alt="avatar-img" class="avatar brround ml-3 align-self-center">--}}
                                    {{--<div>--}}
                                        {{--<strong>Blake</strong> I've finished it! See you so.......--}}
                                        {{--<div class="small text-muted">30 mins ago</div>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<img src="" alt="avatar-img" class="avatar brround ml-3 align-self-center">--}}
                                    {{--<div>--}}
                                        {{--<strong>Caroline</strong> Just see the my Admin....--}}
                                        {{--<div class="small text-muted">12 mins ago</div>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<img src="" alt="avatar-img" class="avatar brround ml-3 align-self-center">--}}
                                    {{--<div>--}}
                                        {{--<strong>Jonathan</strong> Hi! I'am singer......--}}
                                        {{--<div class="small text-muted">1 hour ago</div>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                                {{--<a href="#" class="dropdown-item d-flex pb-3">--}}
                                    {{--<img src="" alt="avatar-img" class="avatar brround ml-3 align-self-center">--}}
                                    {{--<div>--}}
                                        {{--<strong>Emily</strong> Just a reminder you have.....--}}
                                        {{--<div class="small text-muted">45 mins ago</div>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                                {{--<div class="dropdown-divider"></div>--}}
                                {{--<a href="#" class="dropdown-item text-center">View all Messages</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="dropdown d-none d-md-flex">
                            <a class="nav-link icon" data-toggle="dropdown">
                                <i class="fe fe-grid"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow  app-selector">
                                <ul class="drop-icon-wrap">
                                    <li>
                                        <a href="common/course" class="drop-icon-item">
                                            <i class="icon icon-map text-dark"></i>
                                            <span class="block">دوره آموزشی</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{Auth::user()->getLevelUrl()}}/payments" class="drop-icon-item">
                                            <i class="icon icon-credit-card text-dark"></i>
                                            <span class="block">تراکنش مالی</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="common/info" class="drop-icon-item">
                                            <i class="icon icon-info text-dark"></i>
                                            <span class="block">اطلاعات پروفایل</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="common/message" class="drop-icon-item">
                                            <i class="icon icon-speech text-dark"></i>
                                            <span class="block">پیام</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="common/comments" class="drop-icon-item">
                                            <i class="icon icon-bubbles text-dark"></i>
                                            <span class="block">نظرات</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="common/settings" class="drop-icon-item">
                                            <i class="icon icon-settings text-dark"></i>
                                            <span class="block">تنظیمات</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="dropdown ">
                            <a href="#" class="nav-link pl-0 leading-none user-img" data-toggle="dropdown">
                                <img src="_upload_/_users_/{{Auth::user()->code}}/personal/small_{{Auth::user()->image}}" alt="{{Auth::user()->name}}" class="avatar avatar-md brround">
                            </a>
                            <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow ">
                                <a class="dropdown-item" href="user/profile/{{Auth::user()->id}}/{{str_replace(" ","_",Auth::user()->name)}}">
                                    <i class="dropdown-icon icon icon-user"></i>پروفایل من
                                </a>
                                <a class="dropdown-item" href="common/message">
                                    <i class="dropdown-icon icon icon-speech"></i> صندوق پیام
                                </a>
                                <a class="dropdown-item" href="{{Auth::user()->getLevelUrl()}}/payments">
                                    <i class="dropdown-icon  icon icon-credit-card"></i> تراکنش های مالی
                                </a>
                                <a class="dropdown-item" href="common/settings">
                                    <i class="dropdown-icon  icon icon-settings"></i>  اطلاعات کاربری
                                </a>
                                <a class="dropdown-item" href="logout">
                                    <i class="dropdown-icon icon icon-power"></i> خروج از سامانه
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/App-Header-->

        <!-- Sidebar menu-->
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar doc-sidebar">
            <div class="app-sidebar__user clearfix">
                <div class="dropdown user-pro-body">
                    <div>
                        <img src="_upload_/_users_/{{Auth::user()->code}}/personal/small_{{Auth::user()->image}}" alt="{{Auth::user()->name}}" class="avatar avatar-lg brround">
                        <a href="user/setting" class="profile-img">
                            <span class="fa fa-pencil" aria-hidden="true"></span>
                        </a>
                    </div>
                    <div class="user-info">
                        <h2>{{Auth::user()->name}}</h2>
                    </div>
                </div>
            </div>
            <ul class="side-menu">
                <li class="slide">
                    <a class="side-menu__item" href="#"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">صفحه سایت</span></a>
                </li>  <li class="slide">
                    <a class="side-menu__item" href="{{Auth::user()->getLevelUrl()}}/dashboard"><i class="side-menu__icon fe fe-airplay"></i><span class="side-menu__label">پنل کاربری</span></a>
                </li>
                @if (Auth::user()->can('view-markaz'))
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href=""><i class="side-menu__icon fe fe-folder"></i><span class="side-menu__label">مرکز خدمات حوزه علمیه</span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li>
                            <a href="markaz/vam" class="slide-item">درخواست تسهیلات</a>
                        </li>
                        <li>
                            <a href="markaz/vam_followup" class="slide-item">پیگیری تسهیلات</a>
                        </li>
                        <li>
                            <a href="markaz/database" class="slide-item">بانک اطلاعاتی</a>
                        </li>
                    </ul>
                </li>
                @endif
                @if (Auth::user()->can('view-teacher'))
                    <li class="slide">
                        <a class="side-menu__item" href="teacher/course"><i class="side-menu__icon fe fe-calendar"></i><span class="side-menu__label">دوره های آموزشی</span></a>
                    </li>
                @else
                    <li class="slide">
                        <a class="side-menu__item" href="common/course"><i class="side-menu__icon fe fe-calendar"></i><span class="side-menu__label">دوره های آموزشی</span></a>
                    </li>
                @endif
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href=""><i class="side-menu__icon fe fe-dollar-sign"></i><span class="side-menu__label">مالی</span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li>
                            <a href="{{Auth::user()->getLevelUrl()}}/payments" class="slide-item">لیست تراکنش های مالی</a>
                        </li>
                        <li>
                            <a href="common/wallet" class="slide-item">موجودی حساب</a>
                        </li>
                        <li>
                            <a href="common/get_money" class="slide-item">درخواست وجه</a>
                        </li>
                        <li>
                            <a href="common/income_money" class="slide-item">واریز وجه</a>
                        </li>
                    </ul>
                </li>

                <li class="slide">
                    <a class="side-menu__item"  href="common/comments"><i class="side-menu__icon fa fa-comment-o"></i><span class="side-menu__label">نظرات</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item"  href="common/message"><i class="side-menu__icon fa fa-envelope-o"></i><span class="side-menu__label">صندوق پیام</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item"  href="common/whishlist"><i class="side-menu__icon fe fe-message-circle"></i><span class="side-menu__label">علاقه مندی ها</span></a>
                </li>
                {{--<li class="slide">--}}
                    {{--<a class="side-menu__item" data-toggle="slide" href="teacher/notification"><i class="side-menu__icon fa fa-bell-o"></i><span class="side-menu__label">اطلاع رسانی</span></a>--}}
                {{--</li>--}}
                <li class="slide">
                    <a class="side-menu__item" href="common/info"><i class="side-menu__icon fe fe-info"></i><span class="side-menu__label">اطلاعات پروفایل</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="common/settings"><i class="side-menu__icon fe fe-settings"></i><span class="side-menu__label">تنظیمات کاربری</span></a>
                </li>

                <li class="slide">
                        <a href="logout" class="btn btn-primary btn-block mt-3 text-white"><i class="fa fa-sign-out"></i>  خروج</a>
                </li>
            </ul>
        </aside>
        <!-- /Sidebar menu-->

        <!--App-Content-->
        <div class="app-content  my-3 my-md-5">
            <div class="side-app">

                <!--Page-Header-->
                <div class="page-header">
                    {{--<h4 class="page-title" style="font-family: VazirRegular"></h4>--}}
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{Auth::user()->getLevelUrl()}}/dashboard">پنل کاربری</a></li>
                        @Yield('titleBar')
                    </ol>
                </div>
                <!--/Page-Header-->
                @Yield('Content')


            </div>
        </div>

        <div class="modal" id="comment_modal"  role="dialog"  aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">مشاهده نظر</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label mt-2">ارسال کننده:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex">
                                            <input type="text" class="form-control" readonly disabled="" id="comment_fullname"  >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label mt-2">تاریخ ارسال:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex">
                                            <input type="text" class="form-control" readonly disabled="" id="comment_date"  >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label mt-2"> امتیاز ارسال:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex">
                                            <input type="text" class="form-control" readonly disabled="" id="comment_score"  >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label mt-2">متن نظر:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex">
                                            <textarea type="text" class="form-control" readonly disabled="" id="comment_message" rows="5" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer" >
                        <button type="button" class="btn btn-default"  data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>

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

        <div class="modal" id="message_modal"  role="dialog"  aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">مشاهده پیام</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label mt-2">ارسال کننده:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex">
                                            <input type="text" class="form-control" readonly disabled="" id="mess_owner"  >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label mt-2">تاریخ ارسال:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex">
                                            <input type="text" class="form-control" readonly disabled="" id="mess_date"  >                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label mt-2">عنوان:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex">
                                            <input type="text" class="form-control" readonly disabled="" id="mess_subject"  >                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label mt-2">متن پیام:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex">
                                            <textarea type="text" class="form-control" readonly disabled="" style="font-family: VazirThin" id="mess_message" rows="3" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label mt-2">متن پاسخ:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex">
                                            <textarea type="text" class="form-control" id="reply_mess_message" style="font-family: VazirThin" rows="3" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input id="mess_id_user" type="hidden" readonly>
                            <input id="message_id" type="hidden" readonly>
                            <input id="message_target_type" type="hidden" readonly>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn_add_reply_message" class="btn btn-success">ارسال پاسخ</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--Footer-->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-lg-12 col-sm-12 mt-3 mt-lg-0 text-center">
                    <a href="#" class="fs-14 text-primary">طراحی و توسعه توسط </a> شرکت <a href="#" class="fs-14 text-primary"> ایده نگاران همگام </a>  . حق کپی محفوظ است © 1399
                </div>
            </div>
        </div>
    </footer>
    <!--/Footer-->
</div>

<!-- Back to top -->
<a href="#top" id="back-to-top" ><i class="fa fa-long-arrow-up"></i></a>

<!-- JQuery js-->
<script src="assets/js/jquery-3.2.1.min.js"></script>

<!-- Bootstrap js -->
<script src="assets/plugins/bootstrap-4.3.1/js/popper.min.js"></script>
<script src="assets/plugins/bootstrap-4.3.1/js/bootstrap.min.js"></script>

<!--JQuery Sparkline Js-->
<script src="assets/js/jquery.sparkline.min.js"></script>

<!-- Circle Progress Js-->
<script src="assets/js/circle-progress.min.js"></script>

<!-- Star Rating Js-->
<script src="assets/plugins/rating/jquery.rating-stars.js"></script>

<!-- Fullside-menu Js-->
<script src="assets/plugins/sidemenu/sidemenu.js"></script>

<!-- Custom scroll bar Js-->
<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!--Counters -->
<script src="assets/plugins/counters/counterup.min.js"></script>
<script src="assets/plugins/counters/waypoints.min.js"></script>

<!-- CHARTJS CHART -->
<script src="assets/plugins/chart/Chart.bundle.js"></script>
<script src="assets/plugins/chart/utils.js"></script>

<!-- Index Scripts -->
{{--<script src="assets/plugins/echarts/echarts.js"></script>--}}
{{--<script src="assets/js/index4.js"></script>--}}


<!-- WYSIWYG Editor js -->
<script src="assets/plugins/wysiwyag/jquery.richtext.js"></script>

<!-- Custom Js-->
<script src="assets/js/admin-custom.js"></script>

<!-- Data tables -->
<script src="assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>

<script src="assets/plugins/ckeditor/ckeditor.js"></script>
<script src="assets/plugins/ckeditor/config.js"></script>
<script src="assets_admin/js/jquery.toast.js"></script>
<script src="assets_admin/plugins/fileuploads/js/dropify.js"></script>

<script src="assets/js/_admin/admin_user.js"></script>
<script src="assets/js/kasboom.js"></script>

@Yield('Page_JS')

</body>
</html>

