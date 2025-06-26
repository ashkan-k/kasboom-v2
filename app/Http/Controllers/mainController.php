<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Models\category;
use App\Models\category_middle;
use App\Models\category_sub;
use App\Models\chatroom;
use App\Models\city;
use App\Models\classroom;
use App\Models\comment;
use App\Models\consult;
use App\Models\contact;
use App\Models\course;
use App\Models\discount;
use App\Models\faq;
use App\Models\hire;
use App\Models\invite;
use App\Models\kasboom_redirect;
use App\Models\KasboomCoupon;
use App\Models\lesson_attach;
use App\Models\live;
use App\Models\message;
use App\Models\payment;
use App\Models\news;
use App\Models\newsletter;
use App\Models\note;
use App\Models\partner;
use App\Models\lesson;
use App\Models\QuizICDL;
use App\Models\quiz;
use App\Models\quiz_question;
use App\Models\kasboomRedirect;
use App\Models\razmayesh_feedback;
use App\Models\state;
use App\Models\teacher;
use App\Models\teacher_education;
use App\Models\teh;
use App\Models\User;
use App\Models\user_favorite;
use App\Models\user_quiz;
use App\Models\webinar;
use App\Models\webinar_register;
use App\Models\wikiidea;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use SoapClient;
use App\lib\zarinpal;
use Illuminate\Support\Facades\DB;

class mainController extends Controller
{
  protected $accessdenide_response = [
    'error' => true,
    'data' => '',
    'message' => 'شما مجوز این عملیات را ندارید',
    'type' => 'error'
  ];

  public function index()
  {
    // $IndexBooks = getIndexBook();
    // $IndexBlog = getIndexBlog();
    return view("index");
  }

  public function redirect($path)
  {
    $redirect_path = kasboom_redirect::where("path", "=", $path)->first();
    if ($redirect_path != null)
      return redirect($redirect_path->redirect);
    else
      return view(404);
  }

  public function sign_mobile()
  {
    return view("sign_mobile");
  }

  public function faq()
  {
    $faqs = faq::all();
    return view("faq", compact("faqs"));
  }



  public function test()
  {
    $phoneNumber="09055165955";
    $name='حسن نجفی2';
    $code = 12345;
    $url = "http://sms.rajat.ir/send_line.php";
    $client = new Client();
    $text ="کد تایید کسبوم: " . $code;
    $text = $text."\n\n". "لغو ۱۱ ";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'to' => $phoneNumber,
        'from' => 5000298645,
        'fori' => 2,
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

//    $sender = "1000689696";
//    $receptor = "09055165955";
//    $message = ".وب سرویس پیام کوتاه کاوه نگار";
//    $api = new \Kavenegar \KavenegarApi("4D6236676A664A36724E52767576466661522B3371627A7539774A4F77364D4A72774E304364774A6862453D");
//    $api -> Send ( $sender,$receptor,$message);

//    $sender = "10006703323323";
//    $receptor = "09055165955";
//    $message = "وب سرویس تخصصی کاوه نگار ";
//    $api = new \Kavenegar\KavenegarApi("4D6236676A664A36724E52767576466661522B3371627A7539774A4F77364D4A72774E304364774A6862453D");
//    $api->Send($sender,$receptor,$message);

//  catch(\Kavenegar\Exceptions\ApiException $e){
    // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
//    echo $e->errorMessage();
//  }
//catch(\Kavenegar\Exceptions\HttpException $e){
//     در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
//    echo $e->errorMessage();
//  }

//    $webServiceURL       = "http://sms.parsgreen.ir/Api/SendSMS.asmx?WSDL";
//    $webServiceSignature = "FBA31667-4163-4961-A1C2-B48B931C6706";
//    $webServicemobile = "09055165955";
//    $webServiceLang = "fa";
//    $webServiceotpType = 2;
//    $webServicepatternId = 1;
//
//    $parameters['signature'] = $webServiceSignature;
//    $parameters['mobile'] = $webServicemobile;
//    $parameters['Lang'] = $webServiceLang;
//    $parameters['otpType'] = $webServiceotpType;
//    $parameters['patternId'] = $webServicepatternId;
//    $parameters['otpCode'] = 0x0;
//
////    try
////    {
//      $con = new SoapClient($webServiceURL);
//      $responseSTD = (array) $con ->SendOtp($parameters);
//      echo 'OutPut Method Value.............................=>';
//      echo '</br>';
//      echo  $responseSTD['SendOtpResult'];
//      echo '</br>';
//      echo 'OTP Code.............................=>';
//      echo '</br>';
//      echo $responseSTD['otpCode'];
//      echo '</br>';

//    }
//    catch (SoapFault $ex)
//    {
//      echo $ex->faultstring;
//    }

//    sendSMS_Tabliq($phoneNumber,$name);
//    sendSMS_Consult_Register("حسن", "مشاورم", "1399", $phoneNumber,"139","12313شسیش" ,100000);
//    sendSMS_Register_howzeh("حسن",$phoneNumber,"0919","تست");

//    Session::flush();

//    return view("test");
//    $cats = getCategory('course');
//    foreach ($cats as $cat) {
//      $courses = course::where('id_category', '=', $cat->id)->where("status", "=", 1)
//        ->select('id', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count')->get();
//      $sum_hours = $courses->sum('hour');
//      $sum_minutes = $courses->sum('minutes');
//      $total_register = $courses->sum('register_count');
//      $total_learn_time = ($sum_hours * 60) + $sum_minutes;
//      $cat->total_learn_time = $total_learn_time;
//      $cat->total_register = $total_register;
//    }
//    dd($cats);
//    return view("test");
  }


  public function pege404()
  {
    return view("404");
  }

  public function about()
  {

    $courses=Cookie::get('courses');
    if ($courses == null) {
      $courses = course::where('status', '=', 1)->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))->with(array('teacher' => function ($query) {
        $query->select('id', 'fullname');
      }))
        ->select('id', 'title', 'slug', 'image', 'price', 'hour', 'minutes','video_minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price','img_slider','img_slider_mobile','img_mini_banner','have_certificate','view_count')
        ->get();

      cookie('courses', $courses, 500);

    }

    $courses_count = $courses->count();
    $sum_hours = $courses->sum('hour');
    $sum_minutes = $courses->sum('minutes');
    $sum_video_minutes = $courses->sum('video_minutes');

    $total_learn_time = ($sum_hours * 60) + $sum_minutes+$sum_video_minutes;

    $teachers_count = teacher::where('status', '=', 1)->count();

    $student_count = classroom::count('id_user');

    $comments = comment::where("status", "=", 1)
      ->with(array('user' => function ($queryuser) {
        $queryuser->select('id', 'name', 'image');
      }))
      ->select('id', 'id_target', 'id_user', 'score', 'regist_date', 'comment')
      ->latest()
      ->get();

    return view("aboutus", compact('comments', 'teachers_count', 'courses_count', 'student_count', 'total_learn_time'));
  }

  public function contactus()
  {
    $message = "";
    $fullname = "";
    $email = "";
    $tel = "";
    $subject = "";
    $memo = "";

    return view("contactus", compact("message", "fullname", "email", "tel", "subject", "memo"));

  }

  public function tabliq($id_course)
  {
    set_time_limit(0);

    $users = User::where("sms", "=", 0)
      ->where("status", "=", 1)
      ->where("corp_type", "=", 'talabe')
      ->select('id', 'name', 'phonenumber','subsid')
      ->take(500)
      ->get();


    //$users = User::where("id", "=", 1)->get();

    foreach ($users as $user) {
      if (true) {
        // $class = webinar_register::where("id_user", "=", $user->id)->first();
        $class="dd";
        if ($class != null) {
          $status = sendSMS_Tabliq($user->phonenumber, $user->name,$user->subsid);
          if ($status == true) {
            User::where('id', '=', $user->id)
              ->update([
                'sms' => 1
              ]);
            echo $user->name . ' sms sended';
          } else
            echo $user->name . ' sms faild';

          echo "<br>";
        }
      }
    }

  }

  public function send_sms_webinar($id)
  {
    set_time_limit(0);
    $webinar=webinar::find($id);
    if($webinar)
    {
      $webinar_registers=webinar_register::where('id_webinar',$id)
        ->with([
          'user' => function ($query) {
            $query->select('id', 'name','phonenumber');
          }
        ])
        ->get();
    }

    foreach ($webinar_registers as $user) {
      $status = sendSMS_webinar($webinar->title,$user->user->phonenumber, $user->user->name, $user->user_url);
      if ($status == true) {
        User::where('id', '=', $user->id)
          ->update([
            'sms' => 1
          ]);
        echo $user->name . ' sms sended';
      } else
        echo $user->name . ' sms faild';

      echo "<br>";
    }
  }
  public function inform(Request $request)
  {
    $phone = $request->inform_mobile;
    $type = $request->inform_type;
    $user = newsletter::where('phonenumber', '=', $phone)->where("type", "=", $type)->first();
    if ($user == null) {
      $nowdate_shamsi = nowDate_Shamsi();

      $item = new newsletter();
      $item->phonenumber = $phone;
      $item->regist_date = $nowdate_shamsi;
      $item->type = $type;
      $item->save();


      return ($this->ajax_response(false, '', 'عضویت در خبرنامه پیامکی سایت انجام شد', 'success'));

    } else
      return ($this->ajax_response(true, '', 'عضویت شماره موبایل در خبرنامه پیامکی سایت قبلا انجام شد', 'error'));
  }

  public function getCity(Request $request)
  {
    $state = $request->state;
    $cities = city::where('state_id', $state)->get();
    $final = '';
    foreach ($cities as $city) {
      $id = $city['id'];
      $name = $city['name'];
      $final .= "<option value=$id>$name</option>";
    }

    return ($this->ajax_response(false, $final, '', 'success'));

  }

  public function send_message(Request $request)
  {

    if (Auth::check()) {
      $id = $request->id_target;
      $type = $request->type_target;
      $subject = $request->subject;
      $memo = $request->memo;

      $mess = new message();
      $mess->type = $type;
      $mess->id_target = $id;
      $mess->subject = $subject;
      $mess->message = $memo;
      $mess->id_owner = Auth::user()->id;
      $mess->regist_date = nowDate_Shamsi();
      $mess->read_status = 0;
      $mess->save();

      return ($this->ajax_response(false, '', 'پیام ارسال شد', 'success'));
    } else
      return ($this->ajax_response(true, '', 'شما مجوز دسترسی ندارید', 'error'));

  }

  public function get_message(Request $request)
  {
    $response = [];

    if (Auth::check()) {
      $message = "";
      $user = "";
      if (Auth::user()->isManager()) {
        $message = message::where("id", "=", $request->id)->first();
        $user = User::where("id", "=", $message->id_owner)->select("id", "name")->first();
        $response = [
          'error' => false,
          'message' => '',
          'type' => 'success',
          'data' => $message,
          'user' => $user
        ];
      } else {
        $user_type_target = Auth::user()->level;
        $column = 'id_' . $user_type_target;
        $user_id_target = 0;
        if ($column == "id_user")
          $user_id_target = Auth::user()->id;
        else
          $user_id_target = Auth::user()->$column;

//                $message = message::where("type", "=", $user_type_target)
//                    ->where("id_target", "=", $user_id_target)
//                    ->where("id", "=", $request->id)->first();

        $message = message::where("id", "=", $request->id)->first();


        if ($message != null) {
          $message->read_status = 1;
          $message->save();
          $user = User::where("id", "=", $message->id_owner)->select("id", "name")->first();
        }
        $response = [
          'error' => false,
          'message' => '',
          'type' => 'success',
          'data' => $message,
          'user' => $user
        ];
      }

      return response()->json($response);
    } else
      return response()->json($this->accessdenide_response);

  }

  public function all_messages(Request $request)
  {
    $request_id_target = $request->id_target;
    $request_type_target = $request->type_target;

    if (Auth::user()->isManager())
      $user = Session::get('user');
    else
      $user = Auth::user();

    $user_type_target = $user->getLevelUrl();
    $messages = "";
    if ($user_type_target == "teacher") {
      $courses = course::where("id_teacher", "=", $user->id_teacher)->select("id")->get();
      $messages = message::where("type", "=", "course")
        ->whereIn("id_target", $courses);
    } else {
      $wher = "(id_owner=" . $request_id_target . ")";
//            $wher="(type = '".$user_type_target."') and (id_target=".$request_id_target." or id_owner=".$request_id_target.")";
//            dd($wher);
      $messages = message::
      whereRaw($wher)
        ->get();
    }
//           $messages=message::where("type", "=", $user_type_target)->where("id_target", "=", $request_id_target)->orWhere("id_owner","=",$request_id_target);

    return Datatables::of($messages)
      ->addColumn('fullname', function ($row) {
        return $row->getUserName();
      })->make(true);
  }

  public function reply_message(Request $request)
  {
    if (Auth::check()) {
      $id_mess = $request->id_mess;
      $reply_message = $request->reply_message;
      $id_target = $request->id_target;

      $message = message::where("id", "=", $id_mess)->first();
      if ($message != null) {
        $message_id_target = $message->id_target;
        if (($message_id_target == $id_target) or (Auth::user()->isManager())) {
          $message->replay_message = $reply_message;
          $message->replay_date = nowDate_Shamsi();
          $message->read_status = 1;
          $message->save();

          return ($this->ajax_response(false, '', 'ارسال پاسخ پیام انجام شد', 'success'));
        }

      }
    } else
      return ($this->ajax_response(true, '', 'شما دسترسی مجاز را ندارید', 'error'));
  }

  public function get_comment(Request $request)
  {
    if (Auth::check()) {
      $comment = comment::where("id", "=", $request->id)->first();
      if (!Auth::user()->isManager()) {
        $comment->read_status = 1;
        $comment->save();
      }
      $user = "";
      if ($comment != null)
        $user = User::where("id", "=", $comment->id_user)->select("id", "name", "username")->first();
      $response = [
        'error' => false,
        'message' => '',
        'type' => 'success',
        'data' => $comment,
        'user' => $user
      ];

      return response()->json($response);
    } else
      return response()->json($this->accessdenide_response);

  }

  public function all_comment(Request $request)
  {

    $request_id_target = $request->id_target;
    $request_type_target = $request->type_target;
    $user_type_target = Auth::user()->getLevelUrl();

    if (($user_type_target == $request_type_target)) {
      return Datatables::of(message::where("type", "=", $user_type_target)->where("id_target", "=", $request_id_target))
        ->addColumn('fullname', function ($row) {
          return $row->getUserName();
        })->make(true);
    } else
      return "";
  }

  public function send_comment(Request $request)
  {
    if (Auth::check()) {
      $id_target = $request->id_target;
      $type = $request->type;
      $id_user = Auth::user()->id;
      $score = $request->comment_score;
      $comment_memo = $request->comment_memo;
      if ($score == null)
        $score = 3;

      $comment = new comment();
      $comment->type = $type;
      $comment->id_target = $id_target;
      $comment->id_user = $id_user;
      $comment->comment = $comment_memo;
      $comment->score = $score;
      $comment->regist_date = nowDate_Shamsi();
      $comment->read_status = 0;
      $comment->status = 0;
      $comment->save();

      return ($this->ajax_response(false, '', 'نظر شما ارسال و بعد از بررسی در سایت نمایش داده می شود', 'success'));

    } else
      return ($this->ajax_response(true, '', 'شما دسترسی مجاز را ندارید', 'error'));
  }

  public function inviteBySMS(Request $request)
  {
    $type = $request->type;
    $title = $request->title;
    $id_target = $request->id_target;
    $phoneNumber = $request->phonenumber;
    $news_letter = newsletter::where("phonenumber", "=", $phoneNumber)
      ->where("type", "=", $type)
      ->where("id_target", "=", $id_target)->count();

    if ($news_letter == 0) {
      $invite = new newsletter();
      $invite->id_target = $id_target;
      $invite->type = $type;
      $invite->phonenumber = $phoneNumber;
      $invite->regist_date = nowDate_Shamsi();
      $invite->save();

      if ($type == 'course') {
        $url = "kasboom.ir/skill/course/" . $id_target;
        sendSMS_Invite_Course($phoneNumber, $title, $url);
      }

      return $this->ajax_response(false, '', 'دعوت نامه ارسال گردید', 'success');

    } else
      return ($this->ajax_response(true, '', 'به این شماره قبلا دعوت نامه ارسال شده است', 'error'));


  }

  public function newsletter(Request $request)
  {
    $phonenumber = $request->phonenumber;
    $news_letter = newsletter::where("phonenumber", "=", $phonenumber)->first();
    if ($news_letter == null) {
      $letter = new newsletter();
      $letter->phonenumber = $phonenumber;
      $letter->regist_date = nowDate_Shamsi();
      $letter->save();

      sendSMS_NewsLetter($phonenumber);

      return ($this->ajax_response(false, '', 'عضویت شما در خبرنامه پیامکی کسب بوم انجام شد.', 'success'));
    } else
      return ($this->ajax_response(true, '', 'شماره وارد شده قبلا در خبرنامه پیامکی کسب بوم عضو شده است.', 'error'));
  }

  public function getMiddleCategory(Request $request)
  {
    $id_mega_category = $request->id_mega_category;
    $menus = category_middle::where("type", "sub_shop")->where("id_mega_category", $id_mega_category)->get();
    $final = '';
    foreach ($menus as $mn) {
      $id = $mn['id'];
      $name = $mn['title'];
      $final .= "<option value=$id>$name</option>";
    }

    return ($this->ajax_response(false, $final, 'عضویت در خبرنامه پیامکی پخش زنده کسب بوم انجام شد', 'success'));

  }

  public function getSubCategory(Request $request)
  {
    $id_middle_category = $request->id_middle_category;
    $menus = category_sub::where("id_category", "=", $id_middle_category)->get();
    $final = '';
    foreach ($menus as $mn) {
      $id = $mn['id'];
      $name = $mn['title'];
      $final .= "<option value=$id>$name</option>";
    }

    return ($this->ajax_response(false, $final, 'عضویت در خبرنامه پیامکی پخش زنده کسب بوم انجام شد', 'success'));
  }

  public function add_favorite(Request $request)
  {
    $id_target = $request->id_target;
    $type = $request->type;
    if (Auth::check()) {
      $nowDate = date("Y-m-d");
      $nowdate_shamsi = jdate($nowDate)->format('%Y/%m/%d');

      $image='';
      $title='';
      $code='';
      if($type=="course"){
        $course=course::where("id","=",$id_target)->select('image','code','title')->first();
        if($course != null){
          $image=$course->image;
          $title=$course->title;
          $code=$course->code;
        }
      }
      elseif($type=="webinar"){
        $webinar=webinar::where("id","=",$id_target)->select('image','code','title')->first();
        if($webinar != null){
          $image=$webinar->image;
          $title=$webinar->title;
          $code=$webinar->code;
        }
      }
      elseif($type=="consult"){
        $consult=consult::where("id","=",$id_target)->select('image','code','fullname')->first();
        if($consult != null){
          $image=$consult->image;
          $title=$consult->title;
          $code=$consult->code;
        }
      }
      $userfav = new user_favorite();
      $userfav->id_user = Auth::user()->id;
      $userfav->type = $type;
      $userfav->id_target = $id_target;
      $userfav->regist_date = $nowdate_shamsi;
      $userfav->image = $image;
      $userfav->title = $title;
      $userfav->code = $code;
      $userfav->save();

      return ($this->ajax_response(false, '', 'ثبت در علاقه مندی ها با موفقیت انجام شد', 'success'));

    } else
      return ($this->ajax_response(true, '', 'برای ثبت علاقه مندی وارد پنل خود در سایت شوید', 'error'));


  }

  public function remove_favorite(Request $request)
  {
    if (Auth::check()) {
      $usefav = user_favorite::where("id_user", "=", Auth::user()->id)
        ->where("type", "=", $request->type)
        ->where("id_target", "=", $request->id_target)
        ->delete();

      return ($this->ajax_response(false, '', 'حذف از علاقه مندی ها انجام شد', 'success'));
    } else
      return ($this->ajax_response(true, '', 'برای حذف علاقه مندی وارد پنل خود در سایت شوید', 'error'));
  }

  public function check_discount()
  {
    if (!Auth::check())
      return ($this->ajax_response(true, '', 'شما دسترسی به این بخش را ندارید', 'error'));

    $urlPrevious =  str_replace(url('/'), '', url()->previous());
    $urlPreviousArray = explode('/', $urlPrevious);
    $type = $urlPreviousArray[2];
    $id = $urlPreviousArray[3];
    $userId = auth()->user()->id;

    $coupon = $this->checkKasboomCoupon($type, $id, $userId);
    if($coupon['status'])
      return ($this->ajax_response(false, $coupon,'', 'success'));
    else
      return ($this->ajax_response(true, '', $coupon['message'], 'error'));
  }

  public function checkKasboomCoupon ($type, $id, $userId) {

    $coupons = KasboomCoupon::where([
      ['coupon_code', request()->discount],
      ['start_date', '<=', jdate()->format('Y/m/d')],
      ['end_date', '>=', jdate()->format('Y/m/d')],
      ['status', 1],
    ])->first();
    if (!$coupons)
      return ['status' => false, 'message' => 'کد تخفیف معتبر نمی باشد'];

//    check max_count
    if((int)$coupons->max_count === 0)
      return ['status' => false, 'message' => 'محدودیت استفاده از این کد به پایان رسیده است'];

//    check users id
    if(!is_null($coupons->users) && !in_array($userId, $coupons->users))
      return ['status' => false, 'message' => 'این کد تخفیف به شما تعلق نمی گیرد'];

//    check webinars id
    if($type === 'take_webinar') {
      if($coupons->for_webinar === 0)
        return ['status' => false, 'message' => 'این کد تخفیف به بخش وبینارها تعلق نمی گیرد'];

      if(!in_array($id, $coupons->webinars))
        return ['status' => false, 'message' => 'کد تخفیف به این وبینار تعلق نمی گیرد'];

      $skill = webinar::find($id);
      if($skill->price < $coupons->minimum_price)
        return ['status' => false, 'message' => "این کد تخفیف به وبیناری با قیمت بالاتر از $coupons->minimum_price تعلق می گیرد"];
    }

//    check courses id
    if($type === 'take_course') {
      if($coupons->for_course === 0)
        return ['status' => false, 'message' => 'این کد تخفیف به بخش دوره ها تعلق نمی گیرد'];

      if(!in_array($id, $coupons->courses))
        return ['status' => false, 'message' => 'کد تخفیف به این دوره تعلق نمی گیرد'];

      $skill = course::find($id);
      if($skill->price < $coupons->minimum_price)
        return ['status' => false, 'message' => "این کد تخفیف به دوره ای با قیمت بالاتر از $coupons->minimum_price تعلق می گیرد"];
    }

//    check buy_once_user
    if($coupons->buy_once_user) {
      if(in_array($userId, $coupons->users_use))
        return ['status' => false, 'message' => 'شما قبلا از این کد استفاده کرده اید و به شما تعلق نمی گیرد'];
    }

    if($coupons->type){
// count
      $discount = $coupons->type_value;
    } else {
// discount
      $discount = ( $skill->price * $coupons->type_value ) / 100;
    }

    return ['status' => true, 'discount' => $discount,'type_value' => $coupons->type_value];
  }


  public function send_ticket(Request $request)
  {
    $id_target = $request->id_target;
    $subject = $request->subject;
    $message = $request->message;
    $type = $request->type;
    $flag = true;
    $now_date = nowDate_Shamsi();
    if ($type == "course") {
      $classroom = classroom::where("id_user", "=", Auth::user()->id)
        ->where("id_course", "=", $id_target)->first();
      if ($classroom != null) {
        if ($now_date <= $classroom->ticket_date_to)
          $flag = true;
        else
          return ($this->ajax_response(true, '', 'مدت زمان شما برای پرسش از مدرس به اتمام رسیده است', 'error'));
      } else
        return ($this->ajax_response(true, '', 'ارسال پرسش فقط برای دوره های می باشد که ثبت نام نموده اید', 'error'));
    }

    if ($flag == true) {

      $attachFile = "";
      $file_type = "";
      if ($request->file('attach_file')) {
        $folderPath = "_upload_/_ticket_/" . $type . "/" . $id_target;
        $file = $request->file('attach_file');
        $file_type = $file->getClientOriginalExtension();
        $attachFile = uploadFile($file, $folderPath);
      }

      $mess = new message();
      $mess->type = $type;
      $mess->id_owner = Auth::user()->id;
      $mess->id_target = $id_target;
      $mess->subject = $subject;
      $mess->message = $message;
      $mess->regist_date = nowDate_Shamsi();
      $mess->replay_message = '';
      $mess->read_status = 0;
      $mess->replay_date = '';
      $mess->attach_file = $attachFile;
      $mess->filetype = $file_type;
      $mess->save();

      return ($this->ajax_response(false, '', 'ارسال پرسش انجام شد', 'success'));
    } else
      return ($this->ajax_response(true, '', 'خطا در ارسال پرسش', 'error'));

  }

  public function check_username(Request $request)
  {
    if (Auth::check()) {
      $username = $request->username;
      $user = User::where("username", "=", $username)->count();
      if ($user == 0)
        return ($this->ajax_response(false, '', 'نام کاربری قابل استفاده می باشد', 'success'));
      else
        return ($this->ajax_response(true, '', 'نام کاربری قبلا استفاده شده است', 'error'));
    } else
      return ($this->ajax_response(true, '', 'شما دسترسی مجاز را ندارید', 'error'));
  }

  public function contact(Request $request)
  {
    $fullname = $request->fullname;
    $email = $request->email;
    $tel = $request->tel;
    $subject = $request->subject;
    $memo = $request->memo;
    $contact = new contact();
    $contact->fullname = $fullname;
    $contact->phone = $tel;
    $contact->email = $email;
    $contact->subject = $subject;
    $contact->memo = $memo;
    $contact->regist_date = nowDate_Shamsi();
    $contact->status = 0;
    $contact->save();

    $message = "ثبت انجام شد";
    return view("contactus", compact("message", "fullname", "email", "tel", "subject", "memo"));
  }

  public function detail_message($id_message)
  {
    if (Auth::check()) {
      $message = message::where("id", "=", $id_message)->first();
      $user = User::where("id", "=", $message->id_owner)->select('id', 'name', 'username')->first();
      $userlevel = Auth::user()->getLevelUrl();
      return view($userlevel . ".detail_message", compact("message", "user"));
    } else
      return view("accessdenid");
  }

  public function public_search(Request $request)
  {
    // $type = $request->search_type;
    $type="course";
    $search_title = $request->search_title;
    if ($type == "course") {
      $cats = getCategory("course");

      $courses = course::where('status', '=', 1)
        ->where('title', 'like', '%' . $search_title . '%')
        ->orWhere('abstractMemo', 'like', '%' . $search_title . '%')
        ->with(array('category' => function ($query) {
          $query->select('id', 'title');
        }))
        ->with(array('teacher' => function ($query) {
          $query->select('id', 'fullname');
        }))
        ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'abstractMemo', 'score', 'discount', 'old_price')
        ->orderBy('id', 'desc')
        ->paginate(5);

      return view("course/course_list", compact('cats', 'courses'));

    } elseif ($type == "webinar") {
      $cats = getCategory("webinar");
      $webinars = webinar::where('status', '=', 1)
        ->where('title', 'like', '%' . $search_title . '%')
        ->orWhere('abstractMemo', 'like', '%' . $search_title . '%')
        ->with(array('category' => function ($query) {
          $query->select('id', 'title');
        }))
        ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'discount', 'abstractMemo', 'score', 'discount', 'old_price', 'capacity_register', 'teacher_name', 'webinar_date', 'webinar_start_time_hour', 'webinar_start_time_minutes', 'view_count', 'like_count', 'comment_count')
        ->orderBy('id', 'desc')
        ->paginate(5);

      return view("webinar/webinar_list", compact('cats', 'webinars'));
    } elseif ($type == "consult") {
      $cats = getCategory("consult");
      $consults = consult::where('status', '=', 1)
        ->where('fullname', 'like', '%' . $search_title . '%')
        ->with(array('category' => function ($query) {
          $query->select('id', 'title');
        }))
        ->select('id', 'fullname', 'id_category', 'image', 'consult_field', 'code', 'abstractAbout', 'score', 'view_count', 'consult_count', 'comment_count')
        ->orderBy('id', 'desc')
        ->paginate(5);
      return view("consult/consult_list", compact('cats', 'consults'));

    } elseif ($type == "product") {

    } elseif ($type == "chamber") {

    } elseif ($type == "wikiidea") {
      $cats = getCategory("idea");
      $ideas = wikiidea::where("status", "=", 1)
        ->where("title", "like", "%" . $search_title . "%")
        ->orwhere("abstractMemo", "like", "%" . $search_title . "%")
        ->select('id', 'title', 'image', 'code', 'minimal_fund', 'risk', 'profitability', 'id_category', 'abstractMemo', 'score', 'like_count', 'view_count', 'comment_count')
        ->paginate(5);

      return view("wiki/wiki_list", compact('cats', 'ideas'));
    } elseif ($type == "blog") {
      $cats = getCategory("blog");
      $blogs = blog::where("title", "like", "%" . $search_title . "%")
        ->orWhere("abstractMemo", "like", "%" . $search_title . "%")
        ->with(array('category' => function ($query) {
          $query->select('id', 'title');
        }))->with(array('writer' => function ($query) {
          $query->select('id', 'name', 'code', 'image', 'like_count', 'last_education', 'regist_date');
        }))->where('status', '=', '1')
        ->select('id', 'title', 'code', 'image', 'regist_date', 'view_count', 'comment_count', 'id_category', 'id_user', 'memo')
        ->orderBy('id', 'desc')
        ->take(10)
        ->paginate(6);


      $writers = User::wherein('id', function ($q) {
        $q->from('blogs')
          ->selectRaw('id_user')
          ->distinct('id_user');
      })->select('id', 'name', 'image', 'like_count', 'regist_date', 'last_education')->get();

      return view("blog/search_blogs", compact('blogs', 'cats', 'writers'));
    } elseif ($type == "hire") {
      $hires = hire::where("title", "like", "%" . $search_title . "%")
        ->where('status', '=', 1)
        ->select('id', 'image', 'title')->get();
      return view('hire/hire_list', compact('hires'));
    } elseif ($type == "live") {
      $lives = live::where("title", "like", "%" . $search_title . "%")->select("id", "code", "title", "image", "teacher_name", "status", "regist_date")->get();
      return view("live.lives", compact("lives"));
    }
  }

  public function shopp()
  {
    return view('chamber.testshop');
  }

  public function help()
  {
    return view("help");
  }

  public function comming()
  {
    $referer = request()->headers->get('referer');
    return view("comming", compact("referer"));
  }

  public function send_sms(Request $request)
  {
    $token = env('_token');
    $sms_type = $request->type;
    $phoneNumber = $request->phone;
    $_token = $request->_token;

    if ($_token == $token) {
      $data = json_decode($request->data);

      $status = false;
      if ($sms_type == 'login') {
        $loginCode = $data->logincode;
        $status = sendSMS_Login($phoneNumber, $loginCode);
      } elseif ($sms_type == 'verify_technical') {
        $name = $data->name;
        $username = $data->username;
        $status = sendSMS_verify_technical($phoneNumber, $name, 0, $username);
      } elseif ($sms_type == 'register') {
        $name = $data->name;
        $loginCode = $data->logincode;
        $status = sendSMS_Register($name, $phoneNumber, $loginCode);
      } elseif ($sms_type == 'register') {
        $name = $data->name;
        $loginCode = $data->logincode;
        $status = sendSMS_Register($name, $phoneNumber, $loginCode);
      } elseif ($sms_type == 'register_howzeh') {
        $name = $data->name;
        $username = $data->username;
        $message = $data->message;
        $status = sendSMS_Register_howzeh($name, $phoneNumber, $username, $message);
      } elseif ($sms_type == 'followup') {
        $name = $data->name;
        $followup = $data->followup;
        $status = sendSMS_vam_followup($name, $phoneNumber, $followup);
      } elseif ($sms_type == 'newsLetter') {
        $status = sendSMS_NewsLetter($phoneNumber);
      } elseif ($sms_type == 'inviteTeacher') {
        $name = $data->name;
        $status = sendSMS_InviteTeacher($phoneNumber, $name);
      } elseif ($sms_type == 'course_quiz') {
        $name = $data->name;
        $title = $data->title;
        $score = $data->score;
        $nowdate = $data->date;
        $status = sendSMS_Course_Quiz($name, $title, $score, $nowdate, $phoneNumber);
      } elseif ($sms_type == 'course_register') {
        $name = $data->name;
        $title = $data->title;
        $nowdate = $data->date;
        $RefID = $data->RefID;
        $factor_id = $data->factor_id;
        $payment_price = $data->payment_price;
        $status = sendSMS_Course_Register($name, $title, $nowdate, $phoneNumber, $RefID, $factor_id, $payment_price);
      } elseif ($sms_type == 'webinar_register') {
        $name = $data->name;
        $title = $data->title;
        $username = $data->username;
        $webinar_date = $data->date;
        $refID = $data->RefID;
        $url = $data->url;
        $payment_price = $data->payment_price;
        $status = sendSMS_Webinar_Register($name, $username, $title, $webinar_date, $phoneNumber, $refID, $payment_price, $url);
      } elseif ($sms_type == 'consult_register') {
        $name = $data->name;
        $fullname = $data->fullname;
        $nowdate = $data->date;
        $RefID = $data->RefID;
        $factor_id = $data->factor_id;
        $payment_price = $data->payment_price;
        $status = sendSMS_Consult_Register($name, $fullname, $nowdate, $phoneNumber, $RefID, $factor_id, $payment_price);
      } elseif ($sms_type == 'consultingTime') {
        $user_name = $data->name;
        $consult_name = $data->consult_name;
        $consult_date = $data->date;
        $consult_time = $data->consult_time;
        $status = sendSMS_ConsultingTime($user_name, $consult_name, $phoneNumber, $consult_date, $consult_time);
      } elseif ($sms_type == 'hire_register') {
        $name = $data->name;
        $title = $data->title;
        $nowdate = $data->date;
        $RefID = $data->RefID;
        $factor_id = $data->factor_id;
        $payment_price = $data->payment_price;
        $status = sendSMS_Hire_Register($name, $title, $nowdate, $phoneNumber, $RefID, $factor_id, $payment_price);
      } elseif ($sms_type == 'inviteLive') {
        $status = sendSMS_InviteLive($phoneNumber);
      } elseif ($sms_type == 'hire_register') {
        $name = $data->name;
        $title = $data->title;
        $nowdate = $data->date;
        $RefID = $data->RefID;
        $factor_id = $data->factor_id;
        $payment_price = $data->payment_price;
        $status = sendSMS_Hire_Register($name, $title, $nowdate, $phoneNumber, $RefID, $factor_id, $payment_price);
      }
      if ($status == true)
        return ($this->ajax_response(!$status, '', 'ارسال پیامک انجام شد', 'success'));
      else
        return ($this->ajax_response(!$status, '', 'ارسال پیامک انجام نشد', 'error'));

    } else
      return ($this->ajax_response(false, '', 'عدم دسترسی', 'error'));

  }

  public function work_with_us()
  {
    return view("work-with-us");
  }

  public function invite_teacher()
  {
    $states=getState();
    return view('invite_teacher',compact('states'));
  }

  public function course_suggestion()
  {
    $states = getState();
    return view("course_suggestion", compact("states"));
  }

  public function sign_tech()
  {
    return redirect("web");
  }

  public function message()
  {
    $title="";
    $message="";

  }

  public function amar(){
    $users =classroom::where("status", "=", 1)
      ->with(array('user' => function ($queryuser) {
        $queryuser->select('id', 'id_state','name')
          ->with(array('state' => function ($queryuser) {
            $queryuser->select('id', 'name');
          }));
      }))
      ->select('id', 'id_user', 'id_course')
      ->get();

    $col=collect([['nn' =>0]]);
    $col=['n' =>0];
    dd($col);
    $state[][]=0;
    foreach ($users as $user){
      $state_name=$user->user->state->name;
      if($state[$state_name]==null)
        $state[$state_name]=0;


      $state[$state_name]=$state[$state_name][0]+1;
//      dd($user->user->state->name);
//      $state[$user->user->id_state][]=
    }
    dd($state);
  }

  public function update_page()
  {
    return view("update");
  }


  public function sky()
  {
    $client = new Client();

    $sky_key = "apikey-5845155-13-875a205316f999ab613c46dee747eaf3";
    $url = "https://www.skyroom.online/skyroom/api/".$sky_key;

    $response = $client->request('POST', $url, [
      'verify' => false,
      'json' => [
        'action' => 'getRoom',
        'params' => [
          'name' => 'leather'
        ]
      ]
    ]);
    if ($response->getStatusCode() == 200) {
      $response_data = json_decode($response->getBody());
      $room_id=$response_data->result->id;
      $user_id=Auth::user()->id;
      $nickname=Auth::user()->firstname.' '.Auth::user()->lastname;
      $access= 1;
      $concurrent=1;
      $language="fa";
      $ttl=2000000;

      $response_login = $client->request('POST', $url, [
        'verify' => false,
        'json' => [
          'action' => 'createLoginUrl',
          'params' => [
            'room_id' => $room_id,
            'user_id' => $user_id,
            'nickname' => $nickname,
            'access' => $access,
            'concurrent' => $concurrent,
            'language' => $language,
            'ttl' => $ttl
          ]
        ]
      ]);

      if ($response_login->getStatusCode() == 200) {
        $response_data_login = json_decode($response_login->getBody());
        $user_sky_url=$response_data_login->result;
        dd($user_sky_url);
      }

    }


  }

  public function exhibition()
  {
    $webinars = webinar::where("status","=",1)->where("type","=",0)
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))

      ->get()
      ->sortByDesc('status')
      ->sortBy('webinar_date');

    $webinars_kasb = webinar::where("status","=",1)->where("type","=",1)
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))

      ->get()
      ->sortByDesc('status')
      ->sortBy('webinar_date');

    $courses = course::where('status', '=', 1)->with(array('category' => function ($query) {
      $query->select('id', 'title');
    }))->with(array('teacher' => function ($query) {
      $query->select('id', 'fullname');
    }))
      ->select('id', 'title', 'image', 'price', 'hour', 'minutes','video_minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price','img_slider','img_slider_mobile','img_mini_banner','have_certificate','view_count')
      ->get()
      ->sortByDesc('id');



    $webinar_register=webinar_register::where("id",">",23)->count();
    return view("exhibition.index",compact('webinars','webinars_kasb','courses','webinar_register'));
  }

  public function vtour()
  {
    return view('exhibition.tour');
  }

  public function changeurl()
  {
    $id_webinar=1;
    $classname="chador";
    $client = new Client();
    $sky_key = "apikey-5845155-13-875a205316f999ab613c46dee747eaf3";
    $sky_url = "https://www.skyroom.online/skyroom/api/".$sky_key;
    $user_sky_url='';

    $webinar_registers=webinar_register::where("id_webinar","=",$id_webinar)->get();
    foreach ($webinar_registers as $webinar){
      $urls=$webinar->user_url;
      $arrs=explode("/",$urls);
      $user_url=$arrs[4];
      $id_user=$webinar->id_user;
      $redirect=kasboom_redirect::where("path","=",$user_url)->first();
      if($redirect != null){
        $user=User::where("id","=",$id_user)->first();


        $response = $client->request('POST', $sky_url, [
          'verify' => false,
          'json' => [
            'action' => 'getRoom',
            'params' => [
              'name' => $classname
            ]
          ]
        ]);

        if ($response->getStatusCode() == 200) {
          $response_data = json_decode($response->getBody());
          $room_id=$response_data->result->id;
          $user_id=$user->id;
          $nickname=$user->firstname.' '.$user->lastname;
          if($nickname == null || $nickname =='' || strlen($nickname)<3)
            $nickname=$user->name;

          if($nickname == null || $nickname =='' || strlen($nickname)<3)
            $nickname=$user_id;

          $access= 1;
          $concurrent=1;
          $language="fa";
          $ttl=2000000;

          $response_login = $client->request('POST', $sky_url, [
            'verify' => false,
            'json' => [
              'action' => 'createLoginUrl',
              'params' => [
                'room_id' => $room_id,
                'user_id' => $user_id,
                'nickname' => $nickname,
                'access' => $access,
                'concurrent' => $concurrent,
                'language' => $language,
                'ttl' => $ttl
              ]
            ]
          ]);

          if ($response_login->getStatusCode() == 200) {
            $response_data_login = json_decode($response_login->getBody());
            $user_sky_url=$response_data_login->result;

            $redirect->redirect=$user_sky_url;
            $redirect->save();
          }

        }
      }
    }

  }

  public function feedback()
  {
    $message="";
    return view('exhibition.comment',compact('message'));
  }

  public function regist_feedback(Request $request)
  {
    $phone=$request->phone;
    $f1=$request->f1;
    $f2=$request->f2;
    $f3=$request->f3;
    $f4=$request->f4;
    $f5=$request->f5;
    $f6=$request->f6;
    $f7=$request->f7;
    $f8=$request->f8;
    $f9=$request->f9;
    $comment=$request->comment;

    $isexist=0;
    if($phone != null) {
      $phone = checkValidPhone($phone);
      $isexist=razmayesh_feedback::where("phonenumber","=",$phone)->count();
    }

    if($isexist==0) {
      $feed = new razmayesh_feedback();
      $feed->phonenumber = $phone;
      $feed->f1 = $f1;
      $feed->f2 = $f2;
      $feed->f3 = $f3;
      $feed->f4 = $f4;
      $feed->f5 = $f5;
      $feed->f6 = $f6;
      $feed->f7 = $f7;
      $feed->f8 = $f8;
      $feed->f9 = $f9;
      $feed->comment = $comment;
      $feed->save();
      return view('exhibition.comment_ok');

    }
    else {
      $message="باشماره فوق قبلا نظر ثبت شده است";
      return view('exhibition.comment',compact('message'));
    }


  }

  public function qore()
  {
    return view('qore');
  }

  public function subsid()
  {
    $courses_query = course::where('status', '=', 1)->with(array('category' => function ($query) {
      $query->select('id', 'title');
    }))->with(array('teacher' => function ($query) {
      $query->select('id', 'fullname');
    }))
      ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'video_minutes','s_talabe','price','s_markaz', 'id_category', 'cloud_url', 'cloud_json_url', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'abstractMemo', 'view_count');

    $courses = $courses_query->get()->sortByDesc('id');


    $webinars = webinar::where("status", ">=", 1)->where("type", "=", 5)->get();
    return view('subsid',compact('courses','webinars'));
  }

  public function change($id_course,$id_teacher)
  {
    $teacher= User::where("id",$id_teacher)->first();
    $teacher_total_income=$teacher->total_income;
    $teacher_wallet=$teacher->wallet;
    $payments=Payment::where("payment_for","course")->where("id_target",$id_course)->where("regist_date" ,">=","1401/11/01")->where("status",1)->get();

    $all_m=0;
    foreach($payments as $payment)
    {
      $teacher_payment=$payment->teacher_payment;
      if($teacher_payment>0) {
        $new_teacher_payment = round($teacher_payment / 2);
        $teacher_total_income = $teacher_total_income - $new_teacher_payment;
        $teacher_wallet = $teacher_wallet - $new_teacher_payment;
        $all_m=$all_m+$new_teacher_payment;

        $payment->teacher_payment=$new_teacher_payment;
        $payment->save();
      }
    }


    $teacher->total_income=$teacher_total_income;
    $teacher->wallet = $teacher_wallet;
    $teacher->save();

    dd($all_m);
  }

  public function yarane() {
    return view('yarane');
  }



  public function icdl()
  {

    $datas = QuizICDL::groupBy('state')
      ->select('state', DB::raw('count(*) as count'))
      ->where("status","payment")
      ->orderby('state')
      ->get()
      ->toArray();


    $states=state::all();
    return view("icdl",compact('states','datas'));
  }

  public function quiz_icdl()
  {

    if(request()->state == null)
    {
      $datas = QuizICDL::groupBy('state')
        ->select('state', DB::raw('count(*) as count'))
        ->where("status","payment")
        ->orderby('state')
        ->get()
        ->toArray();


      $states=state::all();
      $message="لطفا استان مرکز آزمون را انتخاب نمائید";
      return view("icdl",compact('message','states','datas'));
    }
    $Description = 'ثبت نام آزمون ICDL  ' .
      $Email = Auth::user()->email;
    $Mobile = Auth::user()->phonenumber;
    $CallbackURL = url('quiz-icdl/verifyPayment'); // Required
//    $CallbackURL = 'http://localhost/kasboom/public_html/quiz-icdl/verifyPayment'; // Required
    $order = new zarinpal();
    $res = $order->pay(50000, $Email, $Mobile, $Description, $CallbackURL);

    if ($res != false) {
      $payment = new QuizICDL();
      $payment->user_id = Auth::user()->id;
      $payment->user_name = Auth::user()->firstname." ".Auth::user()->lastname;
      $payment->state = request()->state;
      $payment->regist_date = nowDate_Shamsi();
      $payment->authority = $res;
      $payment->refID = "0";
      $payment->status = "wait_payment";
      $payment->save();
    }
    return redirect('https://www.zarinpal.com/pg/StartPay/' . $res);
  }

  public function verifyPaymentICDL(Request $request)
  {
    $MerchantID = 'e7d6f566-c2e1-4fbe-9473-7ac3567a3944';
    $Authority = $request->get('Authority');
    $payment_price = 50000;
    $states=state::all();
    $datas = QuizICDL::groupBy('state')
      ->select('state', DB::raw('count(*) as count'))
      ->where("status","payment")
      ->orderby('state')
      ->get()
      ->toArray();


    @mkdir(storage_path('payment' . DIRECTORY_SEPARATOR . date('Y-m-d')));
    $file = storage_path('payment' . DIRECTORY_SEPARATOR . date('Y-m-d') . DIRECTORY_SEPARATOR . $Authority . '.txt');
    file_put_contents($file, json_encode($_GET) . "\n", FILE_APPEND);

    $payment = QuizICDL::where("authority", "=", $Authority)->first();
    if(!$payment) {
      $message="Authority not found";
      return view('icdl', compact('message','states','datas'));
    }

    if ($request->get('Status') != 'OK') {
      $message="خطا در پرداخت";
      return view('icdl', compact('message','states','datas'));
    }

    $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
    $result = $client->PaymentVerification(
      [
        'MerchantID' => $MerchantID,
        'Authority' => $Authority,
        'Amount' => $payment_price,
      ]
    );

    if (!empty($result))
      file_put_contents($file, json_encode($result) . "\n", FILE_APPEND);

    if (!empty($result) and (($result->Status == 101) or ($result->Status == 100) or ($result->Status == 'OK') )) {
      $RefID = $result->RefID;

      if (!Auth::check()) {
        $message = "ابتدا به حساب کاربری خود وارد شوید";
        return view('icdl', compact('message','states','datas'));
      }

      $payment->status = "payment";
      $payment->refID = $RefID;
      $payment->save();

      $message="پرداخت شما با موفقیت انجام شد و رزور آزمون قطعی شد."."\n"."کد پرداخت:".$RefID;
//        sendSMS_ICDL_Register($user->name, $course_info->title, $nowdate, $user->phonenumber, $RefID, $factor, $payment_price);
      return view('icdl', compact('message','states','datas'));
    } else {
      $message = "پرداخت ناموفق";
      return view('icdl', compact('message','states','datas'));
    }
  }

}
