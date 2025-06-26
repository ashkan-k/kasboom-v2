var webinar_datatable="";
var id_webinar=0;

function loadwebinars() {
    webinar_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/webinar/all_webinars",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <div class=""><img src="_upload_/_webinars_/'+row.code+'/small_'+row.image+'" class="avatar" alt="'+row.title+'"></div>';
                    return div;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.title;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.category_title;
                }
            },

            {
                mRender: function (data, type, row) {
                    return row.teacher_name;
                }
            },
            {
                mRender: function (data, type, row) {
                    if(row.price <1)
                        return 'رایگان';
                    else
                        return number_format(row.price)   + '  تومان ';
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.register_count
                    // return row.id_category;
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
                    var facts=`<a href="_manager/webinar/detail/`+row.id+`/`+title+`" title="اطلاعات بیشتر" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i> </a>&nbsp;`;
                    if(row.per_delete == true)
                        facts=facts+`<button type="button" onclick="deleteWebinar(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                    return facts;


                }
            },

        ]

    });

}

function loadComments() {
    table_comments.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: {
            url: "_manager/webinar/comments",
                type: "POST",
                data: function (d) {
                d.id_webinar =$("#id_webinar").val();
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
                var user=`<a href="profile/`+row.id_user+`" title="مشخصات کاربر ارسال کننده" target="_blank" class="btn btn-info  btn-sm text-white"> <i class="fa fa-user"></i> `+row.fullname+` </a>&nbsp;`;
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
                // facts=facts+`<button type="button" onclick="deleteComment(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                return facts;


            }
        },

    ]

    });
}

function loadUsers() {
    table_users.DataTable({
        // processing: true,
        // serverSide: true,

        // order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: {
            url: "_manager/webinar/users",
            type: "POST",
            data: function (d) {
                d.id_webinar =$("#id_webinar").val();
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
                    var user=`<a href="profile/`+row.id_user+`" title="مشخصات کاربر " target="_blank" class="btn btn-info  btn-sm text-white"> <i class="fa fa-user"></i> `+row.fullname+` </a>&nbsp;`;
                    return user;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.register_date;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.refID;
                }
            },
            {
                mRender: function (data, type, row) {
                    var facts="";
                    facts=facts+`<button type="button" onclick="viewFactor(`+row.id+`)" title="نمایش فاکتور" class="btn btn-success  btn-sm text-white"> <i class="fa fa-credit-card"></i></button>&nbsp;`;
                    return facts;


                }
            },

        ]

    });
}

function viewFactor(id) {
    alert("مشاهده فاکتور");
}

function deleteWebinar(id) {

    Swal.fire({
        title: 'حذف اطلاعات وبینار',
        text: "آیا برای حذف وبینار مطمئن هستید؟",
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
            $.ajax({
                url: "_manager/webinar/delete",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف وبینار");
                },
                success: function (result) {
                    if (!result.error) {
                        webinar_datatable.DataTable().ajax.reload();

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

$("#btn_add_webinar").on("click",function (event) {
    var webinar_image=$('#webinar_image')[0].files[0];
    var webinar_video=$('#webinar_video')[0].files[0];
    var webinar_category = $("#webinar_category").val();
    var webinar_teacher = $("#webinar_teacher").val();
    var webinar_teacher_name = $("#webinar_new_teacher_name").val();
    var webinar_teacher_percnet = $("#webinar_teacher_percnet").val();
    var webinar_cloud_url = $("#webinar_cloud_url").val();
    var webinar_sky_url = $("#webinar_sky_url").val();
    var webinar_title = $("#webinar_title").val();
    var webinar_abstractMemo = $("#webinar_abstractMemo").val();
    var webinar_price = $("#webinar_price").val();
    var webinar_old_price = $("#webinar_old_price").val();
    var webinar_discount = $("#webinar_discount").val();
    var webinar_capacity_register = $("#webinar_capacity_register").val();
    var webinar_date = $("#webinar_date").val();
    var webinar_start_time_hour = $("#webinar_start_time_hour").val();
    var webinar_start_time_minutes = $("#webinar_start_time_minutes").val();
    var webinar_hour = $("#webinar_hour").val();
    var webinar_minutes = $("#webinar_minutes").val();
    var webinar_have_certificate = $("#webinar_have_certificate").val();
    var webinar_certificate_memo = $("#webinar_certificate_memo").val();
    var webinar_save_status = $("#webinar_save_status").val();
    var webinar_state = $("#webinar_state").val();
    var webinar_have_ticket = $("#webinar_have_ticket").val();
    var webinar_have_quiz = $("#webinar_have_quiz").val();
    var webinar_mohtava = CKEDITOR.instances['webinar_mohtava'].getData();


    let formDataa = new FormData();
    formDataa.append('webinar_image', webinar_image);
    formDataa.append('webinar_video', webinar_video);
    formDataa.append('webinar_category', webinar_category);
    formDataa.append('webinar_teacher', webinar_teacher);
    formDataa.append('webinar_teacher_name', webinar_teacher_name);
    formDataa.append('webinar_cloud_url', webinar_cloud_url);
    formDataa.append('webinar_sky_url', webinar_sky_url);
    formDataa.append('webinar_title', webinar_title);
    formDataa.append('webinar_abstractMemo', webinar_abstractMemo);
    formDataa.append('webinar_price', webinar_price);
    formDataa.append('webinar_discount', webinar_discount);
    formDataa.append('webinar_capacity_register', webinar_capacity_register);
    formDataa.append('webinar_date', webinar_date);
    formDataa.append('webinar_start_time_hour', webinar_start_time_hour);
    formDataa.append('webinar_start_time_minutes', webinar_start_time_minutes);
    formDataa.append('webinar_hour', webinar_hour);
    formDataa.append('webinar_minutes', webinar_minutes);
    formDataa.append('webinar_save_status', webinar_save_status);
    formDataa.append('webinar_have_certificate', webinar_have_certificate);
    formDataa.append('webinar_certificate_memo', webinar_certificate_memo);
    formDataa.append('webinar_mohtava', webinar_mohtava);
    formDataa.append('webinar_state', webinar_state);
    formDataa.append('webinar_have_ticket', webinar_have_ticket);
    formDataa.append('webinar_have_quiz', webinar_have_quiz);
    formDataa.append('webinar_teacher_percnet', webinar_teacher_percnet);
    formDataa.append('webinar_old_price', webinar_old_price);

    $.ajax({
        url: "_manager/webinar/add_webinar",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت مشخصات اولیه وبینار آموزشی");
        },
        success: function (result) {
            if (!result.error) {
                id_webinar=result.data;
                $("#id_webinar").val(result.data);

                $('#form_intro').find("input[type=text], textarea").val("");
                $("#form_intro").trigger('reset');
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

$("#btn_add_webinar_attach").on("click",function (event) {
    var id_webinar = $("#id_webinar").val();
    var webinar_code = $("#webinar_code").val();
    var attach_title = $("#attach_title").val();
    var attach_file=$('#attach_file')[0].files[0];

    let formDataa = new FormData();
    formDataa.append('id_webinar', id_webinar);
    formDataa.append('webinar_code', webinar_code);
    formDataa.append('attach_title', attach_title);
    formDataa.append('attach_file', attach_file);
    $.ajax({
        url: "_manager/webinar/add_webinar_attach",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت مشخصات وبینار آموزشی");
        },
        success: function (result) {
            if (!result.error) {
                var webinar=result.data;
                var tr="<tr id='tr_"+webinar['id']+"'><td>"+attach_title+"</td>";
                tr=tr+"<td><a class='btn btn-success btn-sm' href='_upload_/_webinars_/"+webinar_code+"/attachs/"+webinar['attach_filename']+"' target='_blank'><i class='fa fa-download'></i>&nbsp; مشاهده </a> &nbsp;";
                tr=tr+"<a onclick='delete_attach("+webinar['id']+")' class='btn btn-danger btn-sm text-white' style='cursor: pointer'><i class='fa fa-trash'></i>&nbsp; حذف </a></td></tr>";
                $("#table_attach").append(tr);
                $("#attach_title").val("");
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
});

$("#btn_edit_webinar").on("click",function (event) {
    var webinar_image=$('#webinar_image')[0].files[0];
    var webinar_category = $("#webinar_category").val();
    var webinar_teacher = $("#webinar_teacher").val();
    var webinar_teacher_name = $("#webinar_new_teacher_name").val();
    var webinar_teacher_percnet = $("#webinar_teacher_percnet").val();
    var webinar_cloud_url = $("#webinar_cloud_url").val();
    var webinar_sky_url = $("#webinar_sky_url").val();
    var webinar_title = $("#webinar_title").val();
    var webinar_abstractMemo = $("#webinar_abstractMemo").val();
    var webinar_price = $("#webinar_price").val();
    var webinar_old_price = $("#webinar_old_price").val();
    var webinar_discount = $("#webinar_discount").val();
    var webinar_capacity_register = $("#webinar_capacity_register").val();
    var webinar_date = $("#webinar_date").val();
    var webinar_start_time_hour = $("#webinar_start_time_hour").val();
    var webinar_start_time_minutes = $("#webinar_start_time_minutes").val();
    var webinar_hour = $("#webinar_hour").val();
    var webinar_minutes = $("#webinar_minutes").val();
    var webinar_have_certificate = $("#webinar_have_certificate").val();
    var webinar_certificate_memo = $("#webinar_certificate_memo").val();
    var webinar_save_status = $("#webinar_save_status").val();
    var webinar_state = $("#webinar_state").val();
    var webinar_have_ticket = $("#webinar_have_ticket").val();
    var webinar_have_quiz = $("#webinar_have_quiz").val();
    var webinar_mohtava = CKEDITOR.instances['webinar_mohtava'].getData();
    var id_webinar = $("#id_webinar").val();


    let formDataa = new FormData();
    formDataa.append('webinar_image', webinar_image);
    formDataa.append('id_webinar', id_webinar);
    formDataa.append('webinar_category', webinar_category);
    formDataa.append('webinar_teacher', webinar_teacher);
    formDataa.append('webinar_teacher_name', webinar_teacher_name);
    formDataa.append('webinar_cloud_url', webinar_cloud_url);
    formDataa.append('webinar_sky_url', webinar_sky_url);
    formDataa.append('webinar_title', webinar_title);
    formDataa.append('webinar_abstractMemo', webinar_abstractMemo);
    formDataa.append('webinar_price', webinar_price);
    formDataa.append('webinar_discount', webinar_discount);
    formDataa.append('webinar_capacity_register', webinar_capacity_register);
    formDataa.append('webinar_date', webinar_date);
    formDataa.append('webinar_start_time_hour', webinar_start_time_hour);
    formDataa.append('webinar_start_time_minutes', webinar_start_time_minutes);
    formDataa.append('webinar_hour', webinar_hour);
    formDataa.append('webinar_minutes', webinar_minutes);
    formDataa.append('webinar_save_status', webinar_save_status);
    formDataa.append('webinar_have_certificate', webinar_have_certificate);
    formDataa.append('webinar_certificate_memo', webinar_certificate_memo);
    formDataa.append('webinar_mohtava', webinar_mohtava);
    formDataa.append('webinar_state', webinar_state);
    formDataa.append('webinar_have_ticket', webinar_have_ticket);
    formDataa.append('webinar_have_quiz', webinar_have_quiz);
    formDataa.append('webinar_teacher_percnet', webinar_teacher_percnet);
    formDataa.append('webinar_old_price', webinar_old_price);

    $.ajax({
        url: "_manager/webinar/edit_webinar",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت مشخصات وبینار آموزشی");
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

function delete_attach(id) {
    Swal.fire({
        title: 'حذف فایل ضممیه ',
        text: "آیا برای حذف فایل ضمیمه وبینار مطمئن هستید؟",
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
            $.ajax({
                url: "_manager/webinar/delete_attach",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف وبینار");
                },
                success: function (result) {
                    if (!result.error) {
                        $("#tr_"+id).remove();
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


