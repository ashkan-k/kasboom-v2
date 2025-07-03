@extends('course.master_course')

@section('Page_Title')
    آموزشگاه کسب بوم - وبینارهای آموزشی
@endsection

@section('Page_CSS_Before')


@endsection

@section('Page_CSS_After')

    {{--slider price--}}
    <link href="assets/plugins/jquery-uislider/jquery-ui.css" rel="stylesheet">

    <style>
        @media (max-width:576px) {
            .myitem-card{
                width: 100%;
            }

        }
        @media (min-width:577px) {
            .myitem-card{
                width: 25%;
            }

        }
    </style>
    <link href="assets_consult/Css/Style.css" rel="stylesheet" />

@endsection

@section('SliderDiv')

    @endsection


@section('Content')
    <section class="container mt-5 p-lg-3">
        <div class="row">
            <div class="col-lg-3 col-md-4 mb-3 leftcol">
                <div class="box p-4 grad-bg text-white"  style="text-align: right">
                    <h5 class="bt-color IRANSansWeb_Medium" style="text-align: right"> <i class="fa fa-filter pl-2"></i>جستجو</h5>
                    <input id="course_name" class="form-control" type="text" placeholder="عنوان وبینار">
                    <button id="btn_search_ajax_webinar" class="btn btn-warning btn-block p-2 text-white">جستجو</button>
                </div>
                <br>
                <div class="box p-4 grad-bg text-white"  style="text-align: right">
                    <h5 class="bt-color IRANSansWeb_Medium pb-4"> <i class="fa fa-folder-o pl-2"></i>دسته بندی</h5>
                    <div class="filter-product-checkboxs">
                        @foreach($cats as $cat)
                            @if($cat->item_count>0)
                                <div class="row">
                                    <div class="col-lg-10 col-xs-10 col-sm-10 col-md-10">
                                        <label class="custom-control custom-checkbox" >
                                            <input type="checkbox" class="custom-control-input category"  name="cat_{{$cat->category}}" id="idcat_{{$cat->id}}" value="{{$cat->id}}">
                                            <span class="custom-control-label">
                                                <a class="text-white">{{$cat->title}}</a>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 col-xs-2 col-sm-2 col-md-2 d-none d-lg-block">
                                        <span class="label label-secondary IRANSansWeb_Medium">{{$cat->item_count}}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <hr>

                    <h5 class="bt-color IRANSansWeb_Medium"><i class="fa fa-credit-card-alt ml-2"></i>محدوده هزینه (تومان)</h5>
                    <div id="skill">
                        <div class="card-body IRANSansWeb_Medium" style="margin: 0;!important;padding: 0">
                            <h6>
                                <input type="text" class="IRANSansWeb_Medium"  id="price" style="  background: transparent; border: none;color: white">
                            </h6>
                            <div id="mySlider" class="IRANSansWeb_Medium"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button  class="btn btn-warning btn-block p-2 text-white"  id="btn_filter_ajax_webinar" >اعمال محدودسازی</button>
                    </div>
                </div>

            </div>
            <div class="col-lg-9 col-md-8"  id="tab-row">
                <div class=" mb-0">
                    <div class="p-5 bg-white item2-gl-nav d-flex">
                        <h6 class="mb-0 mt-2 IRANSansWeb_Medium" id="result_info">نمایش آخرین وبینارهای آموزشی</h6>
                        <ul class="nav item2-gl-menu mr-auto">
                        </ul>
                        <div class="d-flex">
                            <label class="ml-5 mt-1 mb-sm-3" >ترتیب:</label>
                            <select id="sortselect_webinar" class="form-control select-sm w-70" disabled="">
                                <option value="new">جدیدترین ها</option>
                                <option value="old">قدیمی ترین ها</option>
                                <option value="free">رایگان</option>
                                <option value="dontfree">غیر رایگان</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="tab-11">
                    @foreach($webinars as $webinar)
                        <?php $title=str_replace(' ','_',$webinar->title); ?>
                        <div class="card overflow-hidden" style="border-radius: 15px">
                            <div class="d-md-flex">
                                <div class="item-card9-imgs myitem-card" {{--style="width: 25%;"--}}>
                                    <a href="skill/webinar/intro/{{$webinar->id}}/{{$title}}"></a>
                                    <img src="_upload_/_webinars_/{{$webinar->code}}/medium_{{$webinar->image}}" alt="{{$webinar->title}}" class="cover-image" style="width: 100%;height: 100%;">
                                </div>
                                <div class="card-body " style="padding-top: 0;padding-bottom: 0">
                                    <div class="item-card9">
                                        <div class="row">
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                                <a href="skill/webinar/intro/{{$webinar->id}}/{{$title}}" class="text-dark"><h3 class="font-weight mt-1">{{$webinar->title}}</h3></a>
                                                <div class="mt-2 mb-2" style="font-family: VazirLight">
                                                    <a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>{{$webinar->category->title}}</span></a>
                                                    <a href="teacher/profile/{{$webinar->id_teacher}}/{{str_replace(" ","_",$webinar->teacher_name)}}" title="مشاهده پروفایل مدرس" class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-user text-muted ml-1"></i>{{$webinar->teacher_name}}</span></a>
                                                    <br class="mobile-hidden">
                                                    <a  class="ml-4"><span class="text-muted fs-13 IRANSansWeb_Light"><i class="fa fa-calendar text-muted ml-1"></i>{{$webinar->webinar_start_time_minutes}} : {{$webinar->webinar_start_time_hour}} - {{$webinar->webinar_date}}</span></a>
                                                    <p class="mb-0 fs-14">{{$webinar->abstractMemo}}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-3 col-xs-3 col-md-3 float-left text-left">
                                                <br>
                                                    <span class="old_price text-muted fs-16 IRANSansWeb_Light" >
                                                        {{number_format($webinar->old_price)}} <small class="fs-10"> تومان</small> </span> </span>
                                                    <span class="bg-red text-white fs-13 IRANSansWeb_Light p-1" style="border-radius: 10px">% {{$webinar->discount}}  </span>
                                                <br>
                                                <a  class="ml-4 text-danger">
                                                    <span class="fs-20 text-danger  IRANSansWeb_Bold">
                                                        @if($webinar->price==0)
                                                            رایگان
                                                        @else
                                                            {{number_format($webinar->price)}}<small class="fs-10"> تومان</small>
                                                        @endif
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                        <br class="hidden_mobile">
                                        <div class="text-left">
                                            <span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">{{$webinar->view_count != null ? $webinar->view_count : 0}}&nbsp;<i class="fa fa-eye"></i></span>
                                            <span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">{{$webinar->register_count != null ? $webinar->register_count : 0}}&nbsp;<i class="fa fa-users"></i></span>
                                            <span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">{{$webinar->like_count != null ? $webinar->like_count : 0}}&nbsp;<i class="fa fa-heart"></i></span>
                                            <span class="text-muted IRANSansWeb_Light">{{$webinar->score != null ? $webinar->score : 0}}&nbsp;<i class="fa fa-star"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center" id="paginate">
                    <ul class="pagination mt-3 IRANSansWeb_Medium">
                        {{ $webinars->links( "pagination::bootstrap-4") }}
                    </ul>
                </div>

            </div>
        </div>
    </section>



@endsection


@section('Page_JS')

    <script src="assets/plugins/jquery-uislider/jquery-ui.js"></script>


    <script>

        var va1l=toPersianDigit(number_format(0));
        var val2=toPersianDigit(number_format(500000));
        $( "#mySlider" ).slider({
            range: true,
            min: 0,
            max: 1000000,
            values: [ 0, 500000 ],
            step:10000,

            slide: function( event, ui ) {

                $( "#price" ).val( " بین " +toPersianDigit(number_format(ui.values[ 0 ])) + " تا " + toPersianDigit(number_format(ui.values[ 1 ]))  +" تومان ");

            }
        });

        $( "#price" ).val( " بین " +va1l +
            " - " +val2 +" تومان " );




    </script>
@endsection
