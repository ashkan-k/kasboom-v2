var news_change_image=0;
var news_id=0;
var code="";
var image="";

function loadnews() {
    news_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_news",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <div class=""><img src="_upload_/_news_/'+row.code+'/small_'+row.image+'" class="avatar" alt="'+row.title+'"></div>';
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
                    return row.regist_date;
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
                    var facts=`<a href="_manager/news/`+row.id+`/`+title+`" title="جزئیات و ویرایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-edit"></i> </a>&nbsp;`;
                    if(row.per_delete == true)
                        facts=facts+`<button type="button" onclick="deleteNews(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                    return facts;


                }
            },


        ]

    });


}

function loadNewsComments() {
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
            url: "_manager/news/comments",
                type: "POST",
                data: function (d) {
                d.id_news =news_id;
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

function deleteNews(id) {

    Swal.fire({
        title: 'حذف خبر',
        text: "آیا برای حذف خبر مطمئن هستید؟",
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
                url: "_manager/news/delete_news",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف خبر");
                },
                success: function (result) {
                    if (!result.error) {
                        news_datatable.DataTable().ajax.reload();

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
    all_comment_table.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_news_comments",
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
                        return row.news_title;
                    else
                        return "<strong>"+row.news_title+"</strong>"
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
                    var tag="<p class='font-13' title='"+row.comment+"' style='cursor: help'>"+abstract_comment+"</p>";
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

$("#btn_add_news").on("click",function (event) {
    var news_image=$('#news_image')[0].files[0];
    var news_cloud_url=$('#news_cloud_url').val();
    var news_title = $("#news_title").val();
    var news_category = $("#news_category").val();
    var news_state = $("#news_state").val();
    var news_abstractMemo = $("#news_abstractMemo").val();
    var news_memo = CKEDITOR.instances['news_memo'].getData();

    let formDataa = new FormData();
    formDataa.append('news_image', news_image);
    formDataa.append('news_cloud_url', news_cloud_url);
    formDataa.append('news_title', news_title);
    formDataa.append('news_category', news_category);
    formDataa.append('news_state', news_state);
    formDataa.append('news_abstractMemo', news_abstractMemo);
    formDataa.append('news_memo', news_memo);

    $.ajax({
        url: "_manager/news/add_news",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت خبر");
        },
        success: function (result) {
            if (!result.error) {

                $('#news_form').find("input[type=text], textarea").val("");
                $("#news_form").trigger('reset');
                $(".dropify-clear").trigger("click");
                CKEDITOR.instances['news_memo'].setData("");



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

$("#btn_edit_news").on("click",function (event) {
    var news_image=$('#news_image')[0].files[0];
    var news_cloud_url=$('#news_cloud_url').val();
    var news_title = $("#news_title").val();
    var news_category = $("#news_category").val();
    var news_state = $("#news_state").val();
    var news_abstractMemo = $("#news_abstractMemo").val();
    var news_status = $("#news_status").val();
    var news_memo = CKEDITOR.instances['news_memo'].getData();

    let formDataa = new FormData();
    formDataa.append('news_change_image', news_change_image);
    formDataa.append('news_image', news_image);
    formDataa.append('news_cloud_url', news_cloud_url);
    formDataa.append('news_title', news_title);
    formDataa.append('news_category', news_category);
    formDataa.append('news_state', news_state);
    formDataa.append('news_abstractMemo', news_abstractMemo);
    formDataa.append('news_memo', news_memo);
    formDataa.append('news_status', news_status);
    formDataa.append('news_id', news_id);

    $.ajax({
        url: "_manager/news/edit_news",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات اطلاعات خبر");
        },
        success: function (result) {
            if (!result.error) {

                $('#news_form').find("input[type=text], textarea").val("");
                $("#news_form").trigger('reset');
                $(".dropify-clear").trigger("click");
                CKEDITOR.instances['news_memo'].setData("");
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
