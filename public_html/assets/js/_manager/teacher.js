var teacher_change_image=0;
var teacher_id=0;
var code="";
var image="";

function loadteachers() {

    teacher_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_teachers",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <div class=""><img src="_upload_/_teachers_/'+row.code+'/small_'+row.image+'" class="avatar cover-image avatar-lg brround" alt="'+row.title+'"></div>';
                    return div;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.fullname;
                }
            },

            {
                mRender: function (data, type, row) {
                    return row.education;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.course_count;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.total_income
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.wallet;
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
                    var facts=`<a href="_manager/teacher/`+row.id+`/`+title+`" title="جزئیات و ویرایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-edit"></i> </a>&nbsp;`;
                    if(row.per_delete == true)
                        facts=facts+`<button type="button" onclick="deleteTeacher(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                    return facts;


                }
            },

        ]

    });
}

function loadTeacherCommments() {
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
            url: "_manager/teacher/comments",
                type: "POST",
                data: function (d) {
                d.id_teacher =$("#teacher_id").val();
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

function deleteTeacher(id) {

    Swal.fire({
        title: 'حذف مدرس',
        text: "آیا برای حذف مدرس مطمئن هستید؟",
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
                url: "_manager/teacher/delete_teacher",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف اطلاعات مدرس");
                },
                success: function (result) {
                    if (!result.error) {
                        teacher_datatable.DataTable().ajax.reload();

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
        ajax: "_manager/all_teacher_comments",
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
                    return row.teacher_name;
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
                    var facts="";
                    facts=facts+`<button type="button" onclick="viewComment(`+row.id+`)" title="نمایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i></button>&nbsp;`;
                    return facts;

                }
            },

        ]

    });
}

function loadTeacherCourses() {
    course_table.DataTable({
        // processing: true,
        // serverSide: true,

        // order: [[1, 'asc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: {
            url: "_manager/teacher/all_courses",
            type: "POST",
            data: function (d) {
                d.id_teacher =$("#teacher_id").val();
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

                    var div='<img src="_upload_/_courses_/'+row.code+'/'+row.image+'" class="avatar" alt="'+row.title+'" />';
                    return div;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.title;
                    return div;
                }
            },

            {
                mRender: function (data, type, row) {
                    if(row.price <1)
                        return 'رایگان';
                    else
                        return row.price   + '  تومان ';
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.register_count + ' نفر ';
                    // return row.id_category;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.view_count;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.like_count;
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
                    var title=row.title;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var facts=`<a href="_manager/course/`+row.id+`/`+title+`" title="جزئیات و ویرایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-edit"></i> </a>&nbsp;`;
                    facts=facts+`<a href="_manager/teacher/course/`+row.id+`/users`+`" title="مهارت آموزان" class="btn btn-success btn-sm text-white"><i class="fa fa-users"></i> </a>&nbsp;`;
                    return facts;

                }
            },


        ]

    });

}

function addEducation(){
    $("#grade_new").val("");
    $("#univercity_new").val("");
    $('#eduction_model').modal('toggle');

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
            formDataa.append('teacher_id', $("#teacher_id").val());
            $.ajax({
                url: "_manager/teacher/delete_education",
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

$("#btn_add_teacher").on("click",function (event) {
    var teacher_cloud_url = $("#teacher_cloud_url").val();
    var teacher_category = $("#teacher_category").val();
    var teacher_name = $("#teacher_name").val();
    var teacher_education = $("#teacher_education").val();
    var teacher_univercity = $("#teacher_univercity").val();
    var teacher_mobile = $("#teacher_mobile").val();
    var teacher_mobile2 = $("#teacher_mobile2").val();
    var teacher_tel_work = $("#teacher_tel_work").val();
    var teacher_tel = $("#teacher_tel").val();
    var state = $("#state").val();
    var city = $("#city").val();
    var teacher_address_work = $("#teacher_address_work").val();
    var teacher_address_home = $("#teacher_address_home").val();
    var teacher_course_count = $("#teacher_course_count").val();
    var teacher_married = $("#teacher_married").val();
    var teacher_job = $("#teacher_job").val();
    var teacher_gender = $("#teacher_gender").val();
    var teacher_birthdate_place = $("#teacher_birthdate_place").val();
    var teacher_birthdate = $("#teacher_birthdate").val();
    var teacher_nationalid = $("#teacher_nationalid").val();
    var teacher_password = $("#teacher_password").val();
    var teacher_image=$('#teacher_image')[0].files[0];
    var teacher_username=$('#username').val();



    let formDataa = new FormData();
    formDataa.append('teacher_image', teacher_image);
    formDataa.append('teacher_cloud_url', teacher_cloud_url);
    formDataa.append('teacher_category', teacher_category);
    formDataa.append('teacher_name', teacher_name);
    formDataa.append('teacher_education', teacher_education);
    formDataa.append('teacher_univercity', teacher_univercity);
    formDataa.append('teacher_mobile', teacher_mobile);
    formDataa.append('teacher_mobile2', teacher_mobile2);
    formDataa.append('teacher_tel_work', teacher_tel_work);
    formDataa.append('teacher_tel', teacher_tel);
    formDataa.append('state', state);
    formDataa.append('city', city);
    formDataa.append('teacher_address_work', teacher_address_work);
    formDataa.append('teacher_address_home', teacher_address_home);
    formDataa.append('teacher_course_count', teacher_course_count);
    formDataa.append('teacher_married', teacher_married);
    formDataa.append('teacher_job', teacher_job);
    formDataa.append('teacher_gender', teacher_gender);
    formDataa.append('teacher_birthdate_place', teacher_birthdate_place);
    formDataa.append('teacher_birthdate', teacher_birthdate);
    formDataa.append('teacher_nationalid', teacher_nationalid);
    formDataa.append('teacher_password', teacher_password);
    formDataa.append('teacher_username', teacher_username);


    $.ajax({
        url: "_manager/teacher/add_teacher",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت مدرس آموزشی");
        },
        success: function (result) {
            if (!result.error) {

                $('#teacher_form').find("input[type=text], textarea").val("");
                $("#teacher_form").trigger('reset');
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
    var teacher_cloud_url = $("#teacher_cloud_url").val();
    var teacher_category = $("#teacher_category").val();
    var teacher_name = $("#teacher_name").val();
    var teacher_education = $("#teacher_education").val();
    var teacher_univercity = $("#teacher_univercity").val();
    var state = $("#state").val();
    var city = $("#city").val();
    var teacher_address_work = $("#teacher_address_work").val();
    var teacher_address_home = $("#teacher_address_home").val();
    var teacher_married = $("#teacher_married").val();
    var teacher_job = $("#teacher_job").val();
    var teacher_gender = $("#teacher_gender").val();
    var teacher_birthdate_place = $("#teacher_birthdate_place").val();
    var teacher_birthdate = $("#teacher_birthdate").val();
    var teacher_nationalid = $("#teacher_nationalid").val();
    var teacher_username = $("#username").val();
    var teacher_image=$('#teacher_image')[0].files[0];


    let formDataa = new FormData();
    formDataa.append('teacher_image', teacher_image);
    formDataa.append('teacher_cloud_url', teacher_cloud_url);
    formDataa.append('teacher_category', teacher_category);
    formDataa.append('teacher_name', teacher_name);
    formDataa.append('teacher_education', teacher_education);
    formDataa.append('teacher_univercity', teacher_univercity);
    formDataa.append('state', state);
    formDataa.append('city', city);
    formDataa.append('teacher_address_work', teacher_address_work);
    formDataa.append('teacher_address_home', teacher_address_home);
    formDataa.append('teacher_married', teacher_married);
    formDataa.append('teacher_job', teacher_job);
    formDataa.append('teacher_gender', teacher_gender);
    formDataa.append('teacher_birthdate_place', teacher_birthdate_place);
    formDataa.append('teacher_birthdate', teacher_birthdate);
    formDataa.append('teacher_nationalid', teacher_nationalid);
    formDataa.append('teacher_id', $("#teacher_id").val());
    formDataa.append('teacher_change_image', teacher_change_image);
    formDataa.append('teacher_username', teacher_username);

    $.ajax({
        url: "_manager/teacher/edit_teacher_info",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات مشخصات مدرس");
        },
        success: function (result) {
            if (!result.error) {

                $('#form_info').find("input[type=text], textarea").val("");
                $("#form_info").trigger('reset');
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
    var teacher_education = $("#teacher_education").val();
    var teacher_univercity = $("#teacher_univercity").val();
    var abstractAbout = $("#abstractAbout").val();

    var skills = CKEDITOR.instances['skills'].getData();
    var learn_history = CKEDITOR.instances['learn_history'].getData();
    var about = CKEDITOR.instances['about'].getData();



    let formDataa = new FormData();
    formDataa.append('abstractAbout', abstractAbout);
    formDataa.append('about', about);
    formDataa.append('learn_history', learn_history);
    formDataa.append('skills', skills);
    formDataa.append('teacher_education', teacher_education);
    formDataa.append('teacher_univercity', teacher_univercity);
    formDataa.append('teacher_id', $("#teacher_id").val());

    $.ajax({
        url: "_manager/teacher/edit_teacher_skill",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات مشخصات مهارتی مدرس");
        },
        success: function (result) {
            if (!result.error) {

                // $('#from_skill').find("input[type=text], textarea").val("");
                // $("#from_skill").trigger('reset');
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

    var teacher_mobile = $("#mobile").val();
    var teacher_mobile2 = $("#mobile2").val();
    var teacher_tel = $("#tel").val();
    var teacher_tel_work = $("#tel_work").val();
    var teacher_email = $("#email").val();
    var teacher_website = $("#website").val();
    var teacher_soroush = $("#soroush").val();
    var teacher_eita = $("#eita").val();
    var teacher_telegram = $("#telegram").val();
    var teacher_instgram = $("#instagram").val();
    var teacher_linkdin = $("#linkdin").val();
    var teacher_whatapp = $("#whatsapp").val();
    var teacher_aparat = $("#aparat").val();

    let formDataa = new FormData();
    formDataa.append('teacher_mobile', teacher_mobile);
    formDataa.append('teacher_mobile2', teacher_mobile2);
    formDataa.append('teacher_tel', teacher_tel);
    formDataa.append('teacher_tel_work', teacher_tel_work);
    formDataa.append('teacher_email', teacher_email);
    formDataa.append('teacher_website', teacher_website);
    formDataa.append('teacher_soroush', teacher_soroush);
    formDataa.append('teacher_eita', teacher_eita);
    formDataa.append('teacher_telegram', teacher_telegram);
    formDataa.append('teacher_instgram', teacher_instgram);
    formDataa.append('teacher_linkdin', teacher_linkdin);
    formDataa.append('teacher_whatapp', teacher_whatapp);
    formDataa.append('teacher_aparat', teacher_aparat);
    formDataa.append('teacher_id', $("#teacher_id").val());

    $.ajax({
        url: "_manager/teacher/edit_teacher_contact",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات مشخصات تماس مدرس");
        },
        success: function (result) {
            if (!result.error) {

                // $('#from_skill').find("input[type=text], textarea").val("");
                // $("#from_skill").trigger('reset');
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
    formDataa.append('teacher_accountnumber', teacher_accountnumber);
    formDataa.append('teacher_cardnumber', teacher_cardnumber);
    formDataa.append('teacher_shabanumber', teacher_shabanumber);
    formDataa.append('teacher_id', $("#teacher_id").val());

    $.ajax({
        url: "_manager/teacher/edit_teacher_bank",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات مشخصات بانکی مدرس");
        },
        success: function (result) {
            if (!result.error) {

                // $('#from_bank').find("input[type=text], textarea").val("");
                // $("#from_bank").trigger('reset');
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
    formDataa.append('teacher_id', $("#teacher_id").val());

    $.ajax({
        url: "_manager/teacher/add_education",
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
                var tr=`<tr id="tr_edu_`+result.data+`"><td>`+grade_new+`</td><td>`+univercity_new+`</td><td><a class="btn  btn-danger btn-app" onclick="deleteEducation(`+result.data+`)" title="حذف" style="height: auto;!important; padding: 5px;!important;"><i class="fa fa-trash"></i> حذف</a></td></tr>`;
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

