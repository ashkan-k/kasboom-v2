@extends('layouts.front-master')

@section('Page_Title')
آموزشگاه کسب بوم - گروه های دوره های آموزشی
@endsection

@section('Page_CSS')

@endsection


@section('Content')

<!-- Education category List -->
<div class="education-category-list">
  <div class="container">
    <div class="category-info">
      <div class="image">
        <img src="/assets-v2/images/icons/kasbom-category/online-learning.svg" alt="دوره های آموزشی">
      </div>
      <div class="text">
        <h2 class="name">دوره های آموزشی مهارتی</h2>
        <div class="desc">
          در ادامه فهرستی از گروه های آموزشی کسب بوم آمده است، که طبقه‌بندی موضوعی و کاربردی آموزش‌ها را نشان می‌دهند. استفاده از این فهرست، یافتن و انتخاب آموزش مورد نظر شما را، آسان خواهد نمود.
        </div>
      </div>
    </div>
    <div class="category-list-inner">
      <div class="title">
        <div class="title-inner">
          <div class="shape"></div>
          <h1>گروه های آموزشی دوره های مهارتی </h1>
        </div>
      </div>
      <div class="list">
        @foreach($cats as $cat)
        <?php $title = str_replace(' ', '_', $cat->title); ?>
        <div class="card-category-courses">
          <a href="category/{{ $cat->slug }}">
            <div class="cover">
              <img src="_upload_/_category_/images/{{$cat->type}}/{{$cat->image}}" alt="{{$cat->title}}">
            </div>
            <div class="course-info">
              <div class="item">
                <span class="number">{{$cat->item_count}}</span>
                <span class="info">آموزش</span>
              </div>
              <div class="item">
                <span class="number">{{$cat->total_learn_time}}</span>
                <span class="info">دقیقه</span>
              </div>
              <div class="item">
                <span class="number">{{$cat->total_register}}</span>
                <span class="info">مهارت‌آموز</span>
              </div>
            </div>
{{--              <div class="course-info">--}}
{{--                <div class="item">--}}
{{--                  <span class="number">{{$cat->item_count}}</span>--}}
{{--                  <span class="info">آموزش</span>--}}
{{--                </div>--}}
{{--                <div class="item">--}}
{{--                  <span class="number">{{$cat->total_learn_time}}</span>--}}
{{--                  <span class="info">دقیقه</span>--}}
{{--                </div>--}}
{{--                <div class="item">--}}
{{--                  <span class="number">{{$cat->total_register}}</span>--}}
{{--                  <span class="info">مهارت‌آموز</span>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

@endsection


@section('Page_JS')

@endsection
