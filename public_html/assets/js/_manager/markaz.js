
function loadvams_manager() {
  vam_datatable.DataTable({
    // processing: true,
    // serverSide: true,

    // order: [[0, 'desc']],
    paging: true,
    searching: true,
    pageLength: 10,
    ordering: true,
    destroy: true,
    ajax: "markaz/admin/all_vams",
    "initComplete":function( settings, json){
      var cnt_faild=0;
      var cnt_nok=0;
      var cnt_ok=0;
      var cnt_wait=0;
      for (var i = 0; i < (json.data).length; i = i + 1) {
        var modir_accept = json.data[i]['modir_accept']
        if (modir_accept == "wait")
          cnt_wait = cnt_wait + 1;
        else if (modir_accept == "ok")
          cnt_ok = cnt_ok + 1;
        else if (modir_accept == "nok")
          cnt_nok = cnt_nok + 1;
        else if (modir_accept == "faild"){
          cnt_faild = cnt_faild + 1;
        }
      }
      $("#cnt_wait").text(cnt_wait)
      $("#cnt_ok").text(cnt_ok)
      $("#cnt_nok").text(cnt_nok)
      $("#cnt_faild").text(cnt_faild)
      $("#cnt_total").text(cnt_ok + cnt_nok + cnt_wait + cnt_faild);
    },
    columns: [
      {
        mRender: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        mRender: function (data, type, row, meta) {
          return row.state.name;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_service;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.name +"  "+row.family;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.fathername;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_national;
        }
      },

      {
        mRender: function (data, type, row) {
          return row.type_job;
        }
      },
      {
        mRender: function (data, type, row) {
          var val="";
          if(row.modir_accept == "wait") {
            val = 'در انتظار تایید';
            cnt_wait=cnt_wait+1;
          }
          else if(row.modir_accept == "ok") {
            val = 'تایید شده';
            cnt_ok=cnt_ok+1;
          }
          else if(row.modir_accept == "nok") {
            val = 'عدم تایید';
            cnt_nok=cnt_nok+1;
          }
          else if(row.modir_accept == "faild") {
            val = 'نواقصی پرونده';
            cnt_faild=cnt_faild+1;
          }

          var tag= "<p class='font-13' title='"+row.status+"' style='cursor:help '>"+val+"</p>";
          return tag;

        }
      },
      {
        mRender: function (data, type, row) {
          var facts=`<a href="_manager/markaz/vam/`+row.id+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> جزئیات&nbsp;<i class="fa fa-eye"></i> </a>&nbsp;`;
          return facts;


        }
      },

    ]

  });
}

function loadvams() {
    vam_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
      destroy: true,
        ajax: "markaz/admin/all_vams",
        "initComplete":function( settings, json){
        var cnt_faild=0;
        var cnt_nok=0;
        var cnt_ok=0;
        var cnt_wait=0;
        for (var i = 0; i < (json.data).length; i = i + 1) {
          var modir_accept = json.data[i]['modir_accept']
          if (modir_accept == "wait")
            cnt_wait = cnt_wait + 1;
          else if (modir_accept == "ok")
            cnt_ok = cnt_ok + 1;
          else if (modir_accept == "nok")
            cnt_nok = cnt_nok + 1;
          else if (modir_accept == "faild"){
            cnt_faild = cnt_faild + 1;
          }
        }
        $("#cnt_wait").text(cnt_wait)
        $("#cnt_ok").text(cnt_ok)
        $("#cnt_nok").text(cnt_nok)
        $("#cnt_faild").text(cnt_faild)
        $("#cnt_total").text(cnt_ok + cnt_nok + cnt_wait + cnt_faild);
      },
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_service;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.name +"  "+row.family;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.fathername;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_national;
                }
            },

            {
                mRender: function (data, type, row) {
                    return row.type_job;
                }
            },
            {
                mRender: function (data, type, row) {
                  var val="";
                  if(row.modir_accept == "wait") {
                    val = 'در انتظار تایید';
                    cnt_wait=cnt_wait+1;
                  }
                  else if(row.modir_accept == "ok") {
                    val = 'تایید شده';
                    cnt_ok=cnt_ok+1;
                  }
                  else if(row.modir_accept == "nok") {
                    val = 'عدم تایید';
                    cnt_nok=cnt_nok+1;
                  }
                  else if(row.modir_accept == "faild") {
                    val = 'نواقصی پرونده';
                    cnt_faild=cnt_faild+1;
                  }

                  var tag= "<p class='font-13' title='"+row.status+"' style='cursor:help '>"+val+"</p>";
                  return tag;

                }
            },
            {
                mRender: function (data, type, row) {
                    var facts=`<a href="markaz/admin/vam/`+row.id+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> جزئیات&nbsp;<i class="fa fa-eye"></i> </a>&nbsp;`;
                    return facts;


                }
            },

        ]

    });
}

function loadoks() {
  vam_datatable.DataTable({
    // processing: true,
    // serverSide: true,

    order: [[0, 'desc']],
    paging: true,
    searching: true,
    pageLength: 10,
    ordering: true,
    destroy: true,
    ajax: "markaz/admin/all_vams/ok",
    columns: [
      {
        mRender: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_service;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.name +"  "+row.family;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.fathername;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_national;
        }
      },

      {
        mRender: function (data, type, row) {
          return row.type_job;
        }
      },
      {
        mRender: function (data, type, row) {
          var val="";
          if(row.modir_accept == "wait") {
            val = 'در انتظار تایید';
            cnt_wait=cnt_wait+1;
          }
          else if(row.modir_accept == "ok") {
            val = 'تایید شده';
            cnt_ok=cnt_ok+1;
          }
          else if(row.modir_accept == "nok") {
            val = 'عدم تایید';
            cnt_nok=cnt_nok+1;
          }
          else if(row.modir_accept == "faild") {
            val = 'نواقصی پرونده';
            cnt_faild=cnt_faild+1;
          }

          var tag= "<p class='font-13' title='"+row.status+"' style='cursor:help '>"+val+"</p>";
          return tag;

        }
      },
      {
        mRender: function (data, type, row) {
          var facts=`<a href="markaz/admin/vam/`+row.id+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> جزئیات&nbsp;<i class="fa fa-eye"></i> </a>&nbsp;`;
          return facts;


        }
      },

    ]

  });
}

function loadnoks() {
  vam_datatable.DataTable({
    // processing: true,
    // serverSide: true,

    order: [[0, 'desc']],
    paging: true,
    searching: true,
    pageLength: 10,
    ordering: true,
    destroy: true,
    ajax: "markaz/admin/all_vams/nok",
    columns: [
      {
        mRender: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_service;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.name +"  "+row.family;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.fathername;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_national;
        }
      },

      {
        mRender: function (data, type, row) {
          return row.type_job;
        }
      },
      {
        mRender: function (data, type, row) {
          var val="";
          if(row.modir_accept == "wait") {
            val = 'در انتظار تایید';
            cnt_wait=cnt_wait+1;
          }
          else if(row.modir_accept == "ok") {
            val = 'تایید شده';
            cnt_ok=cnt_ok+1;
          }
          else if(row.modir_accept == "nok") {
            val = 'عدم تایید';
            cnt_nok=cnt_nok+1;
          }
          else if(row.modir_accept == "faild") {
            val = 'نواقصی پرونده';
            cnt_faild=cnt_faild+1;
          }

          var tag= "<p class='font-13' title='"+row.status+"' style='cursor:help '>"+val+"</p>";
          return tag;

        }
      },
      {
        mRender: function (data, type, row) {
          var facts=`<a href="markaz/admin/vam/`+row.id+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> جزئیات&nbsp;<i class="fa fa-eye"></i> </a>&nbsp;`;
          return facts;


        }
      },

    ]

  });
}

function loadfailds() {
  vam_datatable.DataTable({
    // processing: true,
    // serverSide: true,
    destroy: true,
    order: [[0, 'desc']],
    paging: true,
    searching: true,
    pageLength: 10,
    ordering: true,
    ajax: "markaz/admin/all_vams/faild",
    columns: [
      {
        mRender: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_service;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.name +"  "+row.family;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.fathername;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_national;
        }
      },

      {
        mRender: function (data, type, row) {
          return row.type_job;
        }
      },
      {
        mRender: function (data, type, row) {
          var val="";
          if(row.modir_accept == "wait") {
            val = 'در انتظار تایید';
            cnt_wait=cnt_wait+1;
          }
          else if(row.modir_accept == "ok") {
            val = 'تایید شده';
            cnt_ok=cnt_ok+1;
          }
          else if(row.modir_accept == "nok") {
            val = 'عدم تایید';
            cnt_nok=cnt_nok+1;
          }
          else if(row.modir_accept == "faild") {
            val = 'نواقصی پرونده';
            cnt_faild=cnt_faild+1;
          }

          var tag= "<p class='font-13' title='"+row.status+"' style='cursor:help '>"+val+"</p>";
          return tag;

        }
      },
      {
        mRender: function (data, type, row) {
          var facts=`<a href="markaz/admin/vam/`+row.id+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> جزئیات&nbsp;<i class="fa fa-eye"></i> </a>&nbsp;`;
          return facts;


        }
      },

    ]

  });
}

function loadwaites() {
  vam_datatable.DataTable({
    // processing: true,
    // serverSide: true,

    order: [[0, 'desc']],
    paging: true,
    searching: true,
    pageLength: 10,
    ordering: true,
    destroy: true,
    ajax: "markaz/admin/all_vams/wait",
    columns: [
      {
        mRender: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_service;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.name +"  "+row.family;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.fathername;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_national;
        }
      },

      {
        mRender: function (data, type, row) {
          return row.type_job;
        }
      },
      {
        mRender: function (data, type, row) {
          var val="";
          if(row.modir_accept == "wait") {
            val = 'در انتظار تایید';
            cnt_wait=cnt_wait+1;
          }
          else if(row.modir_accept == "ok") {
            val = 'تایید شده';
            cnt_ok=cnt_ok+1;
          }
          else if(row.modir_accept == "nok") {
            val = 'عدم تایید';
            cnt_nok=cnt_nok+1;
          }
          else if(row.modir_accept == "faild") {
            val = 'نواقصی پرونده';
            cnt_faild=cnt_faild+1;
          }

          var tag= "<p class='font-13' title='"+row.status+"' style='cursor:help '>"+val+"</p>";
          return tag;

        }
      },
      {
        mRender: function (data, type, row) {
          var facts=`<a href="markaz/admin/vam/`+row.id+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> جزئیات&nbsp;<i class="fa fa-eye"></i> </a>&nbsp;`;
          return facts;


        }
      },

    ]

  });
}


$("#btn_sign_modir").on("click",function (event) {
    var message_faild=$('#message_faild').val();
    var message_deaccept = $("#message_deaccept").val();
    var report_final = $("#report_final").val();
    var suggest_amount = $("#suggest_amount").val();
    var id_vam = $("#id_vam").val();
    var modir_final = $('input[name = "modir_final"]:checked').val();
    let formDataa = new FormData();
    formDataa.append('message_faild', message_faild);
    formDataa.append('message_deaccept', message_deaccept);
    formDataa.append('report_final', report_final);
    formDataa.append('suggest_amount', suggest_amount);
    formDataa.append('id_vam', id_vam);
    formDataa.append('modir_final', modir_final);

    $.ajax({
        url: "markaz/admin/edit_reports",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت نظریات و تاییدیه");
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

function loaddbs1() {
    db1_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "markaz/admin/all_dbs1",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_markaz;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.name +"  "+row.family;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.fathername;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_national;
                }
            },

            {
                mRender: function (data, type, row) {
                    var facts=`<a href="markaz/dbs1/`+row.id+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i> </a>&nbsp;`;
                    return facts;


                }
            },

        ]

    });

}

$("#btn_sign_modir_db1").on("click",function (event) {
    var report_final = $("#report_final").val();
    var id_database1 = $("#id_database1").val();

    let formDataa = new FormData();
    formDataa.append('report_final', report_final);
    formDataa.append('id_database1', id_database1);

    $.ajax({
        url: "markaz/admin/edit_database1_report",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت نظریات و تاییدیه");
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

function loaddbs2_manager() {
  db2_datatable.DataTable({
    // processing: true,
    // serverSide: true,

    order: [[0, 'desc']],
    paging: true,
    searching: true,
    pageLength: 10,
    ordering: true,
    Destroy: true,
    ajax: "markaz/admin/all_dbs2",
    columns: [
      {
        mRender: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.state.name;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_service;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.name +"  "+row.family;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.fathername;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.id_national;
        }
      },

      {
        mRender: function (data, type, row) {
          var facts=`<a href="_manager/markaz/dbs2/`+row.id+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i>جزئیات &nbsp;</a>&nbsp;`;
          return facts;


        }
      },

    ]

  });

}

function loaddbs2() {
    db2_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "markaz/admin/all_dbs2",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_service;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.name +"  "+row.family;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.fathername;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_national;
                }
            },

            {
                mRender: function (data, type, row) {
                    var facts=`<a href="markaz/admin/dbs2/`+row.id+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i>جزئیات &nbsp; </a>&nbsp;`;
                    return facts;


                }
            },

        ]

    });

}

$("#btn_sign_modir_db2").on("click",function (event) {
    var report_final = $("#report_final").val();
    var id_database2 = $("#id_database2").val();

    let formDataa = new FormData();
    formDataa.append('report_final', report_final);
    formDataa.append('id_database2', id_database2);

    $.ajax({
        url: "markaz/admin/edit_database2_report",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت نظریات و تاییدیه");
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


function loaddbs3() {
    db3_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "markaz/admin/all_dbs3",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_markaz;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.name +"  "+row.family;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.fathername;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_national;
                }
            },

            {
                mRender: function (data, type, row) {
                    var facts=`<a href="markaz/dbs3/`+row.id+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i> </a>&nbsp;`;
                    return facts;


                }
            },

        ]

    });

}

$("#btn_sign_modir_db3").on("click",function (event) {
    var report_final = $("#report_final").val();
    var id_database3 = $("#id_database3").val();

    let formDataa = new FormData();
    formDataa.append('report_final', report_final);
    formDataa.append('id_database3', id_database3);

    $.ajax({
        url: "markaz/admin/edit_database3_report",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت نظریات و تاییدیه");
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


function loaddbs4() {
    db4_datatable.DataTable({
        // processing: true,
        // serverSide: true,

        order: [[0, 'desc']],
        paging: true,
        searching: true,
        pageLength: 10,
        ordering: true,
        Destroy: true,
        ajax: "markaz/admin/all_dbs4",
        columns: [
            {
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_markaz;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.name +"  "+row.family;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.fathername;
                }
            },
            {
                mRender: function (data, type, row) {
                    return row.id_national;
                }
            },

            {
                mRender: function (data, type, row) {
                    var facts=`<a href="markaz/dbs4/`+row.id+`" title="مشاهده جزئیات" class="btn btn-success  btn-sm text-white"> <i class="fa fa-eye"></i> </a>&nbsp;`;
                    return facts;


                }
            },

        ]

    });

}

$("#btn_sign_modir_db4").on("click",function (event) {
    var report_final = $("#report_final").val();
    var id_database4 = $("#id_database4").val();

    let formDataa = new FormData();
    formDataa.append('report_final', report_final);
    formDataa.append('id_database4', id_database4);

    $.ajax({
        url: "markaz/admin/edit_database4_report",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
            ShowWaiting("ثبت نظریات و تاییدیه");
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

$("#btn_update_setting_password").on("click",function (event) {



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


function  loadkanons(){
  kanon_datatable.DataTable({
    // processing: true,
    // serverSide: true,

    // order: [[0, 'desc']],
    paging: true,
    searching: true,
    pageLength: 10,
    ordering: true,
    Destroy: true,
    ajax: "markaz/admin/all_kanons",
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
          return row.geo;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.user_name;
        }
      },
      {
        mRender: function (data, type, row) {
          return row.user_phone;
        }
      },
      {
        mRender: function (data, type, row) {
          var  abstract_comment=makeAbstract(row.memo,30);
          var tag= "<p class='font-13' title='"+row.memo+"' style='cursor: help'>"+abstract_comment+"</p>";
          return tag;
        }
      },
      {
        mRender: function (data, type, row) {
          var facts=`<button type="button" onclick="deleteKanon(`+row.id+`)" title="حذف کانون" class="btn danger text-danger"> <i class="fa fa-trash"></i></button>&nbsp;`;
          return facts;
        }
      }

    ]

  });
}

$("#btn_regist_kanon").on("click",function (event) {
  var kanon_name=$("#kanon_name").val();
  var kanon_geo=$("#kanon_geo").val();
  var kanon_user=$("#kanon_user").val();
  var kanon_user_phone=$("#kanon_user_phone").val();
  var kanon_memo=$("#kanon_memo").val();
  var isvalid=true;
  var message='';

  if(!kanon_name){
    isvalid=false;
    message='نام کانون را وارد نمائید';
  }
  if(!kanon_geo){
    isvalid=false;
    message=' منطقه جغرافیایی کانون را وارد نمائید';
  }
  if(!kanon_user){
    isvalid=false;
    message=' نام راهبر کانون را وارد نمائید';
  }
  if(!kanon_user_phone){
    isvalid=false;
    message=' شماره موبایل راهبر کانون را وارد نمائید';
  }

  if(isvalid==true){
    let formDataa = new FormData();
    formDataa.append('kanon_name', kanon_name);
    formDataa.append('kanon_geo', kanon_geo);
    formDataa.append('kanon_user', kanon_user);
    formDataa.append('kanon_user_phone', kanon_user_phone);
    formDataa.append('kanon_memo', kanon_memo);
    $.ajax({
      url: "markaz/admin/addkanon",
      type: 'POST',
      cache: false,
      data: formDataa,
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      beforeSend: function () {
        ShowWaiting("ثب مشخصات کانون");
      },
      success: function (result) {
        if (!result.error) {
          kanon_datatable.DataTable().ajax.reload();
          $("#kanon_name").val("");
          $("#kanon_geo").val("");
          $("#kanon_user").val("");
          $("#kanon_user_phone").val("");
          $("#kanon_memo").val("");
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

function  deleteKanon(id){
  Swal.fire({
    title: 'حذف کانون',
    text: "آیا برای حذف کانون مطمئن هستید؟",
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
        url: "markaz/admin/delkanon",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
          'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
          ShowWaiting("حذف کانون");
        },
        success: function (result) {
          if (!result.error) {
            kanon_datatable.DataTable().ajax.reload();
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


$("#btn_regist_vam_modir").on("click", function (event) {

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
    formData.append('id_vam', $("#id_vam").val());
    $.ajax({
      url: "markaz/admin/requestVam_editor",
      type: 'POST',
      cache: false,
      data: formData,
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      beforeSend: function () {
        ShowWaiting("ثبت  تغییرات");
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
  } else
    ShowMessage(message, "error");
});

