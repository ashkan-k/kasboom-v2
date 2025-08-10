var course_results = "";
var course_results_id = [];
var course_id = 0;
var lesson_id = 0;
var course_title = "";
var course_price = 0;

$("#btn_filter_ajax_course").click(function () {

  var min_price = $("#slider-margin-value-min").attr("data-value");
  var max_price = $("#slider-margin-value-max").attr("data-value");
  var cats = $('.category:checkbox:checked').map(function () {
    return this.value;
  }).get();

  var level1 = 0;
  var level2 = 0;
  var level3 = 0;
  var type_online = 0;
  var type_offline = 0;
  if ($('#level1').is(":checked"))
    level1 = 1;
  if ($('#level2').is(":checked"))
    level2 = 1;
  if ($('#level3').is(":checked"))
    level3 = 1;
  if ($('#learn_type_online').is(":checked"))
    type_online = 1;
  if ($('#learn_type_offline').is(":checked"))
    type_offline = 1;

  let formDataa = new FormData();
  formDataa.append('min_price', min_price);
  formDataa.append('max_price', max_price);
  formDataa.append('cats', cats);
  formDataa.append('level1', level1);
  formDataa.append('level2', level2);
  formDataa.append('level3', level3);
  formDataa.append('type_online', type_online);
  formDataa.append('type_offline', type_offline);

  $.ajax({
    url: "skill/filter_course_ajax",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("محدودسازی دوره های آموزشی");
    },
    success: function (result) {
      // console.log(result);
      if (!result.error) {
        $("#tab-11").empty();
        // var obj = JSON.parse(json.responseText);
        course_results = result.data;
        var courses = result.data;
        var course = "";
        var coursediv = '';
        $("#result_info").text(" تعداد دوره آموزشی " + courses.length + "  مورد  ");
        course_results_id = [];
        for (var i = 0; i < courses.length; i = i + 1) {
          coursediv = '<div class="col-lg-4 col-md-6 col-sm-6">';
          course = courses[i];
          var discount = course['discount']
          var register_count = course['register_count']
          course_results_id.push(course['id']);
          var course_title = course['title'];
          course_title = course_title.replace(/ /g, '_');
          var course_teacher = course['teacher']['fullname'];
          if (course_teacher != null)
            course_teacher = course_teacher.replace(/ /g, '_');
          coursediv += `<div class="card-course" title="` + course_title + `">`;
          coursediv += `<a href="skill/course/` + course['id'] + `/` + course_title + `"></a>`;
          coursediv += `<div class="card-h"><div class="img-inner">`;
          coursediv += `<img src="_upload_/_courses_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `">`;
          coursediv += `</div>`;
          if (course['have_certificate'] == 1)
            coursediv += `<div class="certificate"><img src="v2_assets/images/icons/cer.svg" alt="گواهی نامه پایان دوره"></div>`;
          coursediv += `<div class="rating"><i class="mdi mdi-star"></i>` + course['score'] + `</div></div>`;
          coursediv += `<div class="card-b"><h2>` + course_title + `</h2><div class="info">`;
          coursediv += `<h6><i class="mdi mdi-account-circle-outline"></i>` + course_teacher + `</h6>`;
          coursediv += `<h6><i class="mdi mdi-clock-outline"></i>` + course['hour'] + ` ساعت و ` + course['minutes'] + ` دقیقه </h6>`;
          coursediv += `<div class="price-content off-code"><div class="price">`;
          if (course['old_price'] > 0)
            coursediv += `<div class="real">` + course['old_price'] + `</div>`;
          if (course['price'] > 0)
            coursediv += `<div class="off">` + course['price'] + `</div>`;
          else
            coursediv += `<div class="off">رایگان</div>`;
          coursediv += `</div><div class="text">`;
          if (discount > 0)
            coursediv += `<div class="precentage">` + discount + `%</div>`;
          coursediv += `<span class="toman">تومان</span></div></div></div></div>`;
          // coursediv += `<div class="card-f"><div class="number"><span>ثبت نام کننده ها</span>`;
          // coursediv += `<span>` + register_count + ` نفر</span>`;
          // coursediv += `</div></div>`;
          coursediv += `</a></div></div>`;

          $("#tab-11").append(coursediv);
        }

        $("#sortselect").prop("disabled", false);
        $("#div_paginate").hide();

      } else
        ShowMessage(result.message, result.type);
    },
    complete: function () {
      CloseWaiting();
    },
    error: function () {
      ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
    }
  });

  // var cats=document.getElementsByClassName('category');
});

$("#btn_search_ajax_course").click(function () {
  var course_name = $("#course_name").val();

  let formDataa = new FormData();
  formDataa.append('course_name', course_name);
  if (course_name.length < 2)
    ShowMessage('مقار مناسبی جهت جستجو وارد نمائید', 'error');
  else {
    $.ajax({
      url: "skill/search_course_ajax",
      type: 'POST',
      cache: false,
      data: formDataa,
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      beforeSend: function () {
        ShowWaiting("جستجوی دوره آموزشی");
      },
      success: function (result) {
        // console.log(result);
        if (!result.error) {
          $("#tab-11").empty();
          // var obj = JSON.parse(json.responseText);
          course_results = result.data;
          var courses = result.data;
          var course = "";
          var coursediv = '';
          $("#result_info").text(" تعداد دوره آموزشی " + courses.length + "  مورد  ");
          course_results_id = [];
          for (var i = 0; i < courses.length; i = i + 1) {
            coursediv = '<div class="col-lg-4 col-md-6 col-sm-6">';
            course = courses[i];
            var discount = course['discount']
            var register_count = course['register_count']
            course_results_id.push(course['id']);
            var course_title = course['title'];
            course_title = course_title.replace(/ /g, '_');
            var course_teacher = course['teacher']['fullname'];
            if (course_teacher != null)
              course_teacher = course_teacher.replace(/ /g, '_');
            coursediv += `<div class="card-course" title="` + course_title + `">`;
            coursediv += `<a href="skill/course/` + course['id'] + `/` + course_title + `"></a>`;
            coursediv += `<div class="card-h"><div class="img-inner">`;
            coursediv += `<img src="_upload_/_courses_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `">`;
            coursediv += `</div>`;
            if (course['have_certificate'] == 1)
              coursediv += `<div class="certificate"><img src="v2_assets/images/icons/cer.svg" alt="گواهی نامه پایان دوره"></div>`;
            coursediv += `<div class="rating"><i class="mdi mdi-star"></i>` + course['score'] + `</div></div>`;
            coursediv += `<div class="card-b"><h2>` + course_title + `</h2><div class="info">`;
            coursediv += `<h6><i class="mdi mdi-account-circle-outline"></i>` + course_teacher + `</h6>`;
            coursediv += `<h6><i class="mdi mdi-clock-outline"></i>` + course['hour'] + ` ساعت و ` + course['minutes'] + ` دقیقه </h6>`;
            coursediv += `<div class="price-content off-code"><div class="price">`;
            if (course['old_price'] > 0)
              coursediv += `<div class="real">` + course['old_price'] + `</div>`;
            if (course['price'] > 0)
              coursediv += `<div class="off">` + course['price'] + `</div>`;
            else
              coursediv += `<div class="off">رایگان</div>`;
            coursediv += `</div><div class="text">`;
            if (discount > 0)
              coursediv += `<div class="precentage">` + discount + `%</div>`;

            coursediv += `<span class="toman">تومان</span></div></div></div></div>`;
            // coursediv += `<div class="card-f"><div class="number"><span>ثبت نام کننده ها</span>`;
            // coursediv += `<span>` + register_count + ` نفر</span>`;
            // coursediv += `</div></div>`;
            coursediv += `</a></div></div>`;


            $("#tab-11").append(coursediv);
          }
          $("#sortselect").prop("disabled", false);
          $("#div_paginate").hide();
        } else
          ShowMessage(result.message, result.type);
      },
      complete: function () {
        CloseWaiting();
      },
      error: function () {
        ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
      }
    });
  }
});

$('#sortselect').on('change', function () {
  var course = "";
  var coursediv = "";

  if (this.value == "new") {
    $("#tab-11").empty();
    course_results_id.sort(function (a, b) {
      return a + 2 * b;
    });
    for (var i = 0; i < course_results.length; i = i + 1) {
      course = course_results[i];
      coursediv = '<div class="col-lg-4 col-md-6 col-sm-6">';
      var discount = course['discount']
      var register_count = course['register_count']
      course_results_id.push(course['id']);
      var course_title = course['title'];
      course_title = course_title.replace(/ /g, '_');
      var course_teacher = course['teacher']['fullname'];
      if (course_teacher != null)
        course_teacher = course_teacher.replace(/ /g, '_');
      coursediv += `<div class="card-course" title="` + course_title + `">`;
      coursediv += `<a href="skill/course/` + course['id'] + `/` + course_title + `"></a>`;
      coursediv += `<div class="card-h"><div class="img-inner">`;
      coursediv += `<img src="_upload_/_courses_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `">`;
      coursediv += `</div>`;
      if (course['have_certificate'] == 1)
        coursediv += `<div class="certificate"><img src="v2_assets/images/icons/cer.svg" alt="گواهی نامه پایان دوره"></div>`;
      coursediv += `<div class="rating"><i class="mdi mdi-star"></i>` + course['score'] + `</div></div>`;
      coursediv += `<div class="card-b"><h2>` + course_title + `</h2><div class="info">`;
      coursediv += `<h6><i class="mdi mdi-account-circle-outline"></i>` + course_teacher + `</h6>`;
      coursediv += `<h6><i class="mdi mdi-clock-outline"></i>` + course['hour'] + ` ساعت و ` + course['minutes'] + ` دقیقه </h6>`;
      coursediv += `<div class="price-content off-code"><div class="price">`;
      if (course['old_price'] > 0)
        coursediv += `<div class="real">` + course['old_price'] + `</div>`;
      if (course['price'] > 0)
        coursediv += `<div class="off">` + course['price'] + `</div>`;
      else
        coursediv += `<div class="off">رایگان</div>`;
      coursediv += `</div><div class="text">`;
      if (discount > 0)
        coursediv += `<div class="precentage">` + discount + `%</div>`;
      coursediv += `<span class="toman">تومان</span></div></div></div></div><div class="card-f"><div class="number"><span>ثبت نام کننده ها</span>`;
      coursediv += `<span>` + register_count + ` نفر</span>`;
      coursediv += `</div></div></a></div></div>`;
      $("#tab-11").append(coursediv);
    }

  }
  else if (this.value == "old") {
    $("#tab-11").empty();
    course_results_id.sort();
    for (var i = 0; i < course_results.length; i = i + 1) {
      course = course_results[i];
      coursediv = '<div class="col-lg-4 col-md-6 col-sm-6">';
      var discount = course['discount']
      var register_count = course['register_count']
      course_results_id.push(course['id']);
      var course_title = course['title'];
      course_title = course_title.replace(/ /g, '_');
      var course_teacher = course['teacher']['fullname'];
      if (course_teacher != null)
        course_teacher = course_teacher.replace(/ /g, '_');
      coursediv += `<div class="card-course" title="` + course_title + `">`;
      coursediv += `<a href="skill/course/` + course['id'] + `/` + course_title + `"></a>`;
      coursediv += `<div class="card-h"><div class="img-inner">`;
      coursediv += `<img src="_upload_/_courses_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `">`;
      coursediv += `</div>`;
      if (course['have_certificate'] == 1)
        coursediv += `<div class="certificate"><img src="v2_assets/images/icons/cer.svg" alt="گواهی نامه پایان دوره"></div>`;
      coursediv += `<div class="rating"><i class="mdi mdi-star"></i>` + course['score'] + `</div></div>`;
      coursediv += `<div class="card-b"><h2>` + course_title + `</h2><div class="info">`;
      coursediv += `<h6><i class="mdi mdi-account-circle-outline"></i>` + course_teacher + `</h6>`;
      coursediv += `<h6><i class="mdi mdi-clock-outline"></i>` + course['hour'] + ` ساعت و ` + course['minutes'] + ` دقیقه </h6>`;
      coursediv += `<div class="price-content off-code"><div class="price">`;
      if (course['old_price'] > 0)
        coursediv += `<div class="real">` + course['old_price'] + `</div>`;
      if (course['price'] > 0)
        coursediv += `<div class="off">` + course['price'] + `</div>`;
      else
        coursediv += `<div class="off">رایگان</div>`;
      coursediv += `</div><div class="text">`;
      if (discount > 0)
        coursediv += `<div class="precentage">` + discount + `%</div>`;
      coursediv += `<span class="toman">تومان</span></div></div></div></div><div class="card-f"><div class="number"><span>ثبت نام کننده ها</span>`;
      coursediv += `<span>` + register_count + ` نفر</span>`;
      coursediv += `</div></div></a></div></div>`;
      $("#tab-11").append(coursediv);
    }

  }
  else if (this.value == "free") {
    $("#tab-11").empty();

    for (var i = 0; i < course_results.length; i = i + 1) {
      course = course_results[i];
      if (course['price'] <= 0) {
        coursediv = '<div class="col-lg-4 col-md-6 col-sm-6">';
        var discount = course['discount']
        var register_count = course['register_count']
        course_results_id.push(course['id']);
        var course_title = course['title'];
        course_title = course_title.replace(/ /g, '_');
        var course_teacher = course['teacher']['fullname'];
        if (course_teacher != null)
          course_teacher = course_teacher.replace(/ /g, '_');
        coursediv += `<div class="card-course" title="` + course_title + `">`;
        coursediv += `<a href="skill/course/` + course['id'] + `/` + course_title + `"></a>`;
        coursediv += `<div class="card-h"><div class="img-inner">`;
        coursediv += `<img src="_upload_/_courses_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `">`;
        coursediv += `</div>`;
        if (course['have_certificate'] == 1)
          coursediv += `<div class="certificate"><img src="v2_assets/images/icons/cer.svg" alt="گواهی نامه پایان دوره"></div>`;
        coursediv += `<div class="rating"><i class="mdi mdi-star"></i>` + course['score'] + `</div></div>`;
        coursediv += `<div class="card-b"><h2>` + course_title + `</h2><div class="info">`;
        coursediv += `<h6><i class="mdi mdi-account-circle-outline"></i>` + course_teacher + `</h6>`;
        coursediv += `<h6><i class="mdi mdi-clock-outline"></i>` + course['hour'] + ` ساعت و ` + course['minutes'] + ` دقیقه </h6>`;
        coursediv += `<div class="price-content off-code"><div class="price">`;
        if (course['old_price'] > 0)
          coursediv += `<div class="real">` + course['old_price'] + `</div>`;
        if (course['price'] > 0)
          coursediv += `<div class="off">` + course['price'] + `</div>`;
        else
          coursediv += `<div class="off">رایگان</div>`;
        coursediv += `</div><div class="text">`;
        if (discount > 0)
          coursediv += `<div class="precentage">` + discount + `%</div>`;
        coursediv += `<span class="toman">تومان</span></div></div></div></div><div class="card-f"><div class="number"><span>ثبت نام کننده ها</span>`;
        coursediv += `<span>` + register_count + ` نفر</span>`;
        coursediv += `</div></div></a></div></div>`;
        $("#tab-11").append(coursediv);
      }
    }

  }
  else if (this.value == "dontfree") {
    $("#tab-11").empty();
    for (var i = 0; i < course_results.length; i = i + 1) {
      course = course_results[i];
      if (course['price'] > 0) {
        coursediv = '<div class="col-lg-4 col-md-6 col-sm-6">';
        var discount = course['discount']
        var register_count = course['register_count']
        course_results_id.push(course['id']);
        var course_title = course['title'];
        course_title = course_title.replace(/ /g, '_');
        var course_teacher = course['teacher']['fullname'];
        if (course_teacher != null)
          course_teacher = course_teacher.replace(/ /g, '_');
        coursediv += `<div class="card-course" title="` + course_title + `">`;
        coursediv += `<a href="skill/course/` + course['id'] + `/` + course_title + `"></a>`;
        coursediv += `<div class="card-h"><div class="img-inner">`;
        coursediv += `<img src="_upload_/_courses_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `">`;
        coursediv += `</div>`;
        if (course['have_certificate'] == 1)
          coursediv += `<div class="certificate"><img src="v2_assets/images/icons/cer.svg" alt="گواهی نامه پایان دوره"></div>`;
        coursediv += `<div class="rating"><i class="mdi mdi-star"></i>` + course['score'] + `</div></div>`;
        coursediv += `<div class="card-b"><h2>` + course_title + `</h2><div class="info">`;
        coursediv += `<h6><i class="mdi mdi-account-circle-outline"></i>` + course_teacher + `</h6>`;
        coursediv += `<h6><i class="mdi mdi-clock-outline"></i>` + course['hour'] + ` ساعت و ` + course['minutes'] + ` دقیقه </h6>`;
        coursediv += `<div class="price-content off-code"><div class="price">`;
        if (course['old_price'] > 0)
          coursediv += `<div class="real">` + course['old_price'] + `</div>`;
        if (course['price'] > 0)
          coursediv += `<div class="off">` + course['price'] + `</div>`;
        else
          coursediv += `<div class="off">رایگان</div>`;
        coursediv += `</div><div class="text">`;
        if (discount > 0)
          coursediv += `<div class="precentage">` + discount + `%</div>`;
        coursediv += `<span class="toman">تومان</span></div></div></div></div><div class="card-f"><div class="number"><span>ثبت نام کننده ها</span>`;
        coursediv += `<span>` + register_count + ` نفر</span>`;
        coursediv += `</div></div></a></div></div>`;
        $("#tab-11").append(coursediv);
      }
    }

  }
});

$("#btn_filter_ajax_webinar").click(function () {

  var min_price = $("#mySlider").slider("values")[0];
  var max_price = $("#mySlider").slider("values")[1];
  var cats = $('.category:checkbox:checked').map(function () {
    return this.value;
  }).get();

  let formDataa = new FormData();
  formDataa.append('min_price', min_price);
  formDataa.append('max_price', max_price);
  formDataa.append('cats', cats);

  $.ajax({
    url: "skill/webinar/filter",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("محدودسازی دوره های آموزشی");
    },
    success: function (result) {
      // console.log(result);
      if (!result.error) {
        $("#tab-11").empty();
        // var obj = JSON.parse(json.responseText);
        course_results = result.data;
        var courses = result.data;
        var course = "";
        var coursediv = '';
        $("#result_info").text(" تعداد وبینار آموزشی " + courses.length + "  مورد  ");
        course_results_id = [];
        for (var i = 0; i < courses.length; i = i + 1) {
          coursediv = '<div class="card overflow-hidden" style="border-radius: 15px">';
          course = courses[i];
          course_results_id.push(course['id']);
          var course_title = course['title'];
          course_title = course_title.replace(/ /g, '_');
          coursediv += `<div class="d-md-flex"><div class="item-card9-imgs myitem-card">`;
          coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `"></a>`;
          coursediv += `<img src="_upload_/_webinars_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `" class="cover-image" style="width: 100%;height: 100%;">`;
          coursediv += `</div><div class="card-body " style="padding-top: 0;padding-bottom: 0">`;
          coursediv += `<div class="item-card9"><div class="row"><div class="col-lg-9 col-sm-9 col-xs-9">`;
          coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `" class="text-dark"><h3 class="font-weight mt-1">` + course['title'] + `</h3></a>`;
          coursediv += `<div class="mt-2 mb-2" style="font-family: VazirLight">`;
          coursediv += `<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>` + course['category']['title'] + `</span></a>`;
          coursediv += `<a href="teacher/profile/` + course['id_teacher'] + `/` + course['teacher_name'] + ` title="مشاهده پروفایل مدرس" class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-user text-muted ml-1"></i>` + course['teacher_name'] + `</span></a>`;
          coursediv += `<br class="mobile-hidden">`;
          coursediv += `<a  class="ml-4"><span class="text-muted fs-13 IRANSansWeb_Light"><i class="fa fa-calendar text-muted ml-1"></i> ` + course['webinar_start_time_minutes'] + `:` + course['webinar_start_time_hour'] + ` - ` + course['webinar_date'] + `</span></a>`;
          coursediv += `<p class="mb-0 fs-14">` + course['abstractMemo'] + `</p>`;
          coursediv += `</div></div>`;
          coursediv += `<div class="col-lg-3 col-sm-3 col-xs-3 col-md-3 float-left text-left">`;
          coursediv += `<br>`;
          coursediv += `<span class="old_price text-muted fs-16 IRANSansWeb_Light">` + number_format(course['old_price']) + ` `;
          coursediv += `<small class="fs-10"> تومان</small>`;
          coursediv += `</span></span>&nbsp;&nbsp;`;
          coursediv += `<span class="bg-red text-white fs-13 IRANSansWeb_Light p-1" style="border-radius: 10px">% ` + course['discount'] + ` </span>`;
          coursediv += `<br>`;
          coursediv += `<a class="ml-4 text-danger">`;
          coursediv += `<span class="fs-20 text-danger IRANSansWeb_Bold">`;
          if (course['price'] > 0)
            coursediv += number_format(course['price']) + `<small class="fs-10"> تومان</small>`;
          else
            coursediv += `رایگان`;
          coursediv += `</span></a>`;
          coursediv += `</div></div><br>`;
          coursediv += `<div class="text-left">`;
          coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
          if (course['view_count'] != null)
            coursediv += course['view_count'] + `&nbsp;<i class="fa fa-eye"></i></span>`;
          else
            coursediv += `0 <i class="fa fa-eye"></i></span>`;
          coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
          if (course['register_count'] != null)
            coursediv += course['register_count'] + `&nbsp;<i class="fa fa-users"></i></span>`;
          else
            coursediv += `0 <i class="fa fa-users"></i></span>`;
          coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
          if (course['like_count'] != null)
            coursediv += course['like_count'] + `&nbsp;<i class="fa fa-heart"></i></span`;
          else
            coursediv += `0 <i class="fa fa-heart"></i></span>`;
          coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
          if (course['score'] != null)
            coursediv += course['score'] + `&nbsp;<i class="fa fa-star"></i></span>`;
          else
            coursediv += `0 <i class="fa fa-star"></i></span>`;
          coursediv += `</div></div></div></div></div>`;
          $("#tab-11").append(coursediv);
        }
        $("#sortselect_webinar").prop("disabled", false);
        $("#div_paginate").hide();
      } else
        ShowMessage(result.message, result.type);
    },
    complete: function () {
      CloseWaiting();
    },
    error: function () {
      ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
    }
  });

  // var cats=document.getElementsByClassName('category');
});

$("#btn_search_ajax_webinar").click(function () {

  var course_name = $("#course_name").val();

  let formDataa = new FormData();
  formDataa.append('webinar_name', course_name);
  if (course_name.length < 2)
    ShowMessage('مقار مناسبی جهت جستجو وارد نمائید', 'error');
  else {
    $.ajax({
      url: "skill/webinar/search",
      type: 'POST',
      cache: false,
      data: formDataa,
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      beforeSend: function () {
        ShowWaiting("جستجوی دوره آموزشی");
      },
      success: function (result) {
        // console.log(result);
        if (!result.error) {
          $("#tab-11").empty();
          // var obj = JSON.parse(json.responseText);
          course_results = result.data;
          var courses = result.data;
          var course = "";
          var coursediv = '';
          $("#result_info").text(" تعداد وبینار آموزشی " + courses.length + "  مورد  ");
          course_results_id = [];
          for (var i = 0; i < courses.length; i = i + 1) {
            coursediv = '<div class="card overflow-hidden" style="border-radius: 15px">';
            course = courses[i];
            course_results_id.push(course['id']);
            var course_title = course['title'];
            course_title = course_title.replace(/ /g, '_');
            coursediv += `<div class="d-md-flex"><div class="item-card9-imgs myitem-card">`;
            coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `"></a>`;
            coursediv += `<img src="_upload_/_webinars_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `" class="cover-image" style="width: 100%;height: 100%;">`;
            coursediv += `</div><div class="card-body " style="padding-top: 0;padding-bottom: 0">`;
            coursediv += `<div class="item-card9"><div class="row"><div class="col-lg-9 col-sm-9 col-xs-9">`;
            coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `" class="text-dark"><h3 class="font-weight mt-1">` + course['title'] + `</h3></a>`;
            coursediv += `<div class="mt-2 mb-2" style="font-family: VazirLight">`;
            coursediv += `<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>` + course['category']['title'] + `</span></a>`;
            coursediv += `<a href="teacher/profile/` + course['id_teacher'] + `/` + course['teacher_name'] + ` title="مشاهده پروفایل مدرس" class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-user text-muted ml-1"></i>` + course['teacher_name'] + `</span></a>`;
            coursediv += `<br class="mobile-hidden">`;
            coursediv += `<a  class="ml-4"><span class="text-muted fs-13 IRANSansWeb_Light"><i class="fa fa-calendar text-muted ml-1"></i> ` + course['webinar_start_time_minutes'] + `:` + course['webinar_start_time_hour'] + ` - ` + course['webinar_date'] + `</span></a>`;
            coursediv += `<p class="mb-0 fs-14">` + course['abstractMemo'] + `</p>`;
            coursediv += `</div></div>`;
            coursediv += `<div class="col-lg-3 col-sm-3 col-xs-3 col-md-3 float-left text-left">`;
            coursediv += `<br>`;
            coursediv += `<span class="old_price text-muted fs-16 IRANSansWeb_Light">` + number_format(course['old_price']) + ` `;
            coursediv += `<small class="fs-10"> تومان</small>`;
            coursediv += `</span></span>&nbsp;&nbsp;`;
            coursediv += `<span class="bg-red text-white fs-13 IRANSansWeb_Light p-1" style="border-radius: 10px">% ` + course['discount'] + ` </span>`;
            coursediv += `<br>`;
            coursediv += `<a class="ml-4 text-danger">`;
            coursediv += `<span class="fs-20 text-danger IRANSansWeb_Bold">`;
            if (course['price'] > 0)
              coursediv += number_format(course['price']) + `<small class="fs-10"> تومان</small>`;
            else
              coursediv += `رایگان`;
            coursediv += `</span></a>`;
            coursediv += `</div></div><br>`;
            coursediv += `<div class="text-left">`;
            coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
            if (course['view_count'] != null)
              coursediv += course['view_count'] + `&nbsp;<i class="fa fa-eye"></i></span>`;
            else
              coursediv += `0 <i class="fa fa-eye"></i></span>`;
            coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
            if (course['register_count'] != null)
              coursediv += course['register_count'] + `&nbsp;<i class="fa fa-users"></i></span>`;
            else
              coursediv += `0 <i class="fa fa-users"></i></span>`;
            coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
            if (course['like_count'] != null)
              coursediv += course['like_count'] + `&nbsp;<i class="fa fa-heart"></i></span`;
            else
              coursediv += `0 <i class="fa fa-heart"></i></span>`;
            coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
            if (course['score'] != null)
              coursediv += course['score'] + `&nbsp;<i class="fa fa-star"></i></span>`;
            else
              coursediv += `0 <i class="fa fa-star"></i></span>`;
            coursediv += `</div></div></div></div></div>`;
            $("#tab-11").append(coursediv);
          }
          $("#sortselect_webinar").prop("disabled", false);
          $("#div_paginate").hide();


        } else
          ShowMessage(result.message, result.type);
      },
      complete: function () {
        CloseWaiting();
      },
      error: function () {
        ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
      }
    });
  }
});

$('#sortselect_webinar').on('change', function () {
  var course = "";
  var coursediv = "";

  if (this.value == "new") {
    $("#tab-11").empty();
    course_results_id.sort(function (a, b) {
      return a + 2 * b;
    });
    for (var i = 0; i < course_results_id.length; i = i + 1) {
      var id = course_results_id[i];
      var course = course_results.find(course => course.id === id);
      coursediv = '<div class="card overflow-hidden" style="border-radius: 15px">';
      course = courses[i];
      course_results_id.push(course['id']);
      var course_title = course['title'];
      course_title = course_title.replace(/ /g, '_');
      coursediv += `<div class="d-md-flex"><div class="item-card9-imgs myitem-card">`;
      coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `"></a>`;
      coursediv += `<img src="_upload_/_webinars_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `" class="cover-image" style="width: 100%;height: 100%;">`;
      coursediv += `</div><div class="card-body " style="padding-top: 0;padding-bottom: 0">`;
      coursediv += `<div class="item-card9"><div class="row"><div class="col-lg-9 col-sm-9 col-xs-9">`;
      coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `" class="text-dark"><h3 class="font-weight mt-1">` + course['title'] + `</h3></a>`;
      coursediv += `<div class="mt-2 mb-2" style="font-family: VazirLight">`;
      coursediv += `<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>` + course['category']['title'] + `</span></a>`;
      coursediv += `<a href="teacher/profile/` + course['id_teacher'] + `/` + course['teacher_name'] + ` title="مشاهده پروفایل مدرس" class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-user text-muted ml-1"></i>` + course['teacher_name'] + `</span></a>`;
      coursediv += `<br class="mobile-hidden">`;
      coursediv += `<a  class="ml-4"><span class="text-muted fs-13 IRANSansWeb_Light"><i class="fa fa-calendar text-muted ml-1"></i> ` + course['webinar_start_time_minutes'] + `:` + course['webinar_start_time_hour'] + ` - ` + course['webinar_date'] + `</span></a>`;
      coursediv += `<p class="mb-0 fs-14">` + course['abstractMemo'] + `</p>`;
      coursediv += `</div></div>`;
      coursediv += `<div class="col-lg-3 col-sm-3 col-xs-3 col-md-3 float-left text-left">`;
      coursediv += `<br>`;
      coursediv += `<span class="old_price text-muted fs-16 IRANSansWeb_Light">` + number_format(course['old_price']) + ` `;
      coursediv += `<small class="fs-10"> تومان</small>`;
      coursediv += `</span></span>&nbsp;&nbsp;`;
      coursediv += `<span class="bg-red text-white fs-13 IRANSansWeb_Light p-1" style="border-radius: 10px">% ` + course['discount'] + ` </span>`;
      coursediv += `<br>`;
      coursediv += `<a class="ml-4 text-danger">`;
      coursediv += `<span class="fs-20 text-danger IRANSansWeb_Bold">`;
      if (course['price'] > 0)
        coursediv += number_format(course['price']) + `<small class="fs-10"> تومان</small>`;
      else
        coursediv += `رایگان`;
      coursediv += `</span></a>`;
      coursediv += `</div></div><br>`;
      coursediv += `<div class="text-left">`;
      coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
      if (course['view_count'] != null)
        coursediv += course['view_count'] + `&nbsp;<i class="fa fa-eye"></i></span>`;
      else
        coursediv += `0 <i class="fa fa-eye"></i></span>`;
      coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
      if (course['register_count'] != null)
        coursediv += course['register_count'] + `&nbsp;<i class="fa fa-users"></i></span>`;
      else
        coursediv += `0 <i class="fa fa-users"></i></span>`;
      coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
      if (course['like_count'] != null)
        coursediv += course['like_count'] + `&nbsp;<i class="fa fa-heart"></i></span`;
      else
        coursediv += `0 <i class="fa fa-heart"></i></span>`;
      coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
      if (course['score'] != null)
        coursediv += course['score'] + `&nbsp;<i class="fa fa-star"></i></span>`;
      else
        coursediv += `0 <i class="fa fa-star"></i></span>`;
      coursediv += `</div></div></div></div></div>`;
      $("#tab-11").append(coursediv);

    }

  } else if (this.value == "old") {
    $("#tab-11").empty();
    course_results_id.sort();
    for (var i = 0; i < course_results_id.length; i = i + 1) {
      var id = course_results_id[i];
      var course = course_results.find(course => course.id === id);
      coursediv = '<div class="card overflow-hidden" style="border-radius: 15px">';
      var course_title = course['title'];
      course_title = course_title.replace(/ /g, '_');
      coursediv += `<div class="d-md-flex"><div class="item-card9-imgs myitem-card">`;
      coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `"></a>`;
      coursediv += `<img src="_upload_/_webinars_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `" class="cover-image" style="width: 100%;height: 100%;">`;
      coursediv += `</div><div class="card-body " style="padding-top: 0;padding-bottom: 0">`;
      coursediv += `<div class="item-card9"><div class="row"><div class="col-lg-9 col-sm-9 col-xs-9">`;
      coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `" class="text-dark"><h3 class="font-weight mt-1">` + course['title'] + `</h3></a>`;
      coursediv += `<div class="mt-2 mb-2" style="font-family: VazirLight">`;
      coursediv += `<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>` + course['category']['title'] + `</span></a>`;
      coursediv += `<a href="teacher/profile/` + course['id_teacher'] + `/` + course['teacher_name'] + ` title="مشاهده پروفایل مدرس" class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-user text-muted ml-1"></i>` + course['teacher_name'] + `</span></a>`;
      coursediv += `<br class="mobile-hidden">`;
      coursediv += `<a  class="ml-4"><span class="text-muted fs-13 IRANSansWeb_Light"><i class="fa fa-calendar text-muted ml-1"></i> ` + course['webinar_start_time_minutes'] + `:` + course['webinar_start_time_hour'] + ` - ` + course['webinar_date'] + `</span></a>`;
      coursediv += `<p class="mb-0 fs-14">` + course['abstractMemo'] + `</p>`;
      coursediv += `</div></div>`;
      coursediv += `<div class="col-lg-3 col-sm-3 col-xs-3 col-md-3 float-left text-left">`;
      coursediv += `<br>`;
      coursediv += `<span class="old_price text-muted fs-16 IRANSansWeb_Light">` + number_format(course['old_price']) + ` `;
      coursediv += `<small class="fs-10"> تومان</small>`;
      coursediv += `</span></span>&nbsp;&nbsp;`;
      coursediv += `<span class="bg-red text-white fs-13 IRANSansWeb_Light p-1" style="border-radius: 10px">% ` + course['discount'] + ` </span>`;
      coursediv += `<br>`;
      coursediv += `<a class="ml-4 text-danger">`;
      coursediv += `<span class="fs-20 text-danger IRANSansWeb_Bold">`;
      if (course['price'] > 0)
        coursediv += number_format(course['price']) + `<small class="fs-10"> تومان</small>`;
      else
        coursediv += `رایگان`;
      coursediv += `</span></a>`;
      coursediv += `</div></div><br>`;
      coursediv += `<div class="text-left">`;
      coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
      if (course['view_count'] != null)
        coursediv += course['view_count'] + `&nbsp;<i class="fa fa-eye"></i></span>`;
      else
        coursediv += `0 <i class="fa fa-eye"></i></span>`;
      coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
      if (course['register_count'] != null)
        coursediv += course['register_count'] + `&nbsp;<i class="fa fa-users"></i></span>`;
      else
        coursediv += `0 <i class="fa fa-users"></i></span>`;
      coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
      if (course['like_count'] != null)
        coursediv += course['like_count'] + `&nbsp;<i class="fa fa-heart"></i></span`;
      else
        coursediv += `0 <i class="fa fa-heart"></i></span>`;
      coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
      if (course['score'] != null)
        coursediv += course['score'] + `&nbsp;<i class="fa fa-star"></i></span>`;
      else
        coursediv += `0 <i class="fa fa-star"></i></span>`;
      coursediv += `</div></div></div></div></div>`;
      $("#tab-11").append(coursediv);
    }

  } else if (this.value == "free") {
    $("#tab-11").empty();

    for (var i = 0; i < course_results.length; i = i + 1) {
      course = course_results[i];
      if (course['price'] <= 0) {
        coursediv = '<div class="card overflow-hidden" style="border-radius: 15px">';
        var course_title = course['title'];
        course_title = course_title.replace(/ /g, '_');
        coursediv += `<div class="d-md-flex"><div class="item-card9-imgs myitem-card">`;
        coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `"></a>`;
        coursediv += `<img src="_upload_/_webinars_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `" class="cover-image" style="width: 100%;height: 100%;">`;
        coursediv += `</div><div class="card-body " style="padding-top: 0;padding-bottom: 0">`;
        coursediv += `<div class="item-card9"><div class="row"><div class="col-lg-9 col-sm-9 col-xs-9">`;
        coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `" class="text-dark"><h3 class="font-weight mt-1">` + course['title'] + `</h3></a>`;
        coursediv += `<div class="mt-2 mb-2" style="font-family: VazirLight">`;
        coursediv += `<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>` + course['category']['title'] + `</span></a>`;
        coursediv += `<a href="teacher/profile/` + course['id_teacher'] + `/` + course['teacher_name'] + ` title="مشاهده پروفایل مدرس" class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-user text-muted ml-1"></i>` + course['teacher_name'] + `</span></a>`;
        coursediv += `<br class="mobile-hidden">`;
        coursediv += `<a  class="ml-4"><span class="text-muted fs-13 IRANSansWeb_Light"><i class="fa fa-calendar text-muted ml-1"></i> ` + course['webinar_start_time_minutes'] + `:` + course['webinar_start_time_hour'] + ` - ` + course['webinar_date'] + `</span></a>`;
        coursediv += `<p class="mb-0 fs-14">` + course['abstractMemo'] + `</p>`;
        coursediv += `</div></div>`;
        coursediv += `<div class="col-lg-3 col-sm-3 col-xs-3 col-md-3 float-left text-left">`;
        coursediv += `<br>`;
        coursediv += `<span class="old_price text-muted fs-16 IRANSansWeb_Light">` + number_format(course['old_price']) + ` `;
        coursediv += `<small class="fs-10"> تومان</small>`;
        coursediv += `</span></span>&nbsp;&nbsp;`;
        coursediv += `<span class="bg-red text-white fs-13 IRANSansWeb_Light p-1" style="border-radius: 10px">% ` + course['discount'] + ` </span>`;
        coursediv += `<br>`;
        coursediv += `<a class="ml-4 text-danger">`;
        coursediv += `<span class="fs-20 text-danger IRANSansWeb_Bold">`;
        if (course['price'] > 0)
          coursediv += number_format(course['price']) + `<small class="fs-10"> تومان</small>`;
        else
          coursediv += `رایگان`;
        coursediv += `</span></a>`;
        coursediv += `</div></div><br>`;
        coursediv += `<div class="text-left">`;
        coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
        if (course['view_count'] != null)
          coursediv += course['view_count'] + `&nbsp;<i class="fa fa-eye"></i></span>`;
        else
          coursediv += `0 <i class="fa fa-eye"></i></span>`;
        coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
        if (course['register_count'] != null)
          coursediv += course['register_count'] + `&nbsp;<i class="fa fa-users"></i></span>`;
        else
          coursediv += `0 <i class="fa fa-users"></i></span>`;
        coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
        if (course['like_count'] != null)
          coursediv += course['like_count'] + `&nbsp;<i class="fa fa-heart"></i></span`;
        else
          coursediv += `0 <i class="fa fa-heart"></i></span>`;
        coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
        if (course['score'] != null)
          coursediv += course['score'] + `&nbsp;<i class="fa fa-star"></i></span>`;
        else
          coursediv += `0 <i class="fa fa-star"></i></span>`;
        coursediv += `</div></div></div></div></div>`;
        $("#tab-11").append(coursediv);
      }
    }

  } else if (this.value == "dontfree") {
    $("#tab-11").empty();
    for (var i = 0; i < course_results.length; i = i + 1) {
      course = course_results[i];
      if (course['price'] > 0) {
        coursediv = '<div class="card overflow-hidden" style="border-radius: 15px">';
        var course_title = course['title'];
        course_title = course_title.replace(/ /g, '_');
        coursediv += `<div class="d-md-flex"><div class="item-card9-imgs myitem-card">`;
        coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `"></a>`;
        coursediv += `<img src="_upload_/_webinars_/` + course['code'] + `/medium_` + course['image'] + `" alt="` + course['title'] + `" class="cover-image" style="width: 100%;height: 100%;">`;
        coursediv += `</div><div class="card-body " style="padding-top: 0;padding-bottom: 0">`;
        coursediv += `<div class="item-card9"><div class="row"><div class="col-lg-9 col-sm-9 col-xs-9">`;
        coursediv += `<a href="skill/webinar/intro/` + course['id'] + `/` + course_title + `" class="text-dark"><h3 class="font-weight mt-1">` + course['title'] + `</h3></a>`;
        coursediv += `<div class="mt-2 mb-2" style="font-family: VazirLight">`;
        coursediv += `<a  class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-cube ml-1"></i>` + course['category']['title'] + `</span></a>`;
        coursediv += `<a href="teacher/profile/` + course['id_teacher'] + `/` + course['teacher_name'] + ` title="مشاهده پروفایل مدرس" class="ml-4 float-right"><span class="text-muted fs-13"><i class="fa fa-user text-muted ml-1"></i>` + course['teacher_name'] + `</span></a>`;
        coursediv += `<br class="mobile-hidden">`;
        coursediv += `<a  class="ml-4"><span class="text-muted fs-13 IRANSansWeb_Light"><i class="fa fa-calendar text-muted ml-1"></i> ` + course['webinar_start_time_minutes'] + `:` + course['webinar_start_time_hour'] + ` - ` + course['webinar_date'] + `</span></a>`;
        coursediv += `<p class="mb-0 fs-14">` + course['abstractMemo'] + `</p>`;
        coursediv += `</div></div>`;
        coursediv += `<div class="col-lg-3 col-sm-3 col-xs-3 col-md-3 float-left text-left">`;
        coursediv += `<br>`;
        coursediv += `<span class="old_price text-muted fs-16 IRANSansWeb_Light">` + number_format(course['old_price']) + ` `;
        coursediv += `<small class="fs-10"> تومان</small>`;
        coursediv += `</span></span>&nbsp;&nbsp;`;
        coursediv += `<span class="bg-red text-white fs-13 IRANSansWeb_Light p-1" style="border-radius: 10px">% ` + course['discount'] + ` </span>`;
        coursediv += `<br>`;
        coursediv += `<a class="ml-4 text-danger">`;
        coursediv += `<span class="fs-20 text-danger IRANSansWeb_Bold">`;
        if (course['price'] > 0)
          coursediv += number_format(course['price']) + `<small class="fs-10"> تومان</small>`;
        else
          coursediv += `رایگان`;
        coursediv += `</span></a>`;
        coursediv += `</div></div><br>`;
        coursediv += `<div class="text-left">`;
        coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
        if (course['view_count'] != null)
          coursediv += course['view_count'] + `&nbsp;<i class="fa fa-eye"></i></span>`;
        else
          coursediv += `0 <i class="fa fa-eye"></i></span>`;
        coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
        if (course['register_count'] != null)
          coursediv += course['register_count'] + `&nbsp;<i class="fa fa-users"></i></span>`;
        else
          coursediv += `0 <i class="fa fa-users"></i></span>`;
        coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
        if (course['like_count'] != null)
          coursediv += course['like_count'] + `&nbsp;<i class="fa fa-heart"></i></span`;
        else
          coursediv += `0 <i class="fa fa-heart"></i></span>`;
        coursediv += `<span class="text-muted IRANSansWeb_Light" style="margin-left: 10px">`;
        if (course['score'] != null)
          coursediv += course['score'] + `&nbsp;<i class="fa fa-star"></i></span>`;
        else
          coursediv += `0 <i class="fa fa-star"></i></span>`;
        coursediv += `</div></div></div></div></div>`;
        $("#tab-11").append(coursediv);
      }
    }

  }
});

$("#btn_add_favorite").click(function () {
  let formDataa = new FormData();
  formDataa.append('id_target', $("#favorite_id_target").val());
  formDataa.append('type', $("#favorite_type").val());
  $.ajax({
    url: "/add_favorite",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت در علاقه مندی ها");
    },
    success: function (result) {
      if (!result.error) {
        $("#btn_remove_favorite").show();
        $("#btn_add_favorite").hide();
      }
      ShowMessage(result.message, result.type);
    },
    complete: function () {
      CloseWaiting();
    },
    error: function () {
      ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
    }
  });

});

$("#btn_remove_favorite").click(function () {
  let formDataa = new FormData();
  formDataa.append('id_target', $("#favorite_id_target").val());
  formDataa.append('type', $("#favorite_type").val());
  $.ajax({
    url: "remove_favorite",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("حذف از علاقه مندی ها");
    },
    success: function (result) {
      if (!result.error) {
        $("#btn_remove_favorite").hide();
        $("#btn_add_favorite").show();
      }
      ShowMessage(result.message, result.type);

    },
    complete: function () {
      CloseWaiting();
    },
    error: function () {
      ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
    }
  });

});

$("#btn_invite_sms_course").click(function () {

  var phone = $("#phoneNumber").val();
  if (phone.length == 11) {
    let formDataa = new FormData();
    formDataa.append('id_target', course_id);
    formDataa.append('title', course_title);
    formDataa.append('type', "course");
    formDataa.append('phonenumber', phone);
    $.ajax({
      url: "inviteBySMS",
      type: 'POST',
      cache: false,
      data: formDataa,
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      beforeSend: function () {
        ShowWaiting("ارسال دعوت نامه");
      },
      success: function (result) {
        if (!result.error) {
          $("#phoneNumber").val("");
        }
        ShowMessage(result.message, result.type);

      },
      complete: function () {
        CloseWaiting();
      },
      error: function () {
        ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
      }
    });
  } else
    ShowMessage('شماره موبایل معتبر وارد نمائید', 'error');

});

$("#btn_add_note").click(function () {
  var note_title = $("#note_title").val();
  var note_body = $("#note_body").val();

  let formDataa = new FormData();
  formDataa.append('id_course', course_id);
  formDataa.append('id_lesson', lesson_id);
  formDataa.append('note_title', note_title);
  formDataa.append('note_body', note_body);

  $.ajax({
    url: "skill/add_note",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ثبت یادداشت");
    },
    success: function (result) {
      var id = result.id;
      var tr = `<div class="note"  id="tr_note_` + id + `"><div class="name"><h6>` + note_title + `</h6><div class="action"><button onclick="delete_note(` + id + `)" class="btn-circle red"><i class="mdi mdi-trash-can-outline"></i></button></div></div><div class="text">` + note_body + `</div></div>`;
      if (!result.error) {
        $("#tbody_note").append(tr);
        $("#note_title").val("");
        $("#note_body").val("");
      }
      ShowMessage(result.message, result.type);
      $('#modal-addNote').modal('toggle');
    },
    complete: function () {
      CloseWaiting();
    },
    error: function () {
      ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
    }
  });

});

function completelsson() {
  let formDataa = new FormData();
  formDataa.append('id_course', course_id);
  formDataa.append('id_lesson', lesson_id);
  formDataa.append('flag', fg);

  $.ajax({
    url: "skill/lesson_complete",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("تکمیل درس آموزشی");
    },
    success: function (result) {
      if (!result.error) {
        var course_title2 = course_title.replace(" ", "_");
        // window.location.href ="skill/course/"+course_id+"/"+course_title2;
      }
      ShowMessage(result.message, result.type);


    },
    complete: function () {
      CloseWaiting();
    },
    error: function () {
      ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
    }
  });
}

$("#btn_complete_lesson").click(function () {
  completelsson();

});


$("#btn_discount").click(function () {

  if (($("#discount").val()).length > 3) {
    let formDataa = new FormData();
    formDataa.append('discount', $("#discount").val());
    formDataa.append('used_for', $("#discount_type").val());
    $.ajax({
      url: "check_discount",
      type: 'POST',
      cache: false,
      data: formDataa,
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $("#csrf-token").attr('content')
      },
      beforeSend: function () {
        ShowWaiting("بررسی کد تخفیف");
      },
      success: function (result) {
        // console.log(result);
        if (!result.error) {
          var discount_price = result.data['discount'];
          var discount_price = result.data['discount'];
          var percent = result.data['type_value'];
          var price = course_price;
          var new_price = ((price - discount_price)*1);

          var user_wallet = $("#wallet_price").val();
          var user_subsid = $("#subsid_price").val();
          user_wallet = user_wallet * 1;
          user_subsid = user_subsid * 1;
          var new_wallet_online = new_price - (user_wallet+user_subsid);
          new_wallet_online = new_wallet_online * 1;
          new_wallet_online_check = new_wallet_online * 1;
          discount_price = number_format(discount_price);
          new_price = number_format(new_price);
          new_wallet_online = number_format(new_wallet_online);
          $("#discount_pay").text(percent + " درصد برابر با " + discount_price + "  تومان ");
          $("#final_price").text(new_wallet_online + " تومان ");
          $("#wallet-online").text(number_format(new_wallet_online));

          if (new_wallet_online_check <= 0) {
            $("#div_online").hide();
            $("#div_wallet").show();
            $("#payment_type_wallet").prop("checked", true);
          }
        } else
          ShowMessage(result.message, result.type);
      },
      complete: function () {
        CloseWaiting();
      },
      error: function () {
        ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
      }
    });
  } else {
    ShowMessage("کد تخفیف معتبر نمی باشد", 'error');

  }
});


$("#btn_request_certificate").click(function () {
  let formDataa = new FormData();
  formDataa.append('id_course', course_id);

  $.ajax({
    url: "skill/get_certificate",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("تکمیل درس آموزشی");
    },
    success: function (result) {
      if (!result.error) {
        $("#btn_request_certificate").attr('disabled', false);
      }

      ShowMessage(result.message, result.type);


    },
    complete: function () {
      CloseWaiting();
    },
    error: function () {
      ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
    }
  });
});

$("#btn_send_ticket").click(function () {

  let formDataa = new FormData();
  formDataa.append('id_target', course_id);
  formDataa.append('subject', $("#ticket_subject").val());
  formDataa.append('message', $("#ticket_message").val());
  formDataa.append('attach_file', $('#ticket_file')[0].files[0]);
  formDataa.append('type', "course");

  $.ajax({
    url: "send_ticket",
    type: 'POST',
    cache: false,
    data: formDataa,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $("#csrf-token").attr('content')
    },
    beforeSend: function () {
      ShowWaiting("ارسال پرسش");
    },
    success: function (result) {
      if (!result.error) {
        $("#ticket_subject").val("");
        $("#ticket_message").val("");
        $(".dropify-clear").trigger("click");
        $('#modal-question').modal('toggle');
      }

      ShowMessage(result.message, result.type);


    },
    complete: function () {
      CloseWaiting();
    },
    error: function () {
      ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
    }
  });
});

function delete_note(id) {
  Swal.fire({
    title: 'حذف نکته آموزش',
    text: "آیا برای حذف نکته مطمئن هستید؟",
    icon: 'error',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: "تایید",
    cancelButtonText: 'انصراف',
  }).then((result) => {
    if (result.value) {
      let formDataa = new FormData();
      formDataa.append('id_course', course_id);
      formDataa.append('id_lesson', lesson_id);
      formDataa.append('id', id);

      $.ajax({
        url: "skill/delete_note",
        type: 'POST',
        cache: false,
        data: formDataa,
        contentType: false,
        processData: false,
        headers: {
          'X-CSRF-TOKEN': $("#csrf-token").attr('content')
        },
        beforeSend: function () {
          ShowWaiting("حذف  یادداشت");
        },
        success: function (result) {
          if (!result.error) {
            $("#tr_note_" + id).remove();
          }
          ShowMessage(result.message, result.type);

        },
        complete: function () {
          CloseWaiting();
        },
        error: function () {
          ShowMessage(' « خطای ناشناخته لطفا صفحه را تجدید (بازنشانی) کرده و مجددا تلاش نمایید. »', 'error');
        }
      });
    }
  });
}

function show() {
  $("#btn_add_favorite").show();
}

function hide() {
  $("#btn_add_favorite").hide();
}
