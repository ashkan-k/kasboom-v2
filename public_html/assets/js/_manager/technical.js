// var tollab_datatable="";
// var user_datatabless="";
var userID=0;

function loadAllUsers() {
    user_datatabless.DataTable({
        processing: true,
        serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "_manager/all_users",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    var div='';
                    if(row.level == 'teacher')
                        div=' <div class=""><img src="_upload_/_teachers_/'+row.code+'/small_'+row.image+'" class="avatar cover-image avatar-lg brround" alt="'+row.name+'"></div>';
                    else if(row.level == 'consult')
                        div=' <div class=""><img src="_upload_/_consult_/'+row.code+'/small_'+row.image+'" class="avatar cover-image avatar-lg brround" alt="'+row.name+'"></div>';
                    else
                        div=' <div class=""><img src="_upload_/_users_/'+row.code+'/personal/small_'+row.image+'" class="avatar cover-image avatar-lg brround" alt="'+row.name+'"></div>';
                    return div;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.name;
                }
            },

            {
                mRender: function (data, type, row) {
                    return row.username;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.level;

                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_city;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.regist_date;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.wallet
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.serviceid
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
                    var title=row.name;
                    if(title!= null)
                        title=title.replace(' ','_');
                    var facts='';
                    if(row.level == 'consult') {
                        facts = `<a href="_manager/consult_dashboard/` + row.id + `/` + title + `" title="پنل کاربری مشاور" target="_blank" class="btn btn-success  btn-sm text-white"> <i class="fa fa-id-card"></i> </a>&nbsp;`;
                    }
                    else if(row.level == 'teacher') {
                        facts = `<a href="_manager/teacher_dashboard/` + row.id + `/` + title + `" title="پنل کاربری مدرس" target="_blank" class="btn btn-success  btn-sm text-white"> <i class="fa fa-id-card"></i> </a>&nbsp;`;
                    }
                    else {
                        facts = `<a href="_manager/user_dashboard/` + row.id + `/` + title + `" title="پنل کاربری کاربر" target="_blank" class="btn btn-success  btn-sm text-white"> <i class="fa fa-id-card"></i> </a>&nbsp;`;
                    }
                    if(row.per_delete == true)
                        facts=facts+`<button type="button" onclick="deleteUser(`+row.id+`)" title="حذف" class="btn btn-danger  btn-sm text-white"> <i class="fa fa-trash"></i></button>`;

                    facts =facts+ `<a href="profile/` + row.id + `/` + title + `" title="پروفایل کاربری" target="_blank" class="btn btn-info  btn-sm text-white"> <i class="fa fa-user"></i> </a>&nbsp;`;
                    facts =facts+ `&nbsp;<a href="_manager/user_setting/` + row.id + `/` + title + `" title="تنظمیات کاربری" target="_blank" class="btn btn-warning  btn-sm text-white"> <i class="fe fe-settings"></i> </a>&nbsp;`;
                    facts =facts+ `&nbsp;<a href="_manager/user_detail/` + row.id + `/` + title + `" title="اطلاعات کاربری" target="_blank" class="btn btn-secondary  btn-sm text-white"> <i class="fa fa-info-circle"></i> </a>&nbsp;`;
                    return facts;
                }
            },
        ]
    });
}

function loadّFailureTollab() {
    user_datatable.DataTable({
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "technical/all_failure_tollab",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.name;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.fathername
                }
            },
            {
                mRender: function (data, type, row) {
                    var c_type=row.corp_type;
                    var c_rel=row.corp_relation;
                    if(c_type=="talabe"){
                        if(c_rel=="sarparast")
                            return "طلبه سرپرست";
                        else if(c_rel=="takafol")
                            return "طلبه تکفل";
                        else return "طلبه";
                    }
                    else if(c_type=="employee"){
                        if(c_rel=="sarparast")
                            return "کارمند سرپرست";
                        else if(c_rel=="takafol")
                            return "کارمند تکفل";
                        else return "کارمند";
                    }

                        return "";
                }
            },
            {
                mRender: function (data, type, row) {
                    if(row.nationality==1)
                        return "ایرانی";
                    else
                        return "غیرایرانی";

                }
            },
            {
                mRender: function (data, type, row) {
                    return row.serviceid;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.nationalid;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.birthdate
                }
            },
            {
                mRender: function (data, type, row) {
                    var elm=`<button class="btn btn-success btn-sm text-white" title="ویرایش" onclick="viewuser(`+row.id+`)" style="margin-bottom:10px"><i class="fa fa-edit"></i> </button>`;
                    elm=elm+`&nbsp;<label class="custom-switch" style="cursor: pointer;"><input type="checkbox" id="ck_`+row.id+`" onchange="changeStatus(`+row.id+`)" name="custom-switch-checkbox" class="custom-switch-input"><span class="custom-switch-indicator"></span><span class="custom-switch-description"></span></label>`;
                   return elm;
                }
            },
        ]
    });
}

function loadّFailureEmployee(){
    user_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        // order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "technical/all_failure_employee",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.name;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.fathername
                }
            },
            {
                mRender: function (data, type, row) {
                    var c_type=row.corp_type;
                    var c_rel=row.corp_relation;
                    if(c_type=="talabe"){
                        if(c_rel=="sarparast")
                            return "طلبه سرپرست";
                        else if(c_rel=="takafol")
                            return "طلبه تکفل";
                        else return "طلبه";
                    }
                    else if(c_type=="employee"){
                        if(c_rel=="sarparast")
                            return "کارمند سرپرست";
                        else if(c_rel=="takafol")
                            return "کارمند تکفل";
                        else return "کارمند";
                    }

                    return "";
                }
            },

            {
                mRender: function (data, type, row) {
                    return row.personal_code;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.nationalid;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.birthdate
                }
            },
            {
                mRender: function (data, type, row) {
                  var elm=`<button class="btn btn-success btn-sm text-white" title="ویرایش" onclick="viewuser(`+row.id+`)" style="margin-bottom:10px"><i class="fa fa-edit"></i> </button>`;
                  elm=elm+`<label class="custom-switch" style="cursor: pointer"><input type="checkbox" id="ck_`+row.id+`" onchange="changeStatus(`+row.id+`)" name="custom-switch-checkbox" class="custom-switch-input"><span class="custom-switch-indicator"></span><span class="custom-switch-description"></span></label>`;
                    return elm;
                }
            },
        ]
    });
}

function changeStatus(id) {
    let formDataa = new FormData();
    formDataa.append('id', id);
    formDataa.append('status', $('#ck_'+id).prop("checked"));
    $.ajax({
        url: "technical/verify_user",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("حذف اطلاعات کاربر");
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

$("#btn_update_setting_pass").on("click",function (event) {
    var nowpass=$("#nowpass").val();
    var newpass=$("#newpass").val();
    var renewpass=$("#renewpass").val();
    if(newpass==renewpass){
        if(newpass.length < 8){
            ShowMessage("تعداد کاراکترهای کلمه عبور جدید کم است", "error");
        }
        else {
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
    }
    else
        ShowMessage("کلمات عبور جدید یکسان نمی باشد", "error");
});

function viewuser(id){
  userID=id;
  $.ajax({
    url: "technical/viewuser/"+id,
    type: 'GET',
    cache: false,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("دریافت مشخصات کاربر");
    },
    success: function (result) {
      if (!result.error) {
        var data=result.data;
        $("#user_firstname").val(data['firstname'])
        $("#user_lastname").val(data['lastname'])
        $("#user_fathername").val(data['fathername'])
        $("#user_corp_type").val(data['corp_type'])
        $("#user_corp_relation").val(data['corp_relation'])
        $("#user_country").val(data['nationality'])
        $("#user_serviceid").val(data['serviceid'])
        $("#user_nationalid").val(data['nationalid'])
        $("#user_birthdate").val(data['birthdate'])
        $("#user_employed").val(data['employed'])
        $("#user_active").val(data['active'])
        $("#user_personal_code").val(data['personal_code'])

        if(data['corp_type']=='talabe'){
          $("#div_user_serviceid").show();
          $("#div_user_personal_code").hide();
        }
      else{
          $("#div_user_serviceid").hide();
          $("#div_user_personal_code").show();
        }
        $("#info_modal").show();
      }
      else
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

$("#btn_edit_userinfo").on("click",function (event) {
  let formData = new FormData();
  formData.append("firstname", $("#user_firstname").val());
  formData.append("lastname", $("#user_lastname").val());
  formData.append("fathername", $("#user_fathername").val());
  formData.append("corp_type", $("#user_corp_type").val());
  formData.append("corp_relation", $("#user_corp_relation").val());
  formData.append("country", $("#user_country").val());
  formData.append("serviceID", $("#user_serviceid").val());
  formData.append("nationalID", $("#user_nationalid").val());
  formData.append("birthdate", $("#user_birthdate").val());
  formData.append("employed", $("#user_employed").val());
  formData.append("active", $("#user_active").val());
  formData.append("personal_code", $("#user_personal_code").val());
  formData.append("userID", userID);

  $.ajax({
    url: "technical/updateUserinfo_technical",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت مشخصات کاربر");
    },
    success: function (result) {
      if (!result.error) {
        $("#user_firstname").val('');
        $("#user_lasttname").val('');
        $("#user_fathername").val('');
        $("#user_serviceID").val('');
        $("#user_nationalID").val('');
        $("#user_birthdate").val('');
        $("#user_employed").val('0');
        $("#user_active").val('1');
        $("#info_modal").hide();
        user_datatable.DataTable().ajax.reload();

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

$("#btn_delete_userinfo").on("click",function (event) {
  let formData = new FormData();
  formData.append("hide", 'true');
  formData.append("userID", userID);

  $.ajax({
    url: "technical/updateUserinfo_technical",
    type: 'POST',
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("حذف مشخصات کاربر");
    },
    success: function (result) {
      if (!result.error) {
        $("#user_firstname").val('');
        $("#user_lasttname").val('');
        $("#user_fathername").val('');
        $("#user_serviceID").val('');
        $("#user_nationalID").val('');
        $("#user_birthdate").val('');
        $("#user_employed").val('0');
        $("#user_active").val('1');
        $("#info_modal").hide();
        user_datatable.DataTable().ajax.reload();

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


$("#btn_cancel").on("click",function (event) {
  $("#info_modal").hide();

});


$("#btn_close").on("click",function (event) {
  $("#info_modal").hide();
});

