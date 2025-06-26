var consult_id=0;
var lesson_id=0;
var consult_title="";
var consult_price=0;
var wallet=0

$("#btn_search_ajax_consult").click(function (){
    var consult_name=$("#consult_name").val();
    let formDataa = new FormData();
    formDataa.append('consult_name', consult_name);
    if(consult_name.length<2)
        ShowMessage('مقار مناسبی جهت جستجو وارد نمائید', 'error');
    else {
        $.ajax({
            url: "consult/search_consult_ajax",
            type: 'POST',
            cache: false,
            data: formDataa,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            beforeSend: function () {
                ShowWaiting("جستجوی مشاوره متخصص");
            },
            success: function (result) {
                if (!result.error) {
                    $("#tab-row").empty();
                    // var obj = JSON.parse(json.responseText);
                    course_results=result.data;
                    var courses = result.data;
                    var course="";
                    var coursediv='';
                    $("#result_info").text(" تعداد مشاورین متخصص " +courses.length +"  مشاور  ");
                    course_results_id=[];
                    for (var i=0;i<courses.length;i=i+1) {
                        course=courses[i];
                        var consult_fullname=course['fullname'];
                        if(consult_fullname != null)
                          consult_fullname=consult_fullname.replace(/ /g,'_');
                        coursediv='<div class="col-lg-4 col-md-6"><div class="card-advice">';
                        coursediv+=`<a href="consult/profile/`+course['id']+`/`+consult_fullname +`" alt="`+course['fullname']+`">`;
                        coursediv+=`<div class="card-h">`;
                        coursediv+=`<div class="number-advice"><span class="titr">تعداد مشاوره</span>`;
                        coursediv+=`<span class="number">`+course['consult_count'] +`</span>`;
                        coursediv+=`</div>`;
                        coursediv+=`<div class="rate">`+course['score']+`<i class="mdi mdi-star"></i></div>`;
                        coursediv+=`<div class="user-pic">`;
                        coursediv+=`<img src="_upload_/_consult_/`+course['code']+`/small_`+course['image']+`" alt="`+course['fullname']+`">`;
                        coursediv+=`</div>`;
                        coursediv+=`<h2 class="user-name">`+course['fullname'] +`</h2>`;
                        coursediv+=`<h6 class="advice-area">`+course['consult_field'] +`</h6>`;
                        coursediv+=`</div><div class="card-b"><p class="about">`;
                        coursediv+=course['abstractAbout']
                        coursediv+=`</p> <ul class="price-list">`
                        coursediv+=`<li><span class="icon"><i class="mdi mdi-account-multiple-outline"></i></span>`
                        coursediv+=`<span class="price">`+number_format(course['consult_price_present']) +`<small>تومان</small></span></li>`
                        coursediv+=`<li><span class="icon"><i class="mdi mdi-cellphone-android"></i></span>`
                        coursediv+=`<span class="price">`+number_format(course['consult_price_tel']) +`<small>تومان</small></span></li>`
                        coursediv+=`<li><span class="icon"><i class="mdi mdi-forum-outline"></i></span>`
                        coursediv+=`<span class="price">`+number_format(course['consult_price_live']) +`<small>تومان</small></span></li></ul>`
                        coursediv+=`<div class="card-button"><div class="btn btn-gradient">`
                        coursediv+=`<span >مشاهده رزومه</span>`;
                        coursediv+=`</div></div></div><div class="card-f"><ul class="status-list">`;
                        coursediv+=`<li><i class="mdi mdi-eye-outline"></i>`+course['view_count']+`</li>`;
                        coursediv+=`<li><i class="mdi mdi-chat-outline"></i>`+course['comment_count']+`</li>`;
                        coursediv+=`<li><i class="mdi mdi-thumb-up-outline"></i>`+course['score']+`</li>`;
                        coursediv+=`</ul></div></a></div></div>`;
                        $("#tab-row").append(coursediv);
                    }
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

$("#btn_filter_ajax_consult").click(function (){

    var cats = $('.category:checkbox:checked').map(function() {
        return this.value;
    }).get();

    let formDataa = new FormData();
    formDataa.append('cats', cats);

    $.ajax({
        url: "consult/filter_consult_ajax",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("جستجو مشاورین متخصص");
        },
        success: function (result) {
            // console.log(result);
            if (!result.error) {
                $("#tab-row").empty();
                // var obj = JSON.parse(json.responseText);
                course_results=result.data;
                var courses = result.data;
                var course="";
                var coursediv='';
                $("#result_info").text(" تعداد مشاورین متخصص " +courses.length +"  مشاور  ");
                course_results_id=[];
                for (var i=0;i<courses.length;i=i+1) {
                    course=courses[i];
                    var consult_fullname=course['fullname'];
                    if(consult_fullname != null)
                      consult_fullname=consult_fullname.replace(/ /g,'_');
                    coursediv='<div class="col-lg-4 col-md-6"><div class="card-advice">';
                    coursediv+=`<a href="consult/profile/`+course['id']+`/`+consult_fullname +`" alt="`+course['fullname']+`">`;
                    coursediv+=`<div class="card-h">`;
                    coursediv+=`<div class="number-advice"><span class="titr">تعداد مشاوره</span>`;
                    coursediv+=`<span class="number">`+course['consult_count'] +`</span>`;
                    coursediv+=`</div>`;
                    coursediv+=`<div class="rate">`+course['score']+`<i class="mdi mdi-star"></i></div>`;
                    coursediv+=`<div class="user-pic">`;
                    coursediv+=`<img src="_upload_/_consult_/`+course['code']+`/small_`+course['image']+`" alt="`+course['fullname']+`">`;
                    coursediv+=`</div>`;
                    coursediv+=`<h2 class="user-name">`+course['fullname'] +`</h2>`;
                    coursediv+=`<h6 class="advice-area">`+course['consult_field'] +`</h6>`;
                    coursediv+=`</div><div class="card-b"><p class="about">`;
                    coursediv+=course['abstractAbout']
                    coursediv+=`</p> <ul class="price-list">`
                    coursediv+=`<li><span class="icon"><i class="mdi mdi-account-multiple-outline"></i></span>`
                    coursediv+=`<span class="price">`+number_format(course['consult_price_present']) +`<small>تومان</small></span></li>`
                    coursediv+=`<li><span class="icon"><i class="mdi mdi-cellphone-android"></i></span>`
                    coursediv+=`<span class="price">`+number_format(course['consult_price_tel']) +`<small>تومان</small></span></li>`
                    coursediv+=`<li><span class="icon"><i class="mdi mdi-forum-outline"></i></span>`
                    coursediv+=`<span class="price">`+number_format(course['consult_price_live']) +`<small>تومان</small></span></li></ul>`
                    coursediv+=`<div class="card-button"><div class="btn btn-gradient">`
                    coursediv+=`<span >مشاهده رزومه</span>`;
                    coursediv+=`</div></div></div><div class="card-f"><ul class="status-list">`;
                    coursediv+=`<li><i class="mdi mdi-eye-outline"></i>`+course['view_count']+`</li>`;
                    coursediv+=`<li><i class="mdi mdi-chat-outline"></i>`+course['comment_count']+`</li>`;
                    coursediv+=`<li><i class="mdi mdi-thumb-up-outline"></i>`+course['score']+`</li>`;
                    coursediv+=`</ul></div></a></div></div>`;
                    $("#tab-row").append(coursediv);
                }

                // $("#sortselect").prop( "disabled", false );


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

$("#btn_discount").click(function () {

    if (($("#discount").val()).length > 3) {
        let formDataa = new FormData();
        formDataa.append('discount', $("#discount").val());
        formDataa.append('used_for', "consult");
        $.ajax({
            url: "check_discount",
            type: 'POST',
            cache: false,
            data: formDataa,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            beforeSend: function () {
                ShowWaiting("بررسی کد تخفیف");
            },
            success: function (result) {
                // console.log(result);
                if (!result.error) {
                    var percent = result.data;
                    var price =consult_price;
                    var discount_price = (price * (percent / 100));
                    var new_price = (price - discount_price);

                    discount_price=number_format(discount_price);
                    new_price=number_format(new_price);


                    $("#discount_pay").text(percent + " درصد برابر با " + discount_price + "  تومان ");
                    $("#final_price").text(new_price + " تومان ");

                    if(new_price<= wallet)
                        $('#payment_type_wallet').attr("disabled", false);
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
    else {
        ShowMessage("کد تخفیف معتبر نمی باشد", 'error');

    }
});
