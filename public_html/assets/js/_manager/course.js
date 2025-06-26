var id_course=0;

function loadcourses() {

    course_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_courses",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div='<img src="_upload_/_courses_/'+row.code+'/small_'+row.image+'" class="avatar" alt="'+row.title+'">';
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
                    return row.teacher_name;
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
                    return row.register_count
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
                    facts=facts+`<button type="button" onclick="deleteCourse(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                    return facts;

                }
            },

        ]

    });

}

function loadIdeaCommments() {
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
            url: "_manager/wikiideas/comments",
            type: "POST",
            data: function (d) {
                d.id_idea =idea_id;
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
                    var title=row.fullname;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var user=`<a href="profile/`+row.id_user+`/`+title+`" title="مشخصات کاربر ارسال کننده" target="_blank" class="btn btn-info  btn-sm text-white"> <i class="fa fa-user"></i> `+row.fullname+` </a>&nbsp;`;
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
                    facts=facts+`<button type="button" onclick="deleteComment(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                    return facts;


                }
            },

        ]

    });





}

function deleteCourse(id) {

    Swal.fire({
        title: 'حذف دوره آموزشی',
        text: "آیا برای حذف دوره آموزشی مطمئن هستید؟",
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
                url: "_manager/course/delete_course",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف دوره آموزشی");
                },
                success: function (result) {
                    if (!result.error) {
                        course_datatable.DataTable().ajax.reload();

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

$("#btn_add_course_intro").on("click",function (event) {
    var course_image=$('#course_image')[0].files[0];
    var course_video=$('#course_video')[0].files[0];

    var course_category = $("#course_category").val();
    var course_teacher = $("#course_teacher").val();
    var course_cloud_url = $("#course_cloud_url").val();
    var course_title = $("#course_title").val();
    var course_price = $("#course_price").val();
    var course_discount = $("#course_discount").val();
    var course_hour = $("#course_hour").val();
    var course_minutes = $("#course_minutes").val();
    var course_have_certificate = $("#course_have_certificate").val();
    var course_certificate_memo = $("#course_certificate_memo").val();
    var course_learn_type = $("#course_learn_type").val();
    var course_state = $("#course_state").val();
    var course_have_ticket = $("#course_have_ticket").val();
    var course_have_quiz = $("#course_have_quiz").val();
    var course_teacher_percnet = $("#course_teacher_percnet").val();
    var course_old_price = $("#course_old_price").val();
    var course_level = $("#course_level").val();


    let formDataa = new FormData();
    formDataa.append('course_image', course_image);
    formDataa.append('course_video', course_video);
    formDataa.append('course_category', course_category);
    formDataa.append('course_teacher', course_teacher);
    formDataa.append('course_cloud_url', course_cloud_url);
    formDataa.append('course_title', course_title);
    formDataa.append('course_price', course_price);
    formDataa.append('course_discount', course_discount);
    formDataa.append('course_hour', course_hour);
    formDataa.append('course_minutes', course_minutes);
    formDataa.append('course_have_certificate', course_have_certificate);
    formDataa.append('course_certificate_memo', course_certificate_memo);
    formDataa.append('course_learn_type', course_learn_type);
    formDataa.append('course_state', course_state);
    formDataa.append('course_level', course_level);
    formDataa.append('course_have_ticket', course_have_ticket);
    formDataa.append('course_have_quiz', course_have_quiz);
    formDataa.append('course_teacher_percnet', course_teacher_percnet);
    formDataa.append('course_old_price', course_old_price);

    $.ajax({
        url: "_manager/course/add_course",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت مشخصات اولیه دوره آموزشی");
        },
        success: function (result) {
            if (!result.error) {
                id_course=result.data;
                $("#id_course").val(result.data);
                $("#btn_add_course_intro").prop("disabled",true);
                // $("#tab_info_").click();
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

$("#btn_add_course_info").on("click",function (event) {
    var course_minimal_fund = $("#course_minimal_fund").val();
    var course_risk = $("#course_risk").val();
    var course_profitability = $("#course_profitability").val();
    var course_profitability_memo = $("#course_profitability_memo").val();
    var course_manpower = $("#course_manpower").val();
    var course_scale = $("#course_scale").val();
    var course_abstractMemo = $("#course_abstractMemo").val();
    var id_course=$("#id_course").val();
    var course_memo = CKEDITOR.instances['course_memo'].getData();


    let formDataa = new FormData();
    formDataa.append('id_course', id_course);
    formDataa.append('course_minimal_fund', course_minimal_fund);
    formDataa.append('course_risk', course_risk);
    formDataa.append('course_profitability', course_profitability);
    formDataa.append('course_profitability_memo', course_profitability_memo);
    formDataa.append('course_manpower', course_manpower);
    formDataa.append('course_scale', course_scale);
    formDataa.append('course_abstractMemo', course_abstractMemo);
    formDataa.append('course_memo', course_memo);

    $.ajax({
        url: "_manager/course/edit_course_info",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت اطلاعات کلی دوره آموزشی آموزشی");
        },
        success: function (result) {
            if (!result.error) {
                $("#tab_content_").click();
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

$("#btn_add_course_content").on("click",function (event) {
    var id_course=$("#id_course").val();
    var course_mohtava = CKEDITOR.instances['course_mohtava'].getData();

    console.log(course_mohtava);
    let formDataa = new FormData();
    formDataa.append('id_course', id_course);
    formDataa.append('course_content', course_mohtava);
    $.ajax({
        url: "_manager/course/edit_course_content",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت سرفصل های دوره آموزشی آموزشی");
        },
        success: function (result) {
            if (!result.error) {
                $("#tab_lesson_").click();
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

$("#btn_add_course_lesson").on("click",function (event) {
    var lesson_no = $("#lesson_no").val();
    var lesson_cloud_url = $("#lesson_cloud_url").val();
    var lesson_title = $("#lesson_title").val();
    var lesson_memo = $("#lesson_memo").val();
    var lesson_hour = $("#lesson_hour").val();
    var lesson_minutes = $("#lesson_minutes").val();

    var isFree=0;
    if ($('#isFree').is(":checked"))
        isFree = 1;
    else
        isFree = 0;
    var id_course=$("#id_course").val();



    let formDataa = new FormData();
    formDataa.append('lesson_no', lesson_no);
    formDataa.append('lesson_cloud_url', lesson_cloud_url);
    formDataa.append('lesson_title', lesson_title);
    formDataa.append('lesson_memo', lesson_memo);
    formDataa.append('lesson_hour', lesson_hour);
    formDataa.append('lesson_minutes', lesson_minutes);
    formDataa.append('isFree', isFree);
    formDataa.append('id_course', id_course);

    $.ajax({
        url: "_manager/course/add_lesson",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت مشخصات اولیه دوره آموزشی");
        },
        success: function (result) {
            if (!result.error) {
                var lesson_id=result.data;
                var lesson_url=$("#lesson_cloud_url").val();
                var tr="<tr id='tr_lesson_"+lesson_id+"'>";
                if(isFree==1)
                    tr=tr+"<td> درس "+lesson_no+" - <b class='text-info'>رایگان</b></td>";
                else
                    tr=tr+"<td> درس "+lesson_no+"</td>";
                tr=tr+"<td>"+lesson_title+"</td>";
                tr=tr+"<td>"+lesson_hour+" ساعت و "+lesson_minutes+" دقیقه</td>";
                tr=tr+"<td>"+lesson_memo+"</td>";
                tr=tr+"<td><a class='btn btn-app' onclick='viewAttachLesson("+lesson_id+")'  title='فایل های ضمیمه'  style='height: auto;!important; padding: 5px;!important;'><i class='fa fa-files-o'></i> ضمائم</a>";
                tr=tr+`<a class='btn btn-app' onclick='viewVideoLesson("`+lesson_url+`")'  title='مشاهده ویدیو'  style='height: auto;!important; padding: 5px;!important;'><i class='fa fa-video-camera'></i> ویدیو</a>`;
                tr=tr+"<a class='btn btn-app' onclick='editLesson("+lesson_id+")'  title='ویرایش اطلاعات'  style='height: auto;!important; padding: 5px;!important;'><i class='fa fa-edit'></i> ویرایش</a>";
                tr=tr+"<a class='btn btn-app' onclick='deleteLesson("+lesson_id+")'  title='حذف درس'  style='height: auto;!important; padding: 5px;!important;'><i class='fa fa-trash'></i> حذف</a></td>";
                $("#table_lesson").append(tr);

                $("#lesson_cloud_url").val("");
                $("#lesson_title").val("");
                $("#lesson_memo").val("");
                $("#lesson_hour").val("");
                $("#lesson_minutes").val("");
                $("#lesson_title").focus();
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

$("#btn_add_lesson_attach").on("click",function (event) {
    var attach_title = $("#attach_title").val();
    var attach_file=$('#attach_file')[0].files[0];
    var id_course = $("#id_course").val();
    var id_lesson = $("#id_lesson_attach").val();
    var course_code = $("#course_code").val();

    let formDataa = new FormData();
    formDataa.append('attach_title', attach_title);
    formDataa.append('attach_file', attach_file);
    formDataa.append('id_course', id_course);
    formDataa.append('id_lesson', id_lesson);
    formDataa.append('course_code', course_code);

    $.ajax({
        url: "_manager/course/add_lesson_attach",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت فایل ضمیمه درس ");
        },
        success: function (result) {
            if (!result.error) {
                var lesson_attach_id=result.data;
                var tr="<tr id='lesson_attach_'"+lesson_attach_id+">";
                tr=tr+"<td>"+lesson_attach_id+"</td>";
                tr=tr+"<td>"+attach_title+"</td>";
                tr=tr+"<td><a href='' title='دانلود' class='btn btn-bitbucket  btn-sm text-white' target='_blank' ><i class='fa fa-eye'></i></a>&nbsp;";
                tr=tr+"<a title='حذف' class='btn btn-danger  btn-sm text-white' onclick='deleteAttachment("+lesson_attach_id+")' ><i class='fa fa-trash'></i></a></td>";
                $("#table_attach").append(tr);

                $("#attach_title").val("");
                $(".dropify-clear").trigger("click");
                $("#attach_title").focus();
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

$("#btn_edit_course_intro").on("click",function (event) {
    var course_image=$('#course_image')[0].files[0];

    var course_category = $("#course_category").val();
    var course_teacher = $("#course_teacher").val();
    var course_cloud_url = $("#course_cloud_url").val();
    var course_title = $("#course_title").val();
    var course_price = $("#course_price").val();
    var course_discount = $("#course_discount").val();
    var course_hour = $("#course_hour").val();
    var course_minutes = $("#course_minutes").val();
    var course_have_certificate = $("#course_have_certificate").val();
    var course_certificate_memo = $("#course_certificate_memo").val();
    var course_learn_type = $("#course_learn_type").val();
    var course_state = $("#course_state").val();
    var course_level = $("#course_level").val();
    var course_have_ticket = $("#course_have_ticket").val();
    var course_have_quiz = $("#course_have_quiz").val();
    var course_teacher_percnet = $("#course_teacher_percnet").val();
    var course_old_price = $("#course_old_price").val();
    var id_course = $("#id_course").val();

    let formDataa = new FormData();
    formDataa.append('course_image', course_image);
    formDataa.append('course_category', course_category);
    formDataa.append('course_teacher', course_teacher);
    formDataa.append('course_cloud_url', course_cloud_url);
    formDataa.append('course_title', course_title);
    formDataa.append('course_price', course_price);
    formDataa.append('course_discount', course_discount);
    formDataa.append('course_hour', course_hour);
    formDataa.append('course_minutes', course_minutes);
    formDataa.append('course_have_certificate', course_have_certificate);
    formDataa.append('course_certificate_memo', course_certificate_memo);
    formDataa.append('course_learn_type', course_learn_type);
    formDataa.append('course_state', course_state);
    formDataa.append('course_level', course_level);
    formDataa.append('course_have_ticket', course_have_ticket);
    formDataa.append('course_have_quiz', course_have_quiz);
    formDataa.append('course_teacher_percnet', course_teacher_percnet);
    formDataa.append('course_old_price', course_old_price);
    formDataa.append('id_course', id_course);

    $.ajax({
        url: "_manager/course/edit_course",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت مشخصات اولیه دوره آموزشی");
        },
        success: function (result) {
            if (!result.error) {
                $("#btn_add_course_intro").prop("disabled",true);
                $("#tab_info_").click();
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

$("#btn_edit_course_lesson").on("click",function (event) {
    var lesson_no=$("#lesson_no_edit").val();
    var lesson_cloud_url= $("#lesson_cloud_url_edit").val();
    var lesson_title=$("#lesson_title_edit").val();
    var lesson_memo=$("#lesson_memo_edit").val();
    var lesson_hour=$("#lesson_hour_edit").val();
    var lesson_minutes=$("#lesson_minutes_edit").val();
    var lesson_id=$("#lesson_edit_id").val();
    var id_course = $("#id_course").val();

    var isFree=0;
    if ($('#isFree_edit').is(":checked"))
        isFree = 1;
    else
        isFree = 0;


    let formDataa = new FormData();
    formDataa.append('lesson_no', lesson_no);
    formDataa.append('lesson_cloud_url', lesson_cloud_url);
    formDataa.append('lesson_title', lesson_title);
    formDataa.append('lesson_memo', lesson_memo);
    formDataa.append('lesson_hour', lesson_hour);
    formDataa.append('lesson_minutes', lesson_minutes);
    formDataa.append('lesson_id', lesson_id);
    formDataa.append('isFree', isFree);
    formDataa.append('id_course', id_course);
    $.ajax({
        url: "_manager/course/edit_lesson",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت مشخصات درس");
        },
        success: function (result) {
            ShowMessage(result.message, result.type);

            if (!result.error) {
                $('#lesson_edit_modal').modal('toggle');


                $('#tr_lesson_'+lesson_id).remove();
                var tr="<tr id='lesson_'"+lesson_id+">";
                if(isFree==1)
                    tr=tr+"<td> درس "+lesson_no+" - <b class='text-info'>رایگان</b></td>";
                else
                    tr=tr+"<td> درس "+lesson_no+"</td>";
                tr=tr+"<td>"+lesson_title+"</td>";
                tr=tr+"<td>"+lesson_hour+" ساعت و "+lesson_minutes+" دقیقه</td>";
                tr=tr+"<td>"+lesson_memo+"</td>";
                tr=tr+"<td><a class='btn btn-app' onclick='viewAttachLesson("+lesson_id+")'  title='فایل های ضمیمه'  style='height: auto;!important; padding: 5px;!important;'><i class='fa fa-files-o'></i> ضمائم</a>";
                tr=tr+`<a class='btn btn-app' onclick='viewVideoLesson("`+lesson_cloud_url+`")'  title='مشاهده ویدیو'  style='height: auto;!important; padding: 5px;!important;'><i class='fa fa-video-camera'></i> ویدیو</a>`;
                tr=tr+"<a class='btn btn-app' onclick='editLesson("+lesson_id+")'  title='ویرایش اطلاعات'  style='height: auto;!important; padding: 5px;!important;'><i class='fa fa-edit'></i> ویرایش</a>";
                tr=tr+"<a class='btn btn-app' onclick='deleteLesson("+lesson_id+")'  title='حذف درس'  style='height: auto;!important; padding: 5px;!important;'><i class='fa fa-trash'></i> حذف</a></td>";

                $("#table_lesson").append(tr);

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

$("#btn_add_new_question").on("click", function (event){
    var quiz_question=$("#quiz_question").val();
    var quiz_option1=$("#quiz_option1").val();
    var quiz_option2=$("#quiz_option2").val();
    var quiz_option3=$("#quiz_option3").val();
    var quiz_option4=$("#quiz_option4").val();
    var quiz_answer=$("#quiz_answer").val();
    var id_course=$("#id_course").val();

    let formDataa = new FormData();
    formDataa.append('quiz_question', quiz_question);
    formDataa.append('quiz_option1', quiz_option1);
    formDataa.append('quiz_option2', quiz_option2);
    formDataa.append('quiz_option3', quiz_option3);
    formDataa.append('quiz_option4', quiz_option4);
    formDataa.append('quiz_answer', quiz_answer);
    formDataa.append('id_course', id_course);
    $.ajax({
        url: "_manager/course/add_quiz_question",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت سوال آزمونی");
        },
        success: function (result) {
            ShowMessage(result.message, result.type);

            if (!result.error) {
                $("#quiz_question").val("");
                $("#quiz_option1").val("");
                $("#quiz_option2").val("");
                $("#quiz_option3").val("");
                $("#quiz_option4").val("");
                $("#quiz_answer").val(1);
                table_quiz.DataTable().ajax.reload();

                $('#lesson_add_question_modal').modal('toggle');
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

$("#btn_add_reply_message").on("click",function (event) {
    let targerData = new FormData();
    targerData.append('id_mess', $("#mess_id").val());
    targerData.append('id_course', $("#id_course").val());
    targerData.append('reply_message', $("#reply_mess_message").val());
    $.ajax({
        url: "_manager/course/reply_message",
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

function loaddatatables() {
    //load comments
    mydatatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: {
            url: "_manager/course/comments",
            data: function (d) {
                d.id_course =$("#id_course").val();
            },
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            complete: function (json){
                // var jsonData = obj.data;
                // alert(jsonData.length);
                // comment_count=jsonData.length;
                // for (var i=0;i<jsonData.length;i=i+1){
                //     var elementID=jsonData[i]['id'];
                //     var elementTitle = jsonData[i]['Title_DB'];
                //     var fs = "<option value='" + elementID + "'>" + elementTitle + "</option>";
                //     $("#TargetDB").append(fs);
                //     ListDBForMerg.push(elementID);
                // }
            }
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
                    return row.score + " از  5  ";
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.regist_date;
                }
            },
            {
                mRender: function (data, type, row) {
                    var abstract=makeAbstract(row.comment,100);
                    var span='<span title="'+row.comment+'">'+abstract+'</span>';
                    return span;
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

    // load quess
    table_quiz.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'asc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: {
            url: "_manager/course/quizques",
            data: function (d) {
                d.id_course =$("#id_course").val();
            },
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            complete: function (json){
                // var obj = JSON.parse(json.responseText);
                // var jsonData = obj.data;
                // alert(jsonData.length);
                // comment_count=jsonData.length;
                // for (var i=0;i<jsonData.length;i=i+1){
                //     var elementID=jsonData[i]['id'];
                //     var elementTitle = jsonData[i]['Title_DB'];
                //     var fs = "<option value='" + elementID + "'>" + elementTitle + "</option>";
                //     $("#TargetDB").append(fs);
                //     ListDBForMerg.push(elementID);
                // }
            }
        },
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.question;
                }
            },
            {
                mRender: function (data, type, row) {

                    if(row.answer ==1){
                        var div=`<div class="text-success"><i class='fa fa-check'>`+row.option1;+` </div>`
                        return div;
                    }
                    else
                        return row.option1;
                }
            },

            {
                mRender: function (data, type, row) {
                    if(row.answer ==2){
                        var div=`<div class="text-success"><i class='fa fa-check'>`+row.option2;+` </div>`
                        return div;
                    }
                    else
                        return row.option2;

                }
            },
            {
                mRender: function (data, type, row) {
                    if(row.answer ==3){
                        var div=`<div class="text-success"><i class='fa fa-check'>`+row.option3;+` </div>`
                        return div;
                    }
                    else
                        return row.option3;

                }
            },
            {
                mRender: function (data, type, row) {
                    if(row.answer ==4){
                        var div=`<div class="text-success"><i class='fa fa-check'>`+row.option4;+` </div>`
                        return div;
                    }
                    else
                        return row.option4;

                }
            },
            {
                mRender: function (data, type, row) {
                    var id=row.id;
                    var facts=`<button onclick="deleteQues(`+id+`)" class="btn btn-danger btn-sm" title="حذف سوال"  ><i class="fa fa-trash"></i></button>`;
                    return facts;


                }
            },
        ]

    });
    //
    // // load users
    table_users.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: {
            url: "_manager/course/users",
            data: function (d) {
                d.id_course =$("#id_course").val();
            },
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            complete: function (json){
            }
        },
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <img src="_upload_/_users_/'+row.id_user+'/personal/'+row.image+'" class="avatar avatar-lg cover-image" alt="'+row.fullname+'">';
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
                    return row.regist_date;
                }
            },

            {
                mRender: function (data, type, row) {
                    var div=' <div class="project-details"><div class="project-info">';
                    if (row.result == 'learning')
                        div=div+'<div class="status approved"><i class="icon-pencil"></i> در حال آموزش</div></div></div>';
                    else
                    {
                        div=div+'<div class="status approved"><i class="icon-check_circle"></i> تکمیل دوره</div></div></div>';
                    }
                    return div;

                }
            },
            {
                mRender: function (data, type, row) {
                    if(row.result == 'learning')
                        return '-----';
                    else
                        return row.quiz_score;
                }
            },
            {
                mRender: function (data, type, row) {
                    var title=row.fullname;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var facts=`<a href="profile/`+row.id_user+`/`+title+`" target="_blank" class="btn btn-success btn-sm" title="مشاهده پروفایل مهارت آموز">  <i class="fa fa-eye"> </i></a>`;
                    return facts;


                }
            },
        ]

    });
    //
    // // load message
    table_messages.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[2, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: {
            url: "_manager/course/messages",
            data: function (d) {
                d.id_course =$("#id_course").val();
            },
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $("#csrf-token").attr('content')
            },
            complete: function (json){
                // var obj = JSON.parse(json.responseText);
                // var jsonData = obj.data;
                // alert(jsonData.length);
                // comment_count=jsonData.length;
                // for (var i=0;i<jsonData.length;i=i+1){
                //     var elementID=jsonData[i]['id'];
                //     var elementTitle = jsonData[i]['Title_DB'];
                //     var fs = "<option value='" + elementID + "'>" + elementTitle + "</option>";
                //     $("#TargetDB").append(fs);
                //     ListDBForMerg.push(elementID);
                // }
            }
        },
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    if(row.read_status==1)
                        return row.fullname;
                    else
                        return '<strong>'+ row.fullname+'</strong>';

                }
            },
            {
                mRender: function (data, type, row) {
                    if(row.read_status==1)
                        return row.regist_date;
                    else
                        return '<strong>'+ row.regist_date+'</strong>';
                }
            },
            {
                mRender: function (data, type, row) {
                    if(row.read_status==1)
                        return row.subject;
                    else
                        return '<strong>'+ row.subject+'</strong>';
                }
            },

            {
                mRender: function (data, type, row) {
                    var st='';
                    if(row.replay_message == '')
                        st= 'در انتظار پاسخ';
                    else
                        st= 'پاسخ داده شده';

                    if(row.read_status==1)
                        return st;
                    else
                        return '<strong>'+ st+'</strong>';
                }
            },
            {
                mRender: function (data, type, row) {
                    var facts=`<a onclick="view_message('`+row.id+`')" class="btn btn-success btn-sm text-white" title="مشاهده پیام">  <i class="fa fa-eye"> </i></a>`;
                    return facts;


                }
            },
        ]

    });
}

function view_message(id_mess) {
    let targerData = new FormData();
    targerData.append('id_mess', id_mess);
    targerData.append('id_course', $("#id_course").val());
    $.ajax({
        url: "_manager/course/get_message",
        type: 'POST',
        cache: false,
        data: targerData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("مشاهده پیام");
        },
        success: function (result) {
            if (!result.error) {
                var mess_data=result.data;
                $("#mess_message").val(mess_data.message);
                $("#mess_id_user").val(mess_data.id_user);
                $("#mess_subject").text(mess_data.subject);
                $("#reply_mess_message").val(mess_data.replay_message);
                $("#mess_id").val(id_mess);
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

    $('#message_modal').modal('toggle');
}

function viewLesson(id) {
    $('#lesson_video_modal').modal('toggle');

}

function editLesson(id) {

    let formDataa = new FormData();
    formDataa.append('id_course', $("#id_course").val());
    formDataa.append('id_lesson', id);

    $.ajax({
        url: "_manager/course/get_lesson",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("دریافت مشخصات درس");
        },
        success: function (result) {
            if (!result.error) {
                var data=result.data;
                $("#lesson_no_edit").val(data['lesson_number']);
                $("#lesson_cloud_url_edit").val(data['cloud_url']);
                $("#lesson_title_edit").val(data['title']);
                $("#lesson_memo_edit").val(data['memo']);
                $("#lesson_hour_edit").val(data['hour']);
                $("#lesson_minutes_edit").val(data['minutes']);
                if(data['isFree']==0)
                    $( "#isFree_edit" ).prop( "checked", false );
                else
                    $( "#isFree_edit" ).prop( "checked", true );
                $("#lesson_edit_id").val(id);




            }
            else{
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


    $('#lesson_edit_modal').modal('toggle');

}

function addAttachLesson(id) {
    $("#id_lesson_attach").val(id);
    $('#lesson_attach_modal').modal('toggle');
}

function viewAttachLesson(id) {
    $("#id_lesson_attach").val(id);
    var code=$("#course_code").val();
    let targerData = new FormData();
    targerData.append('id_lesson', id);
    targerData.append('id_course',$("#id_course").val());
    $.ajax({
        url: "_manager/course/lesson_attachments",
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
            // alert(result);
            if (!result.error) {
                var attachs=result.data;
                var trs="";
                for(var i=0;i<attachs.length;i=i+1){
                    var tr="<tr id='tr_lesson_attach_"+attachs[i]['id']+"'>";
                    var num=i+1;
                    tr=tr+"<td>"+num+"</td>";
                    tr=tr+"<td>"+attachs[i]['title']+"</td>";
                    tr=tr+`<td><a class="btn btn-bitbucket btn-sm text-white text-center" style="padding: 2px" href="_upload_/_courses_/`+code+`/lessons/lesson`+attachs[i]['id_lesson']+`/`+attachs[i]['attachment_file']+`" target="_blank" title="دانلود"> <i class="fa fa-download"> </i>&nbsp;&nbsp;<a class="btn btn-danger btn-sm text-white text-center" style="padding: 2px" onclick="deleteAttachment(`+attachs[i]['id']+`) " target="_blank" title="حذف ضمیمه"> <i class="fa fa-trash"> </i> </a></td>`;
                    tr=tr+"<tr>";
                    trs=trs+tr;
                }
                $("#table_attach").empty();
                $("#table_attach").append(trs);
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


    $('#lesson_attach_modal').modal('toggle');
}

function deleteAttachment(id){
    Swal.fire({
        title: 'حذف ضمیمه درس ',
        text: "آیا از حذف ضمیمه درس  مطمئن هستید؟",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "بله",
        cancelButtonText: 'انصراف',
    }).then((result) => {
        if (result.value) {
            var id_course = $("#id_course").val();
            var id_lesson = $("#id_lesson_attach").val();
            let formDataa = new FormData();
            formDataa.append('lesson_id', id_lesson);
            formDataa.append('id_course', id_course);
            formDataa.append('id_attach', id);

            $.ajax({
                url: "_manager/course/delete_lesson_attachment",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف درس با ضمائم");
                },
                success: function (result) {
                    if (!result.error) {
                        $('#tr_lesson_attach_'+id).remove();
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
}

function deleteLesson(id) {

    Swal.fire({
        title: 'حذف درس و ضمائم ',
        text: "آیا از حذف درس با ضمائم آن مطمئن هستید؟",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "بله",
        cancelButtonText: 'انصراف',
    }).then((result) => {
        if (result.value) {
            var id_course = $("#id_course").val();
            let formDataa = new FormData();
            formDataa.append('lesson_id', id);
            formDataa.append('id_course', id_course);

            $.ajax({
                url: "_manager/course/delete_lesson",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف درس با ضمائم");
                },
                success: function (result) {
                    if (!result.error) {
                        $('#tr_lesson_'+id).remove();
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

}

function viewVideoLesson(url) {
    $("#lesson_video_element").attr("src",url);
    $('#lesson_video_modal').modal('toggle');
}

function deleteQues(id){
    Swal.fire({
        title: 'حذف سوال آزمون ',
        text: "آیا از حذف سوال آزمون مطمئن هستید؟",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "بله",
        cancelButtonText: 'انصراف',
    }).then((result) => {
        if (result.value) {
            var id_course = $("#id_course").val();
            let formDataa = new FormData();
            formDataa.append('id_course', id_course);
            formDataa.append('id_quess', id);

            $.ajax({
                url: "_manager/course/delete_quiz_question",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف سوال آزمون");
                },
                success: function (result) {
                    if (!result.error) {
                        table_quiz.DataTable().ajax.reload();
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

}

function loadCoursesUsers() {
    mydatatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[3, 'asc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_course_users",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <img src="_upload_/_users_/'+row.id_user+'/personal/'+row.image+'" class="avatar avatar-lg cover-image" alt="'+row.fullname+'">';
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
                    return row.course_name;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.regist_date;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <div class="project-details"><div class="project-info">';
                    if (row.result == 'learning')
                        div=div+'<div class="status approved"><i class="icon-pencil"></i> آموزش</div></div></div>';
                    else
                    {
                        div=div+'<div class="status approved"><i class="icon-check_circle"></i> تکمیل</div></div></div>';
                    }
                    return div;

                }
            },
            {
                mRender: function (data, type, row) {
                    if(row.result == 'learning')
                        return '-----';
                    else
                        return row.quiz_score;
                }
            },
            {
                mRender: function (data, type, row) {
                    var title=row.fullname;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var facts=`<a href="profile/`+row.id_user+`/`+title+`" target="_blank" class="btn btn-success btn-sm" title="مشاهده پروفایل مهارت آموز">  <i class="fa fa-user"> </i></a>&nbsp;`;

                    title=row.course_name;
                    title=title.replace(' ','_');
                    facts=facts+`<a href="_manager/course/`+row.id_course+`/`+title+`" title="جزئیات و ویرایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-book"></i> </a>&nbsp;`;
                    return facts;


                }
            },

        ]

    });

}