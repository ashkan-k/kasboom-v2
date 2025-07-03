@extends('course.master_course')

@section('Page_Title')
  آموزشگاه کسب بوم - گروه های وبینارهای آموزشی
@endsection

@section('Page_CSS')

@endsection


@section('Content')

  <!-- Education category List -->
  <div class="education-category-list">
    <div class="container">
      <div class="category-info">
        <div class="image">
          <img src="v4_assets/images/icons/kasbom-category/webinar.svg" alt="وبینارهای آموزشی">
        </div>
        <div class="text">
          <h2 class="name">وبینارهای آموزشی مهارتی</h2>
          <div class="desc">
            در ادامه فهرستی از گروه های وبینارهای آموزشی آمده است، که طبقه‌بندی موضوعی و کاربردی وبینارها را نشان می‌دهند. استفاده از این فهرست، یافتن و انتخاب آموزش مورد نظر شما را، آسان خواهد نمود.
          </div>
        </div>
      </div>
      <div class="category-list-inner">
        <div class="title">
          <h2>گروه های وبینارهای آموزشی </h2>
        </div>
        <div class="list">
          @foreach($cats as $cat)
            <?php $title=str_replace(' ','_',$cat->title); ?>
            <div class="card-category-courses">
            <a href="skill/category/{{$cat->id}}/{{$title}}">
              <div class="cover">
                <img src="_upload_/_category_/images/{{$cat->type}}/{{$cat->image}}" alt="{{$cat->title}}">
              </div>
              <div class="card-b">
                <div class="name">
                  <h2>{{$cat->title}}</h2>
                </div>
                <div class="course-info">
                  <div class="item">
                    <span class="number">{{$cat->itam_count}}</span>
                    <span class="info">وبینار</span>
                  </div>
                  <div class="item">
                    <span class="number">{{$cat->total_register}}</span>
                    <span class="info">دقیقه</span>
                  </div>
                  <div class="item">
                    <span class="number">{{$cat->total_register}}</span>
                    <span class="info">ثبت نام</span>
                  </div>
                </div>
              </div>
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
