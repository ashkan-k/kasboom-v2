<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\classroom;
use App\Models\comment;
use App\Models\consult;
use App\Models\discount;
use App\lib\zarinpal;
use App\Models\payment;
use App\Models\teacher;
use App\Models\User;
use App\Models\user_favorite;
use App\Models\kasboom_redirect;
use App\Models\webinar;
use App\Models\webinar_attach;
use App\Models\webinar_register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use SoapClient;
use Yajra\Datatables\Datatables;

class webinarController extends Controller
{

  protected $accessdenide_response = [
    'error' => true,
    'data' => '',
    'message' => 'شما مجوز این عملیات را ندارید',
    'type' => 'error'
  ];

  public function webinars()
  {
    if (Auth::user()->can('view-webinar')) {
      $webinar_count = webinar::count();
      $webinar_register = webinar_register::count();
      $comment_count = comment::where("type", "=", "webinar")->count();

      return view("_manager.webinar.webinars", compact("webinar_count", "webinar_register", "comment_count"));
    } else
      return view("_manager.accessdenid");
  }

  public function all_webinars()
  {
    if (Auth::user()->can('view-webinar')) {
      $per_delete = auth()->user()->can('delete-webinar');
      return Datatables::of(webinar::where("status", ">=", 0)->select('id', 'code', 'image', 'title', 'id_category', 'teacher_name', 'price', 'register_count', 'status'))
        ->addColumn('category_title', function ($row) {
          return $row->getCategoryTitle();
        })
        ->addColumn('per_delete', function ($row) use ($per_delete) {
          return $per_delete;
        })
        ->make(true);
    }
    return "";
  }

  public function add_form()
  {
    if (Auth::user()->can('create-webinar')) {
      $cats = getCategory('webinar');
      $states = getState();
      $teachers = teacher::where("type", "=", "webinar")->where("status", 1)->select("id", "fullname")->get();
      return view("_manager.webinar.add_webinar", compact("cats", "states", "teachers"));
    } else
      return view("_manager.accessdenid");

  }

  public function add_webinar(Request $request)
  {
    if (Auth::user()->can('create-webinar')) {

      $webinar_category = $request->webinar_category;
      $webinar_teacher = $request->webinar_teacher;
      $webinar_teacher_name = $request->webinar_teacher_name;
      $webinar_cloud_url = $request->webinar_cloud_url;
      $webinar_teacher_percnet = $request->webinar_teacher_percnet;
      $webinar_abstractMemo = $request->webinar_abstractMemo;
      $webinar_title = $request->webinar_title;
      $webinar_price = $request->webinar_price;
      $webinar_discount = $request->webinar_discount;
      $webinar_capacity_register = $request->webinar_capacity_register;
      $webinar_date = $request->webinar_date;
      $webinar_start_time_hour = $request->webinar_start_time_hour;
      $webinar_start_time_minutes = $request->webinar_start_time_minutes;
      $webinar_hour = $request->webinar_hour;
      $webinar_minutes = $request->webinar_minutes;
      $webinar_have_certificate = $request->webinar_have_certificate;
      $webinar_certificate_memo = $request->webinar_certificate_memo;
      $webinar_save_status = $request->webinar_save_status;
      $webinar_state = $request->webinar_state;
      $webinar_have_ticket = $request->webinar_have_ticket;
      $webinar_old_price = $request->webinar_old_price;
      $webinar_mohtava = $request->webinar_mohtava;
      $webinar_sky_url = $request->webinar_sky_url;


      $code = generateIdeaCode();

      $webinar = new webinar();

      $imgFileName = '';
      $videoFileName = '';
      if ($request->file('webinar_image')) {
        $folderPath = "_upload_/_webinars_/" . $code;
        $imgFileName = uploadImageFile($request->file('webinar_image'), $folderPath);
        $webinar->image = $imgFileName;
      }

      if ($request->file('webinar_video')) {
        $folderPath = "_upload_/_webinars_/" . $code;
        $videoFileName = uploadVideoFile($request->file('webinar_video'), $folderPath);
        $webinar->intro_video = $videoFileName;
      }

      $nowdate = nowDate_Shamsi();

      $new_teacher = '';
      if ($webinar_teacher_name != null) {
        $new_teacher = new teacher();
        $new_teacher->fullname = $webinar_teacher_name;
        $new_teacher->type = "webinar";
        $new_teacher->regist_date = $nowdate;
        $new_teacher->save();
        $webinar_teacher = $new_teacher->id;
      }


      $webinar->code = $code;
      $webinar->id_category = $webinar_category;
      $webinar->id_teacher = $webinar_teacher;
      $webinar->teacher_name = $webinar_teacher_name;
      $webinar->title = $webinar_title;
      $webinar->abstractMemo = $webinar_abstractMemo;
      $webinar->sky_url = $webinar_sky_url;
      $webinar->cloud_url = $webinar_cloud_url;
      $webinar->price = $webinar_price;
      $webinar->old_price = $webinar_old_price;
      $webinar->discount = $webinar_discount;
      $webinar->capacity_register = $webinar_capacity_register;
      $webinar->webinar_date = $webinar_date;
      $webinar->webinar_start_time_hour = $webinar_start_time_hour;
      $webinar->webinar_start_time_minutes = $webinar_start_time_minutes;
      $webinar->hour = $webinar_hour;
      $webinar->minutes = $webinar_minutes;
      $webinar->have_certificate = $webinar_have_certificate;
      $webinar->certificate_memo = $webinar_certificate_memo;
      $webinar->save_status = $webinar_save_status;
      $webinar->id_state = $webinar_state;
      $webinar->content = $webinar_mohtava;
      $webinar->have_ticket = $webinar_have_ticket;
      $webinar->teacher_percent = $webinar_teacher_percnet;
      $webinar->status = 1;
      $webinar->regist_date = $nowdate;
      $webinar->save();


      $id_webinar = $webinar->id;


      $cat = category::where("type", "=", "webinar")->where("id", "=", $webinar_category)->first();
      if ($cat->item_count >= 0)
        $cat->increment('item_count');
      else {
        $cat->item_count = 0;
        $cat->save();
      }

      return ($this->ajax_response(false, $id_webinar, 'ثبت مشخصات وبینار با موفقیت انجام شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);


  }

  public function add_webinar_attach(Request $request)
  {
    if (Auth::user()->can('create-webinar')) {

      $id_webinar = $request->id_webinar;
      $webinar_code = $request->webinar_code;
      $attach_title = $request->attach_title;

      $webinar = new webinar_attach();

      $imgFileName = '';
      if ($request->file('attach_file')) {
        $folderPath = "_upload_/_webinars_/" . $webinar_code . "/attachs/";
        $file = $request->file('attach_file');
        $imgFileName = uploadFile($file, $folderPath);
        $webinar->attach_filename = $imgFileName;
      }

      $webinar->id_webinar = $id_webinar;
      $webinar->attach_title = $attach_title;
      $webinar->save();


      return ($this->ajax_response(false, $webinar, ' ضمیمه وبینار با موفقیت ارسال شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);
  }

  public function delete_attach(Request $request)
  {
    $id = $request->id;
    if (Auth::user()->isManager()) {
      $info = webinar_attach::where("id", "=", $id)->first();
      $id_webinar = $info->id_webinar;
      $info->delete();
      if ($id_webinar != null) {
        $webinar = webinar::where("id", "=", $info->id_webinar)->first();
        $path = "_uplaod_/_webinars_/" . $webinar->code . "/attachs/" . $info->attach_filename;
        deleteFile($path);
      }

      return ($this->ajax_response(false, '', ' حذف ضمیمه انجام شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);
  }

  public function webinar_detail($id, $title = null)
  {
    if (Auth::user()->can('view-webinar')) {
      $webinar = webinar::where("id", "=", $id)->first();
      $cats = getCategory("webinar");
      $teachers = teacher::where("type", "=", "webinar")->where("status", 1)->select("id", "fullname")->get();
      //$teachers = teacher::where("id","=",$webinar->id_teacher)->select("id","code","image" ,"fullname")->get();
      $states = getState();
      $attachs = webinar_attach::where("id_webinar", "=", $id)->get();
      return view("_manager.webinar.detail_webinar", compact("webinar", "teachers", "cats", "states", "attachs"));
    } else
      return response()->json($this->accessdenide_response);

  }

  public function edit_webinar(Request $request)
  {
    if (Auth::user()->can('create-webinar')) {

      $webinar_category = $request->webinar_category;
      $webinar_teacher = $request->webinar_teacher;
      $webinar_teacher_name = $request->webinar_teacher_name;
      $webinar_cloud_url = $request->webinar_cloud_url;
      $webinar_teacher_percnet = $request->webinar_teacher_percnet;
      $webinar_abstractMemo = $request->webinar_abstractMemo;
      $webinar_title = $request->webinar_title;
      $webinar_price = $request->webinar_price;
      $webinar_discount = $request->webinar_discount;
      $webinar_capacity_register = $request->webinar_capacity_register;
      $webinar_date = $request->webinar_date;
      $webinar_start_time_hour = $request->webinar_start_time_hour;
      $webinar_start_time_minutes = $request->webinar_start_time_minutes;
      $webinar_hour = $request->webinar_hour;
      $webinar_minutes = $request->webinar_minutes;
      $webinar_have_certificate = $request->webinar_have_certificate;
      $webinar_certificate_memo = $request->webinar_certificate_memo;
      $webinar_save_status = $request->webinar_save_status;
      $webinar_state = $request->webinar_state;
      $webinar_have_ticket = $request->webinar_have_ticket;
      $webinar_old_price = $request->webinar_old_price;
      $webinar_mohtava = $request->webinar_mohtava;
      $webinar_sky_url = $request->webinar_sky_url;
      $id_webinar = $request->id_webinar;


      $webinar = webinar::where("id", "=", $id_webinar)->first();

      if ($request->file('webinar_image')) {
        $folderPath = "_upload_/_webinars_/" . $webinar->code;
        $path = $folderPath . "/" . "/" . $webinar->image;
        deleteFile($path);
        $imgFileName = uploadImageFile($request->file('webinar_image'), $folderPath);
        $webinar->image = $imgFileName;
      }

      $new_teacher = '';
      if ($webinar_teacher_name != null) {
        if (teacher::where("fullname", "=", $webinar_teacher_name)->count() == 0) {
          $new_teacher = new teacher();
          $new_teacher->fullname = $webinar_teacher_name;
          $new_teacher->type = "webinar";
          $new_teacher->regist_date = nowDate_Shamsi();
          $new_teacher->save();
          $webinar_teacher = $new_teacher->id;
        }
      }

      $webinar->id_category = $webinar_category;
      $webinar->id_teacher = $webinar_teacher;
      $webinar->teacher_name = $webinar_teacher_name;
      $webinar->title = $webinar_title;
      $webinar->abstractMemo = $webinar_abstractMemo;
      $webinar->sky_url = $webinar_sky_url;
      $webinar->cloud_url = $webinar_cloud_url;
      $webinar->price = $webinar_price;
      $webinar->old_price = $webinar_old_price;
      $webinar->discount = $webinar_discount;
      $webinar->capacity_register = $webinar_capacity_register;
      $webinar->webinar_date = $webinar_date;
      $webinar->webinar_start_time_hour = $webinar_start_time_hour;
      $webinar->webinar_start_time_minutes = $webinar_start_time_minutes;
      $webinar->hour = $webinar_hour;
      $webinar->minutes = $webinar_minutes;
      $webinar->have_certificate = $webinar_have_certificate;
      $webinar->certificate_memo = $webinar_certificate_memo;
      $webinar->save_status = $webinar_save_status;
      $webinar->id_state = $webinar_state;
      $webinar->content = $webinar_mohtava;
      $webinar->have_ticket = $webinar_have_ticket;
      $webinar->teacher_percent = $webinar_teacher_percnet;
      $webinar->status = 1;
      $webinar->save();

      return ($this->ajax_response(false, $id_webinar, 'ثبت غییرات مشخصات وبینار با موفقیت انجام شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);


  }

  public function webinar_comments(Request $request)
  {
    if (Auth::user()->can('comment-course')) {
      $id_webinar = $request->id_webinar;
      $data = comment::where("type", "=", "webinar")->where("id_target", "=", $id_webinar)->get();
      return Datatables::of($data)
        ->addColumn('fullname', function ($row) {
          return $row->getUserName();
        })->make(true);
    } else
      return "";
  }

  public function webinar_users(Request $request)
  {
    if (Auth::user()->can('view-webinar')) {
      $id_webinar = $request->id_webinar;
      $data = webinar_register::where("id_webinar", "=", $id_webinar)->get();
      return Datatables::of($data)
        ->addColumn('fullname', function ($row) {
          return $row->getUserName();
        })->make(true);
    } else
      return "";
  }

  public function webinar_intro($id, $title = null)
  {
    $teacher_owner = false;
    $related_webinars = [];
    $webinar = webinar::where("id", "=", $id)->first();
    $teacher = null;
    if ($webinar != null) {

      $teacher = teacher::where("id", "=", $webinar->id_teacher)->select("id", "code", "image", "fullname")->first();

      $related_webinars = webinar::where('status', '=', '1')
        ->where('id_category', '=', $webinar->id_category)
        ->where('id', '<>', $webinar->id)
        ->with(array('category' => function ($query) {
          $query->select('id', 'title');
        }))
        ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'teacher_name', 'webinar_date', 'webinar_start_time_hour', 'webinar_start_time_minutes', 'webinar_end_time_hour', 'webinar_end_time_minute', 'register_count', 'code', 'discount', 'abstractMemo', 'score', 'discount', 'old_price')
        ->get();

      $taked_webinar = null;
      if (Auth::check())
        $taked_webinar = webinar_register::where('id_user', '=', Auth::user()->id)
          ->where('id_webinar', '=', $id)
          ->first();

      $favorite_status = false;
      if (Auth::check()) {
        $user_fav = user_favorite::where("id_user", "=", Auth::user()->id)
          ->where("type", "=", "webinar")
          ->where("id_target", "=", $id)
          ->first();
        if ($user_fav == null)
          $favorite_status = false;
        else
          $favorite_status = true;
      }

      $comments = comment::where("type", "=", "webinar")->latest()->paginate(10);
      $attachs = webinar_attach::where("id_webinar", "=", $id)->get();

      $attach_dic = [];
      foreach ($attachs as $attach) {
        $attach_dic[$attach->category][] = $attach;
      }


      $taked_course = null;


      if ($teacher_owner == true)
        $taked_course = true;
      else {
        if (Auth::check())
          $taked_course = webinar_register::where('id_webinar', '=', $id)
            ->where('id_user', '=', Auth::user()->id)
            ->first();
      }

//          if(Auth::check())
//            if(Auth::user()->isManager())
//              $taked_course = true;


      if ($webinar->view_count >= 0)
        $webinar->increment('view_count');
      else
        $webinar->view_count = 0;

      $webinar->save();
      return view("webinar.webinar_detail", compact("favorite_status", "attachs", "taked_webinar", "webinar", "related_webinars", "comments", "attach_dic", "teacher"));
    } else
      return view("404");

  }

  public function category_webinar($id_category, $title = null)
  {
    $cats = getCategory('webinar');
    $webinars = webinar::where('status', '=', 1)
      ->where('id_category', '=', $id_category)
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))->with(array('teacher' => function ($query) {
        $query->select('id', 'fullname');
      }))
      ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'discount', 'abstractMemo', 'score', 'discount', 'old_price', 'capacity_register', 'teacher_name', 'webinar_date', 'webinar_start_time_hour', 'webinar_start_time_minutes', 'view_count', 'like_count', 'comment_count')
      ->latest()
      ->paginate(6);
    return view("webinar.webinar_category", compact("webinars", "cats", "id_category"));
  }

  public function webinar_list()
  {
//    $cats = getCategoryMega(['webinars']);
    $cats = getCategory('webinars');
    $query = webinar::where('status', '>', 0)
      ->with(['category' => function ($query) {
        $query->select('id', 'title');
      }])
      ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'discount', 'abstractMemo', 'score', 'discount', 'old_price', 'capacity_register', 'teacher_name', 'webinar_date', 'webinar_start_time_hour', 'webinar_start_time_minutes', 'view_count', 'like_count', 'comment_count', 'status', 'have_video');

    $search = request()->search;
    if ($search == 'undefined')
      $search = '';

    if ($search) $query->where('title', 'LIKE', "%$search%");

    $sort = request()->sort;
    if ($sort === 'old') $query->oldest('id');
    else $query->latest('id');

    $minPrice = (int)(str_replace(',', '', request()->minPrice));
    $maxPrice = (int)(str_replace(',', '', request()->maxPrice));

    if ($maxPrice) $query->whereBetween('price', [$minPrice, $maxPrice]);

    $type = request()->type;
    if ($type === 'free') $query->where('price', 0);
    elseif ($type === 'nofree') $query->where('price', '>', 0);

    $cat = request()->cat;
    if ($cat) $query->where('id_cat_mega', $cat);

    $webinars = $query->paginate(6);
    return view("webinar/search_webinar", compact('cats', 'webinars'));
  }

  public function search(Request $request)
  {
    $webinar_title = $request->webinar_name;

    $webinars = webinar::where('status', '=', 1)
      ->where('title', 'like', '%' . $webinar_title . '%')
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'discount', 'abstractMemo', 'score', 'discount', 'old_price', 'capacity_register', 'teacher_name', 'webinar_date', 'webinar_start_time_hour', 'webinar_start_time_minutes', 'view_count', 'like_count', 'comment_count')
      ->orderBy('id', 'desc')
      ->get();

    return ($this->ajax_response(false, $webinars, '', 'success'));

  }

  public function filter(Request $request)
  {
    $min_price = (int)$request->min_price;
    $max_price = (int)$request->max_price;
    $cats = $request->cats;

    if ($cats != null)
      $id_categorys = array_map('intval', explode(',', $cats));
    else
      $id_categorys = null;

    $query = webinar::where('status', '=', 1)
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }));

    if (count($id_categorys) > 0)
      $query = $query->wherein('id_category', $id_categorys);

    $query = $query->where('price', ">=", $min_price);
    $query = $query->where('price', "<=", $max_price);


    $query = $query->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'discount', 'abstractMemo', 'score', 'discount', 'old_price', 'capacity_register', 'teacher_name', 'webinar_date', 'webinar_start_time_hour', 'webinar_start_time_minutes', 'view_count', 'like_count', 'comment_count')->orderBy('id', 'desc');

    return ($this->ajax_response(false, $query->get(), '', 'success'));

  }

  public function take_webinar($id_webinar, $title)
  {
    if (Auth::check()) {
      $user_in_class = webinar_register::where("id_webinar", "=", $id_webinar)->where("id_user", "=", Auth::user()->id)->first();
      if (empty($user_in_class)) {
        $nowdate_shamsi = nowDate_Shamsi();
        $webinar = webinar::where("id", "=", $id_webinar)->select('id', 'title', 'abstractMemo', 'hour', 'minutes', 'price', 'sky_url', 'subsid', 'subsid_limit', 'capacity_register')->first();

        //if($webinar->price>0) {
        $user_name = Auth::user()->name;
        $subsid = Auth::user()->subsid > $webinar->subsid_limit ? $webinar->subsid_limit : Auth::user()->subsid;
        $wallet = 0;
        if (Auth::user()->isTeacher()) {
          $id_teacher = Auth::user()->id_teacher;
          $teacher = teacher::where("id", "=", $id_teacher)->first();
          if ($teacher != null)
            $wallet = $teacher->wallet;
        } elseif (Auth::user()->isConsult()) {
          $id_consult = Auth::user()->id_consult;
          $consult = consult::where("id", "=", $id_consult)->first();
          if ($consult != null)
            $wallet = $consult->wallet;
        } else
          $wallet = Auth::user()->wallet;

        $final_price = ($webinar->price - $subsid) > 0 ? ($webinar->price - $subsid) : 0;
        $reg_count = webinar_register::where("id_webinar", "=", $id_webinar)->count();

        if ($webinar->capacity_register <= $reg_count) {
          return Redirect::to('skill/webinar/' . $id_webinar . '/' . $title);
        }

        return view('webinar/take_webinar', compact('webinar', 'nowdate_shamsi', 'user_name', 'wallet', 'subsid', 'final_price', 'reg_count'));

      } else
      {
        return Redirect::to('web/learning/webinar');
      }
    } else {
      Session::put('previeusPage', 'skill/take_webinar/' . $id_webinar . '/' . $title);
      return redirect("web");
    }
  }

  public function webinar_payment(Request $request)
  {
    $id_webinar = $request->id_webinar;
    $payment_type = $request->payment_type;

    $webinar_info = webinar::where("id", "=", $id_webinar)->first();
    $webinar = $webinar_info;
    if (Auth::check()) {

      $user_in_class = webinar_register::where("id_webinar", "=", $id_webinar)->where("id_user", "=", Auth::user()->id)->first();
      if ($user_in_class == null) {
        $discount_code = $request->discount;
        $discount = discount::where("discount_code", "=", $discount_code)->where("status", "=", 0)->first();

        //
        $wallet = Auth::user()->wallet;
        $user_subsid = Auth::user()->subsid;
        if ($user_subsid < 0) $user_subsid = 0;
        $subsid = ($user_subsid > $webinar_info->subsid_limit) ? $webinar_info->subsid_limit : $user_subsid;

        //
        $discount_percent = 0;
        if (empty($discount)) {
          $discount_code = 0;
          $discount_price = 0;
          $payment_price = $webinar_info->price;
        } else {
          $discount_price = ($discount->percent / 100) * ($webinar_info->price);
          $payment_price = (($webinar_info->price) - $discount_price);
          $discount_percent = $discount->percent;
        }

        //
        if ($payment_type == "wallet") {
          if (Auth::user()->isTeacher()) {
            $id_teacher = Auth::user()->id_teacher;
            $teacher = teacher::where("id", "=", $id_teacher)->first();
            if ($teacher != null)
              $wallet = $teacher->wallet;
          } elseif (Auth::user()->isConsult()) {
            $id_consult = Auth::user()->id_consult;
            $consult = consult::where("id", "=", $id_consult)->first();
            if ($consult != null)
              $wallet = $consult->wallet;
          }

          if (($wallet + $subsid) >= $payment_price) {
            if ($subsid <= $payment_price) {
              $new_subsid = $user_subsid - $subsid;
              $new_wallet = $wallet - ($payment_price - $subsid);
              $used_subsid = $subsid;
            } else {
              $new_subsid = $user_subsid - $payment_price;
              $new_wallet = $wallet;
              $used_subsid = $payment_price;
            }

            $discount = discount::where("discount_code", "=", $discount_code)->first();
            $discount->id_user_used = Auth::user()->id;
            $discount->last_date_used = nowDate_Shamsi();
            if ($discount->type == 'single')
              $discount->status = 1;
            else if ($discount->type == 'multi') {
              $remain = $discount->remain;
              $count = $discount->count;
              $new_remain = $remain - 1;
              if ($new_remain < 1)
                $discount->status = 1;
              else
                $discount->status = 0;

              $discount->remain = $new_remain;
            }
            $discount->save();

            $factor = generateNewFactorID("wbr");

            $RefID = 'wallet_' . $factor;

            $nowdate = nowDate_Shamsi();
            $payment = new payment();
            $payment->id_user = Auth::user()->id;
            $payment->payment_for = "webinar";
            $payment->id_target = $id_webinar;
            $payment->teacher_payment = 0;
            $payment->product_course_title = $webinar_info->title;
            $payment->regist_date = $nowdate;
            $payment->price = $webinar_info->price;
            $payment->discount_percent = $discount_percent;
            $payment->discount_code = $discount_code;
            $payment->discount_price = $discount_price;
            $payment->payment_price = $payment_price;
            $payment->subsid_price = $used_subsid;
            $payment->authority = "wallet";
            $payment->bankname = "کیف پول";
            $payment->status = 1;
            $payment->refID = $RefID;
            $payment->factor_id = $factor;
            $payment->save();

            $webinar_info->increment('register_count');
            $webinar_info->save();

            $user_kasboom_url = generateWebinarUrl(Auth::user()->id, $webinar_info->username);

            $user_sky_url = "https://webinar.kasboom.ir/" . $webinar_info->username;

            webinar_register::updateOrInsert(
              [
                'id_user' => Auth::user()->id, 'user_url' => "https://Kasboom.ir/ch/" . $user_kasboom_url,
                'id_webinar' => $id_webinar, 'register_date' => $nowdate, 'factor_id' => $factor,
                'refID' => $RefID, 'status' => 1, 'payment_id' => $payment->id
              ]
            );

            if (Auth::user()->isTeacher()) {
              $id_teacher = Auth::user()->id_teacher;
              $teacher = teacher::where("id", "=", $id_teacher)->first();
              if ($teacher != null) {
                teacher::where('id', '=', $id_teacher)
                  ->update([
                    'wallet' => $new_wallet
                  ]);
              }
            } elseif (Auth::user()->isConsult()) {
              $id_consult = Auth::user()->id_consult;
              $consult = consult::where("id", "=", $id_consult)->first();
              if ($consult != null) {
                consult::where('id', '=', $id_consult)
                  ->update([
                    'wallet' => $new_wallet
                  ]);
              }
            }

            User::where('id', '=', Auth::user()->id)
              ->update([
                'wallet' => $new_wallet,
                'subsid' => $new_subsid,
              ]);


            $minutes = $webinar_info->webinar_start_time_minutes;
            if ($minutes == 0 || $minutes == "0")
              $minutes = "00";


            $webinar_date = $webinar_info->webinar_date . "\n\n" . "ساعت شروع : " . $webinar_info->webinar_start_time_hour . ':' . $minutes;


            if ($webinar_info->status == 1) {
              $client = new Client();
              $sky_key = "apikey-5845155-13-875a205316f999ab613c46dee747eaf3";
              $url = "https://www.skyroom.online/skyroom/api/" . $sky_key;

              $response = $client->request('POST', $url, [
                'verify' => false,
                'json' => [
                  'action' => 'getRoom',
                  'params' => [
                    'name' => $webinar_info->username
                  ]
                ]
              ]);

              if ($response->getStatusCode() == 200) {
                $body = $response->getBody();
                //file_put_contents('test.txt', $body, FILE_APPEND);
                $response_data = json_decode($body);
                $room_id = $response_data->result->id;
                $user_id = Auth::user()->id;
                $nickname = Auth::user()->firstname . ' ' . Auth::user()->lastname;
                if ($nickname == null || $nickname == '' || strlen($nickname) < 3) $nickname = Auth::user()->name;
                if ($nickname == null || $nickname == '' || strlen($nickname) < 3) $nickname = $user_id;

                $access = 1;
                $concurrent = 1;
                $language = "fa";
                $ttl = 2000000;

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
                  $user_sky_url = $response_data_login->result;
                }

              }

              kasboom_redirect::updateOrInsert(
                ['path' => $user_kasboom_url, 'redirect' => $user_sky_url]
              );

            if($webinar_info->type === 5){
                  sendSMS_Webinar_Register_term(Auth::user()->name, Auth::user()->username, $webinar_info->title, Auth::user()->phonenumber, $RefID, $payment_price, "https://Kasboom.ir/ch/" . $user_kasboom_url);
                  sendSMS_Webinar_Register_term(Auth::user()->name, Auth::user()->username, $webinar_info->title, '09055165955', $RefID, $payment_price, "https://Kasboom.ir/ch/" . $user_kasboom_url);
            }
            else
               sendSMS_Webinar_Register2(Auth::user()->name, Auth::user()->username, $webinar_info->title, $webinar_date, Auth::user()->phonenumber, $RefID, $payment_price, "https://Kasboom.ir/ch/" . $user_kasboom_url);



              // sendSMS_Webinar_Register2(Auth::user()->name,Auth::user()->username,$webinar_info->title,$webinar_date,'09055165955',$RefID,$payment_price,"https://Kasboom.ir/ch/".$user_kasboom_url);
            }


            $type = "webinar";
            return view('webinar/payment_factor', compact('webinar', 'payment', 'type'));

          } else {
            $title = "پرداخت ناموفق";
            $message = "اعتبار شما برای پرداخت با کیف پول کافی نمی باشد";
            $redirect = "skill/take_webinar/" . $webinar_info->id . "/" . gethttplink($webinar_info->title);
            return view("message", compact("title", "message", "redirect"));
          }

        } else {
          $payment_price -= ($wallet + $subsid);
          $Description = 'ثبت نام در وبینار ' . $webinar_info->title;
          $Email = Auth::user()->email;
          $Mobile = Auth::user()->phonenumber;
          $CallbackURL = url('skill/webinar/verifyPayment'); // Required

          //
          $order = new zarinpal();
          $res = $order->pay($payment_price, $Email, $Mobile, $Description, $CallbackURL);

          if ($res != false) {
            $payment = new payment();
            $payment->id_user = Auth::user()->id;
            $payment->payment_for = "webinar";
            $payment->id_target = $id_webinar;
            $payment->teacher_payment = 0;
            $payment->product_course_title = $webinar_info->title;
            $payment->regist_date = nowDate_Shamsi();
            $payment->price = $webinar_info->price;
            $payment->discount_percent = $discount_percent;
            $payment->discount_code = $discount_code;
            $payment->discount_price = $discount_price;
            $payment->payment_price = $payment_price;
            $payment->subsid_price = $subsid;
            $payment->authority = $res;
            $payment->refID = "0";
            $payment->bankname = "زرین پال";
            $payment->status = 0;
            $payment->save();
          }
          return redirect('https://www.zarinpal.com/pg/StartPay/' . $res);
        }

      } else
        return Redirect::to('skill/webinar/' . $id_webinar . '/' . str_replace(" ", "_", $webinar_info->title));
    } else {
      Session::put('previeusPage', 'skill/take_webinar/' . $id_webinar . '/' . str_replace(" ", "_", $webinar_info->title));
      return redirect("web");
    }
  }

  public function verifyPayment(Request $request)
  {
    $MerchantID = 'e7d6f566-c2e1-4fbe-9473-7ac3567a3944';
    $Authority = $request->get('Authority');
    $payment_price = 0;
    $payment = payment::where("authority", "=", $Authority)->first();
    $id_user = $payment->id_user;
    $user_info = User::where("id", $id_user)->first();
    $wallet = $user_info->wallet;

    if ($payment != null) {
      $payment_price = $payment->payment_price;
    }

    if ($request->get('Status') == 'OK') {

      $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
      $result = $client->PaymentVerification(
        [
          'MerchantID' => $MerchantID,
          'Authority' => $Authority,
          'Amount' => $payment_price,
        ]
      );

      if (($result->Status == 101) or ($result->Status == 100)) {

        if (($payment->status == 0) and ($payment->refID == "0")) {
          $id_webinar = $payment->id_target;
          $discount_code = $payment->discount_code;
          $teacher_wallet = $payment->teacher_payment;
          $RefID = $result->RefID;

          // add payment price to wallet
          $wallet += $payment_price;
          User::where("id", $id_user)->update([
            'wallet' => $wallet
          ]);

          $webinar_info = $webinar = webinar::where("id", "=", $id_webinar)->first();

          $user_subsid = $user_info->subsid;
          if ($user_subsid < 0) $user_subsid = 0;
          $subsid = ($user_subsid > $webinar_info->subsid_limit) ? $webinar_info->subsid_limit : $user_subsid;

          if ($payment->price <= ($wallet + $subsid)) {
            $factor_id = generateNewFactorID("wbr");

            webinar_register::updateOrInsert(
              ['id_user' => $id_user, 'id_webinar' => $id_webinar, 'register_date' => nowDate_Shamsi(), 'factor_id' => $factor_id, 'refID' => $RefID, 'status' => 1]
            );

            if ($discount_code != null) {
              $discount = discount::where("type", "=", "webinar")
                ->where("status", "=", 0)
                ->where("discount_code", "=", $discount_code)->first();
              if ($discount != null) {
                $discount->id_user_used = $id_user;
                $discount->last_date_used = nowDate_Shamsi();
                if ($discount->type == 'single')
                  $discount->status = 1;
                else if ($discount->type == 'multi') {
                  $remain = $discount->remain;
                  $count = $discount->count;
                  $new_remain = $remain - 1;
                  if ($new_remain < 1)
                    $discount->status = 1;
                  else
                    $discount->status = 0;

                  $discount->remain = $new_remain;
                }
                $discount->save();
              }
            }

            $payment->status = 1;
            $payment->refID = $RefID;
            $payment->factor_id = $factor_id;
            $payment->save();

            //
            webinar_register::where('id_user', $user_info->id)->where('id_webinar', $id_webinar)->update([
              'payment_id' => $payment->id
            ]);

            //
            $webinar_info->increment('register_count');
            $webinar_info->save();

            // calc and update new wallet & subsid
            if ($payment->price <= $subsid) {
              User::where("id", $id_user)->update([
                'subsid' => $user_subsid - $payment->price
              ]);
            } else {
              User::where("id", $id_user)->update([
                'subsid' => $user_subsid - $subsid,
                'wallet' => $wallet - ($payment->price - $subsid),
              ]);
            }

            //
            $client = new Client();
            $sky_key = "apikey-5845155-13-875a205316f999ab613c46dee747eaf3";
            $url = "https://www.skyroom.online/skyroom/api/" . $sky_key;

            $response = $client->request('POST', $url, [
              'verify' => false,
              'json' => [
                'action' => 'getRoom',
                'params' => [
                  'name' => $webinar_info->username
                ]
              ]
            ]);

            if ($response->getStatusCode() == 200) {
              $body = $response->getBody();
              $response_data = json_decode($body);
              $room_id = isset($response_data->result) ? $response_data->result->id : null;
              $user_id = $user_info->id;
              $nickname = $user_info->firstname . ' ' . $user_info->lastname;
              if ($nickname == null || $nickname == '' || strlen($nickname) < 3) $nickname = $user_info->name;
              if ($nickname == null || $nickname == '' || strlen($nickname) < 3) $nickname = $user_id;

              $access = 1;
              $concurrent = 1;
              $language = "fa";
              $ttl = 2000000;

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
                $user_sky_url = isset($response_data_login->result) ? $response_data_login->result : null;
                $user_kasboom_url = generateWebinarUrl($user_info->id, $webinar_info->username);
                kasboom_redirect::updateOrInsert(
                  ['path' => $user_kasboom_url, 'redirect' => $user_sky_url]
                );
              }

              webinar_register::where('id_user', $user_info->id)->where('id_webinar', $id_webinar)->update([
                'user_url' => "https://kasboom.ir/ch/" . $user_kasboom_url
              ]);
            }

            //
            $webinar_date = $webinar_info->webinar_date . ' - ' . $webinar_info->webinar_start_time_minutes . ' : ' . $webinar_info->webinar_start_time_hour;
//            sendSMS_Webinar_Register($user_info->name,$user_info->username,$webinar_info->title,$webinar_date,$user_info->phonenumber,$RefID,$payment_price,$webinar_info->sky_url);

            if($webinar_info->type === 5){
                sendSMS_Webinar_Register_term($user_info->name, $user_info->username, $webinar_info->title, $user_info->phonenumber, $RefID, $payment_price, "https://kasboom.ir/ch/" . $user_kasboom_url);
                   sendSMS_Webinar_Register_term($user_info->name, $user_info->username, $webinar_info->title, '09055165955', $RefID, $payment_price, "https://kasboom.ir/ch/" . $user_kasboom_url);
            }
            else
                 sendSMS_Webinar_Register2($user_info->name, $user_info->username, $webinar_info->title, $webinar_date, $user_info->phonenumber, $RefID, $payment_price, "https://kasboom.ir/ch/" . $user_kasboom_url);



            $type = "webinar";
            return view('webinar.payment_factor', compact('user_info', 'payment', 'type', 'webinar'));
          } else {
            $title = "ثبت نام ناموفق";
            $message = "مبلغ پرداختی به کیف پول شما اضافه شد ولی برای خرید وبینار کافی نمی باشد";
            $redirect = "skill/take_webinar/" . $webinar_info->id . "/" . gethttplink($webinar_info->title);
            return view("message", compact("title", "message", "redirect"));
          }
        }

        $type = "webinar";
        return view('webinar.payment_factor', compact('user_info', 'payment', 'type'));
      } else {
        $type = "webinar";
        return view('webinar.payment_factor', compact('user_info', 'payment', 'type'));

//                return 'خطا در انجام عملیات';
      }
    } else {
      $type = "webinar";
      return view('webinar.payment_factor', compact('payment', 'type', 'user_info'));
//            return 'خطا در انجام عملیات';
    }
  }

  public function webinar_delete(Request $request)
  {
    $id = $request->id;
    if (Auth::user()->can('delete-webinar')) {
      $webinar = webinar::where("id", "=", $id)->first();
      if ($webinar != null) {
        webinar_attach::where("id_webinar", "=", $id)->delete();
        $folderPath = "_upload_/_webinars_/" . $webinar->code . '/';
        delete_directory($folderPath);
      }
      $webinar->delete();
      return ($this->ajax_response(false, '', ' ضمیمه وبینار با موفقیت ارسال شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);

  }

}


