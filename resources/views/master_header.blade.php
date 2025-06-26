{{--header--}}
<header class="mynavbar type-2">
  <div class="container-lg">
    <div class="navbar-inner">
      <div class="nav-links">
        <button type="button" class="btn-services-menu">
          <i class="mdi mdi-dots-grid"></i>
          <span>سایر خدمات</span>
        </button>
        <ul>
          <li><a href="web/invite-teacher"><i class="mdi mdi-help-circle-outline"></i>تدریس در کسبوم</a></li>
        </ul>
      </div>
      <div class="nav-logo">
        <a href="#"><span></span></a>
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
              <a href="register" class="btn-nav ">
                <span class="icon"><i class="mdi mdi-account-outline"></i></span>
                <span class="text">حساب من</span>
              </a>
            @else
              @if( Auth::user()->is_logout==0)
                <a href="web" class="btn-nav active">
                  <span class="icon"><i class="mdi mdi-account-outline"></i></span>
                  <span class="text">حساب من</span>
                </a>
                <ul class="user-menu">
                  <li>
                    <a href="web"><i class="mdi mdi-account-circle-outline"></i>پنل کاربری</a>
                  </li>
                  <li>
                    <a href="web/message"><i class="mdi mdi-email-outline"></i>صندوق پیام</a>
                  </li>
                  <li>
                    <a href="web/setting"><i class="mdi mdi-cog-outline"></i>تنظیمات کاربری</a>
                  </li>
                  <li>
                    <a href="logout" data-bs-toggle="modal" data-bs-target="#modal-exit">
                      <i class="mdi mdi-exit-to-app"></i>خروج
                    </a>
                  </li>
                </ul>
              @else
                <a href="register" class="btn-nav ">
                  <span class="icon"><i class="mdi mdi-account-outline"></i></span>
                  <span class="text">حساب من</span>
                </a>
              @endif

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
            <h6>خدمات کسبوم</h6>
          </div>
          <div class="sidebar-close">
            <button class="btn-close-menu anim-2s"><i class="mdi mdi-close"></i></button>
          </div>
        </div>
        <div class="services-list">
            <div class="service-item">
            <a href="landuse">
              <div class="icon">
                <img src="assets-v2/images/icons/kasbom-services/iran.svg" alt="image">
              </div>
              <div class="text">آمایش سرزمینی</div>
            </a>
          </div>

          <div class="service-item">
            <a href="wikiidea">
              <div class="icon">
                <img src="assets-v2/images/icons/kasbom-services/idea.svg" alt="image">
              </div>
              <div class="text">ایده های کسب و کار</div>
            </a>
          </div>

           <div class="service-item">
            <a href="roadmap">
              <div class="icon">
                <img src="assets-v2/images/icons/kasbom-services/direction.png" alt="image">
              </div>
              <div class="text">نقشه راه مشاغل</div>
            </a>
          </div>

          <div class="service-item">
            <a href="skill/courses">
              <div class="icon">
                <img src="assets-v2/images/icons/kasbom-services/online-learning.svg" alt="image">
              </div>
              <div class="text">آموزشگاه مشاغل</div>
            </a>
          </div>
          <!--<div class="service-item">-->
          <!--  <a href="consult">-->
          <!--    <div class="icon">-->
          <!--      <img src="assets-v2/images/icons/kasbom-services/chat.png" alt="image">-->
          <!--    </div>-->
          <!--    <div class="text">مشاوره کسب و کار</div>-->
          <!--  </a>-->
          <!--</div>-->
          <!--<div class="service-item">-->
          <!--  <a href="shop">-->
          <!--    <div class="icon">-->
          <!--      <img src="assets-v2/images/icons/kasbom-services/store.png" alt="image">-->
          <!--    </div>-->
          <!--    <div class="text">فروشگاه محصولات</div>-->
          <!--  </a>-->
          <!--</div>-->


          <div class="service-item">
            <a href="blogs">
              <div class="icon">
                <img src="assets-v2/images/icons/kasbom-services/news.svg" alt="image">
              </div>
              <div class="text">مجله کسب و کار</div>
            </a>
          </div>

          <div class="service-item">
            <a href="{{ url('suppliers') }}">
              <div class="icon">
                <img src="assets-v2/images/icons/kasbom-services/supplier.svg" alt="image">
              </div>
              <div class="text">شرکت های پشتیبان</div>
            </a>
          </div>

        </div>
        <div class="sidebar-text mt-4">
          <h6>لینک های مفید</h6>
        </div>
        <ul class="sidebar-list">
          <li class="item"><a href="check-certificate"><i class="mdi mdi-certificate"></i>استعلام گواهینامه</a>
          <li class="item"><a href="faq"><i class="mdi mdi-help-circle"></i>سوالات متداول</a>
          <li class="item"><a href="web/invite-teacher"><i class="mdi mdi-school"></i>تدریس در کسبوم</a>
          <li class="item"><a href="skill/course_suggestion"><i class="mdi mdi-star"></i>پیشنهاد دوره</a>
          <li class="item"><a href="contactus"><i class="mdi mdi-phone"></i>تماس با ما</a>
          <li class="item"><a href="help"><i class="mdi mdi-help-circle"></i>راهنمای سایت</a>
        </ul>
      </div>
      <div class="overlay-sidebar"></div>
    </div>
  </div>
</header>

<!-- Desktop Search -->
<div id="desktop-search-content" class="">
  <div class="search-inner">
    <button type="button" class="btn-arrow-back">
      <i class="mdi mdi-close"></i>
    </button>
    <form action="search" method="get" class="search-input">
      <input name="search_title" type="text" class="desktop-search-input" placeholder="جستجو در کسبوم">
      <button type="button" class="btn-clear"><i class="mdi mdi-close"></i></button>
      <button type="submit" class="btn-search"><i class="mdi mdi-magnify"></i>جستجو</button>
    </form>
    {{-- <div class="list-result">--}}
    {{-- <ul class="tags">--}}
    {{-- <li><a href="#">گوشی موبایل</a></li>--}}
    {{-- <li><a href="#">سامسونگ M62</a></li>--}}
    {{-- <li><a href="#">تلویزیون ال‌جی</a></li>--}}
    {{-- <li><a href="#">پیراهن مردانه</a></li>--}}
    {{-- <li><a href="#">نگهدارنده گوشی</a></li>--}}
    {{-- </ul>--}}
    {{-- <ul class="result">--}}
    {{-- <li><a href="#"><i class="mdi mdi-shape-outline"></i><span>دسته بندی موبایل</span>A52</a></li>--}}
    {{-- <li><a href="#"><i class="mdi mdi-shape-outline"></i><span>قاب و نگهدارنده مویابل</span>A52</a></li>--}}
    {{-- <li><a href="#"><i class="mdi mdi-clock-outline"></i>تی شرت مردانه</a></li>--}}
    {{-- <li><a href="#"><i class="mdi mdi-clock-outline"></i>کوشی موبایل</a></li>--}}
    {{-- <li><a href="#"><i class="mdi mdi-clock-outline"></i>تی شرت مردانه</a></li>--}}
    {{-- <li><a href="#"><i class="mdi mdi-shape-outline"></i><span>دسته بندی موبایل</span>A52</a></li>--}}
    {{-- <li><a href="#"><i class="mdi mdi-shape-outline"></i><span>قاب و نگهدارنده مویابل</span>A52</a></li>--}}
    {{-- <li><a href="#"><i class="mdi mdi-clock-outline"></i>تی شرت مردانه</a></li>--}}
    {{-- <li><a href="#"><i class="mdi mdi-clock-outline"></i>کوشی موبایل</a></li>--}}
    {{-- <li><a href="#"><i class="mdi mdi-clock-outline"></i>تی شرت مردانه</a></li>--}}
    {{-- </ul>--}}
    {{-- </div>--}}
  </div>
</div>

<!-- Modal Exit -->
<div class="modal fade" id="modal-exit" tabindex="-1" aria-labelledby="modal-exit-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-exit-title">خروج</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="title">از حساب کاربری خود خارج می شوید؟</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-btn-default-outline icon-right" data-bs-dismiss="modal"><i class="mdi mdi-close"></i>انصراف</button>
        <a href="logout">
          <button type="button" class="btn btn-danger icon-right"><i class="mdi mdi-check"></i>خروج</button>
        </a>
      </div>
    </div>
  </div>
</div>
