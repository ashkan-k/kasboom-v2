@extends('layouts.front-master')

@section('Page_Title')
    کسب بوم - ویکی ایده
@endsection

@section('Page_CSS_Before')

@endsection

@section('Page_CSS_After')
    <link href="/assets/plugins/jquery-uislider/jquery-ui.css" rel="stylesheet">
@endsection

@section('SliderDiv')
@endsection

@section('Content')

    <section class="container mt-5 p-lg-3">
        <div class="row">
            <div class="col-lg-3 col-md-4 mb-3 leftcol">
                <div class="box p-4 grad-bg text-white"  style="text-align: right">
                    <h5 class="bt-color IRANSansWeb_Medium" style="text-align: right"> <i class="fa fa-filter pl-2"></i>جستجو</h5>
                    <input id="idea_name" class="form-control" type="text" placeholder="عنوان ایده">
                    <button id="btn_search_ajax_wiki" class="btn btn-warning btn-block p-2 text-white">جستجو</button>
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
                    <h5 class="bt-color IRANSansWeb_Medium"><i class="fa fa-user ml-2"></i>ریسک</h5>
                    <div id="skill" class="p-2">
                        <div class="filter-product-checkboxs">
                            <label class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="level1" value="1">
                                <span class="custom-control-label">
										پایین
										</span>
                            </label>
                            <label class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="level2" value="1">
                                <span class="custom-control-label">
											متوسط
										</span>
                            </label>
                            <label class="custom-control custom-checkbox mb-0">
                                <input type="checkbox" class="custom-control-input" id="level3" value="1">
                                <span class="custom-control-label">
											زیاد
										</span>
                            </label>
                            <label class="custom-control custom-checkbox mb-0">
                                <input type="checkbox" class="custom-control-input" id="level4" value="1">
                                <span class="custom-control-label">
											خیلی زیاد
										</span>
                            </label>
                        </div>
                        <ul>
                            <li>
                                <div class="footerimg d-flex">
                                    <div class="d-flex footerimg-l mb-0">
                                        {{--<a onclick="filterWriter({{$writer->id}})" style="cursor:pointer;"  class="time-title p-0 leading-normal mt-0"><img src="_upload_/_users_/{{$writer->id}}/personal/{{$writer->image}}" alt="{{$writer->name}}" class="avatar brround  ml-2"></a>--}}
                                        {{--<a onclick="filterWriter({{$writer->id}})"  style="cursor:pointer;"  class="time-title p-0 leading-normal mt-2">{{$writer->name}} </a>--}}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <h5 class="bt-color IRANSansWeb_Medium"><i class="fa fa-credit-card-alt ml-2"></i>کف سرمایه (تومان)</h5>
                    <div id="skill">
                        <div class="card-body" style="margin: 0;!important;padding: 0">
                            <h6>
                                <input type="text" id="price" class="IRANSansWeb_Medium" style="  background: transparent; border: none;color: white">
                            </h6>
                            <div id="mySlider"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button  class="btn btn-warning btn-block p-2 text-white"  id="btn_filter_ajax_wiki" >اعمال محدودسازی</button>
                    </div>
                </div>

            </div>
            <div class="col-lg-9 col-md-8"  id="tab-row">
                <div class=" mb-0">
                    <div class="p-2 bg-white item2-gl-nav d-flex" style="margin-right: 10px">
                        <h6 class="mb-0 mt-2 IRANSansWeb_Medium" id="result_info">ترتیب نمایش ایده ها</h6>
                        <ul class="nav item2-gl-menu mr-auto">
                            {{--<li class=""><a href="#tab-11" class="active show" data-toggle="tab" title="List style"><i class="fa fa-list"></i></a></li>--}}
                            {{--<li><a href="#tab-12" data-toggle="tab" class="" title="Grid"><i class="fa fa-th"></i></a></li>--}}
                        </ul>
                        <div class="d-flex">
                            <label class="ml-5 mt-1 mb-sm-3" >براساس:</label>
                            <select id="sortselect" class="form-control select-sm w-70" disabled="">
                                <option value="new">جدیدترین ها</option>
                                <option value="old">قدیمی ترین ها</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="tab-11">
                    @foreach($ideas as $idea)
                        <?php $title=str_replace(' ','_',$idea->title); ?>
                        <div class="card overflow-hidden">
                            <div class="d-md-flex">
                                <div class="item-card9-imgs">
                                    <a href="wikiidea/idea/{{$idea->id}}/{{$title}}"></a>
                                    <img src="_upload_/_wikiideas_/{{$idea->code}}/medium_{{$idea->image}}" alt="{{$idea->title}}" class="cover-image" style="width: 100%;height: 100%;">
                                </div>
                                <div class="card-body " style="padding-top: 0;padding-bottom: 0">
                                    <div class="item-card9">
                                        <div class="row">
                                            <div class="col-lg-10 col-sm-12 col-xs-12">
                                                <a href="wikiidea/idea/{{$idea->id}}/{{$title}}" class="text-dark"><h3 class="font-weight-semibold mt-1">{{$idea->title}}</h3></a>
                                                <div class="mt-2 mb-2 " style="font-family: VazirLight">
                                                    <a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>{{$idea->category->title}}</span></a>
                                                    <a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-play text-muted ml-1"></i>ریسک: {{$idea->risk}}</span></a>
                                                    <a  class="ml-4 d-none d-lg-block"><span class="text-muted fs-13"><i class="fa fa-clock-o text-muted ml-1"></i>سودآوری:  {{$idea->profitability}}</span></a>
                                                    <h6 class="IRANSansWeb_Medium"> کف سرمایه: {{number_format($idea->minimal_fund)}} تومان &nbsp;</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <p class="mb-0 fs-14 IRANSansWeb_Light">{{$idea->abstractMemo}}</p>
                                        </div>
                                        <div class="text-left">
                                            <span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">{{$idea->view_count != null ? $idea->view_count : 0}}&nbsp;<i class="fa fa-eye"></i></span>
                                            <span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">{{$idea->like_count != null ? $idea->like_count : 0}}&nbsp;<i class="fa fa-heart"></i></span>
                                            <span class="text-muted IRANSansWeb_Medium">{{$idea->score != null ? $idea->score : 0}}&nbsp;<i class="fa fa-star"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center IRANSansWeb_Medium" id="paginate">
                    <ul class="pagination mt-3 IRANSansWeb_Medium">
                        {{ $ideas->links( "pagination::bootstrap-4") }}
                    </ul>
                </div>

            </div>
        </div>
    </section>




@endsection


@section('Page_JS')

    <script src="assets/plugins/jquery-uislider/jquery-ui.js"></script>


    <script>

        wiki_results="pu";
        wiki_results_id=[];


        var va1l=toPersianDigit(number_format(0));
        var val2=toPersianDigit(number_format(1000000000));

        $( "#mySlider" ).slider({
            range: true,
            min: 0,
            max: 5000000000,
            values: [ 0, 2000000000 ],
            step:500000,
            slide: function( event, ui ) {
                $( "#price" ).val( " بین " + toPersianDigit(number_format(ui.values[ 0 ])) + " تا " + toPersianDigit(number_format(ui.values[ 1 ])) +" تومان ");
            }
        });

        $( "#price" ).val( " بین " +va1l +
            " - " + val2  +" تومان ");



    </script>
@endsection
