@extends('layouts.front-master')

@section('Page_Title')کسب بوم - لیست ایده ها@endsection

@section('Page_CSS_Before')@endsection

@section('Page_CSS_After')@endsection

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

<!-- Category banner -->
<div class="category-banner" style="margin-top: 135px !important;">
  <div class="container-lg">
    <div class="banner-inner">
      <h1 class="title">لیست ایده ها</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <!--<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home"></i></a></li>-->
          <!--<li class="breadcrumb-item"><a href="#">کالای دیجیتال</a></li>-->
          <!--<li class="breadcrumb-item active" aria-current="page">اسپیکر بلوتوثی</li>-->
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
            <h6>دسته بندی</h6>
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" name="catRadio" type="radio" checked value="0">
                <label class="form-check-label" for="checkbox-01">همه</label>
              </div>
            </div>
            @foreach($cats as $cat)
            @if($cat->idea_count > 0)
            <div class="checkbox-group">
              <div class="form-check">
                <input @if($title==$cat->title) checked @endif class="form-check-input"
                type="radio" name="catRadio" value="{{$cat->id}}">
                <label class="form-check-label" for="checkbox-01">{{$cat->title}}</label>
              </div>
              <span class="number">{{$cat->idea_count}}</span>
            </div>
            @endif
            @endforeach
          </div>
          <div class="item">
            <h6>ریسک پذیری</h6>
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="riskRadio" checked value="">
                <label class="form-check-label" for="checkbox-07">همه</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="riskRadio" value="پایین">
                <label class="form-check-label" for="checkbox-07">پایین</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="riskRadio" value="متوسط">
                <label class="form-check-label" for="checkbox-08">متوسط</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="riskRadio" value="زیاد">
                <label class="form-check-label" for="checkbox-09">زیاد</label>
              </div>
            </div>
            <div class="checkbox-group">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="riskRadio" value="خیلی زیاد">
                <label class="form-check-label" for="checkbox-10">خیلی زیاد</label>
              </div>
            </div>
          </div>
          <div class="item">
            <h6>قیمت زیاد سرمایه</h6>
            <div class="range-price-filter">
              <div class="price-range"></div>
              <div class="range-value-inner">
                <div class="min-range">
                  <span>از</span>
                  <div id="priceNumberMin" class="price-number slider-value-min" data-value="1000"></div>
                  <span>تومان</span>
                </div>
                <div class="max-range">
                  <span>تا</span>
                  <div id="priceNumberMax" class="price-number slider-value-max" data-value="1000000000"></div>
                  <span>تومان</span>
                </div>
              </div>
            </div>
            <div class="apply-filter">
              <button type="submit" class="btn btn-default icon-right submitFilter"><i class="mdi mdi-check"></i>اعمال فیلتر</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-12">
        <div class="cards-list-container">
          <div class="list-title have-sort">
            <h2 class="sort-title"><i class="mdi mdi-sort-variant"></i>مرتب سازی براساس :</h2>
            <ul id="selectIdea">
              <li data-value="" class="active">
                <a href="javascript:void(0);">جدیدترین</a>
              </li>
              <li data-value="like_count">
                <a href="javascript:void(0);">محبوب ترین</a>
              </li>
              <li data-value="view_count">
                <a href="javascript:void(0);">بیشترین بازدید</a>
              </li>
            </ul>
          </div>
          <div class="list-inner" id="searchResult"></div>
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
      <button class="btn-link-collapse collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-collapse-01" aria-expanded="true" aria-controls="filter-collapse-01">
        <span class="title">دسته بندی</span>
        <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
      </button>
      <div class="collapse" id="filter-collapse-01">
        <div class="mobile-category-list">
          <div class="checkbox-group">
            <div class="form-check">
              <input checked class="form-check-input" type="radio" name="catRadioMobile" value="getAllCat">
              <label class="form-check-label" for="mobile-checkbox-01">همه</label>
            </div>
          </div>

          @foreach($cats as $cat)
          @if($cat->idea_count > 0)
          <div class="checkbox-group">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="catRadioMobile" @if($title==$cat->title) checked @endif
              value="{{$cat->id}}">
              <label class="form-check-label" for="mobile-checkbox-01">{{$cat->title}}</label>
            </div>
            <span class="number">{{$cat->idea_count}}</span>
          </div>
          @endif
          @endforeach
        </div>
      </div>
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
              <div id="priceNumberMobileMin" class="price-number slider-value-min" data-value="1000"></div>
              <span>تومان</span>
            </div>
            <div class="max-range">
              <span>تا</span>
              <div id="priceNumberMobileMax" class="price-number slider-value-max" data-value="1000000000"></div>
              <span>تومان</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mob-footer">
    <button type="button" class="btn btn-green icon-right submitFilter"><i class="mdi mdi-check"></i>اعمال فیلتر</button>
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
      <input class="form-check-input" value="" type="radio" name="selectIdeaMobile" checked>
      <label class="form-check-label" for="radio-sort-01">همه ایده ها</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" value="like_count" type="radio" name="selectIdeaMobile">
      <label class="form-check-label" for="radio-sort-02">ایده های محبوب</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" value="view_count" type="radio" name="selectIdeaMobile">
      <label class="form-check-label" for="radio-sort-03">ایده های پربازدید</label>
    </div>
  </div>
  <div class="mob-footer">
    <button type="button" class="btn btn-green icon-right submitFilter"><i class="mdi mdi-check"></i>اعمال فیلتر</button>
  </div>
</div>

<input type="hidden" value="web" id="webOrMobile">
@endsection

@section('Page_JS')
<script>
  _search = function(page, sort) {
    var sortable = ''
    if (sort) {
      sortable = sort
    }

    var form = new FormData();
    var webOrMobile = $('#webOrMobile').val()
    var searchInputWiki = $('#searchInputWiki').val();

    if (webOrMobile === 'web') {
      var minPrice = $('#priceNumberMin').text();
      var maxPrice = $('#priceNumberMax').text();
      minPrice = parseInt(String(minPrice).replace(/,/g, ''));
      maxPrice = parseInt(String(maxPrice).replace(/,/g, ''));

      form.append("title", $('input[name="catRadio"]:checked').val());
      form.append("sort", sortable);
      form.append("search", searchInputWiki ? searchInputWiki : '');
      form.append("priceNumberMin", minPrice);
      form.append("priceNumberMax", maxPrice);
      form.append("risk", $('input[name="riskRadio"]:checked').val());
    } else {
      var minPriceMobile = $('#priceNumberMobileMin').text();
      var maxPriceMobile = $('#priceNumberMobileMax').text();
      minPrice = parseInt(String(minPriceMobile).replace(/,/g, ''));
      maxPrice = parseInt(String(maxPriceMobile).replace(/,/g, ''));

      form.append("title", $('input[name="catRadioMobile"]:checked').val());
      form.append("sort", $('input[name="selectIdeaMobile"]:checked').val());
      form.append("search", searchInputWiki ? searchInputWiki : '');
      form.append("priceNumberMin", minPrice);
      form.append("priceNumberMax", maxPrice);
    }

    form.append("page", page);
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "wikiidea/cat/search/ajax",
      type: "POST",
      data: form,
      processData: false,
      contentType: false,
      async: true,
      success: function(data) {
        $('#searchResult').html(data);
      }
    });
  };

  //searchBtnWiki , submitFilter ajax
  $('.searchBtnWiki , .submitFilter').click(function() {
    var sort = $("#selectIdea .active").data('value');
    _search(1, sort);
  });

  //change select value
  $("#selectIdea li").click(function() {
    $("#selectIdea li").removeClass("active")
    $(this).addClass("active");
    var sort = $(this).data('value');
    _search(1, sort);
  });

  //first search
  $(document).ready(function() {
    _search(1);
  });

  //pagination BtnPage
  $(document).on("click", '#paginationBtnPage', function() {
    var sort = $("#selectIdea .active").data('value');
    var id = $(this).data('id');
    _search(id, sort);
  });

  if (jQuery(window).width() <= 992) {
    $('#webOrMobile').val('mobile')
  } else {
    $('#webOrMobile').val('web')
  }
  $(window).resize(function() {
    if (jQuery(window).width() <= 992) {
      $('#webOrMobile').val('mobile')
    } else {
      $('#webOrMobile').val('web')
    }
  });
</script>

@endsection
