<!DOCTYPE html>
<html lang="fa">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  <!-- Meta data -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <base href="{{asset('/')}}" />
  <title>
    صفحه مورد نظر یافت نشد
  </title>

  <meta charset="UTF-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="description">
  <meta content="کسب بوم - آموزش، هدایت، فروش و پشتیبانی کسب و کارهای بومی" name="author">
  <meta name="keywords" content="کسب بوم، کسب وکارهای بومی، تولید داخلی ، مشاغل خانگی ، پشتیبانی، حمایت ، آموزش مشاغل خانگی، توسعه کسب و کار، آموزش کسب و کار، آموزش و پشتیبانی کسب و کار ، تولید ، کاشت ، پرورش ، تدوین طرح توجیهی ، فروش محصولات بومی ، فروش محصولات خانگی ، غرفه محصولات ، ویکی ایده ، ایده های کسب و کار ، نیازمندی های کسب و کار ، استخدام یار" />



  <!-- Favicon -->
  <link rel="icon" href="assets/images/brand/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" type="image/x-icon" href="assets/images/brand/favicon.ico" />

  <!-- Style css -->
  <link href="assets/css/style-rtl.css" rel="stylesheet" />
  <link href="assets/css/skin-modes.css" rel="stylesheet" />

  <!-- Color Skin css -->
  <link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/color-skins/color5.css" />

  <link href="css/fonts.css" rel="stylesheet" type="text/css" />


</head>


<body class="construction-image">


  <!-- Page -->
  <div class="page page-h margin-bottom">
    <div class="page-content z-index-10">
      <div class="container text-center">
        <div class="display-1 text-white mb-5">404</div>
        <h1 class="h2 text-white  mb-3" style="font-family: VazirBold">صفحه یافت نشد</h1>
        <p class="h4 font-weight-normal mb-7 leading-normal text-white" style="font-family: VazirMedium">متاسفانه! صفحه مورد نظر شما یافت نشد</p>
        <a class="btn btn-primary" href="#" style="font-family: VazirMedium">
          برگشت به صفحه نخست
        </a>
      </div>
    </div>
  </div>
  <!-- End Page -->

  <!-- Mobile Navbar -->
  @include ("master_mobile_navbar")

  <!-- Back to top -->
  <a href="#top" id="back-to-top"><i class="fa fa-long-arrow-up"></i></a>

</body>

</html>
