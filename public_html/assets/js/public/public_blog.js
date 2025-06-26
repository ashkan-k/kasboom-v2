var blog_results="";
var blog_results_id=[];
var blog_id=0;
var blog_title="";
var blog_price=0;

$("#btn_search_blogs").click(function (){

    var blog_title=$("#blog_title").val();

    let formDataa = new FormData();
    formDataa.append('blog_title', blog_title);
    if(blog_title.length<2)
        ShowMessage('مقار مناسبی جهت جستجو وارد نمائید', 'error');
    else {
        $.ajax({
            url: "blogs/search_blog_ajax",
            type: 'POST',
            cache: false,
            data: formDataa,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            beforeSend: function () {
                ShowWaiting("جستجوی مطلب آموزشی");
            },
            success: function (result) {
                if (!result.error) {
                    $("#tab-11").empty();
                    // var obj = JSON.parse(json.responseText);
                    course_results=result.data;
                    var courses = result.data;
                    var course="";
                    var coursediv='';
                    $("#result_info").text(" تعداد مطالب مرتبط" +courses.length +"  مورد  ");
                    course_results_id=[];
                    for (var i=0;i<courses.length;i=i+1) {
                        course=courses[i];
                        course_results_id.push(course['id']);
                        var course_title=course['title'];
                        course_title=course_title.replace(/ /g,'_');
                        coursediv="";
                        coursediv+=`<div class="col-xl-4 col-lg-4 col-md-4">`;
                        coursediv+=`<div class="card"><div class="item7-card-img">`;
                        coursediv+=`<a href="blogs/blog/`+course['id']+`/`+course_title+`"></a>`;
                        coursediv+=`<img src="_upload_/_blogs_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
                        coursediv+=`<div class="item7-card-text">`;
                        coursediv+=`<span class="badge badge-info">`+course['category']['title']+`</span>`;
                        coursediv+=`</div></div>`;
                        coursediv+=`<div class="card-body" style="height: 130px;!important;">`;
                        coursediv+=`<div class="item7-card-desc d-flex mb-2">`;
                        coursediv+=`<a class="text-muted IRANSansWeb_Light" style="font-size: x-small"><i class="fa fa-calendar-o ml-1"></i>`+course['regist_date']+`</a>`;
                        coursediv+=`<div class="mr-auto">`;
                        coursediv+=`<a class="text-muted IRANSansWeb_Light" style="font-size: x-small"><i class="fa fa-comment-o ml-1"></i>`+course['comment_count']+`</a>`;
                        coursediv+=`<a class="text-muted IRANSansWeb_Light" style="font-size: x-small"><i class="fa fa-eye ml-1"></i>`+course['view_count']+`</a>`;
                        coursediv+=`</div></div>`;
                        coursediv+=`<a href="blogs/blog/`+course['id']+`/`+course_title+`" class="text-dark" style="font-family: VazirThin">`+course['title']+`</a>`;
                        coursediv+=` </div><div class="card-footer"><div class="item-card2-footer text-left">`;
                        coursediv+=`<a href="blogs/blog/`+course['id']+`/`+course_title+`" class="btn btn-primary btn-sm text-white">مطالعه</a>`;
                        coursediv+=`</div></div></div></div>`;
                        $("#tab-11").append(coursediv);
                    }

                    // var ratingOptions = {
                    //     selectors: {
                    //         starsSelector: '.rating-stars',
                    //         starSelector: '.rating-star',
                    //         starActiveClass: 'is--active',
                    //         starHoverClass: 'is--hover',
                    //         starNoHoverClass: 'is--no-hover',
                    //         targetFormElementSelector: '.rating-value'
                    //     }
                    // };
                    // $(".rating-stars").ratingStars(ratingOptions);

                    $("#paginate").hide();
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


function filterCategory(id_cat) {
    let formDataa = new FormData();
    formDataa.append('id_cat', id_cat);
    $.ajax({
        url: "blogs/search_blog_category_ajax",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("جستجوی مطالب  گروه آموزشی ");
        },
        success: function (result) {
            if (!result.error) {
                $("#tab-11").empty();
                // var obj = JSON.parse(json.responseText);
                course_results=result.data;
                var courses = result.data;
                var course="";
                var coursediv='';
                $("#result_info").text(" تعداد مطالب گروه آموزشی: " +courses.length +"  مورد  ");
                course_results_id=[];
                for (var i=0;i<courses.length;i=i+1) {
                    course=courses[i];
                    course_results_id.push(course['id']);
                    var course_title=course['title'];
                    course_title=course_title.replace(/ /g,'_');
                    coursediv="";
                    coursediv+=`<div class="col-xl-4 col-lg-4 col-md-4">`;
                    coursediv+=`<div class="card"><div class="item7-card-img">`;
                    coursediv+=`<a href="blogs/blog/`+course['id']+`/`+course_title+`"></a>`;
                    coursediv+=`<img src="_upload_/_blogs_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
                    coursediv+=`<div class="item7-card-text">`;
                    coursediv+=`<span class="badge badge-info">`+course['category']['title']+`</span>`;
                    coursediv+=`</div></div>`;
                    coursediv+=`<div class="card-body" style="height: 130px;!important;">`;
                    coursediv+=`<div class="item7-card-desc d-flex mb-2">`;
                    coursediv+=`<a class="text-muted IRANSansWeb_Light" style="font-size: x-small"><i class="fa fa-calendar-o ml-1"></i>`+course['regist_date']+`</a>`;
                    coursediv+=`<div class="mr-auto">`;
                    coursediv+=`<a class="text-muted IRANSansWeb_Light" style="font-size: x-small"><i class="fa fa-comment-o ml-1"></i>`+course['comment_count']+`</a>`;
                    coursediv+=`<a class="text-muted IRANSansWeb_Light" style="font-size: x-small"><i class="fa fa-eye ml-1"></i>`+course['view_count']+`</a>`;
                    coursediv+=`</div></div>`;
                    coursediv+=`<a href="blogs/blog/`+course['id']+`/`+course_title+`" class="text-dark" style="font-family: VazirThin">`+course['title']+`</a>`;
                    coursediv+=` </div><div class="card-footer"><div class="item-card2-footer text-left">`;
                    coursediv+=`<a href="blogs/blog/`+course['id']+`/`+course_title+`" class="btn btn-primary btn-sm text-white">مطالعه</a>`;
                    coursediv+=`</div></div></div></div>`;
                    $("#tab-11").append(coursediv);
                }

                // var ratingOptions = {
                //     selectors: {
                //         starsSelector: '.rating-stars',
                //         starSelector: '.rating-star',
                //         starActiveClass: 'is--active',
                //         starHoverClass: 'is--hover',
                //         starNoHoverClass: 'is--no-hover',
                //         targetFormElementSelector: '.rating-value'
                //     }
                // };
                // $(".rating-stars").ratingStars(ratingOptions);

                $("#paginate").hide();
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
        url: "blogs/search_blog_writer_ajax",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("جستجوی مطالب آموزشی نویسنده");
        },
        success: function (result) {
            if (!result.error) {
                $("#tab-11").empty();
                // var obj = JSON.parse(json.responseText);
                course_results=result.data;
                var courses = result.data;
                var course="";
                var coursediv='';
                $("#result_info").text(" تعداد مطالب نویسنده: " +courses.length +"  مورد  ");
                course_results_id=[];
                for (var i=0;i<courses.length;i=i+1) {
                    course=courses[i];
                    course_results_id.push(course['id']);
                    var course_title=course['title'];
                    course_title=course_title.replace(/ /g,'_');
                    coursediv="";
                    coursediv+=`<div class="col-xl-4 col-lg-12 col-md-12">`;
                    coursediv+=`<div class="card"><div class="item7-card-img">`;
                    coursediv+=`<a href="blogs/blog/`+course['id']+`/`+course_title+`"></a>`;
                    coursediv+=`<img src="_upload_/_blogs_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
                    coursediv+=`<div class="item7-card-text">`;
                    coursediv+=`<span class="badge badge-info">`+course['category']['title']+`</span>`;
                    coursediv+=`</div></div>`;
                    coursediv+=`<div class="card-body" style="height: 130px;!important;">`;
                    coursediv+=`<div class="item7-card-desc d-flex mb-2">`;
                    coursediv+=`<a class="text-muted IRANSansWeb_Light" style="font-size: x-small"><i class="fa fa-calendar-o ml-1"></i>`+course['regist_date']+`</a>`;
                    coursediv+=`<div class="mr-auto">`;
                    coursediv+=`<a class="text-muted IRANSansWeb_Light" style="font-size: x-small"><i class="fa fa-comment-o ml-1"></i>`+course['comment_count']+`</a>`;
                    coursediv+=`<a class="text-muted IRANSansWeb_Light" style="font-size: x-small"><i class="fa fa-eye ml-1"></i>`+course['view_count']+`</a>`;
                    coursediv+=`</div></div>`;
                    coursediv+=`<a href="blogs/blog/`+course['id']+`/`+course_title+`" class="text-dark" style="font-family: VazirThin">`+course['title']+`</a>`;
                    coursediv+=` </div><div class="card-footer"><div class="item-card2-footer text-left">`;
                    coursediv+=`<a href="blogs/blog/`+course['id']+`/`+course_title+`" class="btn btn-primary btn-sm text-white">مطالعه</a>`;
                    coursediv+=`</div></div></div></div>`;
                    $("#tab-11").append(coursediv);
                }

                // var ratingOptions = {
                //     selectors: {
                //         starsSelector: '.rating-stars',
                //         starSelector: '.rating-star',
                //         starActiveClass: 'is--active',
                //         starHoverClass: 'is--hover',
                //         starNoHoverClass: 'is--no-hover',
                //         targetFormElementSelector: '.rating-value'
                //     }
                // };
                // $(".rating-stars").ratingStars(ratingOptions);

                $("#paginate").hide();
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