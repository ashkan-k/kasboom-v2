var wiki_results="";
var wiki_results_id=[];
var wiki_id=0;
var wiki_title="";
var wiki_price=0;


$("#btn_search_ajax_wiki").click(function (){

    var idea_name=$("#idea_name").val();

    let formDataa = new FormData();
    formDataa.append('idea_name', idea_name);
    if(idea_name.length<2)
        ShowMessage('مقار مناسبی جهت جستجو وارد نمائید', 'error');
    else {
        $.ajax({
            url: "wikiidea/search_idea_ajax",
            type: 'POST',
            cache: false,
            data: formDataa,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            beforeSend: function () {
                ShowWaiting("جستجوی ایده کسب و کار");
            },
            success: function (result) {
                // console.log(result);
                if (!result.error) {
                    $("#tab-11").empty();
                    // var obj = JSON.parse(json.responseText);
                    wiki_results=result.data;
                    var courses = result.data;
                    var course="";
                    var coursediv='';
                    $("#result_info").text(" تعداد ایده های کسب و کار " +courses.length +"  مورد  ");
                    wiki_results_id=[];
                    for (var i=0;i<courses.length;i=i+1) {
                        coursediv='<div class="card overflow-hidden">';
                        course=courses[i];
                        wiki_results_id.push(course['id']);
                        var course_title=course['title'];
                        if(course_title != null)
                          course_title=course_title.replace(/ /g,'_');
                        coursediv+=`<div class="d-md-flex"><div class=""><div class="item-card9-imgs">`;
                        coursediv+=`<a href="wikiidea/idea/`+course['id']+`/`+course_title+`"></a>`;
                        coursediv+=`<img src="_upload_/_wikiideas_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
                        coursediv+=`</div></div><div class="">`;
                        coursediv+=`<div class="card-body " style="padding-top: 0;padding-bottom: 0"><div class="item-card9"><div class="row"><div class="col-lg-10 col-sm-12 col-xs-12">`;
                        coursediv+=`<a href="wikiidea/idea/`+course['id']+`/`+course_title+`" class="text-dark"><h3 class="font-weight-semibold mt-1">`+course['title']+`</h3></a>`;
                        coursediv+=`<div class="mt-2 mb-2" style="font-family: VazirLight">`;
                        coursediv+=`<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>`+course['category']['title']+`</span></a>`;
                        coursediv+=`<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-play text-muted ml-1"></i>ریسک: `+course['risk']+`</span></a>`;
                        coursediv+=`<a  class="ml-4"><span class="text-muted fs-13"><i class="fa fa-clock-o text-muted ml-1"></i>سودآوری: `+ course['profitability']+`</span></a>`;
                        coursediv+=`<h6 class="IRANSansWeb_Medium"> کف سرمایه: `+ number_format(course['minimal_fund'])+ `&nbsp; تومان </h6>`;
                        coursediv+=`</div></div></div>`;
                        coursediv+=`<div class="row">`;
                        coursediv+=`<p class="mb-0 fs-14 IRANSansWeb_Light">`+ course['abstractMemo']+ `</p>`;
                        coursediv+=`</div>`;
                        coursediv+=`<div class="text-left">`;
                        coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['view_count']+ ` &nbsp;<i class="fa fa-eye"></i></span>`;
                        coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['like_count']+ ` &nbsp;<i class="fa fa-heart"></i></span>`;
                        coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['score']+ `&nbsp;<i class="fa fa-star"></i></span>`;
                        coursediv+=`</div></div></div></div></div>`;
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

$("#btn_filter_ajax_wiki").click(function (){

    var min_price = $("#mySlider").slider("values")[0];
    var max_price = $("#mySlider").slider("values")[1];
    var cats = $('.category:checkbox:checked').map(function() {
        return this.value;
    }).get();


    var level1=0;
    var level2=0;
    var level3=0;
    var level4=0;
    if ($('#level1').is(":checked"))
        level1=1;
    if ($('#level2').is(":checked"))
        level2=1;
    if ($('#level3').is(":checked"))
        level3=1;
    if ($('#level4').is(":checked"))
        level4=4;
    let formDataa = new FormData();
    formDataa.append('min_price', min_price);
    formDataa.append('max_price', max_price);
    formDataa.append('cats', cats);
    formDataa.append('level1', level1);
    formDataa.append('level2', level2);
    formDataa.append('level3', level3);
    formDataa.append('level4', level4);
    $.ajax({
        url: "wikiidea/filter_idea_ajax",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("محدودسازی ایده های کسب و کار");
        },
        success: function (result) {
            // console.log(result);
            if (!result.error) {
                $("#tab-11").empty();
                // var obj = JSON.parse(json.responseText);
                wiki_results=result.data;
                var courses = result.data;
                var course="";
                var coursediv='';
                $("#result_info").text(" تعداد ایده های کسب و کار " +courses.length +"  مورد  ");
                wiki_results_id=[];
                for (var i=0;i<courses.length;i=i+1) {
                    coursediv='<div class="card overflow-hidden">';
                    course=courses[i];
                    wiki_results_id.push(course['id']);
                    var course_title=course['title'];
                    if(course_title != null)
                      course_title=course_title.replace(/ /g,'_');
                    coursediv+=`<div class="d-md-flex"><div class=""><div class="item-card9-imgs">`;
                    coursediv+=`<a href="wikiidea/idea/`+course['id']+`/`+course_title+`"></a>`;
                    coursediv+=`<img src="_upload_/_wikiideas_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
                    coursediv+=`</div></div><div class="">`;
                    coursediv+=`<div class="card-body " style="padding-top: 0;padding-bottom: 0"><div class="item-card9"><div class="row"><div class="col-lg-10 col-sm-12 col-xs-12">`;
                    coursediv+=`<a href="wikiidea/idea/`+course['id']+`/`+course_title+`" class="text-dark"><h3 class="font-weight-semibold mt-1">`+course['title']+`</h3></a>`;
                    coursediv+=`<div class="mt-2 mb-2" style="font-family: VazirLight">`;
                    coursediv+=`<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>`+course['category']['title']+`</span></a>`;
                    coursediv+=`<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-play text-muted ml-1"></i>ریسک: `+course['risk']+`</span></a>`;
                    coursediv+=`<a  class="ml-4"><span class="text-muted fs-13"><i class="fa fa-clock-o text-muted ml-1"></i>سودآوری: `+ course['profitability']+`</span></a>`;
                    coursediv+=`<h6 class="IRANSansWeb_Medium"> کف سرمایه: `+ number_format(course['minimal_fund'])+ `&nbsp; تومان </h6>`;
                    coursediv+=`</div></div></div>`;
                    coursediv+=`<div class="row">`;
                    coursediv+=`<p class="mb-0 fs-14 IRANSansWeb_Light">`+ course['abstractMemo']+ `</p>`;
                    coursediv+=`</div>`;
                    coursediv+=`<div class="text-left">`;
                    coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['view_count']+ ` &nbsp;<i class="fa fa-eye"></i></span>`;
                    coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['like_count']+ ` &nbsp;<i class="fa fa-heart"></i></span>`;
                    coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['score']+ `&nbsp;<i class="fa fa-star"></i></span>`;
                    coursediv+=`</div></div></div></div></div>`;
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

    // var cats=document.getElementsByClassName('category');
});

$('#sortselect').on('change', function() {
    var course="";
    var coursediv="";

    if(this.value=="new"){
        $("#tab-11").empty();
        wiki_results_id.sort(function(a, b) {return a + 2 * b;});
        console.log(wiki_results_id);
        for (var i=0;i<wiki_results_id.length;i=i+1) {
            var id=wiki_results_id[i];
            var course = wiki_results.find(course => course.id === id);
            coursediv = '<div class="card overflow-hidden">';
            var course_title=course['title'];
            if(course_title != null)
              course_title=course_title.replace(/ /g,'_');
            coursediv+=`<div class="d-md-flex"><div class=""><div class="item-card9-imgs">`;
            coursediv+=`<a href="wikiidea/idea/`+course['id']+`/`+course_title+`"></a>`;
            coursediv+=`<img src="_upload_/_wikiideas_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
            coursediv+=`</div></div><div class="">`;
            coursediv+=`<div class="card-body " style="padding-top: 0;padding-bottom: 0"><div class="item-card9"><div class="row"><div class="col-lg-10 col-sm-12 col-xs-12">`;
            coursediv+=`<a href="wikiidea/idea/`+course['id']+`/`+course_title+`" class="text-dark"><h3 class="font-weight-semibold mt-1">`+course['title']+`</h3></a>`;
            coursediv+=`<div class="mt-2 mb-2" style="font-family: VazirLight">`;
            coursediv+=`<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>`+course['category']['title']+`</span></a>`;
            coursediv+=`<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-muted text-play ml-1"></i>ریسک: `+course['risk']+`</span></a>`;
            coursediv+=`<a  class="ml-4"><span class="text-muted fs-13"><i class="fa fa-clock-o text-muted ml-1"></i>سودآوری: `+ course['profitability']+`</span></a>`;
            coursediv+=`<br>`;
            coursediv+=`<h6 class="IRANSansWeb_Medium"> کف سرمایه: `+number_format(course['minimal_fund'])+ ` &nbsp; تومان </h6>`;
            coursediv+=`</div></div></div>`;
            coursediv+=`<div class="row">`;
            coursediv+=`<p class="mb-0 fs-14 IRANSansWeb_Light">`+ course['abstractMemo']+ `</p>`;
            coursediv+=`</div>`;
            coursediv+=`<div class="text-left">`;
            coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['view_count']+ ` &nbsp;<i class="fa fa-eye"></i></span>`;
            coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['like_count']+ ` &nbsp;<i class="fa fa-heart"></i></span>`;
            coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['score']+ `&nbsp;<i class="fa fa-star"></i></span>`;
            coursediv+=`</div></div></div></div></div>`;
            $("#tab-11").append(coursediv);
        }
    }
    else if( this.value=="old"){
        $("#tab-11").empty();
        wiki_results_id.sort();
        for (var i=0;i<wiki_results_id.length;i=i+1) {
            var id=wiki_results_id[i];
            var course = wiki_results.find(course => course.id === id);
            coursediv = '<div class="card overflow-hidden">';
            var course_title=course['title'];
            if(course_title != null)
              course_title=course_title.replace(/ /g,'_');
            coursediv+=`<div class="d-md-flex"><div class=""><div class="item-card9-imgs">`;
            coursediv+=`<a href="wikiidea/idea/`+course['id']+`/`+course_title+`"></a>`;
            coursediv+=`<img src="_upload_/_wikiideas_/`+course['code']+`/medium_`+course['image']+`" alt="`+course['title']+`" class="cover-image">`;
            coursediv+=`</div></div><div class="">`;
            coursediv+=`<div class="card-body " style="padding-top: 0;padding-bottom: 0"><div class="item-card9"><div class="row"><div class="col-lg-10 col-sm-12 col-xs-12">`;
            coursediv+=`<a href="wikiidea/idea/`+course['id']+`/`+course_title+`" class="text-dark"><h3 class="font-weight-semibold mt-1">`+course['title']+`</h3></a>`;
            coursediv+=`<div class="mt-2 mb-2" style="font-family: VazirLight">`;
            coursediv+=`<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>`+course['category']['title']+`</span></a>`;
            coursediv+=`<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-play text-muted ml-1"></i>ریسک: `+course['risk']+`</span></a>`;
            coursediv+=`<a  class="ml-4"><span class="text-muted fs-13"><i class="fa fa-clock-o text-muted ml-1"></i>سودآوری: `+ course['profitability']+`</span></a>`;
            coursediv+=`<br>`;
            coursediv+=`<h6 class="IRANSansWeb_Medium"> کف سرمایه: `+number_format(course['minimal_fund'])+ `&nbsp; تومان </h6>`;
            coursediv+=`</div></div></div>`;
            coursediv+=`<div class="row">`;
            coursediv+=`<p class="mb-0 fs-14 IRANSansWeb_Light">`+ course['abstractMemo']+ `</p>`;
            coursediv+=`</div>`;
            coursediv+=`<div class="text-left">`;
            coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['view_count']+ ` &nbsp;<i class="fa fa-eye"></i></span>`;
            coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['like_count']+ ` &nbsp;<i class="fa fa-heart"></i></span>`;
            coursediv+=`<span class="text-muted IRANSansWeb_Medium" style="margin-left: 10px">`+ course['score']+ `&nbsp;<i class="fa fa-star"></i></span>`;
            coursediv+=`</div></div></div></div></div>`;
            $("#tab-11").append(coursediv);
        }
    }
});

$("#btn_add_wikiidea").on("click",function (event) {
    var idea_image=$('#idea_image')[0].files[0];
    var idea_video=$('#idea_video')[0].files[0];
    var idea_title = $("#idea_title").val();
    var idea_category = $("#idea_category").val();
    var idea_minimal_fund = $("#idea_minimal_fund").val();
    var idea_risk = $("#idea_risk").val();
    var idea_profitability = $("#idea_profitability").val();
    var idea_profitability_memo = $("#idea_profitability_memo").val();
    var idea_manpower = $("#idea_manpower").val();
    var idea_scale = $("#idea_scale").val();
    var idea_state = $("#idea_state").val();
    var idea_abstractMemo = $("#idea_abstractMemo").val();
    var idea_memo = CKEDITOR.instances['idea_memo'].getData();

    let formDataa = new FormData();
    formDataa.append('idea_image', idea_image);
    formDataa.append('idea_video', idea_video);
    formDataa.append('idea_title', idea_title);
    formDataa.append('idea_category', idea_category);
    formDataa.append('idea_minimal_fund', idea_minimal_fund);
    formDataa.append('idea_risk', idea_risk);
    formDataa.append('idea_profitability', idea_profitability);
    formDataa.append('idea_profitability_memo', idea_profitability_memo);
    formDataa.append('idea_manpower', idea_manpower);
    formDataa.append('idea_scale', idea_scale);
    formDataa.append('idea_state', idea_state);
    formDataa.append('idea_abstractMemo', idea_abstractMemo);
    formDataa.append('idea_memo', idea_memo);

    $.ajax({
        url: "wikiidea/add_idea",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت ایده کسب و کار");
        },
        success: function (result) {
            if (!result.error) {

                $('#idea_form').find("input[type=text], textarea").val("");
                $("#idea_form").trigger('reset');
                $(".dropify-clear").trigger("click");
                CKEDITOR.instances['idea_memo'].setData('');


            }

            ShowMessage(result.message, result.type);
        },
        complete: function () {
            CloseWaiting();
        },
        error: function () {
            CloseWaiting();
            ShowMessage('خطای ناشتاخته', '« صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
        }
    });

});

