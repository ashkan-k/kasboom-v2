var course_results="";
var course_results_id=[];
var hire_id=0;
var hire_title="";
var course_price=0;
var wallet=0;

function show(){
    $("#btn_add_favorite").show();
}
function hide(){
    $("#btn_add_favorite").hide();
}

$("#btn_add_favorite").click(function () {
    let formDataa = new FormData();
    formDataa.append('id_hire', hire_id);
    formDataa.append('title', hire_title);
    $.ajax({
        url: "add_favorite",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت به علاقه مندی ها");
        },
        success: function (result) {
            console.log(result);
            if (!result.error) {
                if (!result.error) {
                    $("#btn_remove_favorite").show();
                    $("#btn_add_favorite").hide();
                }
                ShowMessage(result.message, result.type);

            }
            else{
                window.location.href = "login";
            }
        },
        complete: function () {
            CloseWaiting();
        },
        error: function () {
            ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
        }
    });

});

$("#btn_remove_favorite").click(function () {
    let formDataa = new FormData();
    formDataa.append('id_hire', hire_id);
    $.ajax({
        url: "remove_favorite",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("حذف از علاقه مندی ها");
        },
        success: function (result) {
            console.log(result);
            if (!result.error) {
                $("#btn_remove_favorite").hide();
                $("#btn_add_favorite").show();
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

});

$(".take_quiz").click(function(){
    // swal({
    //     title: "آزمون دوره",
    //     text: "آیا جهت شرکت در آزمون آمادگی لازم را دارید؟",
    //     type: "warning",
    //     showCancelButton: true,
    //     confirmButtonClass: 'btn-warning',
    //     confirmButtonText: "بله",
    //     cancelButtonText: 'بعدا شرکت می کنم',
    //     closeOnConfirm: true
    // }, function () {
    var hire_title_2=hire_title.replace(" ","_");
    window.location.href ="quiz/"+hire_id+"/"+hire_title_2;
    // });
});


function open_hire_tab() {
    $("#course_tab").click();
    $("#course_tab").focus();

}

$("#btn_discount").click(function () {

    if (($("#discount").val()).length > 3) {
        let formDataa = new FormData();
        formDataa.append('discount', $("#discount").val());
        formDataa.append('used_for', "hire");
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
                    var price =course_price;
                    var discount_price = (price * (percent / 100));
                    var new_price = (price - discount_price);


                    $("#discount_pay").text(percent + " درصد برابر با " +number_format(discount_price) + "  تومان ");
                    $("#final_price").text(number_format(new_price) + " تومان ");

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


