<?php

namespace App\Http\Controllers;

use App\Models\state;
use App\Models\User;
use App\Models\UserAddress;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

  public function register() {

    if (Auth::check()){
      if(Auth::user()->is_logout == 1) {
        Auth::logout();
        Session::flush();

        $states = state::where('id', '>', 0)->get();
        $urlOld = url()->previous();
        $urlPush = $urlOld;
        $urlArray = [url('logout'), ];
        if (in_array($urlOld, $urlArray))
          $urlPush = url('/web');

        return view('auth/register', compact('states', 'urlPush'));
      }
      else
        return redirect('web');
    }
    else{
      $states = state::where('id', '>', 0)->get();
      $urlOld = url()->previous();
      $urlPush = $urlOld;
      $urlArray = [url('logout'), ];
      if (in_array($urlOld, $urlArray))
        $urlPush = url('/web');

      return view('auth/register', compact('states', 'urlPush'));
    }
  }

  public function registerCheckPhonenumber() {

    if (Validator::make(request()->all(), ['phonenumber' => 'required'])->fails())
      return response()->json(['message' => 'فیلد شماره موبایل را لطفا پر کنید'],403);

    if (Validator::make(request()->all(), ['phonenumber' => 'digits_between:10,11'])->fails())
      return response()->json(['message' => 'شماره موبایل باید 10 یا 11 کارکتر داشته باشد'],403);

    $user = User::whereIn('phonenumber', [(int)request()->phonenumber, request()->phonenumber])->first();
    if($user) {
      if($user->verify_phonenumber === 1)
        return response()->json(['message' => 'شما قبلا ثبت نام کرده اید , لطفا رمزتان را وارد کنید', 'status' => 'card5'],200);

//    send sms code
      $this->sendSmsPhonenumberVerifyCode($user, 'verify');
      return response()->json(['message' => 'شما قبلا ثبت نام کرده اید , لطفا جهت تایید موبایل کد پیامک شده را وارد کنید', 'status' => 'card4'], 200);
    }

    return response()->json(['message' => 'لطفا یکی از بخش را انتخاب کنید', 'status' => 'card2'],200);
  }

  public function registerStore () {
//    validate phonenumber & name & lastName & state & birthdate & nationalid
    if (Validator::make(request()->all(), ['phonenumber' => 'required|digits_between:10,11'])->fails())
      return response()->json(['message' => 'شماره موبایل باید 10 یا 11 کارکتر داشته باشد'],403);

    $phonenumber = convert_to_number(request()->phonenumber);
    $userPhone = User::whereIn('phonenumber', [(int)$phonenumber, $phonenumber])->first();
    if($userPhone)
      return response()->json(['message' => 'با این شماره قبلا ثبت نام انجام شده است'],403);

    $phonenumber = (int)$phonenumber;
    if (Validator::make(request()->all(), ['name' => 'required'])->fails())
      return response()->json(['message' => 'لطفا فیلد نام را پر کنید'],403);

    if (Validator::make(request()->all(), ['lastName' => 'required'])->fails())
      return response()->json(['message' => 'لطفا فیلد نام خانوادگی را پر کنید'],403);

    $type = request()->type;
    if ($type !== 'type4') {
      $stateId = request()->state;
      $state = state::where('id', $stateId)->first();
      if(!$state || $state->id === 0)
        return response()->json(['message' => 'لطفا یکی از استان هارا انتخاب کنید'],403);
    }

    $year = convert_to_number(request()->year);
    $month = convert_to_number(request()->month);
    $day = convert_to_number(request()->day);
    $birthdate = $year .'/'. $month .'/'. $day;
    if (Validator::make(['birthdate' => $birthdate], ['birthdate' => 'required|date_format:Y/m/d'])->fails())
      return response()->json(['message' => 'تاریخ تولد انتخاب شده معتبر نمی باشد , لطفا دوباره امتحان کنید'],403);

    if (in_array($type, ['type2', 'type3'])) {
      $nationalid = convert_to_number(request()->nationalid);
      if (Validator::make(['nationalid' => $nationalid], ['nationalid' => 'required'])->fails())
        return response()->json(['message' => 'لطفا فیلد کد ملی را پر کنید'],403);

      if (Validator::make(['nationalid' => $nationalid], ['nationalid' => 'digits:10'])->fails())
        return response()->json(['message' => 'فیلد کد ملی باید 10 کارکتر باشد'],403);

      $userNational = User::where('nationalid', $nationalid)->first();
      if($userNational) {
        $miniphone1 = substr($userNational->phonenumber, 0, 3) ;
        $miniphone2 = substr($userNational->phonenumber, 7, 4) ;
        $miniphone = $miniphone2 . '****' . $miniphone1;
        return response()->json(['message' => 'کد ملی تکراری است , یعنی قبلا با این کدملی , با این شماره ' . $miniphone . ' ثبت نام شده است'],403);
      }
    } else $nationalid = '';

    $country = 1;
    $corp = 'howzeh';
    $fathername = '';
    $name = request()->name;
    $lastName = request()->lastName;
    $fullname = $name . ' ' . $lastName;
    $personalCode = '';

//    select type
    if ($type === 'type1') {
//    azad
      $corp = '';
      $corpType = '';
      $corpRelation = '';
      $markazId = '';
      $address = '';
      $id_branch = 0;
      $id_agent = 0;
      $imageName = '';
      $postalCode = '';
      $takafolID = 0;
      $status_memo = '';
      $countTakafol = 0;
      $subsid = 50000;
    }
    elseif ($type === 'type2') {
//    employee
      $markazId = '';
      $corpType = 'employee';
      $personalCode = request()->personal_code;
      if (Validator::make(['personal_code' => $personalCode], ['personal_code' => 'required'])->fails())
        return response()->json(['message' => 'لطفا فیلد کد پرسنلی را پر کنید'],403);

      $fathername = request()->fathername;
      if (Validator::make(['fathername' => $fathername], ['fathername' => 'required'])->fails())
        return response()->json(['message' => 'لطفا فیلد نام پدر را پر کنید'],403);
    }
    elseif ($type === 'type3') {
//    talabe irani
      $corpType = 'talabe';
    }
    elseif ($type === 'type4') {
//    talabe khareji
      $corpType = 'talabe';
      $fathername = request()->fathername;
      if (Validator::make(['fathername' => $fathername], ['fathername' => 'required'])->fails())
        return response()->json(['message' => 'لطفا فیلد نام پدر را پر کنید'],403);

//      befor verify markaz
      $markazId = request()->id_markaz;
      $subsid_exists = User::where([['id_markaz', $markazId], ['yalda_1400', 1]])->count();
      $subsid = $subsid_exists ? 50000 : 0;
      $corpRelation = request()->corp_relation;
      $address = '';
      $id_branch = 0;
      $id_agent = 0;
      $imageName = '';
      $postalCode = '';
      $takafolID = 0;
      $countTakafol = 0;
      if (Validator::make(['corp_relation' => $corpRelation], ['corp_relation' => 'required'])->fails())
        return response()->json(['message' => 'لطفا فیلد نسبت را پر کنید'],403);
      // $status_memo = " طلبه ارجمند آقا/خانم " . $fullname . " هویت شما توسط مرکز خدمات حوزه های علمیه تایید شد. زین پس می توانید از کلیه خدمات سامانه کسب بوم با حمایت مرکز خدمات حوزه های علمیه استفاده نمائید. ";
      $status_memo = " طلبه ارجمند آقا/خانم " . $fullname . " هویت شما توسط مرکز خدمات حوزه های علمیه تایید گردید";

      $country = 0;
      $stateId = 19;
    }

//    only markaz khadamat
    $code = generateIdeaCode();
    if ($type !== 'type1' && $type !== 'type4') {
      if (in_array($type, ['type3', 'type4'])) {
        $markazId = request()->id_markaz;
        if (Validator::make(['id_markaz' => $markazId], ['id_markaz' => 'required'])->fails())
          return response()->json(['message' => 'لطفا فیلد کد مرکز را پر کنید'],403);

        $subsid_exists = User::where([['id_markaz', $markazId], ['yalda_1400', 1]])->count();
        $subsid = $subsid_exists ? 0 : 50000;
      } else if ($type !== 'type2') {
        $subsid = 0;
      }

      $corpRelation = request()->corp_relation;
      if (Validator::make(['corp_relation' => $corpRelation], ['corp_relation' => 'required'])->fails())
        return response()->json(['message' => 'لطفا فیلد نسبت را پر کنید'],403);

      if ($corpRelation === 'sarparast') $familyMemberType = 0;
      else $familyMemberType = 1;


//      get token markaz
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


      //   if ($response->getStatusCode() !== 200)
      //     return response()->json(['message' => 'هنگام استعلام از مرکز خدمات خطایی رخ داد . لطفا دوباره امتحان کنید یا با پشتیبانی تماس بگیرید'], 403);


      $response_data = json_decode($response->getBody());
      $token = $response_data->access_token;

//      set params for request to markaz
      if ($corpType === 'talabe') {
        $url = 'https://apiconsole.csis.ir/api/service/kasbboom/check_states/canvas_student';
        $url_img = 'https://mkh03.csis.ir/api/services/business_canvas/students/' . $markazId . '/profile_image';
        $imageName = $markazId . '.jpg';
        if ($country === 1) {
          $params = [
            'Codm' => $markazId,
            'FamilyMemberType' => $familyMemberType,
            'NationalId' => $nationalid,
            'BirthDate' => $birthdate,
            'Tabee' => $country
          ];
        } else {
          $params = [
            'Codm' => $markazId,
            'FamilyMemberType' => $familyMemberType,
            'FirstName' => $name,
            'LastName' => $lastName,
            'FatherName' => $fathername,
            'BirthDate' => $birthdate,
            'Tabee' => $country
          ];
        }
      } else {
        $url = 'https://apiconsole.csis.ir/api/service/kasbboom/check_states/canvas_personnel';
        $url_img = 'https://mkh03.csis.ir/api/services/business_canvas/personnels/' . $personalCode . '/profile_image';
        $imageName = $personalCode . ".jpg";
        $params = [
          'Codm' => $personalCode,
          'FamilyMemberType' => $familyMemberType,
          'NationalId' => $nationalid,
          'BirthDate' => $birthdate,
          'FirstName' => $name,
          'LastName' => $lastName,
          'FatherName' => $fathername,
          'Mobile' => $phonenumber
        ];
      }

      $response_check = $client->request('POST', $url, [
        'headers' => [ 'Authorization' => 'Bearer ' . $token ],
        'form_params' => $params,
        'verify' => false,
      ]);

      $response_data_check = json_decode($response_check->getBody());

      if(!$response_data_check->Success || empty($response_data_check))
        return response()->json(['message' => 'هنگام استعلام اطلاعات هویتی شما از سیستم مرکز خدمات خطایی رخ داد . لطفا دوباره امتحان کنید.'], 403);

      $isExist = $response_data_check->Data[0]->isvalid;
      if (!$isExist)
        return response()->json(['message' => 'اطلاعات شما توسط سیستم مرکز خدمات تایید نشد . لطفا اطلاعات را صحیح وارد کنید'], 403);


      $countTakafol = isset($response_data_check->Data[0]->CountTakaffol) ? $response_data_check->Data[0]->CountTakaffol : 0;
      $takafolID = isset($response_data_check->Data[0]->idTakaffol) ? $response_data_check->Data[0]->idTakaffol : 0;
      $id_branch = isset($response_data_check->Data[0]->BranchId) ? $response_data_check->Data[0]->BranchId : 0;
      $id_agent = isset($response_data_check->Data[0]->AgentId) ? $response_data_check->Data[0]->AgentId : 0;
      $provinceId = isset($response_data_check->Data[0]->ProvinceId) ? $response_data_check->Data[0]->ProvinceId : 0;
      $address = isset($response_data_check->Data[0]->FullAddress) ? $response_data_check->Data[0]->FullAddress : '';
      $postalCode = isset($response_data_check->Data[0]->ZipCode) ? $response_data_check->Data[0]->ZipCode : 0;
      $stateId = getmystate($provinceId);

//    kashan
      if ($id_branch === 26) $stateId = 48;
//    pardisan
      if ($id_branch === 45 or $id_agent===45){
        $stateId = 45;
        $id_branch=45;
        $id_agent=45;
      }


      if ($corpType === 'talabe')
        $status_memo = " طلبه ارجمند آقا/خانم " . $fullname . " هویت شما توسط مرکز خدمات حوزه های علمیه تایید گردید. ";
      if ($corpType === 'employee')
        $status_memo = ' کارمند ارجمند آقا/خانم ' . $fullname . ' هویت شما توسط مرکز خدمات حوزه های علمیه تایید گردید';

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

      if(!file_exists( public_path() . $path)) $imageName = '';
      if ($corpRelation === 'takafol') $imageName = '';
    }

//    store user
    $user = new User;
    $user->code = $code;
    $user->firstname = $name;
    $user->lastname = $lastName;
    $user->fathername = $fathername;
    $user->name = $fullname;
    $user->id_markaz = $markazId;
    $user->serviceid = $markazId;
    $user->image = $imageName;
    $user->personal_code = $personalCode;
    $user->nationality = $country;
    $user->countTakaffol = $countTakafol;
    $user->id_state = $stateId;
    $user->id_markaz_branch = $id_branch;
    $user->id_markaz_agent = $id_agent;
    $user->username = $phonenumber;
    $user->nationalid = $nationalid;
    $user->password = '';
    $user->phonenumber = $phonenumber;
    $user->address = $address;
    $user->postalcode = $postalCode;
    $user->regist_date = nowDate_Shamsi();
    $user->corp = $corp;
    $user->corp_type = $corpType;
    $user->corp_relation = $corpRelation;
    $user->takafolID = $takafolID;
    $user->birthdate = $birthdate;
    $user->status_memo = $status_memo;
    $user->subsid = $subsid;
    $user->yalda_1400 = $subsid === 0 ? 1 : 0;
    $user->verify_code = null;
    $user->verify_code_mistake = 0;
    $user->level = 'user';
    $user->twostep_auth = 0;
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
    $user->total_income = 0;
    $user->total_settle = 0;
    $user->wallet = 0;
    $user->status = 1;
    $user->employed = null;
    $user->verify_phonenumber = 0;
    $user->save();

//    store address for markaz khadamat
    if ($type !== 'type1' && $type !== 'type4') {
      $usera = new UserAddress;
      $usera->id_user = $user->id;
      $usera->full_name = $fullname;
      $usera->id_state = $stateId;
      $usera->id_city = 0;
      $usera->postal_code = (strlen($postalCode) < 5) ? 0 : $postalCode;
      $usera->address = $address;
      $usera->phone = $phonenumber;
      $usera->mobile = $phonenumber;
      $usera->save();
    }

//    send verify code sms
    $this->sendSmsPhonenumberVerifyCode($user, 'verify');
    return response()->json(['message' => 'ثبت نام انجام شد . پیامکی حاوی کد تایید برای شما ارسال شد . لطفا کد را وارد کنید تا شماره موبایلتان تایید و ثبت نام کامل شود'],200);
  }

  public function sendVerifyPhonenumber() {
    if (Validator::make(request()->all(), ['phonenumber' => 'required|digits_between:10,11'])->fails())
      return response()->json(['message' => 'ابتدا شماره همراه خود را وارد کنید', 'status' => 'card1'],403);

    $phonenumber = convert_to_number(request()->phonenumber);
    $user = User::whereIn('phonenumber', [(int)$phonenumber, $phonenumber])->first();
    if(!$user)
      return response()->json(['message' => 'کاربری یافت نشد . با این شماره ثبت نامی نشده است', 'status' => 'card1'],403);

    $type = request()->type;
    if ($type === 'password') {
      if($user->verify_phonenumber !== 1) {
        $this->sendSmsPhonenumberVerifyCode($user, 'verify');
        return response()->json(['message' => 'شماره همراه شما تایید نشده است. کد تایید شماره همراه پیامک شد', 'status' => 'card4'],403);
      }
      $typeSms = 'password';
      $message = 'رمز یکبار مصرف پیامک شد';
    } else {
      $typeSms = 'verify';
      $message = 'کد تایید پیامک شد';
    }


    $this->sendSmsPhonenumberVerifyCode($user, $typeSms);
    return response()->json(['message' => $message],200);
  }



  public function checkDisposablePassword() {
    if (Validator::make(request()->all(), ['phonenumber' => 'required|digits_between:10,11'])->fails())
      return response()->json(['message' => 'ابتدا شماره همراه خود را وارد کنید', 'status' => 'card1'],403);

    $phonenumber = convert_to_number(request()->phonenumber);
    $user = User::whereIn('phonenumber', [(int)$phonenumber, $phonenumber])->first();
    if(!$user)
      return response()->json(['message' => 'کاربری یافت نشد . با این شماره ثبت نامی نشده است', 'status' => 'card1'],403);

    if($user->verify_phonenumber !== 1) {
      $this->sendSmsPhonenumberVerifyCode($user, 'verify');
      return response()->json(['message' => 'شماره همراه شما تایید نشده است . کد تایید پیامک شد', 'status' => 'card4'],403);
    }

    $verifyCode = (int)request()->verifyCode;
    if (Validator::make(request()->all(), ['verifyCode' => 'required|digits:5'])->fails())
      return response()->json(['message' => 'فیلد کد تایید باید 5 کارکتر باشد'],403);

//    check code mistake
    if ($user->verify_code_mistake >= 5) {
//    send verify code sms
      $this->sendSmsPhonenumberVerifyCode($user, 'verify');
      return response()->json(['message' => 'تعداد دفعات رمز بیش تر از حد مجاز شد , رمز جدیدی برای شما ارسال شد'],403);
    }

//    check verify code
    if ($verifyCode !== $user->verify_code) {
      $user->verify_code_mistake = $user->verify_code_mistake + 1;
      $user->save();
      return response()->json(['message' => 'رمز وارد شده اشتباه است'],403);
    }


//    login user
    Auth::login($user, true);
    $user->is_logout =0;
    $user->save();
//    $this->checkIsLogout($user);
    return response()->json([],200);
  }

  public function verifyPhonenumber () {
    $phonenumber = convert_to_number(request()->phonenumber);
    $user = User::whereIn('phonenumber', [(int)$phonenumber, $phonenumber])->first();
    if(!$phonenumber || !$user)
      return response()->json(['message' => 'کاربری یافت نشد'],403);

    $phonenumber = (int)$phonenumber;
    if($user->verify_phonenumber === 1)
      return response()->json(['message' => 'شماره همراه شما قبلا تایید شده است . لطفا در قسمت ورود , رمزتان را وارد کنید', 'status' => 'card5'],403);

    $verifyCode = (int)request()->verifyCode;
    // if (Validator::make(request()->all(), ['verifyCode' => 'required|digits:5'])->fails())
    //   return response()->json(['message' => 'فیلد کد تایید باید 5 کارکتر باشد'],403);

//    check code mistake
    if ($user->verify_code_mistake >= 5) {
//    send verify code sms
      $this->sendSmsPhonenumberVerifyCode($user, 'verify');
      return response()->json(['message' => 'تعداد دفعات ورود کد بیش تر از حد مجاز شد , کد جدیدی برای شما ارسال شد'],403);
    }

//    check verify code
    if ($verifyCode !== $user->verify_code) {
      $user->verify_code_mistake = $user->verify_code_mistake + 1;
      $user->save();
      return response()->json(['message' => 'کد تایید وارد شده اشتباه می باشد'],403);
    }

//    accept verify phonenumber
    $password = rand(1000000, 9999999);
    $user->verify_phonenumber = 1;
    $user->password = Hash::make($password);
    $user->save();
    $message='';
    $fullname = $user->firstname . ' ' . $user->lastname;
//    send sms password  for markaz khadamat or azad
    if ($user->corp === 'howzeh') {
      if ($user->corp_type === 'talabe')
        $message = "سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد";
      if ($user->corp_type === 'employee')
        $message = 'سلام؛ ثبت نام شما در سایت کسب بوم با موفقیت انجام شد';

      sendSMS_Register_howzeh($fullname, $phonenumber, $phonenumber, $message, $password);
    }
    else sendSMS_Register_Azad($fullname, $phonenumber, $phonenumber, $password);

    $subsid = $user->subsid;
    //if ($subsid > 0) sendSMS_Register_subsid($fullname, $phonenumber, $subsid);

//    login user
    Auth::login($user, true);
    $user->is_logout =0;
    $user->save();
//    $this->checkIsLogout($user);

    return response()->json(['message' => 'ثبت نام با موفقیت کامل شد و رمز عبور پیامک شد'],200);
  }

  private function sendSmsPhonenumberVerifyCode($user, $typeSms) {
    $newVerifyCode = rand(10000,99999);
    $user->verify_code = $newVerifyCode;
    $user->verify_code_mistake = 0;
    $user->save();

    if ($typeSms === 'password')
      sendSMS_Disposable_Password_user($user->name, $user->phonenumber, $newVerifyCode);
    else
      sendSMS_Verify_Code_user($user->name, $user->phonenumber, $newVerifyCode);
  }

  private function checkIsLogout ($user) {
    if ($user->is_logout === 0) {
      $user->is_logout = 1;
      $user->save();
    }
  }


  public function sendSmsPhonenumberVerifyCodeTest() {
    $newVerifyCode = rand(10000,99999);
    sendSMS_Verify_Code_user('حسن', '09055165955', $newVerifyCode);
  }

}
