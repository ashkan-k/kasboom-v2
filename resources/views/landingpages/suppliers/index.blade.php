@extends('blog.blog-ebook-master')

@section('Page_Title')
آموزشگاه کسب بوم - توانمندسازی مهارتی معلولین
@endsection

@section('Page_CSS')

@endsection


@section('Content')


<!-- Page Background -->
<div class="page-background">
  <div class="text">
    <div class="text-inner">
      <h2>شرکت های پشتیبان</h2>
    </div>
  </div>
</div>

<div class="public-section">
  <div class="container">
    <div class="default-title">
      <h2 class="title">شرکت های پشتیبان چه کاری انجام میدهند؟</h2>
      {{-- <h5 class="desc">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک--}}
      {{-- است</h5>--}}
    </div>
    <div class="suppliers-property">
      <ul>
        <li>
          <span class="icon">1</span>
          <span class="text">تامین مواد اولیه</span>
        </li>
        <li>
          <span class="icon">2</span>
          <span class="text">آموزش</span>
        </li>
        <li>
          <span class="icon">3</span>
          <span class="text">خرید تضمینی</span>
        </li>
      </ul>
    </div>
    <div class="buttons-group">
      <a href="#" class="btn btn-default icon-right"><i class="mdi mdi-check"></i>ثبت نام تامین کننده</a>
    </div>
  </div>
</div>

<div class="public-section bg-gray">
  <div class="container">
    <div class="default-title">
      <h2 class="title">شرکت های تامین</h2>
    </div>
    <div class="company-list">
      <div class="card-company">
        <a href="{{ url('supplier/panuch') }}" class="card-inner">
          <div class="cover">
            <div class="img-inner">
              <img src="v4_assets/images/blogs/blog-06.jpg" alt="cover">
            </div>
            <span class="see-details"><i class="mdi mdi-eye"></i>مشاهده جزییات</span>
          </div>
          <div class="company-logo">
            <img src="v4_assets/images/com-1.png" alt="user name" />
          </div>
          <div class="info">
            <h2>پنوچ گستران کهن</h2>
            <p>تعداد تامین شدگان : <span>32</span></p>
          </div>
        </a>
      </div>
      <div class="card-company">
        <a href="{{ url('supplier/panuch') }}" class="card-inner">
          <div class="cover">
            <div class="img-inner">
              <img src="v4_assets/images/blogs/blog-05.jpg" alt="cover">
            </div>
            <span class="see-details"><i class="mdi mdi-eye"></i>مشاهده جزییات</span>
          </div>
          <div class="company-logo">
            <img src="v4_assets/images/com.png" alt="user name" />
          </div>
          <div class="info">
            <h2>ستاره درین رضوان</h2>
            <p>تعداد تامین شدگان : <span>20</span></p>
          </div>
        </a>
      </div>
      <div class="card-company">
        <a href="{{ url('supplier/panuch') }}" class="card-inner">
          <div class="cover">
            <div class="img-inner">
              <img src="v4_assets/images/blogs/blog-04.jpg" alt="cover">
            </div>
            <span class="see-details"><i class="mdi mdi-eye"></i>مشاهده جزییات</span>
          </div>
          <div class="company-logo">
            <img src="v4_assets/images/com-2.png" alt="user name" />
          </div>
          <div class="info">
            <h2>آریا ممتاز رسا</h2>
            <p>تعداد تامین شدگان : <span>26</span></p>
          </div>
        </a>
      </div>
      <div class="card-company">
        <a href="{{ url('supplier/panuch') }}" class="card-inner">
          <div class="cover">
            <div class="img-inner">
              <img src="v4_assets/images/blogs/blog-03.jpg" alt="cover">
            </div>
            <span class="see-details"><i class="mdi mdi-eye"></i>مشاهده جزییات</span>
          </div>
          <div class="company-logo">
            <img src="v4_assets/images/com-2.png" alt="user name" />
          </div>
          <div class="info">
            <h2>طاها گستر آرشام</h2>
            <p>تعداد تامین شدگان : <span>14</span></p>
          </div>
        </a>
      </div>
      <div class="card-company">
        <a href="{{ url('supplier/panuch') }}" class="card-inner">
          <div class="cover">
            <div class="img-inner">
              <img src="v4_assets/images/blogs/blog-02.jpg" alt="cover">
            </div>
            <span class="see-details"><i class="mdi mdi-eye"></i>مشاهده جزییات</span>
          </div>
          <div class="company-logo">
            <img src="v4_assets/images/com-2.png" alt="user name" />
          </div>
          <div class="info">
            <h2>ایده آرا پرداز</h2>
            <p>تعداد تامین شدگان : <span>29</span></p>
          </div>
        </a>
      </div>
      <div class="card-company">
        <a href="{{ url('supplier/panuch') }}" class="card-inner">
          <div class="cover">
            <div class="img-inner">
              <img src="v4_assets/images/blogs/blog-01.jpg" alt="cover">
            </div>
            <span class="see-details"><i class="mdi mdi-eye"></i>مشاهده جزییات</span>
          </div>
          <div class="company-logo">
            <img src="v4_assets/images/com-2.png" alt="user name" />
          </div>
          <div class="info">
            <h2>آینه هنر و صنعت</h2>
            <p>تعداد تامین شدگان : <span>16</span></p>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

@endsection


@section('Page_JS')


@endsection