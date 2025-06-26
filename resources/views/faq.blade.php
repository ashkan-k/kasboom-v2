@extends('layouts.front-master')

@section('Page_Title')
کسب بوم - سوالات متداول
@endsection

@section('Page_CSS')

@endsection

@section('Content')

<!-- Page Background -->
<div class="page-background">
  <div class="text">
    <div class="text-inner">
      <h2>پرسش های متداول</h2>
      <h6>ما به برخی از سوال‌های متداول شما پاسخ داده‌ایم</h6>
    </div>
  </div>
</div>
<!-- Faqs -->
<div class="faqs-page">
  <div class="container">
    <div class="list-of-faqs">
      <div class="faq-search">
        <div class="search-group">
          <input type="text" class="input" placeholder="جستجو در سوالات متداول">
          <span class="icon"><i class="mdi mdi-magnify"></i></span>
        </div>
      </div>

      <!-- Faq Item -->
      @foreach($faqs as $faq)
      <div class="faq-item-collapse">
        <div class="item-header">
          <a class="link collapsed" data-bs-toggle="collapse" href="#faq-collapsed-{{$faq->id}}" role="button" aria-expanded="false" aria-controls="faq-collapsed-{{$faq->id}}">
            {{$faq->question}}
            @if($faq->isvideo ==1)
            (ویدئو)
            @endif
            <div class="icon"><i class="mdi mdi-chevron-down"></i></div>
          </a>
        </div>
        <div class="collapse" id="faq-collapsed-{{$faq->id}}">
          <div class="card-faq">
            @if($faq->isvideo ==1)
            <div class="card-media">
              <div class="media-inner">
                <iframe style="width: 100%;height: 400px" src="{{$faq->url}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
              </div>
            </div>
            @endif

            {!! $faq->answer !!}

          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

@endsection


@section('Page_JS')

@endsection
