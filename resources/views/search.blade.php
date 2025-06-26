@extends('layouts.front-master')

@section('Page_Title')
    کسب بوم - جستجوی دوره های آموزشی
@endsection

@section('Page_CSS_Before')
    <!-- Jquery ui RangeSlider css -->
    <link href="/assets/plugins/jquery-uislider/jquery-ui.css" rel="stylesheet">

    <link href="/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />
@endsection

@section('Page_CSS_After')
    <!-- Jquery ui RangeSlider css -->
    <link href="/assets/plugins/jquery-uislider/jquery-ui.css" rel="stylesheet">

    <link href="/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />
@endsection

@section('SliderDiv')
    <div class="cover-image bg-background" data-image-src="/assets/images/banners/banner1.jpg">
@endsection


@section('Content')

    <!--Section-->
        <div>
            <div class="sptb-1">
                <div class="header-text1 mb-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-9 col-lg-12 col-md-12 d-block mx-auto">
                                <div class="text-center text-white text-property">
                                    <h1 class="" style="font-family: VazirBold">جستجوی دوره آموزشی</h1>
                                </div>
                                <div class="search-background bg-transparent">
                                    <form action="search_course" method="post">
                                        {{ csrf_field() }}
                                        <div class="search-background bg-transparent typewrite-text">
                                            <div class="row">
                                                <div class="col-xl-10 col-lg-12 col-md-12 d-block mx-auto">
                                                    <div class="form row no-gutters ">
                                                        <div class="form-group col-xl-4 col-lg-3 col-md-12 select2-lg br-tl-3 br-bl-3 mb-0 bg-white">
                                                            <select class="form-control select2-show-search  border-bottom-0" name="category" id="category" data-placeholder="انتخاب دسته بندی">
                                                                <optgroup label="موضوعات">
                                                                    <option value="0">انتخاب دسته بندی</option>
                                                                    <option value="0">همه گروه ها</option>
                                                                    @foreach($cats as $cat)
                                                                        <option value="{{$cat->id}}">{{$cat->title}}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <div class="form-group  col-xl-6 col-lg-6 col-md-12 mb-0 bg-white ">
                                                            <input type="text" class="form-control input-lg" required maxlength="50" id="course_name" name="course_name" placeholder="بخشی از عنوان دوره آموزشی را وارد نمائید">
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-12 mb-0">
                                                            <button type="submit" class="btn btn-lg btn-block btn-primary br-tl-md-0 br-bl-md-0">جستجو</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /header-text -->
            </div>
        </div><!--/Section-->
    </div><!--/Section-->



@endsection


@section('Page_JS')
    <!-- Ion.RangeSlider -->
    <script src="/assets/plugins/jquery-uislider/jquery-ui.js"></script>

@endsection
