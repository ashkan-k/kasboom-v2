$("#btn_invite_sms_live").click(function () {

    var phone=$("#txt_mobile_live").val();
    if(phone.length ==11) {
        let formDataa = new FormData();
        formDataa.append('id_target', 0);
        formDataa.append('title', '');
        formDataa.append('type', "live");
        formDataa.append('phonenumber',phone);
        $.ajax({
            url: "lives/live_invite",
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
                    $("#txt_mobile_live").val("");
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
        ShowMessage('شماره موبایل معتبر وارد نمائید', 'error');

});

$("#btn_invite_live").click(function () {
    let formDataa = new FormData();
    formDataa.append('invite_live_mobile', $("#invite_live_mobile").val());
    formDataa.append('id_live', "{{$live->id}}");
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
                $("#invite_live_mobile").val("");
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

