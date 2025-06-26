<!DOCTYPE html>
<html lang="fa" class="no-js" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#07c499" />
  <meta name="msapplication-navbutton-color" content="#07c499">
  <meta name="apple-mobile-web-app-status-bar-style" content="#07c499">
  <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
  <base href="{{asset('/')}}" />

  <title>کسبوم | حساب کاربری</title>

</head>

<body>



  <!-- Scripts -->
  <script src="v4_assets/js/jquery-3.5.1.min.js"></script>

  <script>
    function loginApi() {
      //  activate loading
      $('.wrapper-loading').addClass('active');

      var form = new FormData();
      form.append("username", "{{$username}}");
      form.append("password", "{{$password}}");
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('/backend/public/api/auth/login-test') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function(data) {
          loginWeb(data.token)
        },
        error: function(data) {
          const json = jQuery.parseJSON(data.responseText)
          toastMessage('خطای اعتبار سنجی', json.message, 'danger');

          if (json.status && json.status === 'card4') {
            startTimer(durationTime, timesdisplay[0], 'card4');
            $('.cardAuthentication').removeClass('active');
            $('#card4').addClass('active');
          }
        },
        complete: function() {
          //      deactivate loading
          $('.wrapper-loading').removeClass('active');
        }
      });
    }

    function loginWeb(tokenApi) {
      var form = new FormData();
      form.append("username", "{{$username}}");
      form.append("password", "{{$password}}");
      form.append("remote", '');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('/signin') }}",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function() {
          localStorage.setItem('token', tokenApi)
          window.open("/", '_self')
        },
        error: function(data) {
          const json = jQuery.parseJSON(data.responseText)
          toastMessage('', 'ورود به سیستم انجام نشد', 'danger');
        }
      });
    }


    $(document).ready(function() {
      loginApi();
    });

  </script>

</body>

</html>
