var course_results="";
var course_results_id=[];

$("#btn_search_news").click(function (){

    var news_title=$("#news_title").val();

    let formDataa = new FormData();
    formDataa.append('news_title', news_title);
    if(news_title.length<2)
        ShowMessage('مقار مناسبی جهت جستجو وارد نمائید', 'error');
    else {
        $.ajax({
            url: "news/search_news_ajax",
            type: 'POST',
            cache: false,
            data: formDataa,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            beforeSend: function () {
                ShowWaiting("جستجوی خبر");
            },
            success: function (result) {
                if (!result.error) {
                    $("#tab-11").empty();
                    // var obj = JSON.parse(json.responseText);
                    course_results=result.data;
                    var courses = result.data;
                    var course="";
                    var coursediv='';
                    $("#result_info").text(" تعداد اخبار مرتبط: " +courses.length +"  مورد  ");
                    course_results_id=[];
                    for (var i=0;i<courses.length;i=i+1) {
                        course=courses[i];
                        course_results_id.push(course['id']);
                        var course_title=course['title'];
                        course_title=course_title.replace(/ /g,'_');
                        coursediv="";
                        coursediv+=`<div class="col-xl-4 col-lg-12 col-md-12">`;
                        coursediv+=`<div class="card"><div class="item7-card-img">`;
                        coursediv+=`<a href="idea/`+course['id']+`/`+course_title+`"></a>`;
                        coursediv+=`<img src="_upload_/_news_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
                        coursediv+=`<div class="item7-card-text">`;
                        coursediv+=`<span class="badge badge-success">`+course['category']['title']+`</span>`;
                        coursediv+=`</div></div>`;
                        coursediv+=`<div class="card-body" style="height: 160px;!important;">`;
                        coursediv+=`<div class="item7-card-desc d-flex mb-2">`;
                        coursediv+=`<a class="text-muted IRANSansWeb_Light fs-12"><i class="fa fa-calendar-o ml-2"></i>`+course['regist_date']+`</a>`;
                        coursediv+=`<div class="mr-auto">`;
                        coursediv+=`<a class="text-muted IRANSansWeb_Light fs-12"><i class="fa fa-comment ml-2"></i>`+course['comment_count']+`</a>`;
                        coursediv+=`</div></div>`;
                        coursediv+=`<a href="news/`+course['id']+`/`+course_title+`" class="text-dark IRANSansWeb_Light">`+course['title']+`</a>`;
                        coursediv+=`<p >  </p>`;
                        coursediv+=`<a href="news/`+course['id']+`/`+course_title+`" class="btn btn-primary btn-sm" style="float:left;">مطالعه </a>`;
                        coursediv+=`</div></div></div>`;
                        $("#tab-11").append(coursediv);
                    }

                    var ratingOptions = {
                        selectors: {
                            starsSelector: '.rating-stars',
                            starSelector: '.rating-star',
                            starActiveClass: 'is--active',
                            starHoverClass: 'is--hover',
                            starNoHoverClass: 'is--no-hover',
                            targetFormElementSelector: '.rating-value'
                        }
                    };
                    $(".rating-stars").ratingStars(ratingOptions);

                    $("#sortselect").prop( "disabled", false );
                }
                else
                    ShowMessage(result.message, result.type);
            },
            complete: function () {
                CloseWaiting();
            },
            error: function () {
                ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
            }
        });
    }
});

$('#sortselect').on('change', function() {
    var course="";
    var coursediv="";

    if(this.value=="new"){
        $("#tab-11").empty();
        course_results_id.sort(function(a, b) {return a + 2 * b;});
        for (var i=0;i<course_results_id.length;i=i+1) {
            var id=course_results_id[i];
            var course = course_results.find(course => course.id === id);
            var course_title=course['title'];
            course_title=course_title.replace(/ /g,'_');
            coursediv="";
            coursediv+=`<div class="col-xl-4 col-lg-12 col-md-12">`;
            coursediv+=`<div class="card"><div class="item7-card-img">`;
            coursediv+=`<a href="idea/`+course['id']+`/`+course_title+`"></a>`;
            coursediv+=`<img src="_upload_/_news_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
            coursediv+=`<div class="item7-card-text">`;
            coursediv+=`<span class="badge badge-success">`+course['category']['title']+`</span>`;
            coursediv+=`</div></div>`;
            coursediv+=`<div class="card-body" style="height: 160px;!important;">`;
            coursediv+=`<div class="item7-card-desc d-flex mb-2">`;
            coursediv+=`<a class="text-muted IRANSansWeb_Light fs-12"><i class="fa fa-calendar-o ml-2"></i>`+course['regist_date']+`</a>`;
            coursediv+=`<div class="mr-auto">`;
            coursediv+=`<a class="text-muted IRANSansWeb_Light fs-12"><i class="fa fa-comment ml-2"></i>0 نظر</a>`;
            coursediv+=`</div></div>`;
            coursediv+=`<a href="news/`+course['id']+`/`+course_title+`" class="text-dark IRANSansWeb_Light" >`+course['title']+`</a>`;
            coursediv+=`<p >  </p>`;
            coursediv+=`<a href="news/`+course['id']+`/`+course_title+`" class="btn btn-primary btn-sm" style="float:left;">مطالعه </a>`;
            coursediv+=`</div></div></div>`;
            $("#tab-11").append(coursediv);
        }
    }
    else if( this.value=="old"){
        $("#tab-11").empty();
        course_results_id.sort();
        for (var i=0;i<course_results_id.length;i=i+1) {
            var id=course_results_id[i];
            var course = course_results.find(course => course.id === id);
            var course_title=course['title'];
            coursediv="";
            coursediv+=`<div class="col-xl-4 col-lg-12 col-md-12">`;
            coursediv+=`<div class="card"><div class="item7-card-img">`;
            coursediv+=`<a href="idea/`+course['id']+`/`+course_title+`"></a>`;
            coursediv+=`<img src="_upload_/_news_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
            coursediv+=`<div class="item7-card-text">`;
            coursediv+=`<span class="badge badge-success">`+course['category']['title']+`</span>`;
            coursediv+=`</div></div>`;
            coursediv+=`<div class="card-body" style="height: 160px;!important;">`;
            coursediv+=`<div class="item7-card-desc d-flex mb-2">`;
            coursediv+=`<a class="text-muted IRANSansWeb_Light fs-12"><i class="fa fa-calendar-o ml-2"></i>`+course['regist_date']+`</a>`;
            coursediv+=`<div class="mr-auto">`;
            coursediv+=`<a class="text-muted IRANSansWeb_Light fs-12"><i class="fa fa-comment ml-2"></i>0 نظر</a>`;
            coursediv+=`</div></div>`;
            coursediv+=`<a href="news/`+course['id']+`/`+course_title+`" class="text-dark IRANSansWeb_Light">`+course['title']+`</a>`;
            coursediv+=`<p >  </p>`;
            coursediv+=`<a href="news/`+course['id']+`/`+course_title+`" class="btn btn-primary btn-sm" style="float:left;">مطالعه </a>`;
            coursediv+=`</div></div></div>`;
            $("#tab-11").append(coursediv);
        }
    }
});

function filterCategory(id_cat) {
    let formDataa = new FormData();
    formDataa.append('id_cat', id_cat);
    $.ajax({
        url: "news/search_news_category_ajax",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("جستجوی اخبار گروه خبری ");
        },
        success: function (result) {
            if (!result.error) {
                $("#tab-11").empty();
                // var obj = JSON.parse(json.responseText);
                course_results=result.data;
                var courses = result.data;
                var course="";
                var coursediv='';
                $("#result_info").text(" تعداد اخبار گروه خبری: " +courses.length +"  مورد  ");
                course_results_id=[];
                for (var i=0;i<courses.length;i=i+1) {
                    course=courses[i];
                    course_results_id.push(course['id']);
                    var course_title=course['title'];
                    course_title=course_title.replace(/ /g,'_');
                    coursediv="";
                    coursediv+=`<div class="col-xl-4 col-lg-12 col-md-12">`;
                    coursediv+=`<div class="card"><div class="item7-card-img">`;
                    coursediv+=`<a href="idea/`+course['id']+`/`+course_title+`"></a>`;
                    coursediv+=`<img src="_upload_/_news_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
                    coursediv+=`<div class="item7-card-text">`;
                    coursediv+=`<span class="badge badge-success">`+course['category']['title']+`</span>`;
                    coursediv+=`</div></div>`;
                    coursediv+=`<div class="card-body" style="height: 160px;!important;">`;
                    coursediv+=`<div class="item7-card-desc d-flex mb-2">`;
                    coursediv+=`<a class="text-muted IRANSansWeb_Light fs-12"><i class="fa fa-calendar-o ml-2"></i>`+course['regist_date']+`</a>`;
                    coursediv+=`<div class="mr-auto">`;
                    coursediv+=`<a class="text-muted IRANSansWeb_Light fs-12"><i class="fa fa-comment ml-2"></i>`+course['comment_count']+`</a>`;
                    coursediv+=`</div></div>`;
                    coursediv+=`<a href="news/`+course['id']+`/`+course_title+`" class="text-dark IRANSansWeb_Light">`+course['title']+`</a>`;
                    coursediv+=`<p >  </p>`;
                    coursediv+=`<a href="news/`+course['id']+`/`+course_title+`" class="btn btn-primary btn-sm" style="float:left;">مطالعه </a>`;
                    coursediv+=`</div></div></div>`;
                    $("#tab-11").append(coursediv);
                }

                var ratingOptions = {
                    selectors: {
                        starsSelector: '.rating-stars',
                        starSelector: '.rating-star',
                        starActiveClass: 'is--active',
                        starHoverClass: 'is--hover',
                        starNoHoverClass: 'is--no-hover',
                        targetFormElementSelector: '.rating-value'
                    }
                };
                $(".rating-stars").ratingStars(ratingOptions);

                $("#sortselect").prop( "disabled", false );
            }
            else
                ShowMessage(result.message, result.type);
        },
        complete: function () {
            CloseWaiting();
        },
        error: function () {
            ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
        }
    });
}

function filterWriter(id_writer) {
    let formDataa = new FormData();
    formDataa.append('id_writer', id_writer);
    $.ajax({
        url: "news/search_news_writer_ajax",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("جستجوی اخبار نویسنده");
        },
        success: function (result) {
            if (!result.error) {
                $("#tab-11").empty();
                // var obj = JSON.parse(json.responseText);
                course_results=result.data;
                var courses = result.data;
                var course="";
                var coursediv='';
                $("#result_info").text(" تعداد اخبار نویسنده: " +courses.length +"  مورد  ");
                course_results_id=[];
                for (var i=0;i<courses.length;i=i+1) {
                    course=courses[i];
                    course_results_id.push(course['id']);
                    var course_title=course['title'];
                    course_title=course_title.replace(/ /g,'_');
                    coursediv="";
                    coursediv+=`<div class="col-xl-4 col-lg-12 col-md-12">`;
                    coursediv+=`<div class="card"><div class="item7-card-img">`;
                    coursediv+=`<a href="idea/`+course['id']+`/`+course_title+`"></a>`;
                    coursediv+=`<img src="_upload_/_news_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
                    coursediv+=`<div class="item7-card-text" >`;
                    coursediv+=`<span class="badge badge-success">`+course['category']['title']+`</span>`;
                    coursediv+=`</div></div>`;
                    coursediv+=`<div class="card-body" style="height: 160px;!important;">`;
                    coursediv+=`<div class="item7-card-desc d-flex mb-2">`;
                    coursediv+=`<a class="text-muted IRANSansWeb_Light fs-12"><i class="fa fa-calendar-o ml-2"></i>`+course['regist_date']+`</a>`;
                    coursediv+=`<div class="mr-auto">`;
                    coursediv+=`<a class="text-muted IRANSansWeb_Light fs-12"><i class="fa fa-comment ml-2"></i>`+course['comment_count']+`</a>`;
                    coursediv+=`</div></div>`;
                    coursediv+=`<a href="news/`+course['id']+`/`+course_title+`" class="text-dark IRANSansWeb_Light">`+course['title']+`</a>`;
                    coursediv+=`<p >  </p>`;
                    coursediv+=`<a href="news/`+course['id']+`/`+course_title+`" class="btn btn-primary btn-sm" style="float:left;">مطالعه </a>`;
                    coursediv+=`</div></div></div>`;
                    $("#tab-11").append(coursediv);
                }

                var ratingOptions = {
                    selectors: {
                        starsSelector: '.rating-stars',
                        starSelector: '.rating-star',
                        starActiveClass: 'is--active',
                        starHoverClass: 'is--hover',
                        starNoHoverClass: 'is--no-hover',
                        targetFormElementSelector: '.rating-value'
                    }
                };
                $(".rating-stars").ratingStars(ratingOptions);

                $("#sortselect").prop( "disabled", false );
            }
            else
                ShowMessage(result.message, result.type);
        },
        complete: function () {
            CloseWaiting();
        },
        error: function () {
            ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
        }
    });
}