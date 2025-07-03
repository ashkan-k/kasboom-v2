@extends('layouts.front-master')

@section('Page_Title')کسب بوم - جزئیات ایده ها@endsection

@section('Page_CSS_Before')@endsection

@section('Page_CSS_After')@endsection

@section('Content')
<!-- Idea Content -->
<div class="public-section">
  <div class="container" style="margin-top: 50px !important;">
    <div class="row">
      <div class="col-lg-9 col-md-12">
        <div class="blog-details-container">
          <div class="blog-image">
            <figure class="blog-pic">
              <div class="img-inner">
                <img src="_upload_/_wikiideas_/{{$idea->code}}/{{$idea->image}}" alt="{{$idea->title}}" />
              </div>
              <div class="blog-information blurred-container">
                <h2>{{$idea->title}}</h2>
              </div>
            </figure>
          </div>
          <div class="blog-description">
            <div class="blog-date">
              <div class="seen">
                <i class="mdi mdi-eye-outline"></i>
                <span>{{$idea->view_count != null ? $idea->view_count : 0}}</span>
              </div>
              <div class="star">
                <i class="mdi mdi-star-outline"></i>
                <span>{{$idea->score != null ? $idea->score : 0}}</span>
              </div>
              <div class="time">
                <i class="mdi mdi-clock-outline"></i>
                <span>{{$idea->registe_date != null ? $idea->registe_date : 0}}</span>
              </div>
              <div class="like">
                <button type="button" class="btn-like">
                  <span>{{$idea->like_count != null ? $idea->like_count : 0}}</span>
                </button>
              </div>
            </div>

            <h6 class="name">توضیحات مختصری از ایده:</h6>
            {!! $idea->memo !!}
          </div>
          <div class="blog-tags">
            <div class="tag-title">
              <h6>برچسب‌ها : </h6>
            </div>
            <ul>
              <li>{{$idea->category?->title}}</li>
            </ul>
          </div>
          <div class="pull-left">
            <!-- share -->
            <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
              <a class="a2a_button_telegram"></a>
              <a class="a2a_button_whatsapp"></a>
              <a class="a2a_button_google_gmail"></a>
              <a class="a2a_button_wordpress"></a>
              <a class="a2a_button_linkedin"></a>
              <a class="a2a_button_print"></a>
              <a class="a2a_button_copy_link"></a>
            </div>
            <script async src="/assets-v2/js/page.js"></script>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-12">
        <div class="side-idea">
          <div class="idea-table-property">
            <div class="title"><i class="mdi mdi-check-circle-outline"></i>ویژگی های ایده</div>
            <ul>
              <li><span class="name">دسته بندی</span><span class="desc">{{$idea->category?->title}}</span></li>
              <li><span class="name">کف سرمایه</span><span class="desc">{{number_format($idea->minimal_fund)}} تومان</span></li>
              <li><span class="name">ریسک</span><span class="desc">{{$idea->risk}}</span></li>
              <li><span class="name">سودآوری</span><span class="desc">{{$idea->profitability}}</span></li>
              <li><span class="name">نیروی انسانی</span><span class="desc">{{$idea->manpower}} </span></li>
              <li><span class="name">مقیاس</span><span class="desc">{{$idea->scale}}</span></li>
            </ul>
          </div>
          <div class="myalert alert-info">
            <div class="icon"><i class="mdi mdi-alert-outline"></i></div>
            <div class="text">نکته: توضیحات و ویژگی های ایده خصوصا مبلغ کف سرمایه برای تاریخ {{$idea->registe_date}} می باشد و مبلغ کف سرمایه با توجه به نرخ تورم افزایش دارد.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="main-list-content">
  <div class="container" id="resultSearch"></div>
</div>

<!-- ایده های های مشابه -->
@if(count($related_ideas) > 0)
<div class="education-section">
  <div class="container">
    <div class="title">
      <div class="title-inner">
        <div class="shape"></div>
        <h1>ایده‌های مشابه</h1>
      </div>
      <div class="see-more">
        <a href="{{url('wikiidea/cat/getAllCat')}}">
          <span class="text">مشاهده همه</span>
          <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
        </a>
      </div>
    </div>
    <div class="section-inner">
      <div class="swiper swiper-workshop" dir="rtl">
        <div class="swiper-wrapper">
          @foreach($related_ideas as $midea)
          <div class="swiper-slide">
            <div class="card-teammate">
              <div class="card-inner">
                <a href="{{url('wikiidea/details/' . $midea->id)}}">
                  <figure class="idea-pic">
                    <div class="img-inner">
                      <img src="_upload_/_wikiideas_/{{$midea->code}}/medium_{{$midea->image}}" alt="{{$midea->title}}" />
                    </div>
                  </figure>
                  <div class="user-pic">
                    @if($midea->writer && $midea->writer->code && $midea->writer->image)
                    <img src="_upload_/_users_/{{$midea->writer->code}}/personal/{{$midea->writer->image}}" alt="{{$midea->writer->name}}" />
                    @endif
                  </div>
                  <div class="card-b">
                    <h1>{{$midea->title}}</h1>
                    <ul>
                      <li><span>دسته بندی : </span>{{$midea->category->title}}</li>
                      <li><span>ریسک : </span>{{$midea->risk}}</li>
                      <li><span>سودآوری : </span>{{$midea->profitability}}</li>
                    </ul>
                  </div>
                  <div class="card-f">
                    <ul class="status-list">
                      <li><i class="mdi mdi-eye-outline"></i>{{$midea->view_count != null ? $midea->view_count : 0}}</li>
                      <li><i class="mdi mdi-heart-outline"></i>{{$midea->like_count != null ? $midea->like_count : 0}}</li>
                    </ul>
                  </div>
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <!-- Add Options -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </div>
  </div>
</div>
@endif

<div class="modal fade" id="modal-sendcomments" tabindex="-1" aria-labelledby="modal-sendcomments-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-sendcomments-title">ارسال نظر</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-send-comment">
          <div class="range-card-body">
            <label class="range-label">امتیاز شما به ایده</label>
            <div class="range-inner">
              <div class="rate-range"></div>
              <div id="commentRange" class="value-range"></div>
            </div>
          </div>
          <div class="textarea-group">
            <textarea id="commentTextarea" class="textarea" cols="30" rows="4" placeholder="نظر خود را بنویسید..." required></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-grey" data-bs-dismiss="modal">انصراف</button>
        <button id="storeComment" type="button" class="btn btn-green">ارسال</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('Page_JS')

<script>
  idea_id = {
    {
      $idea - > id
    }
  };

  //first search
  $(document).ready(function() {
    _search_detail(1);
  });

  //pagination BtnPage
  $(document).on("click", '#paginationBtnPage', function() {
    var id = $(this).data('id');
    _search_detail(id);
  });
</script>

@endsection
