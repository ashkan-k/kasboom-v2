function loadcategorys() {
    category_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[2, 'asc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_categorys",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.title;
                }
            },
            {
                mRender: function (data, type, row) {
                    if(row.type=="idea")
                        return "ویکی ایده";
                    else if(row.type=="news")
                        return "اخبار";
                    else if(row.type=="blog")
                        return "مطالب آموزشی";
                    else if(row.type=="course")
                        return "دوره آموزشی";
                    else if(row.type=="shop")
                        return "فروشگاه";
                    else if(row.type=="consult")
                        return "مشاوره";
                    else if(row.type=="requirement")
                        return "نیازمندی ها";
                    else if(row.type=="hire")
                        return "استخدام یار";
                    else if(row.type=="webinar")
                        return "کارگاه آموزشی";
                    else if(row.type=="teacher")
                        return "مدرس";
                    else if(row.type=="note")
                        return "نکات آموزشی استخدام یار";
                    else if(row.type=="hire_blog")
                        return "مطالب آموزشی استخدام یار";
                    else if(row.type=="podcast")
                        return "پادکست استخدام یار";
                    else if(row.type=="videocast")
                        return "ویدئوکست استخدام یار";
                    else if(row.type=="hire_ques")
                        return "نمونه سوال استخدام یار";
                    else if(row.type=="hire_consult")
                        return "مشاوره استخدام یار";
                    else
                        returnrow.type;
                }
            },
            {
                mRender: function (data, type, row) {
                    var title=row.title;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var facts=`<a onclick="editCategory(`+row.id+`,'`+row.title+`')" title="جزئیات و ویرایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-edit"></i> </a>&nbsp;`;
                    if(row.per_delete == true)
                        facts=facts+`<button type="button" onclick="deleteCategory(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                    return facts;


                }
            },

        ]

    });

}

function loadShopCategorys() {
    category_shop_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[2, 'asc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_shop_categorys",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.title;
                }
            },
            {
                mRender: function (data, type, row) {
                    if(row.type=="idea")
                        return "ویکی ایده";
                    else if(row.type=="news")
                        return "اخبار";
                    else if(row.type=="blog")
                        return "مطالب آموزشی";
                    else if(row.type=="course")
                        return "دوره آموزشی";
                    else if(row.type=="shop")
                        return "فروشگاه";
                    else if(row.type=="consult")
                        return "مشاوره";
                    else if(row.type=="requirement")
                        return "نیازمندی ها";
                    else if(row.type=="hire")
                        return "استخدام یار";
                    else if(row.type=="webinar")
                        return "کارگاه آموزشی";
                    else if(row.type=="teacher")
                        return "مدرس";
                    else if(row.type=="note")
                        return "نکات آموزشی استخدام یار";
                    else if(row.type=="hire_blog")
                        return "مطالب آموزشی استخدام یار";
                    else if(row.type=="podcast")
                        return "پادکست استخدام یار";
                    else if(row.type=="videocast")
                        return "ویدئوکست استخدام یار";
                    else if(row.type=="hire_ques")
                        return "نمونه سوال استخدام یار";
                    else if(row.type=="hire_consult")
                        return "مشاوره استخدام یار";
                    else
                        returnrow.type;
                }
            },
            {
                mRender: function (data, type, row) {
                    var title=row.title;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var facts=`<a onclick="editCategory(`+row.id+`,'`+row.title+`')" title="جزئیات و ویرایش" class="btn btn-success  btn-sm text-white"> <i class="fa fa-edit"></i> </a>&nbsp;`;
                    if(row.per_delete == true)
                        facts=facts+`<button type="button" onclick="deleteCategory(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;
                    return facts;


                }
            },

        ]

    });

}

function editCategory(id,title){
    $("#cat_title").val(title);
    $("#category_id").val(id);
    $("#btn_add_category").hide();
    $("#btn_edit_category").show();
    $('#category_modal').modal('toggle');

}

function deleteCategory(id) {

    Swal.fire({
        title: 'حذف گروه آموزشی/خبری',
        text: "آیا برای حذف گروه مطمئن هستید؟",
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
                url: "_manager/category/delete_category",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف گروه آموزشی/خبری");
                },
                success: function (result) {
                    if (!result.error) {
                        category_datatable.DataTable().ajax.reload();

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

function addCategory(){
    $("#cat_title").val("");
    $("#category_id").val("");
    $("#btn_add_category").show();
    $("#btn_edit_category").hide();
    $('#category_modal').modal('toggle');

}

$("#btn_add_category").on("click",function (event) {
    var title=$('#cat_title').val();
    var cat_type=$('#cat_type').val();

    let formDataa = new FormData();
    formDataa.append('cat_title', title);
    formDataa.append('cat_type', cat_type);

    $.ajax({
        url: "_manager/category/add_category",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت گروه آموزشی");
        },
        success: function (result) {
            if (!result.error) {
                $('#category_modal').modal('toggle');
                category_datatable.DataTable().ajax.reload();

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

$("#btn_edit_category").on("click",function (event) {
    var title=$('#cat_title').val();
    var cat_type=$('#cat_type').val();

    let formDataa = new FormData();
    formDataa.append('cat_title', title);
    formDataa.append('cat_type', cat_type);
    formDataa.append('id', $("#category_id").val());

    $.ajax({
        url: "_manager/category/edit_category",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت  تغییرات گروه آموزشی");
        },
        success: function (result) {
            if (!result.error) {
                $('#category_modal').modal('toggle');
                category_datatable.DataTable().ajax.reload();
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


$("#btn_add_shop_group_category").on("click",function (event) {
    var title=$('#new_group').val();
    var mega_category=$('#mega_category').val();

    let formDataa = new FormData();
    formDataa.append('title', title);
    formDataa.append('mega_category', mega_category);

    $.ajax({
        url: "_manager/category/add_shop_group_category",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت گروه بندی محصول");
        },
        success: function (result) {
            if (!result.error) {
                $('#category_modal').modal('toggle');
                // category_datatable.DataTable().ajax.reload();
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


$("#btn_add_shop_daste_category").on("click",function (event) {
    var title=$('#new_daste').val();
    var middle_category=$('#middle_category').val();

    let formDataa = new FormData();
    formDataa.append('title', title);
    formDataa.append('middle_category', middle_category);

    $.ajax({
        url: "_manager/category/add_shop_daste_category",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت دسته بندی محصول");
        },
        success: function (result) {
            if (!result.error) {
                $('#category_modal').modal('toggle');
                // category_datatable.DataTable().ajax.reload();
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

$('#mega_category').on('change', function (e) {

    e.preventDefault();
    var selectData = $(this).val();
    let formData= new FormData();
    formData.append('mega_category',selectData);
    $.ajax({
        url: "getMiddleCategory",
        type: 'POST',
        cache: false,
        data: formData,
        contentType: false,
        processData: false,
        headers: {

            'X-CSRF-TOKEN': $("#csrf-token").attr('content')

        },
        beforeSend: function () {
            ShowWaiting("کمی صبر کنید");
        },
        success: function (result) {
            if (!result.error) {
                $('#middle_category').html(result.data);
            }
        },
        complete: function () {
            CloseWaiting();
        },
        error: function () {
            CloseWaiting();
        }
    });

});

$('#middle_category').on('change', function (e) {

    e.preventDefault();
    var selectData = $(this).val();
    let formData= new FormData();
    formData.append('middle_category',selectData);
    $.ajax({
        url: "getSubCategory",
        type: 'POST',
        cache: false,
        data: formData,
        contentType: false,
        processData: false,
        headers: {

            'X-CSRF-TOKEN': $("#csrf-token").attr('content')

        },
        beforeSend: function () {
            ShowWaiting("کمی صبر کنید");
        },
        success: function (result) {
            if (!result.error) {
                $('#mini_category').html(result.data);
            }
        },
        complete: function () {
            CloseWaiting();
        },
        error: function () {
            CloseWaiting();
        }
    });

});
// loadShopCategorys();