@extends('course.new.master_course')

@section('Page_Title')
آموزشگاه کسب بوم - توانمندسازی مهارتی معلولین
@endsection

@section('Page_CSS')

@endsection


@section('Content')

  <div class="landing-page-header">
    <div class="container-lg">
      <div class="row align-items-center text-center text-md-start">
        <div class="col-lg-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
          <div class="text">
            <h1>توانمندسازی مهارتی معلولین</h1>
            <p>آنان که با دستانی گویا سخن می گویند و با ذره ای از باقیمانده شنوایی خود، به آوای هستی گوش
              جان می سپارند، هر دو آیتی از سپاسگزاری پروردگارند.
              تلاش همه جانبه برای احیا و تقویت توانمندی های مهارتی-شغلی افراد با اختلالات شنوایی از
              مسئولیت های اجتماعی مجموعه کسبوم در مسیر ارتقاء کیفیت زندگی این افراد می باشند
              مجموعه کسبوم در تلاش است تا خدمات آموزشی و مشاوره مهارت های کسب و کار را برای این عزیزان
              عرضه نماید. حمایت از تولیدکنندگان با اختلالات شنوایی از اقدامات این مجموعه می باشد. </p>
            <a href="#" class="btn btn-default icon-left">مشاهده دوره ها<i
                class="mdi mdi-arrow-left"></i></a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="image">
            <div class="img-inner">
              <div class="video-preview">
                <div class="video-inner" data-vide-bg="v4_assets/videos/landing/ocean"
                     data-vide-options="loop: true, muted: true, position: 50% 50%, autoplay: true">
                </div>
              </div>
              <div class="video-button">
                <button type="button" class="btn-video" data-bs-toggle="modal"
                        data-bs-target="#modal-about">
                  <i class=" mdi mdi-play"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="landing-section border-radius">
    <div class="container-lg">
      <div class="default-title">
        <h2 class="title">خدمات ویژه کسبوم</h2>
      </div>
      <div class="section-inner">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card-property">
              <div class="icon">
                <i class="mdi mdi-school-outline"></i>
              </div>
              <div class="text">
                <h6>تهیه و تولید دوره های آموزشی مهارتی و کسب و کار ویژه معلولین</h6>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card-property">
              <div class="icon">
                <i class="mdi mdi-message-text-outline"></i>
              </div>
              <div class="text">
                <h6>مشاوره تخصصی و عمومی کسب و کار ویژه معلولین</h6>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card-property">
              <div class="icon">
                <i class="mdi mdi-video-outline"></i>
              </div>
              <div class="text">
                <h6>تولید آموزش ویدئویی زبان اشاره ویژه مددکاران و مربیان</h6>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card-property">
              <div class="icon">
                <i class="mdi mdi-handshake-outline"></i>
              </div>
              <div class="text">
                <h6>حمایت از تولیدکنندگان جهت تجاری سازی، بازاریابی و فروش محصولات </h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- دوره‌های آموزشی مهارتی -->
  <div class="landing-section bg-trasparent">
    <div class="container-lg">
      <div class="default-title type-2">
        <h2 class="title">دوره‌های آموزشی مهارتی </h2>
        <h5 class="desc">دوره های آموزشی آفلاین مهارتی - شغلی کسبوم ویژه معلولین</h5>
      </div>
      <div class="section-inner">
        <div class="swiper swiper-courses" dir="rtl">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="card-course" title="نام دوره">
                <a href="education-details.html">
                  <div class="img-container">
                    <div class="img-inner">
                      <img src="v4_assets/images/courses/1.jpg" alt="course-name" />
                    </div>
                    <div class="certificate">گواهینامه دارد</div>
                    <div class="percentage">30%</div>
                  </div>
                  <div class="card-b">
                    <h2>آموزش پیشرفته چرم دوزی</h2>
                    <div class="info">
                      <h6>مرضیه افشار</h6>
                      <div class="price-content off-code">
                        <div class="price">
                          <div class="real">169,000</div>
                          <div class="off">100,000</div>
                        </div>
                        <div class="text">
                          <span class="toman">تومان</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card-course" title="نام دوره">
                <a href="education-details.html">
                  <div class="img-container">
                    <div class="img-inner">
                      <img src="v4_assets/images/courses/2.jpg" alt="course-name" />
                    </div>
                    <div class="certificate">گواهینامه دارد</div>
                    <div class="percentage">30%</div>
                  </div>
                  <div class="card-b">
                    <h2>آموزش پیشرفته چرم دوزی</h2>
                    <div class="info">
                      <h6>مرضیه افشار</h6>
                      <div class="price-content off-code">
                        <div class="price">
                          <div class="real">169,000</div>
                          <div class="off">100,000</div>
                        </div>
                        <div class="text">
                          <span class="toman">تومان</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card-course" title="نام دوره">
                <a href="education-details.html">
                  <div class="img-container">
                    <div class="img-inner">
                      <img src="v4_assets/images/courses/3.jpg" alt="course-name" />
                    </div>
                    <div class="certificate">گواهینامه دارد</div>
                    <div class="percentage">30%</div>
                  </div>
                  <div class="card-b">
                    <h2>آموزش پیشرفته چرم دوزی</h2>
                    <div class="info">
                      <h6>مرضیه افشار</h6>
                      <div class="price-content off-code">
                        <div class="price">
                          <div class="real">169,000</div>
                          <div class="off">100,000</div>
                        </div>
                        <div class="text">
                          <span class="toman">تومان</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card-course" title="نام دوره">
                <a href="education-details.html">
                  <div class="img-container">
                    <div class="img-inner">
                      <img src="v4_assets/images/courses/course-04.jpg" alt="course-name" />
                    </div>
                    <div class="certificate">گواهینامه دارد</div>
                    <div class="percentage">30%</div>
                  </div>
                  <div class="card-b">
                    <h2>آموزش پیشرفته چرم دوزی</h2>
                    <div class="info">
                      <h6>مرضیه افشار</h6>
                      <div class="price-content off-code">
                        <div class="price">
                          <div class="real">169,000</div>
                          <div class="off">100,000</div>
                        </div>
                        <div class="text">
                          <span class="toman">تومان</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card-course" title="نام دوره">
                <a href="education-details.html">
                  <div class="img-container">
                    <div class="img-inner">
                      <img src="v4_assets/images/courses/course-05.jpg" alt="course-name" />
                    </div>
                    <div class="certificate">گواهینامه دارد</div>
                    <div class="percentage">30%</div>
                  </div>
                  <div class="card-b">
                    <h2>آموزش پیشرفته چرم دوزی</h2>
                    <div class="info">
                      <h6>مرضیه افشار</h6>
                      <div class="price-content off-code">
                        <div class="price">
                          <div class="real">169,000</div>
                          <div class="off">100,000</div>
                        </div>
                        <div class="text">
                          <span class="toman">تومان</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card-course" title="نام دوره">
                <a href="education-details.html">
                  <div class="img-container">
                    <div class="img-inner">
                      <img src="v4_assets/images/courses/course-06.jpg" alt="course-name" />
                    </div>
                    <div class="certificate">گواهینامه دارد</div>
                    <div class="percentage">30%</div>
                  </div>
                  <div class="card-b">
                    <h2>آموزش پیشرفته چرم دوزی</h2>
                    <div class="info">
                      <h6>مرضیه افشار</h6>
                      <div class="price-content off-code">
                        <div class="price">
                          <div class="real">169,000</div>
                          <div class="off">100,000</div>
                        </div>
                        <div class="text">
                          <span class="toman">تومان</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
        <!-- <div class="buttons-group">
            <a href="#" class="btn btn-primary icon-left">دوره‌های بیشتر<i class="mdi mdi-arrow-left"></i></a>
        </div> -->
      </div>
    </div>
  </div>

  <!-- آموزش جامع زبان اشاره -->
  <div class="landing-section bg-gray border-radius pt-6">
    <div class="strip-back-right"></div>
    <div class="container-lg">
      <div class="section-inner">
        <div class="row align-items-center text-center text-md-start ">
          <div class="col-lg-6">
            <div class="image-cover">
              <div class="img-container">
                <figure>
                  <div class="img-inner">
                    <img src="v4_assets/images/bg/nashenava.jpg" alt="دوره جامع آموزش زبان اشاره">
                  </div>
                </figure>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="text-content">
              <div class="default-title right">
                <h2 class="title">آموزش جامع زبان اشاره</h2>
              </div>
              <p>زبان از ویژگی‌های مهم بشر و عنصر وجودی انسان است و شیوه‌ای غیرغریزی برای انتقال عقاید،
                دانش، احساسات و خواسته‌ها از طریق تولید مجموعه‌ای از نمادهای اختیاری است. در این میان
                زبان اشاره راهکاری برای رفع نیازهای شفاهی و ارتباطی جامعه معلولین است، همان طور که
                زبان‌هایی همچون فارسی، چینی، انگلیسی و... راهکارهایی برای رفع نیازهای ارتباطی جامعه
                شنوایان است.</p>
              <p>مجموعه کسبوم در راستای غنی‌سازی دانش و گسترش آگاهی جامعه، اقدام به تولید دوره جامع آموزش
                زبان اشاره به صورت ویدئویی می باشد تا قدمی کوچک در کمک به احقاق حقوق معلولین داشته
                باشد</p>
              <p></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Statue -->
  <div class="landing-section bg-trasparent">
    <div class="container-lg">
      <div class="section-inner">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6 col-6">
            <div class="card-status br-radius">
              <div class="icon bg-white">
                <svg id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512"
                     width="512" xmlns="http://www.w3.org/2000/svg">
                  <g>
                    <path
                      d="m256 207c47.972 0 87-39.028 87-87s-39.028-87-87-87-87 39.028-87 87 39.028 87 87 87zm0-144c31.43 0 57 25.57 57 57s-25.57 57-57 57-57-25.57-57-57 25.57-57 57-57z" />
                    <path
                      d="m432 207c30.327 0 55-24.673 55-55s-24.673-55-55-55-55 24.673-55 55 24.673 55 55 55zm0-80c13.785 0 25 11.215 25 25s-11.215 25-25 25-25-11.215-25-25 11.215-25 25-25z" />
                    <path
                      d="m444.1 241h-23.2c-27.339 0-50.939 16.152-61.693 39.352-22.141-24.17-53.944-39.352-89.228-39.352h-27.957c-35.284 0-67.087 15.182-89.228 39.352-10.755-23.2-34.355-39.352-61.694-39.352h-23.2c-37.44 0-67.9 30.276-67.9 67.49v109.21c0 16.156 13.194 29.3 29.412 29.3h91.727c1.538 17.9 16.59 32 34.883 32h199.957c18.292 0 33.344-14.1 34.883-32h90.679c16.796 0 30.46-13.61 30.46-30.34v-108.17c-.001-37.214-30.461-67.49-67.901-67.49zm-414.1 67.49c0-20.672 17.002-37.49 37.9-37.49h23.2c20.898 0 37.9 16.818 37.9 37.49v10.271c-10.087 26.264-8 42.004-8 98.239h-91zm331 135.489c0 2.769-2.252 5.021-5.021 5.021h-199.958c-2.769 0-5.021-2.253-5.021-5.021v-81.957c0-50.19 40.832-91.022 91.021-91.022h27.957c50.19 0 91.022 40.832 91.022 91.021zm121-27.319c0 .517 5.592.34-91 .34 0-56.651 2.071-72.018-8-98.239v-10.271c0-20.672 17.002-37.49 37.9-37.49h23.2c20.898 0 37.9 16.818 37.9 37.49z" />
                    <path
                      d="m80 207c30.327 0 55-24.673 55-55s-24.673-55-55-55-55 24.673-55 55 24.673 55 55 55zm0-80c13.785 0 25 11.215 25 25s-11.215 25-25 25-25-11.215-25-25 11.215-25 25-25z" />
                  </g>
                </svg>
              </div>
              <div class="info">
                <h4>تعداد مخاطبین</h4>
                <h6>619</h6>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-6">
            <div class="card-status br-radius">
              <div class="icon bg-white">
                <svg height="511pt" viewBox="0 -3 511.99981 511" width="511pt"
                     xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="m499.902344 236.066406c-7.664063-7.070312-18.089844-11.4375-28.605469-11.984375-11.941406-.617187-23.128906 3.640625-31.460937 11.976563l-56.929688 56.332031c-1.125-1.949219-2.410156-3.789063-3.851562-5.496094-7.003907-8.316406-17.246094-12.894531-28.835938-12.894531h-79.695312c-15.027344 0-29.6875-1.949219-43.570313-5.789062-36.195313-10.011719-70.773437-2.699219-100.003906 21.160156-11.886719 9.703125-20.558594 20.257812-26.042969 27.953125l-14.289062-13.867188c-1.878907-1.824219-4.425782-2.859375-7.046876-2.859375-.023437 0-.042968 0-.066406 0-2.714844.019532-5.339844 1.148438-7.222656 3.101563l-69.464844 72.113281c-1.859375 1.929688-2.8710935 4.523438-2.81249975 7.203125.05859375 2.683594 1.17968775 5.230469 3.12109375 7.078125l117.488281 111.871094c1.949219 1.855468 4.449219 2.78125 6.945313 2.78125 2.621094 0 5.242187-1.019532 7.214844-3.042969l68.816406-70.601563c1.878906-1.929687 2.921875-4.566406 2.871094-7.261718-.050782-2.65625-1.164063-5.21875-3.070313-7.070313l-5.992187-5.8125 13.714843-1.542969c8.296875-.964843 16.734375-1.453124 25.085938-1.453124h121.253906c19.703125 0 36.4375-4.308594 49.742187-12.808594.109376-.070313.21875-.144532.328126-.21875 4.765624-3.3125 9.089843-7.238282 12.847656-11.664063l81.710937-96.128906c13.984375-16.449219 13.109375-36.976563-2.179687-51.074219zm-372.605469 244.449219-102.945313-98.023437 55.457032-57.574219 102.34375 99.316406zm359.4375-206.421875-81.710937 96.132812c-2.59375 3.050782-5.566407 5.761719-8.84375 8.058594-9.988282 6.324219-23.015626 9.535156-38.726563 9.535156h-121.257813c-9.121093 0-18.34375.535157-27.371093 1.585938l-30.148438 3.382812-63.125-61.257812c4.386719-6.503906 12.453125-17.015625 24.136719-26.554688 24.289062-19.828124 51.84375-25.667968 81.894531-17.351562 15.632813 4.324219 32.097657 6.519531 48.941407 6.519531h79.695312c14.3125 0 18.132812 12.398438 18.132812 19.722657 0 5.351562-1.71875 10.445312-4.714843 13.976562-3.25 3.824219-7.871094 5.761719-13.734375 5.761719h-69.375c-5.5625 0-10.070313 4.511719-10.070313 10.074219s4.507813 10.070312 10.070313 10.070312h69.375c11.710937 0 22.039062-4.570312 29.085937-12.867188 5.863281-6.898437 9.207031-15.96875 9.488281-25.664062l65.566407-64.878906c9.371093-9.371094 24.011719-7.019532 32.203125.535156 4.234375 3.90625 9.929687 12.113281.488281 23.21875zm0 0" />
                  <path
                    d="m68.078125 213h98.140625c5.34375 0 10.289062-1.734375 14.3125-4.664062 4.023438 2.929687 8.96875 4.664062 14.3125 4.664062h98.144531c5.34375 0 10.289063-1.734375 14.3125-4.664062 4.023438 2.929687 8.96875 4.664062 14.3125 4.664062h98.140625c13.445313 0 24.382813-10.941406 24.382813-24.386719v-45.765625c0-20.554687-11.503907-38.410156-28.722657-47.21875 8.34375-10.0625 13.367188-22.96875 13.367188-37.03125 0-32.035156-26.0625-58.097656-58.097656-58.097656s-58.097656 26.0625-58.097656 58.097656c0 14.0625 5.023437 26.972656 13.367187 37.03125-7.441406 3.8125-13.8125 9.316406-18.652344 15.992188-4.839843-6.679688-11.210937-12.183594-18.65625-15.992188 8.34375-10.058594 13.367188-22.96875 13.367188-37.03125 0-32.035156-26.0625-58.097656-58.097657-58.097656-32.035156 0-58.097656 26.0625-58.097656 58.097656 0 14.0625 5.027344 26.972656 13.371094 37.035156-7.445312 3.808594-13.816406 9.3125-18.65625 15.992188-4.839844-6.679688-11.210938-12.183594-18.65625-15.996094 8.34375-10.058594 13.367188-22.96875 13.367188-37.027344 0-32.039062-26.0625-58.101562-58.097657-58.101562-32.03125 0-58.09375 26.0625-58.09375 58.101562 0 14.058594 5.023438 26.96875 13.367188 37.03125-17.21875 8.808594-28.726563 26.667969-28.726563 47.21875v45.761719c0 13.445313 10.941406 24.386719 24.386719 24.386719zm302.609375-192.355469c20.925781 0 37.953125 17.023438 37.953125 37.953125 0 20.925782-17.027344 37.953125-37.953125 37.953125-20.929688 0-37.953125-17.023437-37.953125-37.953125-.003906-20.929687 17.023437-37.953125 37.953125-37.953125zm-26.167969 89.800781c7.871094 3.988282 16.757813 6.25 26.164063 6.25 9.410156 0 18.296875-2.261718 26.164062-6.25 15.652344 2.726563 27.148438 16.214844 27.148438 32.402344v45.765625c0 2.339844-1.902344 4.242188-4.242188 4.242188h-98.140625c-2.335937 0-4.238281-1.902344-4.238281-4.242188v-45.765625c-.003906-16.183594 11.496094-29.675781 27.144531-32.402344zm-100.601562-89.800781c20.925781 0 37.953125 17.023438 37.953125 37.953125 0 20.925782-17.027344 37.953125-37.953125 37.953125-20.929688 0-37.953125-17.023437-37.953125-37.953125 0-20.929687 17.023437-37.953125 37.953125-37.953125zm-26.164063 89.800781c7.867188 3.988282 16.753906 6.25 26.164063 6.25 9.410156 0 18.292969-2.261718 26.164062-6.25 15.648438 2.726563 27.148438 16.214844 27.148438 32.402344v45.765625c0 2.339844-1.902344 4.242188-4.242188 4.242188h-98.140625c-2.339844 0-4.242187-1.902344-4.242187-4.242188v-45.765625c0-16.183594 11.5-29.675781 27.148437-32.402344zm-100.605468-89.800781c20.925781 0 37.953124 17.023438 37.953124 37.953125 0 20.925782-17.027343 37.953125-37.953124 37.953125-20.925782 0-37.953126-17.027343-37.953126-37.953125 0-20.929687 17.027344-37.953125 37.953126-37.953125zm-53.3125 122.203125c0-16.183594 11.5-29.675781 27.148437-32.402344 7.871094 3.988282 16.753906 6.25 26.164063 6.25 9.410156 0 18.292968-2.261718 26.164062-6.25 15.652344 2.726563 27.148438 16.214844 27.148438 32.402344v45.765625c0 2.339844-1.902344 4.242188-4.242188 4.242188h-98.140625c-2.339844 0-4.242187-1.902344-4.242187-4.242188zm0 0" />
                </svg>
              </div>
              <div class="info">
                <h4>تحت حمایت</h4>
                <h6>619</h6>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-6">
            <div class="card-status br-radius">
              <div class="icon bg-white">
                <svg height="512pt" viewBox="0 0 512 512" width="512pt"
                     xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="m256 512c-141.164062 0-256-114.835938-256-256s114.835938-256 256-256 256 114.835938 256 256-114.835938 256-256 256zm0-480c-123.519531 0-224 100.480469-224 224s100.480469 224 224 224 224-100.480469 224-224-100.480469-224-224-224zm0 0" />
                  <path
                    d="m368 394.667969c-4.097656 0-8.191406-1.558594-11.308594-4.695313l-112-112c-3.007812-3.007812-4.691406-7.082031-4.691406-11.304687v-149.335938c0-8.832031 7.167969-16 16-16s16 7.167969 16 16v142.699219l107.308594 107.308594c6.25 6.25 6.25 16.382812 0 22.632812-3.117188 3.136719-7.210938 4.695313-11.308594 4.695313zm0 0" />
                </svg>
              </div>
              <div class="info">
                <h4>محتوی تولیدی (دقیقه)</h4>
                <h6>1250</h6>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-6">
            <div class="card-status br-radius">
              <div class="icon bg-white">
                <svg id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512"
                     width="512" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="m502.024 156.633c5.987-2.128 9.983-7.797 9.976-14.151-.008-6.354-4.018-12.013-10.009-14.127l-241-85.031c-3.229-1.14-6.752-1.14-9.981 0l-241 85.031c-5.992 2.113-10.002 7.773-10.01 14.127s3.989 12.023 9.976 14.151l95.469 33.94v97.847c0 16.149 16.847 29.806 50.073 40.59 28.961 9.4 64.647 14.577 100.483 14.577s71.521-5.177 100.483-14.577c33.226-10.784 50.073-24.44 50.073-40.59v-97.847l39.417-14.013v135.584c-17.529 6.198-30.125 22.927-30.125 42.552 0 19.624 12.596 36.354 30.125 42.552v57.285c0 8.284 6.716 15 15 15s15-6.716 15-15v-57.285c17.529-6.198 30.125-22.927 30.125-42.552 0-19.624-12.596-36.354-30.125-42.552v-146.25zm-41.051 213.187c-8.34 0-15.125-6.785-15.125-15.125s6.785-15.125 15.125-15.125 15.125 6.785 15.125 15.125-6.785 15.125-15.125 15.125zm-204.973-296.445 196.069 69.179-196.069 69.703-196.069-69.704zm120.556 212.784c-2.875 2.898-13.167 9.839-36.396 16.466-24.781 7.069-54.67 10.962-84.16 10.962s-59.378-3.893-84.16-10.962c-23.229-6.627-33.521-13.567-36.396-16.466v-84.921l115.531 41.072c1.625.578 3.325.867 5.024.867 1.7 0 3.399-.289 5.024-.867l115.531-41.072v84.921z" />
                </svg>
              </div>
              <div class="info">
                <h4>تعداد مهارت آموزان</h4>
                <h6>619</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- دعوت به همکاری -->
  <div class="landing-section havebg" style="background-image: url(images/bg/nashenava-2.jpg);">
    <div class="container-lg">
      <div class="default-title type-2">
        <h2 class="title">دعوت به همکاری</h2>
        <h5 class="desc">از مربیان و مددکاران اجتماعی ویژه معلولین جهت همکاری در تولید محتوی چندرسانه ای
          آموزشی و انگیزشی دعوت به عمل می آید. اگر دغدغه کمک و همیاری این عزیزان را دارید با ما در ارتباط
          باشید</h5>
      </div>
      <div class="section-inner">
        <div class="form-group">
          <form action="">
            <div class="row">
              <div class="col-lg-6 col-md-6">
                <div class="inputgroup">
                  <input type="text" class="myinput" name="fullname" placeholder="نام و نام خانوادگی"
                         required />
                </div>
              </div>
              <div class="col-lg-6 col-md-6">
                <div class="inputgroup">
                  <input type="text" class="myinput" name="phonenumber" placeholder="شماره موبایل"
                         required />
                </div>
              </div>
              <div class="col-lg-6 col-md-6">
                <div class="select-group">
                  <select class="form-select" name="state">
                    <option value="0" selected disabled>استان</option>
                    <option value="1">قزوین</option>
                    <option value="2">اهواز</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-6 col-md-6">
                <div class="select-group">
                  <select class="form-select" name="city">
                    <option value="0" selected disabled>شهر</option>
                    <option value="1">الوند</option>
                    <option value="2">زیباشهر</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-12 col-md-12">
                <div class="textarea-group">
                                    <textarea class="textarea" cols="30" rows="4" name="memo"
                                              placeholder="توضیحات خود را بنویسید..."></textarea>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="buttons-group">
                  <button type="button" class="btn btn-default icon-right"><i class="mdi mdi-send"></i>ارسال درخواست</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- حمایت از مددجویان -->
  <div class="landing-section bg-white pb-0 bottom-image">
    <div class="container-lg">
      <div class="default-title">
        <h2 class="title">در مسیر حمایت از مددجویان</h2>
      </div>
      <div class="section-inner">
        <div class="levels">
          <div class="level">
            <div class="icon"><i class="mdi mdi-school-outline"></i></div>
            <h2>آموزش مهارت های شغلی و کسب و کار</h2>
          </div>
          <div class="line1">
            <img src="v4_assets/images/icons/line1.svg" alt="line1">
          </div>
          <div class="level">
            <div class="icon"><i class="mdi mdi-forum-outline"></i></div>
            <h2>مشاوره ایجاد و توسعه کسب و کار</h2>
          </div>
          <div class="line2">
            <img src="v4_assets/images/icons/line2.svg" alt="line2">
          </div>
          <div class="level">
            <div class="icon"><i class="mdi mdi-cart-outline"></i></div>
            <h2>فروش و بازاریابی محصولات تولیدی</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- محصولات فروشگاهی -->
  <div class="landing-section bg-gray pt-5">
    <div class="container-lg">
      <div class="default-title type-2">
        <h2 class="title">محصولات فروشگاهی مددجویان</h2>
      </div>
      <div class="section-inner">
        <div class="swiper swiper-workshop" dir="rtl">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="card-product">
                <div class="card-inner">
                  <div class="cover">
                    <div class="cover-style img-normal">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/1.jpg" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="cover-style img-hover">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/1.jpg" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="hover-action">شرکت عصر آتی</div>
                  </div>
                  <div class="info">
                    <h2 class="name">
                      <a href="#">باتری سمعک دی پاور مدل 10 بسته 6 عددی</a>
                    </h2>
                    <div class="price">
                      <!-- isOff -->
                      <div class="real">29,080</div>
                      <!-- <div class="off">460,000</div> -->
                      <div class="toman">تومان</div>
                    </div>
                  </div>
                  <div class="rating">
                    <i class="mdi mdi-star"></i>
                    <span>4</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card-product">
                <div class="card-inner">
                  <div class="cover">
                    <div class="cover-style img-normal">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/2.jpg" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="cover-style img-hover">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/2.jpg" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="hover-action">آزمد</div>
                  </div>
                  <div class="info">
                    <h2 class="name">
                      <a href="#">عصای دستی نابینایان Azmed Az 936L</a>
                    </h2>
                    <div class="price">
                      <div class="real">225,000</div>
                      <div class="toman">تومان</div>
                    </div>
                  </div>
                  <div class="rating">
                    <i class="mdi mdi-star"></i>
                    <span>4.1</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card-product">
                <div class="card-inner">
                  <div class="cover">
                    <div class="cover-style img-normal">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/3.png" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="cover-style img-hover">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/3.png" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="hover-action">جرمنی مد</div>
                  </div>
                  <div class="info">
                    <h2 class="name">
                      <a href="#">سمعک دیجیتالی بیورر آلمان Beurer Hörhilfe HA 85 Paar</a>
                    </h2>
                    <div class="price">
                      <div class="real">6,800,000</div>
                      <div class="toman">تومان</div>
                    </div>
                  </div>
                  <div class="rating">
                    <i class="mdi mdi-star"></i>
                    <span>4.2</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card-product">
                <div class="card-inner">
                  <div class="cover">
                    <div class="cover-style img-normal">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/4.jpg" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="cover-style img-hover">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/4.jpg" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="hover-action">بهراد طب بیدار</div>
                  </div>
                  <div class="info">
                    <h2 class="name">
                      <a href="#">ویلچر ارتوپدی مدل FS908LJ</a>
                    </h2>
                    <div class="price">
                      <div class="real">7,300,000</div>
                      <div class="toman">تومان</div>
                    </div>
                  </div>
                  <div class="rating">
                    <i class="mdi mdi-star"></i>
                    <span>3.8</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card-product">
                <div class="card-inner">
                  <div class="cover">
                    <div class="cover-style img-normal">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/5.jpg" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="cover-style img-hover">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/5.jpg" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="hover-action">مد عیسی</div>
                  </div>
                  <div class="info">
                    <h2 class="name">
                      <a href="#">ویلچر مدعیسی مدل AL101</a>
                    </h2>
                    <div class="price">
                      <div class="real">3,690,000</div>
                      <div class="toman">تومان</div>
                    </div>
                  </div>
                  <div class="rating">
                    <i class="mdi mdi-star"></i>
                    <span>4.0</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card-product">
                <div class="card-inner">
                  <div class="cover">
                    <div class="cover-style img-normal">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/7.jpg" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="cover-style img-hover">
                      <a href="#">
                        <div class="cover-inner">
                          <img src="v4_assets/images/products/landing/7.jpg" alt="product-name">
                        </div>
                      </a>
                    </div>
                    <div class="hover-action">پخش دایانان</div>
                  </div>
                  <div class="info">
                    <h2 class="name">
                      <a href="#">واکر تاشو مدل TOP 919</a>
                    </h2>
                    <div class="price">
                      <div class="real">583,000</div>
                      <div class="toman">تومان</div>
                    </div>
                  </div>
                  <div class="rating">
                    <i class="mdi mdi-star"></i>
                    <span>3.7</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
        <div class="buttons-group">
          <a href="#" class="btn btn-default icon-left">ورود به فروشگاه<i class="mdi mdi-arrow-left"></i></a>
        </div>
      </div>
    </div>
  </div>

  <!-- چندرسانه‌ای های مهارتی -->
  <div class="landing-section bg-white border-radius-top">
    <div class="strip-back-right"></div>
    <div class="container-lg">
      <div class="default-title type-2">
        <h2 class="title">چندرسانه‌ای های مهارتی</h2>
        <h5 class="desc">محتوی چندرسانه ای آموزشی - انگیزشی ویژه معلولین</h5>
      </div>
      <div class="section-inner">
        <div class="card-grid-layout grid-4">
          <div class="card-clip">
            <div class="card-inner">
              <div class="cover">
                <div class="img-inner">
                  <img src="v4_assets/images/bg/login-1.jpg" alt="course">
                </div>
              </div>
              <div class="play">
                <i class="mdi mdi-play"></i>
              </div>
            </div>
          </div>
          <div class="card-clip">
            <div class="card-inner">
              <div class="cover">
                <div class="img-inner">
                  <img src="v4_assets/images/bg/login-2.jpg" alt="course">
                </div>
              </div>
              <div class="play">
                <i class="mdi mdi-play"></i>
              </div>
            </div>
          </div>
          <div class="card-clip">
            <div class="card-inner">
              <div class="cover">
                <div class="img-inner">
                  <img src="v4_assets/images/bg/login-3.jpg" alt="course">
                </div>
              </div>
              <div class="play">
                <i class="mdi mdi-play"></i>
              </div>
            </div>
          </div>
          <div class="card-clip">
            <div class="card-inner">
              <div class="cover">
                <div class="img-inner">
                  <img src="v4_assets/images/bg/login-4.jpg" alt="course">
                </div>
              </div>
              <div class="play">
                <i class="mdi mdi-play"></i>
              </div>
            </div>
          </div>
          <div class="card-clip">
            <div class="card-inner">
              <div class="cover">
                <div class="img-inner">
                  <img src="v4_assets/images/bg/login-5.jpg" alt="course">
                </div>
              </div>
              <div class="play">
                <i class="mdi mdi-play"></i>
              </div>
            </div>
          </div>
          <div class="card-clip">
            <div class="card-inner">
              <div class="cover">
                <div class="img-inner">
                  <img src="v4_assets/images/bg/login-1.jpg" alt="course">
                </div>
              </div>
              <div class="play">
                <i class="mdi mdi-play"></i>
              </div>
            </div>
          </div>
          <div class="card-clip">
            <div class="card-inner">
              <div class="cover">
                <div class="img-inner">
                  <img src="v4_assets/images/bg/login-2.jpg" alt="course">
                </div>
              </div>
              <div class="play">
                <i class="mdi mdi-play"></i>
              </div>
            </div>
          </div>
          <div class="card-clip">
            <div class="card-inner">
              <div class="cover">
                <div class="img-inner">
                  <img src="v4_assets/images/bg/login-3.jpg" alt="course">
                </div>
              </div>
              <div class="play">
                <i class="mdi mdi-play"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="buttons-group">
          <a href="#" class="btn btn-default icon-left"><i class="mdi mdi-arrow-left"></i>ویديوهای بیشتر</a>
        </div>
      </div>
    </div>
  </div>

  <div class="landing-section bg-gray pb-4 pt-4">
    <div class="container-lg">
      <div class="default-title type-2 mb-0">
        <h2 class="title mb-0">حامیان طرح</h2>
      </div>
      <div class="section-inner">
        <div class="supporters-cards-list">
          <div class="item">
            <img src="v4_assets/images/bg/behzisti.png" alt="سازمان بهزیستی کشور">
          </div>
          <div class="item">
            <img src="v4_assets/images/bg/behzisti-qazvin.png" alt="سازمان بهزیستی قزوین">
          </div>
          <div class="item">
            <img src="v4_assets/images/bg/nashenaza-logo.jpg" alt="انجمن خانواده معلولین">
          </div>
          <div class="item">
            <img src="v4_assets/images/bg/markaz.png" alt="مرکز خدمات حوزه های علمیه کشور">
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('Page_JS')

  <script src="v4_assets/plugin/vide/jquery.vide.min.js"></script>

@endsection
