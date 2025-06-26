var user_change_image=0;
var user_id=0;
var code="";
var image="";

function loadAllUsers() {

    user_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_users",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div='';
                    if(row.level == 'teacher')
                        div=' <div class=""><img src="_upload_/_teachers_/'+row.code+'/small_'+row.image+'" class="avatar cover-image avatar-lg brround" alt="'+row.name+'"></div>';
                    else if(row.level == 'consult')
                        div=' <div class=""><img src="_upload_/_consult_/'+row.code+'/small_'+row.image+'" class="avatar cover-image avatar-lg brround" alt="'+row.name+'"></div>';
                    else
                        div=' <div class=""><img src="_upload_/_users_/'+row.code+'/personal/'+row.image+'" class="avatar cover-image avatar-lg brround" alt="'+row.name+'"></div>';
                    return div;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.name;
                }
            },

            {
                mRender: function (data, type, row) {
                    return row.username;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.level;

                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_city;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.regist_date;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.wallet
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.serviceid
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <div class="project-details"><div class="project-info">';


                    if(row.status ==1)
                        div=div+'<div class="status approved"><i class="icon-check_circle"></i> فعال</div></div></div>';
                    else
                        div=div+'<div class="status rejected"><i class="icon-circle-with-cross"></i>غیر فعال</div></div></div>';
                    return div;
                }
            },
            {
                mRender: function (data, type, row) {
                    var title=row.name;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var facts='';
                    if(row.level == 'consult') {
                        facts = `<a href="_manager/consult_dashboard/` + row.id + `/` + title + `" title="پنل کاربری مشاور" target="_blank" class="btn btn-success  btn-sm text-white"> <i class="fa fa-id-card"></i> </a>&nbsp;`;
                    }
                    else if(row.level == 'teacher') {
                        facts = `<a href="_manager/teacher_dashboard/` + row.id + `/` + title + `" title="پنل کاربری مدرس" target="_blank" class="btn btn-success  btn-sm text-white"> <i class="fa fa-id-card"></i> </a>&nbsp;`;
                    }
                    else {
                        facts = `<a href="_manager/user_dashboard/` + row.id + `/` + title + `" title="پنل کاربری کاربر" target="_blank" class="btn btn-success  btn-sm text-white"> <i class="fa fa-id-card"></i> </a>&nbsp;`;
                    }
                    if(row.per_delete == true)
                        facts=facts+`<button type="button" onclick="deleteUser(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;

                    facts =facts+ `<a href="profile/` + row.id + `/` + title + `" title="پروفایل کاربری" target="_blank" class="btn btn-info  btn-sm text-white"> <i class="fa fa-user"></i> </a>&nbsp;`;
                    facts =facts+ `&nbsp;<a href="_manager/user_setting/` + row.id + `/` + title + `" title="تنظمیات کاربری" target="_blank" class="btn btn-warning  btn-sm text-white"> <i class="fe fe-settings"></i> </a>&nbsp;`;
                    facts =facts+ `&nbsp;<a href="_manager/user_detail/` + row.id + `/` + title + `" title="اطلاعات کاربری" target="_blank" class="btn btn-secondary  btn-sm text-white"> <i class="fa fa-info-circle"></i> </a>&nbsp;`;
                    return facts;
                }
            },
        ]
    });
}

function deleteUser(id) {

    Swal.fire({
        title: 'حذف کاربر',
        text: "آیا برای حذف کاربر مطمئن هستید؟",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "بله",
        cancelButtonText: 'انصراف',
    }).then((result) => {
        if (result.value) {
            let formDataa = new FormData();
            formDataa.append('id', id);
            $.ajax({
                url: "_manager/user/delete_user",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف اطلاعات کاربر");
                },
                success: function (result) {
                    if (!result.error) {
                        consult_datatable.DataTable().ajax.reload();

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
    })

}

function loadallcomments(){

    mydatatable.DataTable({
        // processing: true,
        // serverSide: true,

        // order: [[1, 'asc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_consult_comments",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var title = row.fullname;
                    title = title.replace(' ', '_');
                    var user = `<a href="profile/` + row.id_user + `/` + title + `" title="مشخصات کاربر ارسال کننده" target="_blank" class="btn btn-info  btn-sm text-white"> <i class="fa fa-user"></i> ` + row.fullname + ` </a>&nbsp;`;
                    return user;
                }
            },

            {
                mRender: function (data, type, row) {
                    return row.consult_name;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.regist_date;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.score;
                }
            },
            {
                mRender: function (data, type, row) {
                    var  abstract_comment=makeAbstract(row.comment,30);
                    return "<p class='font-13' title='"+row.comment+"' style='cursor: help'>"+abstract_comment+"</p>";
                }
            },
            {
                mRender: function (data, type, row) {
                    var title=row.fullname;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var facts=`<button type="button" onclick="viewComment(`+row.id+`)" title="نمایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i></button>&nbsp;`;
                    return facts;


                }
            },

        ]

    });


}

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

$("#btn_add_user_info").on("click",function (event) {
    var user_name = $("#user_name").val();
    var username = $("#username").val().trim();
    if(username ==null)
        ShowMessage("نام کاربری نمی تواند خالی باشد", "error");
    else {
        var fathername = $("#fathername").val();
        var user_nationalid = $("#user_nationalid").val();
        var user_birthdate = $("#user_birthdate").val();
        var user_gender = $("#user_gender").val();
        var user_married = $("#user_married").val();
        var phonenumber = $("#phonenumber").val();
        var mobile2 = $("#mobile2").val();
        var user_tel_work = $("#user_tel_work").val();
        var tel = $("#tel").val();
        var email = $("#email").val();
        var state = $("#state").val();
        var city = $("#city").val();
        var user_address_work = $("#user_address_work").val();
        var user_address_home = $("#user_address_home").val();
        var user_postalcode = $("#user_postalcode").val();
        var user_job = $("#user_job").val();
        var user_password = $("#user_password").val();
        var user_level = $("#user_level").val();
        var user_image = $('#user_image')[0].files[0];


        let formDataa = new FormData();
        formDataa.append('user_image', user_image);
        formDataa.append('username', username);
        formDataa.append('fathername', fathername);
        formDataa.append('phonenumber', phonenumber);
        formDataa.append('user_name', user_name);
        formDataa.append('user_mobile2', mobile2);
        formDataa.append('user_tel_work', user_tel_work);
        formDataa.append('user_tel', tel);
        formDataa.append('state', state);
        formDataa.append('city', city);
        formDataa.append('user_address_work', user_address_work);
        formDataa.append('user_address_home', user_address_home);
        formDataa.append('user_married', user_married);
        formDataa.append('user_job', user_job);
        formDataa.append('user_gender', user_gender);
        formDataa.append('user_email', email);
        formDataa.append('user_birthdate', user_birthdate);
        formDataa.append('user_nationalid', user_nationalid);
        formDataa.append('user_password', user_password);
        formDataa.append('user_postalcode', user_postalcode);
        formDataa.append('user_level', user_level);


        $.ajax({
            url: "_manager/user/add_user",
            type: 'POST',
            cache: false,
            data: formDataa,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            beforeSend: function () {
                ShowWaiting("ثبت اطلاعات کاربر");
            },
            success: function (result) {
                if (!result.error) {

                    $('#form_info').find("input[type=text], textarea").val("");
                    $("#form_info").trigger('reset');
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

$("#btn_update_personal_info").on("click",function (event) {

    var user_name = $("#user_name").val();
    var fathername = $("#fathername").val();
    var user_nationalid = $("#user_nationalid").val();
    var user_birthdate = $("#user_birthdate").val();
    var user_gender = $("#user_gender").val();
    var user_married = $("#user_married").val();
    var state = $("#state").val();
    var city = $("#city").val();
    var user_job = $("#user_job").val();
    var user_address_home = $("#user_address_home").val();
    var user_postalcode = $("#user_postalcode").val();
    var user_address_work = $("#user_address_work").val();
    var user_image=$('#user_image')[0].files[0];
    var id_user=$('#id_user').val();

    let formDataa = new FormData();

    formDataa.append('user_name', user_name);
    formDataa.append('fathername', fathername);
    formDataa.append('user_nationalid', user_nationalid);
    formDataa.append('user_birthdate', user_birthdate);
    formDataa.append('user_gender', user_gender);
    formDataa.append('user_married', user_married);
    formDataa.append('state', state);
    formDataa.append('city', city);
    formDataa.append('user_job', user_job);
    formDataa.append('user_address_home', user_address_home);
    formDataa.append('user_postalcode', user_postalcode);
    formDataa.append('user_address_work', user_address_work);
    formDataa.append('user_image', user_image);
    formDataa.append('id_user', id_user);

    $.ajax({
        url: "user/updateUserInfo",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },

        beforeSend: function () {
            ShowWaiting("ثبت تغییرات مشخصات ");
        },

        success: function (result) {
            if (!result.error) {
                $("#menu_tab_skill").click();
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

$("#btn_update_skill_info").on("click",function (event) {

    var user_last_education = $("#user_last_education").val();

    var abstractAbout = $("#abstractAbout").val();



    var skills = CKEDITOR.instances['skills'].getData();

    var learn_history = CKEDITOR.instances['learn_history'].getData();

    var about = CKEDITOR.instances['about'].getData();







    let formDataa = new FormData();

    formDataa.append('abstractAbout', abstractAbout);

    formDataa.append('about', about);

    formDataa.append('learn_history', learn_history);

    formDataa.append('skills', skills);

    formDataa.append('last_education', user_last_education);



    $.ajax({

        url: "user/updateUserSkills",

        type: 'POST',

        cache: false,

        data: formDataa,

        contentType: false,

        processData: false,

        headers: {

            'X-CSRF-TOKEN': $("#csrf-token").attr('content')

        },

        beforeSend: function () {

            ShowWaiting("ثبت تغییرات مشخصات مهارتی ");

        },

        success: function (result) {

            if (!result.error) {



                $("#menu_tab_contact").click();

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

$("#btn_update_contact_info").on("click",function (event) {



    var phonenumber = $("#phonenumber").val();

    var mobile2 = $("#mobile2").val();

    var tel = $("#tel").val();

    var tel_work = $("#tel_work").val();

    var website = $("#website").val();

    var email = $("#email").val();

    var soroush = $("#soroush").val();

    var eita = $("#eita").val();

    var telegram = $("#telegram").val();

    var instagram = $("#instagram").val();

    var linkdin = $("#linkdin").val();

    var whatsapp = $("#whatsapp").val();

    var aparat = $("#aparat").val();



    let formDataa = new FormData();

    formDataa.append('phonenumber', phonenumber);

    formDataa.append('mobile2', mobile2);

    formDataa.append('tel', tel);

    formDataa.append('tel_work', tel_work);

    formDataa.append('website', website);

    formDataa.append('email', email);

    formDataa.append('soroush', soroush);

    formDataa.append('eita', eita);

    formDataa.append('telegram', telegram);

    formDataa.append('instagram', instagram);

    formDataa.append('linkdin', linkdin);

    formDataa.append('whatsapp', whatsapp);

    formDataa.append('aparat', aparat);



    $.ajax({

        url: "user/updateUserContacts",

        type: 'POST',

        cache: false,

        data: formDataa,

        contentType: false,

        processData: false,

        headers: {

            'X-CSRF-TOKEN': $("#csrf-token").attr('content')

        },

        beforeSend: function () {

            ShowWaiting("ثبت تغییرات مشخصات تماس ");

        },

        success: function (result) {

            if (!result.error) {



                $("#menu_tab_bank").click();

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

$("#btn_update_bank_info").on("click",function (event) {



    var accountnumber = $("#account_no").val();

    var cardnumber = $("#cardnumber").val();

    var shabanumber = $("#shabanumber").val();



    let formDataa = new FormData();

    formDataa.append('accountnumber', accountnumber);

    formDataa.append('cardnumber', cardnumber);

    formDataa.append('shabanumber', shabanumber);



    $.ajax({

        url: "user/updateUserCards",

        type: 'POST',

        cache: false,

        data: formDataa,

        contentType: false,

        processData: false,

        headers: {

            'X-CSRF-TOKEN': $("#csrf-token").attr('content')

        },

        beforeSend: function () {

            ShowWaiting("ثبت تغییرات مشخصات بانکی ");

        },

        success: function (result) {

            if (!result.error) {



                $('#from_bank').find("input[type=text], textarea").val("");

                $("#from_bank").trigger('reset');



                $('.content').val("");

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

$('#state').on('change', function (e) {
    e.preventDefault();
    var selectData = $(this).val();
    let formData= new FormData();
    formData.append('state',selectData);
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

$("#btn_update_setting_personal").on("click",function (event) {

    var username = $("#username").val();
    var user_name = $("#user_name").val();
    var fathername = $("#fathername").val();
    var user_nationalid = $("#user_nationalid").val();
    var user_id_markaz = $("#user_id_markaz").val();
    var user_talabeid = $("#user_talabeid").val();
    var user_serviceid = $("#user_serviceid").val();
    var user_birthdate = $("#user_birthdate").val();
    var user_gender = $("#user_gender").val();
    var user_married = $("#user_married").val();
    var state = $("#state").val();
    var city = $("#city").val();
    var user_id_teacher = $("#user_id_teacher").val();
    var user_id_consult = $("#user_id_consult").val();
    var level = $("#level").val();
    var id_user=$('#id_user').val();

    let formDataa = new FormData();
    formDataa.append('username', username);
    formDataa.append('user_name', user_name);
    formDataa.append('fathername', fathername);
    formDataa.append('user_nationalid', user_nationalid);
    formDataa.append('user_id_markaz', user_id_markaz);
    formDataa.append('user_talabeid', user_talabeid);
    formDataa.append('user_serviceid', user_serviceid);
    formDataa.append('user_birthdate', user_birthdate);
    formDataa.append('user_gender', user_gender);
    formDataa.append('user_married', user_married);
    formDataa.append('state', state);
    formDataa.append('city', city);
    formDataa.append('user_id_teacher', user_id_teacher);
    formDataa.append('user_id_consult', user_id_consult);
    formDataa.append('level', level);
    formDataa.append('id_user', id_user);

    $.ajax({
        url: "_manager/user/updatePersonalSetting",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },

        beforeSend: function () {
            ShowWaiting("ثبت تنظمیات هویتی کاربر");
        },

        success: function (result) {
            if (!result.error) {
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

$("#btn_increas_wallet").on("click",function (event) {

    var user_in_price = $("#user_in_price").val();
    var user_in_memo = $("#user_in_memo").val();
    var id_user=$('#id_user').val();

    let formDataa = new FormData();
    formDataa.append('user_in_price', user_in_price);
    formDataa.append('user_in_memo', user_in_memo);
    formDataa.append('id_user', id_user);

    $.ajax({
        url: "_manager/user/increasWallet",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },

        beforeSend: function () {
            ShowWaiting("افزایش موجودی کیف پول مجازی");
        },

        success: function (result) {
            if (!result.error) {
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

$("#btn_decreas_wallet").on("click",function (event) {

    var user_out_price = $("#user_out_price").val();
    var user_out_memo = $("#user_out_memo").val();
    var id_user=$('#id_user').val();

    let formDataa = new FormData();
    formDataa.append('user_out_price', user_out_price);
    formDataa.append('user_out_memo', user_out_memo);
    formDataa.append('id_user', id_user);

    $.ajax({
        url: "_manager/user/decreasWallet",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },

        beforeSend: function () {
            ShowWaiting("افزایش موجودی کیف پول مجازی");
        },

        success: function (result) {
            if (!result.error) {
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

$("#btn_change_status").on("click",function (event) {

    var user_status = $("#user_status").val();
    var status_memo = $("#status_memo").val();
    var id_user=$('#id_user').val();

    let formDataa = new FormData();
    formDataa.append('user_status', user_status);
    formDataa.append('status_memo', status_memo);
    formDataa.append('id_user', id_user);

    $.ajax({
        url: "_manager/user/changeStatus",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },

        beforeSend: function () {
            ShowWaiting("تغییر وضعیت کاربر");
        },

        success: function (result) {
            if (!result.error) {
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

$("#btn_change_permissions").on("click",function (event) {

    var wiki_permission=$("#wiki_permission").val();
    var course_permission=$("#course_permission").val();
    var lesson_permission=$("#lesson_permission").val();
    var shop_permission=$("#shop_permission").val();
    var consult_permission=$("#consult_permission").val();
    var req_permission=$("#req_permission").val();
    var workshop_permission=$("#workshop_permission").val();
    var blog_permission=$("#blog_permission").val();
    var hire_permission=$("#hire_permission").val();
    var user_permission=$("#user_permission").val();
    var teacher_permission=$("#teacher_permission").val();
    var news_permission=$("#news_permission").val();
    var category_permission=$("#category_permission").val();
    var landuse_permission=$("#landuse_permission").val();
    var vam_permission=$("#vam_permission").val();
    var markaz_permission=$("#markaz_permission").val();
    var id_user=$('#id_user').val();

    let formDataa = new FormData();
    formDataa.append("wiki_permission",wiki_permission);
    formDataa.append("course_permission",course_permission);
    formDataa.append("lesson_permission",lesson_permission);
    formDataa.append("shop_permission",shop_permission);
    formDataa.append("consult_permission",consult_permission);
    formDataa.append("req_permission",req_permission);
    formDataa.append("workshop_permission",workshop_permission);
    formDataa.append("blog_permission",blog_permission);
    formDataa.append("hire_permission",hire_permission);
    formDataa.append("user_permission",user_permission);
    formDataa.append("teacher_permission",teacher_permission);
    formDataa.append("news_permission",news_permission);
    formDataa.append("category_permission",category_permission);
    formDataa.append("landuse_permission",landuse_permission);
    formDataa.append("vam_permission",vam_permission);
    formDataa.append("markaz_permission",markaz_permission);
    formDataa.append('id_user', id_user);

    $.ajax({
        url: "_manager/user/changePermissions",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },

        beforeSend: function () {
            ShowWaiting("تغییر وضعیت کاربر");
        },

        success: function (result) {
            if (!result.error) {
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

$("#btn_change_pass").on("click",function (event) {

    var newpass=$("#new_pass").val();
    var renewpass=$("#re_new_pass").val();
    var id_user=$('#id_user').val();

    let formDataa = new FormData();
    formDataa.append('newpass', newpass);
    formDataa.append('renewpass', renewpass);
    formDataa.append('id_user', id_user);

    if(newpass==renewpass) {
        if(newpass.length<8)
            ShowMessage('تعداد کاراکترهای کلمه عبور جدید کم است', 'error');
        else {
            $.ajax({
                url: "_manager/user/changePass",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("تغییر کلمه عبور کاربر");
                },
                success: function (result) {
                    // console.log(result);
                    if (!result.error) {
                    }

                    ShowMessage(result.message, result.type);
                },
                complete: function () {
                    CloseWaiting();
                },
                error: function () {
                    CloseWaiting();
                    ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
                }
            });
        }
    }
    else
        ShowMessage('کلمات عبور جدید یکسان نیستند', 'error');

});



