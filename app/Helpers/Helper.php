<?php


use App\Models\blog;
use App\Models\category;
use App\Models\category_middle;
use App\Models\category_sub;

use App\Models\categoryMega;
use App\Models\categoryMiddle;
use App\Models\categorySub;
use App\Models\country;
use App\Models\course;
use App\Models\webinar_register;
use App\Models\payment;
use App\Models\city;
use App\Models\state;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;



function generateRandomString($length = 10)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function generateLowCharRandomString($length = 10)
{
  $characters = '01239876452859871001230456';
//    $characters = 'rstuvwxy456789abcdefgh0123ijklmnopqz';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function generateRandomFactorString($length = 8)
{
  $characters = 'stuvwxyz01234abcdefghi56789jklmnopqr';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function generateNewFactorID($str)
{
  $factor = $str . '-' . generateRandomFactorString();
  $loop = true;
  while ($loop == true) {
    $payment = payment::where('factor_id', '=', $factor)->select('factor_id')->count();
    if ($payment == 0)
      $loop = false;
    else
      $factor = $str . '-' . generateRandomFactorString();
  }

  return $factor;
}



function generateWebinarUrl($id_user,$username)
{
  $rnd=generateRandomFactorString(5);
  $user_kasboom_url=$username.'_'.$id_user.'_'.$rnd;

  $loop = true;
  while ($loop == true) {
    $webinars =webinar_register::where('user_url', '=', 'https://Kasboom.ir/ch/'.$user_kasboom_url)->count();
    if ($webinars == 0)
      $loop = false;
    else{
      $rnd=generateRandomFactorString(5);
      $user_kasboom_url=$username.'_'.$id_user.'_'.$rnd;
    }
  }

  return $user_kasboom_url;
}

function sendSMS_Yarane($phoneNumber,$name, $price)
{
//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text = " طلبه گرامی آقا/خانم ".$name."، یارانه ویژه آموزشی به مبلغ " .$price . " تومان به کیف پول مجازی شما در سامانه کسبوم واریز گردید."."\n\n"."مهلت استفاده تا 25 فروردین 1400"."\n\n". "https://Kasboom.ir";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }



// $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text = " طلبه گرامی آقا/خانم ".$name."، یارانه ویژه آموزشی به مبلغ " .$price . " تومان به کیف پول مجازی شما در سامانه کسبوم واریز گردید."."\n\n"."مهلت استفاده تا 25 فروردین 1400"."\n\n". "https://Kasboom.ir";
//     $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'fori' => 2,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;


}




function sendSMS_Tabliq($phoneNumber,$name,$subsid)
{
  try {
    $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
    $client = new Client();

//  $text="طلبه گرامی آقا/خانم ".$name."\n\n".
//             "سلام". "\n\n".
//             " واریز 300 هزار تومان یارانه آموزشی مرکز خدمات حوزه های علمیه به کیف پول مجازی شما در سامانه کسبوم ویژه دهه فجر". "\n\n".
//             "از این یارانه جهت ثبت نام در دوره های آموزشی ویدئویی و آنلاین  کسبوم می توانید  استفاده نمائید". "\n\n".
//             "زمان استفاده از یارانه از 10 الی 25 بهمن می باشد"."\n\n".
//              "مشاهده لیست دوره ها در سایت زیر:"."\n\n".
//             "https://kasboom.ir"."\n\n";


//$text="راهنمایی". "\n\n".
    //          " در صورت بروز مشکل در ورود به حساب کاربری در سامانه کسبوم مراحل زیر را انجام دهید". "\n\n".
    //         "ابتدا بر روی لینک زیر کلیک نمائید". "\n\n".
    //        "https://kasboom.ir/logout"."\n\n".
    //       "سپس جهت ورود بر روی لینک زیر کلیک نمائید"."\n\n".
    //    "https://kasboom.ir/register"."\n\n".
    //  "و یا مرورگر خود را تعویض نمائید";

// $text="واریز 300 هزار تومان". "\n\n".
//             "یارانه آموزشی مرکز خدمات حوزه های علمیه". "\n\n".
//             "در جشنواره تابستانه کسبوم.". "\n\n".
//             "(مهلت استفاده از یارانه محدود می باشد)"."\n\n".
//             "کسب اطلاعات بیشتر با مراجعه به آدرس زیر:"."\n\n".
//              "https://kasboom.ir/subsid";


//  $text=$name." گرامی \n\n".
//             "یارانه آموزشی باقی مانده شما در سامانه کسبوم:". $subsid."  تومان می باشد"."\n\n".
//             "مهلت باقی مانده جهت استفاده از یارانه آموزشی و تخفیف ویژه جشنواره 4 روز می باشد"."\n\n".
//             "جهت راهنمایی بیشتر به شماره 09918892281 در پیام رسان ایتا پیام ارسال نمائید"."\n\n".
//              "https://kasboom.ir";


    $text="جشنواره تابستانه جهش". "\n\n".
      "مرکز خدمات حوزه علمیه با همکاری سامانه کسبوم برگزار می کنند". "\n\n".
      "ویژه خانواده طلاب". "\n\n".
      "کسب اطلاعات بیشتر:"."\n\n".
      "https://kasboom.ir/subsid";


    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'text' => $text,
        'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  }
  catch (\Exception $e) {
    return false;
  }
}


function sendSMS_webinar($webinar_title,$phoneNumber,$name,$user_url)
{
//  try {
  // $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
  // $client = new Client();

  // $text=$name." گرامی "."\n\n".
  //   "لینک اختصاصی ورود شما به وبینار:". "\n\n".
  //   $webinar_title. "\n\n".
  //   $user_url. "\n\n".
  //   "لینک در اختیار شخص دیگری قرار نگیرد". "\n\n".
  //   "https://kasboom.ir";


  // $response = $client->request('POST', $url, [
  //   'verify' => false,
  //   'form_params' => [
  //     'to' => $phoneNumber,
  //     'text' => $text,
  //     'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
  //   ]
  // ]);
  // $status = $response->getStatusCode();
  // if ($status == 200)
  //   return true;
  // else
  //   return false;
//  }
//  catch (\Exception $e) {
//    return false;
//  }
}
function sendSMS_Tabliq_mazaya($phoneNumber,$name,$subsid)
{
//   try {
  $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
  $client = new Client();

  $text="مزایای دوره های آموزشی کسبوم: ". "\n\n".
    "آموزش حرفه ای" ."\n".
    "محتوی ویدئویی باکیفیت" ."\n".
    "پشتیبانی مدرس" ."\n".
    "گواهینامه آموزشی" ."\n".
    "تسهیلات خوداشتغالی" ."\n".
    "دسترسی همیشگی به دوره" ."\n".
    "هزینه معقول" ."\n".
    "اتاق های گفتگو" ."\n".
    "و ..." ."\n\n".

    "با توجه به اینکه زمان استفاده از یارانه کوتاه می باشد از این فرصت ویژه بهره مند شوید";


  $response = $client->request('POST', $url, [
    'verify' => false,
    'form_params' => [
      'to' => $phoneNumber,
      'text' => $text,
      'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
    ]
  ]);
  $status = $response->getStatusCode();
  if ($status == 200)
    return true;
  else
    return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }
}

function sendSMS_Tabliq_subsid($phoneNumber,$name,$subsid)
{
  try {
    $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
    $client = new Client();
    //$text="طلبه گرامی آقا/خانم  ".$name."\n\n"."نظر به استقبال فراوان از دوره های آموزش مهارتی سامانه کسب بوم، مهلت ثبت نام تا آخر فروردین تمدید شد."."\n\n"." جهت استفاده از یارانه 160 هزار تومانی دوره های آموزشی و همچنین بهره مندی از مزایای دوره ها به سامانه کسب بوم مراجعه فرمائید."."\n\n"."کسب بوم؛ سامانه جامع توانمندسازی کسب و کارهای بومی و مشاغل خانگی"."\n"."https://kasboom.ir"."\n\n"."تلفن پشتیبانی:."."021-28422767";
//    $text="طلبه گرامی آقا/خانم  ".$name."\n\n"."نظر به استقبال فراوان از دوره های آموزش مهارتی سامانه کسب بوم، مهلت ثبت نام تا آخر فروردین تمدید شد."."\n\n"." جهت استفاده از یارانه 160 هزار تومانی دوره های آموزشی و همچنین بهره مندی از مزایای دوره ها به سامانه کسبوم مراجعه فرمائید."."\n\n"."کسبوم؛ سامانه جامع توانمندسازی کسب و کارهای بومی و مشاغل خانگی"."\n"."https://kasboom.ir"."\n\n"."تلفن پشتیبانی:"."\n"."02128422767";

    $text= "طلبه گرامی آقا/خانم  ".$name."\n\n".
      "سرانه آموزشی به مبلغ ". $subsid ." تومان از طرف مرکز خدمات حوزه های علمیه به کیف پول مجازی شما در سامانه کسبوم واریز گردید". "\n\n".
      "مهلت استفاده تا 30 آذر". "\n\n".
      "جهت شرکت در دوره های آموزشی و وبینارهای مشاوره کسب و کار به سامانه کسبوم مراجعه نمایید.". "\n".
      "https://kasboom.ir". "\n\n".
      "تلفن پشتیبانی:". "\n".
      "02128422767";

    //$text = " طلبه گرامی آقا/خانم ".$name."\n\n"." یارانه 80 درصدی ویژه آموزش  مشاغل خانگی اداره کل معیشت و توانمندسازی مرکز خدمات به کیف پول مجازی شما در سامانه کسب بوم واریز گردید."."\n"." جهت اطلاع از مزایا و بهره مندی به سامانه کسب بوم  به آدرس"."\n"." www.Kasboom.ir "."\n"."مراجعه نمائید. "."\n\n"."مهلت استفاده تا 25 فروردین"."\n\n"." کسب بوم؛ سامانه جامع توانمندسازی کسب و کارهای بومی";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'text' => $text,
        'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  }
  catch (\Exception $e) {
    return false;
  }
}


function sendSMS_Verify_Code_user($name, $phoneNumber, $code)
{
//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text = $name . " ارجمند " . "\n\n" . "کد تایید کسبوم: " . $code . "\n\n" . " جهت تایید شماره موبایل، کدفوق را در سامانه کسبوم وارد نمائید";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }

//   try {
    $url = "http://sms.rajat.ir/send_line.php";
    $client = new Client();
    $text ="کد تایید کسبوم: " . $code;
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'from' => 5000298645,
        'username' => 15835,
        'password' => 1583500,
        'text' => $text,
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
//   } catch (\Exception $e) {
//     return false;
//   }


}

function sendSMS_Disposable_Password_user($name, $phoneNumber, $pass)
{
//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text = $name . " ارجمند " . "\n\n" . "رمز یکبار مصرف : " . $pass . "\n\n" . " جهت ورود به حساب کاربری ، رمز فوق را در سامانه کسبوم وارد نمائید";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }

  try{
    $url = "http://sms.rajat.ir/send_line.php";
    $client = new Client();
    $text ="کد تایید کسبوم: " . $pass;
    // $text = $name . " ارجمند " . "\n\n" . "رمز یکبار مصرف : " . $pass . "\n\n" . " جهت ورود به حساب کاربری ، رمز فوق را در سامانه کسبوم وارد نمائید";
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'from' => 5000298645,
        'username' => 15835,
        'password' => 1583500,
        'text' => $text,
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  } catch (\Exception $e) {
    return false;
  }


}

function sendSMS_Register_Azad($name, $phoneNumber, $username, $userpass)
{
//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text = $name . " ارجمند " . "\n\n" . $message . "\n" . "نام کاربری: " . $username . "\n" . "رمز عبور: " . $userpass . "\n\n" . "راهنمای سامانه" . "\n" . "https://kasboom.ir/faq";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }

  $message = 'سلام؛ ثبت نام شما در سامانه کسبوم با موفقیت انجام شد.';

  try{
    $url = "http://sms.rajat.ir/send_line.php";
    $client = new Client();
    $text = $name . " ارجمند " . "\n\n" . $message . "\n" . "نام کاربری: " . $username . "\n" . "رمز عبور: " . $userpass . "\n\n" . "راهنمای سامانه" . "\n" . "https://kasboom.ir/faq";
    $text = $name . " ارجمند " . "\n\n" . $message . "\n" . "نام کاربری: " . $username . "\n" . "رمز عبور: " . $userpass;
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'from' => 5000298645,
        'username' => 15835,
        'password' => 1583500,
        'text' => $text,
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;

  } catch (\Exception $e) {
    return false;
  }


}


function sendSMS_Login($phoneNumber, $loginCode)
{
//  try{
//    $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//
//    $toNum = array($phoneNumber);
//    $pattern_code = "sybxq8l4cb";
//    $input_data = array(
//        "login-code" => $loginCode
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//
//    $flag=false;
//
//    if (count($smsStatus) > 1)
//      $flag=false;
//    else
//      $flag=true;
//
//    return  $flag;
//  }
//  catch (\Exception $e) {
//    return true;
//  }

//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text = "کد یکبار مصرف: " . $loginCode . "\n\n" . "سامانه کسبوم";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }


  try{
    $url = "http://sms.rajat.ir/send_line.php";
    $client = new Client();

    $text ="کد تایید کسبوم: " . $loginCode;
    // $text = "کد یکبار مصرف: " . $loginCode . "\n\n" . "سامانه کسبوم";
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'from' => 5000298645,
        'username' => 15835,
        'password' => 1583500,
        'text' => $text,
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  } catch (\Exception $e) {
    return false;
  }



}

function sendSMS_Password($phoneNumber, $pass)
{
//  try{
//     $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//     $toNum = array($phoneNumber);
//     $pattern_code = "yiblab4hf6";
//     $input_data = array(
//      "pass" => $pass
//     );

//     $user = config('app.sms_username');
//     $pass = config('app.sms_userpass');
//     $fromNum = config('app.sms_fromnum');
//     $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//     $smsStatus = explode(',', $smsStatus);

//     $flag=false;

//     if (count($smsStatus) > 1)
//      $flag=false;
//     else
//      $flag=true;

//     return  $flag;

//  }
//  catch (\Exception $e) {
//     return true;
//  }

  try {
    $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
    $client = new Client();
    $text = "کلمه عبور: " . $pass . "\n\n" . "https://kasboom.ir/register". "\n" . "سامانه کسبوم";
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'text' => $text,
        'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  }
  catch (\Exception $e) {
    return false;
  }

}

function sendSMS_verify_technical($phoneNumber,$name, $wallet,$username)
{
//  try {
//    $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//
//    $toNum = array($phoneNumber);
//    $pattern_code = "q81n60byj3";
//    $input_data = array(
//      "name" => $name,
//      "username" => $username,
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//      return false;
//    else
//      return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }


  try {
    $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
    $client = new Client();
    $text =$name. " ارجمند " . "\n\n" . "اطلاعات کاربری شما در سامانه کسبوم توسط مرکز خدمات حوزه های علمیه تایید گردید.". "\n\n"."نام کاربری:".$username ."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
    $text =$name. " ارجمند " . "\n\n" . "اطلاعات کاربری شما در سامانه کسبوم توسط مرکز خدمات حوزه های علمیه تایید گردید.". "\n\n"."نام کاربری:".$username;
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'text' => $text,
        'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  }
  catch (\Exception $e) {
    return false;
  }


//   try{
//       $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n\n" . "اطلاعات کاربری شما در سامانه کسبوم توسط مرکز خدمات حوزه های علمیه تایید گردید.". "\n\n"."نام کاربری:".$username ."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;

//   } catch (\Exception $e) {
//     return false;
//   }


}

function sendSMS_Register($name, $phoneNumber, $loginCode)
{
//  try{
//
//    $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//    $toNum = array($phoneNumber);
//    $pattern_code = "a1jj90agiv";
//    $input_data = array(
//        "name" => $name,
//        "login-code" => $loginCode,
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//        return false;
//    else
//        return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }

//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text =$name. " عزیز، ضمن عرض خوش آمد گویی شما به خانواده بزرگ کسب بوم، امید است سامانه جامع کسب بوم بتواند همراهی مطمئن در مسیر کارآفرینی و توانمندسازی مهارتی شما باشد. ان شاءالله " . "\n\n"."کلمه عبور:".$loginCode . "\n\n"."https://kasboom.ir/login"."\n". "سامانه کسب بوم";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }

  try{
    $url = "http://sms.rajat.ir/send_line.php";
    $client = new Client();
    $text =$name. " عزیز، ضمن عرض خوش آمد گویی شما به خانواده بزرگ کسب بوم، امید است سامانه جامع کسب بوم بتواند همراهی مطمئن در مسیر کارآفرینی و توانمندسازی مهارتی شما باشد. ان شاءالله " . "\n\n"."کلمه عبور:".$loginCode . "\n\n"."https://kasboom.ir/login"."\n". "سامانه کسب بوم";
    $text ="کلمه عبور:".$loginCode . "\n\n"."https://kasboom.ir/login"."\n". "سامانه کسب بوم";
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'from' => 5000298645,
        'username' => 15835,
        'password' => 1583500,
        'text' => $text,
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;

  } catch (\Exception $e) {
    return false;
  }

}

function sendSMS_Register_howzeh($name,$phoneNumber,$username,$message,$userpass){
//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n\n".$message."\n"."نام کاربری: ".$username."\n"."رمز عبور: ".$userpass."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";;
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }

  try{
    $url = "http://sms.rajat.ir/send_line.php";
    $client = new Client();
    $text =$name. " ارجمند " . "\n\n".$message."\n"."نام کاربری: ".$username."\n"."رمز عبور: ".$userpass."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";;
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'from' => 5000298645,
        'username' => 15835,
        'password' => 1583500,
        'text' => $text,
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;

  } catch (\Exception $e) {
    return false;
  }


}

function sendSMS_vam_followup($name,$phoneNumber,$followup){
//  try{
//  $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//  $toNum = array($phoneNumber);
//  $pattern_code = "rvpj1jnnn8";
//  $input_data = array(
//    "name" => $name,
//    "followup_code" => $followup,
//  );
//
//  $user = config('app.sms_username');
//  $pass = config('app.sms_userpass');
//  $fromNum = config('app.sms_fromnum');
//
//  $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//  $smsStatus = explode(',', $smsStatus);
//  if (count($smsStatus) > 1)
//    return false;
//  else
//    return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }

//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n\n"." کد پیگیری تسهیلات: ".$followup ."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }

// try{
// $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n\n"." کد پیگیری تسهیلات: ".$followup ."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
// } catch (\Exception $e) {
//     return false;
//   }



}

function sendSMS_Invite_Course($phoneNumber, $title, $url_course)
{
//  try{
//  $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//    $toNum = array($phoneNumber);
//    $pattern_code = "jkfhousahx";
//    $input_data = array(
//        "title" => $title,
//        "url" => $url,
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//        return false;
//    else
//        return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }

//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text = "سلام و درود"."\n"."از شما دعوت شده است جهت شرکت در دوره آموزشی  " . "\n". $title . "\n\n". $url_course ."\n\n". "کسبوم؛ سامانه جامع توانمندسازی کسب و کارهای بومی";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }

// try{

// $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text = "سلام و درود"."\n"."از شما دعوت شده است جهت شرکت در دوره آموزشی  " . "\n". $title . "\n\n". $url_course ."\n\n". "کسبوم؛ سامانه جامع توانمندسازی کسب و کارهای بومی";
//     $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
// } catch (\Exception $e) {
//     return false;
//   }



}

function sendSMS_NewsLetter($phoneNumber)
{

//  try{
//  $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//    $toNum = array($phoneNumber);
//    $pattern_code = "0meqyqrx2a";
//    $input_data = array(
//        "name" => "دوست عزیز",
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//        return false;
//    else
//        return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }

//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text ="عضویت شما در خبرنامه کسبوم انجام گردید."."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }

//   try{

// $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text ="عضویت شما در خبرنامه کسبوم انجام گردید."."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,

//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }



}

function sendSMS_InviteTeacher($phoneNumber, $fullname)
{
//  try{
//    $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//    $toNum = array($phonenumber);
//    $pattern_code = "hc0ses7er6";
//    $input_data = array(
//        'name' => $fullname,
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//        return false;
//    else
//        return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }


//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text =$fullname. " ارجمند " . "\n\n"." درخواست همکاری شما ثبت گردید. در اسرع وقت با شما تماس گرفته خواهد شد." ."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }

//   try{

// $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text =$fullname. " ارجمند " . "\n\n"." درخواست همکاری شما ثبت گردید. در اسرع وقت با شما تماس گرفته خواهد شد." ."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'fori' => 2,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }


}

function sendSMS_Course_Quiz($name, $title, $score, $nowdate, $phoneNumber)
{
//
//  try{
//    $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//
//    $toNum = array($phonenumber);
//    $pattern_code = "84pdm6lvd3";
//    $input_data = array(
//        'name' => $name,
//        'title' => $title,
//        'score' => $score,
//        'nowdate' => $nowdate,
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//        return false;
//    else
//        return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }


//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n"."امتیاز کسب شده شما در آزمون دوره ( " .$title." ) ".$score." از 100 می باشد. "."\n"."تاریخ آزمون: ".$nowdate."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }

  try{
    $url = "http://sms.rajat.ir/send_line.php";
    $client = new Client();
    $text =$name. " ارجمند " . "\n"."امتیاز کسب شده شما در آزمون دوره ( " .$title." ) ".$score." از 100 می باشد. "."\n"."تاریخ آزمون: ".$nowdate."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
    $text =$name. " ارجمند " . "\n"."امتیاز کسب شده شما در آزمون دوره ( " .$title." ) ".$score." از 100 می باشد. "."\n"."تاریخ آزمون: ".$nowdate;
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'from' => 5000298645,
        'username' => 15835,
        'password' => 1583500,
        'text' => $text,
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;

  } catch (\Exception $e) {
    return false;
  }


}

function sendSMS_Course_Register($name, $title, $nowdate, $phoneNumber, $RefID, $factor_id, $payment_price)
{
//  try{
//    $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//    $toNum = array($phonenumber);
//    $pattern_code = "46rchgsi0p";
//    $input_data = array(
//        'name' => $name,
//        'title' => $title,
//        'nowdate' => $nowdate,
//        'RefID' => $RefID,
//        'factor_id' => $factor_id,
//        'price' => $payment_price,
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//
//
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//        return false;
//    else
//        return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }


//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n"."ثبت نام شما در دوره ( " .$title." ) باموفقیت انجام شد. "."\n"."تاریخ عضویت: ".$nowdate."\n"."مبلغ پرداختی: ".$payment_price."\n"."کد پیگیری پرداخت: ".$RefID."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }
  try{


    $url = "http://sms.rajat.ir/send_line.php";
    $client = new Client();
    $text =$name. " ارجمند " . "\n"."ثبت نام شما در دوره ( " .$title." ) باموفقیت انجام شد. "."\n"."تاریخ عضویت: ".$nowdate."\n"."مبلغ پرداختی: ".$payment_price."\n"."کد پیگیری پرداخت: ".$RefID."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
    $text =$name. " ارجمند " . "\n"."ثبت نام شما در دوره ( " .$title." ) باموفقیت انجام شد. ";
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'from' => 5000298645,
        'username' => 15835,
        'password' => 1583500,
        'text' => $text,
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  } catch (\Exception $e) {
    return false;
  }


}

function sendSMS_Course_Register_teacher($name, $title, $nowdate, $phoneNumber)
{

  try {
    $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
    $client = new Client();
    $text= " ثبت نام جدید دوره  ".$title."\n\n".
      " هنر آموز : ".$name."\n\n".
      "تاریخ ثبت نام: ".$nowdate."\n\n".
      "کسبوم، پلتفرم اشتغال و توانمندسازی";

    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'text' => $text,
        'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  }
  catch (\Exception $e) {
    return false;
  }

//   try{
//   $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//  $text= " ثبت نام جدید دوره  ".$title."\n\n".
//       " هنر آموز : ".$name."\n\n".
//       "تاریخ ثبت نام: ".$nowdate."\n\n".
//       "کسبوم، پلتفرم اشتغال و توانمندسازی";

//       $text = $text."\n\n". "لغو ۱۱ ";

//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'fori' => 2,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }

}


function sendSMS_Webinar_Register($name, $username, $title, $webinar_date, $phoneNumber, $refID, $payment_price, $url_webinar)
{
//  try{
//  $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//    $toNum = array($phonenumber);
//    $pattern_code = "t2kgp63382";
//    $input_data = array(
//        'name' => $name,
//        'username' => $username,
//        'title' => $title,
//        'webinar_date' => $webinar_date,
//        'RefID' => $refID,
//        'price' => $payment_price,
//        'url' => $url,
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//
//
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//        return false;
//    else
//        return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }
//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n"."ثبت نام شما در وبینار ( " .$title." ) باموفقیت انجام شد. "."\n"."تاریخ وبینار: ".$webinar_date."\n"."نام کاربری: ".$username."\n"."کلمه عبور: شماره موبایل"."\n"."آدرس وبینار: "."\n".$url_webinar."\n"."مبلغ پرداختی: ".$payment_price."\n"."کد پیگیری:".$refID."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }

//   try{
//   $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n"."ثبت نام شما در وبینار ( " .$title." ) باموفقیت انجام شد. "."\n"."تاریخ وبینار: ".$webinar_date."\n"."نام کاربری: ".$username."\n"."کلمه عبور: شماره موبایل"."\n"."آدرس وبینار: "."\n".$url_webinar."\n"."مبلغ پرداختی: ".$payment_price."\n"."کد پیگیری:".$refID."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'fori' => 2,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }

}



function sendSMS_Webinar_Register2($name, $username, $title, $webinar_date, $phoneNumber, $refID, $payment_price, $url_webinar)
{
//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();

//     $text =$name. " ارجمند " . "\n"."ثبت نام شما در وبینار ( " .$title." ) باموفقیت انجام شد. "."\n\n"."تاریخ وبینار: ".$webinar_date."\n\n"." لینک ورود شما به وبینار: "."\n".$url_webinar."\n\n"." برای شرکت در وبینار در تاریخ مقرر بر روی لینک فوق کلیک نمائید. لینک فقط برای شما می باشد در اختیار شخص دیگری قرار نگیرد"."\n\n"."کسبوم؛ سامانه توانمندسازی کسب و کار"."\n\n"."تلفن پشتیبانی: "."02128422767";

//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }

//   try{
//   $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n"."ثبت نام شما در وبینار ( " .$title." ) باموفقیت انجام شد. "."\n\n"."تاریخ وبینار: ".$webinar_date."\n\n"." لینک ورود شما به وبینار: "."\n".$url_webinar."\n\n"." برای شرکت در وبینار در تاریخ مقرر بر روی لینک فوق کلیک نمائید. لینک فقط برای شما می باشد در اختیار شخص دیگری قرار نگیرد"."\n\n"."کسبوم؛ سامانه توانمندسازی کسب و کار"."\n\n"."تلفن پشتیبانی: "."02128422767";
//     $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'fori' => 2,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }


}

function sendSMS_Webinar_Register_term($name, $username, $title, $phoneNumber, $refID, $payment_price, $url_webinar)
{
  try {
    $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
    $client = new Client();

    $text =$name. " ارجمند " . "\n"."ثبت نام شما در وبینار ( " .$title." ) انجام شد. "." لینک ورود شما به دوره: "."\n".$url_webinar;

    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'text' => $text,
        'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  }
  catch (\Exception $e) {
    return false;
  }


//   try{
//   $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
// $text =$name. " ارجمند " . "\n"."ثبت نام شما در وبینار ( " .$title." ) انجام شد. "."\n\n"."تاریخ شروع دوره بعد از تکمیل ظرفیت اطلاع رسانی می شود "."\n\n"." لینک ورود شما به دوره: "."\n".$url_webinar."\n\n"." برای شرکت در دوره لینک فوق را حفظ کنید. لینک فقط برای شما می باشد در اختیار شخص دیگری قرار نگیرد"."\n\n"."کسبوم؛ سامانه توانمندسازی کسب و کار"."\n\n"."تلفن پشتیبانی: "."02128422767";
// $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'fori' => 2,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }


}


function sendSMS_Consult_Register($name, $fullname, $nowdate, $phoneNumber, $RefID, $factor_id, $payment_price)
{
//  try{
//    $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//    $toNum = array($phonenumber);
//    $pattern_code = "hpljg4e5wq";
//    $input_data = array(
//        'name' => $name,
//        'fullname' => $fullname,
//        'nowdate' => $nowdate,
//        'RefID' => $RefID,
//        'factor_id' => $factor_id,
//        'price' => $payment_price,
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//        return false;
//    else
//        return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }

  try {
    $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
    $client = new Client();
    $text =$name. " ارجمند " . "\n"."درخواست مشاوره شما از ( " .$fullname." ) باموفقیت ثبت گردید. زمان دقیق مشاوره در اسرع وقت به صورت پیامکی و تلفنی به اطلاع شما می رسد. "."\n"."تاریخ درخواست: ".$nowdate."\n"."مبلغ پرداختی: ".$payment_price."تومان"."\n"."کد پیگیری: ".$RefID."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'text' => $text,
        'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  }
  catch (\Exception $e) {
    return false;
  }

//   try{

//   $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n"."درخواست مشاوره شما از ( " .$fullname." ) باموفقیت ثبت گردید. زمان دقیق مشاوره در اسرع وقت به صورت پیامکی و تلفنی به اطلاع شما می رسد. "."\n"."تاریخ درخواست: ".$nowdate."\n"."مبلغ پرداختی: ".$payment_price."تومان"."\n"."کد پیگیری: ".$RefID."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'fori' => 2,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }


}

function sendSMS_ConsultingTime($user_name, $consult_name, $phoneNumber, $consult_date, $consult_time)
{
//  try{
//    $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//    $toNum = array($phonenumber);
//    $pattern_code = "wprt0wrbei";
//    $input_data = array(
//        'name' => $user_name,
//        'fullname' => $consult_name,
//        'consult_date' => $consult_date,
//        'consult_time' => $consult_time,
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//        return false;
//    else
//        return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }

  try {
    $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
    $client = new Client();
    $text =$user_name. " ارجمند " . "\n"."زمان مشاوره شما از ( " .$consult_name." ) تعیین گردید. لطفا در زمان زیر در دسترس باشید. "."\n"."تاریخ مشاوره: ".$consult_date."\n"."ساعت مشاوره: ".$consult_time."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'text' => $text,
        'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  }
  catch (\Exception $e) {
    return false;
  }


//   try{
//   $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text =$user_name. " ارجمند " . "\n"."زمان مشاوره شما از ( " .$consult_name." ) تعیین گردید. لطفا در زمان زیر در دسترس باشید. "."\n"."تاریخ مشاوره: ".$consult_date."\n"."ساعت مشاوره: ".$consult_time."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'fori' => 2,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }


}

function sendSMS_Hire_Register($name, $title, $nowdate, $phoneNumber, $RefID, $factor_id, $payment_price)
{
//  try{
//    $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//    $toNum = array($phonenumber);
//    $pattern_code = "4j7meylbtf";
//    $input_data = array(
//        'name' => $name,
//        'title' => $title,
//        'nowdate' => $nowdate,
//        'RefID' => $RefID,
//        'factor_id' => $factor_id,
//        'price' => $payment_price,
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//        return false;
//    else
//        return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }

  try {
    $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
    $client = new Client();
    $text ="فاکتور خرید پکیج استخدام یار ( " .$title." ) "."\n"."تاریخ خرید: ".$nowdate."\n"."شماره فاکتور: ".$factor_id."\n"."مبلغ دوره:".$payment_price." تومان "."\n"."کد پیگیری: ".$RefID."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'text' => $text,
        'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  }
  catch (\Exception $e) {
    return false;
  }


//   try{
//   $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text ="فاکتور خرید پکیج استخدام یار ( " .$title." ) "."\n"."تاریخ خرید: ".$nowdate."\n"."شماره فاکتور: ".$factor_id."\n"."مبلغ دوره:".$payment_price." تومان "."\n"."کد پیگیری: ".$RefID."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'fori' => 2,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   } catch (\Exception $e) {
//     return false;
//   }



}

function sendSMS_InviteLive($phoneNumber)
{

//  try{
//    $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
//    $toNum = array($phoneNumber);
//    $pattern_code = "9zhdk644wn";
//    $input_data = array(
//      "name" => "دوست عزیز",
//    );
//
//    $user = config('app.sms_username');
//    $pass = config('app.sms_userpass');
//    $fromNum = config('app.sms_fromnum');
//
//    $smsStatus = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
//    $smsStatus = explode(',', $smsStatus);
//    if (count($smsStatus) > 1)
//      return false;
//    else
//      return true;
//  }
//  catch (\Exception $e) {
//    return true;
//  }

  try {
    $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
    $client = new Client();
    $text ="سلام و درود؛ "."\n"."عضویت شما در خبرنامه پخش زنده برنامه های کسبوم انجام گردید."."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'text' => $text,
        'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  }
  catch (\Exception $e) {
    return false;
  }


//   try{
//   $url = "http://sms.rajat.ir/send_line.php";
//     $client = new Client();
//     $text ="سلام و درود؛ "."\n"."عضویت شما در خبرنامه پخش زنده برنامه های کسبوم انجام گردید."."\n\n". "سامانه کسبوم"."\n"."https://kasboom.ir";
//     $text = $text."\n\n". "لغو ۱۱ ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phoneNumber,
//         'from' => 5000298645,
//         'fori' => 2,
//         'username' => 15835,
//         'password' => 1583500,
//         'text' => $text,
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;

//   } catch (\Exception $e) {
//     return false;
//   }

}

function nowDate_Shamsi($data = '')
{
  $nowDate = $data == "" ? date("Y-m-d") : $data;
  $nowdate_shamsi = jdate($nowDate)->format('%Y/%m/%d');
  return $nowdate_shamsi;
}

function generateIdeaCode()
{
  $rnd = rand(10, 100);
  $code = $rnd . sha1(time());
  return $code;
}

function uploadImageFile($file, $path)
{
  //    dd(getUserIp($request));
  $ip="172.16.1.0";
  $user_id=ip2long($ip);
  $low_ip=ip2long("172.16.1.1");
  $high_ip=ip2long("172.31.255.254");

  $fileextension = $file->getClientOriginalExtension();
//        $filename = $file->getClientOriginalName();
  $filename = 'img_' . sha1(time()) . "." . $fileextension;
  $public_path = public_path($path);
//  dd($public_path);
  $file = $file->move($public_path, $filename);
  Image::make($public_path . '/' . $filename)->resize(128, 100)->save($public_path . '/small_' . $filename);
  Image::make($public_path . '/' . $filename)->resize(320, 240)->save($public_path . '/medium_' . $filename);
  return $filename;
}

function uploadImageFileWithWatermark($file, $path)
{
  $fileextension = $file->getClientOriginalExtension();
//        $filename = $file->getClientOriginalName();
  $filename = 'img_' . sha1(time()) . "." . $fileextension;
  $public_path = public_path($path);
  $file = $file->move($public_path, $filename);
//    Image::make($public_path.'/'.$filename)->resize(128, 100)->save($public_path.'/small_'.$filename);
  Image::make($public_path . '/' . $filename)->resize(320, 240)->save($public_path . '/small_' . $filename);
  Image::make($public_path . '/' . $filename)->resize(320, 240)->save($public_path . '/medium_' . $filename);

  $stamp_medium = imagecreatefrompng(public_path('assets/images/watermarks/medium.png'));
  $stamp_small = imagecreatefrompng(public_path('assets/images/watermarks/small.png'));
  if ($fileextension == "png") {
    $im_medium = imagecreatefrompng($public_path . '/medium_' . $filename);
    $im_small = imagecreatefrompng($public_path . '/small_' . $filename);
  } else {
    $im_medium = imagecreatefromjpeg($public_path . '/medium_' . $filename);
    $im_small = imagecreatefromjpeg($public_path . '/small_' . $filename);
  }


  $marge_right = 0.1;
  $marge_bottom = 0.1;
  $sx = imagesx($stamp_medium);
  $sy = imagesy($stamp_medium);

  imagecopy($im_medium, $stamp_medium, imagesx($im_medium) - $sx - $marge_right, imagesy($im_medium) - $sy - $marge_bottom, 0, 0, imagesx($stamp_medium), imagesy($stamp_medium));
  imagejpeg($im_medium, $public_path . '/medium_' . $filename, 100);

  $sx = imagesx($stamp_small);
  $sy = imagesy($stamp_small);

  imagecopy($im_small, $stamp_small, imagesx($im_small) - $sx - $marge_right, imagesy($im_small) - $sy - $marge_bottom, 0, 0, imagesx($stamp_small), imagesy($stamp_small));
  imagejpeg($im_small, $public_path . '/small_' . $filename, 100);


  return $filename;
}

function uploadVideoFile($file, $path)
{
  $fileextension = $file->getClientOriginalExtension();
  $filename = 'video_' . sha1(time()) . "." . $fileextension;

  $public_path = public_path($path);

  $file = $file->move($public_path, $filename);
  return $filename;
}

function uploadFile($file, $path)
{
  $fileextension = $file->getClientOriginalExtension();
  $filename = 'file_' . sha1(time()) . "." . $fileextension;

  $public_path = public_path($path);

  $file = $file->move($public_path, $filename);
  return $filename;
}

function deleteFile($path)
{
  File::delete($path);

}

function getCategory($type, $with_courses=false)
{

  $session_name = "cats_" . $type;
  $cats = Session::get($session_name);

  $cats=null;
  if ($cats == null) {
//    $cats = categoryMega::where("status", "=", 1)->get();
    $cats = category::where("status", "=", 1);

    if ($with_courses){
        $cats->with('courses');
    }

      if ($type == 'courses')
          $cats->withCount(['courses' => function($q){
              $q->where('status', 1);
          }]);

      if ($type == 'blogs')
          $cats->withCount(['blogs' => function($q){
              $q->where([['status', 1], ['blog_type', 'media']]);
          }]);

      if ($type == 'consults')
          $cats->withCount(['consults' => function($q){
              $q->where('status', 1);
          }]);

      if ($type == 'webinars')
          $cats->withCount(['webinars' => function($q){
              $q->where('status', '>', 0);
          }]);

      if ($type == 'idea')
          $cats->withCount(['wikiidea' => function($q){
              $q->where('status', 1);
          }]);

    $cats = $cats->get();
    Session::put($session_name, $cats);
  }

  return $cats;
}

function getCategoryMega($type)
{
  $cats = categoryMega::where('status', 1);

  if (in_array('courses', $type))
    $cats->withCount(['courses' => function($q){
      $q->where('status', 1);
    }]);

  if (in_array('blogs', $type))
    $cats->withCount(['blogs' => function($q){
      $q->where([['status', 1], ['blog_type', 'media']]);
    }]);

  if (in_array('consults', $type))
    $cats->withCount(['consults' => function($q){
      $q->where('status', 1);
    }]);

  if (in_array('webinars', $type))
    $cats->withCount(['webinars' => function($q){
      $q->where('status', '>', 0);
    }]);

  if (in_array('idea', $type))
    $cats->withCount(['idea' => function($q){
      $q->where('status', 1);
    }]);

  return $cats->get();
}

function getState()
{
  $states = Session::get("state");
  if ($states == null) {
    $states = state::all();
    Session::put("state", $states);
  }
  return $states;

}

function getCountry()
{
  $countrys = Session::get("countrys");
  if ($countrys == null) {
    $countrys =country::all();
    Session::put("countrys", $countrys);
  }
  return $countrys;
}

function delete_directory($dirname)
{
  $dir_handle = '';
  $dirname = public_path($dirname);
  if (is_dir($dirname))
    $dir_handle = opendir($dirname);

  if (!$dir_handle)
    return false;
  while ($file = readdir($dir_handle)) {
    if ($file != "." && $file != "..") {
      if (!is_dir($dirname . DIRECTORY_SEPARATOR. $file))
        unlink($dirname . DIRECTORY_SEPARATOR . $file);
      else
        delete_directory($dirname . DIRECTORY_SEPARATOR . $file);
    }
  }
  closedir($dir_handle);
  try {
    rmdir($dirname);
  }
  catch (\Exception $e) {
    return true;
  }
  return true;
}

function generateRandomVamCode($length = 10)
{
  $characters = '01234abcdefghijklmnopqrstuvwxyz56789';
  $charactersLength = strlen($characters);
  $randomString = '';
  $exist = true;
  while ($exist == true) {
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    $vam = \App\vam::where("code_followup", "=", $randomString)->first();
    if ($vam == null)
      $exist = false;
  }
  return $randomString;
}

function gethttplink($str)
{
  return str_replace(" ", "_", $str);
}

function getFullMenus()
{
  if (!session()->has('mega_menus')) {
    $session_name = "mega_menus";
    $fullMenu = [];
    $menus = Session::get($session_name);
    if ($menus == null) {
      $mega_menus = category::where("type", "=", "shop")->get();
      foreach ($mega_menus as $menu) {
        $sub_menus = category_middle::where("id_mega_category", "=", $menu->id)
          ->with(array('sub_category' => function ($query) {
            $query->select('id', 'class', 'id_category', 'title');
          }))->get();


        $array = [
          "mega" => $menu,
          "menu" => $sub_menus,
        ];
        array_push($fullMenu, $array);
      }

      Session::put($session_name, $fullMenu);
    } else
      $fullMenu = $menus;
    return $fullMenu;
  }
}

function getMenu($id)
{
  $mega_menu = "";
  $menus = "";
  $menu_info = category::where("id", "=", $id)->first();
  if ($menu_info != null) {
    if ($menu_info->type == "shop") {
      $mega_menu = $menu_info;
      $menus = category::where("id_mega_category", "=", $id)
        ->with(array('sub_category' => function ($query) {
          $query->select('id', 'class', 'id_category', 'title');
        }))->get();
    } elseif ($menu_info->type == "sub_shop") {
      $mega_menu = category::where("id", "=", $menu_info->id_mega_category)->first();
      $menus = category::where("id_mega_category", "=", $mega_menu->id)
        ->with(array('sub_category' => function ($query) {
          $query->select('id', 'class', 'id_category', 'title');
        }))->get();
    }
  } else {
    $sub_menu_info = category_sub::where("id", "=", $id)->first();
    if ($sub_menu_info != null) {
      $menu_info = category::where("id", "=", $sub_menu_info->id_category)->first();
      if ($menu_info->type == "shop") {
        $mega_menu = $menu_info;
        $menus = category::where("id_mega_category", "=", $id)
          ->with(array('sub_category' => function ($query) {
            $query->select('id', 'class', 'id_category', 'title');
          }))->get();
      } elseif ($menu_info->type == "sub_shop") {
        $mega_menu = category::where("id", "=", $menu_info->id_mega_category)->first();
        $menus = category::where("id_mega_category", "=", $mega_menu->id)
          ->with(array('sub_category' => function ($query) {
            $query->select('id', 'class', 'id_category', 'title');
          }))->get();
      }
    }
  }

  $menus_array = [
    "mega" => $mega_menu,
    "menu" => $menus,
  ];
//    $menus_array = array($mega_menu, $menus);
  return $menus_array;
}

function getAllCarts()
{


  $carts = \KasboomShop\Model\ChamberProductCart::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
  $result = [];
  $i = 0;
  $totalPricePayment = 0;
  $totalPrice = 0;
  $totalDiscount = 0;
  $totalTax = 0;
  $shippingCost = 0;
  foreach ($carts as $cart) {
    $discount = 0;
    $result[$i]['product_discount_price'] = 0;
    $result[$i]['id'] = $cart->id;
    $result[$i]['product_name'] = $cart->ChamberProduct->product_name;
    $result[$i]['product_count'] = $cart->chamber_product_cart_count;
    $result[$i]['product_color_name'] = isset($cart->color->name) ? $cart->color->name : '';
    $result[$i]['product_color_code'] = isset($cart->color->code) ? $cart->color->code : '';
    $result[$i]['product_inventory_count'] = $cart->ChamberProduct->product_count;
    $result[$i]['product_image'] = $cart->ChamberProduct->ChamberProductFirstImage();
    $result[$i]['product_price'] = $cart->ChamberProduct->product_price;

    if ($cart->ChamberProduct->product_have_discount == 1 && $cart->ChamberProduct->product_price_discount > 0) {
      $productPrice = $cart->ChamberProduct->product_price_discount;
      $discount = $cart->ChamberProduct->product_price - $cart->ChamberProduct->product_price_discount;
      $result[$i]['product_discount_price'] = $cart->ChamberProduct->product_price_discount;
    } else
      $productPrice = $cart->ChamberProduct->product_price;

    $totalDiscount += $discount * $cart->chamber_product_cart_count;

    $price = $productPrice * $cart->chamber_product_cart_count;
    if ($cart->ChamberProduct->Chamber->chamber_has_tax == 1)
      $totalTax += round($price * .09);

    $totalPrice += $cart->ChamberProduct->product_price * $cart->chamber_product_cart_count;
    $totalPricePayment += (($cart->ChamberProduct->product_price * $cart->chamber_product_cart_count) + $totalTax) - $totalDiscount;
    if (request()->get('shipping_type') > 0 ) {
      $shippingCost += $cart->ChamberProduct->getShippingPrice(request()->get('shipping_type'));
    }
    $i++;
  }

  Session::put('chamber_carts', $result);
  Session::put('chamber_carts_total_tax', $totalTax);
  Session::put('chamber_carts_count', $i);
  Session::put('chamber_carts_total_discount', $totalDiscount);
  $totalPricePayment = $shippingCost != -1 ? $totalPricePayment + $shippingCost : $totalPricePayment;
  Session::put('chamber_carts_total_price_with_discount', $totalPricePayment);

  Session::put('chamber_carts_shipping_cost', getShippingPrice($shippingCost));
  Session::put('chamber_carts_total_price', $totalPrice);
  Session::put('chamber_product_point', (new \KasboomShop\Model\ChamberProduct())->getProductPoint($totalPricePayment));
}

function getShippingPrice($shippingCost)
{
  $str='';
  if ($shippingCost == 0&& request()->get('shipping_type')=='')
    $str = 'مبلغ ارسال در مراحل بعدی محاسبه می شود';
  if ($shippingCost == -1)
    $str = 'رایگان';
  if ($shippingCost > 0)
    $str = $shippingCost . ' تومان ';

  return $str;
}

function fa_number($number)
{
//    if(!is_numeric($number) || empty($number))
//        return '۰';
  $en = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", ".", ",", ",");
  $fa = array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹", ".", ",", ",");
  return str_replace($en, $fa, $number);
}

function validateDate($date, $format = 'Y-m-d')
{
  $d = DateTime::createFromFormat($format, $date);
  // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
  return $d && $d->format($format) === $date;
}

function jalaliToMiladi($date)
{
  $ch='';
  if (strpos($date, '-') !== false) {
    $date = explode("-", tr_num($date));
    $ch='-';
  }
  elseif (strpos($date, '/') !== false) {
    $date = explode("/", tr_num($date));
    $ch='/';
  }

  $date = \Morilog\Jalali\jDateTime::toGregorian($date[0], $date[1], $date[2]);
  return implode($ch, $date);
}

function tr_num($str, $mod = 'en', $mf = '٫')
{
  $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.');
  $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', $mf);
  return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
}

function convert_to_number($string) {
  $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
  $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

  $num = range(0, 9);
  $convertedPersianNums = str_replace($persian, $num, $string);
  $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

  return $englishNumbersOnly;
}

function repairDate($str){
  try {
    $a = explode('/', $str);
    $year = (int)$a[0];
    $month = (int)$a[1];
    $day = (int)$a[2];
    if ($year < 100)
      $year = '13' . $year;
    if ($month < 10)
      $month = '0' . $month;
    if ($day < 10)
      $day = '0' . $day;

    $date = $year . '/' . $month . '/' . $day;
    return $date;
  }
  catch (\Exception $e) {
    return $str;
  }

}

function checkValidPhone($ph){
  $pishcode_09 = substr($ph, 0, 2);
  $pishcode_9891 = substr($ph, 0, 3);
  $pishcode_98091 = substr($ph, 0, 4);
  if($pishcode_09 =='09')
    return (int)$ph;
  elseif($pishcode_9891=='989')
    return substr($ph, 2);
  elseif($pishcode_98091=='9809')
    return substr($ph, 3);
  else
    return $ph;
}

function getIndexBook()
{
  $id_cat_book=69;
  $inedxBook = Session::get("indexBook");
  if ($inedxBook=='') {
    $inedxBook=blog::where("id_category","=",$id_cat_book)->where('status','=',1)
      ->select('id','title','regist_date','view_count','id_category')
      ->latest()
      ->take(4)
      ->get();
    Session::put("indexBook", $inedxBook);
  }
  return $inedxBook;

}

function getIndexBlog()
{
  $id_cat_book=69;
  $inedxBlog = Session::get("indexBlog");
  if ($inedxBlog== '') {
    $inedxBlog=blog::where("id_category","<>",$id_cat_book)->where('status','=',1)
      ->select('id','title','regist_date','code','like_count','regist_date','abstractMemo','image','view_count','id_category','code','cloud_url')
      ->latest()
      ->take(6)
      ->get();
    Session::put("indexBlog", $inedxBlog);
  }
  return $inedxBlog;

}


function sendSMS_Buyer($phonenumber, $receiver_name,$invoice_id,$payment_price ,$ref_id)
{
  try {
    $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
    $client = new Client();
    $text = " ثبت خرید ". "\n"." شماره سفارش: " .$invoice_id. "\n"." نام دریافت کننده: " .$receiver_name."\n"." مبلغ سفارش: ".$payment_price." تومان "."\n"." کد پیگیری پرداخت: ".$ref_id."\n\n". "https://Kasboom.ir";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phonenumber,
        'text' => $text,
        'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  }
  catch (\Exception $e) {
    return false;
  }
}


function getUserIp(Request $request){
  return $request->ip();
}

function checkValidIP($ip){
  $user_id=ip2long($ip);
  $low_ip=ip2long("172.16.1.1");
  $high_ip=ip2long("172.31.255.254");
  if ($user_id <= $high_ip && $user_id >=$low_ip) {
    return false;
  }
  else
    return true;
}

function getIdState($state_title){
  $state=state::where("name","=",$state_title)->first();
  if($state != null)
    return $state->id;
  else
    return 0;
}

function getIdCity($city_title,$id_state){
  $city=city::where("state_id","=",$id_state)->where("name","=",$city_title)->first();

  if($city != null)
    return $city->id;
  else
    return 0;
}


function getmystate ($fanistate){
  $state=0;
  switch ($fanistate) {
    case 1:
      return 1;
      break;
    case 2:
      return 2;
      break;
    case 3:
      return 3;
      break;
    case 4:
      return 4;
      break;
    case 5:
      return 6;
      break;
    case 6:
      return 7;
      break;
    case 7:
      return 8;
      break;
    case 8:
      return 9;
      break;
    case 9:
      return 10;
      break;
    case 10:
      return 11;
      break;
    case 11:
      return 12;
      break;
    case 12:
      return 13;
      break;
    case 13:
      return 14;
      break;
    case 14:
      return 15;
      break;
    case 15:
      return 16;
      break;
    case 16:
      return 17;
      break;
    case 17:
      return 18;
      break;
    case 18:
      return 19;
      break;
    case 19:
      return 20;
      break;
    case 20:
      return 21;
      break;
    case 21:
      return 22;
      break;
    case 22:
      return 23;
      break;
    case 23:
      return 24;
      break;
    case 24:
      return 25;
      break;
    case 25:
      return 26;
      break;
    case 26:
      return 27;
      break;
    case 27:
      return 28;
      break;
    case 28:
      return 29;
      break;
    case 29:
      return 30;
      break;
    case 30:
      return 31;
      break;
    case 31:
      return 5;
      break;
    default:
      return 0;

  }
}



function sendSMS_Register_subsid($name, $phone, $subsid){
//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n"."مبلغ ".$subsid." تومان هدیه آموزش به شما تعلق گرفت. از این مبلغ جهت تهیه دوره و وبینار آموزشی می توانید استفاده نمائید. "."\n\n". "کسبوم همراه شما در مسیر موفقیت";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phone,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }

  try{
    $url = "http://sms.rajat.ir/send_line.php";
    $client = new Client();
    $text =$name. " ارجمند " . "\n"."مبلغ ".$subsid." تومان هدیه آموزش به کیف پول شما در سامانه کسبوم واریز گردید "."\n\n";
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phone,
        'from' => 5000298645,
        'username' => 15835,
        'password' => 1583500,
        'text' => $text,
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  } catch (\Exception $e) {
    return false;
  }


}

function sendSMS_Register_persoanl($name, $phone) {
//   try {
//     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx";
//     $client = new Client();
//     $text =$name. " ارجمند " . "\n\n"." عضویت شما در خانواده بزرگ کسبوم را گرامی می داریم ";
//     $response = $client->request('POST', $url, [
//       'verify' => false,
//       'form_params' => [
//         'to' => $phone,
//         'text' => $text,
//         'signature' => "99CCFC60-9E24-4D72-908F-568FC56FA238",
//       ]
//     ]);
//     $status = $response->getStatusCode();
//     if ($status == 200)
//       return true;
//     else
//       return false;
//   }
//   catch (\Exception $e) {
//     return false;
//   }

  try{
    $url = "http://sms.rajat.ir/send_line.php";
    $client = new Client();
    $text =$name. " ارجمند " . "\n\n"." عضویت شما در خانواده بزرگ کسبوم را گرامی می داریم ";
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phone,
        'from' => 5000298645,
        'username' => 15835,
        'password' => 1583500,
        'text' => $text,
      ]
    ]);
    $status = $response->getStatusCode();
    if ($status == 200)
      return true;
    else
      return false;
  } catch (\Exception $e) {
    return false;
  }


}

if (!function_exists('arToFa')) {
    function arToFa($str, $num_to_en = true)
    {
        $str = str_replace(['ﺁ', 'ﺂ'], 'آ', $str);
        $str = str_replace(['ﺍ', 'ﺎ', 'إ', 'ﺇ', 'ﺈ', 'أ', 'ﺃ', 'ﺄ'], 'ا', $str);
        $str = str_replace(['ﺏ', 'ﺐ', 'ﺑ', 'ﺒ'], 'ب', $str);
        $str = str_replace(['ة', 'ﺓ', 'ﺔ', 'ﻩ', 'ﻪ', 'ﻫ', 'ﻬ'], 'ه', $str);
        $str = str_replace(['ﺕ', 'ﺖ', 'ﺗ', 'ﺘ'], 'ت', $str);
        $str = str_replace(['ﺙ', 'ﺚ', 'ﺛ', 'ﺜ'], 'ث', $str);
        $str = str_replace(['ﺝ', 'ﺞ', 'ﺟ', 'ﺠ'], 'ج', $str);
        $str = str_replace(['ﺡ', 'ﺢ', 'ﺣ', 'ﺤ'], 'ح', $str);
        $str = str_replace(['ﺥ', 'ﺦ', 'ﺧ', 'ﺨ'], 'خ', $str);
        $str = str_replace(['ﺩ', 'ﺪ'], 'د', $str);
        $str = str_replace(['ﺫ', 'ﺬ'], 'ذ', $str);
        $str = str_replace(['ﺭ', 'ﺮ'], 'ر', $str);
        $str = str_replace(['ﺯ', 'ﺰ'], 'ز', $str);
        $str = str_replace(['ﺱ', 'ﺲ', 'ﺳ', 'ﺴ'], 'س', $str);
        $str = str_replace(['ﺵ', 'ﺶ', 'ﺷ', 'ﺸ'], 'ش', $str);
        $str = str_replace(['ﺹ', 'ﺺ', 'ﺻ', 'ﺼ'], 'ص', $str);
        $str = str_replace(['ﺽ', 'ﺾ', 'ﺿ', 'ﻀ'], 'ض', $str);
        $str = str_replace(['ﻁ', 'ﻂ', 'ﻃ', 'ﻄ'], 'ط', $str);
        $str = str_replace(['ﻅ', 'ﻆ', 'ﻇ', 'ﻈ'], 'ظ', $str);
        $str = str_replace(['ﻉ', 'ﻊ', 'ﻋ', 'ﻌ'], 'ع', $str);
        $str = str_replace(['ﻍ', 'ﻎ', 'ﻏ', 'ﻐ'], 'غ', $str);
        $str = str_replace(['ػ', 'ؼ', 'ك', 'ﻙ', 'ﻚ', 'ﻛ', 'ﻜ'], 'ک', $str);
        $str = str_replace(['ؽ', 'ؾ', 'ؿ', 'ي', 'ى', 'ﻯ', 'ﻰ', 'ﯨ', 'ﯩ', 'ﻱ', 'ﻲ', 'ﻳ', 'ﻴ'], 'ی', $str);
        $str = str_replace(['ﻑ', 'ﻒ', 'ﻓ', 'ﻔ'], 'ف', $str);
        $str = str_replace(['ﻕ', 'ﻖ', 'ﻗ', 'ﻘ'], 'ق', $str);
        $str = str_replace(['ﻝ', 'ﻞ', 'ﻟ', 'ﻠ'], 'ل', $str);
        $str = str_replace(['ﻡ', 'ﻢ', 'ﻣ', 'ﻤ'], 'م', $str);
        $str = str_replace(['ﻥ', 'ﻦ', 'ﻧ', 'ﻨ'], 'ن', $str);
        $str = str_replace(['ﻭ', 'ﻮ', 'ؤ', 'ﺅ', 'ﺆ'], 'و', $str);
        $str = str_replace(['ﺉ', 'ﺊ', 'ﺋ', 'ﺌ'], 'ئ', $str);
        $str = str_replace(['ﺀ'], 'ء', $str);
        $str = str_replace(['‍'], '', $str); // remove &zwj;
        $str = str_replace(['‌' . ' ', ' ' . '‌'], ' ', $str); // (&zwnj; + space) or (space + &zwnj;) = space

        if ($num_to_en) {
            $num_en = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
            $num_fa = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
            $num_ar = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
            $str = str_replace($num_fa, $num_en, $str);
            $str = str_replace($num_ar, $num_en, $str);
        }

        return $str;
    }
}

if (!function_exists('nowDateShamsi')) {
    function nowDateShamsi($data = '')
    {
        $nowDate = $data == "" ? date("Y-m-d") : $data;
        $nowdateshamsi = jdate($nowDate)->format('%Y/%m/%d');
        return $nowdateshamsi;
    }
}

if (!function_exists('deleteDirectory')) {
    function deleteDirectory($dirname)
    {
        $slash = DIRECTORY_SEPARATOR;
        $dir_handle = '';
        $dirname = public_path($dirname);
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);

        if (!$dir_handle)
            return false;
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . $slash . $file))
                    unlink($dirname . $slash . $file);
                else
                    deleteDirectory($dirname . $slash . $file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }
}

?>
