@extends('layouts.front-master')

@section('Page_Title')
همکاری با کسب بوم - مربی و مدرس دوره های آموزشی
@endsection


@section('Page_CSS')
<link href="/assets_admin/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />

@endsection


@section('Content')


<!-- Work With Us -->
<div class="work-withUs margin-bottom">
  <div class="container">
    <div class="title">
      <h2>فرصت های شغلی مدرس / مربی</h2>
      <p>همکاری با مربیان و مدرسین جهت تولید محتوای آموزشی کسب و کار </p>
    </div>
    <div class="work-form" style="margin-top: 70px !important;">
      <form action="">
        <div class="form-inner">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="inputgroup">
                <p id="message" class="label-success text-white text-center"></p>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="inputgroup">
                <input type="text" maxlength="50" id="fullname" class="myinput" placeholder="نام و نام خانوادگی" autocomplete="off">
                <label>نام و نام خانوادگی</label>
                <div class="icon"><i class="mdi mdi-face-profile"></i></div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="inputgroup">
                <input type="number" id="phonenumber" maxlength="15" class="myinput" placeholder="شماره موبایل" autocomplete="off">
                <label>شماره موبایل</label>
                <div class="icon"><i class="mdi mdi-numeric"></i></div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="inputgroup">
                <input type="number" id="tel" maxlength="15" class="myinput" placeholder="شماره تلفن" autocomplete="off">
                <label>شماره تلفن</label>
                <div class="icon"><i class="mdi mdi-phone"></i></div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="inputgroup">
                <input type="text" maxlength="12" id="birthdate" class="myinput" placeholder="تاریخ تولد" autocomplete="off">
                <label>تاریخ تولد</label>
                <div class="icon"><i class="mdi mdi-pencil"></i></div>
              </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
              <select class="form-select" id="state">
                <option selected disabled>انتخاب استان</option>
                @foreach ($states as $state)
                <option value="{{ $state['id'] }}">{{ $state['name'] }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <select class="form-select" id="city">
                <option selected disabled>انتخاب شهر</option>
              </select>
            </div>
            <div class="col-lg-12">
              <div class="radio-select-gender">
                <div class="radio-title">جنسیت : </div>
                <div class="gender-inner">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gender-select-1" value="male" checked>
                    <label class="form-check-label" for="gender-select-1">مرد</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" id="gender-select-2" type="radio" name="gender" value="female">
                    <label class="form-check-label" for="gender-select-2">زن</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="textarea-group grey">
                <textarea class="textarea" id="fields" cols="30" rows="4" placeholder="حوزه ها و دوره های مهارتی مورد علاقه جهت تدریس " required></textarea>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="inputgroup">
                <input type="file" class="dropify" placeholder=" پیوست رزومه و سرفصل آموزشی" id="attach_rezoume" name="attach_rezoume" data-max-file-size=5M" data-allowed-file-extensions="pdf doc docs xls zip rar jpg jpeg png tif" />

              </div>
            </div>
            <div class="col-lg-12">
              <div class="textarea-group grey">
                <textarea class="textarea" id="memo" cols="30" rows="4" placeholder="توضیحات بیشتر در صورت نیاز...." required></textarea>
              </div>
            </div>
          </div>
          <div class="send-request">
            <button type="button" id="btn_send_invite_teacher" class="btn btn-gradient icon-right"><i class="mdi mdi-send-outline"></i>ارسال درخواست</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="waiting_modal" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-family: VazirMedium">
          <label id="waitingTitle">در حال پردازش</label>
        </h5>
      </div>
      <div class="modal-body" style="text-align: center; float:top">
        <img id="WaitingImage" src="" height="200p" width="200px" />
        <br>
        <label class="label-warning" id="waitingMess">در حال پردازش درخواست می باشد لطفا شکیبا باشید</label>
      </div>
    </div>
  </div>
</div>


@endsection


@section('Page_JS')
<script src="/assets_admin/plugins/fileuploads/js/dropify.js"></script>

<script>
  $("#message").hide();
  $('#state').on('change', function(e) {

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

      beforeSend: function() {

        // ShowWaiting("در حال ذخیره تغییرات");

      },

      success: function(result) {

        if (!result.error) {

          $('#city').html(result.data);

        }

      },

      complete: function() {

        // CloseWaiting();

      },

      error: function() {

      }

    });

  });

  $("#message").hide();

  var drEvent = $('.dropify').dropify({
    messages: {
      'default': 'سرفصل تدریس دوره ها',
      'replace': 'برای جایگزینی یک فایل را در اینجا بکشید و رها کنید یا کلیک کنید',
      'remove': 'حذف',
      'error': 'خطا، چیزی اشتباه اضافه شده است.'
    },
    error: {
      'fileSize': 'اندازه فایل زیاد می باشد (فایل رزومه حداکثر 5 مگابایت و فایل نمونه تدریس  حداکثر 50 مگابایت می باشد).',
      'minWidth': 'The image width is too small min).',
      'maxWidth': 'The image width is too big px max).',
      'minHeight': 'The image height is too small px min).',
      'maxHeight': 'The image height is too big px max).',
      'imageFormat': 'فرمت روزمه نامعتبر می باشد. (rar-zip-pdf-docx-doc)'
    }
  });
  drEvent.on('dropify.errors', function(event, element) {
    ShowMessage('خطا در فایل انتخاب شده !', 'error')
  });
  drEvent.on('dropify.error.imageFormat', function(event, element) {
    ShowMessage('فرمت فایل معتبر نمی باشد. فرمت های قابل قبول تصاویر(docx-doc-pdf-rar-zip) و فرمت های قابل قبول ویدیو(avi-mp4-mp3-3gp-mpg-mpeg)', 'error');
  });
</script>

@endsection
