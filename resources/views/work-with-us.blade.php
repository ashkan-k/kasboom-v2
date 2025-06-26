@extends('layouts.front-master')

@section('Page_Title')
فرصت های شغلی - همکاری با کسب بوم
@endsection

@section('Page_CSS')

@endsection

@section('Content')
<!-- Page Background -->
<div class="page-background">
  <div class="text">
    <div class="text-inner">
      <h2>دعوت به همکاری</h2>
      <h6>فرصت های شغلی جهت همکاری با مجموعه کسب بوم</h6>
    </div>
  </div>
</div>
<!-- Work With Us -->
<div class="public-section pt-4 pb-2">
  <div class="container-lg">
    <div class="section-inner min-width">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="card-wrok-with-us">
            <a href="skill/invite_teacher">
              <img src="/assets/images/banners/contactus.jpg" alt="همکاری با مربی و مدرس" />
            </a>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="card-wrok-with-us">
            <a href="skill/course_suggestion">
              <img src="/assets/images/banners/suggest.jpg" alt="پیشنهاد تولید محتوی" />
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection


@section('Page_JS')
@endsection
