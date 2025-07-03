@extends('layouts.front-master')

@section('Page_Title')
جستجو دوره های آموزشی
@endsection

@section('Page_CSS')
<link rel="stylesheet" href="/assets-v2/plugin/noUIslider/nouislider.css?1">
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


<div class="category-banner" style="margin-top: 130px !important;">
  <div class="container-lg">
    <div class="banner-inner">
      <h1 class="title">نام دسته بندی</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">اسم دسته بندی</a></li>
          <li class="breadcrumb-item active" aria-current="page">اسپیکر بلوتوثی</li>
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
                <input @if(request()->cat === '0' || !isset(request()->cat)) checked @endif class="form-check-input category" type="radio" name="radioCatWebinar" value="0">
                <label class="form-check-label">همه گروه ها</label>
              </div>
            </div>
            @foreach($cats as $cat)
            @if($cat->webinars_count > 0)
            <div class="checkbox-group">
              <div class="form-check">
                <input @if((int)request()->cat === (int)$cat->id) checked @endif class="form-check-input category" type="radio" name="radioCatWebinar" value="{{$cat->id}}">
                <label class="form-check-label">{{$cat->title}}</label>
              </div>
              <span class="number">{{$cat->webinars_count}}</span>
            </div>
            @endif
            @endforeach
          </div>
          <div class="item">
            <h6>نوع وبینار</h6>
            <div class="checkbox-group">
              <div class="form-check">
                <input @if(request()->type !== 'free' && request()->type !== 'nofree') checked @endif name="radioWebinar" class="form-check-input" type="radio" id="all" value="all">
                <label class="form-check-label" for="all">همه</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input @if(request()->type === 'free') checked @endif name="radioWebinar" class="form-check-input" type="radio" id="free" value="free">
                <label class="form-check-label" for="free">رایگان</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input @if(request()->type === 'nofree') checked @endif name="radioWebinar" class="form-check-input" type="radio" id="nofree" value="nofree">
                <label class="form-check-label" for="nofree">غیررایگان</label>
              </div>
            </div>
          </div>
          <div class="item">
            <h6>محدوده قیمت</h6>
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
              <button type="button" class="btn btn-default icon-right btn_search_ajax_webinar"><i class="mdi mdi-check"></i>اعمال فیلتر</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-12">
        <div class="cards-list-container">
          <div class="list-title have-sort">
            <h2 class="sort-title"><i class="mdi mdi-sort-variant"></i>مرتب سازی براساس :</h2>
            <ul id="sortWebinar">
              <li @if(request()->sort !== 'old') class="active" @endif>
                <a data-value="id" href="javascript:void(0);">جدیدترین ها</a>
              </li>
              <li @if(request()->sort === 'old') class="active" @endif>
                <a data-value="old" href="javascript:void(0);">قدیمی ترین</a>
              </li>
            </ul>
          </div>
          <div class="list-inner">
            <div class="row" id="tab-11">
              @foreach($webinars as $webinar)
              <?php $title = str_replace(' ', '_', $webinar->title); ?>
              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card-webinar" title="{{$webinar->title}}">
                  <div class="card-inner">
                    <a href="skill/webinar/{{$webinar->id}}/{{$title}}">
                      <div class="cover">
                        <div class="img-container">
                          <div class="img-inner">
                            <img src="_upload_/_webinars_/{{$webinar->code}}/medium_{{$webinar->image}}" alt="{{$webinar->title}}" />
                            <!-- <img src="v4_assets/images/courses/1.jpg" alt=""> -->
                          </div>
                        </div>
                        @if($webinar->discount>0)
                        <div class="percentage">{{$webinar->discount}}%</div>
                        @endif
                      </div>
                      <div class="info">
                        <h6 class="teacher">{{$webinar->teacher_name}}</h6>
                        <!-- <h2>{{$webinar->title}}</h2> -->
                        <div class="date-content">
                          <div class="date">
                            <span>{{$webinar->webinar_date}}</span>
                          </div>
                          <div class="time">
                            <span>16:00 - 18:00</span>
                          </div>
                        </div>
                        <div class="price-content off-code">
                          <div class="price">
                            @if($webinar->old_price > 0)
                            <div class="real">{{number_format($webinar->old_price)}}</div>
                            @endif
                            @if($webinar->price > 0)
                            <div class="off">{{number_format($webinar->price)}}</div>
                            @endif
                          </div>
                          <div class="text">
                            @if($webinar->price > 0)
                            <span class="toman">تومان</span>
                            @else
                            <span class="toman">رایگان</span>
                            @endif
                          </div>
                        </div>
                      </div>
                      @if($webinar->have_certificate ==1)
                      <div class="certificate">گواهینامه دارد</div>
                      @endif
                    </a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            <div class="my-pagination">
              <nav aria-label="Page navigation">
                <ul class="pagination">
                  {{ $webinars->appends(request()->all())->links( "pagination::bootstrap-4") }}
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
            @if($cat->webinars_count>0)
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input category_mob" type="radio" name="cat_{{$cat->category}}" id="idcat_{{$cat->id}}_mob" value="{{$cat->id}}">
                <label class="form-check-label">{{$cat->title}}</label>
              </div>
              <span class="number">{{$cat->webinars_count}}</span>
            </div>
            @endif
            @endforeach
          </div>
        </div>
      </div>
      <div class="collapse-item">
        <button class="btn-link-collapse collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-collapse-03" aria-expanded="true" aria-controls="filter-collapse-03">
          <span class="title">نوع وبینار</span>
          <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
        </button>
        <div class="collapse" id="filter-collapse-03">
          <div class="mobile-category-list">
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="all_mob" value="all">
                <label class="form-check-label" for="all_mob">همه</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="free_mob" value="free">
                <label class="form-check-label" for="free_mob">رایگان</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="nofree_mob" value="nofree">
                <label class="form-check-label" for="nofree_mob">غیر رایگان</label>
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
    <button type="button" class="btn btn-default icon-right" id="btn_filter_ajax_webinar_mob"><i class="mdi mdi-check"></i>اعمال فیلتر</button>
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
    <button type="button" class="btn btn-default icon-right" id="btn_sort_mob"><i class="mdi mdi-check"></i>اعمال مرتب سازی</button>
  </div>
</div>


@endsection


@section('Page_JS')

<script>
  $("#sortWebinar li a").click(function() {
    let cat = $('input[name="radioCatWebinar"]:checked').val();
    let value = $(this).data('value')
    window.open('skill/webinars?search=' + "{{request()->search}}" + '&sort=' + value + '&type=' + "{{request()->type}}" + '&minPrice=' + {
      {
        isset(request() - > minPrice) ? request() - > minPrice : 0
      }
    } + '&maxPrice=' + {
      {
        isset(request() - > maxPrice) ? request() - > maxPrice : 10000000
      }
    } + '&cat=' + cat, '_self')
  });

  $(".btn_search_ajax_webinar").click(function() {
    let type = $('input[name="radioWebinar"]:checked').val();
    let cat = $('input[name="radioCatWebinar"]:checked').val();
    var minPrice = $("#min_price").text();
    var maxPrice = $("#max_price").text();
    var search = $("#search").val();
    window.open('skill/webinars?search=' + search + '&sort=' + "{{request()->sort}}" + '&type=' + type + '&minPrice=' + minPrice + '&maxPrice=' + maxPrice + '&cat=' + cat, '_self')
  });
</script>

<script src="/assets-v2/plugin/noUIslider/nouislider.min.js?1"></script>
<script src="/assets-v2/plugin/noUIslider/nouislider.initial.js?1"></script>
@endsection
