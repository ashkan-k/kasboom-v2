function parseError(e, msg='خطا در دریافت اطلاعات') {
              let statusCode = e.status;
              if (statusCode === 404) {
                  createToast('error', 'صفحه یا مسیر مورد نظر یافت نشد. ممکن‌ است دسترسی لازم را نداشته باشید.');
              } else if (statusCode === 403) {
                  createToast('error', 'شما دسترسی به این آیتم را ندارید.');
              } else {
                  try {
                      let error = e.data['non_field_errors'][0];
                      if (error) {
                          createToast('error', error);
                      }
                  } catch (e) {
                      createToast('error', msg);
                  }
              }
          }
function createToast(type, text) {
            let bgColor = '';
            let header = '';
            if (type === 'error') {
              header = 'خطایی رخ داده';
              bgColor = '#e6294b';
            } else if (type === 'warning') {
              header = 'اخطار';
              bgColor = "#ffb22b";
            } else {
              header = "موفقیت آمیز";
              bgColor = "#06d79c";
            }
            $.toast({
              heading: header,
              text: text,
              position: 'bottom-left',
              bgColor: bgColor,
              loaderBg: "rgb(13, 146, 108)",
              loader: true,
              hideAfter: 3000,
              stack: 3
            });
          }
function createSwal(type, text, title, showCancel = true, confirmText = 'بله،مطمئن‌ام', cancelText = "انصراف") {
    return Swal.fire({
      title: title,
      text: text,
      type: type,
      showCancelButton: showCancel,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: confirmText,
      cancelButtonText: cancelText
    })
}

function showToast(error, type) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-left",
        "preventDuplicates": false,
        "showDuration": "2000",
        "hideDuration": "5000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    if (type === 'success') {
        toastr.success(error)
    } else {
        toastr.error(error)
    }
}

// AngularJS Configuration
// var app = angular.module("myApp", []);
// app.config(function ($interpolateProvider, $httpProvider) {
//     $interpolateProvider.startSymbol('[[');
//     $interpolateProvider.endSymbol(']]');
//
//     $httpProvider.defaults.xsrfCookieName = 'csrftoken';
//     $httpProvider.defaults.xsrfHeaderName = 'X-CSRFToken';
// });

// app.config(['ADMdtpProvider', function (ADMdtp) {
//         ADMdtp.setOptions({
//           calType: 'jalali',
//           format: 'YYYY-MM-DD',
//         });
//       }]);
// app.filter('riyalBeautifier', function ($filter) {
//         return function (item) {
//           let noCommaStr = item.toString().replace(/,/g, '');
//           noCommaStr += '';
//           x = noCommaStr.split('.');
//           x1 = x[0];
//           x2 = x.length > 1 ? '.' + x[1] : '';
//           var rgx = /(\d+)(\d{3})/;
//           while (rgx.test(x1)) {
//             x1 = x1.replace(rgx, '$1' + ',' + '$2');
//           }
//           return x1 + x2;
//         };
//       });

function toEnglishDigits(str) {

    // convert persian digits [۰۱۲۳۴۵۶۷۸۹]
    var e = '۰'.charCodeAt(0);
    str = str.replace(/[۰-۹]/g, function(t) {
        return t.charCodeAt(0) - e;
    });

    // convert arabic indic digits [٠١٢٣٤٥٦٧٨٩]
    e = '٠'.charCodeAt(0);
    str = str.replace(/[٠-٩]/g, function(t) {
        return t.charCodeAt(0) - e;
    });
    return str;
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function FormatInputNumberWithComma(element_id, form_id) {
    $(document).ready(function() {
        $(`#${element_id}`).on('input', function() {
            // Get the input value
            var inputValue = $(this).val();

            // Remove existing commas and non-numeric characters
            var sanitizedValue = inputValue.replace(/[^0-9]/g, '');

            // Format the value with commas
            var formattedValue = sanitizedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            // Update the input value
            $(this).val(formattedValue);
        });
    });

    $( `#${form_id}`).on('submit', function (event) {
        $(`#${element_id}`).val($(`#${element_id}`).val().replaceAll(',', ''));
    })
}

function ChangeButtonEnablingStatus(button_id, status) {
    if (status == 'disable') {
        $(`#${button_id}`).addClass('not-allowed-cursor');
        $(`#${button_id}`).removeClass('allowed-cursor');
    } else {
        $(`#${button_id}`).removeClass('not-allowed-cursor');
        $(`#${button_id}`).addClass('allowed-cursor');
    }
}
