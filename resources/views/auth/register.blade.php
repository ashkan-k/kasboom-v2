<!DOCTYPE html>
<html lang="fa" class="no-js" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#07c499" />
  <meta name="msapplication-navbutton-color" content="#07c499">
  <meta name="apple-mobile-web-app-status-bar-style" content="#07c499">
  <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
  <base href="{{asset('/')}}" />

  <title>کسبوم ‍| حساب کاربری</title>
  <link rel="stylesheet" href="/assets-v2/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="/assets-v2/scss/main.css">
  <link rel="stylesheet" href="/assets-v2/plugin/swiperjs/swiper-bundle.min.css">

  <!-- Font Icons -->
  <link href="/assets-v2/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css">

  <!-- Favicon -->
  <link rel="icon" href="/assets-v2/images/small-icon.png">
  <link rel="apple-touch-icon" href="/assets-v2/images/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/assets-v2/images/logo-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/assets-v2/images/logo-114x114.png">

</head>

<body>

  <!-- Loading -->
  <div class="wrapper-loading">
    <div class="inner">
      <div class="load-image">
        <img src="/assets-v2/images/loading.svg" alt="">
      </div>
    </div>
  </div>

  <!-- Login Content -->
  <div class="wrapper-login">
    <div class="login-content">
      <div class="grid-layout">
        <div class="text">
          <h2>ثبت نام</h2>
          <div class="link">
            {{-- <button type="button" class="btn-link" data-bs-toggle="modal" data-bs-target="#modal-help">--}}
            {{-- <i class="mdi mdi-help-circle-outline"></i>راهنمای ثبت نام--}}
            {{-- </button>--}}

            <a href="#" class="btn-link">
              بازگشت
              <i class="mdi mdi-arrow-left"></i>
            </a>
          </div>
        </div>
        <div class="grid-inner">
          <div class="form-login-section">

            <!-- Phonenumber -->
            <div id="card1" class="sign-login active cardAuthentication">
              <div class="back-btn">
                <h2>شماره همراه را وارد کنید</h2>
              </div>
              <div style="margin: 2rem 0;">
                <div class="form-item">
                  <div class="input-group phone-number">
                    <input id="phonenumber" name="phonenumber" type="number" class="form-control" placeholder="91xxxxxxxx">
                    <span class="group-text">98+</span>
                  </div>
                  <span class="input-msg">بدون صفر وارد کنید. مثال 9918892281</span>
                </div>
                <div class="login-button">
                  <button id="registerCheckPhonenumber" type="button" class="btn btn-default icon-right">
                    <i class="mdi mdi-check"></i>ثبت
                  </button>
                </div>
              </div>
            </div>
            <!-- Select 4 -->
            <div id="card2" class="cards-sign-group cardAuthentication">
              <div class="back-btn">
                <h2>یکی از موارد زیر را نتخاب کنید</h2>
                <button type="button" class="btn-back-to-phonenumber">
                  بازگشت<i class="mdi mdi-arrow-left"></i>
                </button>
              </div>
              <div class="group-inner">
                <div class="card-sign-choose">
                  <div class="card-inner">
                    <h6>آزاد (عمومی)</h6>
                    <div class="link">ثبت نام<i class="mdi mdi-arrow-left"></i></div>
                  </div>
                </div>
                <div class="card-sign-choose">
                  <div class="card-inner">
                    <h6>کارمندان حوزوی</h6>
                    <div class="link">ثبت نام<i class="mdi mdi-arrow-left"></i></div>
                  </div>
                </div>
                <div class="card-sign-choose">
                  <div class="card-inner">
                    <h6>طلبه ایرانی</h6>
                    <div class="link">ثبت نام<i class="mdi mdi-arrow-left"></i></div>
                  </div>
                </div>
                <div class="card-sign-choose">
                  <div class="card-inner">
                    <h6>طلبه غیرایرانی</h6>
                    <div class="link">ثبت نام<i class="mdi mdi-arrow-left"></i></div>
                  </div>
                </div>
              </div>
              <div class="link-back">
                <a href="{{url('/')}}">بازگشت به صفحه نخست<i class="mdi mdi-arrow-left"></i></a>
              </div>
            </div>
            <!-- Form 4 -->
            <div id="card3" class="forms-group cardAuthentication">
              {{-- type 1 --}}
              <div class="form-row-inner">
                <div class="back-btn">
                  <h2>آزاد (عمومی)</h2>
                  <button type="button" class="btn-back-to-choose">
                    بازگشت<i class="mdi mdi-arrow-left"></i>
                  </button>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type1Name" type="text" class="myinput" placeholder="نام" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type1LastName" type="text" class="myinput" placeholder="نام خانوادگی" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <select id="type1State" class="form-select">
                      <option selected disabled>استان</option>
                      @foreach($states as $state)
                      <option value="{{$state->id}}">{{$state->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-lg-12">
                    <h6 class="form-title">انتخاب تارخ تولد</h6>
                    <div class="date-content">
                      <div class="select">
                        <select id="type1Day" class="form-select">
                          <option selected disabled>روز</option>
                          @for($i = 1; $i <= 31; $i++) @if($i <=9) <option value="0{{$i}}">0{{$i}}</option>
                            @else
                            <option value="{{$i}}">{{$i}}</option>
                            @endif
                            @endfor
                        </select>
                      </div>
                      <div class="select">
                        <select id="type1Month" class="form-select">
                          <option selected disabled>ماه</option>
                          <option value="01">فروردین</option>
                          <option value="02">اردیبهشت</option>
                          <option value="03">خرداد</option>
                          <option value="04">تیر</option>
                          <option value="05">مرداد</option>
                          <option value="06">شهریور</option>
                          <option value="07">مهر</option>
                          <option value="08">آبان</option>
                          <option value="09">آذر</option>
                          <option value="10">دی</option>
                          <option value="11">بهمن</option>
                          <option value="12">اسفند</option>
                        </select>
                      </div>
                      <div class="select">
                        <select id="type1Year" class="form-select">
                          <option selected disabled>سال</option>
                          @for($i = 0; $i <= 60 ;$i++) <option value="{{1330 + $i}}">{{1330 + $i}}</option>
                            @endfor
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="login-button">
                      <button type="button" class="btn btn-default icon-right" id="type1Btn">
                        <i class="mdi mdi-check"></i>ثبت نام
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              {{-- type 2 --}}
              <div class="form-row-inner">
                <div class="back-btn">
                  <h2>کارمندان حوزوی</h2>
                  <button type="button" class="btn-back-to-choose">
                    بازگشت<i class="mdi mdi-arrow-left"></i>
                  </button>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="radio-group">
                      <h6>نسبت :</h6>
                      <div class="radio-inner">
                        <div class="form-check">
                          <input value="sarparast" class="form-check-input" type="radio" name="type2CorpRelation" checked>
                          <label class="form-check-label" for="radio-group-1">سرپرست</label>
                        </div>
                        <div class="form-check">
                          <input value="takafol" class="form-check-input" type="radio" name="type2CorpRelation">
                          <label class="form-check-label" for="radio-group-2">تکفل</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type2Name" type="text" class="myinput" placeholder="نام" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type2LastName" type="text" class="myinput" placeholder="نام خانوادگی" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type2personalCode" type="text" class="myinput" placeholder="کد پرسنلی" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type2Nationalid" type="text" class="myinput" placeholder="کد ملی" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type2Fathername" type="text" class="myinput" placeholder="نام پدر" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <select id="type2State" class="form-select">
                      <option selected disabled>استان</option>
                      @foreach($states as $state)
                      <option value="{{$state->id}}">{{$state->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-lg-12">
                    <h6 class="form-title">انتخاب تارخ تولد</h6>
                    <div class="date-content">
                      <div class="select">
                        <select id="type2Day" class="form-select">
                          <option selected disabled>روز</option>
                          @for($i = 1; $i <= 31; $i++) @if($i <=9) <option value="0{{$i}}">0{{$i}}</option>
                            @else
                            <option value="{{$i}}">{{$i}}</option>
                            @endif
                            @endfor
                        </select>
                      </div>
                      <div class="select">
                        <select id="type2Month" class="form-select">
                          <option selected disabled>ماه</option>
                          <option value="01">فروردین</option>
                          <option value="02">اردیبهشت</option>
                          <option value="03">خرداد</option>
                          <option value="04">تیر</option>
                          <option value="05">مرداد</option>
                          <option value="06">شهریور</option>
                          <option value="07">مهر</option>
                          <option value="08">آبان</option>
                          <option value="09">آذر</option>
                          <option value="10">دی</option>
                          <option value="11">بهمن</option>
                          <option value="12">اسفند</option>
                        </select>
                      </div>
                      <div class="select">
                        <select id="type2Year" class="form-select">
                          <option selected disabled>سال</option>
                          @for($i = 0; $i <= 60 ;$i++) <option value="{{1330 + $i}}">{{1330 + $i}}</option>
                            @endfor
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="login-button">
                      <button type="button" class="btn btn-default icon-right" id="type2Btn">
                        <i class="mdi mdi-check"></i>ثبت نام
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              {{-- type 3 --}}
              <div class="form-row-inner">
                <div class="back-btn">
                  <h2>طلبه ایرانی</h2>
                  <button type="button" class="btn-back-to-choose">
                    بازگشت<i class="mdi mdi-arrow-left"></i>
                  </button>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="radio-group">
                      <h6>نسبت :</h6>
                      <div class="radio-inner">
                        <div class="form-check">
                          <input value="sarparast" class="form-check-input" type="radio" name="type3CorpRelation" checked>
                          <label class="form-check-label" for="radio-group-3">سرپرست</label>
                        </div>
                        <div class="form-check">
                          <input value="takafol" class="form-check-input" type="radio" name="type3CorpRelation">
                          <label class="form-check-label" for="radio-group-4">تکفل</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type3Name" type="text" class="myinput" placeholder="نام" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type3LastName" type="text" class="myinput" placeholder="نام خانوادگی" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type3Nationalid" type="text" class="myinput" placeholder="کد ملی" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type3MarkazId" type="text" class="myinput" placeholder="کد مرکز خدمات (سرپرست)" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <select id="type3State" class="form-select">
                      <option selected disabled>استان</option>
                      @foreach($states as $state)
                      <option value="{{$state->id}}">{{$state->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-lg-12">
                    <h6 class="form-title">انتخاب تارخ تولد</h6>
                    <div class="date-content">
                      <div class="select">
                        <select id="type3Day" class="form-select">
                          <option selected disabled>روز</option>
                          @for($i = 1; $i <= 31; $i++) @if($i <=9) <option value="0{{$i}}">0{{$i}}</option>
                            @else
                            <option value="{{$i}}">{{$i}}</option>
                            @endif
                            @endfor
                        </select>
                      </div>
                      <div class="select">
                        <select id="type3Month" class="form-select">
                          <option selected disabled>ماه</option>
                          <option value="01">فروردین</option>
                          <option value="02">اردیبهشت</option>
                          <option value="03">خرداد</option>
                          <option value="04">تیر</option>
                          <option value="05">مرداد</option>
                          <option value="06">شهریور</option>
                          <option value="07">مهر</option>
                          <option value="08">آبان</option>
                          <option value="09">آذر</option>
                          <option value="10">دی</option>
                          <option value="11">بهمن</option>
                          <option value="12">اسفند</option>
                        </select>
                      </div>
                      <div class="select">
                        <select id="type3Year" class="form-select">
                          <option selected disabled>سال</option>
                          @for($i = 0; $i <= 60 ;$i++) <option value="{{1330 + $i}}">{{1330 + $i}}</option>
                            @endfor
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="login-button">
                      <button type="button" class="btn btn-default icon-right" id="type3Btn">
                        <i class="mdi mdi-check"></i>ثبت نام
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              {{-- type 4 --}}
              <div class="form-row-inner">
                <div class="back-btn">
                  <h2>طلبه غیرایرانی</h2>
                  <button type="button" class="btn-back-to-choose">
                    بازگشت<i class="mdi mdi-arrow-left"></i>
                  </button>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="radio-group">
                      <h6>نسبت :</h6>
                      <div class="radio-inner">
                        <div class="form-check">
                          <input value="sarparast" class="form-check-input" type="radio" name="type4CorpRelation" checked>
                          <label class="form-check-label" for="radio-group-5">سرپرست</label>
                        </div>
                        <div class="form-check">
                          <input value="takafol" class="form-check-input" type="radio" name="type4CorpRelation">
                          <label class="form-check-label" for="radio-group-6">تکفل</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type4Name" type="text" class="myinput" placeholder="نام" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type4LastName" type="text" class="myinput" placeholder="نام خانوادگی" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type4Fathername" type="text" class="myinput" placeholder="نام پدر" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="inputgroup">
                      <input id="type4MarkazId" type="text" class="myinput" placeholder="کد مرکز خدمات (سرپرست)" autocomplete="on">
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <h6 class="form-title">انتخاب تارخ تولد</h6>
                    <div class="date-content">
                      <div class="select">
                        <select id="type4Day" class="form-select">
                          <option selected disabled>روز</option>
                          @for($i = 1; $i <= 31; $i++) @if($i <=9) <option value="0{{$i}}">0{{$i}}</option>
                            @else
                            <option value="{{$i}}">{{$i}}</option>
                            @endif
                            @endfor
                        </select>
                      </div>
                      <div class="select">
                        <select id="type4Month" class="form-select">
                          <option selected disabled>ماه</option>
                          <option value="01">فروردین</option>
                          <option value="02">اردیبهشت</option>
                          <option value="03">خرداد</option>
                          <option value="04">تیر</option>
                          <option value="05">مرداد</option>
                          <option value="06">شهریور</option>
                          <option value="07">مهر</option>
                          <option value="08">آبان</option>
                          <option value="09">آذر</option>
                          <option value="10">دی</option>
                          <option value="11">بهمن</option>
                          <option value="12">اسفند</option>
                        </select>
                      </div>
                      <div class="select">
                        <select id="type4Year" class="form-select">
                          <option selected disabled>سال</option>
                          @for($i = 0; $i <= 60 ;$i++) <option value="{{1330 + $i}}">{{1330 + $i}}</option>
                            @endfor
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="login-button">
                      <button type="button" class="btn btn-default icon-right" id="type4Btn">
                        <i class="mdi mdi-check"></i>ثبت نام
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Vertificate Code -->
            <div id="card4" class="vertificate-code cardAuthentication">
              <div class="back-btn">
                <h2>تایید شماره موبایل - کد تایید پیامک شده را وارد کنید</h2>
              </div>
              <div>
                <div class="timer-content">
                  <div id="card4Timer">
                    <div class="time-msg">ارسال مجدد کد تا :</div>
                    <div class="time-countdown">02:00</div>
                  </div>

                  <div id="card4SendNewCode" style="display:none">
                    <div class="time-msg">جهت ارسال مجدد کد دکمه زیر را کلیک کنید :</div>
                    <button style="margin-top: 20px" type="button" class="btn btn-default icon-right sendCodeVerify">
                      <i class="mdi mdi-cellphone-message"></i>ارسال کد نو
                    </button>
                  </div>
                </div>
                <div class="form-item">
                  <div class="inputgroup nopadding">
                    <input id="card4VerifyCode" type="text" class="myinput text-center" placeholder="- - - - -" />
                  </div>
                </div>
                <div class="login-button">
                  <button type="button" class="btn btn-default icon-right" id="card4Btn">
                    <i class="mdi mdi-check"></i>ثبت کد
                  </button>
                </div>
              </div>
            </div>
            <!-- Login -->
            <div id="card5" class="login-page cardAuthentication">
              <div class="back-btn">
                <h2>ورود به حساب کاربری</h2>
              </div>
              <div class="phone-number-form">
                شماره همراه :<br>
                <span id="card5ShowPhonenumber"></span>
              </div>
              <div style="margin: 2rem 0;">
                <div class="form-item">
                  <div class="inputgroup nopadding">
                    <input id="card5Password" type="password" class="myinput text-center" placeholder="رمز عبور" autocomplete="off" />
                  </div>
                </div>
                <div class="links-sign">
                  <div class="resend">
                    <button type="button" class="btn-send-code sendCodePassword">
                      <i class="fi fi-rr-refresh"></i>ورود با رمز یکبار مصرف
                    </button>
                  </div>
                  <div class="change-number">
                    <button type="button" class="btn-change-number" id="goCard1">
                      <i class="fi fi-rr-pencil"></i>تغییر شماره همراه
                    </button>
                  </div>
                </div>
                <div class="login-button">
                  <button type="button" class="btn btn-default icon-right" id="card5Btn">
                    <i class="mdi mdi-check"></i>ورود
                  </button>
                </div>
              </div>
            </div>
            <!-- Disposable Password -->
            <div id="card6" class="vertificate-code cardAuthentication">
              <div class="back-btn">
                <h2>ورود با رمز یکبار مصرف</h2>
              </div>
              <div style="margin: 2rem 0;">
                <div class="timer-content">
                  <div id="card6Timer">
                    <div class="time-msg">ارسال مجدد رمز تا :</div>
                    <div class="time-countdown">02:00</div>
                  </div>

                  <div id="card6SendNewCode" style="display:none">
                    <div class="time-msg">جهت ارسال مجدد رمز دکمه زیر را کلیک کنید :</div>
                    <button style="margin-top: 20px" type="button" class="btn btn-default icon-right sendCodePassword">
                      <i class="mdi mdi-cellphone-message"></i>ارسال رمز نو
                    </button>
                  </div>
                </div>
                <div class="form-item">
                  <div class="inputgroup nopadding">
                    <input id="card6VerifyCode" type="text" class="myinput text-center" placeholder="- - - - -" autocomplete="off" />
                  </div>
                </div>
                <div class="login-button">
                  <button type="button" class="btn btn-default icon-right" id="card6Btn">
                    <i class="mdi mdi-check"></i>ورود
                  </button>
                </div>
              </div>
            </div>

          </div>
          <!-- Side Carousel -->
          <div class="bigImages">
            <div class="swiper swiper-login" dir="rtl">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="item">
                    <div class="img-container" style="background-image: url('/assets-v2/images/bg/login-1.jpg')">
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="item">
                    <div class="img-container" style="background-image: url('/assets-v2/images/bg/login-2.jpg')">
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="item">
                    <div class="img-container" style="background-image: url('/assets-v2/images/bg/login-3.jpg')">
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="item">
                    <div class="img-container" style="background-image: url('/assets-v2/images/bg/login-4.jpg')">
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="item">
                    <div class="img-container" style="background-image: url('/assets-v2/images/bg/login-5.jpg')">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- ToastMessage --}}
    <div id="toastmessage-content"></div>
  </div>

  <div class="modal fade" id="modal-help" tabindex="-1" aria-labelledby="modal-title-help" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-title-help">راهنمای ثبت نام</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="faq-item bg-grey">
            <div class="item-header">
              <a class="link collapsed" data-bs-toggle="collapse" href="#faq-collapsed-01" role="button" aria-expanded="false" aria-controls="faq-collapsed-01">
                چگونه میتوانم در کسبوم ثبت نام کنم؟
                <div class="icon"><i class="mdi mdi-chevron-down"></i></div>
              </a>
            </div>
            <div class="collapse" id="faq-collapsed-01">
              <div class="card-faq">
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک
                است
                چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد
              </div>
            </div>
          </div>
          <div class="faq-item bg-grey">
            <div class="item-header">
              <a class="link collapsed" data-bs-toggle="collapse" href="#faq-collapsed-02" role="button" aria-expanded="false" aria-controls="faq-collapsed-02">
                چگونه میتوانم در کسبوم ثبت نام کنم؟
                <div class="icon"><i class="mdi mdi-chevron-down"></i></div>
              </a>
            </div>
            <div class="collapse" id="faq-collapsed-02">
              <div class="card-faq">
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک
                است
                چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد
              </div>
            </div>
          </div>
          <div class="faq-item bg-grey">
            <div class="item-header">
              <a class="link collapsed" data-bs-toggle="collapse" href="#faq-collapsed-03" role="button" aria-expanded="false" aria-controls="faq-collapsed-03">
                چگونه میتوانم در کسبوم ثبت نام کنم؟
                <div class="icon"><i class="mdi mdi-chevron-down"></i></div>
              </a>
            </div>
            <div class="collapse" id="faq-collapsed-03">
              <div class="card-faq">
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک
                است
                چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="/assets-v2/js/jquery-3.5.1.min.js"></script>
  <script src="/assets-v2/js/bootstrap.bundle.min.js"></script>
  <script src="/assets-v2/plugin/swiperjs/swiper-bundle.min.js"></script>
  <script src="/assets-v2/plugin/swiperjs/swiper-initial.js"></script>
  <script src="/assets-v2/js/scripts.js"></script>

  <script>
    var durationTime = 119;
    var timesdisplay = document.querySelectorAll('.time-countdown');
    var myInterval;

    function startTimer(durationTime, tdisplay, typeCard) {
      var timer = durationTime,
        minutes, seconds;
      clearIntervalCountdown(myInterval, tdisplay, timer)
      myInterval = setInterval(function() {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        tdisplay.textContent = minutes + ":" + seconds;
        if (--timer < 0) {
          timer = 0;
          tdisplay.style.display = 'none';

          if (typeCard === 'card4') {
            $('#card4Timer').css('display', 'none');
            $('#card4SendNewCode').css('display', 'block');
          } else if (typeCard === 'card6') {
            $('#card6Timer').css('display', 'none');
            $('#card6SendNewCode').css('display', 'block');
          }

          clearIntervalCountdown(myInterval, tdisplay)
        }
      }, 1000);
    }

    function clearIntervalCountdown(myInterval, tdisplay) {
      clearInterval(myInterval);
      tdisplay.style.display = 'block';
    }


    //card 1 => check phonenumber
    $('#registerCheckPhonenumber').click(function() {
      checkPhonenumber()
    });
    $('#phonenumber').on('keypress', function(e) {
      if (e.which == 13) {
        checkPhonenumber()
      }
    });

    function checkPhonenumber() {
      //  activate loading
      $('.wrapper-loading').addClass('active');
      var form = new FormData();
      form.append("phonenumber", $('#phonenumber').val());
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('register-check-phonenumber') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function(data) {
          $('.cardAuthentication').removeClass('active');

          if (data.status === 'card5') {
            $('#card5').addClass('active');
          }
          if (data.status === 'card4') {
            $('#card4').addClass('active');
            startTimer(durationTime, timesdisplay[0], 'card4');
          }
          if (data.status === 'card2') {
            $('#card2').addClass('active');
          }

          toastMessage('', data.message, 'success')
        },
        error: function(data) {
          const json = jQuery.parseJSON(data.responseText)
          toastMessage('خطای اعتبار سنجی', json.message, 'danger')
        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    }


    //card 3 => type-1
    $('#type1Btn').click(function() {
      //  activate loading
      $('.wrapper-loading').addClass('active');

      var form = new FormData();
      form.append("type", 'type1');
      form.append("phonenumber", $('#phonenumber').val());
      form.append("name", $('#type1Name').val());
      form.append("lastName", $('#type1LastName').val());
      form.append("state", $('#type1State :selected').val());
      form.append("day", $('#type1Day :selected').val());
      form.append("month", $('#type1Month :selected').val());
      form.append("year", $('#type1Year :selected').val());
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('register-store') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function(data) {
          $('.cardAuthentication').removeClass('active');
          $('#card4').addClass('active');
          toastMessage('', data.message, 'success');
          startTimer(durationTime, timesdisplay[0], 'card4');
        },
        error: function(data) {
          try {
            const json = jQuery.parseJSON(data.responseText)
            toastMessage('خطای اعتبار سنجی', json.message, 'danger');
          }
          catch(err) {
            toastMessage('خطای اعتبار سنجی','سرور مرکزی مشغول می باشد. لطفا بعدا اقدام فرمائید', 'danger');
          }
        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    });

    //card 3 => type-2
    $('#type2Btn').click(function() {
      //  activate loading
      $('.wrapper-loading').addClass('active');

      var form = new FormData();
      form.append("type", 'type2');
      form.append("phonenumber", $('#phonenumber').val());
      form.append("name", $('#type2Name').val());
      form.append("lastName", $('#type2LastName').val());
      form.append("personal_code", $('#type2personalCode').val());
      form.append("nationalid", $('#type2Nationalid').val());
      form.append("fathername", $('#type2Fathername').val());
      form.append("corp_relation", $('input[name=type2CorpRelation]:checked').val());
      form.append("state", $('#type2State :selected').val());
      form.append("day", $('#type2Day :selected').val());
      form.append("month", $('#type2Month :selected').val());
      form.append("year", $('#type2Year :selected').val());
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('register-store') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function(data) {
          $('.cardAuthentication').removeClass('active');
          $('#card4').addClass('active');
          toastMessage('', data.message, 'success');
          startTimer(durationTime, timesdisplay[0], 'card4');
        },
        error: function(data) {
          try {
            const json = jQuery.parseJSON(data.responseText)
            toastMessage('خطای اعتبار سنجی', json.message, 'danger');
          }
          catch(err) {
            toastMessage('خطای اعتبار سنجی','سرور مرکزی مشغول می باشد. لطفا بعدا اقدام فرمائید', 'danger');
          }

        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    });

    //card 3 => type-3
    $('#type3Btn').click(function() {
      //  activate loading
      $('.wrapper-loading').addClass('active');

      var form = new FormData();
      form.append("type", 'type3');
      form.append("phonenumber", $('#phonenumber').val());
      form.append("name", $('#type3Name').val());
      form.append("lastName", $('#type3LastName').val());
      form.append("id_markaz", $('#type3MarkazId').val());
      form.append("nationalid", $('#type3Nationalid').val());
      form.append("corp_relation", $('input[name=type3CorpRelation]:checked').val());
      form.append("state", $('#type3State :selected').val());
      form.append("day", $('#type3Day :selected').val());
      form.append("month", $('#type3Month :selected').val());
      form.append("year", $('#type3Year :selected').val());
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('register-store') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function(data) {
          $('.cardAuthentication').removeClass('active');
          $('#card4').addClass('active');
          toastMessage('', data.message, 'success');
          startTimer(durationTime, timesdisplay[0], 'card4');
        },
        error: function(data) {
          try {
            const json = jQuery.parseJSON(data.responseText)
            toastMessage('خطای اعتبار سنجی', json.message, 'danger');
          }
          catch(err) {
            toastMessage('خطای اعتبار سنجی','سرور مرکزی مشغول می باشد. لطفا بعدا اقدام فرمائید', 'danger');
          }

        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    });

    //card 3 => type-4
    $('#type4Btn').click(function() {
      //  activate loading
      $('.wrapper-loading').addClass('active');

      var form = new FormData();
      form.append("type", 'type4');
      form.append("phonenumber", $('#phonenumber').val());
      form.append("name", $('#type4Name').val());
      form.append("lastName", $('#type4LastName').val());
      form.append("id_markaz", $('#type4MarkazId').val());
      form.append("fathername", $('#type4Fathername').val());
      form.append("corp_relation", $('input[name=type4CorpRelation]:checked').val());
      form.append("state", $('#type4State :selected').val());
      form.append("day", $('#type4Day :selected').val());
      form.append("month", $('#type4Month :selected').val());
      form.append("year", $('#type4Year :selected').val());
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('register-store') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function(data) {
          $('.cardAuthentication').removeClass('active');
          $('#card4').addClass('active');
          toastMessage('', data.message, 'success');
          startTimer(durationTime, timesdisplay[0], 'card4');
        },
        error: function(data) {
          try {
            const json = jQuery.parseJSON(data.responseText)
            toastMessage('خطای اعتبار سنجی', json.message, 'danger');
          }
          catch(err) {
            toastMessage('خطای اعتبار سنجی','سرور مرکزی مشغول می باشد. لطفا بعدا اقدام فرمائید', 'danger');
          }

        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    });


    //card 4
    $('#card4Btn').click(function() {
      verifyWeb()
    });
    $('#card4VerifyCode').on('keypress', function(e) {
      if (e.which == 13) {
        verifyWeb()
      }
    });

    function verifyWeb() {
      //  activate loading
      $('.wrapper-loading').addClass('active');

      var form = new FormData();
      form.append("phonenumber", $('#phonenumber').val());
      form.append("verifyCode", $('#card4VerifyCode').val());
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('verify-phonenumber') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function(data) {
          toastMessage('', data.message, 'success');
          // verifyApi()
        },
        error: function(data) {
          const json = jQuery.parseJSON(data.responseText)
          toastMessage('خطای اعتبار سنجی', json.message, 'danger');

          if (json.status && json.status === 'card5') {
            $('.cardAuthentication').removeClass('active');
            $('#card5').addClass('active');
          }
        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    }

    function verifyApi() {
      //  activate loading
      $('.wrapper-loading').addClass('active');

      var form = new FormData();
      form.append("phonenumber", $('#phonenumber').val());
      form.append("verifyCode", $('#card4VerifyCode').val());
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('backend/public/api/auth/verify-phonenumber') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function(data) {
          localStorage.setItem('token', data.token);
          window.open("{{$urlPush}}", '_self')
        },
        error: function(data) {
          const json = jQuery.parseJSON(data.responseText)
          toastMessage('خطای اعتبار سنجی', json.message, 'danger');

          if (json.status && json.status === 'card5') {
            $('.cardAuthentication').removeClass('active');
            $('#card5').addClass('active');
          }
        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    }


    //card 5 => login api - web
    $('#card5Btn').click(function() {
      loginApi()
    })
    $('#card5Password').on('keypress', function(e) {
      if (e.which == 13) {
        loginApi()
      }
    });

    function loginApi() {
      //  activate loading
      $('.wrapper-loading').addClass('active');

      var form = new FormData();
      form.append("username", $('#phonenumber').val());
      form.append("password", $('#card5Password').val());
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('auth/login-test') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function(data) {
          loginWeb(data.token)
        },
        error: function(data) {
          const json = jQuery.parseJSON(data.responseText)
          toastMessage('خطای اعتبار سنجی', json.message, 'danger');

          if (json.status && json.status === 'card4') {
            startTimer(durationTime, timesdisplay[0], 'card4');
            $('.cardAuthentication').removeClass('active');
            $('#card4').addClass('active');
          }
        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    }

    function loginWeb(tokenApi) {
      var form = new FormData();
      form.append("username", $('#phonenumber').val());
      form.append("password", $('#card5Password').val());
      form.append("remote", '');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('/signin') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function() {
          localStorage.setItem('token', tokenApi)
          window.open("web", '_self')
        //   window.open("{{$urlPush}}", '_self')
        },
        error: function(data) {
          const json = jQuery.parseJSON(data.responseText)
          toastMessage('', 'ورود به سیستم انجام نشد', 'danger');
        }
      });
    }


    //send Code password - verify
    $('.sendCodePassword').click(function() {
      sendCode('password')
    })
    $('.sendCodeVerify').click(function() {
      sendCode('verify')
    })

    function sendCode(type) {
      //  activate loading
      $('.wrapper-loading').addClass('active');

      var form = new FormData();
      form.append("phonenumber", $('#phonenumber').val());
      form.append("type", type);
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('auth/send-verify-phonenumber') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function(data) {
          toastMessage('', data.message, 'success');

          if (type === 'password') {
            startTimer(durationTime, timesdisplay[1], 'card6');
            if (!$('#card6').hasClass('active')) {
              $('.cardAuthentication').removeClass('active');
              $('#card6').addClass('active');
            }
            $('#card6Timer').css('display', 'block');
            $('#card6SendNewCode').css('display', 'none');
          } else if (type === 'verify') {
            startTimer(durationTime, timesdisplay[0], 'card4');
            if (!$('#card4').hasClass('active')) {
              $('.cardAuthentication').removeClass('active');
              $('#card4').addClass('active');
            }
            $('#card4Timer').css('display', 'block');
            $('#card4SendNewCode').css('display', 'none');
          }

        },
        error: function(data) {
          const json = jQuery.parseJSON(data.responseText)
          toastMessage('خطای اعتبار سنجی', json.message, 'danger');

          if (json.status) {
            if (json.status === 'card4') {
              startTimer(durationTime, timesdisplay[0], 'card4');
              $('.cardAuthentication').removeClass('active');
              $('#card4').addClass('active');
            } else if (json.status === 'card1') {
              $('.cardAuthentication').removeClass('active');
              $('#card1').addClass('active');
            }
          }
        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    }


    //card6Btn
    $('#card6Btn').click(function() {
      disposableWeb()
    })
    $('#card6VerifyCode').on('keypress', function(e) {
      if (e.which == 13) {
        disposableWeb()
      }
    });

    function disposableWeb() {
      //  activate loading
      $('.wrapper-loading').addClass('active');

      var form = new FormData();
      form.append("phonenumber", $('#phonenumber').val());
      form.append("verifyCode", $('#card6VerifyCode').val());
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('auth/check-disposable-password') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function() {
            window.open("{{$urlPush}}", '_self')
          // disposableApi();
        },
        error: function(data) {
          const json = jQuery.parseJSON(data.responseText)
          toastMessage('خطای اعتبار سنجی', json.message, 'danger');

          if (json.status) {
            if (json.status === 'card4') {
              startTimer(durationTime, timesdisplay[0], 'card4');
              $('.cardAuthentication').removeClass('active');
              $('#card4').addClass('active');
            } else if (json.status === 'card1') {
              $('.cardAuthentication').removeClass('active');
              $('#card1').addClass('active');
            }
          }
        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    }

    function disposableApi() {
      //  activate loading
      $('.wrapper-loading').addClass('active');

      var form = new FormData();
      form.append("phonenumber", $('#phonenumber').val());
      form.append("verifyCode", $('#card6VerifyCode').val());
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('backend/public/api/auth/check-disposable-password') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function(data) {
          localStorage.setItem('token', data.token);
          window.open("{{$urlPush}}", '_self')
        },
        error: function(data) {
          const json = jQuery.parseJSON(data.responseText)
          toastMessage('خطای اعتبار سنجی', json.message, 'danger');

          if (json.status) {
            if (json.status === 'card4') {
              startTimer(durationTime, timesdisplay[0], 'card4');
              $('.cardAuthentication').removeClass('active');
              $('#card4').addClass('active');
            } else if (json.status === 'card1') {
              $('.cardAuthentication').removeClass('active');
              $('#card1').addClass('active');
            }
          }
        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    }


    $('#phonenumber').change(function() {
      const phone = $('#phonenumber').val()
      $('#card5ShowPhonenumber').text(phone)
    })
    $('#goCard1').click(function() {
      $('.cardAuthentication').removeClass('active');
      $('#card1').addClass('active');
    })
    $(document).ready(function() {
      //check isset phonenumber
      const phonenumber = "{{ request()->phonenumber }}"
      if (phonenumber) {
        $('#phonenumber').val(phonenumber)
        $('#card5ShowPhonenumber').text(phonenumber)
        $('#registerCheckPhonenumber').click()
      }
      $('.cardAuthentication').removeClass('active')
      $('#card1').addClass('active')
    })
  </script>

</body>

</html>
