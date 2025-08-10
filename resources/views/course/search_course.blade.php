@extends('course.master_course')

@section('Page_Title')
 دوره های آموزشی
@endsection

@section('Page_CSS')
<link rel="stylesheet" href="assets-v2/plugin/noUIslider/nouislider.css?1">
<style>
  .noUi-handle-upper {
    margin-left: 1000%;
     !important;
  }

  .noUi-handle-lower {
    margin-left: 1000%;
     !important;
  }
</style>
@endsection


@section('Content')

<!-- Mobile Filter -->
<div id="mobile-filter" class="fixed-top is-fixed is-visible">
  <div class="filter-button">
    <button type="button" id="btn-mob-filter" class="btn-filter">
      <i class="mdi mdi-tune"></i>
      <span>فیلترها</span>
    </button>
  </div>
  <div class="filter-button">
    <button type="button" id="btn-mob-sort" class="btn-filter">
      <i class="mdi mdi-sort-ascending mdi-flip-h"></i>
      <span>مرتب سازی</span>
    </button>
  </div>
</div>

{{--banner--}}
<div class="category-banner">
  <div class="container-lg">
    <div class="banner-inner">
      <h1 class="title">{{$cat_title}}</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="skill"><i class="mdi mdi-home"></i></a></li>
          <li class="breadcrumb-item active">
            <a href="category/{{$slug}}}">{{$cat_title}}</a>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<!-- Blogs Content -->
<div class="main-list-content">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-12">
        <div class="filters-side">
          <div class="item">
            <h6>گروه های آموزشی</h6>
            <div class="checkbox-group">
              <div class="form-check">
                <input @if($id_category==='0' ) checked @endif class="form-check-input category" type="radio" name="courseCatRadio" value="0">
                <label class="form-check-label">همه گروه ها</label>
              </div>
            </div>
            @foreach($cats as $cat)
            <div class="checkbox-group">
              <div class="form-check">
                <input @if($id_category===(int)$cat->id) checked @endif class="form-check-input category" type="radio" name="courseCatRadio" value="{{$cat->slug}}" {{$cat->id == $id_category ? "checked" : null}}>
                <label class="form-check-label">{{$cat->title}}</label>
              </div>
{{--              <span class="number">{{$cat->courses_count}}</span>--}}
            </div>
            @endforeach
          </div>
          <div class="item">
            <h6>سطح آموزش</h6>
            <div class="checkbox-group">
              <div class="form-check">
                <input name="lavelRadio" @if(!in_array(request()->level, ['level1','level2','level3'])) checked @endif class="form-check-input" type="radio" value="all">
                <label class="form-check-label" for="level">همه</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input name="lavelRadio" @if(request()->level === 'level1') checked @endif class="form-check-input" type="radio" id="level1" value="level1">
                <label class="form-check-label" for="level1">مقدماتی</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input name="lavelRadio" @if(request()->level === 'level2') checked @endif class="form-check-input" type="radio" id="level2" value="level2">
                <label class="form-check-label" for="level2">متوسطه (رشد)</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input name="lavelRadio" @if(request()->level === 'level3') checked @endif class="form-check-input" type="radio" id="level3" value="level3">
                <label class="form-check-label" for="level3">پیشرفته (تثبیت)</label>
              </div>
            </div>
          </div>
          <div class="item">
            <h6>نوع هزینه</h6>
            <div class="checkbox-group">
              <div class="form-check">
                <input name="priceRadio" @if(!in_array(request()->price, ['nonFree','free'])) checked @endif class="form-check-input" type="radio" value="">
                <label class="form-check-label">همه</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input name="priceRadio" @if(request()->price === 'free') checked @endif class="form-check-input" type="radio" value="free">
                <label class="form-check-label">رایگان</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input name="priceRadio" @if(request()->price === 'nonFree') checked @endif class="form-check-input" type="radio" value="nonFree">
                <label class="form-check-label">غیر رایگان</label>
              </div>
            </div>
          </div>
          <div class="item">
            <h6>نوع آموزش</h6>
            <div class="checkbox-group">
              <div class="form-check">
                <input name="typeRadio" @if(!in_array(request()->type, ['course','class'])) checked @endif class="form-check-input" type="radio" value="">
                <label class="form-check-label">همه</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input name="typeRadio" @if(request()->type === 'course') checked @endif class="form-check-input" type="radio" value="course">
                <label class="form-check-label">دوره اختصاصی</label>
              </div>
            </div>
              <div class="checkbox-group">
                  <div class="form-check">
                      <input name="typeRadio" @if(request()->type === 'duble') checked @endif class="form-check-input" type="radio" value="course">
                      <label class="form-check-label">دوره دوبله</label>
                  </div>
              </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input name="typeRadio" @if(request()->type === 'subtitle') checked @endif class="form-check-input" type="radio" value="class">
                <label class="form-check-label">دوره زیرنویس</label>
              </div>
            </div>
          </div>
          <div class="item">
            <h6>کف سرمایه</h6>
            <div class="range-price-filter">
              <div class="price-range"></div>
              <div class="range-value-inner">
                <div class="min-range">
                  <span>از</span>
                  <div id="min_price" class="price-number slider-value-min" data-value="0"></div>
                  <span>تومان</span>
                </div>
                <div class="max-range">
                  <span>تا</span>
                  <div id="max_price" class="price-number slider-value-max" data-value="10000000"></div>
                  <span>تومان</span>
                </div>
              </div>
            </div>
            <div class="apply-filter">
              <button type="button" class="btn btn-default icon-right" id="btn_filter_ajax_course_new"><i class="mdi mdi-check"></i>اعمال فیلتر</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-12">
        <div class="cards-list-container">
          <div class="list-title have-sort">
            <h2 class="sort-title"><i class="mdi mdi-sort-variant"></i>مرتب سازی براساس :</h2>
            <ul id="sortCourse">
              <li @if(request()->sort === 'id') class="active" @endif>
                <a data-value="id" href="javascript:void(0);">جدیدترین ها</a>
              </li>
              <li @if(request()->sort === 'register_count') class="active" @endif>
                <a data-value="register_count" href="javascript:void(0);">بیشترین خرید</a>
              </li>
              <li @if(request()->sort === 'view_count') class="active" @endif>
                <a data-value="view_count" href="javascript:void(0);">بیشترین بازدید</a>
              </li>
            </ul>
          </div>
          <div class="list-inner">
            <div class="row" id="tab-11">
              @foreach($courses as $course)
                        <?php $title = str_replace(' ', '_', $course->title);
                        $img_src=$course->getThumbnail();
                        $course_slug= "course/".$course->getSlug();
                        $teacher= $course->teacher ? $course->teacher->fullname : 'کسبوم';
                        $time=$course->minutes > 0 ? $course->hour.':'.$course->minutes : $course->hour;
               ?>
              <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                  <div class="card-course" title="{{$course->title}}">
                      <a href="{{$course_slug}}">
                          <div class="img-container">
                              <div class="img-inner">
                                  <img src="{{$img_src}}" alt="{{$course->title}}" />
                              </div>
                              <div class="status">
                                  @if($course->discount > 0)
                                      <div class="percentage">{{$course->discount}}</div>
                                  @endif
                                  @if($course->have_certificate)
                                      <div class="certificate">گواهینامه دارد</div>
                                  @endif
                              </div>
                          </div>
                          <div class="card-b">
                              <h3 class="name">{{$course->title}}</h3>
                              <div class="info">
                                  <h4 class="teacher"><i class="mdi mdi-account-outline"></i>{{$teacher}}</h4>
                                  <p class="duration"><i class="mdi mdi-clock-outline"></i>مدت زمان دوره :
                                      <span>{{$time}}
                                                    ساعت</span>
                                  </p>
                                  @if($course->register_count  >0)
                                      <p class="students"><i class="mdi mdi-school-outline"></i>هنرآموزان :
                                          <span>{{$course->register_count}}
                                                    نفر</span>
                                      </p>
                                  @endif
                                  <div class="price-content off-code">
                                      <div class="price">
                                          @if($course->old_price > 0)
                                              @if($course->old_price <> $course->price)
                                                  <div class="real">{{ number_format($course->old_price) }}</div>
                                              @endif
                                          @endif
                                          @if($course->price > 0)
                                              <div class="off">{{ number_format($course->price) }}</div>
                                          @else
                                              <div class="off">رایگان</div>
                                          @endif
                                      </div>
                                      <div class="text">
                                          @if($course->price > 0)
                                              <span class="toman">تومان</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </a>
                  </div>
              </div>
              @endforeach
            </div>
            <div class="my-pagination">
              <nav aria-label="Page navigation">
                <ul class="pagination">
                  {{ $courses->appends(request()->all())->links( "pagination::bootstrap-4") }}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Mobile Filter Content -->
<div id="mob-filter-content" class="mobile-filter-style">
  <div class="mob-header">
    <h2><i class="mdi mdi-tune"></i>فیلتر‌ها</h2>
    <button type="button" class="btn-close-filter"><i class="mdi mdi-close"></i></button>
  </div>
  <div class="mob-body">
    <div class="collapse-group">
      <div class="collapse-item">
        <button class="btn-link-collapse collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-collapse-01" aria-expanded="true" aria-controls="filter-collapse-01">
          <span class="title">گروه های آموزشی</span>
          <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
        </button>

        <div class="collapse" id="filter-collapse-01">
          <div class="mobile-category-list">
            @foreach($cats as $cat)
            @if($cat->courses_count > 0)
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="cat_{{$cat->category}}" id="idcat_{{$cat->id}}_mob" value="{{$cat->id}}" {{$cat->id == $id_category ? "checked" : null}}>
                <label class="form-check-label">{{$cat->title}}</label>
              </div>
              <span class="number">{{$cat->courses_count}}</span>
            </div>
            @endif
            @endforeach
          </div>
        </div>
      </div>
      <div class="collapse-item">
        <button class="btn-link-collapse collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-collapse-03" aria-expanded="true" aria-controls="filter-collapse-03">
          <span class="title">سطح آموزش</span>
          <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
        </button>
        <div class="collapse" id="filter-collapse-03">
          <div class="mobile-category-list">
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="level1_mob" value="1">
                <label class="form-check-label" for="level1_mob">مقدماتی</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="level2_mob" value="1">
                <label class="form-check-label" for="level2_mob">متوسطه (رشد)</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="level3_mob" value="1">
                <label class="form-check-label" for="level3_mob">پیشرفته (تثبیت)</label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="collapse-item">
        <button class="btn-link-collapse collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-collapse-02" aria-expanded="true" aria-controls="filter-collapse-02">
          <span class="title">محدوده قیمت</span>
          <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
        </button>
        <div class="collapse" id="filter-collapse-02">
          <div class="range-price-filter">
            <div class="price-range"></div>
            <div class="range-value-inner">
              <div class="min-range">
                <span>از</span>
                <div id="min_price_mob" class="price-number slider-value-min" data-value="0"></div>
                <span>تومان</span>
              </div>
              <div class="max-range">
                <span>تا</span>
                <div id="max_price_mob" class="price-number slider-value-max" data-value="10000000"></div>
                <span>تومان</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mob-footer">
    <button type="button" class="btn btn-green icon-right" id="btn_filter_ajax_course_mob"><i class="mdi mdi-check"></i>اعمال فیلتر</button>
  </div>
</div>

<!-- Mobile Sort Content -->
<div id="mob-sort-content" class="mobile-sort-style">
  <div class="mob-header">
    <h2><i class="mdi mdi-sort-ascending mdi-flip-h"></i>مرتب‌ سازی‌ها</h2>
    <button type="button" class="btn-close-sort"><i class="mdi mdi-close"></i></button>
  </div>
  <div class="mob-body p-20">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="sort-radio" id="new" value="new" checked>
      <label class="form-check-label" for="new">جدیدترین ها</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="sort-radio" id="old" value="old">
      <label class="form-check-label" for="old">قدیمی ترین ها</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="sort-radio" id="free" value="free">
      <label class="form-check-label" for="free">رایگان</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="sort-radio" id="dontfree" value="dontfree">
      <label class="form-check-label" for="dontfree">غیر رایگان</label>
    </div>
  </div>
  <div class="mob-footer">
    <button type="button" class="btn btn-green icon-right" id="btn_sort_mob"><i class="mdi mdi-check"></i>اعمال مرتب سازی</button>
  </div>
</div>

@endsection


@section('Page_JS')

<script>
  $("#sortCourse li a").click(function() {
    console.log(1111111111)
    let value = $(this).data('value')
    window.open('category/' + "{{$slug}}" + '?search=' + "{{request()->search}}" + '&sort=' + value + '&level=' + "{{request()->level}}" + '&price=' + "{{request()->price}}" + '&type=' + "{{request()->type}}" + '&minPrice=' + {{isset(request() -> minPrice) ? request() -> minPrice : 0}} + '&maxPrice=' + {{isset(request()-> maxPrice) ? request()-> maxPrice : 10000000}}, '_self')
  });

  $("#btn_filter_ajax_course_new").click(function() {
    let price = $('input[name="priceRadio"]:checked').val();
    let type = $('input[name="typeRadio"]:checked').val();
    let level = $('input[name="lavelRadio"]:checked').val();
    let cat = $('input[name="courseCatRadio"]:checked').val();
    var minPrice = $("#min_price").text();
    var maxPrice = $("#max_price").text();
    window.open('category/' + cat + '?search=' + "{{request()->search}}" + '&sort=' + "{{request()->sort}}" + '&level=' + level + '&price=' + price + '&type=' + type + '&minPrice=' + minPrice + '&maxPrice=' + maxPrice, '_self')
  });
</script>

@endsection
