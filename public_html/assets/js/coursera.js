
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
    targerData.append('target_type', $("#message_target_type").val());
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
                $('#message_modal').modal('toggle');
                $("#reply_mess_message").val("");
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

function view_message(id_mess,id_target,type_target){
    let targerData = new FormData();
    targerData.append('id_mess', id_mess);
    targerData.append('id_target', id_target);
    targerData.append('type_target', type_target);
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
                    $("#mess_subject").val(mess_data.subject);
                    $("#reply_mess_message").val(mess_data.replay_message);
                    $("#message_id").val(mess_data.id);
                    $("#message_target_type").val(mess_data.type);
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
