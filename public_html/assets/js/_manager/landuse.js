var blog_change_image=0;
var landuse_id=0;
var code="";
var image="";
var cnt=0;

function loadlanduse() {
    landuse_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        // order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_landuses",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <div class=""><img src="_upload_/_landuse_/'+row.code+'/small_'+row.image+'" class="avatar" alt="'+row.state+'"></div>';
                    return div;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.state;
                }
            },
            {
                mRender: function (data, type, row) {
                   return row.city;
                }
            },

            {
                mRender: function (data, type, row) {
                    var  abstract_comment=makeAbstract(row.abstract,30);
                    var tag= "<p class='font-13' title='"+row.abstract+"' style='cursor: help'>"+abstract_comment+"</p>";
                    return tag;

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
                    var title=row.state;
                    if(title!= null)
                        title = title.replace(' ', '_');
                    var facts = `<a href="_manager/landuse/` + row.id + `/` + title + `" title="جزئیات و ویرایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-edit"></i> </a>&nbsp;`;
                    if (row.per_delete == true)
                        facts = facts + `<button type="button" onclick="deleteLanduse(` + row.id + `)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
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
                var user=`<a href="_manager/user/`+row.id_user+`" title="مشخصات کاربر ارسال کننده" target="_blank" class="btn btn-info  btn-sm text-white"> <i class="fa fa-user"></i> `+row.fullname+` </a>&nbsp;`;
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

function deleteLanduse(id) {

    Swal.fire({
        title: 'حذف آمایش سرزمینی',
        text: "آیا برای حذف آمایش سرزمینی مطمئن هستید؟",
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
                url: "_manager/landuse/delete_landuse",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف آمایش سرزمینی");
                },
                success: function (result) {
                    if (!result.error) {
                        landuse_datatable.DataTable().ajax.reload();
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

function deleteLanduseImage(image_id,landuse_id) {

    Swal.fire({
        title: 'حذف تصویر آمایش سرزمینی',
        text: "آیا برای حذف تصویر آمایش سرزمینی مطمئن هستید؟",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "بله",
        cancelButtonText: 'انصراف',
    }).then((result) => {
        if (result.value) {
            let formDataa = new FormData();
            formDataa.append('id', image_id);
            formDataa.append('landuse_id', landuse_id);
            $.ajax({
                url: "_manager/landuse/delete_landuse_image",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف تصویر آمایش سرزمینی");
                },
                success: function (result) {
                    if (!result.error) {
                        $("#gallery_"+image_id).remove();
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
        ajax: "_manager/all_blog_comments",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var user=`<a href="_manager/user/`+row.id_user+`" title="مشخصات کاربر ارسال کننده" target="_blank" class="btn btn-info  btn-sm text-white"> <i class="fa fa-user"></i> `+row.fullname+` </a>&nbsp;`;
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

$("#btn_add_landuse").on("click",function (event) {
    var landuse_image=$('#landuse_image')[0].files[0];
    var landuse_cloud_url=$('#landuse_cloud_url').val();
    var state = $("#state").val();
    var city = $("#city").val();
    var area = $("#area").val();
    var population = $("#population").val();
    var isOnlyState = 0;
    var landuse_abstract = $("#landuse_abstract").val();
    var landuse_memo = CKEDITOR.instances['landuse_memo'].getData();
    var landuse_jobs_score = CKEDITOR.instances['landuse_jobs_score'].getData();
    var landuse_jobs_prority = CKEDITOR.instances['landuse_jobs_prority'].getData();

    if ($('#isOnlyState').is(":checked"))
        isOnlyState=1;


    let formDataa = new FormData();
    formDataa.append('landuse_image', landuse_image);
    formDataa.append('landuse_cloud_url', landuse_cloud_url);
    formDataa.append('state', state);
    formDataa.append('city', city);
    formDataa.append('area', area);
    formDataa.append('population', population);
    formDataa.append('landuse_abstract', landuse_abstract);
    formDataa.append('landuse_memo', landuse_memo);
    formDataa.append('landuse_jobs_score', landuse_jobs_score);
    formDataa.append('landuse_jobs_prority', landuse_jobs_prority);
    formDataa.append('isOnlyState', isOnlyState);

    $.ajax({
        url: "_manager/landuse/add_landuse",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت آمایش سرزمینی");
        },
        success: function (result) {
            if (!result.error) {
                var data=result.data;
                $("#landuse_id").val(data.id);
                $("#landuse_code").val(data.code);

                $("#btn_tab_gallery").click();



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

$("#btn_edit_landuse").on("click",function (event) {
    var landuse_image=$('#landuse_image')[0].files[0];
    var landuse_cloud_url=$('#landuse_cloud_url').val();
    var state = $("#state").val();
    var city = $("#city").val();
    var population = $("#population").val();
    var area = $("#area").val();
    var landuse_abstract = $("#landuse_abstract").val();
    var landuse_memo = CKEDITOR.instances['landuse_memo'].getData();
    var landuse_jobs_score = CKEDITOR.instances['landuse_jobs_score'].getData();
    var landuse_jobs_prority = CKEDITOR.instances['landuse_jobs_prority'].getData();
    var landuse_id = $("#landuse_id").val();
    var isOnlyState = 0;

    if ($('#isOnlyState').is(":checked"))
        isOnlyState=1;

    let formDataa = new FormData();
    formDataa.append('landuse_image', landuse_image);
    formDataa.append('landuse_cloud_url', landuse_cloud_url);
    formDataa.append('state', state);
    formDataa.append('city', city);
    formDataa.append('area', area);
    formDataa.append('population', population);
    formDataa.append('landuse_abstract', landuse_abstract);
    formDataa.append('landuse_memo', landuse_memo);
    formDataa.append('landuse_id', landuse_id);
    formDataa.append('isOnlyState', isOnlyState);
    formDataa.append('landuse_jobs_score', landuse_jobs_score);
    formDataa.append('landuse_jobs_prority', landuse_jobs_prority);


    $.ajax({
        url: "_manager/landuse/edit_landuse",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات اطلاعات آمایش سرزمینی");
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

$("#btn_add_to_gallery").on("click" , function (event) {
    var landuse_image_gallery=$('#landuse_image_gallery')[0].files[0];
    var landuse_id = $("#landuse_id").val();
    let formDataa = new FormData();
    formDataa.append('landuse_image_gallery', landuse_image_gallery);
    formDataa.append('landuse_id', landuse_id);

    $.ajax({
        url: "_manager/landuse/up_to_gallery_landuse",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("بارگزاری تصویر در گالری آمایش سرزمینی");
        },
        success: function (result) {
            if (!result.error) {
                var data=result.data;
                var code=$("#landuse_code").val();
                var tr="";
                cnt=cnt+1;
                tr=`<tr id="gallery_`+data.id+`"><td>`+cnt+`</td><td><img src="_upload_/_landuse_/`+code+`/images/`+data.file_path+`" class="avatar"></td><td><button type="button" onclick="deleteLanduseImage(`+data.id+`,`+landuse_id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button></td></tr>`;
                $("#gallery_landuse").append(tr);

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


