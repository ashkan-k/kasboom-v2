
var drEvent = $('.dropify').dropify({
    messages: {
        'default': 'یک فایل را در اینجا بکشید و رها کنید یا کلیک کنید',
        'replace': 'برای جایگزینی یک فایل را در اینجا بکشید و رها کنید یا کلیک کنید',
        'remove': 'حذف',
        'error': 'خطا، چیزی اشتباه اضافه شده است.'
    },
    error: {
        'fileSize': 'اندازه فایل زیاد می باشد (تصویر 5 مگابات و ویدیو حداکثر 100 مگابایت می باشد).',
        'minWidth': 'The image width is too small min).',
        'maxWidth': 'The image width is too big px max).',
        'minHeight': 'The image height is too small px min).',
        'maxHeight': 'The image height is too big px max).',
        'imageFormat': 'فرمت عکس نامعتبر می باشد. (jpg-png-jpeg-gif)'
    }
});
drEvent.on('dropify.errors', function (event, element) {
    ShowMessage('خطا در فایل انتخاب شده !', 'error')
});
drEvent.on('dropify.error.imageFormat', function (event, element) {
    ShowMessage('فرمت فایل معتبر نمی باشد. فرمت های قابل قبول تصاویر(jpg-png-jpeg-gif) و فرمت های قابل قبول ویدیو(mp4-mp3-3gp-mpg-mpeg)', 'error');
});



function deleteComment(id_comment) {

    Swal.fire({
        title: 'حذف نظر ',
        text: "آیا از حذف نظر مطمئن هستید؟",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "بله",
        cancelButtonText: 'انصراف',
    }).then((result) => {
        if (result.value) {
            let formDataa = new FormData();
            formDataa.append('id_comment', id_comment);
            $.ajax({
                url: "_manager/comment/delete",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                },
                success: function (result) {
                     ShowMessage(result.message, result.type);
                    comment_table.DataTable().ajax.reload();
                },
                complete: function () {
                },
                error: function () {
                    ShowMessage('خطای ناشتاخته', '« صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
                }
            });
        }
    });

}


function makeAbstract(text,len){
    if (text==null)
        text="";
    var lentext=(text.length);
    var res=text;
    if (typeof len == "undefined")
        len = 70;
    if (lentext>len){
        res = text.substr(0, len);
        res=res+'...'
    }
    return res;
}


function verify_comment(id) {
    let formDataa = new FormData();
    formDataa.append('id',id);
    $.ajax({
        url: "_manager/verify_comment",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("تایید نظر");
        },
        success: function (result) {
            if (!result.error) {
                lastCommentDatatable.DataTable().ajax.reload();

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

function delete_comment(id) {
    Swal.fire({
        title: 'حذف نظر',
        text: "آیا برای حذف  نظر کاربر مطمئن هستید؟",
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
                url: "_manager/delete_comment",
                type: 'POST',
                cache: false,
                data: formDataa,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $("#csrf-token").attr('content')
                },
                beforeSend: function () {
                    ShowWaiting("حذف نظر");
                },
                success: function (result) {
                    if (!result.error) {
                        lastCommentDatatable.DataTable().ajax.reload();

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


$("#btn_verify_comment").on("click",function (event) {
    let formDataa = new FormData();
    formDataa.append('id', $("#comment_id").val());
    $.ajax({
        url: "_manager/verify_comment",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("تایید نظر");
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
