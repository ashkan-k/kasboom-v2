@extends('blog.blog-ebook-master')

@section('Page_Title')
آموزشگاه کسب بوم - توانمندسازی مهارتی معلولین
@endsection

@section('Page_CSS')

@endsection


@section('Content')


<!-- Spplier Details -->
<div class="supplier-details-section">
  <div class="container">
    <div class="grid-layout">
      <div class="supplier-side">
        <div class="side-inner">
          <div class="store-information">
            <div class="logo">
              <img src="v4_assets/images/consulant-img/user-img-1.png" alt="user name" />
            </div>
            <div class="info">
              <h2>پنوچ گستران کهن</h2>
              <p>حوزه پشتیبانی : <span>متسوجات سنتی و الیاف طبیعی</span></p>
              <p>تعداد تامین شدگان : <span>32</span></p>
            </div>
            <div class="buttons-group">
              <a href="#request-advice-link" class="btn btn-default icon-right"><i class="mdi mdi-check"></i>ثبت نام</a>
            </div>
          </div>
          <div class="services">
            <div class="title">
              <h2>خدمات</h2>
            </div>
            <ul class="services-list">
              <li class="active">
                <span class="name">آموزش</span>
              </li>
              <li class="active">
                <span class="name">تامین مواد اولیه</span>
              </li>
              <li class="active">
                <span class="name">خرید تضمینی محصولات</span>
              </li>
              <li>
                <span class="name">بازاریابی</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="supplier-main">
        <div class="main-inner">
          <div class="store-cover">
            <div class="img-inner">
              <img src="v4_assets/images/bg/index-1.jpg" alt="store-cover">
            </div>
          </div>
          <div class="description">
            <div class="supplier-title">
              <h2>شرایط پشتیبانی</h2>
            </div>
            <p>
              آموزش کامل حرفه نمدگری در محصولات پاپوش های سنتی کیف، کلاه و کفی.
            </p>
            <p>
              تامین مواد اولیه، خرید تضمینی محصولات تولیدی و صادرات به کشورهای حوزه اسکاندیناوی
            </p>
          </div>
          <div class="supplier-forms">
            <div class="supplier-title">
              <h2>فرم ثبت درخواست</h2>
            </div>
            <div class="forms-inner">
              <div class="row">
                <div class="col-lg-6 col-md-6">
                  <div class="inputgroup grey">
                    <input type="text" class="myinput" placeholder="عنوان پروژه مورد نظر شما" autocomplete="on">
                    <label>عنوان پروژه مورد نظر شما</label>
                    <div class="icon"><i class="mdi mdi-pencil-outline"></i></div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="inputgroup grey">
                    <input type="email" class="myinput" placeholder="ایمیل" autocomplete="on">
                    <label>ایمیل</label>
                    <div class="icon"><i class="mdi mdi-email-outline"></i></div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <select class="form-select grey">
                    <option selected disabled>استان</option>
                    <option value="1">قزوین</option>
                    <option value="2">اهواز</option>
                    <option value="3">ارومیه</option>
                  </select>
                </div>
                <div class="col-lg-6 col-md-6">
                  <select class="form-select grey">
                    <option selected disabled>استان</option>
                    <option value="1">قزوین</option>
                    <option value="2">اهواز</option>
                    <option value="3">ارومیه</option>
                  </select>
                </div>
                <div class="col-lg-12">
                  <div class="textarea-group grey">
                    <textarea class="textarea" cols="30" rows="4" placeholder="شرح مختصری از پروژه" required></textarea>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="send-request">
                    <button type="button" class="btn btn-primary">ارسال درخواست</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="supplier-users">
          <div class="supplier-title">
            <h2>حمایت شدگان</h2>
          </div>
          <div class="users-list">
            <div class="card-user-supplier">
              <div class="card-inner">
                <div class="user-image">
                  <img src="v4_assets/images/consulant-img/user-img-1.png" alt="user-name">
                </div>
                <div class="info">
                  <h2 class="name">نام کاربر</h2>
                  <p class="desc">میران ضمانت</p>
                </div>
              </div>
            </div>
            <div class="card-user-supplier">
              <div class="card-inner">
                <div class="user-image">
                  <img src="v4_assets/images/consulant-img/user-img-2.png" alt="user-name">
                </div>
                <div class="info">
                  <h2 class="name">نام کاربر</h2>
                  <p class="desc">میران ضمانت</p>
                </div>
              </div>
            </div>
            <div class="card-user-supplier">
              <div class="card-inner">
                <div class="user-image">
                  <img src="v4_assets/images/consulant-img/user-img-3.png" alt="user-name">
                </div>
                <div class="info">
                  <h2 class="name">نام کاربر</h2>
                  <p class="desc">میران ضمانت</p>
                </div>
              </div>
            </div>
            <div class="card-user-supplier">
              <div class="card-inner">
                <div class="user-image">
                  <img src="v4_assets/images/consulant-img/user-img-4.png" alt="user-name">
                </div>
                <div class="info">
                  <h2 class="name">نام کاربر</h2>
                  <p class="desc">میران ضمانت</p>
                </div>
              </div>
            </div>
            <div class="card-user-supplier">
              <div class="card-inner">
                <div class="user-image">
                  <img src="v4_assets/images/consulant-img/user-img-5.png" alt="user-name">
                </div>
                <div class="info">
                  <h2 class="name">نام کاربر</h2>
                  <p class="desc">میران ضمانت</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection


@section('Page_JS')


@endsection
