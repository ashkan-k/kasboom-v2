var blog_change_image=0;
var blog_id=0
var code="";
var image="";

function loadblogs() {
    blog_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_blogs",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <div class=""><img src="_upload_/_blogs_/'+row.code+'/small_'+row.image+'" class="avatar" alt="'+row.title+'"></div>';
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
                        title = title.replace(' ', '_');
                    var facts = `<a href="_manager/blog/` + row.id + `/` + title + `" title="جزئیات و ویرایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-edit"></i> </a>&nbsp;`;
                    if (row.per_delete == true)
                        facts = facts + `<button type="button" onclick="deleteBlog(` + row.id + `)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                    return facts;



                }
            },


        ]

    });


}

function loadBlogComments() {
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
            url: "_manager/blog/comments",
                type: "POST",
                data: function (d) {
                d.id_blog =blog_id;
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
                // facts=facts+`<button type="button" onclick="deleteComment(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                return facts;


            }
        },

    ]

    });


}

function deleteBlog(id) {

    Swal.fire({
        title: 'حذف مطلب آموزشی کسب و کار',
        text: "آیا برای حذف مطلب مطمئن هستید؟",
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
                url: "_manager/blog/delete_blog",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف مطلب آموزشی");
                },
                success: function (result) {
                    if (!result.error)
                        blog_datatable.DataTable().ajax.reload();


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
        ajax: "_manager/all_blog_comments",
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
                        return row.blog_title;
                    else
                        return "<strong>"+row.blog_title+"</strong>"
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
                    facts=facts+`<button onclick="viewComment(`+row.id+`)" title="نمایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i></button>&nbsp;`;
                    // facts=facts+`<button onclick="deleteComment(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                    return facts;


                }
            },

        ]

    });
}

$("#btn_add_blog").on("click",function (event) {
    var blog_image=$('#blog_image')[0].files[0];
    var blog_attach=$('#blog_attach')[0].files[0];
    var blog_cloud_url=$('#blog_cloud_url').val();
    var blog_title = $("#blog_title").val();
    var blog_category = $("#blog_category").val();
    var blog_state = $("#blog_state").val();
    var blog_abstractMemo = $("#blog_abstractMemo").val();
    var blog_resource = $("#blog_resource").val();
    var blog_hashtags = $("#blog_hashtags").val();
    var blog_memo = CKEDITOR.instances['blog_memo'].getData();
    let formDataa = new FormData();
    formDataa.append('blog_image', blog_image);
    formDataa.append('blog_cloud_url', blog_cloud_url);
    formDataa.append('blog_title', blog_title);
    formDataa.append('blog_category', blog_category);
    formDataa.append('blog_state', blog_state);
    formDataa.append('blog_abstractMemo', blog_abstractMemo);
    formDataa.append('blog_memo', blog_memo);
    formDataa.append('blog_resource', blog_resource);
    formDataa.append('blog_attach', blog_attach);
    formDataa.append('blog_hashtags', blog_hashtags);

    $.ajax({
        url: "_manager/blog/add_blog",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت مطلب آموزشی کسب و کار");
        },
        success: function (result) {
            if (!result.error) {

                $('#blog_form').find("input[type=text], textarea").val("");
                $("#blog_form").trigger('reset');
                $(".dropify-clear").trigger("click");
                CKEDITOR.instances['blog_memo'].setData("");



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

$("#btn_edit_blog").on("click",function (event) {
    var blog_image=$('#blog_image')[0].files[0];
    var blog_cloud_url=$('#blog_cloud_url').val();
    var blog_title = $("#blog_title").val();
    var blog_category = $("#blog_category").val();
    var blog_state = $("#blog_state").val();
    var blog_abstractMemo = $("#blog_abstractMemo").val();
    var blog_resource = $("#blog_resource").val();
    var blog_hashtags = $("#blog_hashtags").val();
    var blog_attach=$('#blog_attach')[0].files[0];
    var blog_memo = CKEDITOR.instances['blog_memo'].getData();

    let formDataa = new FormData();
    formDataa.append('blog_change_image', blog_change_image);
    formDataa.append('blog_image', blog_image);
    formDataa.append('blog_cloud_url', blog_cloud_url);
    formDataa.append('blog_title', blog_title);
    formDataa.append('blog_category', blog_category);
    formDataa.append('blog_state', blog_state);
    formDataa.append('blog_abstractMemo', blog_abstractMemo);
    formDataa.append('blog_memo', blog_memo);
    formDataa.append('blog_resource', blog_resource);
    formDataa.append('blog_attach', blog_attach);
    formDataa.append('blog_hashtags', blog_hashtags);
    formDataa.append('blog_id', blog_id);

    $.ajax({
        url: "_manager/blog/edit_blog",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات اطلاعات مطلب آموزشی کسب و کار");
        },
        success: function (result) {
            if (!result.error) {

                // $('#blog_form').find("input[type=text], textarea").val("");
                // $("#blog_form").trigger('reset');
                // $(".dropify-clear").trigger("click");
                // CKEDITOR.instances['blog_memo'].setData("");
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
