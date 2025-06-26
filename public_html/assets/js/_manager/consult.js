var consult_change_image=0;
var consult_id=0;
var code="";
var image="";

function loadconsults() {

    consult_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_consults",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <div class=""><img src="_upload_/_consult_/'+row.code+'/'+row.image+'" class="avatar cover-image avatar-lg brround" alt="'+row.fullname+'"></div>';
                    return div;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <div class="project-details"><div class="project-info"><p>'+row.fullname+'</p></div></div>';
                    return div;
                }
            },
            // {
            //     mRender: function (data, type, row) {
            //         return row.education;
            //     }
            // },
            {
                mRender: function (data, type, row) {
                    return row.consult_field;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.total_income
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.wallet
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.consult_count;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.view_count;
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
                    var title=row.fullname;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var facts=`<a href="_manager/consult/`+row.id+`/`+title+`" title="جزئیات و ویرایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-edit"></i> </a>&nbsp;`;
                    if(row.per_delete == true)
                        facts=facts+`<button type="button" onclick="deleteConsult(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                    return facts;
                }
            },
        ]
    });
}

function loadConsultCommments() {
    comment_table.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: {
            url: "_manager/consult/all_comments",
                type: "POST",
                data: function (d) {
                d.id_consult =$("#consult_id").val();
            },
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            // beforeSend: function(){
            //     ShowWaiting("بارگزاری نظرات ایده");
            // },
            // dataSrc: function ( ) {
            //     CloseWaiting();
            // },
        },
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
                if(row.read_status==1)
                    return row.regist_date;
                else
                    return "<strong>"+row.regist_date+"</strong>"
            }
        },
        {
            mRender: function (data, type, row) {
                if(row.read_status==1)
                    return row.score;
                else
                    return "<strong>"+row.score+"</strong>"
            }
        },
        {
            mRender: function (data, type, row) {
                var  abstract_comment=makeAbstract(row.comment,30);
                var tag= "<p class='font-13' title='"+row.comment+"' style='cursor: help'>"+abstract_comment+"</p>";
                if(row.read_status==1)
                    return tag;
                else
                    return "<strong>"+tag+"</strong>"
            }
        },
        {
            mRender: function (data, type, row) {
                var facts="";
                facts=facts+`<button type="button" onclick="viewComment(`+row.id+`)" title="نمایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i></button>&nbsp;`;
                return facts;


            }
        },

    ]

    });


}

function deleteConsult(id) {

    Swal.fire({
        title: 'حذف مشاور',
        text: "آیا برای حذف مشاور از کلینیک مطمئن هستید؟",
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
                url: "_manager/consult/delete_consult",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف اطلاعات مشاور");
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

function loadConsultTimes() {
    consult_time_table.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[5, 'asc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: {
            url: "_manager/consult/all_consultTimes",
            type: "POST",
            data: function (d) {
                d.id_consult =$("#consult_id").val();
            },
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            // beforeSend: function(){
            //     ShowWaiting("بارگزاری نظرات ایده");
            // },
            // dataSrc: function ( ) {
            //     CloseWaiting();
            // },
        },
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.user_name;
                }
            },

            {
                mRender: function (data, type, row) {
                   return row.consult_type;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.consult_date +" ساعت " +row.consult_time;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.consult_minutes +" دقیقه ";
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.status;
                }
            },
            {
                mRender: function (data, type, row) {
                    var title=row.user_name;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var facts=`<a href="_manager/consulting/`+row.id+`/`+title+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i> </a>&nbsp;`;
                    return facts;

                }
            },


        ]

    });

}

function loadAllConsulting() {
    consulting_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[7, 'asc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: {
            url: "_manager/consult/all_consulting",
            type: "POST",
            data: function (d) {
            },
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            // beforeSend: function(){
            //     ShowWaiting("بارگزاری نظرات ایده");
            // },
            // dataSrc: function ( ) {
            //     CloseWaiting();
            // },
        },
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.user_name;
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
                    return row.consult_date +" ساعت " +row.consult_time;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.consult_type;
                }
            },
            {
                mRender: function (data, type, row) {
                    var  abstract_comment=makeAbstract(row.memo,30);
                    var tag= "<p class='font-13' title='"+row.memo+"' style='cursor: help'>"+abstract_comment+"</p>";
                    return tag;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.status;
                }
            },
            {
                mRender: function (data, type, row) {
                    var title=row.consult_name;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var facts=`<a href="_manager/consulting/`+row.id+`/`+title+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> <i class="fa fa-edit"></i> </a>&nbsp;`;
                    return facts;

                }
            },


        ]

    });

}

function deleteEducation(id){
    Swal.fire({
        title: 'حذف اطلاعات سابقه مهارتی',
        text: "آیا برای حذف مطمئن هستید؟",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "تایید",
        cancelButtonText: 'انصراف',
    }).then((result) => {
        if (result.value) {
            let formDataa = new FormData();
            formDataa.append('id', id);
            formDataa.append('consult_id', $("#consult_id").val());
            $.ajax({
                url: "_manager/consult/delete_education",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف سابقه مهارتی");
                },
                success: function (result) {
                    if (!result.error) {
                        $("#tr_edu_"+id).remove();
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

function addEducation(){
    $("#grade_new").val("");
    $("#univercity_new").val("");
    $('#eduction_model').modal('toggle');

}

function loadConsultPayments(){
    payment_table.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: {
            url: "_manager/consult/all_consult_payments",
            type: "POST",
            data: function (d) {
                d.id_consult =$("#consult_id").val();
            },
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            // beforeSend: function(){
            //     ShowWaiting("بارگزاری نظرات ایده");
            // },
            // dataSrc: function ( ) {
            //     CloseWaiting();
            // },
        },
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.regist_date;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.fullname;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.product_course_title;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.payment_price;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.refID;
                }
            },

        ]

    });
}

$("#btn_add_consult").on("click",function (event) {
    var consult_cloud_url = $("#consult_cloud_url").val();
    var consult_category = $("#consult_category").val();
    var consult_name = $("#consult_name").val();
    var consult_education = $("#consult_education").val();
    var consult_univercity = $("#consult_univercity").val();
    var consult_mobile = $("#consult_mobile").val();
    var consult_mobile2 = $("#consult_mobile2").val();
    var consult_tel_work = $("#consult_tel_work").val();
    var consult_tel = $("#consult_tel").val();
    var state = $("#state").val();
    var city = $("#city").val();
    var consult_address_work = $("#consult_address_work").val();
    var consult_address_home = $("#consult_address_home").val();
    var consult_married = $("#consult_married").val();
    var consult_job = $("#consult_job").val();
    var consult_gender = $("#consult_gender").val();
    var consult_birthdate_place = $("#consult_birthdate_place").val();
    var consult_birthdate = $("#consult_birthdate").val();
    var consult_nationalid = $("#consult_nationalid").val();
    var consult_password = $("#consult_password").val();
    var consult_username = $("#username").val();
    var consult_field = $("#consult_field").val();
    var consult_image=$('#consult_image')[0].files[0];



    let formDataa = new FormData();
    formDataa.append('consult_image', consult_image);
    formDataa.append('consult_cloud_url', consult_cloud_url);
    formDataa.append('consult_category', consult_category);
    formDataa.append('consult_name', consult_name);
    formDataa.append('consult_education', consult_education);
    formDataa.append('consult_univercity', consult_univercity);
    formDataa.append('consult_mobile', consult_mobile);
    formDataa.append('consult_mobile2', consult_mobile2);
    formDataa.append('consult_tel_work', consult_tel_work);
    formDataa.append('consult_tel', consult_tel);
    formDataa.append('state', state);
    formDataa.append('city', city);
    formDataa.append('consult_address_work', consult_address_work);
    formDataa.append('consult_address_home', consult_address_home);
    formDataa.append('consult_married', consult_married);
    formDataa.append('consult_job', consult_job);
    formDataa.append('consult_gender', consult_gender);
    formDataa.append('consult_birthdate_place', consult_birthdate_place);
    formDataa.append('consult_birthdate', consult_birthdate);
    formDataa.append('consult_nationalid', consult_nationalid);
    formDataa.append('consult_password', consult_password);
    formDataa.append('consult_field', consult_field);
    formDataa.append('consult_username', consult_username);


    $.ajax({
        url: "_manager/consult/add_consult",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت اطلاعات مشاور");
        },
        success: function (result) {
            if (!result.error) {

                $('#consult_form').find("input[type=text], textarea").val("");
                $("#consult_form").trigger('reset');
                $(".dropify-clear").trigger("click");
                $('.ckeditor').val("");
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

$("#btn_update_personal_info").on("click",function (event) {
    var consult_cloud_url = $("#consult_cloud_url").val();
    var consult_category = $("#consult_category").val();
    var consult_name = $("#consult_name").val();
    var consult_education = $("#consult_education").val();
    var consult_univercity = $("#consult_univercity").val();
    var state = $("#state").val();
    var city = $("#city").val();
    var consult_address_work = $("#consult_address_work").val();
    var consult_address_home = $("#consult_address_home").val();
    var consult_married = $("#consult_married").val();
    var consult_job = $("#consult_job").val();
    var consult_gender = $("#consult_gender").val();
    var consult_birthdate_place = $("#consult_birthdate_place").val();
    var consult_birthdate = $("#consult_birthdate").val();
    var consult_nationalid = $("#consult_nationalid").val();
    var consult_image=$('#consult_image')[0].files[0];
    var consult_username = $("#username").val();

    let formDataa = new FormData();
    formDataa.append('consult_image', consult_image);
    formDataa.append('consult_cloud_url', consult_cloud_url);
    formDataa.append('consult_category', consult_category);
    formDataa.append('consult_name', consult_name);
    formDataa.append('consult_education', consult_education);
    formDataa.append('consult_univercity', consult_univercity);
    formDataa.append('state', state);
    formDataa.append('city', city);
    formDataa.append('consult_address_work', consult_address_work);
    formDataa.append('consult_address_home', consult_address_home);
    formDataa.append('consult_married', consult_married);
    formDataa.append('consult_job', consult_job);
    formDataa.append('consult_gender', consult_gender);
    formDataa.append('consult_birthdate_place', consult_birthdate_place);
    formDataa.append('consult_birthdate', consult_birthdate);
    formDataa.append('consult_nationalid', consult_nationalid);
    formDataa.append('consult_id', $("#consult_id").val());
    formDataa.append('consult_change_image', consult_change_image);
    formDataa.append('consult_username', consult_username);

    $.ajax({
        url: "_manager/consult/edit_consult_info",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات مشخصات مشاور");
        },
        success: function (result) {
            if (!result.error) {

                $("#menu_tab_skill").click();
                $(".dropify-clear").trigger("click");
                $('.ckeditor').val("");
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
    var consult_education = $("#consult_education").val();
    var consult_univercity = $("#consult_univercity").val();
    var abstractAbout = $("#abstractAbout").val();

    var skills = CKEDITOR.instances['skills'].getData();
    var learn_history = CKEDITOR.instances['learn_history'].getData();
    var about = CKEDITOR.instances['about'].getData();



    let formDataa = new FormData();
    formDataa.append('abstractAbout', abstractAbout);
    formDataa.append('about', about);
    formDataa.append('learn_history', learn_history);
    formDataa.append('skills', skills);
    formDataa.append('consult_education', consult_education);
    formDataa.append('consult_univercity', consult_univercity);
    formDataa.append('consult_id', $("#consult_id").val());

    $.ajax({
        url: "_manager/consult/edit_consult_skill",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات مشخصات مهارتی مشاور");
        },
        success: function (result) {
            if (!result.error) {

                $("#menu_tab_contact").click();
                $(".dropify-clear").trigger("click");
                $('.ckeditor').val("");
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

    var consult_mobile = $("#mobile").val();
    var consult_mobile2 = $("#mobile2").val();
    var consult_tel = $("#tel").val();
    var consult_tel_work = $("#tel_work").val();
    var consult_email = $("#email").val();
    var consult_website = $("#website").val();
    var consult_soroush = $("#soroush").val();
    var consult_eita = $("#eita").val();
    var consult_telegram = $("#telegram").val();
    var consult_instgram = $("#instagram").val();
    var consult_linkdin = $("#linkdin").val();
    var consult_whatapp = $("#whatsapp").val();
    var consult_aparat = $("#aparat").val();

    let formDataa = new FormData();
    formDataa.append('consult_mobile', consult_mobile);
    formDataa.append('consult_mobile2', consult_mobile2);
    formDataa.append('consult_tel', consult_tel);
    formDataa.append('consult_tel_work', consult_tel_work);
    formDataa.append('consult_email', consult_email);
    formDataa.append('consult_website', consult_website);
    formDataa.append('consult_soroush', consult_soroush);
    formDataa.append('consult_eita', consult_eita);
    formDataa.append('consult_telegram', consult_telegram);
    formDataa.append('consult_instgram', consult_instgram);
    formDataa.append('consult_linkdin', consult_linkdin);
    formDataa.append('consult_whatapp', consult_whatapp);
    formDataa.append('consult_aparat', consult_aparat);
    formDataa.append('consult_id', $("#consult_id").val());

    $.ajax({
        url: "_manager/consult/edit_consult_contact",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات مشخصات تماس مشاور");
        },
        success: function (result) {
            if (!result.error) {

                $("#menu_tab_bank").click();
                $(".dropify-clear").trigger("click");
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

$("#btn_update_bank_info").on("click",function (event) {

    var teacher_accountnumber = $("#account_no").val();
    var teacher_cardnumber = $("#cardnumber").val();
    var teacher_shabanumber = $("#shabanumber").val();

    let formDataa = new FormData();
    formDataa.append('consult_accountnumber', teacher_accountnumber);
    formDataa.append('consult_cardnumber', teacher_cardnumber);
    formDataa.append('consult_shabanumber', teacher_shabanumber);
    formDataa.append('consult_id', $("#consult_id").val());

    $.ajax({
        url: "_manager/consult/edit_consult_bank",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات مشخصات بانکی مشاور");
        },
        success: function (result) {
            if (!result.error) {

                $(".dropify-clear").trigger("click");
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

$("#btn_add_new_education").on("click",function(){
    var grade_new=$("#grade_new").val();
    var univercity_new=$("#univercity_new").val();

    let formDataa = new FormData();
    formDataa.append('grade_new', grade_new);
    formDataa.append('univercity_new', univercity_new);
    formDataa.append('consult_id', $("#consult_id").val());

    $.ajax({
        url: "_manager/consult/add_education",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت اطلاعات مهارتی");
        },
        success: function (result) {
            if (!result.error) {
                $("#grade_new").val("");
                $("#univercity_new").val("");
                var tr=`<tr id="tr_edu_"`+result.data+`><td>`+grade_new+`</td><td>`+univercity_new+`</td><td><a class="btn  btn-danger btn-app" onclick="deleteEducation(`+result.data+`)" title="حذف" style="height: auto;!important; padding: 5px;!important;"><i class="fa fa-trash"></i> حذف</a></td></tr>`;
                $("#table_education").append(tr);

                $('#eduction_model').modal('toggle');

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

$("#btn_set_consulting_time").on("click",function(){

    let formDataa = new FormData();
    formDataa.append('consult_date',$("#consult_date").val());
    formDataa.append('consult_time',$("#consult_time").val());
    formDataa.append('id_consulting', $("#id_consulting").val());

    $.ajax({
        url: "_manager/consult/set_consult_time",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تاریخخ مشاوره");
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

$("#btn_complete_consult").on("click",function(){

    let formDataa = new FormData();
    formDataa.append('user_score',$("#user_score").val());
    formDataa.append('user_comment',$("#user_comment").val());
    formDataa.append('consult_minutes',$("#consult_minutes").val());
    formDataa.append('id_consulting', $("#id_consulting").val());

    $.ajax({
        url: "_manager/consult/complete_consult",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("تکمیل و پایان مشاوره");
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
