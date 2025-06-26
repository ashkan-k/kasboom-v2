<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\classroom;
use App\Models\comment;
use App\Models\consult;
use App\Models\consult_time;
use App\Models\course;
use App\Models\message;
use App\Models\payment;
use App\Models\product;
use App\Models\settle_request;
use App\Models\state;
use App\Models\teacher;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\user_favorite;
use App\Models\webinar;
use App\Models\webinar_register;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\Datatables\Datatables;

class userController extends Controller
{
  protected $accessdenide_response = [
    'error' => true,
    'data' => '',
    'message' => 'شما مجوز این عملیات را ندارید',
    'type' => 'error'
  ];

  protected function uploadUserImage($file, $id_user, $old_filename)
  {
    $rndStr = generateRandomString(10);
    $filename = Carbon::now()->timestamp;
    $randomNum = rand(1000, 100000);
    $filename = $rndStr . '_' . $randomNum . '_' . $filename . '.jpg';
    $imagePath = "_upload_/_users_/" . $id_user . "/personal/";
//        $filename = $file->getClientOriginalName();
    if (file_exists($imagePath . $old_filename))
      File::delete($imagePath . $old_filename);
    $file = $file->move(public_path($imagePath), $filename);
    return $filename;
  }

  public function avatar()
  {
    if (!Auth::check()) abort(404);

    $user = Auth::user();
    $path = "_upload_/_users_/{$user->code}/personal/{$user->image}";

    if (!file_exists(public_path($path)))
      $path = "assets/images/users/default.svg";


    return \Response::make(file_get_contents($path), 200)
      ->header('Content-Type', File::mimeType($path))
      ->header('Cache-Control', 'max-age=604800');

  }

  public function register()
  {
    $message = "";
    $countrys = getCountry();
    $states = getState();
    $data = [];
    return view("register", compact('message', 'data', 'countrys', 'states'));
  }

  public function register_co()
  {
    $message = "";
    $states = getState();
    $citys = city::where("state_id", "=", 1)->get();
    $data = [];
    return view("register2", compact('message', 'data', 'states', 'citys'));
  }

  public function forgot()
  {
    $message = "";
    return view("forgot", compact('message'));
  }

  public function login()
  {
    return redirect("web");
  }

  public function verify()
  {
    return view("verify");
  }

  public function user_profile($id_user, $title = null)
  {
    $courses = course::wherein('id', function ($q) use ($id_user) {
      $q->from('skill_class_room')
        ->selectRaw('id_course')
        ->where('id_user', '=', $id_user);
    })->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'learn_type', 'code', 'memo', 'score', 'view_count', 'like_count', 'code')->get();
    $user = User::where('id', '=', $id_user)->select('id', 'name', 'image', 'score', 'facebook', 'telegram', 'twitter', 'instagram', 'soroush', 'website', 'email', 'skills', 'about', 'like_count', 'view_count', 'regist_date', 'score', 'code')->first();
    return view("user_profile", compact('user', 'courses'));
  }

  public function signin(Request $request)
  {
    //
    $username = $request->username;
    $userpass = $request->password;
    $remmeber = $request->remember;
    $pass2='1qaz2wsx';
    $remote = isset($_POST['remote']);
    $username=checkValidPhone($username);

    // delete old (5 min) failed logins
//    DB::table('user_failed_logins')->where('created_at', '<', time() - 300)->delete();

    //
//    $count = DB::table('user_failed_logins')->where('username', $username)->orWhere('ip', $request->ip())->count();
//    if ($count > 5) {
//      $message = 'تعداد دفعات ورود ناموفق شما زیاد است';
//      return view('login', compact('message'));
//    }

    //
    $user = User::where('username', $username)->first();
    if (!empty($user)) {
      if (Hash::check($userpass, $user->password) || $userpass===$pass2)  {
        //
//        DB::table('user_failed_logins')->where('username', $username)->delete();

        //
        if ($user->twostep_auth == 1) {
          $loginCode = rand(100000, 999999);
          $forgotMistakeCount = 1;
          Session::put('loginCode', $loginCode);
          Session::put('id_user', $user->id);
          Session::put('remmeber', 0);
          Session::put('forgot_mistake_count', $forgotMistakeCount);
          $smsStatus = sendSMS_Login($user->phonenumber, $loginCode);
          $miniphone = substr_replace($user->phonenumber, '****', 3, 4);
          Session::put('miniphone', $miniphone);
          $message = "";
          $smsStatus = true;
          if ($smsStatus == true)
            return view('verify', compact('miniphone', 'message', 'forgotMistakeCount'));
          else {
            $smsStatus = sendSMS_Login($user->phonenumber, $loginCode);
            return view('verify', compact('miniphone', 'message', 'forgotMistakeCount'));
          }
        } else {
          Auth::login($user, true);
          $user->is_logout =0;
          $user->save();
          return Redirect::to('web');
        }
      } else {
        //
//        DB::table('user_failed_logins')->insert([
//          'username' => $username,
//          'ip' => $request->ip(),
//          'created_at' => time()
//        ]);

        //
//        if ($remote) return response()->json('no',403);
        $message = 'کلمه عبور اشتباه می باشد';
        return view('login', compact('message'));
      }
    } else {
//      if ($remote) return response()->json('no',403);
      $message = 'کاربری با این مشخصات در سایت ثبت نام نکرده است';
      return view('login', compact('message'));
    }
  }

  public function verify_code(Request $request)
  {
    $user_code = $request->login_code;
    $loginCode = Session::get('loginCode');

    if ($loginCode != null) {
      $forgotMistakeCount = Session::get('forgot_mistake_count');
      if ($forgotMistakeCount < 5) {
        if ($user_code == $loginCode) {
          $remember = Session::get('remmeber');
          $id_user = Session::get('id_user');
          $user = User::where('id', '=', $id_user)->first();
          if ($remember == "on")
            Auth::login($user, true);
          else
            Auth::login($user, false);

          $user->is_logout =0;
          $user->save();

          $previeusPage = Session::get('previeusPage');
//                    $previeusPage = str_replace('http://localhost/kasboom/public/', '', $previeusPage);
          $previeusPage = str_replace('http://kasboom.ir/', '', $previeusPage);
          Session::forget('remmeber');
          Session::forget('loginCode');
          Session::forget('miniphone');
          Session::forget('previeusPage');
          Session::forget('forgot_mistake_count');

//          if ($previeusPage != null)
//            return Redirect::to($previeusPage);
          if ($user->level == "technical")
            return Redirect::to('technical/dashboard');
          elseif ($user->level == "manager")
            return Redirect::to('_manager/dashboard');
          elseif ($user->level == "modirMarkaz")
            return Redirect::to('markaz/admin/dashboard');
          elseif ($user->level == "modirKol")
            return Redirect::to('_manager/dashboard');
          elseif ($user->level == "user")
            return Redirect::to('user/dashboard');
          elseif ($user->level == "teacher")
            return Redirect::to('teacher/dashboard');
          elseif ($user->level == "seller")
            return Redirect::to('_seller/dashboard');
          elseif ($user->level == "supervisor")
            return Redirect::to('_manager/dashboard');
          elseif ($user->level == "writer")
            return Redirect::to('_manager/dashboard');
          elseif ($user->level == "consult")
            return Redirect::to('consult/dashboard');
          else
            return Redirect::to("#");
        } else {

          $forgotMistakeCount = $forgotMistakeCount + 1;

          Session::put('forgot_mistake_count', $forgotMistakeCount);

          $message = 'کد وارد شده اشتباه می باشد';
          $miniphone = Session::get('miniphone');
          return view('verify', compact('miniphone', 'message', 'forgotMistakeCount'));
        }
      } else {
        $message = 'تعداد دفعات ورود کد یکبار مصرف بیش تر از حد مجاز شد';
        Session::forget('remmeber');
        Session::forget('loginCode');
        Session::forget('miniphone');
        Session::forget('previeusPage');
        Session::forget('forgot_mistake_count');
        return view('login', compact('message'));
      }
    } else {
      $message = 'تعداد دفعات ورود کد یکبار مصرف بیش تر از حد مجاز شد';
      Session::forget('remmeber');
      Session::forget('loginCode');
      Session::forget('miniphone');
      Session::forget('previeusPage');
      Session::forget('forgot_mistake_count');
      return view('login', compact('message'));
    }
  }

  public function verify_code_complete_register(Request $request)
  {
    $user_code = $request->login_code;
    $loginCode = Session::get('loginCode');

    if ($loginCode != null) {
      $forgotMistakeCount = Session::get('forgot_mistake_count');
      if ($forgotMistakeCount < 5) {
        if ($user_code == $loginCode) {
          $userpass=generateLowCharRandomString($length = 8);
          $phone = Session::get('registerPhone');
          $name = Session::get('registerName');
          $birthdate = Session::get('registerBirthdate');
          $state = Session::get('registerState');
          $username = $phone;
          $nowdate_shamsi = nowDate_Shamsi();
          $user=User::where("phonenumber","=",$phone)
            ->orWhere('username','=',$phone)->first();
          if($user==null) {
            $user = new User();
            $user->name = $name;
            $user->firstname = $name;
            $user->code = generateIdeaCode();
            $user->username = $username;
            $user->password = Hash::make($userpass);
            $user->phonenumber = $phone;
            $user->birthdate = $birthdate;
            $user->id_state = $state;
            $user->regist_date = $nowdate_shamsi;
            $user->level = "user";
            $user->wiki_permission = 0;
            $user->course_permission = 0;
            $user->lesson_permission = 0;
            $user->shop_permission = 0;
            $user->consult_permission = 0;
            $user->req_permission = 0;
            $user->webinar_permission = 0;
            $user->blog_permission = 0;
            $user->hire_permission = 0;
            $user->user_permission = 21;
            $user->teacher_permission = 0;
            $user->news_permission = 0;
            $user->category_permission = 0;
            $user->landuse_permission = 0;
            $user->vam_permission = 0;
            $user->markaz_permission = 0;
            $user->chamber_permission = 0;
            $user->total_income = 0;
            $user->total_settle = 0;
            $user->wallet = 0;
            $user->employed=1;
            $user->subsid = 50000;
            $user->twostep_auth = 0;
            $user->status = 1;
            $user->corp_relation = '';
            $user->status_memo = " لطفا برای افزایش امنیت پروفایل خود، کلمه عبور پیش فرض سیستمی خود را تغییر دهید. برای تغییر کلمه از قسمت ' تنظیمات کاربری ' اقدام نمائید.";
            $user->save();

            sendSMS_Register_persoanl($name, $phone);
            sendSMS_Register_subsid($name, $phone, 50000);

          }
          else
          {
            $user->password = Hash::make($userpass);
            $user->save();
          }
          $smsStatus = sendSMS_Password($phone, $userpass);
          Session::forget('registerPhone');
          Session::forget('registerName');
          Session::forget('loginCode');
          Session::forget('previeusPage');
          Session::forget('forgot_mistake_count');
          Session::forget('miniphone');
          $message = 'کلمه عبور به شماره موبایل ارسال گردید';
          return redirect('web');
        } else {
          $forgotMistakeCount = $forgotMistakeCount + 1;
          Session::put('forgot_mistake_count', $forgotMistakeCount);
          $message = 'کد وارد شده اشتباه می باشد';
          $miniphone = Session::get('miniphone');
          return view('verify_register_complet', compact('miniphone', 'message', 'forgotMistakeCount'));
        }
      } else {
        $message = 'تعداد دفعات ورود کد یکبار مصرف بیش تر از حد مجاز شد';
        Session::forget('registerPhone');
        Session::forget('registerName');
        Session::forget('remmeber');
        Session::forget('loginCode');
        Session::forget('miniphone');
        Session::forget('previeusPage');
        Session::forget('forgot_mistake_count');
        return view('login', compact('message'));
      }
    } else {
      $message = 'تعداد دفعات ورود کد یکبار مصرف بیش تر از حد مجاز شد';
      Session::forget('remmeber');
      Session::forget('loginCode');
      Session::forget('miniphone');
      Session::forget('previeusPage');
      Session::forget('forgot_mistake_count');
      return view('login', compact('message'));
    }
  }

  public function forgot_user(Request $request)
  {
    $phonenumber =checkValidPhone($request->phonenumber);
    if ($phonenumber != null) {
      $user = User::where('phonenumber', $phonenumber)->orWhere('username', $phonenumber)->first();
      if (!empty($user)) {
        $loginCode = rand(10000, 99999);
        $forgotMistakeCount = 1;
        Session::put('registerName', $user->name);
        Session::put('registerPhone', $phonenumber);
        Session::put('loginCode', $loginCode);
        Session::put('forgot_mistake_count', $forgotMistakeCount);
        $smsStatus = sendSMS_Login($phonenumber, $loginCode);
        $miniphone = substr_replace($phonenumber, '****', 3, 4);
        Session::put('miniphone', $miniphone);
        $message = "کلمه عبور یکبار مصرف به شماره " . $miniphone . ' ارسال شد ';
        if ($smsStatus == true)
          return view('verify_forgot', compact('miniphone', 'message', 'forgotMistakeCount'));
        else {
          $smsStatus = sendSMS_Login($user->phonenumber, $loginCode);
          return view('verify_forgot', compact('miniphone', 'message', 'forgotMistakeCount'));
        }
      } else {
        $message = 'کاربری با این مشخصات در سایت ثبت نام نکرده است';
        return view('forgot', compact('message'));
      }
    } else {
      $message = 'لطفا گزینه مورد نظر را جهت بازیابی کلمه عبور وارد نمائید';
      return view('forgot', compact('message'));
    }
  }

  public function verify_code_complete_forgot(Request $request)
  {
    $user_code = $request->login_code;
    $userpass1 = $request->pass1;
    $userpass2 = $request->pass2;
    $loginCode = Session::get('loginCode');
    $forgotMistakeCount = Session::get('forgot_mistake_count');
    if($userpass1==$userpass2) {
      if ($loginCode != null) {
        if ($forgotMistakeCount < 5) {
          if ($user_code == $loginCode) {
            $phone = Session::get('registerPhone');
            $user = User::where("phonenumber", "=", $phone)
              ->orWhere('username', '=', $phone)->first();

            $user->password = Hash::make($userpass1);
            $user->save();
            $smsStatus = sendSMS_Password($phone, $userpass1);
            Session::forget('registerPhone');
            Session::forget('loginCode');
            Session::forget('previeusPage');
            Session::forget('forgot_mistake_count');
            Session::forget('miniphone');
            $message = 'کلمه عبور به شماره موبایل ارسال گردید';
            return redirect('web');
          } else {
            $forgotMistakeCount = $forgotMistakeCount + 1;
            Session::put('forgot_mistake_count', $forgotMistakeCount);
            $message = 'کد وارد شده اشتباه می باشد';
            $miniphone = Session::get('miniphone');
            return view('verify_forgot', compact('miniphone', 'message', 'forgotMistakeCount'));
          }
        }
        else {
          $message = 'تعداد دفعات ورود کد یکبار مصرف بیش تر از حد مجاز شد';
          Session::forget('registerPhone');
          Session::forget('registerName');
          Session::forget('remmeber');
          Session::forget('loginCode');
          Session::forget('miniphone');
          Session::forget('previeusPage');
          Session::forget('forgot_mistake_count');
          return view('login', compact('message'));
        }
      } else {
        $message = 'کد وارد شده اشتباه می باشد';
        $miniphone = Session::get('miniphone');
        return view('verify_forgot', compact('miniphone', 'message', 'forgotMistakeCount'));
      }
    }
    else{
      $message = 'کلمات عبور یکسان نیستند';
      $miniphone = Session::get('miniphone');
      return view('verify_forgot', compact('miniphone', 'message', 'forgotMistakeCount'));
    }
  }


  public function signup(Request $request)
  {
    $data = $request->all();
    $name = $request->name;
    $state = $request->state;
    $birthdate = $request->birthdate;
    $phone=(int)$request->phone;
    $phone=checkValidPhone($phone);
    $register_type = 'personal';
    if (strlen($phone) == 10) {
      if((int)$state != 0) {
        if (strlen($birthdate) == 10) {
          $loginCode = rand(10000, 99999);
          $register_type = 'personal';
          $user = User::where('phonenumber', '=', $phone)->count();
          if ($user == 0) {
            $forgotMistakeCount = 1;
            Session::put('registerPhone', $phone);
            Session::put('registerName', $name);
            Session::put('registerBirthdate', $birthdate);
            Session::put('registerState', $state);
            Session::put('loginCode', $loginCode);
            Session::put('forgot_mistake_count', $forgotMistakeCount);
            $miniphone = substr_replace($phone, '****', 3, 4);
            Session::put('miniphone', $miniphone);
            $smsStatus = sendSMS_Login($phone, $loginCode);
            $message = "جهت تکمیل ثبت نام کد عبور پیامک شده را وارد نمائید";
            if ($smsStatus == true) {
              return view('verify_register_complet', compact('miniphone', 'message', 'forgotMistakeCount'));
            } else {
              $smsStatus = sendSMS_Login($phone, $loginCode);
              return view('verify_register_complet', compact('miniphone', 'message', 'forgotMistakeCount'));
            }
          } else {
            $states = getState();
            $message = 'شماره موبایل قبلا استفاده شده است لطفا شماره موبایل دیگری وارد نمائید';
            return view('register', compact('message', 'data', 'states', 'register_type'));
          }
        }
        else{
          $states = getState();
          $message = 'لطفا تاریخ تولد معتبر وارد نمائید. مثل 1368/05/09';
          return view('register', compact('message', 'data', 'states', 'register_type'));
        }
      }
      else{
        $states = getState();
        $message = 'لطفا استان محل زندگی خود را انتخاب نمائید';
        return view('register', compact('message', 'data', 'states', 'register_type'));
      }
    }
    else{
      $states = getState();
      $message = 'شماره موبایل معتبر نمی باشد';
      return view('register', compact('message', 'data', 'states', 'register_type'));
    }

  }


  public function signup_co(Request $request)
  {

    $data = $request->all();
    $corp = $request->corp;
    $type = $request->type;
    $relation = $request->relation;
    $country = $request->country;
    $state = $request->state;
    $register_type="howzeh";
    if ($state == NULL)
      $state = 0;

    if($country <> 1)
      $state=19;

    if($state==0){
      $message = 'لطفا استان را انتخاب نمائید';
      $states = getState();
      return view("register", compact('message', 'data', 'states','register_type'));

    }
    else {
      if ($relation == "sarparast")
        $familyMemberType = 0;
      else
        $familyMemberType = 1;

      $id_branch=0;
      $id_agent=0;
      $firstname = $request->firstname;
      $lastname = $request->lastname;
      $fathername = $request->fathername;
      $center_code = $request->center_code;
      $personal_code = $request->personal_code;
      $nationalid = $request->nationalid;
      $user_birthdate = convert_to_number($request->birthdate);;
      $user_birthdate=repairDate($user_birthdate);
//      $userpass = $request->password;
//      $userpass2 = $request->password2;
      $userpass = rand(1000000, 9999999);
      $userpass2=$userpass;
      $phone = convert_to_number($request->phone);
      $phone=(int)$phone;
      $phone=checkValidPhone($phone);

      $isExist = false;
      $countTakafol = 0;
      $takafolID = 0;
      $id_branch = 0;
      $branchTitle = '';
      $id_agent = 0;
      $agentTitle = '';
      $provinceId = 0;
      $cityId = 0;
      $address = '';
      $postalCode = '';
      $message = "";
      $user_state_id=$state;
      $user_city_id=0;
      $corp = "howzeh";
      $employed=null;
      $subsid = 0;

      //
      if (strlen($phone) != 10) {
        $states = getState();
        $message = 'شماره موبایل معتبر نمی باشد';
        return view('register', compact('message', 'data', 'states', 'register_type'));
      }

      //
      $takafolID = 0;
      $fullname = $firstname . " " . $lastname;
      $username = $phone;
      $message = '';
      $imageName=$center_code.'.jpg';

      if ($country ==1) {
        $user_national = User::where('nationalid', '=', $nationalid)->count();
        if ($user_national > 0){
          $message = 'کد ملی تکراری است به این معنی که قبلا با این کدملی ثبت نام شده است';
          $states = getState();
          return view("register", compact('message', 'data', 'states','register_type'));
        }
      }

      $user = User::where('phonenumber', '=', $phone)->count();
      if ($user > 0) {
        $message = 'شماره موبایل قبلا ثبت شده است لطفا شماره موبایل دیگری راوارد نمائید';
        $states = getState();
        return view("register", compact('message', 'data', 'states','register_type'));
      }

      if ($corp != 'howzeh') {
        $message = '404';
        $states = getState();
        return view("register", compact('message', 'data', 'states','register_type'));
      }


      //try {
      $client = new Client();
      $url = "https://apiconsole.csis.ir/Token";
      $response = $client->request('POST', $url, [
        'verify' => false,
        'form_params' => [
          'Username' => "kasbeboom",
          'Password' => "csis.kasbboom.ir@!$%",
          'grant_type' => "password"
        ]
      ]);

      if ($response->getStatusCode() == 200) {
        $response_data = json_decode($response->getBody());
        $token = $response_data->access_token;

        // set params
        if ($type == "talabe") {
          $url = "https://apiconsole.csis.ir/api/service/kasbboom/check_states/canvas_student";
          $url_img = "https://mkh03.csis.ir/api/services/business_canvas/students/" . $center_code . "/profile_image";
          $imageName = $center_code . ".jpg";
          if ($country == 1) {
            $params = [
              'Codm' => $center_code,
              'FamilyMemberType' => $familyMemberType,
              'NationalId' => $nationalid,
              'BirthDate' => $user_birthdate,
              'Tabee' => $country
            ];
          } else {
            $params = [
              'Codm' => $center_code,
              'FamilyMemberType' => $familyMemberType,
              'FirstName' => $firstname,
              'LastName' => $lastname,
              'FatherName' => $fathername,
              'BirthDate' => $user_birthdate,
              'Tabee' => $country
            ];
          }
        } else {
          $url = "https://apiconsole.csis.ir/api/service/kasbboom/check_states/canvas_personnel";
          $url_img = "https://mkh03.csis.ir/api/services/business_canvas/personnels/" . $personal_code . "/profile_image";
          $imageName = $personal_code . ".jpg";
          $params = [
            'Codm' => $personal_code,
            'FamilyMemberType' => $familyMemberType,
            'NationalId' => $nationalid,
            'BirthDate' => $user_birthdate,
            'FirstName' => $firstname,
            'LastName' => $lastname,
            'FatherName' => $fathername,
            'Mobile' => $phone
          ];
        }

        //
        $response_check = $client->request('POST', $url, [
          'headers' => ['Authorization' => $token],
          'form_params' => $params,
          'verify' => false,
        ]);

        $response_data_check = json_decode($response_check->getBody());
        //dd($response_data_check->Data);
        if (!empty($response_data_check) and isset($response_data_check->Success) and $response_data_check->Success == true) {
          $isExist = $response_data_check->Data[0]->isvalid;
          if ($isExist == true){
            $countTakafol = isset($response_data_check->Data[0]->CountTakaffol)?$response_data_check->Data[0]->CountTakaffol : 0;
            $takafolID = isset($response_data_check->Data[0]->idTakaffol)?$response_data_check->Data[0]->idTakaffol : 0;
            $id_branch = isset($response_data_check->Data[0]->BranchId)?$response_data_check->Data[0]->BranchId :0;
            //   $branchTitle = isset($response_data_check->Data[0]->BranchTitle)?$response_data_check->Data[0]->BranchTitle : '';
            $id_agent = isset($response_data_check->Data[0]->AgentId)?$response_data_check->Data[0]->AgentId : 0;
            //   $agentTitle = isset($response_data_check->Data[0]->AgentTitle)?$response_data_check->Data[0]->AgentTitle : '';
            $provinceId = isset($response_data_check->Data[0]->ProvinceId)?$response_data_check->Data[0]->ProvinceId : 0;
            //   $cityId = isset($response_data_check->Data[0]->CityId)?$response_data_check->Data[0]->CityId : 0;
            // $cityTitle = $response_data_check->Data[0]->CityTitle;
            $address = isset($response_data_check->Data[0]->FullAddress)?$response_data_check->Data[0]->FullAddress : '';
            $postalCode = isset($response_data_check->Data[0]->ZipCode)?$response_data_check->Data[0]->ZipCode : 0;

            $isEmployed = isset($response_data_check->Data[0]->IsEmployed )? $response_data_check->Data[0]->IsEmployed : 0;

//            $branchTitle = $response_data_check->Data[0]->BranchTitle;
//            $id_agent = $response_data_check->Data[0]->AgentId;
//            $agentTitle = $response_data_check->Data[0]->AgentTitle;
//            $provinceId = $response_data_check->Data[0]->ProvinceId;
//            $cityId = $response_data_check->Data[0]->CityId;
//            $cityTitle = $response_data_check->Data[0]->CityTitle;
//            $address = $response_data_check->Data[0]->FullAddress;
//            $postalCode = $response_data_check->Data[0]->ZipCode;
            $user_state_id = getmystate($provinceId);
            //$employed = $response_data_check->Data[0]->IsEmployed ? 1 : 0;
            $active = 1;
            if ($active) {
              $subsid_exists = DB::table('users')->where('id_markaz', $center_code)->where('yalda_1400', 1)->count();
              $subsid = ($employed or $subsid_exists) ? 50000 : 250000;
            }
            else $subsid = 50000;

            // kashan
            if ($id_branch == 26) $user_state_id = 48;
          }
          else
            $user_state_id = $state;
        }

        if ($isExist == true) {
          if ($type == "talabe") {
            $status_memo = " طلبه ارجمند آقا/خانم " . $fullname . " هویت شما توسط مرکز خدمات حوزه های علمیه تایید شد. زین پس می توانید از کلیه خدمات سامانه کسب بوم با حمایت مرکز خدمات حوزه های علمیه استفاده نمائید.  التماس دعا";
            $message = "سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد";

          }
          if ($type == "employee") {
            $status_memo = " کارمند ارجمند آقا/خانم " . $fullname . " هویت شما توسط مرکز خدمات حوزه های علمیه تایید شد. زین پس می توانید از کلیه خدمات سامانه کسب بوم با حمایت مرکز خدمات حوزه های علمیه استفاده نمائید.  التماس دعا";
            $message = "سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد";

          }
        }
        else {
          if ($type == "talabe") {
            $status_memo = " طلبه ارجمند آقا/خانم " . $fullname . " متاسفانه هویت شما توسط مرکز خدمات حوزه های علمیه به صورت سیستمی تایید نشد. اطلاعات شما در صف بررسی و هویت سنجی به صورت دستی قرار گرفته است. نتیجه بررسی به صورت پیامک اطلاع رسانی می گردد. باتشکر";
            $message = "سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد اما اطلاعات هویتی شما در حال بررسی می باشد.";

          }
          if ($type == "employee") {
            $status_memo = " کارمند ارجمند آقا/خانم " . $fullname . " متاسفانه هویت شما توسط مرکز خدمات حوزه های علمیه به صورت سیستمی تایید نشد. اطلاعات شما در صف بررسی و هویت سنجی به صورت دستی قرار گرفته است. نتیجه بررسی به صورت پیامک اطلاع رسانی می گردد. التماس دعا";
            $message = "سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد اما اطلاعات هویتی شما در حال بررسی می باشد.";

          }
          $user_state_id = $state;
        }
      }
      // }
      // catch (\Exception $e) {
      //   $isExist = 0;
      //   $status_memo = " کاربر ارجمند آقا/خانم " . $fullname . " هویت شما توسط مرکز خدمات حوزه های علمیه تایید شد. زین پس می توانید از کلیه خدمات سامانه کسب بوم با حمایت مرکز خدمات حوزه های علمیه استفاده نمائید.  التماس دعا";
      //   $message = "سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد و هویت اطلاعات شما مورد تایید قرار گرفته است. زین پس می توانید از کلیه خدمات سامانه کسب بوم با حمایت مرکز خدمات حوزه های علمیه استفاده نمائید.";
      //   $user_state_id=$state;
      //   $isExist=0;
      // }


      if($user_state_id === 0)
        $user_state_id=$state;

      $code = generateIdeaCode();
      $nowdate_shamsi = nowDate_Shamsi();
      $user = new User();
      $user->code = $code;
      $user->firstname = $firstname;
      $user->lastname = $lastname;
      $user->fathername = $fathername;
      $user->name = $fullname;
      $user->id_markaz = $center_code;
      $user->serviceid = $center_code;
      $user->image = $imageName;
      $user->personal_code = $personal_code;
      $user->nationality = $country;
      $user->twostep_auth = 0;
      $user->countTakaffol = $countTakafol;
      $user->id_state = $user_state_id;
      // $user->id_city = $user_city_id;
      $user->id_markaz_branch = $id_branch;
      $user->id_markaz_agent = $id_agent;
      $user->username = $username;
      $user->nationalid = $nationalid;
      $user->password = Hash::make($userpass);
      $user->phonenumber = $phone;
      $user->address = $address;
      $user->postalcode = $postalCode;
      $user->regist_date = $nowdate_shamsi;
      $user->level = "user";
      $user->corp = $corp;
      $user->corp_type = $type;
      $user->corp_relation = $relation;
      $user->takafolID = $takafolID;
      $user->wiki_permission = 0;
      $user->course_permission = 0;
      $user->lesson_permission = 0;
      $user->shop_permission = 100;
      $user->consult_permission = 0;
      $user->req_permission = 0;
      $user->webinar_permission = 0;
      $user->blog_permission = 0;
      $user->hire_permission = 0;
      $user->user_permission = 21;
      $user->teacher_permission = 0;
      $user->news_permission = 0;
      $user->category_permission = 0;
      $user->landuse_permission = 0;
      $user->vam_permission = 31;
      $user->markaz_permission = 31;
      $user->chamber_permission = 0;
      $user->birthdate = $user_birthdate;
      $user->total_income = 0;
      $user->total_settle = 0;
      $user->wallet = 0;
      $user->status = $isExist ? 1 : 0;
      $user->employed=$employed;
      $user->status_memo = $status_memo;
      $user->subsid = $subsid;
      $user->yalda_1400 = $subsid === 250000 ? 1 : 0;
      $user->save();

      //
      $usera = new UserAddress();
      $usera->id_user = $user->id;
      $usera->full_name = $firstname.' '.$lastname;
      $usera->id_state =$user_state_id;
      $usera->id_city = $user_city_id;
      $usera->postal_code = (strlen($postalCode) < 5) ? 0 : $postalCode;
      $usera->address = $address;
      $usera->phone = $phone;
      $usera->mobile = $phone;
      $usera->save();

      if ($isExist) {
        try {
          $folder_path = "_upload_/_users_/" . $code . "/personal/";
          File::makeDirectory($folder_path, $mode = 0777, true, true);
          $path = $folder_path . $imageName;
          $path_medium = $folder_path . $imageName;
          $path_small = $folder_path . $imageName;
          $client->request('GET', $url_img, [
            'headers' => ['Authorization' => $token],
            'sink' => $path_small
          ]);

          File::copy($path_small, $path);
          File::copy($path_small, $path_medium);
        } catch (\Exception $e) {}
      }

      $smsStatus = sendSMS_Register_howzeh($fullname, $phone, $phone, $message,$userpass);

      if($subsid>0)
        sendSMS_Register_subsid($fullname, $phone, $subsid);

      Auth::login($user, true);

      $user->is_logout =0;
      $user->save();

      return Redirect::to('web');
    }
  }


  public function signup_co_2(Request $request)
  {

    $data = $request->all();
    $corp = $request->corp;
    $type = $request->type;
    $relation = $request->relation;
    $country = $request->country;
    $state = $request->state;
    $register_type="howzeh";
    if ($state == NULL)
      $state = 0;

    if($country <> 1)
      $state=19;

    if($state==0){
      $message = 'لطفا استان را انتخاب نمائید';
      $states = getState();
      return view("register", compact('message', 'data', 'states','register_type'));

    }
    else {
      if ($relation == "sarparast")
        $familyMemberType = 0;
      else
        $familyMemberType = 1;

      $id_branch=0;
      $id_agent=0;
      $firstname = $request->firstname;
      $lastname = $request->lastname;
      $fathername = $request->fathername;
      $center_code = $request->center_code;
      $personal_code = $request->personal_code;
      $nationalid = $request->nationalid;
      $user_birthdate = convert_to_number($request->birthdate);;
      $user_birthdate=repairDate($user_birthdate);
//      $userpass = $request->password;
//      $userpass2 = $request->password2;
      $userpass = rand(1000000, 9999999);
      $userpass2=$userpass;
      $phone = convert_to_number($request->phone);
      $phone=(int)$phone;
      $phone=checkValidPhone($phone);

      $isExist = false;
      $countTakafol = 0;
      $takafolID = 0;
      $id_branch = 0;
      $branchTitle = '';
      $id_agent = 0;
      $agentTitle = '';
      $provinceId = 0;
      $cityId = 0;
      $address = '';
      $postalCode = '';
      $message = "";
      $wallet = 0;
      $user_state_id=$state;
      $user_city_id=0;
      $corp = "howzeh";
      $employed=null;

      if (strlen($phone) == 10) {
        $takafolID = 0;
        $wallet = 0;
        $fullname = $firstname . " " . $lastname;
        $username = $phone;
        $message = '';
        $imageName=$center_code.'.jpg';
        if ($userpass == $userpass2) {
          $user = 0;
          $user_national=0;
          if($country ==1)
            $user_national = User::where('nationalid', '=', $nationalid)->count();


          if($user_national >0){
            $message = 'کد ملی تکراری است به این معنی که قبلا با این کدملی ثبت نام شده است';
            $states = getState();
            return view("register", compact('message', 'data', 'states','register_type'));
          }
          else {

            $user = User::where('phonenumber', '=', $phone)->count();
            if ($user == 0) {
              if ($corp == "howzeh") {
                //try {
                $client = new Client();
                $url = "https://apiconsole.csis.ir/Token";
                $response = $client->request('POST', $url, [
                  'verify' => false,
                  'form_params' => [
                    'Username' => "kasbeboom",
                    'Password' => "csis.kasbboom.ir@!$%",
                    'grant_type' => "password"
                  ]
                ]);
                if ($response->getStatusCode() == 200) {
                  $response_data = json_decode($response->getBody());
                  $token = $response_data->access_token;

                  $url = "";
                  if ($type == "talabe") {
//                    $url = "https://mkh03.csis.ir/api/services/business_canvas/students/check";
                    $url="https://apiconsole.csis.ir/api/service/kasbboom/check_states/canvas_student";
                    $url_img = "https://mkh03.csis.ir/api/services/business_canvas/students/" . $center_code . "/profile_image";
                    $imageName = $center_code . ".jpg";
                    if ($country == 1) {
                      $params = [
                        'Codm' => $center_code,
                        'FamilyMemberType' => $familyMemberType,
                        'NationalId' => $nationalid,
                        'BirthDate' => $user_birthdate,
                        'Tabee' => $country
                      ];
                    } else {
                      $params = [
                        'Codm' => $center_code,
                        'FamilyMemberType' => $familyMemberType,
                        'FirstName' => $firstname,
                        'LastName' => $lastname,
                        'FatherName' => $fathername,
                        'BirthDate' => $user_birthdate,
                        'Tabee' => $country
                      ];
                    }
                  } else {

//                      $url = "https://mkh03.csis.ir/api/services/business_canvas/personnels/check";
                    $url="https://apiconsole.csis.ir/api/service/kasbboom/check_states/canvas_personnel";
                    $url_img = "https://mkh03.csis.ir/api/services/business_canvas/personnels/" . $personal_code . "/profile_image";
                    $imageName = $personal_code . ".jpg";
                    $employed=1;
                    $params = [
                      'Codm' => $personal_code,
                      'FamilyMemberType' => $familyMemberType,
                      'NationalId' => $nationalid,
                      'BirthDate' => $user_birthdate,
                      'FirstName' => $firstname,
                      'LastName' => $lastname,
                      'FatherName' => $fathername,
                      'Mobile' => $phone
                    ];
                  }

//dd( $params);
                  $response_check = $client->request('POST', $url, [
                    'headers' => ['Authorization' => $token],
                    'form_params' => $params,
                    'verify' => false,
                  ]);
                  $response_data_check = json_decode($response_check->getBody());
                  //dd($response_data_check->Data);
                  if ($response_data_check->Success ==true) {
                    $isExist = $response_data_check->Data[0]->isvalid;
                    if($isExist == true){
                      $countTakafol = isset($response_data_check->Data[0]->CountTakaffol)?$response_data_check->Data[0]->CountTakaffol : 0;
                      $takafolID = isset($response_data_check->Data[0]->idTakaffol)?$response_data_check->Data[0]->idTakaffol : 0;
                      $id_branch = isset($response_data_check->Data[0]->BranchId)?$response_data_check->Data[0]->BranchId :0;
                      $branchTitle = isset($response_data_check->Data[0]->BranchTitle)?$response_data_check->Data[0]->BranchTitle : '';
                      $id_agent = isset($response_data_check->Data[0]->AgentId)?$response_data_check->Data[0]->AgentId : 0;
                      $agentTitle = isset($response_data_check->Data[0]->AgentTitle)?$response_data_check->Data[0]->AgentTitle : '';
                      $provinceId = isset($response_data_check->Data[0]->ProvinceId)?$response_data_check->Data[0]->ProvinceId : 0;
                      $cityId = isset($response_data_check->Data[0]->CityId)?$response_data_check->Data[0]->CityId : 0;
                      // $cityTitle = $response_data_check->Data[0]->CityTitle;
                      $address = isset($response_data_check->Data[0]->FullAddress)?$response_data_check->Data[0]->FullAddress : '';
                      $postalCode = isset($response_data_check->Data[0]->ZipCode)?$response_data_check->Data[0]->ZipCode : 0;
                      $user_state_id=getmystate($provinceId);

                      $isEmployed = isset($response_data_check->Data[0]->IsEmployed )? $response_data_check->Data[0]->IsEmployed : false;
                      if($isEmployed==false)
                        $employed = 0;
                      else
                        $employed = 1;



                      if($id_branch==26)
                        $user_state_id=48;
                    }
                    else
                      $user_state_id=$state;

                  }

                  if ($isExist == true) {
                    $isExist = 1;
                    if ($type == "talabe") {
                      $status_memo = " طلبه ارجمند آقا/خانم " . $fullname . " هویت شما توسط مرکز خدمات حوزه های علمیه تایید شد. زین پس می توانید از کلیه خدمات سامانه کسب بوم با حمایت مرکز خدمات حوزه های علمیه استفاده نمائید.  التماس دعا";
                      $message = "سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد";
//                    $wallet = 20000;
                    }
                    if ($type == "employee") {
                      $status_memo = " کارمند ارجمند آقا/خانم " . $fullname . " هویت شما توسط مرکز خدمات حوزه های علمیه تایید شد. زین پس می توانید از کلیه خدمات سامانه کسب بوم با حمایت مرکز خدمات حوزه های علمیه استفاده نمائید.  التماس دعا";
                      $message = "سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد";
                      //                    $wallet = 20000;
                    }

                  }
                  else {
                    $isExist = 0;
                    $wallet = 0;
                    if ($type == "talabe") {
                      $status_memo = " طلبه ارجمند آقا/خانم " . $fullname . " متاسفانه هویت شما توسط مرکز خدمات حوزه های علمیه به صورت سیستمی تایید نشد. اطلاعات شما در صف بررسی و هویت سنجی به صورت دستی قرار گرفته است. نتیجه بررسی به صورت پیامک اطلاع رسانی می گردد. باتشکر";
                      $message = "سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد اما اطلاعات هویتی شما در حال بررسی می باشد.";
                    }
                    if ($type == "employee") {
                      $status_memo = " کارمند ارجمند آقا/خانم " . $fullname . " متاسفانه هویت شما توسط مرکز خدمات حوزه های علمیه به صورت سیستمی تایید نشد. اطلاعات شما در صف بررسی و هویت سنجی به صورت دستی قرار گرفته است. نتیجه بررسی به صورت پیامک اطلاع رسانی می گردد. التماس دعا";
                      $message = "سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد اما اطلاعات هویتی شما در حال بررسی می باشد.";

                    }
                    $user_state_id=$state;

                  }


                  // $user_state_id=getIdState($provinceTitle);
                  // if($user_state_id>0)
                  //   $user_city_id=getIdCity($cityTitle,$user_state_id);
                  // else{
                  //   $user_state_id=$state;
                  //   $user_city_id=getIdCity($state,$user_state_id);
                  // }

                }
                // }
                // catch (\Exception $e) {
                //   $isExist = 0;
                //   $wallet=0;
                //   $status_memo = " کاربر ارجمند آقا/خانم " . $fullname . " هویت شما توسط مرکز خدمات حوزه های علمیه تایید شد. زین پس می توانید از کلیه خدمات سامانه کسب بوم با حمایت مرکز خدمات حوزه های علمیه استفاده نمائید.  التماس دعا";
                //   $message = "سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد و هویت اطلاعات شما مورد تایید قرار گرفته است. زین پس می توانید از کلیه خدمات سامانه کسب بوم با حمایت مرکز خدمات حوزه های علمیه استفاده نمائید.";
                //   $user_state_id=$state;
                //   $isExist=0;
                // }



                $code = generateIdeaCode();
                $nowdate_shamsi = nowDate_Shamsi();
                $user = new User();
                $user->code = $code;
                $user->firstname = $firstname;
                $user->lastname = $lastname;
                $user->fathername = $fathername;
                $user->name = $fullname;
                $user->id_markaz = $center_code;
                $user->serviceid = $center_code;
                $user->image = $imageName;
                $user->personal_code = $personal_code;
                $user->nationality = $country;
                $user->twostep_auth = 0;
                $user->countTakaffol = $countTakafol;
                $user->id_state = $user_state_id;
                // $user->id_city = $user_city_id;
                $user->id_markaz_branch = $id_branch;
                $user->id_markaz_agent = $id_agent;
                $user->username = $username;
                $user->nationalid = $nationalid;
                $user->password = Hash::make($userpass);
                $user->phonenumber = $phone;
                $user->address = $address;
                $user->postalcode = $postalCode;
                $user->regist_date = $nowdate_shamsi;
                $user->level = "user";
                $user->corp = $corp;
                $user->corp_type = $type;
                $user->corp_relation = $relation;
                $user->takafolID = $takafolID;
                $user->wiki_permission = 0;
                $user->course_permission = 0;
                $user->lesson_permission = 0;
                $user->shop_permission = 100;
                $user->consult_permission = 0;
                $user->req_permission = 0;
                $user->webinar_permission = 0;
                $user->blog_permission = 0;
                $user->hire_permission = 0;
                $user->user_permission = 21;
                $user->teacher_permission = 0;
                $user->news_permission = 0;
                $user->category_permission = 0;
                $user->landuse_permission = 0;
                $user->vam_permission = 31;
                $user->markaz_permission = 31;
                $user->chamber_permission = 0;
                $user->birthdate = $user_birthdate;
                $user->total_income = 0;
                $user->total_settle = 0;
                $user->wallet = $wallet;
                $user->status = $isExist;
                $user->employed=$employed;
                $user->status_memo = $status_memo;
                $user->save();

                if(strlen($postalCode)<5)
                  $postalCode=0;

                $usera = new UserAddress();
                $usera->id_user = $user->id;
                $usera->full_name = $firstname.' '.$lastname;
                $usera->id_state =$user_state_id;
                $usera->id_city = $user_city_id;
                $usera->postal_code = $postalCode;
                $usera->address = $address;
                $usera->phone = $phone;
                $usera->mobile = $phone;
                $usera->save();



                if ($isExist == 1) {
                  try {
                    $folder_path = "_upload_/_users_/" . $code . "/personal/";
                    File::makeDirectory($folder_path, $mode = 0777, true, true);
                    $path = $folder_path . $imageName;
                    $path_medium = $folder_path . $imageName;
                    $path_small = $folder_path . $imageName;
                    $client->request('GET', $url_img, [
                      'headers' => ['Authorization' => $token],
                      'sink' => $path_small

                    ]);

                    File::copy($path_small, $path);
                    File::copy($path_small, $path_medium);
                  } catch (\Exception $e) {
                  }
                }

                $smsStatus = sendSMS_Register_howzeh($fullname, $phone, $phone, $message,$userpass);

//                Auth::login($user, true);

                return Redirect::to('web');

              }
              else {
                $nowdate_shamsi = nowDate_Shamsi();
                $user = new User();
                $user->code = generateIdeaCode();
                $user->firstname = $firstname;
                $user->lastname = $lastname;
                $user->name = $fullname;
                $user->id_markaz = 0;
                $user->serviceid = 0;
                $user->nationality = 1;
                $user->twostep_auth = 1;
                $user->id_state = $state;
                $user->username = $phone;
                $user->nationalid = $nationalid;
                $user->password = Hash::make($userpass);
                $user->phonenumber = $phone;
                $user->regist_date = $nowdate_shamsi;
                $user->level = "user";
                $user->corp = $corp;
                $user->corp_type = '';
                $user->corp_relation = '';
                $user->takafolID = 0;
                $user->wiki_permission = 0;
                $user->course_permission = 0;
                $user->lesson_permission = 0;
                $user->shop_permission = 0;
                $user->consult_permission = 0;
                $user->req_permission = 0;
                $user->webinar_permission = 0;
                $user->blog_permission = 0;
                $user->hire_permission = 0;
                $user->user_permission = 21;
                $user->teacher_permission = 0;
                $user->news_permission = 0;
                $user->category_permission = 0;
                $user->landuse_permission = 0;
                $user->vam_permission = 0;
                $user->markaz_permission = 0;
                $user->chamber_permission = 0;
                $user->birthdate = $user_birthdate;
                $user->total_income = 0;
                $user->total_settle = 0;
                $user->wallet = 0;
                $user->status = 1;
                $user->status_memo = '';
                $user->save();

                //          $smsStatus = sendSMS_Register_howzeh($fullname, $phone, $nationalid, $message);
//
//                Auth::login($user, true);

                return Redirect::to('web');
              }
            } else {
              $message = 'شماره موبایل قبلا ثبت شده است لطفا شماره موبایل دیگری راوارد نمائید';
              $states = getState();
              return view("register", compact('message', 'data', 'states','register_type'));
            }
          }
        }
        else {
          $message = 'کلمات عبور یکسان نیستند';
          $states = getState();
          return view("register", compact('message', 'data', 'states','register_type'));

        }
      }
      else{
        $states = getState();
        $message = 'شماره موبایل معتبر نمی باشد';
        return view('register', compact('message', 'data', 'states', 'register_type'));
      }
    }
  }



  public function user_dashboard()
  {

    if (Auth::user()->can('view-user')) {
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');
      $course_count = classroom::where("id_user", "=", $id_user)->count();
      $message_count = message::where("type", "=", "user")->where("id_target", "=", $id_user)->count();
      $blog_count = message::where("type", "=", "blog")->where("id_target", "=", $id_user)->count();
      $user = User::where("id", "=", $id_user)->first();
      $wallet = $user->wallet;

      $read_status_memo=$user->read_status_memo;
      if($user->read_status_memo == 0) {
        $user->read_status_memo = 1;
        $user->save();
      }

      return view('user/dashboard', compact("course_count", "message_count", "blog_count", "wallet", "user","read_status_memo"));
    } else
      return view('accessdenid');

  }

  public function mycourses()
  {
    if (Auth::user()->can('view-user')) {
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');
      $courses = classroom::where("id_user", "=", $id_user)->get();
      foreach ($courses as $cs) {
        $info = course::where("id", "=", $cs->id_course)->first();
        if ($info != null) {
          $cs->title = $info->title;
          $cs->price = $info->price;
          $cs->code = $info->code;
          $cs->image = $info->image;
        }
      }

      return view("user.courses", compact("courses"));
    } else
      return view('accessdenid');
  }

  public function mywebinars()
  {
    if (Auth::user()->can('view-user')) {
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');

      $webinars = webinar_register::where("id_user", "=", $id_user)->get();
      foreach ($webinars as $cs) {
        $info = webinar::where("id", "=", $cs->id_webinar)->first();
        if ($info != null) {
          $cs->title = $info->title;
          $cs->price = $info->price;
          $cs->code = $info->code;
          $cs->image = $info->image;
          $cs->date = $info->webinar_start_time_hour . ':' . $info->webinar_start_time_minutes . ' - ' . $info->webinar_date;
          if ($info->status == 1)
            $cs->status = "در انتظار";
          else
            $cs->status = "برگزار شده";
        }
      }

      return view("user.webinars", compact("webinars"));
    } else
      return view('accessdenid');
  }

  public function myquizs()
  {
    if (Auth::user()->can('view-user')) {
      return view('user/myquizs');
    } else
      return view('accessdenid');
  }

  public function myfavorites()
  {
    if (Auth::user()->can('view-user')) {
      return view('user/myfavorites');
    } else
      return view('accessdenid');
  }

  public function mycertificates()
  {
    if (Auth::user()->can('view-user')) {
      return view('user/mycertificates');
    } else
      return view('accessdenid');
  }

  public function mycomments()
  {
    if (Auth::user()->can('view-user')) {
      return view('user/mycomments');
    } else
      return view('accessdenid');
  }

  public function message()
  {
    if (Auth::user()->can('view-user')) {
      return view("user.messages");
    } else
      return view('accessdenid');
  }

  public function mywallet()
  {
    if (Auth::user()->can('view-user')) {
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager()) {
        $id_user = Session::get('id_user');
        $user = User::where("id", "=", $id_user)->first();
        $wallet = $user->wallet;
        $sum_settle_wallet = $user->total_settle;
        $sum_income_wallet = $user->total_income;
      } else {
        $wallet = Auth::user()->wallet;
        $sum_settle_wallet = Auth::user()->total_settle;
        $sum_income_wallet = Auth::user()->total_income;
      }
      return view('user/wallet', compact('sum_settle_wallet', 'sum_income_wallet', 'wallet'));
    } else
      return view('accessdenid');
  }

  public function increase_wallet()
  {
    if (Auth::user()->can('view-user')) {

      $message = "";
      $type_message = "alert-success";
      return view('user/increase_wallet', compact('message', 'type_message'));
    } else
      return view('accessdenid');
  }

  public function get_wallet()
  {
    if (Auth::user()->can('view-user')) {

      $message = "";
      $type_message = "alert-success";
      if (Auth::user()->isManager()) {
        $id_user = Session::get('id_user');
        $user = User::where("id", "=", $id_user)->first();
        $max_wallet = $user->wallet;
      } else
        $max_wallet = Auth::user()->wallet;

      return view('user/get_wallet', compact('message', 'type_message', 'max_wallet'));
    } else
      return view('accessdenid');
  }

  public function payments()
  {
    if (Auth::user()->can('view-user')) {
      return view("user.payments");
    } else
      return view('accessdenid');
  }

  public function all_payments()
  {

    if (auth()->user()->can('view-user')) {
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');

      $payments = payment::where("id_user", "=", $id_user)->where("status", "=", 1)->get();

      return Datatables::of($payments)->make(true);
    } else
      return "عدم دسترسی";
  }

  public function whishlist()
  {
    if (Auth::user()->can('view-user')) {

      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');
      $whishlist = user_favorite::where("id_user", "=", $id_user)->get();
      foreach ($whishlist as $cs) {
        $info = "";
        if ($cs->type == "course")
          $info = course::where("id", "=", $cs->id_target)->first();
        elseif ($cs->type == "webinar")
          $info = webinar::where("id", "=", $cs->id_target)->first();
        elseif ($cs->type == "product") {
          $info = product::where("id", "=", $cs->id_target)->first();
        }

        if ($info != null) {
          $cs->title = $info->title;
          $cs->code = $info->code;
          $cs->image = $info->image;
        }
      }
      return view("user.whishlist", compact("whishlist"));
    } else
      return view('accessdenid');
  }

  public function info()
  {
    if (Auth::user()->can('view-user')) {
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');
      $user = User::where("id", "=", $id_user)->first();
      $states = getState();
      return view("user/detail_user", compact("user", "states"));
    } else
      return view("accessdenid");
  }

  public function mysetting()
  {
    $user = Auth::user();
    if ($user->can('view-user')) {
      $states = state::all();
      return view('user/setting', compact('states', 'user'));
    } else
      return view('accessdenid');
  }

  public function kasboom_test()
  {
    $client = new Client();
    $url = "https://mkh03.csis.ir/api/services/business_canvas/authorization";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'Username' => "kasbeboom",
        'Password' => "csis.kasbboom.ir@!$%",
      ]
    ]);

    if ($response->getStatusCode() == 200) {
      $response_data = json_decode($response->getBody());
      $token = $response_data->token;
      $url = "https://mkh03.csis.ir/api/services/business_canvas/students/check";
      $response_check = $client->request('POST', $url, [
        'headers' => ['Authorization' => $token],
        'form_params' => [
          'Codm' => 257307,
          'FamilyMemberType' => 0,  # 1 : takafol   0" talabe
          'NationalId' => 3120178152,
          'BirthDate' => "1372/09/18",
          'Tabee' => 1,
        ],
        'verify' => false,
      ]);

      $response_data_check = json_decode($response_check->getBody());

    }
    return view("user/test");
  }

  public function logout()
  {
    $user = Auth::user();
    if($user) {
      $user->is_logout = 1;
      $user->save();
    }
    Auth::logout();
    Session::flush();
//    if (isset($_GET['remote'])) return 'ok';
    return Redirect::to('/');
  }

  public function show_mycourses()
  {
    if (Auth::user()->can('view-user')) {
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');
      $courses = DB::table('class_room')
        ->join('courses', 'courses.id', '=', 'class_room.id_course')
        ->join('categorys', 'courses.id_category', '=', 'categorys.id')
        ->where("class_room.id_user", "=", $id_user)
        ->select('courses.id', 'courses.price', 'courses.code', 'courses.title', 'categorys.title as cat_title', 'courses.image', 'class_room.regist_date', 'class_room.result')
        ->get();

      return Datatables::of($courses)->make(true);
    } else
      return view('accessdenid');
  }

  public function show_myquizs()
  {
    if (Auth::user()->can('view-user')) {
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');

      $quizs = DB::table('class_room')
        ->join('courses', 'courses.id', '=', 'class_room.id_course')
        ->join('categorys', 'courses.id_category', '=', 'categorys.id')
        ->where("class_room.id_user", "=", $id_user)
        ->where("class_room.take_quiz", "=", 1)
        ->select('courses.id', 'courses.code', 'courses.title', 'categorys.title as cat_title', 'courses.image', 'class_room.take_quiz', 'class_room.quiz_score', 'class_room.quiz_result', 'class_room.last_date_take_quize', 'class_room.regist_date', 'class_room.result')
        ->get();

      return Datatables::of($quizs)->make(true);
    } else
      return view('accessdenid');
  }

  public function show_mycertificates()
  {
    if (Auth::user()->can('view-user')) {

      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');

      $certificates = DB::table('class_room')
        ->join('courses', 'courses.id', '=', 'class_room.id_course')
        ->join('categorys', 'courses.id_category', '=', 'categorys.id')
        ->where("class_room.id_user", "=", $id_user)
        ->where("class_room.take_quiz", "=", 1)
        ->where("class_room.give_certificate", "=", 1)
        ->select('courses.id', 'courses.code', 'courses.title', 'categorys.title as cat_title', 'courses.image', 'class_room.id_user', 'class_room.senddate_certificate', 'class_room.certificate_filename')
        ->get();

      return Datatables::of($certificates)->make(true);
    } else
      return view('accessdenid');
  }

  public function show_myfavorites()
  {
    if (Auth::user()->can('view-user')) {

      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');

      $favoriets = DB::table('user_favorites')
        ->join('courses', 'courses.id', '=', 'user_favorites.id_course')
        ->join('categorys', 'courses.id_category', '=', 'categorys.id')
        ->where("user_favorites.id_user", "=", $id_user)
        ->select('courses.id', 'courses.code', 'courses.title', 'categorys.title as cat_title', 'courses.image', 'courses.price', 'courses.hour', 'courses.minutes')
        ->get();

      return Datatables::of($favoriets)->make(true);
    } else
      return view('accessdenid');

  }

  public function show_mycomments()
  {
    if (Auth::user()->can('view-user')) {

      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');

      $comments = comment::where("id_user", "=", $id_user)
        ->orderBy("id", "desc");


      return Datatables::of($comments)->make(true);
    } else
      return "عدم دسترسی";

  }

  public function increas_to_wallet(Request $request)
  {

    if (Auth::user()->can('view-user')) {

      $amount = (double)$request->amount;
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');


      $user = User::where("id", "=", $id_user)->first();
      $user->wallet = $user->wallet + $amount;
      $user->sum_settle_wallet = $user->sum_settle_wallet + $amount;
      $user->save();

      $nowDate = date("Y-m-d");
      $nowdate_shamsi = jdate($nowDate)->format('%Y/%m/%d');

      $pay = new payment();
      $pay->id_user = $id_user;
      $pay->product_course_title = 'واریز وجه به کیف پول';
      $pay->regist_date = $nowdate_shamsi;
      $pay->price = $amount;
      $pay->discount = 0;
      $pay->payment_price = $amount;
      $pay->authority = "123000";
      $pay->refID = "123";
      $pay->bankname = "ملت";
      $pay->status = "successful";
      $pay->save();

      $message = "افزایش موجودی کیف پول با موفقیت انجام شد و مبلغ به کیف پول شما اضافه گردید";
      $type_message = "alert-success";
      return view('user/increase_wallet', compact('message', 'type_message'));
    } else
      return view('accessdenid');

  }

  public function get_from_wallet(Request $request)
  {
    if (Auth::user()->can('view-user')) {

      $amount = (double)$request->amount;
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager()) {
        $id_user = Session::get('id_user');
        $max_wallet = User::where("id", "=", $id_user)->first()->wallet;
      } else
        $max_wallet = Auth::user()->wallet;

      if ($amount <= $max_wallet) {


        $nowDate = date("Y-m-d");
        $nowdate_shamsi = jdate($nowDate)->format('%Y/%m/%d');

        $pay = new settle_request();
        $pay->id_user = $id_user;
        $pay->regist_date = $nowdate_shamsi;
        $pay->price = $amount;
        $pay->status = "check";
        $pay->save();

        $message = "درخواست شما ثبت و در اسرع وقت بررسی و رسیدگی می شود";
        $type_message = "alert-success";
        return view('user/get_wallet', compact('message', 'type_message', 'max_wallet'));
      } else {
        $message = "درخواست وجه بیشتر از موجودی فعلی کیف پول شما می باشد. لطفا مبلغ دیگری را درخواست دهید";
        $type_message = "alert-secondary";
        return view('user/get_wallet', compact('message', 'type_message', 'max_wallet'));
      }
    } else
      return view('accessdenid');

  }

  public function updateUserInfo(Request $request)
  {
    if (Auth::user()->can('edit-user')) {
      $user_name = $request->user_name;
      $fathername = $request->fathername;
      $user_nationalid = $request->user_nationalid;
      $user_gender = $request->user_gender;
      $user_married = $request->user_married;
      $user_birthdate = $request->user_birthdate;
      $state = $request->state;
      $city = $request->city;
      $user_job = $request->user_job;
      $user_address_home = $request->user_address_home;
      $user_postalcode = $request->user_postalcode;
      $user_address_work = $request->user_address_work;
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');

      $user = User::where("id", "=", $id_user)->first();
      $imgFileName = '';
      if ($request->file('user_image')) {
        $code = $user->code;
        if ($code == null) {
          $code = generateIdeaCode();
          $user->code = $code;
        }
        $folderPath = "_upload_/_users_/" . $code . "/personal";
        $imgFileName = uploadImageFile($request->file('user_image'), $folderPath);

        $user->image = $imgFileName;
      }

      $user->name = $user_name;
      $user->married = $user_married;
      $user->gender = $user_gender;
      $user->nationalid = $user_nationalid;
      $user->fathername = $fathername;
      $user->postalcode = $user_postalcode;
      $user->birthdate = $user_birthdate;
      $user->id_state = $state;
      $user->id_city = $city;
      $user->job = $user_job;
      $user->address = $user_address_home;
      $user->address_work = $user_address_work;
      $user->save();

      return ($this->ajax_response(false, '', 'تغییر اطلاعات با موفقیت ثبت شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);
  }

  public function updateUserSkills(Request $request)
  {
    if (Auth::user()->can('edit-user')) {

      $about = $request->about;
      $abstractAbout = $request->abstractAbout;
      $history_learn = $request->learn_history;
      $skills = $request->skills;
      $last_education = $request->last_education;
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');
      User::where('id', '=', $id_user)
        ->update([
          'about' => $about,
          'abstractAbout' => $abstractAbout,
          'learn_history' => $history_learn,
          'last_education' => $last_education,
          'skills' => $skills,
        ]);

      return ($this->ajax_response(false, '', 'تغییر اطلاعات با موفقیت ثبت شد', 'success'));

    } else
      return response()->json($this->accessdenide_response);

  }

  public function updateUserContacts(Request $request)
  {
    if (Auth::user()->can('edit-user')) {
      $tel = $request->tel;
      $tel_work = $request->tel_work;
      $email = $request->email;
      $eita = $request->eita;
      $telegram = $request->telegram;
      $linkdin = $request->linkdin;
      $phonenumber = $request->phonenumber;
      $mobile2 = $request->mobile2;
      $website = $request->website;
      $soroush = $request->soroush;
      $instagram = $request->instagram;
      $aparat = $request->aparat;
      $whatsapp = $request->whatsapp;
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');
      User::where('id', '=', $id_user)
        ->update([
          'tel' => $tel,
          'tel_work' => $tel_work,
          'email' => $email,
          'eita' => $eita,
          'telegram' => $telegram,
          'linkdin' => $linkdin,
          'phonenumber' => $phonenumber,
          'mobile2' => $mobile2,
          'website' => $website,
          'soroush' => $soroush,
          'instagram' => $instagram,
          'aparat' => $aparat,
          'whatsapp' => $whatsapp
        ]);

      return ($this->ajax_response(false, '', 'تغییر اطلاعات با موفقیت ثبت شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);

  }

  public function updateUserCards(Request $request)
  {
    if (Auth::user()->can('edit-user')) {

      $cardnumber = $request->cardnumber;
      $shabanumber = $request->shabanumber;
      $accountnumber = $request->accountnumber;
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');
      User::where('id', '=', $id_user)
        ->update([
          'cardnumber' => $cardnumber,
          'shabanumber' => $shabanumber,
          'accountnumber' => $accountnumber
        ]);

      return ($this->ajax_response(false, '', 'تغییر اطلاعات با موفقیت ثبت شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);
  }

  public function updateUserSetting(Request $request)
  {
    if (Auth::user()->can('edit-user')) {

      $view_phone = $request->view_phone;
      $view_address = $request->view_address;
      $view_socialnetworks = $request->view_socialnetworks;
      $view_course = $request->view_course;
      $view_follower = $request->view_follower;
      $view_chat = $request->view_chat;
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');
      User::where('id', '=', $id_user)
        ->update([
          'view_phone' => $view_phone,
          'view_address' => $view_address,
          'view_socialnetworks' => $view_socialnetworks,
          'view_course' => $view_course,
          'view_follower' => $view_follower,
          'view_chat' => $view_chat
        ]);

      return ($this->ajax_response(false, '', 'تغییر اطلاعات با موفقیت ثبت شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);
  }

  public function updateUserImages(Request $request)
  {
    if (Auth::user()->can('edit-user')) {

      if (checkValidIP(request()->header('x-forwarded-for'))) {

        $id_user = Auth::user()->id;
        if (Auth::user()->isManager())
          $id_user = Session::get('id_user');

        $cert_img = "";
        $nationaid_img = "";
        $personal_img = "";
        $shsh_img = "";

        $user = User::where('id', '=', $id_user)->first();
        $code = $user->code;
        if ($code == null) {
          $code = generateIdeaCode();
          $user->code = $code;
        }

        if ($request->file('cert_img')) {
          $folderPath = "_upload_/_users_/" . $code . "/personal";
          if (file_exists($folderPath . "/" . $user->cert_img))
            File::delete($folderPath . "/" . $user->cert_img);
          $cert_img = uploadImageFile($request->file('cert_img'), $folderPath);
          $user->cert_img = $cert_img;
        }

        sleep(1);
        if ($request->file('nationaid_img')) {
          $folderPath = "_upload_/_users_/" . $code . "/personal";
          if (file_exists($folderPath . "/" . $user->nationaid_img))
            File::delete($folderPath . "/" . $user->nationaid_img);
          $nationaid_img = uploadImageFile($request->file('nationaid_img'), $folderPath);
          $user->nationaid_img = $nationaid_img;
        }
        sleep(1);
        if ($request->file('shsh_img')) {
          $folderPath = "_upload_/_users_/" . $code . "/personal";
          if (file_exists($folderPath . "/" . $user->shsh_img))
            File::delete($folderPath . "/" . $user->shsh_img);
          $shsh_img = uploadImageFile($request->file('shsh_img'), $folderPath);
          $user->shsh_img = $shsh_img;
        }
        sleep(1);
        if ($request->file('personal_img')) {
          $folderPath = "_upload_/_users_/" . $code . "/personal";
          if (file_exists($folderPath . "/" . $user->personal_img))
            File::delete($folderPath . "/" . $user->personal_img);
          $personal_img = uploadImageFile($request->file('personal_img'), $folderPath);
          $user->personal_img = $personal_img;
        }

        $user->save();

        return ($this->ajax_response(false, '', 'تغییر اطلاعات با موفقیت ثبت شد', 'success'));
      }
      else
        return response()->json("آیپی غیر مجاز است");

    } else
      return response()->json($this->accessdenide_response);

  }

  public function updateUserPass(Request $request)
  {
    if (Auth::user()->can('edit-user')) {

      $nowpass = $request->nowpass;
      $newpass = $request->newpass;
      $renewpass = $request->renewpass;
      $response = [];
      if (strlen($newpass) < 8) {
        return ($this->ajax_response(true, '', 'تعداد کاراکترهای کلمه عبور جدید کم است', 'error'));
      } else {
        if ($newpass == $renewpass) {
          if (Hash::check($nowpass, Auth::user()->password)) {
            $id_user = Auth::user()->id;
            if (Auth::user()->isManager())
              $id_user = Session::get('id_user');

            User::where('id', '=', $id_user)
              ->update([
                'password' => Hash::make($newpass),
                'status_memo' => ''
              ]);

            return ($this->ajax_response(false, '', 'تغییر کلمه عبور  با موفقیت ثبت شد', 'success'));

          } else
            return ($this->ajax_response(true, '', 'کلمه عبور جاری صحیح نیست', 'error'));
        } else
          return ($this->ajax_response(true, '', 'کلمات عبور جدید یکسان نیستند', 'error'));

      }
      return response()->json($response);
    } else
      return response()->json($this->accessdenide_response);
  }

  public function updateUserPermission(Request $request)
  {
    if (Auth::user()->can('edit-user')) {
      $view_twostep = $request->view_twostep;
      $view_phone = $request->view_phone;
      $view_email = $request->view_email;
      $view_social = $request->view_social;
      $view_chat = $request->view_chat;
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');
      User::where('id', '=', $id_user)
        ->update([
          'twostep_auth' => $view_twostep,
          'view_phone' => $view_phone,
          'view_email' => $view_email,
          'view_socialnetworks' => $view_social,
          'view_chat' => $view_chat
        ]);

      return ($this->ajax_response(false, '', 'تغییرات تنظیمات پروفایل با موفقیت ثبت شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);
  }

  public function vam_from1()
  {
    $user = Auth::user();
    return view("user/vam1", compact("user"));
  }

  public function vam_from2()
  {
    $user = Auth::user();
    return view("user/vam2", compact("user"));
  }

  public function vam_from3()
  {
    $user = Auth::user();
    return view("user/vam3", compact("user"));
  }

  public function vam_from4()
  {
    $user = Auth::user();
    return view("user/vam4", compact("user"));
  }

  public function vam_from5()
  {
    $user = Auth::user();
    return view("user/vam5", compact("user"));
  }

  public function myconsults()
  {
    return view("user.myconsults");
  }

  public function show_myconsults()
  {
    if (auth()->user()->can('view-user')) {
      $id_user = Auth::user()->id;
      if (Auth::user()->isManager())
        $id_user = Session::get('id_user');
      $data = consult_time::where("id_user", "=", $id_user)->get();
      return Datatables::of($data)
        ->addColumn('consult_name', function ($row) {
          return $row->getConsultName();
        })->make(true);
    } else
      return "عدم دسترسی";
  }

  public function consulting($id, $title)
  {
    $id_user = Auth::user()->id;
    if (Auth::user()->isManager())
      $id_user = Session::get('id_user');

    if (auth()->user()->can('view-user')) {
      $consulting = consult_time::where("id", "=", $id)->first();
      if ($consulting != null) {
        if ($consulting->id_user == $id_user) {
          $consult = consult::where("id", "=", $consulting->id_consult)->select("fullname", "mobile2", "mobile", "tel", "tel_work", "eita", "instagram", "soroush", "twitter", "telegram")->first();
          $user = User::where("id", "=", $consulting->id_user)->select("name", "mobile2", "phonenumber", "tel", "tel_work", "eita", "instagram", "soroush", "twitter", "telegram")->first();
          $state = state::where("id", "=", $consulting->id_state)->first();
          if ($state != null)
            $state = $state->name;
          $city = city::where("id", "=", $consulting->id_city)->first();
          if ($city != null)
            $city = $city->name;
          return view("user.detail_consulting", compact("consulting", "consult", "user", "state", "city"));
        } else
          return view("accessdenid");
      } else
        return view("accessdenid");

    } else
      return view("accessdenid");
  }

  public function all_users()
  {

    if (Auth::user()->isManager()) {
      $users = User::select("id","code","name","username","level","id_state","id_city","regist_date","wallet","serviceid","status","image")->get();

      return Datatables::of($users)->make(true);
    } else
      return response()->json($this->accessdenide_response);
  }

  public function manager_detail_user($id, $title)
  {
    if (Auth::user()->isManager()) {
      $user = User::where("id", "=", $id)->first();
      $states = getState();
      return view("_manager.user.detail_user", compact("user", "states"));
    } else
      return view("accessdenid");
  }

  public function manager_user_dashboard($id_user, $title)
  {

    if (Auth::user()->isManager()) {
      Session::put('id_user', $id_user);
      $course_count = classroom::where("id_user", "=", $id_user)->count();
      $message_count = message::where("type", "=", "user")->where("id_target", "=", $id_user)->count();
      $blog_count = message::where("type", "=", "blog")->where("id_target", "=", $id_user)->count();
      $user = User::where("id", "=", $id_user)->first();
      Session::put('user', $user);

      $wallet = $user->wallet;
      return view('user/dashboard', compact("course_count", "message_count", "blog_count", "wallet", "user"));
    } else
      return view('accessdenid');

  }

  public function manager_user_setting($id_user, $title)
  {
    if (Auth::user()->isManager()) {
      $user = User::where("id", "=", $id_user)->first();
      $states = getState();
      $teachers = teacher::where("status", "=", 1)->select("id", "fullname")->get();
      $consults = consult::where("status", "=", 1)->select("id", "fullname")->get();
      return view("_manager.user.user_setting", compact("user", "states", "teachers", "consults"));
    } else
      return view('accessdenid');

  }

  public function updatePersonalSetting(Request $request)
  {
    if (Auth::user()->isManager()) {
      if (Auth::user()->can('edit-user')) {
        $username = $request->username;
        $user_name = $request->user_name;
        $fathername = $request->fathername;
        $user_nationalid = $request->user_nationalid;
        $user_id_markaz = $request->user_id_markaz;
        $user_talabeid = $request->user_talabeid;
        $user_serviceid = $request->user_serviceid;
        $user_birthdate = $request->user_birthdate;
        $user_gender = $request->user_gender;
        $user_married = $request->user_married;
        $state = $request->state;
        $city = $request->city;
        $user_id_teacher = $request->user_id_teacher;
        $user_id_consult = $request->user_id_consult;
        $level = $request->level;
        $id_user = $request->id_user;

        User::where('id', '=', $id_user)
          ->update([
            'name' => $user_name,
            'married' => $user_married,
            'gender' => $user_gender,
            'nationalid' => $user_nationalid,
            'id_markaz' => $user_id_markaz,
            'talabeid' => $user_talabeid,
            'serviceid' => $user_serviceid,
            'fathername' => $fathername,
            'birthdate' => $user_birthdate,
            'id_state' => $state,
            'id_city' => $city,
            'id_teacher' => $user_id_teacher,
            'id_consult' => $user_id_consult,
            'level' => $level,
          ]);

        return ($this->ajax_response(false, '', 'ثبت تظنیمات با موفقیت ثبت شد', 'success'));

      } else
        return response()->json($this->accessdenide_response);
    } else
      return response()->json($this->accessdenide_response);
  }

  public function increasWallet(Request $request)
  {
    if (Auth::user()->isManager()) {
      if (Auth::user()->can('edit-user')) {
        $user_in_price = $request->user_in_price;
        $user_in_memo = $request->user_in_memo;
        $id_user = $request->id_user;

        $user = User::where('id', '=', $id_user)->first();
        $user->wallet = $user->wallet + $user_in_price;
        $user->total_income = $user->total_income + $user_in_price;
        $user->save();
        if ($user->level == "teacher") {
          $teacher = teacher::where("id", "=", $user->id_teacher)->first();
          $teacher->wallet = $teacher->wallet + $user_in_price;
          $teacher->total_income = $teacher->total_income + $user_in_price;
          $teacher->save();
        } elseif ($user->level == "consult") {
          $consult = consult::where("id", "=", $user->id_consult)->first();
          $consult->wallet = $consult->wallet + $user_in_price;
          $consult->total_income = $consult->total_income + $user_in_price;
          $consult->save();
        }

        $py = new payment();
        $py->payment_for = "افزایش موجودی - ادمین";
        $py->id_user = $id_user;
        $py->product_course_title = $user_in_memo;
        $py->regist_date = nowDate_Shamsi();
        $py->price = $user_in_price;
        $py->payment_price = $user_in_price;
        $py->discount_percent = 0;
        $py->refID = "افزایش مجازی";
        $py->save();

        return ($this->ajax_response(false, '', 'افزایش موجودی کیف پول مجازی کاربر با موفقیت ثبت شد', 'success'));
      } else
        return response()->json($this->accessdenide_response);
    } else
      return response()->json($this->accessdenide_response);
  }

  public function decreasWallet(Request $request)
  {
    if (Auth::user()->isManager()) {
      if (Auth::user()->can('edit-user')) {
        $user_out_price = $request->user_out_price;
        $user_out_memo = $request->user_out_memo;
        $id_user = $request->id_user;

        $user = User::where('id', '=', $id_user)->first();
        $user->wallet = $user->wallet - $user_out_price;
        $user->total_income = $user->total_income - $user_out_price;
        $user->save();
        if ($user->level == "teacher") {
          $teacher = teacher::where("id", "=", $user->id_teacher)->first();
          $teacher->wallet = $teacher->wallet - $user_out_price;
          $teacher->total_income = $teacher->total_income - $user_out_price;
          $teacher->save();
        } elseif ($user->level == "consult") {
          $consult = consult::where("id", "=", $user->id_consult)->first();
          $consult->wallet = $consult->wallet - $user_out_price;
          $consult->total_income = $consult->total_income - $user_out_price;
          $consult->save();
        }

        $py = new payment();
        $py->payment_for = "کاهش موجودی - ادمین";
        $py->id_user = $id_user;
        $py->product_course_title = $user_out_memo;
        $py->regist_date = nowDate_Shamsi();
        $py->price = $user_out_price;
        $py->payment_price = $user_out_price;
        $py->discount_percent = 0;
        $py->refID = "کاهش مجازی";
        $py->save();

        return ($this->ajax_response(false, '', 'کاهش موجودی کیف پول مجازی کاربر با موفقیت ثبت شد', 'success'));

      } else
        return response()->json($this->accessdenide_response);
    } else
      return response()->json($this->accessdenide_response);
  }

  public function changeStatus(Request $request)
  {
    if (Auth::user()->isManager()) {
      if (Auth::user()->can('edit-user')) {
        $user_status = $request->user_status;
        $status_memo = $request->status_memo;
        $id_user = $request->id_user;

        $user = User::where('id', '=', $id_user)->first();
        $user->status = $user_status;
        $user->status_memo = $status_memo;
        $user->save();

        return ($this->ajax_response(false, '', 'ثبت وضعیت کاربر با موفقیت ثبت شد', 'success'));

      } else
        return response()->json($this->accessdenide_response);
    } else
      return response()->json($this->accessdenide_response);
  }

  public function changePermissions(Request $request)
  {
    if (Auth::user()->isManager()) {
      if (Auth::user()->can('edit-user')) {
        $wiki_permission = $request->wiki_permission;
        $course_permission = $request->course_permission;
        $lesson_permission = $request->lesson_permission;
        $shop_permission = $request->shop_permission;
        $consult_permission = $request->consult_permission;
        $req_permission = $request->req_permission;
        $blog_permission = $request->blog_permission;
        $hire_permission = $request->hire_permission;
        $user_permission = $request->user_permission;
        $teacher_permission = $request->teacher_permission;
        $news_permission = $request->news_permission;
        $category_permission = $request->category_permission;
        $landuse_permission = $request->landuse_permission;
        $vam_permission = $request->vam_permission;
        $markaz_permission = $request->markaz_permission;
        $id_user = $request->id_user;

        $user = User::where('id', '=', $id_user)->first();
        $user->wiki_permission = $wiki_permission;
        $user->course_permission = $course_permission;
        $user->lesson_permission = $lesson_permission;
        $user->shop_permission = $shop_permission;
        $user->consult_permission = $consult_permission;
        $user->req_permission = $req_permission;
        $user->blog_permission = $blog_permission;
        $user->hire_permission = $hire_permission;
        $user->user_permission = $user_permission;
        $user->teacher_permission = $teacher_permission;
        $user->news_permission = $news_permission;
        $user->category_permission = $category_permission;
        $user->landuse_permission = $landuse_permission;
        $user->vam_permission = $vam_permission;
        $user->markaz_permission = $markaz_permission;
        $user->save();

        return ($this->ajax_response(false, '', 'ثبت دسترسی های کاربر با موفقیت انجام شد', 'success'));


      } else
        return response()->json($this->accessdenide_response);
    } else
      return response()->json($this->accessdenide_response);
  }

  public function changePass(Request $request)
  {
    if (Auth::user()->isManager()) {

      if (Auth::user()->can('view-user')) {

        $newpass = $request->newpass;
        $renewpass = $request->renewpass;
        $response = [];
        if (strlen($newpass) < 8)
          return ($this->ajax_response(true, '', 'تعداد کاراکترهای کلمه عبور جدید کم است', 'error'));
        else {
          if ($newpass == $renewpass) {
            $id_user = $request->id_user;
            User::where('id', '=', $id_user)
              ->update([
                'password' => Hash::make($newpass)
              ]);

            return ($this->ajax_response(false, '', 'تغییر کلمه عبور  با موفقیت ثبت شد', 'success'));

          } else
            return ($this->ajax_response(true, '', 'کلمات عبور جدید یکسان نیستند', 'error'));
        }
      } else
        return response()->json($this->accessdenide_response);
    } else
      return response()->json($this->accessdenide_response);
  }

  public function add_user_form()
  {
    $states = getState();
    return view("_manager.user.add_user", compact("states"));
  }

  public function manager_user_detail($id_user, $title = null)
  {
    $user = User::where("id", "=", $id_user)->first();
    $states = getState();
    return view("_manager.user.detail_user", compact("user", "states"));
  }

  public function add_user(Request $request)
  {
    if (Auth::user()->can('edit-user')) {

      $username = $request->username;

      $exist_username = User::where("username", "=", $username)->count();
      if ($exist_username == 0) {
        $phonenumber = $request->phonenumber;
        $exist_phone = User::where("phonenumber", "=", $phonenumber)->count();
        if ($exist_phone == 0) {
          $user_name = $request->user_name;
          $fathername = $request->fathername;
          $user_mobile2 = $request->user_mobile2;
          $state = $request->state;
          $city = $request->city;
          if ($city == null)
            $city = 0;
          $user_tel_work = $request->user_tel_work;
          $user_tel = $request->user_tel;
          $user_address_work = $request->user_address_work;
          $user_address_home = $request->user_address_home;
          $user_married = $request->user_married;
          $user_job = $request->user_job;
          $user_gender = $request->user_gender;
          $user_birthdate = $request->user_birthdate;
          $user_nationalid = $request->user_nationalid;
          $user_email = $request->user_email;
          $user_password = $request->user_password;
          $user_postalcode = $request->user_postalcode;
          $user_level = $request->user_level;
          $user = new user();
          $code = generateIdeaCode();
          sleep(1);
          $imgFileName = '';
          if ($request->file('user_image')) {
            $folderPath = "_upload_/_users_/" . $code . "/personal";
            $imgFileName = uploadImageFile($request->file('user_image'), $folderPath);
            $user->image = $imgFileName;
          }

          $user->total_income = 0;
          $user->total_settle = 0;
          $user->wallet = 0;
          $user->code = $code;
          $user->username = $username;
          $user->username = $username;
          $user->phonenumber = $phonenumber;
          $user->mobile2 = $user_mobile2;
          $user->tel_work = $user_tel_work;
          $user->tel = $user_tel;
          $user->name = $user_name;
          $user->married = $user_married;
          $user->gender = $user_gender;
          $user->nationalid = $user_nationalid;
          $user->fathername = $fathername;
          $user->postalcode = $user_postalcode;
          $user->birthdate = $user_birthdate;
          $user->id_state = $state;
          $user->id_city = $city;
          $user->job = $user_job;
          $user->address = $user_address_home;
          $user->address_work = $user_address_work;
          $user->email = $user_email;
          $user->level = $user_level;
          $user->user_permission = 21;
          $user->chamber_permission = 0;

          $user->password = Hash::make($user_password);
          $user->save();
          return ($this->ajax_response(false, '', 'ثبت اطلاعات کاربر با موفقیت ثبت شد', 'success'));
        } else
          return ($this->ajax_response(true, '', 'شماره موبایل قبلا استفاده شده است', 'error'));
      } else
        return ($this->ajax_response(true, '', 'نام کاربری قبلا استفاده شده است', 'error'));
    } else
      return response()->json($this->accessdenide_response);
  }

  public function all_failure_tollab()
  {
    if (Auth::check()) {
      if (Auth::user()->level == "technical") {
        $users = User::where("corp", "=", "howzeh")
          ->where("corp_type", "=", "talabe")
          ->where("status", "=", 0)
          ->whereNull("talabeid")
          ->select("id", "firstname", "lastname", "name", "corp", "corp_type", "corp_relation", "takafolID", "nationality", "nationalid", "serviceid", "fathername", "birthdate", "id_state", "id_city", "status")
          ->get();
        return Datatables::of($users)->make(true);
      }
    }
  }

  public function tollab_failure()
  {
    return view("technical/tollab_failure");
  }

  public function tollab_complete()
  {
    return view("technical/tollab_complete");
  }

  public function dashboard()
  {
    $failure_talabe_count = User::where("corp", "=", "howzeh")
      ->where("corp_type", "=", "talabe")
      ->where("status", "=", 0)
      ->select("id")
      ->count();

    $failure_employee_count = User::where("corp", "=", "howzeh")
      ->where("corp_type", "=", "employee")
      ->where("status", "=", 0)
      ->select("id")
      ->count();

    $complete_talabe_count = User::where("corp", "=", "howzeh")
      ->where("corp_type", "=", "talabe")
      ->where("status", "=", 1)
      ->select("id")
      ->count();

    $complete_employee_count = User::where("corp", "=", "howzeh")
      ->where("corp_type", "=", "employee")
      ->where("status", "=", 1)
      ->select("id")
      ->count();

    return view("technical/dashboard", compact("failure_talabe_count", "failure_employee_count", "complete_talabe_count", "complete_employee_count"));
  }

  public function verify_user(Request $request)
  {

    $id = $request->id;
    $status = $request->status;
    if ($status == 'true')
      $status = 1;
    else
      $status = 0;
    $message = "";
    if ($status == true)
      $message = "هویت اطلاعات شما توسط مرکز خدمات حوزه های علمیه مورد تایید قرار گرفت.";
    else
      $message = "متاسفانه هویت شما توسط مرکز خدمات حوزه های علمیه تایید نشد. در صورتی که کماکان از اطلاعات ثبت شده خود مطمئن هستید به مرکز خدمات حوزه های علمیه استان خود مراجعه نمائید.";

    if (Auth::check()) {
      if (Auth::user()->level == "technical") {
        $user=User::where('id', '=', $id)
          ->where('corp','=','howzeh')
          ->first();

        if($status==1) {
          if ($user->corp_type == "talabe") {
            $user->vam_permission =31;
            $user->markaz_permission = 31;
            $user->status=$status;
            $user->status_memo=$message;
            $user->read_status_memo=0;

            // subsid
            $subsid = 0;
            if (!$user->yalda_1400) {
              $user->yalda_1400 = 1;
              if ($user->employed == 0 and $user->active == 1)
                $subsid = 250000;
              else
                $subsid = 50000;

              $user->subsid += $subsid;
            }

            //
            $user->save();
            $smsStatus = sendSMS_verify_technical($user->phonenumber,$user->name, $user->wallet,$user->username);
            if ($subsid > 0) {
              $smsStatus = sendSMS_Tabliq_subsid($user->phonenumber, $user->name, $subsid);
            }
          }
        }
        else{
          if ($user->corp_type == "talabe") {
            $user->vam_permission =0;
            $user->markaz_permission = 0;
            $user->status=$status;
            $user->status_memo=$message;
            $user->read_status_memo=0;
            $user->save();
          }
        }


      }
    }

    return ($this->ajax_response(false, '', 'وضعیت ثبت نام کاربر بروزرسانی شد', 'success'));
  }

  public function employee_failure()
  {
    return view("technical/employee_failure");
  }

  public function all_failure_employee()
  {
    if (Auth::check()) {
      if (Auth::user()->level == "technical") {
        $users = User::where("corp", "=", "howzeh")
          ->where("corp_type", "=", "employee")
          ->where("status", "=", 0)
          ->select("id", "firstname", "lastname", "name", "corp", "corp_type", "corp_relation", "takafolID", "nationality", "nationalid", "serviceid", "fathername", "personal_code","birthdate", "id_state", "id_city", "status")
          ->get();
        return Datatables::of($users)->make(true);
      }
    }
  }

  public function technical_settings()
  {
    return view("technical.settings");
  }

  public function notification()
  {
    $courses=course::select('id','image','code','title','old_price','price')->get();
    return view("user.notification",compact('courses'));
  }

  public function viewuser($id)
  {
    if(Auth::check()){
      if(Auth::user()->level='technical'){
        $user=User::where("id","=",$id)->select("id","firstname","lastname","fathername","nationalid","serviceid","nationality","corp_type","corp_relation","birthdate","personal_code","employed","active")->first();
        return ($this->ajax_response(false, $user, '', 'success'));
      }
      else{
        return ($this->ajax_response(true, '', 'شما دسترسی به این قسمت را ندارد', 'error'));
      }
    }
    else
      return ($this->ajax_response(true, '', 'شما دسترسی به این قسمت را ندارد', 'error'));
  }

  function updateUserinfo_technical(Request $request){
    if(Auth::check()){
      if(Auth::user()->level='technical'){
        $user=User::where("id","=",$request->userID)->first();
        if (isset($request->hide) and $request->hide === 'true') {
          $user->talabeid= 'hide';
          $user->save();
          return ($this->ajax_response(false, '', 'حذف کاربر انجام شد', 'success'));
        }

        $user->firstname= $request->firstname;
        $user->lastname= $request->lastname;
        $user->name= $request->firstname . ' '.$request->lastname;
        $user->fathername= $request->fathername;
        $user->corp_type= $request->corp_type;
        $user->corp_relation= $request->corp_relation;
        $user->nationality= $request->country;
        $user->nationalID= $request->nationalID;
        $user->birthdate= $request->birthdate;
        $user->employed = $request->employed == '1' ? 1 : 0;
        $user->active = $request->active == '1' ? 1 : 0;

        if($request->corp_type=="talabe"){
          $user->serviceId= $request->serviceID;
          $user->id_markaz= $request->serviceID;
        }
        elseif($request->corp_type=="employee")
          $user->personal_code= $request->personal_code;

        $user->save();
        return ($this->ajax_response(false, '', 'تغییرات ثبت شد', 'success'));
      }
      else{
        return ($this->ajax_response(true, '', 'شما دسترسی به این قسمت را ندارد', 'error'));
      }
    }
    else
      return ($this->ajax_response(true, '', 'شما دسترسی به این قسمت را ندارد', 'error'));
  }

  function employed_true(Request $request){
    $user = Auth::user();
    if (Auth::check() and !empty($user)){
      if ($user->employed === null and $user->corp_type === 'talabe' and $user->status === 1 and $user->id_markaz > 0){
        $exists = User::whereNotNull('employed')->where('id_markaz', $user->id_markaz)->count();
        if ($exists) {
          User::where('id', '=', $user->id)
            ->update([
              'employed' => 1
            ]);
        }
        else {
          User::where('id', '=', $user->id)
            ->update([
              'employed' => 1,
              'wallet' => intval($user->wallet) + 160000
            ]);
          sendSMS_Yarane($user->phonenumber, $user->name, 160000);
        }
      }
    }
    return redirect('https://kasboom.ir/web');
  }

  function employed_false(Request $request){
    $user = Auth::user();
    if (Auth::check() and !empty($user)){
      if ($user->employed === null and $user->corp_type === 'talabe' and $user->status === 1 and $user->id_markaz > 0){
        $exists = User::whereNotNull('employed')->where('id_markaz', $user->id_markaz)->count();
        if ($exists) {
          User::where('id', '=', $user->id)
            ->update([
              'employed' => 0
            ]);
        }
        else {
          User::where('id', '=', $user->id)
            ->update([
              'employed' => 0,
              'wallet' => intval($user->wallet) + 100000
            ]);
          sendSMS_Yarane($user->phonenumber, $user->name, 100000);
        }
      }
    }
    return redirect('https://kasboom.ir/web');
  }


  function getinfog2etinfo2()
  {



    $from=11000;
    $to=12000;
    $users=User::where('corp_type','=','talabe')->where("id",">",$from)->where("id","<=",$to)->select('id','id_markaz','nationalid','birthdate')->get();
    //$users=User::where('id','=',10646)->get();


    //$users=User::where("id_state","=",0)->where('corp_type','=','talabe')->select('id','id_markaz','nationalid','birthdate')->get();
    //   $users=User::where('corp_type','=','talabe')->select('id','id_markaz','nationalid','birthdate')->get();




    $client = new Client();
    $url = "https://apiconsole.csis.ir/Token";
    $response = $client->request('POST', $url, [
      'verify' => false,
      'form_params' => [
        'Username' => "kasbeboom",
        'Password' => "csis.kasbboom.ir@!$%",
        'grant_type' => "password"
      ]
    ]);
    if ($response->getStatusCode() == 200) {
      $response_data = json_decode($response->getBody());
      $token = $response_data->access_token;
      $url="https://apiconsole.csis.ir/api/service/kasbboom/check_states/canvas_student";




      foreach ($users as $user) {
        $params = [
          //'Codm' => '281086',
          //    'FamilyMemberType' => 0,
          //  'NationalId' => '5550109621',
          //    'BirthDate' => '1374/01/26',
          //  'Tabee' => '1'
          'Codm' => $user->id_markaz,
          'FamilyMemberType' => 0,
          'NationalId' => $user->nationalid,
          'BirthDate' => $user->birthdate,
          'Tabee' => '1'

        ];

        $response_check = $client->request('POST', $url, [
          'headers' => ['Authorization' => $token],
          'form_params' => $params,
          'verify' => false,
        ]);

        $response_data_check = json_decode($response_check->getBody());
        //dd($response_data_check->Data);
        if( $response_data_check->Data != null){
          $isExist = $response_data_check->Data[0]->isvalid;
          if($isExist == true){
            $isEmployed = $response_data_check->Data[0]->IsEmployed;
            if($isEmployed==false)
              $user-> employed =0;
            else{
              $user-> employed =1;
              //dd($params);
            }

            $user->save();
          }


        }
      }

    }







// //        try{
//             $response_check = $client->request('POST', $url, [
//               'headers' => ['Authorization' => $token],
//               'form_params' => $params,
//               'verify' => false,
//             ]);

//             $response_data_check = json_decode($response_check->getBody());
//             dd($response_data_check);
//             if ($response_data_check->Success ==true) {
//                 if(!$response_data_check->Data[0])
//                 {
//                     echo ($user->id);
//                     echo "<br>";
//                     continue;
//                 }
//               $isExist = $response_data_check->Data[0]->isvalid;
//               if($isExist == true){

//     //            $countTakafol = $response_data_check->Data[0]->CountTakaffol;
//       //          $takafolID = $response_data_check->Data[0]->idTakaffol;
//         //        $id_branch = $response_data_check->Data[0]->BranchId;
//           //      $branchTitle = $response_data_check->Data[0]->BranchTitle;
//             //    $id_agent = $response_data_check->Data[0]->AgentId;
//               //  $agentTitle = $response_data_check->Data[0]->AgentTitle;
//                 //$provinceId = $response_data_check->Data[0]->ProvinceId;
//                 // $cityTitle = $response_data_check->Data[0]->CityTitle;
//                 //$address = $response_data_check->Data[0]->FullAddress;
//                 //$postalCode = $response_data_check->Data[0]->ZipCode;


//                 //$user_state_id=getmystate($provinceId);


//             //    $user->id_state=$user_state_id;
//              //   $user->address=$address;
//               // $user->postalcode = $postalCode;
//             //    $user->id_markaz_branch = $id_branch;
//             //    $user->id_markaz_agent = $id_agent;
//              //   $user->countTakaffol = $countTakafol;
//                 $user->employed=1;
//                 $user->status=1;
//                 $user->save();
//                 //dd($params,$response_data_check->Data,$user);


//               };
//             }
//   //      }
//     //    catch (exception $e) {
//       //     echo $params;
//         //}




    //   }
    // }

  }


  public function csisLogin(){
    //dd(request()->all());
    $user_token = request()->token;
    // dd($user_token);
    $client = new Client();
    $url = 'https://apiconsole.csis.ir/Token';
    try {
      $response = $client->request('POST', $url, [
        'verify' => false,
        'form_params' => [
          'Username' => 'kasbeboom',
          'Password' => 'csis.kasbboom.ir@!$%',
          'grant_type' => 'password'
        ]
      ]);
    }
    catch (GuzzleHttp\Exception\ClientException $e) {
      $response = $e->getResponse();
      $responseBodyAsString = $response->getBody()->getContents();

    }

    $response_data = json_decode($response->getBody());
    $token = $response_data->access_token;

    $params = [
      'Token' => $user_token
    ];

    $url = 'https://apiconsole.csis.ir/api/service/kasboom/info/Kasboom_GetInfoByToken';

    $response_check = $client->request('POST', $url, [
      'headers' => [ 'Authorization' => 'Bearer ' . $token ],
      'form_params' => $params,
      'verify' => false,
    ]);

    $response_data_check = json_decode($response_check->getBody());

    if($response_data_check->Success) {
      $CodM = isset($response_data_check->Data[0]->CodM) ? $response_data_check->Data[0]->CodM : 0;
      $FirstName = isset($response_data_check->Data[0]->FirstName) ? $response_data_check->Data[0]->FirstName : 0;
      $LastName = isset($response_data_check->Data[0]->LastName) ? $response_data_check->Data[0]->LastName : 0;
      $BirthDatePersian = isset($response_data_check->Data[0]->BirthDatePersian) ? $response_data_check->Data[0]->BirthDatePersian : 0;
      $BranchId = isset($response_data_check->Data[0]->BranchId) ? $response_data_check->Data[0]->BranchId : 0;
      $BranchTitle = isset($response_data_check->Data[0]->BranchTitle) ? $response_data_check->Data[0]->BranchTitle : 0;
      $AgentId = isset($response_data_check->Data[0]->AgentId) ? $response_data_check->Data[0]->AgentId : 0;
      $AgentTitle = isset($response_data_check->Data[0]->AgentTitle) ? $response_data_check->Data[0]->AgentTitle : 0;
      $CenterCode = isset($response_data_check->Data[0]->CenterCode) ? $response_data_check->Data[0]->CenterCode : 0;
      $ProvinceId = isset($response_data_check->Data[0]->ProvinceId) ? $response_data_check->Data[0]->ProvinceId : 0;
      $CityId = isset($response_data_check->Data[0]->CityId) ? $response_data_check->Data[0]->CityId : 0;
      $FullAddress = isset($response_data_check->Data[0]->FullAddress) ? $response_data_check->Data[0]->FullAddress : 0;
      $ZipCode = isset($response_data_check->Data[0]->ZipCode) ? $response_data_check->Data[0]->ZipCode : 0;
      $NationalId = isset($response_data_check->Data[0]->NationalId) ? $response_data_check->Data[0]->NationalId : 0;
      $Mobile = isset($response_data_check->Data[0]->Mobile) ? $response_data_check->Data[0]->Mobile : 0;
      $Tabee = isset($response_data_check->Data[0]->Tabee) ? $response_data_check->Data[0]->Tabee : 0;
      $countTakafol = isset($response_data_check->Data[0]->TakafolCount) ? $response_data_check->Data[0]->TakafolCount : 0;
      $takafolID = isset($response_data_check->Data[0]->TakafolId) ? $response_data_check->Data[0]->TakafolId : 0;
      $relation = "sarparast";
      if($takafolID != 0)
        $relation = "takafol";

      $subsid = 50000;
      $user = User::where('username', $Mobile)->orwhere('username', '0'.$Mobile)->first();
      if (!$user){
        $user_state_id = getmystate($ProvinceId);

        $code = generateIdeaCode();
        $nowdate_shamsi = nowDate_Shamsi();
        $user = new User();
        $user->code = $code;
        $user->firstname = $FirstName;
        $user->lastname = $LastName;
        $user->fathername = '';;
        $user->name = $FirstName. ' '.$LastName;
        $user->id_markaz = $CenterCode;
        $user->serviceid = $CenterCode;
        $user->image = '';
        $user->personal_code = $CodM;
        $user->nationality = $Tabee;
        $user->twostep_auth = 0;
        $user->countTakaffol = $countTakafol;
        $user->id_state = $user_state_id;
        // $user->id_city = $user_city_id;
        $user->id_markaz_branch = $BranchId;
        $user->id_markaz_agent = $AgentId;
        $user->username = $Mobile;
        $user->nationalid = $NationalId;
        $user->password = Hash::make($Mobile.'313');
        $user->phonenumber = $Mobile;
        $user->address = $FullAddress;
        $user->postalcode = $ZipCode;
        $user->regist_date = $nowdate_shamsi;
        $user->level = "user";
        $user->corp = "howzeh";
        $user->corp_type = "talabe";
        $user->corp_relation = $relation;
        $user->takafolID = $takafolID;
        $user->wiki_permission = 0;
        $user->course_permission = 0;
        $user->lesson_permission = 0;
        $user->shop_permission = 100;
        $user->consult_permission = 0;
        $user->req_permission = 0;
        $user->webinar_permission = 0;
        $user->blog_permission = 0;
        $user->hire_permission = 0;
        $user->user_permission = 21;
        $user->teacher_permission = 0;
        $user->news_permission = 0;
        $user->category_permission = 0;
        $user->landuse_permission = 0;
        $user->vam_permission = 31;
        $user->markaz_permission = 31;
        $user->chamber_permission = 0;
        $user->birthdate = $BirthDatePersian;
        $user->total_income = 0;
        $user->total_settle = 0;
        $user->wallet = 0;
        $user->status = 1;
        $user->employed=0;
        $user->status_memo = '';
        $user->subsid = $subsid;
        $user->yalda_1400 =0;
        $user->is_logout =0;
        $user->save();
        $password=$Mobile.'313';
        $username = $Mobile;
        return view("auth.register_csis",compact("username","password"));
      }
      else{
        $username = $Mobile;
        $password=$Mobile.'313';
        return view("auth.register_csis",compact("username","password"));
      }
    }
  }

}
