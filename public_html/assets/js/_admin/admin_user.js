var teacher_change_image = 0;
var teacher_id = 0;
var code = "";
var image = "";
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


function userCourses() {
  mydatatable.DataTable({
    // processing: true,
    // serverSide: true,
    // order: [[1, 'asc']],
    paging: true,
    searching: true,
    pageLength: 10,
    ordering: true,
    Destroy: true,
    dom: 'Bfrtip',
    buttons: [
      'excelHtml5',
      'pdfHtml5',
      'print'
    ],
    ajax: "user/all_courses",
    columns: [
      {
        mRender: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        mRender: function (data, type, row) {
          var div = '<img src="_upload_/_courses_/' + row.code + '/small_' + row.image + '" class="avatar avatar-xl" alt="' + row.title + '">';
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
          if (row.price < 1)
            return 'رایگان';
          else
            return row.price + '  تومان ';
        }
      },
      {
        mRender: function (data, type, row) {
          return (row.regist_date);
        }
      },
      {
        mRender: function (data, type, row) {
          var div = ' <div class="project-details"><div class="project-info">';
          if (row.status == 1)
            div = div + '<div class="status approved"><i class="icon-check_circle"></i> فعال</div></div></div>';
          else
            div = div + '<div class="status rejected"><i class="icon-circle-with-cross"></i>غیر فعال</div></div></div>';
          return div;
        }
      },
      {
        mRender: function (data, type, row) {
          var title = row.title;
          if (title != null)
            title = title.replace(' ', '_');
          var facts = `<a href="course/` + row.id + `/` + title + `" class="btn btn-success btn-sm text-white"><i class="fa fa-eye"></i> </a>&nbsp;`;
          return facts;
        }
      },
    ]
  });
}

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
        d.id_course = $("#id_course").val();
      },
      type: "GET",
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      complete: function (json) {
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
          return row.fullname;
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
          var abstract = makeAbstract(row.comment, 100);
          var span = '<span title="' + row.comment + '">' + abstract + '</span>';
          return span;
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
        d.id_course = $("#id_course").val();
      },
      type: "GET",
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      complete: function (json) {
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
          if (row.answer == 1) {
            var div = `<div class="text-success"><i class='fa fa-check'>` + row.option1;
            +` </div>`
            return div;
          } else
            return row.option1;
        }
      },
      {
        mRender: function (data, type, row) {
          if (row.answer == 2) {
            var div = `<div class="text-success"><i class='fa fa-check'>` + row.option2;
            +` </div>`
            return div;
          } else
            return row.option2;
        }
      },
      {
        mRender: function (data, type, row) {
          if (row.answer == 3) {
            var div = `<div class="text-success"><i class='fa fa-check'>` + row.option3;
            +` </div>`
            return div;
          } else
            return row.option3;
        }
      },
      {
        mRender: function (data, type, row) {
          if (row.answer == 4) {
            var div = `<div class="text-success"><i class='fa fa-check'>` + row.option4;
            +` </div>`
            return div;
          } else
            return row.option4;
        }
      },
      {
        mRender: function (data, type, row) {
          var id = row.id;
          var facts = `<button onclick="deleteQues(` + id + `)" class="btn btn-danger btn-sm" title="حذف سوال"  ><i class="fa fa-trash"></i></button>`;
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
        d.id_course = $("#id_course").val();
      },
      type: "GET",
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      complete: function (json) {
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
          var div = ' <img src="_upload_/_users_/' + row.id_user + '/personal/' + row.image + '" class="avatar avatar-lg cover-image" alt="' + row.fullname + '">';
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
          var div = ' <div class="project-details"><div class="project-info">';
          if (row.result == 'learning')
            div = div + '<div class="status approved"><i class="icon-pencil"></i> در حال آموزش</div></div></div>';
          else {
            div = div + '<div class="status approved"><i class="icon-check_circle"></i> تکمیل دوره</div></div></div>';
          }
          return div;
        }
      },
      {
        mRender: function (data, type, row) {
          if (row.result == 'learning')
            return '-----';
          else
            return row.quiz_score;
        }
      },
      {
        mRender: function (data, type, row) {
          var title = row.fullname;
          if (title != null)
            title = title.replace(' ', '_');
          var facts = `<a href="profile/` + row.id_user + `/` + title + `" target="_blank" class="btn btn-success btn-sm" title="مشاهده پروفایل مهارت آموز">  <i class="fa fa-eye"> </i></a>`;
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
        d.id_course = $("#id_course").val();
      },
      type: "GET",
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      complete: function (json) {
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
          if (row.read_status == 1)
            return row.fullname;
          else
            return '<strong>' + row.fullname + '</strong>';
        }
      },
      {
        mRender: function (data, type, row) {
          if (row.read_status == 1)
            return row.regist_date;
          else
            return '<strong>' + row.regist_date + '</strong>';
        }
      },
      {
        mRender: function (data, type, row) {
          if (row.read_status == 1)
            return row.subject;
          else
            return '<strong>' + row.subject + '</strong>';
        }
      },
      {
        mRender: function (data, type, row) {
          var st = '';
          if (row.replay_message == '')
            st = 'در انتظار پاسخ';
          else
            st = 'پاسخ داده شده';
          if (row.read_status == 1)
            return st;
          else
            return '<strong>' + st + '</strong>';
        }
      },
      {
        mRender: function (data, type, row) {
          var facts = `<a onclick="view_message('` + row.id + `')" class="btn btn-success btn-sm text-white" title="مشاهده پیام">  <i class="fa fa-eye"> </i>مشاهده</a>`;
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
        var mess_data = result.data;
        $("#mess_message").val(mess_data.message);
        $("#mess_id_user").val(mess_data.id_user);
        $("#mess_subject").text(mess_data.subject);
        $("#reply_mess_message").val(mess_data.replay_message);
        $("#mess_id").val(id_mess);
      } else {
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

function check2price(productsum){
  var vamprice=$("#user_vam_price").val();
  if(productsum>vamprice) {
    $("#btn_next").prop("disabled", true);
    $("#span_vam_price_message").text("مبلغ مصارف وام بیشتر از مبلغ درخواستی وام می باشد ");
    $("#span_vam_price_message").show();
  }
  else if(productsum<vamprice) {
    $("#btn_next").prop("disabled", true);
    $("#span_vam_price_message").text("مبلغ مصارف وام کمتر از مبلغ درخواستی وام می باشد ");
    $("#span_vam_price_message").show();
  }
  else if(productsum==vamprice) {
    $("#btn_next").prop("disabled",false);
    $("#span_vam_price_message").hide();
  }
}

function loadpayments() {
  table_payments.DataTable({
    paging: true,
    searching: true,
    pageLength: 10,
    ordering: true,
    Destroy: true,
    ajax: "user/all_payments",
    columns: [
      {
        mRender: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.factor_id;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.regist_date;
        }
      },
      {
        mRender: function (data, type, row) {
          var vall = "";
          if (row.payment_for == "course")
            vall = "خرید دوره " + row.product_course_title;
          else if (row.payment_for == "hire")
            vall = "خرید پکیج " + row.product_course_title;
          else if (row.payment_for == "webinar")
            vall = "وبینار " + row.product_course_title;
          else
            vall = row.product_course_title;
          return vall;
        }
      },
      {
        mRender: function (data, type, row) {
          // if(row.payment_price>0) {
          //     var total=0;
          //     total = parseFloat(total) + parseFloat(row.payment_price);
          //     $("#total").text("مجموع پرداختی: " + total +" تومان ");
          // }
          return row.payment_price + " تومان ";
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

function loadUserConsulting() {
  consulting_datatable.DataTable({
    // processing: true,
    // serverSide: true,
    // order: [[1, 'asc']],
    paging: true,
    searching: true,
    pageLength: 10,
    ordering: true,
    Destroy: true,
    ajax: "user/show_myconsults",
    columns: [
      {
        mRender: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        mRender: function (data, type, row) {
          var title = row.consult_name;
          if (title != null)
            title = title.replace(' ', '_');
          var facts = `<a href="consult/profile/` + row.id_consult + `/` + title + `" target="_blank" class="btn btn-info btn-sm" title="مشاهده پروفایل مشاور">` + row.consult_name + `  <i class="fa fa-user"> </i></a>&nbsp;`;
          return facts;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.regist_date;
        }
      },
      {
        mRender: function (data, type, row) {
          if (row.consult_date != null)
            return row.consult_date + " ساعت " + row.consult_time;
          else
            return 'در انتظار';
        }
      },
      {
        mRender: function (data, type, row) {
          return row.consult_type;
        }
      },
      {
        mRender: function (data, type, row) {
          var abstract_comment = makeAbstract(row.memo, 30);
          var tag = "<p class='font-13' title='" + row.memo + "' style='cursor: help'>" + abstract_comment + "</p>";
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
          var title = row.consult_name;
          if (title != null)
            title = title.replace(' ', '_');
          var facts = `<a href="user/consulting/` + row.id + `/` + title + `" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i> </a>&nbsp;`;
          return facts;
        }
      },
    ]
  });
}

function deleteProduct(id) {
  Swal.fire({
    title: 'حذف مورد مصرفی تسهیلات',
    text: "آیا برای حذف کالا مطمئن هستید؟",
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
      formDataa.append('id_user', $("#id_u").val());
      formDataa.append('id_vam', $("#id_vam").val());
      $.ajax({
        url: "markaz/deleteVamProduct",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
          'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
          ShowWaiting("حذف کالای تسهیلات");
        },
        success: function (result) {
          if (!result.error) {
            var product_price=result.data;
            var sum=$("#sum").text();
            sum=sum.replace(/,/g,'')
            sum=parseInt(sum);
            product_price=parseInt(product_price);
            if(sum>product_price)
              sum=sum-product_price;
            else
              sum=product_price-sum;
            check2price(sum);

            sum=number_format(sum);
            $("#product_" + id).remove();
            var tr_sum='<tr id="tr_sum"><td colspan="2">مجموع مبلغ مصارف وام</td><td ><span id="sum">'+sum+'</span> تومان </td></tr>';
            $("#tr_sum").remove();
            $("#table_products").append(tr_sum);

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

function deleteCourse(id) {
  Swal.fire({
    title: 'حذف دوره آموزشی',
    text: "آیا برای حذف دوره آموزشی مطمئن هستید؟",
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
      formDataa.append('id_user', $("#id_u").val());
      formDataa.append('id_database1', $("#id_database1").val());
      $.ajax({
        url: "markaz/deleteDatabase1Course",
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
            $("#course_" + id).remove();
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

$("#btn_update_personal_info").on("click", function (event) {
  var user_name = $("#user_name").val();
  var fathername = $("#fathername").val();
  var user_nationalid = $("#user_nationalid").val();
  var user_birthdate = $("#user_birthdate").val();
  var user_gender = $("#user_gender").val();
  var user_married = $("#user_married").val();
  var state = $("#state").val();
  var city = $("#city").val();
  var user_job = $("#user_job").val();
  var user_address_home = $("#user_address_home").val();
  var user_postalcode = $("#user_postalcode").val();
  var user_address_work = $("#user_address_work").val();
  var user_image = $('#user_image')[0].files[0];
  let formDataa = new FormData();
  formDataa.append('user_name', user_name);
  formDataa.append('fathername', fathername);
  formDataa.append('user_nationalid', user_nationalid);
  formDataa.append('user_birthdate', user_birthdate);
  formDataa.append('user_gender', user_gender);
  formDataa.append('user_married', user_married);
  formDataa.append('state', state);
  formDataa.append('city', city);
  formDataa.append('user_job', user_job);
  formDataa.append('user_address_home', user_address_home);
  formDataa.append('user_postalcode', user_postalcode);
  formDataa.append('user_address_work', user_address_work);
  formDataa.append('user_image', user_image);
  $.ajax({
    url: "user/updateUserInfo",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت تغییرات مشخصات ");
    },
    success: function (result) {
      if (!result.error) {
        $("#menu_tab_skill").click();
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

$("#btn_update_skill_info").on("click", function (event) {
  var user_last_education = $("#user_last_education").val();
  var abstractAbout = $("#abstractAbout").val();
  var skills = CKEDITOR.instances['skills'].getData();
  var learn_history = CKEDITOR.instances['learn_history'].getData();
  var about = CKEDITOR.instances['about'].getData();
  let formDataa = new FormData();
  formDataa.append('abstractAbout', abstractAbout);
  formDataa.append('about', about);
  formDataa.append('learn_history', learn_history);
  formDataa.append('skills', skills);
  formDataa.append('last_education', user_last_education);
  $.ajax({
    url: "user/updateUserSkills",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت تغییرات مشخصات مهارتی ");
    },
    success: function (result) {
      if (!result.error) {
        $("#menu_tab_contact").click();
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

$("#btn_update_contact_info").on("click", function (event) {
  var phonenumber = $("#phonenumber").val();
  var mobile2 = $("#mobile2").val();
  var tel = $("#tel").val();
  var tel_work = $("#tel_work").val();
  var website = $("#website").val();
  var email = $("#email").val();
  var soroush = $("#soroush").val();
  var eita = $("#eita").val();
  var telegram = $("#telegram").val();
  var instagram = $("#instagram").val();
  var linkdin = $("#linkdin").val();
  var whatsapp = $("#whatsapp").val();
  var aparat = $("#aparat").val();
  let formDataa = new FormData();
  formDataa.append('phonenumber', phonenumber);
  formDataa.append('mobile2', mobile2);
  formDataa.append('tel', tel);
  formDataa.append('tel_work', tel_work);
  formDataa.append('website', website);
  formDataa.append('email', email);
  formDataa.append('soroush', soroush);
  formDataa.append('eita', eita);
  formDataa.append('telegram', telegram);
  formDataa.append('instagram', instagram);
  formDataa.append('linkdin', linkdin);
  formDataa.append('whatsapp', whatsapp);
  formDataa.append('aparat', aparat);
  $.ajax({
    url: "user/updateUserContacts",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت تغییرات مشخصات تماس ");
    },
    success: function (result) {
      if (!result.error) {
        $("#menu_tab_bank").click();
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

$("#btn_update_bank_info").on("click", function (event) {
  var accountnumber = $("#account_no").val();
  var cardnumber = $("#cardnumber").val();
  var shabanumber = $("#shabanumber").val();
  let formDataa = new FormData();
  formDataa.append('accountnumber', accountnumber);
  formDataa.append('cardnumber', cardnumber);
  formDataa.append('shabanumber', shabanumber);
  $.ajax({
    url: "user/updateUserCards",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت تغییرات مشخصات بانکی ");
    },
    success: function (result) {
      if (!result.error) {
        $("#menu_tab_image").click();
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
  let formData = new FormData();
  formData.append('state', selectData);
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

$("#btn_update_setting_password").on("click", function (event) {
  var nowpass = $("#nowpass").val();
  var newpass = $("#newpass").val();
  var renewpass = $("#renewpass").val();
  if (newpass == renewpass) {
    if (newpass.length < 8) {
      ShowMessage("تعداد کاراکترهای کلمه عبور جدید کم است", "error");
    } else {
      let formDataa = new FormData();
      formDataa.append('nowpass', nowpass);
      formDataa.append('newpass', newpass);
      formDataa.append('renewpass', renewpass);
      $.ajax({
        url: "updateUserPass",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
          'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
          ShowWaiting("ثب تغییرات امنیتی");
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
    }
  } else
    ShowMessage("کلمات عبور جدید یکسان نمی باشد", "error");
});

$("#btn_update_setting_permission").on("click", function (event) {
  var view_twostep = 0;
  var view_phone = 0;
  var view_email = 0;
  var view_chat = 0;
  var view_social = 0;
  if ($('#view_twostep').is(":checked"))
    view_twostep = 1;
  if ($('#view_phone').is(":checked"))
    view_phone = 1;
  if ($('#view_email').is(":checked"))
    view_email = 1;
  if ($('#view_chat').is(":checked"))
    view_chat = 1;
  if ($('#view_social').is(":checked"))
    view_social = 1;
  let formDataa = new FormData();
  formDataa.append('view_twostep', view_twostep);
  formDataa.append('view_phone', view_phone);
  formDataa.append('view_email', view_email);
  formDataa.append('view_chat', view_chat);
  formDataa.append('view_social', view_social);
  $.ajax({
    url: "updateUserPermission",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثب تغییرات پروفایل");
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

$('#btnUpdateUserImages').click(function () {
  var personal_img = $('#personal_img')[0].files[0];
  var nationaid_img = $('#nationaid_img')[0].files[0];
  var cert_img = $('#cert_img')[0].files[0];
  var shsh_img = $('#shsh_img')[0].files[0];
  let formDataa = new FormData();
  formDataa.append('cert_img', cert_img);
  formDataa.append('nationaid_img', nationaid_img);
  formDataa.append('personal_img', personal_img);
  formDataa.append('shsh_img', shsh_img);
  $.ajax({
    url: "user/updateUserImages",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("بارگزاری تصاویر");
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
      ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
    }
  });
});

$("#btn_regist_vam").on("click", function (event) {
  var user_name = $("#user_name").val();
  var user_family = $("#user_family").val();
  var user_type_job = $("#user_type_job").val();
  var user_fathername = $("#user_fathername").val();
  var user_id_service = $("#user_id_service").val();
  var user_id_national = $("#user_id_national").val();
  var user_relatewithsarparast = $("#user_relatewithsarparast").val();
  var user_phonenumber = $("#user_phonenumber").val();
  var user_tel = $("#user_tel").val();
  var user_edge = $("#user_edge").val();
  var user_cert_maharat = $("#user_cert_maharat").val();
  var user_vam_price = $("#user_vam_price").val();
  var user_address_work = $("#user_address_work").val();
  var user_products = $("#user_products").val();
  var user_relatewithtalabe = $("#user_relatewithtalabe").val();
  var user_have_madrak = $("#user_have_madrak").val();
  var user_madrak_markaz_name = $("#user_madrak_markaz_name").val();
  var user_madrak_markaz_tajrobe = $("#user_madrak_markaz_tajrobe").val();
  var user_tolid_capacity = $("#user_tolid_capacity").val();
  var user_tolid_place = $("#user_tolid_place").val();
  var user_tolid_space = $("#user_tolid_space").val();
  var user_tolid_time = $("#user_tolid_time").val();
  var user_tolid_forosh = $("#user_tolid_forosh").val();
  var user_tolid_money = $("#user_tolid_money").val();
  var user_forosh_way = $("#user_forosh_way").val();
  var user_forosh_way_memo = $("#user_forosh_way_memo").val();
  var user_forosh_suggest = $("#user_forosh_suggest").val();
  var user_maziyat_reqabat = $("#user_maziyat_reqabat").val();
  var user_contact_way = $("#user_contact_way").val();
  var user_sabeqe_kar = $("#user_sabeqe_kar").val();

  var isValid = true;
  var message = "";

  if (!user_maziyat_reqabat) {
    isValid = false;
    message = "لطفا مزیت رقابتی خود را وارد نمائید";
  }

  if (!user_forosh_way_memo) {
    isValid = false;
    message = "توضیح مختصری را وارد نمائید";
  }

  if (!user_products) {
    isValid = false;
    message = "لطفا نوع محصولات تولیدی/خدماتی را وارد نمائید";
  }
  if (!user_address_work) {
    isValid = false;
    message = "لطفا آدرس محل کسب و کار را وارد نمائید";
  }

  if (!user_vam_price) {
    isValid = false;
    message = "لطفا مبلغ وام درخواستی را وارد نمائید";
  }

  if (!user_edge) {
    isValid = false;
    message = "لطفا سن را وارد نمائید";
  }

  if (!user_phonenumber) {
    isValid = false;
    message = "لطفا تلفن همراه را وارد نمائید";
  }

  if (!user_id_national) {
    isValid = false;
    message = "لطفا کد ملی را وارد نمائید";
  }

  if (!user_id_service) {
    isValid = false;
    message = "لطفا کد مرکز را وارد نمائید";
  }

  if (!user_fathername) {
    isValid = false;
    message = "لطفا نام پدر را وارد نمائید";
  }

  if (!user_family) {
    isValid = false;
    message = "لطفا نام خانوادگی را وارد نمائید";
  }

  if (!user_name) {
    isValid = false;
    message = "لطفا نام را وارد نمائید";
  }
  if (isValid == true) {
    let formData = new FormData();
    formData.append('user_name', user_name);
    formData.append('user_family', user_family);
    formData.append('user_type_job', user_type_job);
    formData.append('user_fathername', user_fathername);
    formData.append('user_id_service', user_id_service);
    formData.append('user_id_national', user_id_national);
    formData.append('user_relatewithsarparast', user_relatewithsarparast);
    formData.append('user_phonenumber', user_phonenumber);
    formData.append('user_tel', user_tel);
    formData.append('user_edge', user_edge);
    formData.append('user_cert_maharat', user_cert_maharat);
    formData.append('user_vam_price', user_vam_price);
    formData.append('user_address_work', user_address_work);
    formData.append('user_products', user_products);
    formData.append('user_relatewithtalabe', user_relatewithtalabe);
    formData.append('user_have_madrak', user_have_madrak);
    formData.append('user_madrak_markaz_name', user_madrak_markaz_name);
    formData.append('user_madrak_markaz_tajrobe', user_madrak_markaz_tajrobe);
    formData.append('user_tolid_capacity', user_tolid_capacity);
    formData.append('user_tolid_place', user_tolid_place);
    formData.append('user_tolid_space', user_tolid_space);
    formData.append('user_tolid_time', user_tolid_time);
    formData.append('user_tolid_forosh', user_tolid_forosh);
    formData.append('user_tolid_money', user_tolid_money);
    formData.append('user_forosh_way', user_forosh_way);
    formData.append('user_forosh_way_memo', user_forosh_way_memo);
    formData.append('user_forosh_suggest', user_forosh_suggest);
    formData.append('user_maziyat_reqabat', user_maziyat_reqabat);
    formData.append('user_contact_way', user_contact_way);
    formData.append('user_sabeqe_kar', user_sabeqe_kar);
    formData.append('id_user', $("#id_u").val());
    $.ajax({
      url: "markaz/requestVam",
      type: 'POST',
      cache: false,
      data: formData,
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      beforeSend: function () {
        ShowWaiting("ثبت درخواست تسهیلات (وام)");
      },
      success: function (result) {
        if (!result.error) {
          $("#menu_tab_masraf").click();
          $("#id_vam").val(result.data);

          $("#span_vam_price").text(user_vam_price)
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
  } else
    ShowMessage(message, "error");
});

$("#btn_regist_vam_editor").on("click", function (event) {
  var user_name = $("#user_name").val();
  var user_family = $("#user_family").val();
  var user_type_job = $("#user_type_job").val();
  var user_fathername = $("#user_fathername").val();
  var user_id_service = $("#user_id_service").val();
  var user_id_state = $("#user_id_state").val();
  var user_id_national = $("#user_id_national").val();
  var user_relatewithsarparast = $("#user_relatewithsarparast").val();
  var user_phonenumber = $("#user_phonenumber").val();
  var user_tel = $("#user_tel").val();
  var user_edge = $("#user_edge").val();
  var user_cert_maharat = $("#user_cert_maharat").val();
  var user_vam_price = $("#user_vam_price").val();
  var user_address_work = $("#user_address_work").val();
  var user_products = $("#user_products").val();
  var user_relatewithtalabe = $("#user_relatewithtalabe").val();
  var user_have_madrak = $("#user_have_madrak").val();
  var user_madrak_markaz_name = $("#user_madrak_markaz_name").val();
  var user_madrak_markaz_tajrobe = $("#user_madrak_markaz_tajrobe").val();
  var user_tolid_capacity = $("#user_tolid_capacity").val();
  var user_tolid_place = $("#user_tolid_place").val();
  var user_tolid_space = $("#user_tolid_space").val();
  var user_tolid_time = $("#user_tolid_time").val();
  var user_tolid_forosh = $("#user_tolid_forosh").val();
  var user_tolid_money = $("#user_tolid_money").val();
  var user_forosh_way = $("#user_forosh_way").val();
  var user_forosh_way_memo = $("#user_forosh_way_memo").val();
  var user_forosh_suggest = $("#user_forosh_suggest").val();
  var user_maziyat_reqabat = $("#user_maziyat_reqabat").val();
  var user_contact_way = $("#user_contact_way").val();
  var user_sabeqe_kar = $("#user_sabeqe_kar").val();

  var isValid = true;
  var message = "";

  if (!user_maziyat_reqabat) {
    isValid = false;
    message = "لطفا مزیت رقابتی خود را وارد نمائید";
  }

  if (!user_forosh_way_memo) {
    isValid = false;
    message = "توضیح مختصری را وارد نمائید";
  }

  if (!user_products) {
    isValid = false;
    message = "لطفا نوع محصولات تولیدی/خدماتی را وارد نمائید";
  }
  if (!user_address_work) {
    isValid = false;
    message = "لطفا آدرس محل کسب و کار را وارد نمائید";
  }

  if (!user_vam_price) {
    isValid = false;
    message = "لطفا مبلغ وام درخواستی را وارد نمائید";
  }

  if (!user_edge) {
    isValid = false;
    message = "لطفا سن را وارد نمائید";
  }

  if (!user_phonenumber) {
    isValid = false;
    message = "لطفا تلفن همراه را وارد نمائید";
  }

  if (!user_id_national) {
    isValid = false;
    message = "لطفا کد ملی را وارد نمائید";
  }

  if (!user_id_service) {
    isValid = false;
    message = "لطفا کد مرکز را وارد نمائید";
  }

  if (!user_fathername) {
    isValid = false;
    message = "لطفا نام پدر را وارد نمائید";
  }

  if (!user_family) {
    isValid = false;
    message = "لطفا نام خانوادگی را وارد نمائید";
  }

  if (!user_name) {
    isValid = false;
    message = "لطفا نام را وارد نمائید";
  }
  if (isValid == true) {
    let formData = new FormData();
    formData.append('user_name', user_name);
    formData.append('user_family', user_family);
    formData.append('user_type_job', user_type_job);
    formData.append('user_fathername', user_fathername);
    formData.append('user_id_service', user_id_service);
    formData.append('user_id_national', user_id_national);
    formData.append('user_relatewithsarparast', user_relatewithsarparast);
    formData.append('user_phonenumber', user_phonenumber);
    formData.append('user_tel', user_tel);
    formData.append('user_edge', user_edge);
    formData.append('user_cert_maharat', user_cert_maharat);
    formData.append('user_vam_price', user_vam_price);
    formData.append('user_address_work', user_address_work);
    formData.append('user_products', user_products);
    formData.append('user_relatewithtalabe', user_relatewithtalabe);
    formData.append('user_have_madrak', user_have_madrak);
    formData.append('user_madrak_markaz_name', user_madrak_markaz_name);
    formData.append('user_madrak_markaz_tajrobe', user_madrak_markaz_tajrobe);
    formData.append('user_tolid_capacity', user_tolid_capacity);
    formData.append('user_tolid_place', user_tolid_place);
    formData.append('user_tolid_space', user_tolid_space);
    formData.append('user_tolid_time', user_tolid_time);
    formData.append('user_tolid_forosh', user_tolid_forosh);
    formData.append('user_tolid_money', user_tolid_money);
    formData.append('user_forosh_way', user_forosh_way);
    formData.append('user_forosh_way_memo', user_forosh_way_memo);
    formData.append('user_forosh_suggest', user_forosh_suggest);
    formData.append('user_maziyat_reqabat', user_maziyat_reqabat);
    formData.append('user_contact_way', user_contact_way);
    formData.append('user_sabeqe_kar', user_sabeqe_kar);
    formData.append('id_user', $("#id_u").val());
    $.ajax({
      url: "markaz/requestVam_editor",
      type: 'POST',
      cache: false,
      data: formData,
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      beforeSend: function () {
        ShowWaiting("ثبت درخواست تسهیلات (وام)");
      },
      success: function (result) {
        if (!result.error) {
          $("#menu_tab_masraf").click();
          $("#id_vam").val(result.data);
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
  } else
    ShowMessage(message, "error");
});

function next_tab(elm) {
  $("#" + elm).click();
}

$("#btn_add_vam_product").on("click", function (event) {
  var product_title = $("#product_title").val();
  var product_brand = $("#product_title").val();
  var product_price = $("#product_price").val();
  let formData = new FormData();
  formData.append('product_title', product_title);
  formData.append('product_brand', product_brand);
  formData.append('product_price', product_price);
  formData.append('id_user', $("#id_u").val());
  formData.append('id_vm', $("#id_vam").val());
  var isvalid=true;
  var message='';

  if(!product_price){
    isvalid=false;
    message='مبلغ کالا را وارد نمائید';
  }
  if(!product_brand){
    isvalid=false;
    message='جنس کالا را وارد نمائید';
  }
  if(!product_title){
    isvalid=false;
    message='عنوان کالا را وارد نمائید';
  }

  if(isvalid ==true) {
    $.ajax({
      url: "markaz/addVamProduct",
      type: 'POST',
      cache: false,
      data: formData,
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      beforeSend: function () {
        ShowWaiting("ثبت درخواست تسهیلات (وام)");
      },
      success: function (result) {
        if (!result.error) {
          $('#form2').find("input[type=text], textarea").val("");
          $("#form2").trigger('reset');
          $("#product_price").val('');
          var tr = '<tr id="product_' + result.data + '">';
          tr = tr + '<td>' + product_title + '</td>';
          tr = tr + '<td>' + product_brand + '</td>';
          tr = tr + '<td>' +number_format(product_price) + '</td>';
          var facts = `<button onclick="deleteProduct(` + result.data + `)" class="btn btn-danger btn-sm" title="حذف مورد"  ><i class="fa fa-trash"></i></button>`;
          tr = tr + '<td>' + facts + '</td>';
          tr = tr + '</tr>';

          var sum=$("#sum").text();

          sum=sum.replace(/,/g,'')
          sum=parseInt(sum)
          if (isNaN(sum))
            sum = parseInt(product_price);
          else
            sum = sum+ parseInt(product_price);


          check2price(sum);

          sum=number_format(sum);
          var tr_sum='<tr id="tr_sum"><td colspan="2">مجموع مبلغ مصارف وام</td><td ><span id="sum">'+sum+'</span> تومان </td></tr>';
          $("#tr_sum").remove();
          $("#table_products").append(tr);
          $("#table_products").append(tr_sum);



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
  else
    ShowMessage(message, 'error');
});

$("#btn_upload_vam_file").on("click", function (event) {
  var vam_cert_img = $('#vam_cert_img')[0].files[0];
  var vam_mohit_img1 = $('#vam_mohit_img1')[0].files[0];
  var vam_mojavez_img = $('#vam_mojavez_img')[0].files[0];
  var vam_mohit_img2 = $('#vam_mohit_img2')[0].files[0];
  let formData = new FormData();
  formData.append('vam_cert_img', vam_cert_img);
  formData.append('vam_mohit_img1', vam_mohit_img1);
  formData.append('vam_mojavez_img', vam_mojavez_img);
  formData.append('vam_mohit_img2', vam_mohit_img2);
  formData.append('id_user', $("#id_u").val());
  formData.append('id_vm', $("#id_vam").val());
  $.ajax({
    url: "markaz/uploadVamAttach",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("بارگزاری مستندات");
    },
    success: function (result) {
      if (!result.error) {
        // $('#form2').find("input[type=text], textarea").val("");
        // $("#form2").trigger('reset');
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

$("#btn_verify_vam").on("click", function (event) {
  let formData = new FormData();
  formData.append('id_user', $("#id_u").val());
  formData.append('id_vm', $("#id_vam").val());
  $.ajax({
    url: "markaz/verifyVam",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("تایید نهایی تسهیلات");
    },
    success: function (result) {
      if (!result.error) {
        $("#code_followup").text(result.data);
        $("#divcode").show();
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

$("#btn_regist_database1").on("click", function (event) {
  let formdata = new FormData();
  formdata.append('name', $("#user_name").val());
  formdata.append('family', $("#user_family").val());
  formdata.append('fathername', $("#fathername").val());
  formdata.append('id_service', $("#user_id_service").val());
  formdata.append('id_national', $("#user_id_national").val());
  formdata.append('birthdate', $("#user_birthdate").val());
  formdata.append('birthdate_place', $("#user_birthdate_place").val());
  formdata.append('phonenumber', $("#user_phonenumber").val());
  formdata.append('tel', $("#user_tel").val());
  formdata.append('eita', $("#user_eita").val());
  formdata.append('instagram', $("#user_instagram").val());
  formdata.append('email', $("#user_email").val());
  formdata.append('postalcode', $("#user_postalcode").val());
  formdata.append('address', $("#user_address").val());
  formdata.append('married', $("#user_married").val());
  formdata.append('childcount', $("#user_childcount").val());
  formdata.append('relatewithtalabe', $("#user_relatewithtalabe").val());
  formdata.append('sarparast', $("#user_sarparast").val());
  formdata.append('child_takafol_count', $("#user_child_takafol_count").val());
  formdata.append('sarparast_name', $("#user_sarparast_name").val());
  formdata.append('health_status', $("#user_health_status").val());
  formdata.append('naghs_ozv', $("#user_naghs_ozv").val());
  formdata.append('bimari_khas', $("#user_bimari_khas").val());
  formdata.append('last_univercity_cert', $("#last_univercity_cert").val());
  formdata.append('univercity_reshte', $("#user_univercity_reshte").val());
  formdata.append('univercity_name', $("#user_univercity_name").val());
  formdata.append('last_howze_cert', $("#last_howze_cert").val());
  formdata.append('howze_reshte', $("#user_howze_reshte").val());
  formdata.append('howze_name', $("#user_howze_name").val());
  formdata.append('learn_maharat', $("#user_learn_maharat").val());
  formdata.append('learn_maharat_name', $("user_#learn_maharat_name").val());
  formdata.append('ashna_maharat', $("#user_ashna_maharat").val());
  formdata.append('tajrobe_count', $("#user_tajrobe_count").val());
  formdata.append('ashna_maharat_name', $("#user_ashna_maharat_name").val());
  formdata.append('level_maharat', $("#user_level_maharat").val());
  formdata.append('level_maharat_memo', $("#user_level_maharat_memo").val());
  formdata.append('favorite_maharat', $("#user_favorite_maharat").val());
  formdata.append('why_select_favorite', $("#user_why_select_favorite").val());
  formdata.append('dontstart_maharat', $("#user_dontstart_maharat").val());
  formdata.append('daryaft_vam', $("#user_daryaft_vam").val());
  formdata.append('masraf_vam', $("#user_masraf_vam").val());
  formdata.append('learn_maharat_name', $("#user_learn_maharat_name").val());
  formdata.append('id_user', $("#id_u").val());
  $.ajax({
    url: "markaz/registDatabase1",
    type: 'POST',
    cache: false,
    data: formdata,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت بانک اطلاعاتی");
    },
    success: function (result) {
      if (!result.error) {
        // $('#form1').find("input[type=text], textarea").val("");
        // $("#form1").trigger('reset');
        $("#menu_tab_bank").click();
        $("#id_database1").val(result.data);
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

$("#btn_add_course_database1").on("click", function (event) {
  let formdata = new FormData();
  var title = $("#course_title").val();
  var level = $("#course_level").val();
  var type = $("#course_type").val();
  var price = $("#course_price").val();
  var memo = $("#course_memo").val();
  formdata.append('course_title', title);
  formdata.append('course_level', level);
  formdata.append('course_type', type);
  formdata.append('course_price', price);
  formdata.append('course_memo', memo);
  formdata.append('id_db', $("#id_database1").val());
  $.ajax({
    url: "markaz/registDatabase1Course",
    type: 'POST',
    cache: false,
    data: formdata,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت دوره آموزشی");
    },
    success: function (result) {
      if (!result.error) {
        var tr = "<tr id='course_" + result.data + "'>";
        tr = tr + "<td>" + title + "</td>";
        tr = tr + "<td>" + level + "</td>";
        tr = tr + "<td>" + type + "</td>";
        tr = tr + "<td>" + price + "</td>";
        tr = tr + "<td>" + memo + "</td>";
        var facts = `<button onclick="deleteCourse(` + result.data + `)" class="btn btn-danger btn-sm" title="حذف دوره"  ><i class="fa fa-trash"></i></button>`;
        tr = tr + "<td>" + facts + "</td>";
        tr = tr + "</tr>";
        $("#table_markaz_courses").append(tr);
        // $("#new_course_modal").hide();
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

$("#btn_upload_database1_file").on("click", function (event) {
  var cert_img = $('#cert_img')[0].files[0];
  var national_img = $('#national_img')[0].files[0];
  var mojavez_img = $('#mojavez_img')[0].files[0];
  var sh_img = $('#sh_img')[0].files[0];
  let formData = new FormData();
  formData.append('cert_img', cert_img);
  formData.append('national_img', national_img);
  formData.append('mojavez_img', mojavez_img);
  formData.append('sh_img', sh_img);
  formData.append('id_user', $("#id_u").val());
  formData.append('id_database1', $("#id_database1").val());
  $.ajax({
    url: "markaz/uploadDatabase1Attach",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("بارگزاری مستندات");
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

$("#btn_verify_database1").on("click", function (event) {
  let formData = new FormData();
  formData.append('id_user', $("#id_u").val());
  formData.append('id_database1', $("#id_database1").val());
  formData.append('user_nahad_learn', $("#user_nahad_learn").val());
  formData.append('user_contact_way', $("#user_contact_way").val());
  $.ajax({
    url: "markaz/verifyDatabase1",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("تایید نهایی بانک اطلاعاتی");
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

$("#btn_regist_database2").on("click", function (event) {

  var isValid = true;
  var message = "";

  if (!$("#user_id_service").val()) {
    isValid = false;
    message = "لطفا کد مرکز خدمات خود را وارد نمائید";
  }
  if (!$("#user_id_national").val()) {
    isValid = false;
    message = "لطفا کد ملی خود را وارد نمائید";
  }
  if (!$("#user_name").val()) {
    isValid = false;
    message = "لطفا نام را وارد نمائید";
  }
  if (!$("#user_family").val()) {
    isValid = false;
    message = "لطفا نام خانوادگی را وارد نمائید";
  }
  if (!$("#fathername").val()) {
    isValid = false;
    message = "لطفا نام پدر را وارد نمائید";
  }
  if (!$("#user_birthdate").val()) {
    isValid = false;
    message = "لطفا تاریخ تولد را وارد نمائید";
  }
  if (!$("#user_birthdate_place").val()) {
    isValid = false;
    message = "لطفااستان محل تولد را وارد نمائید";
  }

  if (!$("#user_phonenumber").val()) {
    isValid = false;
    message = "لطفا شماره موبایل را وارد نمائید";
  }


  if (!$("#user_tel").val()) {
    isValid = false;
    message = "لطفا شماره تماس را وارد نمائید";
  }

  if (!$("#user_tel").val()) {
    isValid = false;
    message = "لطفا شماره تماس را وارد نمائید";
  }

  if (!$("#user_address").val()) {
    isValid = false;
    message = "لطفا آدرس را وارد نمائید";
  }

  if (!$("#user_have_maharat_job_title").val()) {
    isValid = false;
    message = "عنوان کسب و کار را وارد نمائید";
  }

  if (!$("#user_have_maharat_job_memo").val()) {
    isValid = false;
    message = "خلاصه کسب و کار را وارد نمائید";
  }

  if (!$("#user_have_have_job_problems").val()) {
    isValid = false;
    message = "موانع و مشکلات کسب و کار را وارد نمائید";
  }

  if (!$("#user_masraf_vam").val()) {
    isValid = false;
    message = "موارد مصرف تسهیلات را وارد نمائید";
  }
  if(isValid==true) {
    let formdata = new FormData();
    formdata.append("id_user", $("#id_u").val());
    // formdata.append("id_markaz", $("#user_id_markaz").val());
    // formdata.append("id_talabe", $("#user_id_talabe").val());
    formdata.append("id_service", $("#user_id_service").val());
    formdata.append("id_national", $("#user_id_national").val());
    formdata.append("name", $("#user_name").val());
    formdata.append("family", $("#user_family").val());
    formdata.append("fathername", $("#fathername").val());
    formdata.append("birthdate", $("#user_birthdate").val());
    formdata.append("birthdate_place", $("#user_birthdate_place").val());
    formdata.append("phonenumber", $("#user_phonenumber").val());
    formdata.append("tel", $("#user_tel").val());
    formdata.append("eita", $("#user_eita").val());
    formdata.append("instagram", $("#user_instagram").val());
    formdata.append("email", $("#user_email").val());
    formdata.append("postalcode", $("#user_postalcode").val());
    formdata.append("address", $("#user_address").val());
    formdata.append("address_work", $("#user_address_work").val());
    formdata.append("married", $("#user_married").val());
    formdata.append("childcount", $("#user_childcount").val());
    formdata.append("relatewithtalabe", $("#user_relatewithtalabe").val());
    formdata.append("sarparast", $("#user_sarparast").val());
    formdata.append("child_takafol_count", $("#user_child_takafol_count").val());
    formdata.append("sarparast_name", $("#user_sarparast_name").val());
    formdata.append("health_status", $("#user_health_status").val());
    formdata.append("naghs_ozv", $("#user_naghs_ozv").val());
    formdata.append("bimari_khas", $("#user_bimari_khas").val());
    formdata.append("last_univercity_cert", $("#user_last_univercity_cert").val());
    formdata.append("last_howze_cert", $("#user_last_howze_cert").val());
    formdata.append("univercity_reshte", $("#user_univercity_reshte").val());
    formdata.append("univercity_name", $("#user_univercity_name").val());
    formdata.append("howze_reshte", $("#user_howze_reshte").val());
    formdata.append("howze_name", $("#user_howze_name").val());
    formdata.append("have_maharat", $("#user_have_maharat").val());
    formdata.append("have_maharat_name", $("#user_have_maharat_name").val());
    formdata.append("have_maharat_level", $("#user_have_maharat_level").val());
    formdata.append("have_maharat_cert", $("#user_have_maharat_cert").val());
    formdata.append("have_maharat_cert_name", $("#user_have_maharat_cert_name").val());
    formdata.append("have_maharat_tajrobe", $("#user_have_maharat_tajrobe").val());
    formdata.append("have_maharat_learning", $("#user_have_maharat_learning").val());
    formdata.append("have_maharat_learning_malzomat", $("#user_have_maharat_learning_malzomat").val());
    formdata.append("have_maharat_job", $("#user_have_maharat_job").val());
    formdata.append("have_mahrat_job_type", $("#user_have_mahrat_job_type").val());
    formdata.append("have_maharat_job_title", $("#user_have_maharat_job_title").val());
    formdata.append("have_maharat_job_memo", $("#user_have_maharat_job_memo").val());
    formdata.append("have_have_job_problems", $("#user_have_have_job_problems").val());
    formdata.append("donthave_job_reason", $("#user_donthave_job_reason").val());
    formdata.append("karafarini_memo", $("#user_karafarini_memo").val());
    formdata.append("ashna_forosh", $("#user_ashna_forosh").val());
    formdata.append("favorite_rahbar", $("#user_favorite_rahbar").val());
    formdata.append("created_job", $("#user_created_job").val());
    formdata.append("learn_takmili", $("#user_learn_takmili").val());
    formdata.append("learn_takmili_courses", $("#user_learn_takmili_courses").val());
    formdata.append("daryaft_vam", $("#user_daryaft_vam").val());
    formdata.append("masraf_vam", $("#user_masraf_vam").val());
    formdata.append("contact_way", $("#user_contact_way").val());

    $.ajax({
      url: "markaz/registDatabase2",
      type: 'POST',
      cache: false,
      data: formdata,
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      beforeSend: function () {
        ShowWaiting("ثبت بانک اطلاعاتی");
      },
      success: function (result) {
        if (!result.error) {
          // $('#form1').find("input[type=text], textarea").val("");
          // $("#form1").trigger('reset');
          $("#menu_tab_doc").click();
          $("#id_database2").val(result.data);
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
  else
    ShowMessage(message, "error");

});

$("#btn_upload_database2_file").on("click", function (event) {
  var cert_img = $('#cert_img')[0].files[0];
  var national_img = $('#national_img')[0].files[0];
  var mojavez_img = $('#mojavez_img')[0].files[0];
  var sh_img = $('#sh_img')[0].files[0];
  let formData = new FormData();
  formData.append('cert_img', cert_img);
  formData.append('national_img', national_img);
  formData.append('mojavez_img', mojavez_img);
  formData.append('sh_img', sh_img);
  formData.append('id_user', $("#id_u").val());
  formData.append('id_database2', $("#id_database2").val());
  $.ajax({
    url: "markaz/uploadDatabase2Attach",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("بارگزاری مستندات");
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

$("#btn_verify_database2").on("click", function (event) {
  let formData = new FormData();
  formData.append('id_user', $("#id_u").val());
  formData.append('id_database2', $("#id_database2").val());
  $.ajax({
    url: "markaz/verifyDatabase2",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("تایید نهایی بانک اطلاعاتی");
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

$("#btn_regist_database3").on("click", function (event) {
  let formdata = new FormData();
  formdata.append("id_user", $("#id_u").val());
  formdata.append("name", $("#user_name").val());
  formdata.append("family", $("#user_family").val());
  formdata.append("fathername", $("#fathername").val());
  formdata.append("id_service", $("#user_id_service").val());
  formdata.append("id_national", $("#user_id_national").val());
  formdata.append("birthdate", $("#user_birthdate").val());
  formdata.append("birthdate_place", $("#user_birthdate_place").val());
  formdata.append("phonenumber", $("#user_phonenumber").val());
  formdata.append("tel", $("#user_tel").val());
  formdata.append("eita", $("#user_eita").val());
  formdata.append("instagram", $("#user_instagram").val());
  formdata.append("email", $("#user_email").val());
  formdata.append("postalcode", $("#user_postalcode").val());
  formdata.append("address", $("#user_address").val());
  formdata.append("address_work", $("#user_address_work").val());
  formdata.append("last_univercity_cert", $("#user_last_univercity_cert").val());
  formdata.append("univercity_reshte", $("#user_univercity_reshte").val());
  formdata.append("univercity_name", $("#user_univercity_name").val());
  formdata.append("last_howze_cert", $("#user_last_howze_cert").val());
  formdata.append("howze_reshte", $("#user_howze_reshte").val());
  formdata.append("howze_name", $("#user_howze_name").val());
  formdata.append("job_history", $("#user_job_history").val());
  formdata.append("have_sabeqe", $("#user_have_sabeqe").val());
  formdata.append("burthdate", $("#user_birthdate").val());
  formdata.append("have_sabeqe_name", $("#user_have_sabeqe_name").val());
  formdata.append("have_maharat", $("#user_have_maharat").val());
  formdata.append("have_maharat_name", $("#user_have_maharat_name").val());
  formdata.append("have_maharat_level", $("#user_have_maharat_level").val());
  formdata.append("ashna_tolid", $("#user_ashna_tolid").val());
  formdata.append("created_job", $("#user_created_job").val());
  formdata.append("created_job_memo", $("#user_created_job_memo").val());
  formdata.append("created_job_requirements", $("#user_created_job_requirements").val());
  formdata.append("work_type", $("#user_work_type").val());
  formdata.append("contact_way", $("#user_contact_way").val());
  $.ajax({
    url: "markaz/registDatabase3",
    type: 'POST',
    cache: false,
    data: formdata,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت بانک اطلاعاتی");
    },
    success: function (result) {
      if (!result.error) {
        // $('#form1').find("input[type=text], textarea").val("");
        // $("#form1").trigger('reset');
        $("#menu_tab_bank").click();
        $("#id_database3").val(result.data);
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

$("#btn_upload_database3_file").on("click", function (event) {
  var cert_img = $('#cert_img')[0].files[0];
  var national_img = $('#national_img')[0].files[0];
  var mojavez_img = $('#mojavez_img')[0].files[0];
  var sh_img = $('#sh_img')[0].files[0];
  let formData = new FormData();
  formData.append('cert_img', cert_img);
  formData.append('national_img', national_img);
  formData.append('mojavez_img', mojavez_img);
  formData.append('sh_img', sh_img);
  formData.append('id_user', $("#id_u").val());
  formData.append('id_database3', $("#id_database3").val());
  $.ajax({
    url: "markaz/uploadDatabase3Attach",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("بارگزاری مستندات");
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

$("#btn_verify_database3").on("click", function (event) {
  let formData = new FormData();
  formData.append('id_user', $("#id_u").val());
  formData.append('id_database3', $("#id_database3").val());
  $.ajax({
    url: "markaz/verifyDatabase3",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("تایید نهایی بانک اطلاعاتی");
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

$("#btn_regist_database4").on("click", function (event) {
  let formdata = new FormData();
  formdata.append("id_user", $("#id_u").val());
  formdata.append("name", $("#user_name").val());
  formdata.append("family", $("#user_family").val());
  formdata.append("fathername", $("#fathername").val());
  formdata.append("id_service", $("#user_id_service").val());
  formdata.append("id_national", $("#user_id_national").val());
  formdata.append("birthdate", $("#user_birthdate").val());
  formdata.append("birthdate_place", $("#user_birthdate_place").val());
  formdata.append("phonenumber", $("#user_phonenumber").val());
  formdata.append("tel", $("#user_tel").val());
  formdata.append("eita", $("#user_eita").val());
  formdata.append("instagram", $("#user_instagram").val());
  formdata.append("email", $("#user_email").val());
  formdata.append("postalcode", $("#user_postalcode").val());
  formdata.append("address", $("#user_address").val());
  formdata.append("address_work", $("#user_address_work").val());
  formdata.append("last_howze_cert", $("#user_last_howze_cert").val());
  formdata.append("last_univercity_cert", $("#user_last_univercity_cert").val());
  formdata.append("raste_related", $("#user_raste_related").val());
  formdata.append("sabeqe_time", $("#user_sabeqe_time").val());
  formdata.append("ashna_forosh", $("#user_ashna_forosh").val());
  formdata.append("have_technick", $("#user_have_technick").val());
  formdata.append("have_technick_memo", $("#user_have_technick_memo").val());
  formdata.append("have_software", $("#user_have_software").val());
  formdata.append("have_software_name", $("#user_have_software_name").val());
  formdata.append("have_site", $("#user_have_site").val());
  formdata.append("have_site_address", $("#user_have_site_address").val());
  formdata.append("related_country", $("#user_related_country").val());
  formdata.append("forosh_out_country", $("#user_forosh_out_country").val());
  formdata.append("forosh_out_country_product_name", $("#user_forosh_out_country_product_name").val());
  formdata.append("forosh_out_country_name", $("#user_forosh_out_country_name").val());
  formdata.append("ashna_sefte", $("#user_ashna_sefte").val());
  formdata.append("forosh_type", $("#user_forosh_type").val());
  formdata.append("forosh_type_memo", $("#user_forosh_type_memo").val());
  formdata.append("ashna_pc", $("#user_ashna_pc").val());
  formdata.append("experience", $("#user_experience").val());
  formdata.append("forosh_problems", $("#user_forosh_problems").val());
  formdata.append("other_maharat", $("#user_other_maharat").val());
  formdata.append("forosh_suggestion", $("#user_forosh_suggestion").val());
  formdata.append("introduction", $("#user_introduction").val());
  formdata.append("move_experience", $("#user_move_experience").val());
  formdata.append("daryaft_vam", $("#user_daryaft_vam").val());
  formdata.append("masraf_vam", $("#user_masraf_vam").val());
  formdata.append("contact_way", $("#user_contact_way").val());
  $.ajax({
    url: "markaz/registDatabase4",
    type: 'POST',
    cache: false,
    data: formdata,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت بانک اطلاعاتی");
    },
    success: function (result) {
      if (!result.error) {
        // $('#form1').find("input[type=text], textarea").val("");
        // $("#form1").trigger('reset');
        $("#menu_tab_bank").click();
        $("#id_database4").val(result.data);
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

$("#btn_upload_database4_file").on("click", function (event) {
  var cert_img = $('#cert_img')[0].files[0];
  var national_img = $('#national_img')[0].files[0];
  var mojavez_img = $('#mojavez_img')[0].files[0];
  var sh_img = $('#sh_img')[0].files[0];
  let formData = new FormData();
  formData.append('cert_img', cert_img);
  formData.append('national_img', national_img);
  formData.append('mojavez_img', mojavez_img);
  formData.append('sh_img', sh_img);
  formData.append('id_user', $("#id_u").val());
  formData.append('id_database4', $("#id_database4").val());
  $.ajax({
    url: "markaz/uploadDatabase4Attach",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("بارگزاری مستندات");
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

$("#btn_verify_database4").on("click", function (event) {
  let formData = new FormData();
  formData.append('id_user', $("#id_u").val());
  formData.append('id_database4', $("#id_database4").val());
  $.ajax({
    url: "markaz/verifyDatabase4",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("تایید نهایی بانک اطلاعاتی");
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

$("#btn_regist_consult_comment").on("click", function (event) {
  let formDataa = new FormData();
  formDataa.append('user_score', $("#user_score").val());
  formDataa.append('user_comment', $("#user_comment").val());
  formDataa.append('consult_minutes', $("#consult_minutes").val());
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
      ShowWaiting("ثبت نظر کاربر");
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
})

$("#btn_recovery_vam_followcode").on("click", function (event) {
  $.ajax({
    url: "markaz/recover_followcode",
    type: 'GET',
    cache: false,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت نظر کاربر");
    },
    success: function (result) {
      if (!result.error) {
        $("#form_result").hide();
        $("#recover_followup_code").text(result.data);
        $("#form_followupcode").show();
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
