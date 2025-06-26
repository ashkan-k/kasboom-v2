function loadwikiideas() {
    wikiideas_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_ideas",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div=' <div class=""><img src="_upload_/_wikiideas_/'+row.code+'/small_'+row.image+'" class="avatar cover-image avatar-lg" alt="'+row.title+'"></div>';
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
                    return row.publisher_name;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.risk;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.minimal_fund
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.profitability;
                }
            },
            // {
            //     mRender: function (data, type, row) {
            //         return row.view_count;
            //     }
            // },
            // {
            //     mRender: function (data, type, row) {
            //         return row.like_count;
            //     }
            // },
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
                    var facts=`<a href="_manager/idea/`+row.id+`/`+title+`" title="جزئیات و ویرایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-edit"></i> </a>&nbsp;`;
                    if(row.per_delete == true)
                        facts=facts+`<button type="button" onclick="deleteIdea(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
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
                var facts=`<a href="profile/`+row.id_user+`/`+title+`" target="_blank" class="btn btn-info btn-sm" title="مشاهده پروفایل کاربر">  `+ row.fullname+`</i></a>`;
                return facts;
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



    var imgPath="_upload_/_wikiideas_/"+code+"/"+image;

    var drEvent = $('#idea_image').dropify();
    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = imgPath;
    drEvent.destroy();
    drEvent.init();


}

function deleteIdea(id) {

    Swal.fire({
        title: 'حذف اطلاعات ایده کسب و کار',
        text: "آیا برای حذف ایده مطمئن هستید؟",
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
                url: "_manager/wikiideas/delete_idea",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف ایده کسب و کار");
                },
                success: function (result) {
                    if (!result.error) {
                        wikiideas_datatable.DataTable().ajax.reload();

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

$("#btn_add_wikiidea").on("click",function (event) {
    var idea_image=$('#idea_image')[0].files[0];
    var idea_video=$('#idea_video')[0].files[0];
    var idea_cloud_url=$('#idea_cloud_url').val();
    var idea_title = $("#idea_title").val();
    var idea_category = $("#idea_category").val();
    var idea_minimal_fund = $("#idea_minimal_fund").val();
    var idea_risk = $("#idea_risk").val();
    var idea_profitability = $("#idea_profitability").val();
    var idea_profitability_memo = $("#idea_profitability_memo").val();
    var idea_manpower = $("#idea_manpower").val();
    var idea_scale = $("#idea_scale").val();
    var idea_state = $("#idea_state").val();
    var idea_abstractMemo = $("#idea_abstractMemo").val();
    var idea_memo = CKEDITOR.instances['idea_memo'].getData();

    let formDataa = new FormData();
    formDataa.append('idea_image', idea_image);
    formDataa.append('idea_video', idea_video);
    formDataa.append('idea_cloud_url', idea_cloud_url);
    formDataa.append('idea_title', idea_title);
    formDataa.append('idea_category', idea_category);
    formDataa.append('idea_minimal_fund', idea_minimal_fund);
    formDataa.append('idea_risk', idea_risk);
    formDataa.append('idea_profitability', idea_profitability);
    formDataa.append('idea_profitability_memo', idea_profitability_memo);
    formDataa.append('idea_manpower', idea_manpower);
    formDataa.append('idea_scale', idea_scale);
    formDataa.append('idea_state', idea_state);
    formDataa.append('idea_abstractMemo', idea_abstractMemo);
    formDataa.append('idea_memo', idea_memo);

    $.ajax({
        url: "_manager/wikiideas/add_idea",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت ایده کسب و کار");
        },
        success: function (result) {
            if (!result.error) {

                $('#idea_form').find("input[type=text], textarea").val("");
                $("#idea_form").trigger('reset');
                $(".dropify-clear").trigger("click");
                CKEDITOR.instances['idea_memo'].setData('');


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

$("#btn_edit_wikiidea").on("click",function (event) {
    var idea_image=$('#idea_image')[0].files[0];
    var idea_cloud_url=$('#idea_cloud_url').val();
    var idea_title = $("#idea_title").val();
    var idea_category = $("#idea_category").val();
    var idea_minimal_fund = $("#idea_minimal_fund").val();
    var idea_risk = $("#idea_risk").val();
    var idea_profitability = $("#idea_profitability").val();
    var idea_profitability_memo = $("#idea_profitability_memo").val();
    var idea_manpower = $("#idea_manpower").val();
    var idea_scale = $("#idea_scale").val();
    var idea_state = $("#idea_state").val();
    var idea_abstractMemo = $("#idea_abstractMemo").val();
    var idea_memo = CKEDITOR.instances['idea_memo'].getData();

    let formDataa = new FormData();
    formDataa.append('idea_change_image', idea_change_image);
    formDataa.append('idea_image', idea_image);
    formDataa.append('idea_cloud_url', idea_cloud_url);
    formDataa.append('idea_title', idea_title);
    formDataa.append('idea_category', idea_category);
    formDataa.append('idea_minimal_fund', idea_minimal_fund);
    formDataa.append('idea_risk', idea_risk);
    formDataa.append('idea_profitability', idea_profitability);
    formDataa.append('idea_profitability_memo', idea_profitability_memo);
    formDataa.append('idea_manpower', idea_manpower);
    formDataa.append('idea_scale', idea_scale);
    formDataa.append('idea_state', idea_state);
    formDataa.append('idea_abstractMemo', idea_abstractMemo);
    formDataa.append('idea_memo', idea_memo);
    formDataa.append('idea_id', idea_id);

    $.ajax({
        url: "_manager/wikiideas/edit_idea",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت تغییرات اطلاعات ایده کسب و کار");
        },
        success: function (result) {
            if (!result.error) {

                $('#idea_form').find("input[type=text], textarea").val("");
                $("#idea_form").trigger('reset');
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
