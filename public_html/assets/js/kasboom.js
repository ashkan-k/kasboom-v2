var lastCommentDatatable="";
var id_user=0;

(function($) {
    "use strict";

    // ______________ Cover-image
    $(".cover-image").each(function(e) {
        var attr = $(this).attr('data-image-src');
        if (typeof attr !== typeof undefined && attr !== false) {
            $(this).css('background', 'url(' + attr + ') center center');
        }
    });

    // ______________ Global Loader
    $(window).on("load", function(e) {
        $("#global-loader").fadeOut("slow");
    })

    // ______________ Color-skin
    $(document).on("click", "a[data-theme]", function(e) {
        $("head link#theme").attr("href", $(this).data("theme"));
        $(this).toggleClass('active').siblings().removeClass('active');
    });
    $(document).on("click", "a[data-effect]", function(e) {
        $("head link#effect").attr("href", $(this).data("effect"));
        $(this).toggleClass('active').siblings().removeClass('active');
    });

    // ______________ Modal
    // $("#myModal").modal('show');

    // ______________Rating Stars
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
    // $(".rating-stars").ratingStars(ratingOptions);

    // ______________mCustomScrollbar
    // $(".vscroll").mCustomScrollbar();
    // $(".nav-sidebar").mCustomScrollbar({
    //     theme: "minimal",
    //     autoHideScrollbar: true,
    //     scrollbarPosition: "outside"
    // });

    // ______________Active Class
    $(".horizontalMenu-list li a").each(function(e) {
        var pageUrl = window.location.href.split(/[?#]/)[0];
        if (this.href == pageUrl) {
            $(this).addClass("active");
            $(this).parent().addClass("active"); // add active to li of the current link
            $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
            $(this).parent().parent().prev().click(); // click the item to make it drop
        }
    });


    // ______________ Back to Top
    $(window).on("scroll", function(e) {
        if ($(this).scrollTop() > 0) {
            $('#back-to-top').fadeIn('slow');
        } else {
            $('#back-to-top').fadeOut('slow');
        }
    });
    $(document).on("click", "#back-to-top", function(e) {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });



    // ______________Quantity-right-plus
    var quantitiy = 0;
    $(document).on('click','.quantity-right-plus', function(e) {
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        $('#quantity').val(quantity + 1);
    });
    $(document).on('click', '.quantity-left-minus', function(e) {
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        if (quantity > 0) {
            $('#quantity').val(quantity - 1);
        }
    });



    // ______________Chart-circle
    if ($('.chart-circle').length) {
        $('.chart-circle').each(function(e) {
            let $this = $(this);
            $this.circleProgress({
                fill: {
                    color: $this.attr('data-color')
                },
                size: $this.height(),
                startAngle: -Math.PI / 4 * 2,
                emptyFill: '#f9faff',
                lineCap: ''
            });
        });
    }
    const DIV_CARD = 'div.card';



    // ______________Tooltip
    // $('[data-toggle="tooltip"]').tooltip();

    // ______________Popover
    // $('[data-toggle="popover"]').popover({
    //     html: true
    // });

    // ______________Card Remove
    $(document).on('click', '[data-toggle="card-remove"]', function(e) {
        let $card = $(this).closest(DIV_CARD);
        $card.remove();
        e.preventDefault();
        return false;
    });

    // ______________Card Collapse
    $(document).on('click', '[data-toggle="card-collapse"]', function(e) {
        let $card = $(this).closest(DIV_CARD);
        $card.toggleClass('card-collapsed');
        e.preventDefault();
        return false;
    });

    // ______________Card Full Screen
    $(document).on('click', '[data-toggle="card-fullscreen"]', function(e) {
        let $card = $(this).closest(DIV_CARD);
        $card.toggleClass('card-fullscreen').removeClass('card-collapsed');
        e.preventDefault();
        return false;
    });

    /*//////////////////// Header and Horizontal skins  //////////////////////*/

    //$('body').addClass("default-header"); //

    //$('body').addClass("headerstyle1");   //

    // $('body').addClass("headerstyle2"); //

    // $('body').addClass("default-menu"); //

    // $('body').addClass("menu-style1"); //

    // $('body').addClass("menu-style2"); //

})(jQuery);

function baseUrl() {
    //return window.location.origin + '/bagher_al_olum/public/';
    return $('base').attr('href');
    //return 'http://192.168.10.1/bagher_al_olum/public/';
}

function ShowMessage(message, messageType) {
    $.toast({
        heading: 'پیغام',
        text: message,
        icon: messageType,
        loader: true,        // Change it to false to disable loader
        showHideTransition: 'slide',
        loaderBg: '#9EC600',  // To change the background
        position: 'bottom-center',
    })
}

function ShowWaiting(title){
    var imageWaitingRandom= Math.floor((Math.random() * 10) + 1);
    var message="در حال انجام عملیات " + title + " می باشد لطفا شکیبا باشید";
    var src="assets/images/waiting/"+imageWaitingRandom+".gif";
    $("#WaitingImage").attr("src",src);

    $("#waitingMess").text(message);
    $("#waitingTitle").text(title+" ...");
    $('#waiting_modal').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });
}

function CloseWaiting(){
    $('#waiting_modal').modal('hide');
}

function makeAbstract(text,len){
    if (text==null)
        text="";
    var lentext=(text.length);
    var res=text;
    if (typeof len == "undefined")
        len = 70;
    if (lentext>len){
        res = text.substr(0, len);
        res=res+'...'
    }
    return res;
}

function news_letter(type) {

    var mobile=$("#txt_mobile_inform").val();
    if(mobile.length ==11) {
        let formDataa = new FormData();
        formDataa.append('inform_mobile', mobile);
        formDataa.append('inform_type', type);
        $.ajax({
            url: "inform",
            type: 'POST',
            cache: false,
            data: formDataa,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            beforeSend: function () {
                ShowWaiting("ارسال دعوت نامه");
            },
            success: function (result) {
                if (!result.error) {
                    $("#txt_mobile_inform").val("");
                }
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
    else
        ShowMessage("شماره موبایل معتبر وارد نمایید", "error");

}

$("#btn_send_message").on("click",function (event) {

    var type_target=$("#type_target").val();
    var id_target=$("#id_target").val();
    var subject=$("#contact_subject").val();
    var memo=$("#contact_message").val();

    let formDataa = new FormData();
    formDataa.append('type_target', type_target);
    formDataa.append('id_target', id_target);
    formDataa.append('subject', subject);
    formDataa.append('memo', memo);

    $.ajax({
        url: "send_message",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ارسال پیام");
        },
        success: function (result) {
            if (!result.error) {
                $('#contact').modal('toggle');
                $("#contact_subject").val("");
                $("#contact_message").val("");

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

$("#btn_add_reply_message").on("click",function (event) {
    let targerData = new FormData();
    targerData.append('id_mess', $("#message_id").val());
    targerData.append('id_target', $("#message_id_target").val());
    targerData.append('reply_message', $("#reply_mess_message").val());
    $.ajax({
        url: "reply_message",
        type: 'POST',
        cache: false,
        data: targerData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ارسال پاسخ پیام");
        },
        success: function (result) {
            ShowMessage(result.message, result.type);
            if (!result.error) {

            }
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

function viewMessage(id_mess){
    let targerData = new FormData();
    targerData.append('id', id_mess);
    $.ajax({
        url: "get_message",
        type: 'POST',
        cache: false,
        data: targerData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
        },
        success: function (result) {
            if (!result.error) {
                var mess_data=result.data;
                var user_data=result.user;
                if(mess_data != null) {
                    $("#mess_owner").val(user_data.name);
                    $("#mess_date").val(mess_data.regist_date);
                    $("#mess_message").val(mess_data.message);
                    $("#mess_id_user").val(mess_data.id_owner);
                    $("#message_id_target").val(mess_data.id_target);
                    $("#mess_subject").val(mess_data.subject);
                    $("#reply_mess_message").val(mess_data.replay_message);
                    $("#message_id").val(mess_data.id);
                    $("#message_target_type").val(mess_data.type);

                    if(mess_data.id_owner == id_user)
                        $("#btn_add_reply_message").hide();
                    else
                        $("#btn_add_reply_message").show();
                }
            }
            else {
                ShowMessage(result.message, result.type);
            }
        },
        complete: function () {
        },
        error: function () {
            // ShowMessage('خطای ناشتاخته', '« صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
        }
    });

    $('#message_modal').modal('toggle');
}

function viewComment(id_comment) {
    let formDataa = new FormData();
    formDataa.append('id', id_comment);
    $.ajax({
        url: "get_comment",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("مشاهده نظر");
        },
        success: function (result) {
            if (!result.error) {
                var mess_data=result.data;
                if(mess_data != null) {
                    var user_data = result.user;
                    $("#comment_fullname").val(user_data.name);
                    $("#comment_message").val(mess_data.comment);
                    $("#comment_date").val(mess_data.regist_date);
                    $("#comment_score").val(mess_data.score);
                    $("#comment_id").val(mess_data.id);
                }
            }
            else {
                ShowMessage(result.message, result.type);
            }
        },
        complete: function () {
            CloseWaiting();
        },
        error: function () {
            CloseWaiting();
            ShowMessage('خطای ناشتاخته', '« صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
        }
    });

    $('#comment_modal').modal('toggle');
}

function send_comment(type,id_target) {
    let formDataa = new FormData();
    formDataa.append('id_target', id_target);
    formDataa.append('type', type);
    formDataa.append('comment_score', $("#comment_score").val());
    formDataa.append('comment_memo', $("#comment_memo").val());
    $.ajax({
        url: "send_comment",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ارسال نظر");
        },
        success: function (result) {
            if (!result.error) {
                $("#comment_memo").val("");
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

}

$("#btn_send_invite_teacher").on("click",function (event) {


    var fullname=$("#fullname").val();
    var phonenumber=$("#phonenumber").val();
    var tel=$("#tel").val();
    var birthdate=$("#birthdate").val();
    var gender=$('input[name="gender"]:checked').val();
    var state=$("#state").val();
    var city=$("#city").val();
    var fields=$("#fields").val();
    var memo=$("#memo").val();
    var attach_rezoume=$('#attach_rezoume')[0].files[0];

    if((fullname ==null) || (phonenumber ==null) || city==null || state==null )
        ShowMessage("لطفا فرم را کامل پرنمائید", "error");
    else {
        let formDataa = new FormData();
        formDataa.append("fullname", fullname);
        formDataa.append("phonenumber", phonenumber);
        formDataa.append("tel", tel);
        formDataa.append("birthdate", birthdate);
        formDataa.append("gender", gender);
        formDataa.append("city", city);
        formDataa.append("state", state);
        formDataa.append("fields", fields);
        formDataa.append("attach_rezoume", attach_rezoume);
        formDataa.append("memo", memo);

        $.ajax({
            url: "skill/invite_teacher_register",
            type: 'POST',
            cache: false,
            data: formDataa,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            beforeSend: function () {
                ShowWaiting("ثبت اطلاعات و بارگزاری پیوست ها");
            },
            success: function (result) {
                if (!result.error) {
                    $("#message").text(result.message);
                    $("#message").show();

                    $('#invite_form').find("input[type=text], textarea").val("");
                    $("#invite_form").trigger('reset');
                    $(".dropify-clear").trigger("click");
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
    }


});

$("#btn_regist_course_suggestion").on("click",function (event) {

        var title = $("#title").val();
        var category = $("#category").val();
        var minimal_fund = $("#minimal_fund").val();
        var manpower = $("#manpower").val();
        var risk = $("#risk").val();
        var profitability = $("#profitability").val();
        var state = $("#state").val();
        var memo = $("#memo").val();
        if (title == null)
            ShowMessage("لطفا عنوان پیشنهادی خود را وارید نمائید", "error");
        else {
            let formDataa = new FormData();
            formDataa.append("title", title);
            formDataa.append("category", category);
            formDataa.append("minimal_fund", minimal_fund);
            formDataa.append("manpower", manpower);
            formDataa.append("risk", risk);
            formDataa.append("profitability", profitability);
            formDataa.append("state", state);
            formDataa.append("memo", memo);
            $.ajax({
                url: "skill/regist_course_suggestion",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("ثبت پیشنهاد");
                },
                success: function (result) {
                    if (!result.error) {
                        $("#message").text(result.message);
                        $("#message").show();

                        $('#invite_form').find("input[type=text], textarea").val("");
                        $("#invite_form").trigger('reset');
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
        }



});

$("#btn_send_news_letter").on("click",function (event) {


    var phonenumber=$("#newletter_phonenumber").val();
    if((phonenumber ==null) || (phonenumber.length >11) || (phonenumber.length <10))
        ShowMessage("لطفا شماره موبایل معتبر وارد نمائید", "error");
    else {
        let formDataa = new FormData();
        formDataa.append("phonenumber", phonenumber);
        $.ajax({
            url: "newsletter",
            type: 'POST',
            cache: false,
            data: formDataa,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            beforeSend: function () {
                ShowWaiting("عضویت در خبرنامه پیامکی");
            },
            success: function (result) {
                if (!result.error) {
                    $('#newletter_phonenumber').val("");
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
    }


});

$("#btn_check_username").on("click",function (event) {
    var username = $("#username").val();
    let formDataa = new FormData();
    formDataa.append('username', username);
    $.ajax({
        url: "check_username",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("بررسی نام کاربری");
        },
        success: function (result) {
            if (!result.error) {
                $('#user_message').hide();
            }
            else {
                $('#user_message').text(result.message);
                $('#user_message').show();
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


function number_format(Number)
{
    Number+= '';
    Number= Number.replace(',', '');
    x = Number.split('.');
    y = x[0];
    z= x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(y))
        y= y.replace(rgx, '$1' + ',' + '$2');
    return y+ z;
}

function toPersianDigit2(number) {
    return number.toLocaleString('fa-IR',{
        useGrouping:false
    }).replace(".",".").replace(",",",");

}

function toPersianDigit(en) {
    var pn = "";
    for ( var i=0; i < en.length; i++) {
        switch(en.charAt(i)) {
            case "0":
                pn = pn + "۰";
                break;
            case "1":
                pn = pn + "۱";
                break;
            case "2":
                pn = pn + "۲";
                break;
            case "3":
                pn = pn + "۳";
                break;
            case "4":
                pn = pn + "۴";
                break;
            case "5":
                pn = pn + "۵";
                break;
            case "6":
                pn = pn + "۶";
                break;
            case "7":
                pn = pn + "۷";
                break;
            case "8":
                pn = pn + "۸";
                break;
            case "9":
                pn = pn + "۹";
                break;
            case ",":
                pn = pn + "٫";
                break;
            case ".":
                pn = pn + "/";
                break;
            default:
                pn = pn + en.charAt(i);
                break;

        }
    }
    return pn;
}

$('#state').on('change', function (e) {
    e.preventDefault();
    var selectData = $("#state").val();
    let formData = new FormData();
    formData.append('state', selectData);
    $.ajax({
        url: "getCity",
        type: 'POST',
        cache: false,
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },

        beforeSend: function () {
            // ShowWaiting("در حال ذخیره تغییرات");
        },
        success: function (result) {
            if (!result.error) {
                $('#city').html(result.data);
            }
        },
        complete: function () {
            // CloseWaiting();
        },
        error: function () {
        }
    });
});


function CloseWaiting(){
  $('#waiting_modal').hide();
}

function ShowWaiting(title){

  var imageWaitingRandom= Math.floor((Math.random() * 10) + 1);
  var message="در حال انجام عملیات " + title + " می باشد لطفا شکیبا باشید";
  var src="assets/images/waiting/"+imageWaitingRandom+".gif";
  $("#WaitingImage").attr("src",src);

  $("#waitingMess").text(message);
  $("#waitingTitle").text(title+" ...");
  $('#waiting_modal').show();
}
