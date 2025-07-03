<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\categoryMega;
use App\Models\classroom;
use App\Models\comment;
use App\Models\consult;
use App\Models\course;
use App\Models\course_pre_registration;
use App\Models\course_suggestion;
use App\Models\discount;
use App\Models\faq;
use App\Models\invite;
use App\Models\KasboomSurvey;
use App\Models\KasboomSurveyField;
use App\Models\lesson;
use App\lib\zarinpal;
use App\Models\message;
use App\Models\news;
use App\Models\note;
use App\Models\payment;
use App\Models\quiz_question;
use App\Models\SkillCourseSuggestions;
use App\Models\SkillCourseSuggestionsRate;
use App\Models\state;
use App\Models\teacher;
use App\Models\User;
use App\Models\lesson_attach;
use App\Models\user_favorite;
use App\Models\user_quiz;
use App\Models\userlesson;
use App\Models\webinar;
use App\Models\webinar_register;
use App\Models\wikiidea;
use App\Models\workshop;
use Exception;
use GuzzleHttp\Client;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Morilog\Jalali\Facades\jDate;
use SoapClient;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class courseController extends Controller
{
  protected $accessdenide_response = [
    'error' => true,
    'data' => '',
    'message' => 'شما مجوز این عملیات را ندارید',
    'type' => 'error'
  ];

  public function course_index_new()
  {
        $cats = getCategory('course', true);
        $courses = Cookie::get('courses');
        $dbl_courses = Cookie::get('dbl_courses');
        $sbt_courses = Cookie::get('sbt_courses');
        $pre_courses = Cookie::get('pre_courses');
        $webinars = Cookie::get('webinars');
    //    $preprouctions = Cookie::get('preprouctions');
        $comments = Cookie::get('comments');
      $newst_courses = [];
        if ($courses == null) {
          $courses_query = course::where('status', '=', 1)->where("type","course")->with(array('category' => function ($query) {
            $query->select('id', 'title');
          }))->with(array('teacher' => function ($query) {
            $query->select('id', 'fullname');
          }))
            ->select('id', 'title', 'slug', 'image', 'price', 'hour', 'minutes', 'video_minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'abstractMemo', 'view_count');

          $courses = $courses_query->get()->sortByDesc('id');;
          cookie('courses', $courses, 500);
    //      $moreview_courses = $courses->sortByDesc('view_count');
          $newst_courses = $courses->sortByDesc('id');
        }

        if ($dbl_courses == null) {
              $dbl_courses_query = course::where('status', '=', 1)->where("type","duble")->with(array('category' => function ($query) {
                  $query->select('id', 'title');
              }))->select('id', 'title', 'slug', 'image', 'price', 'hour', 'minutes', 'video_minutes', 'id_category','register_count', 'code','discount', 'score', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'abstractMemo', 'view_count');

              $dbl_courses = $dbl_courses_query->get()->sortByDesc('id');
              cookie('dbl_courses', $dbl_courses, 500);
        }

        if ($sbt_courses == null) {
              $sbt_courses_query = course::where('status', '=', 1)->where("type","subtitle")->with(array('category' => function ($query) {
                  $query->select('id', 'title');
              }))->select('id', 'title', 'slug', 'image', 'price', 'hour', 'minutes', 'video_minutes', 'id_category','register_count', 'code','discount', 'score', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'abstractMemo', 'view_count');

              $sbt_courses = $sbt_courses_query->get()->sortByDesc('id');
              cookie('sbt_courses', $sbt_courses, 500);
         }

          if ($pre_courses == null) {
              $pre_courses_query = course::where('status', '=', 2)->with(array('category' => function ($query) {
                  $query->select('id', 'title');
              }))->select('id', 'title', 'slug', 'image', 'price', 'hour', 'minutes', 'video_minutes', 'id_category','register_count', 'code','discount', 'score', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'abstractMemo', 'view_count');

              $pre_courses = $pre_courses_query->get()->sortByDesc('id');
              cookie('pre_courses', $pre_courses, 500);
          }


        $courses_count = $courses->count() + $dbl_courses->count() + $sbt_courses->count();
        $sum_hours = $courses->sum('hour') + $dbl_courses->sum('hour')  + $sbt_courses->sum('hour') ;
        $sum_minutes = $courses->sum('minutes')+$dbl_courses->sum('minutes')+$sbt_courses->sum('minutes');
        $sum_video_minutes = $courses->sum('video_minutes')+$dbl_courses->sum('video_minutes')+$sbt_courses->sum('video_minutes');
        $total_learn_time = ($sum_hours * 60) + $sum_minutes + $sum_video_minutes;


      $discount_courses_video = $courses_query->whereNotNull('old_price')
        ->whereNotNull('cloud_url')
        ->withCount([
            'classroom as class_users_count' => function ($query) {
                $query->select(DB::raw('count(DISTINCT id_user)'));
            }
        ])->limit(8)->get()->sortByDesc('id');

        $catRand = null;
        $catRandCourses = collect();
        if ($cats->isNotEmpty()) {
          $catRand = $cats->random(1);

          $catRandCourses = $courses_query->where('id_category', $catRand[0]->id)->latest('id')->get();
        }

      $webinars = webinar::where("status", ">=", 1)->where("have_video", "=", 1)
          ->with(array('category' => function ($query) {
              $query->select('id', 'title');
          }))
          ->get()
          ->sortByDesc('id');

//      $online_courses = webinar::where("status", ">=", 1)->where("type", "=", 5)
//          ->with(array('category' => function ($query) {
//              $query->select('id', 'title');
//          }))
//          ->get()
//          ->sortByDesc('id');

    $webinar_count = $webinars?->count();
    $sum_hours = $webinars?->sum('hour');
    $sum_minutes = $webinars?->sum('minutes');
    $total_learn_time = $total_learn_time + ($sum_hours * 60) + $sum_minutes;
    $webinars = $webinars?->take(6);
    $skill_count = $webinar_count + $courses_count;

//    if ($preprouctions == null) {
//      $preprouctions = course::where('status', '=', 2)
//        ->with(array('category' => function ($query) {
//          $query->select('id', 'title');
//        }))->with(array('teacher' => function ($query) {
//          $query->select('id', 'fullname');
//        }))
//        ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price', 'img_slider', 'img_slider_mobile', 'img_big_banner', 'have_certificate')
//        ->latest()
//        ->take(8)
//        ->get();
//
//      cookie('preprouctions', $preprouctions, 1400);
//    }

    if ($comments == null) {

      $comments = comment::where("type", "=", "course")
        ->where("status", "=", 1)
        ->where("comment", "<>", '')
        ->with(array('user' => function ($queryuser) {
          $queryuser->select('id', 'name', 'code', 'image');
        }))
        ->select('id', 'id_target', 'id_user', 'score', 'regist_date', 'comment')
        ->latest()
        ->take(30)
        ->get();

      cookie('comments', $comments, 500);
    }

//    $teachers_count = Cookie::get('teachers_count');
//    $teachers = [];
//    if ($teachers_count == null) {
//      $teachers = teacher::where('status', '>', 0)->select('id', 'code', 'img_mini_banner', 'fullname', 'status')->orderByDesc('id')->get();
//      $teachers_count = count($teachers);
//      cookie('teachers_count', $teachers_count, 500);
//    }

    $student_count = classroom::count('id_user');
    $student_count_weinar = webinar_register::count('id_user');

    $student_count = $student_count + $student_count_weinar;
    cookie('students_count', $student_count, 500);
    $states = getState();

    $courseSuggestions = SkillCourseSuggestions::where('read_status', 1)->get();
    if (auth()->check()) $userSuggestions = SkillCourseSuggestionsRate::where('user_id', auth()->user()->id)->pluck('sugg_id')->toArray();
    else $userSuggestions = [];

      return view("course.course_index", compact('courses','dbl_courses','sbt_courses','pre_courses','userSuggestions','courseSuggestions', 'catRandCourses', 'catRand','webinars', 'newst_courses', 'discount_courses_video', 'courses_count', 'student_count', 'total_learn_time', 'states', 'cats', 'comments', 'webinar_count','skill_count'));
  }

  public function courseSuggestionChange () {
    if (!auth()->check())
      return response()->json(['message' => 'لطفا جهت ثبت رای ابتدا وارد حساب کاربری شوید'], 403);

    $suggestId = (int)request()->id;
    $userId = auth()->user()->id;
    $suggest = SkillCourseSuggestions::where('id', $suggestId)->where('read_status', 1)->first();
    if(!$suggest)
      return response()->json(['message' => 'متاسفانه دوره ی پیشنهادی یافت نشد , لطفا دوباره امتحان کنید'], 403);

    $userSuggest = SkillCourseSuggestionsRate::where('user_id', $userId)->where('sugg_id', $suggestId)->first();
    if($userSuggest) {
      $userSuggest->delete();
      $suggest->rate = $suggest->rate - 1;
      $message = 'رای با موفقیت حذف شد';
      $status = 'remove';
    } else {
//      store rate
      $store = new SkillCourseSuggestionsRate;
      $store->user_id = $userId;
      $store->sugg_id = $suggestId;
      $store->save();

      $suggest->rate = $suggest->rate + 1;
      $message = 'رای با موفقیت ثبت شد';
      $status = 'add';
    }
    $rateCount = $suggest->rate;
    $suggest->save();

    return response()->json(['message' => $message, 'rateCount' => $rateCount, 'status' => $status], 200);
  }

    public function coursePreRegistrationSubmit ($slug) {
        if (!auth()->check())
            return \redirect('/web');

        $course = course::where('slug', $slug)->firstOrFail();

        course_pre_registration::updateOrInsert(
            ['user_id' => auth()->user()->id, 'course_id' => $course->id]
        );

        session()->flash('course_pre_registration_success_message', 'پیش ثبت نام انجام شد. پیام اطلاع رسانی شروع دوره برای شما ارسال خواهد شد.');

        return Redirect::to('course/' . $slug);
    }

  public function course_index()
  {
    //Session::flush();

    $cats = getCategory('course');

    $courses = Cookie::get('courses');
    $webinars = Cookie::get('webinars');
    $preprouctions = Cookie::get('preprouctions');
    $comments = Cookie::get('comments');

    if ($courses == null) {
      $courses = course::where('status', '=', 1)->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))->with(array('teacher' => function ($query) {
        $query->select('id', 'fullname');
      }))
        ->select('id', 'title', 'slug', 'image', 'price', 'hour', 'minutes', 'video_minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'view_count')
        ->get();

      cookie('courses', $courses, 500);

      $moreview_courses = $courses->sortByDesc('view_count');
      $newst_courses = $courses->sortByDesc('id');

    }


    $courses_count = $courses->count();
    $sum_hours = $courses->sum('hour');
    $sum_minutes = $courses->sum('minutes');
    $sum_video_minutes = $courses->sum('video_minutes');

    $total_learn_time = ($sum_hours * 60) + $sum_minutes + $sum_video_minutes;


    $webinars = webinar::where("status", ">=", 1)->where("have_video", "=", 1)
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->get()
      ->sortByDesc('id');
    // ->take(6);


    $webinar_count = $webinars->count();
    $sum_hours = $webinars->sum('hour');
    $sum_minutes = $webinars->sum('minutes');

    $total_learn_time = $total_learn_time + ($sum_hours * 60) + $sum_minutes;

    $webinars = $webinars->take(6);

    $skill_count=$webinar_count+$courses_count;

    //   cookie('webinars', $webinars, 500);

    if ($preprouctions == null) {
      $preprouctions = course::where('status', '=', 2)
        ->with(array('category' => function ($query) {
          $query->select('id', 'title');
        }))->with(array('teacher' => function ($query) {
          $query->select('id', 'fullname');
        }))
        ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price', 'img_slider', 'img_slider_mobile', 'img_big_banner', 'have_certificate')
        ->latest()
        ->take(8)
        ->get();

      cookie('preprouctions', $preprouctions, 1400);
    }

    if ($comments == null) {

      $comments = comment::where("type", "=", "course")
        ->where("status", "=", 1)
        ->where("comment", "<>", '')
        ->with(array('user' => function ($queryuser) {
          $queryuser->select('id', 'name', 'code', 'image');
        }))
        ->select('id', 'id_target', 'id_user', 'score', 'regist_date', 'comment')
        ->latest()
        ->take(30)
        ->get();

      cookie('comments', $comments, 500);
    }

    $teachers_count = Cookie::get('teachers_count');
    // $teachers_count=[];
    $teachers = [];
    if ($teachers_count == null) {
      $teachers = teacher::where('status', '>', 0)->select('id', 'code', 'img_mini_banner', 'fullname', 'status')->orderByDesc('id')->get();
      $teachers_count = count($teachers);
      cookie('teachers_count', $teachers_count, 500);
      //dd($teachers);
    }

    $student_count = classroom::count('id_user');
    $student_count_weinar = webinar_register::count('id_user');

    $student_count = $student_count + $student_count_weinar;

    cookie('students_count', $student_count, 500);

    $states = getState();
    return view("course.course_index", compact('courses', 'webinars', 'newst_courses', 'moreview_courses', 'teachers_count', 'courses_count', 'student_count', 'total_learn_time', 'states', 'cats', 'teachers', 'preprouctions', 'comments', 'webinar_count','skill_count'));

  }

  public function course()
  {
    $cats = getCategory('course');
    foreach ($cats as $cat) {
      $courses = course::where('id_mega', '=', $cat->id)->where("status", "=", 1)
        ->select('id', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count')->get();

      $sum_hours = $courses->sum('hour');
      $sum_minutes = $courses->sum('minutes');
      $total_register = $courses->sum('register_count');
      $total_learn_time = ($sum_hours * 60) + $sum_minutes;
      $cat->total_learn_time = $total_learn_time;
      $cat->total_register = $total_register;
    }
    return view("course/course_category", compact('cats', 'courses'));
  }

  public function category_course($slug)
  {
    $cat=category::where("slug",$slug)->first();
    $cats = category::all();
      $id_category = 0;
    $query = course::with([
        'category' => function ($query) {
          $query->select('id', 'title');
        },
        'teacher' => function ($query) {
          $query->select('id', 'fullname');
        }
      ])->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price', 'have_certificate');

      $cat_title='';
    if ($cat) {
        $query->where('id_category', $cat->id);
        $cat_title = $cat->title;
        $id_category = $cat->id;
    }



    $search = request()->search;
    if ($search == 'undefined')
      $search = '';
    if ($search) $query->where('title', 'LIKE', "%$search%");

    $price = request()->price;
    if ($price === 'free') $query->where('price', 0);
    elseif ($price === 'nonFree') $query->where('price', '>', 0);

    $type = request()->type;
    if ($type === 'course') $query->where('type', 'course');
    elseif ($type === 'duble') $query->where('type', 'duble');
    elseif ($type === 'subtitle') $query->where('type', 'subtitle');

    $sort = request()->sort;
    if ($sort) $query->latest($sort);

    $minPrice = (int)(str_replace(',', '', request()->minPrice));
    $maxPrice = (int)(str_replace(',', '', request()->maxPrice));
    if ($maxPrice) $query->whereBetween('price', [$minPrice, $maxPrice]);

    $level = request()->level;
    if (in_array($level, ['level1', 'level2', 'level1'])) $query->where('title', $level);

    $courses = $query->paginate(9);
    return view("course.search_course", compact("courses", "cats", "slug", "cat_title","id_category"));
  }

  public function course_suggestion()
  {
      Auth::loginUsingId(1);
    $states = getState();
    return view('course_suggestion', compact('states'));
  }

  public function invite_teacher()
  {
    $states = getState();
    return view("invite_teacher", compact("states"));
  }

  public function invite_teacher_register(Request $request)
  {
    if (checkValidIP($request->header('x-forwarded-for'))) {

      $fullname = $request->fullname;
      $phonenumber = $request->phonenumber;
      $tel = $request->tel;
      $birthdate = $request->birthdate;
      $gender = $request->gender;
      $state = $request->state;
      $city = $request->city;
      $fields = $request->fields;
      $memo = $request->memo;
      $code = generateIdeaCode();
      $rezoumeName = "";
      $sampleName = "";

      if ($request->file('attach_rezoume')) {
        $folderPath = "_upload_/_invite_/_teacher_/" . $code;
        $rezoumeName = uploadFile($request->file('attach_rezoume'), $folderPath);
      }

      if ($request->file('attach_sample')) {
        $folderPath = "_upload_/_invite_/_teacher_/" . $code;
        $sampleName = uploadFile($request->file('attach_sample'), $folderPath);
      }

      $invite = new invite();
      $invite->type = "teacher";
      $invite->code = $code;
      $invite->fullname = $fullname;
      $invite->phonenumber = $phonenumber;
      $invite->tel = $tel;
      $invite->birthdate = $birthdate;
      $invite->gender = $gender;
      $invite->id_state = $state;
      $invite->id_city = $city;
      $invite->fields = $fields;
      $invite->attach_rezoume = $rezoumeName;
      $invite->attach_sample = $sampleName;
      $invite->memo = $memo;
      $invite->regist_date = nowDate_Shamsi();
      $invite->status = 0;
      $invite->save();

      sendSMS_InviteTeacher($phonenumber, $fullname);

      return ($this->ajax_response(false, '', 'درخواست شما ثبت و در اسرع وقت بررسی و نتیجه خدمت شما اطلاع رسانی می گردد. باتشکر', 'success'));
    } else
      return ($this->ajax_response(true, '', 'دسترسی غیرمجاز از شبکه', 'error'));
  }

  public function course_detail($slug)
  {
      $course = course::where('slug', $slug)->first();
      if(!$course)
        return view("course.course_404");

//      Auth::loginUsingId(37701);
//      classroom::where("id_course", "=", $course->id)->where("id_user", "=", Auth::id())->delete();

      $id_course=$course->id;
      $id_user = 0;
      $category_t = category::where("id", $course->id_category)->first();
      $category_title='';
      if($category_t != null)
        $category_title=$category_t->title;

      if (Auth::check())
          $id_user = Auth::user()->id;

      $teacher = teacher::where("id", "=", $course->id_teacher)
        ->select('id', 'fullname', 'code', 'image', 'education')
        ->first();


      $lessons_seasons_group = lesson::where("id_course", "=", $id_course)
        ->select('season', 'season_title')
        ->groupBy('season', 'season_title')
        ->get();


      $lessons = lesson::where("id_course", $id_course)
        ->with(array('userlesson' => function ($queryuser) use ($id_user, $id_course) {
          $queryuser->where('id_user', '=', $id_user);
          $queryuser->where('id_course', '=', $id_course);
          $queryuser->select('id', 'id_user', 'id_course', 'id_lesson', 'regist_date', 'status');
        }))
        ->select('id', 'id_course', 'title', 'season','hour', 'minutes', 'size', 'memo', 'lesson_number', 'isFree','cloud_mp4_url')
        ->orderby('lesson_number')
        ->get();

      $classroom = classroom::where("id_course",  $id_course)
        ->with(array('user' => function ($queryuser) {
          $queryuser->select('id', 'name', 'image', 'code')->take(6)->orderBy('id', 'asc')->get();;
        }))
        ->select('id', 'id_course', 'id_user', 'quiz_result')
        ->latest()
        ->limit(6)
        ->get();

      $comments = comment::where("type", "=", "course")
        ->where("status", "=", 1)
        ->where("id_target", "=", $id_course)
        ->with(array('user' => function ($queryuser) {
          $queryuser->select('id', 'name', 'code', 'image');
        }))
        ->select('id', 'id_target', 'id_user', 'score', 'regist_date', 'comment')
        ->latest()
        ->paginate(10);

      $related_course = course::where('type', "course")->where('status', '1')
        ->where('id_category',  $course->id_category)
        ->where('id', '<>', $course->id)
        ->with(array('category' => function ($query) {
          $query->select('id', 'title');
        }))->with(array('teacher' => function ($query) {
          $query->select('id', 'fullname');
        }))
        ->select('id', 'type','title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'abstractMemo', 'score', 'discount', 'old_price')
        ->get();

      $taked_course = null;
      if (Auth::check()) {
         $taked_course = classroom::where('id_course',  $id_course)
            ->where('id_user',  $id_user)
            ->first();
      }

      $pre_registrated_course = null;
      if (Auth::check()) {
          $pre_registrated_course = course_pre_registration::where('course_id',  $id_course)
              ->where('user_id',  $id_user)
              ->first();
      }

//      if (Auth::check())
//        if (Auth::user()->isManager())
//          $taked_course = true;
//          $pre_registrated_course = true;


      $favorite_status = false;
      if (Auth::check()) {
        $user_fav = user_favorite::where("id_user", "=", Auth::user()->id)
          ->where("type", "course")
          ->where("id_target", $id_course)
          ->first();
        if ($user_fav == null)
          $favorite_status = false;
        else
          $favorite_status = true;
      }

      if ($course->view_count >= 0)
        $course->increment('view_count');
      else {
        $course->view_count = 0;
        $course->save();
      }

      $attachs = lesson_attach::where("id_course", "=", $id_course)
        ->where("id_lesson", "=", 0)
        ->orderBy('category', 'asc')->select('id','id_lesson','id_course','category','title','memo','filesize')->get();

      $attach_dic = [];
      foreach ($attachs as $attach) {
        $attach_dic[$attach->category][] = $attach;
      }
      $course->save();

      foreach ($lessons as $lesson) {
          if ($lesson->isFree != 1)
            $lesson->cloud_mp4_url = '';
      }
      $kasboomSurveyFieldId = [29, 28, 27, 25, 24, 14, 8];
      $kasboomSurveyField = KasboomSurveyField::whereIn('id', $kasboomSurveyFieldId)->select('id', 'title')->get();
      $kasboomSurvey = KasboomSurvey::whereIn('survey_field_id', $kasboomSurveyFieldId)
        ->where('id_target', $id_course)->get();

      $kasboomSurveys = [];
      foreach ($kasboomSurveyFieldId as $fieldId) {
        $score = $kasboomSurvey->where('survey_field_id', $fieldId)->sum('score');
        $count = $kasboomSurvey->where('survey_field_id', $fieldId)->count();
        if($count >0)
            $kasboomSurveys[$fieldId] = ['score' => substr((($score / $count) * 20), 0, 4)];
        else
        $kasboomSurveys[$fieldId]=0;

      }
      return view("course/course_detail", compact( 'kasboomSurveys', 'kasboomSurveyField', 'course', 'category_title', 'teacher', 'lessons', 'classroom', 'related_course', 'taked_course', 'pre_registrated_course', 'comments', 'favorite_status', 'attach_dic','lessons_seasons_group'));
  }

  public function lesson_detail($id_course, $id_lesson, $title = null)
  {
    $lesson = [];
    $lesson_attachs = [];
    $notes = [];
    $course = null;
    $lesson_of_course = lesson::where("id", "=", $id_lesson)->where("id_course", "=", $id_course)->first();
    $course = course::where('id', '=', $id_course)->select('id', 'code', 'title', 'id_teacher', 'image')->first();
    if (!empty($lesson_of_course)) {
      $lessons = lesson::where("id_course", "=", $id_course)->select('id', 'hour', 'minutes', 'lesson_number', 'title', 'poster_url')->orderBy('lesson_number', 'asc')->get();
      if ($lesson_of_course->isFree == 1) {
        $lesson = lesson::where('id_course', '=', $id_course)->where('id', '=', $id_lesson)->first();
        $lesson_attachs = lesson_attach::where('id_course', '=', $id_course)->where('id_lesson', '=', $id_lesson)->get();
        return view("course/lesson_detail", compact('course', 'lesson', 'lesson_attachs', 'notes', 'lessons'));
      } else {
        if (Auth::check()) {
          if (Auth::user()->level == "teacher") {
            $id_teacher = Auth::user()->id_teacher;
            if ($course->id_teacher == $id_teacher) {

              $lesson = lesson::where('id_course', '=', $id_course)->where('id', '=', $id_lesson)->first();
              $lesson_attachs = lesson_attach::where('id_course', '=', $id_course)->where('id_lesson', '=', $id_lesson)->get();
              $notes = note::where('id_course', '=', $id_course)->where('id_lesson', '=', $id_lesson)->where('id_user', '=', Auth::user()->id)->get();
              return view("course/lesson_detail", compact('course', 'lesson', 'lesson_attachs', 'notes', 'lessons'));
            }
          } else {
            $user_in_class = classroom::where("id_course", "=", $id_course)->where("id_user", "=", Auth::user()->id)->first();
            if (($user_in_class != null) || (Auth::user()->isManager()) || ($lesson_of_course->isFree == 1)) {
              if ($lesson_of_course != null) {
                $lesson = lesson::where('id_course', '=', $id_course)->where('id', '=', $id_lesson)->first();
                $lesson_attachs = lesson_attach::where('id_course', '=', $id_course)->where('id_lesson', '=', $id_lesson)->get();
                $notes = note::where('id_course', '=', $id_course)->where('id_lesson', '=', $id_lesson)->where('id_user', '=', Auth::user()->id)->get();
                $course = course::where('id', '=', $id_course)->select('id', 'code', 'title')->first();
                return view("course/lesson_detail", compact('course', 'lesson', 'lesson_attachs', 'notes', 'lessons'));
              } else
                return view("404");
            } else
              return Redirect::to("skill/take_course/" . $id_course);
          }
        } else
          return redirect("web");
      }

      return view("course/lesson_detail", compact('course', 'lesson', 'lesson_attachs', 'notes', 'lessons'));

    } else
      return view("404");

  }

  public function quiz($id_course, $title = null)
  {
    $nowDate = date("Y-m-d");
    $nowdate_shamsi = nowDate_Shamsi();

    $id_user = Auth::user()->id;
    $user_course_status = classroom::where("id_user", "=", $id_user)
      ->where("id_course", "=", $id_course)
      ->first();
    if ($user_course_status != null) {
      if ($user_course_status->result == "finish") {
        if (!empty($user_course_status)) {
          $last_date_take_quize_miladi = $user_course_status->last_date_take_quize_miladi;
          if ($last_date_take_quize_miladi == null) {
            $ques = quiz_question::where('id_course', '=', $id_course)->inRandomOrder()->take(20)->get();
            $course = course::where('id', '=', $id_course)->select('id', 'code', 'title')->first();
            $user_course_status->last_date_take_quize = $nowdate_shamsi;
            $user_course_status->last_date_take_quize_miladi = $nowDate;
            $user_course_status->take_quiz = 1;
            $user_course_status->save();
            return view("course/quiz", compact('ques', 'course'));
          } else {
            $now = time();
            $your_date = strtotime($last_date_take_quize_miladi);
            $datediff = $now - $your_date;
            $diff_days = (abs((int)round($datediff / (60 * 60 * 24))));
            if ($diff_days >= 15) {
              $ques = quiz_question::where('id_course', '=', $id_course)->inRandomOrder()->take(3)->get();
              $course = course::where('id', '=', $id_course)->select('id', 'code', 'title')->first();
              return view("course/quiz", compact('ques', 'course'));
            } else {
              $redirect = "skill/course/" . $id_course . "/" . $title;
              $day_mount = 15 - $diff_days;
              $title2 = str_replace("_", " ", $title);
              $message = "شما بعد از " . $day_mount . "  روز می توانید مجددا در آزمون  ' " . $title2 . " ' شرکت کنید ";
              $title = "وضعیت شرکت در آزمون";
              return view("message", compact("message", 'title', 'redirect'));
            }
          }
        }
      } else {
        if ($user_course_status->result == "learning") {
          $redirect = "skill/course/" . $id_course . "/" . $title;
          $title2 = str_replace("_", " ", $title);
          $message = "برای شرکت در آزمون حتما باید تمامی درس های دوره ی آموزشی را مشاهده نمائید";
          $title = "وضعیت شرکت در آزمون";
          return view("message", compact("message", 'title', 'redirect'));
        } elseif ($user_course_status->result == "certificate") {
          $redirect = "skill/course/" . $id_course . "/" . $title;
          $title2 = str_replace("_", " ", $title);
          $message = "قبلا در آزمون این دوره شرکت کرده اید و گواهی پایان دوره برا شما صادر شده است";
          $title = "وضعیت شرکت در آزمون";
          return view("message", compact("message", 'title', 'redirect'));
        }
      }

    } else {
      $title = "آزمون دوره";
      $message = "امکان شرکت در آزمون دوره " . $title . " را ندارید ";
      $redirect = "skill";
      return view("message", compact("title", "message", "redirect"));
    }

  }

  public function quiz_result($id_course, $title = null)
  {
    $id_user = Auth::user()->id;

    $class_room = classroom::where("id_user", "=", $id_user)
      ->where("id_course", "=", $id_course)
      ->first();
    $user_quizs = user_quiz::where('id_user', '=', $id_user)->where('id_course', '=', $id_course)
      ->with(array('questions' => function ($query) {
        $query->select('id', 'question');
      }))->get();

    $course = course::where('id', '=', $id_course)->select('id', 'code', 'title')->first();

    return view("course/quiz_result", compact('user_quizs', 'course', 'class_room'));
  }

  public function category()
  {
    $cats = category::where('status', '=', 1)->where('type', '=', 'course')
      ->with(array('courses' => function ($query) {
        $query->select('id_category', 'title')->orderBy('id', 'asc')->take(8);
      }))->get();
    return view("category", compact('cats'));
  }

  function adduserquesresult($id_user, $id_course, $id_ques, $user_answer, $answer)
  {

    user_quiz::updateOrInsert(
      ['id_user' => $id_user, 'id_course' => $id_course, 'id_quize_questions' => $id_ques, 'user_answer' => (int)$user_answer, 'answer' => $answer]
    );
  }

  public function quiz_correction(request $request)
  {

    $nowDate = date("Y-m-d");
    $nowdate_shamsi = nowDate_Shamsi();
    $id_course = $request->course_id;

    $id_user = Auth::user()->id;
    $user_course_status = classroom::where("id_user", "=", $id_user)
      ->where("id_course", "=", $id_course)
      ->first();

    if ($user_course_status != null) {
      if ($user_course_status->result == "finish") {
        if ($user_course_status->certificate_status == 'صدور مدرک') {
          $redirect = "skill/course/" . $id_course . "/";
          $message = "شما قبلا در آزمون این دوره شرکت کرده اید و گواهی پایان دوره نیز برای شما ارسال شده است.";
          $title = "وضعیت شرکت در آزمون";
          return view("message", compact("message", 'title', 'redirect'));
        } else {
          $last_date_take_quize_miladi = $user_course_status->last_date_take_quize_miladi;
          $now = time();

          $your_date = strtotime($last_date_take_quize_miladi);

          $datediff = $now - $your_date;
          $diff_days = (abs((int)round($datediff / (60 * 60 * 24))));
          if (($diff_days >= 15) or ($your_date == false)) {
            $score = 0;
            $cnt_quest = 0;
            $cnt_true_answer = 0;
            $cnt_quest = 20;
            user_quiz::where("id_course", "=", $id_course)->where("id_user", "=", $id_user)->delete();
            foreach ($request->except(['_token', 'course_id', 'course_title']) as $key => $value) {

              $ques_id = str_replace("ques_", "", $key);
              $ques_user_answer = $value;
              $ques = quiz_question::where("id", "=", $ques_id)->select('id', 'question', 'answer')->first();
              if ((int)$ques_user_answer == (int)$ques->answer) {
                $this->adduserquesresult($id_user, $id_course, $ques_id, (int)$ques_user_answer, 1);
                $cnt_true_answer = $cnt_true_answer + 1;
              } else
                $this->adduserquesresult($id_user, $id_course, $ques_id, (int)$ques_user_answer, 0);
            }

            if ($cnt_quest > 0)
              $score = ($cnt_true_answer / $cnt_quest) * 100;
            else
              $score = 0;
            $score = (int)round($score);
            $class_room = classroom::where("id_user", "=", $id_user)
              ->where("id_course", "=", $id_course)
              ->first();

            $quiz_result = 0;
            if ($score < 70)
              $quiz_result = 0;
            else {
              $quiz_result = 1;
              $class_room->certificate_status = "صدور مدرک";
            }


            $class_room->last_date_take_quize_miladi = $nowDate;
            $class_room->last_date_take_quize = $nowdate_shamsi;
            $class_room->take_quiz = 1;
            $class_room->quiz_score = $score;
            $class_room->quiz_result = $quiz_result;

            $class_room->save();

            $nowdate = nowDate_Shamsi();
            $course = course::where('id', '=', $id_course)->select('id', 'code', 'title')->first();
            $user_quizs = user_quiz::where('id_user', '=', $id_user)->where('id_course', '=', $id_course)
              ->with(array('questions' => function ($query) {
                $query->select('id', 'question');
              }))->get();

            //sendSMS_Course_Quiz(Auth::user()->name, $course->title, $score, $nowdate, Auth::user()->phonenumber);
            return view("course/quiz_result", compact('user_quizs', 'course', 'class_room'));
          } else {
            $redirect = "skill/course/" . $id_course . "/";
            $day_mount = 15 - $diff_days;
            $message = "شما بعد از " . $day_mount . "  روز می توانید مجددا در آزمون  شرکت کنید ";
            $title = "وضعیت شرکت در آزمون";
            return view("message", compact("message", 'title', 'redirect'));
          }
        }
      }
    }
  }

  public function cat_lessons($id_category, $title = null)
  {
    $cat = category::where('id', '=', $id_category)->select('id', 'title')->first();
    return view('course/cat_courses', compact('courses', 'cat'));
  }

  public function search_course(Request $request)
  {
    $cours_title = $request->course_name;
    $id_category = (int)$request->category;
    $cat_title = '';

    if ($id_category <> 0) {
      $courses = course::where('status', '=', 1)
        ->where('title', 'like', '%' . $cours_title . '%')
        ->where('id_category', '=', $id_category)
        ->with(array('category' => function ($query) {
          $query->select('id', 'title');
        }))
        ->with(array('teacher' => function ($query) {
          $query->select('id', 'fullname');
        }))
        ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'learn_type', 'code', 'abstractmemo', 'score')
        ->orderBy('id', 'desc')
        ->get();

      $cat_title = category::where('id', '=', $id_category)->select('title')->first()->title;
    } else {
      $courses = course::where('type', '=', "course")
        ->where('status', '=', 1)
        ->where('title', 'like', '%' . $cours_title . '%')
        ->with(array('category' => function ($query) {
          $query->select('id', 'title');
        }))
        ->with(array('teacher' => function ($query) {
          $query->select('id', 'fullname');
        }))
        ->select('id', 'title', 'image', 'price', 'hour', 'abstractMemo', 'minutes', 'id_category', 'id_teacher', 'register_count', 'learn_type', 'code', 'memo', 'score')
        ->orderBy('id', 'desc')
        ->get();

      $cat_title = 'همه گروه های آموزشی';
    }
    return view('search_result', compact('courses', 'cat_title'));
  }

  public function public_search(Request $request)
  {
    $search_type = $request->search_type;
    $course_title = $request->search_title;
    if ($search_type == 'course') {
      $cats = getCategory('course');
      $courses = course::where("status", "=", 1)
        ->where("title", "like", "%" . $course_title . "%")
        ->orwhere("abstractMemo", "like", "%" . $course_title . "%")
        ->with(array('category' => function ($query) {
          $query->select('id', 'title');
        }))->with(array('teacher' => function ($query) {
          $query->select('id', 'fullname');
        }))
        ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'abstractMemo', 'score', 'discount', 'old_price', 'view_count', 'like_count', 'comment_count')
        ->paginate(6);

      $id_category = 0;
      return view("course.search_course", compact("courses", "cats", "id_category"));
    }

  }

  public function search()
  {
    $cats = getCategory('course');

    return view('search', compact('cats'));
  }

  public function take_course($id_course, $slug = null)
  {
    $course_count=env('course_count');
    if (Auth::check()) {
     // if(auth()->user()->corp_type == 'talabe') {
        $user_id = Auth::user()->id;
        $payments_count=0;
        $user_in_class = classroom::where("id_course", "=", $id_course)->where("id_user", "=", Auth::user()->id)->first();
        if (empty($user_in_class)) {
//                $factor_id = generateNewFactorID();
          $nowdate_shamsi = nowDate_Shamsi();
          $course = course::where("id", "=", $id_course)->select('id', 'title', 'abstractMemo', 'hour', 'minutes', 'price', 'subsid_limit')->first();
          if ($course->price >= 0) {
            $user_name = Auth::user()->name;
            $wallet = 0;
            if (Auth::user()->isTeacher()) {
              $id_teacher = Auth::user()->id_teacher;
              $teacher = teacher::where("id", "=", $id_teacher)->first();
              if ($teacher != null)
                $wallet = $teacher->wallet;
            } else {
              $wallet = Auth::user()->wallet;
            }

            $user_subsid = Auth::user()->subsid;
            $subsid = $user_subsid > $course->subsid_limit ? $course->subsid_limit : $user_subsid;

            return view('course/take_course', compact('course', 'nowdate_shamsi', 'user_name', 'wallet', 'subsid', 'payments_count', 'course_count'));
          }

        } else {

          return Redirect::to('course/' . $slug);
        }
     // }
     // else{
     //   $title="جشنواره زمستانه کسبوم";
     //   $message="این جشنواره ویژه طلاب و خانواده طلاب سراسر کشور می باشد. در صورتی که به صورت آزاد در سایت ثب نام نموده اید می توانید بعد از جشنواره اقدام به خرید دوره نمائید";
     //   $redirect='#';
     //   return view("message_user", compact("title", "message", "redirect"));


   //   }

    } else {

      Session::put('previeusPage', 'skill/take_course/' . $id_course . '/' . $slug);
      return redirect("web");
    }
  }

  public function search_course_ajax(Request $request)
  {
    $course_title = $request->course_name;

    $courses = course::where('status', '=', 1)
      ->where('title', 'like', '%' . $course_title . '%')
      ->orWhere('abstractMemo', 'like', '%' . $course_title . '%')
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->with(array('teacher' => function ($query) {
        $query->select('id', 'fullname');
      }))
      ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'register_count', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'abstractMemo', 'score', 'old_price', 'have_certificate')
      ->orderBy('id', 'desc')
      ->get();

    return ($this->ajax_response(false, $courses, '', 'success'));

  }

  public function filter_course_ajax(Request $request)
  {
    $min_price = (int)$request->min_price;
    $max_price = (int)$request->max_price;
    $level1 = (int)$request->level1;
    $level2 = (int)$request->level2;
    $level3 = (int)$request->level3;
//    $online = (int)$request->type_online;
//    $offline = (int)$request->type_offline;
    $cats = $request->cats;

    if ($cats != null)
      $id_categorys = array_map('intval', explode(',', $cats));
    else
      $id_categorys = null;


    $levels = [];
    $types = [];
    if ($level1 == 1)
      array_push($levels, 'level1');
    if ($level2 == 1)
      array_push($levels, 'level2');
    if ($level3 == 1)
      array_push($levels, 'level3');

//    if ($online == 1)
//      array_push($types, 'آفلاین');
//    if ($offline == 1)
//      array_push($types, 'حضوری');

    $query = course::where('type', '=', "course")
      ->where('status', '=', 1)
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->with(array('teacher' => function ($query) {
        $query->select('id', 'fullname');
      }));

    if ($id_categorys != null) {
      if (count($id_categorys) > 0)
        $query = $query->wherein('id_category', $id_categorys);
    }
    if ($levels != null) {
      if (count($levels) > 0)
        $query = $query->wherein('level', $levels);
    }
//    if (count($types) > 0)
//      $query = $query->wherein('learn_type', $types);

    $query = $query->where('price', ">=", $min_price);
    $query = $query->where('price', "<=", $max_price);


    $query = $query->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'abstractMemo', 'score', 'discount', 'old_price')->orderBy('id', 'desc');

    return ($this->ajax_response(false, $query->get(), '', 'success'));
  }

  public function category_courses(Request $request)
  {
    $id_category = $request->id_category;

    $query = course::where('status', '=', 1)
      ->where("id_category", "=", $id_category)
      ->with(array('teacher' => function ($query) {
        $query->select('id', 'fullname');
      }))
      ->select('id', 'title', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'abstractMemo', 'score', 'discount', 'old_price')
      ->latest();

    return ($this->ajax_response(false, $query->get(), '', 'success'));

  }

  public function add_favorite_url(Request $request)
  {
    $id_course = $request->id_course;
    if (Auth::check()) {
        $course = course::findOrFail($id_course);

      $nowDate = date("Y-m-d");
      $nowdate_shamsi = jdate($nowDate)->format('%Y/%m/%d');

      $userfav = new user_favorite();
      $userfav->id_user = Auth::user()->id;
      $userfav->type = 'course';
      $userfav->id_target = $id_course;
      $userfav->regist_date = $nowdate_shamsi;
      $userfav->save();

      $title = str_replace(' ', '_', $request->title);

      return Redirect::to('course/' . $course->getSlug());

    } else {
      $title = str_replace(' ', '_', $request->title);
      Session::put('previeusPage', 'skill/add_favorite/' . $id_course . '/' . $title);
      return ($this->ajax_response(true, '', 'نیاز به ورود به سایت می باشد', 'error'));
    }

  }

  public function course_payment(Request $request)
  {
    $id_course = $request->id_course;
    $payment_type = $request->payment_type;
    $discount_code = $request->discount;
    $referral_user = intval(tr_num(trim($request->referral)));
    $payment_price = 0;
    $discount_price = 0;
    $discount_percent = 0;
    $course_price = 0;
    $remain_online_payment = 0;
    $course_price_with_discount = 0;
    $teacher_wallet = 0;
    $id_teacher = 0;
    $teacher = null;
    $course_info = course::where("id", "=", $id_course)->first();
    if (Auth::check()) {
      $user_subsid = Auth::user()->subsid;
      $subsid = $user_subsid > $course_info->subsid_limit ? $course_info->subsid_limit : $user_subsid;
      $user_wallet = Auth::user()->wallet;
      $id_teacher = $course_info->id_teacher;
      $teacher = User::where("level", "=", "teacher")->where("id_teacher", "=", $id_teacher)->first();
      if (!empty($course_info)) {
        $course_price = $course_info->price;
        $user_in_class = classroom::where("id_user", "=", Auth::user()->id)->where("id_course", "=", $id_course)->first();
        if ($user_in_class == null) {
          $discount = discount::where("discount_code", "=", $discount_code)->first();
          $teacher_percent = $course_info->teacher_percnet;

          if (empty($discount)) {
            $discount_code = 0;
            $discount_price = 0;
            $payment_price = $course_price;
            $course_price_with_discount = $course_price;
            $remain_online_payment = $course_price - ($user_wallet + $subsid);
          } else {
            $discount_percent = $discount->percent;
            $discount_price = ($discount_percent / 100) * ($course_price);
            $course_price_with_discount = $course_price - $discount_price;
            $payment_price = $course_price_with_discount;
            $remain_online_payment = $course_price_with_discount - ($user_wallet + $subsid);
          }

          if ($course_price > 0) {
            $teacher_wallet = ($payment_price * ($teacher_percent / 100));
          }


          if ($payment_type == "wallet") {
            if (($user_wallet + $subsid) >= $course_price_with_discount) {

              $nowDate = date("Y-m-d");
              $ticket_date = (date('Y-m-d', strtotime($nowDate . ' + 31 days')));
              $ticket_shamsi_date = jdate($ticket_date)->format('%Y/%m/%d');

              $class_id = classroom::insertGetId(
                ['id_user' => Auth::user()->id, 'id_course' => $id_course, 'regist_date' => nowDate_Shamsi(), 'result' => 'learning', 'take_quiz' => 0, 'status' => 1]
              );

              if (!empty($discount)) {
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
              }

              $factor = generateNewFactorID("skl");
              $RefID = 'wallet_' . $factor;
              $nowdate = nowDate_Shamsi();
              $payment = new payment();
              $payment->id_user = Auth::user()->id;
              $payment->payment_for = "course";
              $payment->id_target = $id_course;
              $payment->teacher_payment = $teacher_wallet;
              $payment->product_course_title = $course_info->title;
              $payment->regist_date = $nowdate;
              $payment->price = $course_info->price;
              $payment->discount_percent = $discount_percent;
              $payment->discount_code = $discount_code;
              $payment->discount_price = $discount_price;
              $payment->payment_price = $payment_price;
              $payment->authority = "wallet";
              $payment->bankname = "کیف پول";
              $payment->status = 1;
              $payment->subsid_price = $subsid;
              $payment->wallet_price = $payment_price - $subsid;
              $payment->refID = $RefID;
              $payment->factor_id = $factor;
              $payment->referral_user = $referral_user;
              $payment->referral_price = User::referral_price;
              $payment->save();

              //
              classroom::where('id', $class_id)->update([
                'payment_id' => $payment->id
              ]);

              //
              DB::table('users')
                ->where('id', $referral_user)
                ->update([
                  'wallet' => DB::raw('wallet + ' . User::referral_price),
                ]);

              //
              $course_info->increment('register_count');
              $course_info->save();

              if (!empty($teacher)) {
                $teacher->wallet = $teacher->wallet + $teacher_wallet;
                $teacher->total_income = $teacher->total_income + $teacher_wallet;
                $teacher->save();
              }

              if ($subsid > 0) {
                if ($payment_price <= $subsid) {
                  Auth::user()->subsid -= $payment_price;
                }
                else {
                  Auth::user()->subsid -= $subsid;
                  Auth::user()->wallet -= ($payment_price - $subsid);
                }
              } else {
                Auth::user()->wallet -= $payment_price;
              }

              Auth::user()->save();

              //sendSMS_Course_Register(Auth::user()->name, $course_info->title, $nowdate, Auth::user()->phonenumber, $RefID, $factor, $payment_price);

              //sendSMS_Course_Register(Auth::user()->name, $course_info->title, $nowdate, '09055165955', $RefID, $factor, $payment_price);


//               if ($course_info->price > 0 and !empty($teacher)){
//                   sendSMS_Course_Register_teacher(Auth::user()->name, $course_info->title, $nowdate, $teacher->phonenumber);
//                   sendSMS_Course_Register(Auth::user()->name, $course_info->title, $nowdate, '09055165955', $RefID, $factor, $payment_price);
//               }

              $type = "course";
              return view('course.payment_factor', compact('payment', 'type'));
            } else {
              $title = "پرداخت ناموفق";
              $message = "اعتبار شما برای پرداخت با کیف پول کافی نمی باشد";
              $redirect = "skill/take_course/" . $course_info->id . "/" . gethttplink($course_info->title);
              return view("message", compact("title", "message", "redirect"));
            }
          } else {

            $Description = 'ثبت نام دوره ' . $course_info->title;
            $Email = Auth::user()->email;
            $Mobile = Auth::user()->phonenumber;
            $CallbackURL = url('course/verifyPayment'); // Required
//            $CallbackURL = 'http://localhost/kasboom/public_html/skill/verifyPayment'; // Required
            $order = new zarinpal();
            $res = $order->pay($remain_online_payment, $Email, $Mobile, $Description, $CallbackURL);

            if ($res != false) {
              $payment = new payment();
              $payment->id_user = Auth::user()->id;
              $payment->payment_for = "course";
              $payment->id_target = $id_course;
              $payment->teacher_payment = $teacher_wallet;
              $payment->product_course_title = $course_info->title;
              $payment->regist_date = nowDate_Shamsi();
              $payment->price = $course_info->price;
              $payment->discount_percent = $discount_percent;
              $payment->discount_code = $discount_code;
              $payment->discount_price = $discount_price;
              $payment->payment_price = $remain_online_payment;
              $payment->subsid_price = $subsid;
              $payment->wallet_price = $user_wallet;
              $payment->authority = $res;
              $payment->refID = "0";
              $payment->bankname = "زرین پال";
              $payment->status = 0;
              $payment->referral_user = $referral_user;
              $payment->referral_price = User::referral_price;
              $payment->save();
            }
            return redirect('https://www.zarinpal.com/pg/StartPay/' . $res);
          }

        } else
          return Redirect::to('course/' . $course_info->getSlug());
      } else {
        $message = "ابتدا به حساب کاربری خود وارد شوید";
        $title = "عدم دسترسی";
        $redirect = 'course/take_course/' . $id_course . '/' . str_replace(" ", "_", $course_info->title);
        return view("message", compact("message", 'title', 'redirect'));
      }
    } else {
      Session::put('previeusPage', 'course/take_course/' . $id_course . '/' . str_replace(" ", "_", $course_info->title));
      return redirect("web");
    }

  }

  public function verifyPayment(Request $request)
  {
    $MerchantID = 'e7d6f566-c2e1-4fbe-9473-7ac3567a3944';
    $Authority = $request->get('Authority');
    $payment_price = 0;

    @mkdir(storage_path('payment' . DIRECTORY_SEPARATOR . date('Y-m-d')));
    $file = storage_path('payment' . DIRECTORY_SEPARATOR . date('Y-m-d') . DIRECTORY_SEPARATOR . $Authority . '.txt');
    file_put_contents($file, json_encode($_GET) . "\n", FILE_APPEND);


//      $directory = storage_path('payment' . DIRECTORY_SEPARATOR . date('Y-m-d'));
//      // بررسی و ایجاد پوشه
//      if (!is_dir($directory)) {
//          if (!mkdir($directory, 0777, true)) {
//              throw new Exception('Failed to create directory: ' . $directory);
//          }
//      }
//      // بررسی دسترسی نوشتن
//      if (!is_writable($directory)) {
//          throw new Exception('Directory is not writable: ' . $directory);
//      }
//      // پاکسازی Authority
//      $Authority = preg_replace('/[^A-Za-z0-9_-]/', '', $Authority);
//      $file = $directory . DIRECTORY_SEPARATOR . $Authority . '.txt';
//      // ذخیره داده‌ها
//      file_put_contents($file, json_encode($_GET) . "\n", FILE_APPEND);


    $payment = payment::where("authority", "=", $Authority)->first();
    if ($payment != null) {
      $payment_price = $payment->payment_price;
    } else {
      file_put_contents($file, 'Authority not found' . "\n", FILE_APPEND);
      abort(404);
    }

    if ($request->get('Status') != 'OK') {
      file_put_contents($file, 'Authority not found' . "\n", FILE_APPEND);
      $type = "course";
      return view('course.payment_factor', compact('payment', 'type'));
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

    if (!empty($result) and (($result->Status == 101) or ($result->Status == 100))) {
      if ((int)$payment->status == 0) {
        $id_course = $payment->id_target;
        $discount_code = $payment->discount_code;
        $teacher_wallet = $payment->teacher_payment;
        $RefID = $result->RefID;

        if (!Auth::check()) {
          $message = "ابتدا به حساب کاربری خود وارد شوید";
          $title = "عدم دسترسی";
          $redirect = "web";
          return view("message", compact("message", 'title', 'redirect'));
        }

        $course_info = course::where("id", "=", $id_course)->first();
        if (empty($course_info)) {
          $message = "ابتدا به حساب کاربری خود وارد شوید";
          $title = "عدم دسترسی";
          $redirect = 'skill/take_course/' . $id_course . '/' . str_replace(" ", "_", $course_info->title);
          return view("message", compact("message", 'title', 'redirect'));
        }

        //
        $user = Auth::user();
        $user_subsid = $user->subsid;
        if ($user_subsid < 0) $user_subsid = 0;
        $subsid = ($user_subsid > $course_info->subsid_limit) ? $course_info->subsid_limit : $user_subsid;

        //
        $user->wallet += $payment_price;
        $user->save();

        //
        $id_teacher = $course_info->id_teacher;
        $teacher = User::where("level", "=", "teacher")->where("id_teacher", "=", $id_teacher)->first();
        $course_price = $course_info->price;
        $user_in_class = classroom::where("id_user", "=", $user->id)->where("id_course", "=", $id_course)->first();

        if (!empty($user_in_class))
          return Redirect::to('course/' . $course_info->getSlug());

        $teacher_percent = $course_info->teacher_percnet;

        //
        $discount = discount::where("discount_code", "=", $discount_code)->where("status", "=", 0)->first();
        if (!empty($discount)) {
          $discount_percent = $discount->percent;
          $discount_price = ($discount_percent / 100) * ($course_price);
          $course_price -= $discount_price;
        }

        if ($course_price > 0) {
          $teacher_wallet = ($course_price * ($teacher_percent / 100));
        }

        //
        if ($user->wallet + $subsid < $course_price) {
          $title = "خرید ناموفق دوره آموزشی";
          $message = "اعتبار شما برای پرداخت با کیف پول کافی نمی باشد. مقدار کیف پول شما: " . number_format($user->wallet) . " تومان ";
//          $redirect = "skill/take_course/" . $course_info->id . "/" . gethttplink($course_info->title);
          $redirect = "skill/take_course/" . $course_info->id . "/" . $course_info->getSlug();
          return view("message", compact("title", "message", "redirect"));
        }

        $nowDate = date("Y-m-d");
        $ticket_date = (date('Y-m-d', strtotime($nowDate . ' + 31 days')));
        $ticket_shamsi_date = jdate($ticket_date)->format('%Y/%m/%d');

        classroom::updateOrInsert(
          [
            'id_user' => $user->id, 'id_course' => $id_course, 'regist_date' => nowDate_Shamsi(),
            'result' => 'learning', 'take_quiz' => 0, 'status' => 1, 'payment_id' => $payment->id
          ]
        );

        if (!empty($discount)) {
          $discount->id_user_used = $user->id;
          $discount->last_date_used = nowDate_Shamsi();
          if ($discount->type == 'single') $discount->status = 1;
          else if ($discount->type == 'multi') {
            $discount->remain --;
            $discount->status = $discount->remain < 1 ? 1 : 0;
          }
          $discount->save();
        }

        //
        $factor = generateNewFactorID("skl");
        $payment->status = 1;
        $payment->refID = $RefID;
        $payment->factor_id = $factor;
        $payment->save();

        //
        DB::table('users')
          ->where('id', $payment->referral_user)
          ->update([
            'wallet' => DB::raw('wallet + ' . $payment->referral_price),
          ]);

        //
        $course_info->increment('register_count');
        $course_info->save();

        if (!empty($teacher)) {
          $teacher->wallet += $teacher_wallet;
          $teacher->total_income += $teacher_wallet;
          $teacher->save();
        }

        // calc and update new wallet & subsid
        if ($course_price <= $subsid) $user->subsid -= $course_price;
        else {
          $user->subsid = $user_subsid - $subsid;
          $user->wallet -= ($course_price - $subsid);
        }
        $user->save();

        //
       // $nowdate = nowDate_Shamsi();
        //sendSMS_Course_Register($user->name, $course_info->title, $nowdate, $user->phonenumber, $RefID, $factor, $payment_price);
        //sendSMS_Course_Register($user->name, $course_info->title, $nowdate, '09055165955', $RefID, $factor, $payment_price);

        //if ($course_info->price > 0 and !empty($teacher)) {
          //sendSMS_Course_Register_teacher($user->name, $course_info->title, $nowdate, $teacher->phonenumber);
          //sendSMS_Course_Register($user->name, $course_info->title, $nowdate, '09055165955', $RefID, $factor, $payment_price);
       // }

        $type = "course";
        return view('course.payment_factor', compact('payment', 'type'));
      }

      $type = "course";
      return view('course.payment_factor', compact('payment', 'type'));
    } else {
      $type = "course";
      return view('course.payment_factor', compact('payment', 'type'));
//                return 'خطا در انجام عملیات';
    }
  }

  public function add_note(Request $request)
  {
//        dd($request->all());
    if (Auth::check()) {
      $id_course = (int)$request->id_course;
      $id_lesson = (int)$request->id_lesson;
      $note_title = $request->note_title;
      $note_body = $request->note_body;
      if (!empty($note_title)) {
        $note = new note();
        $note->id_course = $id_course;
        $note->id_lesson = $id_lesson;
        $note->id_user = Auth::user()->id;
        $note->note_title = $note_title;
        $note->note = $note_body;
        $note->save();

        return ($this->ajax_response(false, $note->id, 'ثبت بادداشت انجام شد', 'success'));
      } else
        return ($this->ajax_response(true, '', 'عنوان بادداشت خالی است', 'error'));
    } else
      return ($this->ajax_response(true, '', 'ابتدا به سایت وارد شوید', 'error'));
  }

  public function delete_note(Request $request)
  {
    if (Auth::check()) {
      $id_course = (int)$request->id_course;
      $user_in_class = classroom::where("id_course", "=", $id_course)->where("id_user", "=", Auth::user()->id)->first();
      if (!empty($user_in_class)) {
        note::destroy($request->id);

        return ($this->ajax_response(false, '', 'حذف بادداشت انجام شد', 'success'));
      } else
        return ($this->ajax_response(true, '', 'شما دسترسی این عملیات را ندارید', 'error'));
    } else
      return ($this->ajax_response(true, '', 'شما دسترسی این عملیات را ندارید', 'error'));

  }

  public function lesson_complete(Request $request)
  {
    $response = '';
    if (Auth::check()) {
      $id_course = $request->id_course;
      $user_in_class = classroom::where("id_course", "=", $id_course)->where("id_user", "=", Auth::user()->id)->first();
      if (!empty($user_in_class)) {
        $id_lesson = $request->id_lesson;
        $nowdate_shamsi = nowDate_Shamsi();
        userlesson::updateOrInsert(
          ['id_user' => Auth::user()->id, 'id_course' => $id_course, 'id_lesson' => $id_lesson, 'regist_date' => $nowdate_shamsi, 'status' => 1]
        );

        $array1 = array();
        $array2 = array();
//                dd(array_diff($array1,$array2));

        $user_lessons = userlesson::where("id_user", "=", Auth::user()->id)
          ->where("id_course", "=", $id_course)
          ->select('id', 'id_lesson')
          ->get()
          ->toArray();

        $course_lessons = lesson::where("id_course", "=", $id_course)
          ->select('id', 'lesson_number')
          ->get()
          ->toArray();

        foreach ($user_lessons as $user_lesson)
          array_push($array1, $user_lesson['id_lesson']);
        foreach ($course_lessons as $course_lesson)
          array_push($array2, $course_lesson['id']);

        if (array_diff($array1, $array2) == []) {
          classroom::where('id_user', '=', Auth::user()->id)
            ->where('id_course', '=', $id_course)
            ->update([
              'result' => "finish"
            ]);
        }

        return ($this->ajax_response(false, '', 'تکمیل درس دوره آموزشی انجام شد', 'success'));

      } else
        return ($this->ajax_response(true, '', 'شما دسترسی به این قست را ندارید', 'error'));
    } else
      return ($this->ajax_response(true, '', 'شما دسترسی به این قست را ندارید', 'error'));

  }

  public function get_certificate(Request $request)
  {
    $id_course = $request->id_course;
    $classroom = classroom::where("id_course", "=", $id_course)
      ->where("id_user", "=", Auth::user()->id)
      ->first();
    if ($classroom != null) {
      if ($classroom->result == "finish") {
        if ($classroom->certificate_status == 'تکمیل دوره' || $classroom->certificate_status == '') {
          $classroom->certificate_status = "صدور مدرک";
          $classroom->save();
          return ($this->ajax_response(false, '', 'درخواست صدور مدرک ثبت گردید', 'success'));
        } elseif ($classroom->certificate_status == 'صدور مدرک')
          return ($this->ajax_response(true, '', 'درخواست صدور مدرک قبلا ثبت شده است', 'error'));
      } elseif ($classroom->result == "learning")
        return ($this->ajax_response(true, '', 'ابتدا دوره مورد نظر را تکمیل نمائید', 'error'));
    } else
      return ($this->ajax_response(true, '', 'ابتدا در این دوره ثبت نام نمائید', 'error'));

  }

  public function add_form()
  {
    if (Auth::user()->can('create-course')) {
      $cats = getCategory('course');
      $states = getState();
      $teachers = teacher::where("status", 1)->select("id", "fullname")->get();
      return view("_manager.course.add_course", compact("cats", "states", "teachers"));
    } else
      return view("_manager.accessdenid");

  }

  public function add_course(Request $request)
  {
    if (Auth::user()->can('create-course')) {

//            return $request->all();
      $course_category = $request->course_category;
      $course_teacher = $request->course_teacher;
      $course_cloud_url = $request->course_cloud_url;
      $course_title = $request->course_title;
      $course_price = $request->course_price;
      $course_discount = $request->course_discount;
      $course_hour = $request->course_hour;
      $course_minutes = $request->course_minutes;
      $course_have_certificate = $request->course_have_certificate;
      $course_certificate_memo = $request->course_certificate_memo;
      $course_learn_type = $request->course_learn_type;
      $course_state = $request->course_state;
      $course_level = $request->course_level;
      $course_have_ticket = $request->course_have_ticket;
      $course_have_quiz = $request->course_have_quiz;
      $course_teacher_percnet = $request->course_teacher_percnet;
      $course_old_price = $request->course_old_price;
      $course_type = $request->course_type;

      if ($course_type == null)
        $course_type = "course";

      $code = generateIdeaCode();

      $course = new course();

      $imgFileName = '';
      $videoFileName = '';
      if ($request->file('course_image')) {
        $folderPath = "_upload_/_courses_/" . $code;
        $imgFileName = uploadImageFile($request->file('course_image'), $folderPath);
        $course->image = $imgFileName;
      }

      $course->code = $code;
      $course->type = $course_type;
      $course->id_category = $course_category;
      $course->id_teacher = $course_teacher;
      $course->title = $course_title;
      $course->cloud_url = $course_cloud_url;
      $course->price = $course_price;
      $course->discount = $course_discount;
      $course->hour = $course_hour;
      $course->minutes = $course_minutes;
      $course->have_certificate = $course_have_certificate;
      $course->certificate_memo = $course_certificate_memo;
      $course->learn_type = $course_learn_type;
      if ($course_state == null)
        $course_state = 0;
      $course->id_state = $course_state;
      $course->level = $course_level;
      $course->have_ticket = $course_have_ticket;
      $course->have_quiz = $course_have_quiz;
      $course->teacher_percnet = $course_teacher_percnet;
      $course->old_price = $course_old_price;
//            $course->intro_video = $videoFileName;
      $course->save();

      $id_course = $course->id;


      $cat = category::where("type", "=", "course")->where("id", "=", $course_category)->first();
      if ($cat->item_count >= 0)
        $cat->increment('item_count');
      else {
        $cat->item_count = 0;
        $cat->save();
      }

      return ($this->ajax_response(false, $id_course, 'ثبت تغییرات مشخصات دوره آموزشی با موفقیت انجام شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);
  }

  public function edit_course(Request $request)
  {
    if (Auth::user()->can('edit-course')) {

//            return $request->all();
      $course_category = $request->course_category;
      $course_teacher = $request->course_teacher;
      $course_cloud_url = $request->course_cloud_url;
      $course_title = $request->course_title;
      $course_price = $request->course_price;
      $course_discount = $request->course_discount;
      $course_hour = $request->course_hour;
      $course_minutes = $request->course_minutes;
      $course_have_certificate = $request->course_have_certificate;
      $course_certificate_memo = $request->course_certificate_memo;
      $course_learn_type = $request->course_learn_type;
      $course_state = $request->course_state;
      $course_level = $request->course_level;
      $id_course = $request->id_course;
      $course_have_ticket = $request->course_have_ticket;
      $course_have_quiz = $request->course_have_quiz;
      $course_teacher_percnet = $request->course_teacher_percnet;
      $course_old_price = $request->course_old_price;
      $course_type = $request->course_type;

      if ($course_type == null)
        $course_type = "course";

      $course = course::where("id", "=", (int)$id_course)->first();

      $code = $course->code;

      $imgFileName = '';
      $videoFileName = '';
      if ($request->file('course_image')) {
        $folderPath = "_upload_/_courses_/" . $code;
        $imgFileName = uploadImageFile($request->file('course_image'), $folderPath);
        $course->image = $imgFileName;
      }

      $course->id_category = $course_category;
      $course->id_teacher = $course_teacher;
      $course->title = $course_title;
      $course->cloud_url = $course_cloud_url;
      $course->price = $course_price;
      $course->discount = $course_discount;
      $course->hour = $course_hour;
      $course->minutes = $course_minutes;
      $course->have_certificate = $course_have_certificate;
      $course->certificate_memo = $course_certificate_memo;
      $course->learn_type = $course_learn_type;
      if ($course_state == null)
        $course_state = 0;
      $course->id_state = $course_state;
      $course->have_ticket = $course_have_ticket;
      $course->have_quiz = $course_have_quiz;
      $course->teacher_percnet = $course_teacher_percnet;
      $course->old_price = $course_old_price;
      $course->level = $course_level;
      $course->type = $course_type;
      $course->save();

      $id_course = $course->id;

      return ($this->ajax_response(false, $id_course, 'ثبت تغییرات مشخصات دوره آموزشی با موفقیت انجام شد', 'success'));

    } else {
      return response()->json($this->accessdenide_response);
    }
  }

  public function edit_course_info(Request $request)
  {
    if (Auth::user()->can('edit-course')) {

      $course_minimal_fund = $request->course_minimal_fund;
      $course_risk = $request->course_risk;
      $course_profitability = $request->course_profitability;
      $course_profitability_memo = $request->course_profitability_memo;
      $course_scale = $request->course_scale;
      $course_manpower = $request->course_manpower;
      $course_abstractMemo = $request->course_abstractMemo;
      $course_memo = $request->course_memo;
      $id_course = $request->id_course;

      $course = course::where("id", "=", $id_course)->first();
      if ($course != null) {
        $course->minimal_fund = $course_minimal_fund;
        $course->risk = $course_risk;
        $course->profitability = $course_profitability;
        $course->profitability_memo = $course_profitability_memo;
        $course->scale = $course_scale;
        $course->manpower = $course_manpower;
        $course->abstractMemo = $course_abstractMemo;
        $course->memo = $course_memo;
        $course->save();

        return ($this->ajax_response(false, '', 'ثبت اطلاعات دوره آموزشی با موفقیت انجام شد', 'success'));
      } else
        return ($this->ajax_response(true, '', 'مشکل در ثبت اطلاعات دوره آموزشی', 'error'));
    } else
      return response()->json($this->accessdenide_response);
  }

  public function edit_course_content(Request $request)
  {
    if (Auth::user()->can('edit-course')) {
      $course_content = $request->course_content;
      $id_course = $request->id_course;

      $course = course::where("id", "=", $id_course)->first();
      if ($course != null) {
        $course->content = $course_content;
        $course->save();

        return ($this->ajax_response(false, '', 'ثبت محتوی و سرفصل دوره آموزشی با موفقیت انجام شد', 'success'));
      } else
        return ($this->ajax_response(true, '', 'مشکل در ثبت محتوی دوره آموزشی', 'error'));
    } else
      return response()->json($this->accessdenide_response);
  }

  public function add_lesson(Request $request)
  {
    if (Auth::user()->can('create-lesson')) {
      $lesson_no = $request->lesson_no;
      $lesson_cloud_url = $request->lesson_cloud_url;
      $lesson_title = $request->lesson_title;
      $lesson_memo = $request->lesson_memo;
      $lesson_hour = $request->lesson_hour;
      $lesson_minutes = $request->lesson_minutes;
      $isFree = $request->isFree;
      $id_course = $request->id_course;

      $lesson = new lesson();
      $lesson->lesson_number = $lesson_no;
      $lesson->id_course = $id_course;
      $lesson->title = $lesson_title;
      $lesson->cloud_url = $lesson_cloud_url;
      $lesson->hour = $lesson_hour;
      $lesson->minutes = $lesson_minutes;
      $lesson->video = "";
      $lesson->memo = $lesson_memo;
      $lesson->status = 1;
      $lesson->isFree = $isFree;
      $lesson->save();

      return ($this->ajax_response(false, $lesson->id, 'ثبت درس آموزشی با موفقیت انجام شد', 'success'));

    } else
      return response()->json($this->accessdenide_response);
  }

  public function add_lesson_attach(Request $request)
  {
    if (Auth::user()->can('create-lesson')) {
      $attach_title = $request->attach_title;
      $id_course = $request->id_course;
      $id_lesson = $request->id_lesson;
      $course_code = $request->course_code;

      $fileName = "";
      if ($request->file('attach_file')) {
        $folderPath = "_upload_/_courses_/" . $course_code . "/lessons/lesson" . $id_lesson;
        $fileName = uploadFile($request->file('attach_file'), $folderPath);
      }

      $lesson = new lesson_attach();
      $lesson->id_course = $id_course;
      $lesson->id_lesson = $id_lesson;
      $lesson->attachment_file = $fileName;
      $lesson->title = $attach_title;
      $lesson->save();

      return ($this->ajax_response(false, $id_course, 'فایل ضمیمه درس با موفقیت ثبت شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);
  }

  public function lesson_attachments(Request $request)
  {
    if (Auth::user()->can('view-lesson')) {
      $id_lesson = $request->id_lesson;
      $id_course = $request->id_course;
      $lesson = lesson_attach::where("id_course", "=", $id_course)
        ->where("id_lesson", "=", $id_lesson)->get()->toArray();

      return ($this->ajax_response(false, $lesson, '', 'success'));

    } else
      return response()->json($this->accessdenide_response);
  }

  public function delete_course(Request $request)
  {
    if (Auth::user()->can('delete-course')) {
      $id_course = $request->id;

      $course = course::where("id", "=", $id_course)->first();
      if ($course != null) {
        $course->status = 0;
        $course->save();
      }

      return ($this->ajax_response(false, '', 'حذف دروه آموزشی با موفقیت انجام شد', 'success'));
    } else
      return response()->json($this->accessdenide_response);

  }

  public function courses()
  {
    if (Auth::user()->can('view-course')) {
      $course_count = course::count();
      $join_count = classroom::where("id_course", "!=", null)
        ->distinct()->select('id_user')->count();

      $join_finish_count = classroom::where("id_course", "!=", null)
        ->where("result", "finish")
        ->distinct()->select('id_user')->count();

      $comment_count = comment::where("type", "=", "course")->count();

      return view("_manager.course.courses", compact("course_count", "join_count", "join_finish_count", "comment_count"));
    } else
      return view("_manager.accessdenid");
  }

  public function all_courses()
  {
    if (Auth::user()->can('view-course')) {
      $per_delete = auth()->user()->can('delete-course');
      return Datatables::of(course::where("status", "=", 1)->select('id', 'code', 'title', 'id_teacher', 'price', 'register_count', 'view_count', 'like_count', 'status', 'image'))
        ->addColumn('category_title', function ($row) {
          return $row->getCategoryTitle();
        })
        ->addColumn('teacher_name', function ($row) {
          return $row->getTecherName();
        })
        ->addColumn('per_delete', function ($row) use ($per_delete) {
          return $per_delete;
        })
        ->make(true);
    }
    return [];
  }

  public function course_users_form()
  {
    if (Auth::user()->can('view-course')) {
      $users = classroom::where("id_course", "!=", null)->distinct()->select('id_user', 'result');
      $course_count = course::count();
      $user_count = $users->count();
      $finish_count = $users->where("result", "finish")->count();
      $quiz_count = $users->where("take_quiz", 1)->count();
      return view("_manager.course.users", compact("course_count", "user_count", "finish_count", "quiz_count"));
    }
  }

  public function allcourse_comments()
  {
    if (Auth::user()->can('comment-course')) {
      return Datatables::of(comment::where("type", "=", "course"))
        ->addColumn('fullname', function ($row) {
          return $row->getUserName();
        })->addColumn('title', function ($row) {
          return $row->getCourseName();
        })->make(true);
    } else
      return [];
  }

  public function all_course_users()
  {
    if (Auth::user()->can('view-course') and (Auth::user()->isManager())) {
      return Datatables::of(classroom::all())
        ->addColumn('fullname', function ($row) {
          return $row->getUserName();
        })
        ->addColumn('course_name', function ($row) {
          return $row->getCourseName();
        })
        ->addColumn('image', function ($row) {
          return $row->getUserImage();
        })
        ->make(true);
    } else
      return [];
  }

  public function show_course_users(Request $request)
  {
    $id_course = $request->id_course;

    if (Auth::user()->can('view-course')) {
      return Datatables::of(classroom::where("id_course", "=", $id_course))
        ->addColumn('fullname', function ($row) {
          return $row->getUserName();
        })
        ->addColumn('image', function ($row) {
          return $row->getUserImage();
        })
        ->make(true);
    } else
      return [];
  }

  public function show_course_messages(Request $request)
  {
    if (Auth::user()->can('view-course')) {
      $id_course = $request->id_course;
      $data = message::where("id_target", "=", $id_course)->get();
      return Datatables::of($data)
        ->addColumn('fullname', function ($row) {
          return $row->getUserName();
        })
        ->make(true);
    } else
      return [];
  }

  public function all_comments()
  {
    if (Auth::user()->can('comment-course')) {
      $comments = comment::where("type", "=", "course");
      $comment_count = $comments->count();
      $up_count = $comments->where("score", "=", 5)->count();
      $down_count = $comments->where("score", "=", 1)->count();
      $mean_count = 0;
      if ($comment_count > 0)
        $mean_count = ($comments->sum("score") / $comment_count);
      return view("_manager.course.comments", compact("comment_count", "up_count", "down_count", "mean_count"));
    } else
      return view("_manager.accessdenid");
  }

  public function show_course_comments(Request $request)
  {
    if (Auth::user()->can('comment-course')) {
      $id_course = $request->id_course;
      $data = comment::where("type", "=", "course")->where("id_target", "=", $id_course)->get();
      return Datatables::of($data)
        ->addColumn('fullname', function ($row) {
          return $row->getUserName();
        })->make(true);
    } else
      return [];
  }

  public function show_course_quizques(Request $request)
  {
    if (Auth::user()->can('view-course')) {
      $id_course = $request->id_course;
      $data = quiz_question::where("type", "=", "course")->where("id_course", "=", $id_course)->get();
      return Datatables::of($data)->make(true);
    } else
      return [];
  }

  public function manage_course_edit($id, $title = null)
  {
    if (Auth::user()->can('view-course')) {
      $course = course::where("id", "=", $id)->first();
      $lessons = lesson::where('id_course', $id)->get();
      $quiz_ques = quiz_question::where("id_course", $id)->get();
      $comments_count = comment::where("type", "comment")->where("id_target", "=", $id)->get();
      $cats = category::where('status', '=', 1)->where('type', '=', 'course')->select('id', 'category', 'title', 'class', 'item_count')->get();
      $teachers = teacher::where("status", 1)->select("id", "fullname")->get();
      return view("_manager/course/detail_course", compact("course", "lessons", "quiz_ques", "comments_count", "cats", "teachers"));
    } else
      return view("_manager.accessdenid");
  }

  public function delete_lesson(Request $request)
  {
    if (Auth::user()->can('delete-lesson')) {
      $id_course = $request->id_course;
      $id_lesson = $request->lesson_id;
      $response = [];

      $course = course::where("id", "=", $id_course)->first();
      $id_teacher = $course->id_teacher;
      if (($id_teacher == Auth::user()->id_teacher) || (Auth::user()->isManager())) {
        lesson_attach::where("id_course", "=", $id_course)
          ->where("id_lesson", "=", $id_lesson)->delete();
        $lesson = lesson::where("id_course", "=", $id_course)
          ->where("id", "=", $id_lesson)->first();
        $path = '_upload_/_courses_/' . $course->code . '/lessons/lesson' . $id_lesson;
//        dd(public_path($path));
        $lesson->delete();
        delete_directory($path);
        return ($this->ajax_response(false, '', 'حذف درس انجام شد', 'success'));

      } else
        return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));

    }


  }

  public function delete_lesson_attachment(Request $request)
  {
    $id_course = $request->id_course;
    $id_lesson = $request->lesson_id;
    $id_attach = $request->id_attach;
    $response = [];

    if (Auth::user()->can('delete-lesson')) {

      $id_teacher = course::where("id", "=", $id_course)->first()->id_teacher;
      if (($id_teacher == Auth::user()->id_teacher) || (Auth::user()->isManager())) {
        lesson_attach::where("id", "=", $id_attach)->delete();

        return ($this->ajax_response(false, '', 'حذف ضمیمه درس انجام شد', 'success'));
      } else
        return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));
    } else
      return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));
  }

  public function get_lesson(Request $request)
  {
    $id_course = $request->id_course;
    $id_lesson = $request->id_lesson;

    if (Auth::user()->can('view-lesson')) {
      $id_teacher = course::where("id", "=", $id_course)->first()->id_teacher;
      if (($id_teacher == Auth::user()->id_teacher) || (Auth::user()->isManager())) {
        $lesson = lesson::where("id", "=", $id_lesson)->first();
        if ($lesson != null)
          return ($this->ajax_response(false, $lesson, '', 'success'));
        else
          return ($this->ajax_response(true, '', 'درس مورد نظر ثبت نشده است', 'error'));
      } else
        return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));
    } else
      return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));

  }

  public function edit_lesson(Request $request)
  {
    if (Auth::user()->can('edit-course')) {
      $lesson_no = $request->lesson_no;
      $lesson_cloud_url = $request->lesson_cloud_url;
      $lesson_title = $request->lesson_title;
      $lesson_memo = $request->lesson_memo;
      $lesson_hour = $request->lesson_hour;
      $lesson_minutes = $request->lesson_minutes;
      $isFree = $request->isFree;
      $id_course = $request->id_course;
      $id_lesson = $request->lesson_id;

      $lesson = lesson::where("id", "=", $id_lesson)->first();
      if ($lesson != null) {
        $lesson->lesson_number = $lesson_no;
        $lesson->id_course = $id_course;
        $lesson->title = $lesson_title;
        $lesson->cloud_url = $lesson_cloud_url;
        $lesson->hour = $lesson_hour;
        $lesson->minutes = $lesson_minutes;
        $lesson->video = "";
        $lesson->memo = $lesson_memo;
        $lesson->status = 1;
        $lesson->isFree = $isFree;
        $lesson->save();

        return ($this->ajax_response(false, $id_course, 'ثبت اطلاعات درس با موفقیت انجام شد', 'success'));
      } else
        return ($this->ajax_response(true, '', 'درس مورد نظر ثبت نشده است', 'success'));
    } else {
      return response()->json($this->accessdenide_response);

    }
  }

  public function add_quiz_question(Request $request)
  {
    if (Auth::user()->can('edit-course')) {

      $quiz_question = $request->quiz_question;
      $quiz_option1 = $request->quiz_option1;
      $quiz_option2 = $request->quiz_option2;
      $quiz_option3 = $request->quiz_option3;
      $quiz_option4 = $request->quiz_option4;
      $quiz_answer = $request->quiz_answer;
      $id_course = $request->id_course;

      $response = [];

      if ($quiz_question == null)
        return ($this->ajax_response(true, '', 'سوال نمی تواند خالی باشد', 'error'));
      else {
        $exist = quiz_question::where("type", "=", "course")->where("id_course", "=", $id_course)->where("question", "=", $quiz_question)->first();
        if ($exist == null) {
          $ques = new quiz_question();
          $ques->type = "course";
          $ques->id_course = $id_course;
          $ques->question = $quiz_question;
          $ques->option1 = $quiz_option1;
          $ques->option2 = $quiz_option2;
          $ques->option3 = $quiz_option3;
          $ques->option4 = $quiz_option4;
          $ques->answer = $quiz_answer;
          $ques->save();

          return ($this->ajax_response(false, '', 'سوال با موفقیت ثبت گردید', 'success'));

        } else
          return ($this->ajax_response(true, '', 'سوال قبلا ثبت شده است', 'error'));
      }
    } else
      return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));

  }

  public function delete_quiz_question(Request $request)
  {
    if (Auth::user()->can('delete-course')) {
      $id_course = $request->id_course;
      $id_quess = $request->id_quess;
      $response = [];
      $id_teacher = course::where("id", "=", $id_course)->first()->id_teacher;
      if ($id_teacher == Auth::user()->id_teacher) {
        quiz_question::where("type", "=", "course")->where("id_course", "=", $id_course)->where("id", "=", $id_quess)->delete();

        return ($this->ajax_response(false, '', 'حذف سوال آزمونی انجام شد', 'success'));
      } else
        return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));
    } else
      return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));

  }

  public function get_message(Request $request)
  {

    if (Auth::user()->can('view-course')) {
      $id_course = $request->id_course;
      $response = [];
      $id_teacher = course::where("id", "=", $id_course)->first()->id_teacher;
      if ($id_teacher == Auth::user()->id_teacher) {
        $message = message::where("id", "=", $request->id_mess)->first();

        $message->read_status = 1;
        $message->save();

        return ($this->ajax_response(false, $message, '', 'success'));
      } else
        return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));
    } else
      return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));
  }

  public function reply_message(Request $request)
  {
    if (Auth::user()->can('view-course')) {
      $id_course = $request->id_course;
      $reply_message = $request->reply_message;
      $id_mess = $request->id_mess;
      $response = [];
      $id_teacher = course::where("id", "=", $id_course)->first()->id_teacher;
      if ($id_teacher == Auth::user()->id_teacher) {
        $message = message::where("id", "=", $id_mess)->first();

        $message->replay_message = $reply_message;
        $message->replay_date = nowDate_Shamsi();
        $message->read_status = 1;
        $message->save();

        return ($this->ajax_response(false, '', 'ارسال پاسخ پیام با موفقیت انجام شد', 'success'));
      } else
        return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));
    } else
      return ($this->ajax_response(true, '', 'شما دسترسی به این عملیات را ندارید', 'error'));
  }

  public function send_ticket(Request $request)
  {
    $id_course = $request->id_course;
    $subject = $request->subject;
    $message = $request->message;
    $file = $request->file;

  }


  public function regist_course_suggestion(Request $request)
  {
    if (Auth::check()) {

      $title = $request->title;
      $memo = $request->memo;
      $cat = $request->category;
      $state = $request->state;

      $invite = new course_suggestion();
      $invite->id_user = Auth::user()->id;
      $invite->title = $title;
      $invite->memo = $memo;
      $invite->category = $cat;
      $invite->id_state = $state;
      $invite->regist_date = nowDate_Shamsi();
      $invite->read_status = 0;
      $invite->reply_message = '';
      $invite->save();

      return ($this->ajax_response(false, '', 'باتشکر. پیشنهاد شما ثبت گردید', 'success'));
    } else
      return ($this->ajax_response(true, '', 'برای ثبت پیشنهاد ابتدا وارد سایت شوید', 'error'));
  }

  public function certificates()
  {
    return view("course.certificates");
  }

  public function faq()
  {
    $faqs = faq::where("type", "=", "course")->get();
    return view("course.faq", compact("faqs"));
  }

  public function yalda(){



    $courses = course::where('status', '=', 1)->with(array('category' => function ($query) {
      $query->select('id', 'title');
    }))->with(array('teacher' => function ($query) {
      $query->select('id', 'fullname');
    }))
      ->select('id', 'title', 'image', 'price', 'abstractMemo','hour', 'minutes', 'video_minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'view_count')
      ->get()
      ->sortByDesc('id');

    $courses_count = $courses->count();

    $webinars = webinar::where("status", "=", 1)->where("type", "<", 3)
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->get()
      ->sortBy('webinar_date');

    $webinar_count = $webinars->count();

    $consults = webinar::where("type", "=", 3)
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->get()
      ->sortBy('webinar_date');

    $consult_count = $consults->count();

    $student_count = classroom::where('regist_date','>','1400/09/18')->count();
    $student_count_weinar = webinar_register::where('register_date','>','1400/09/18')->count();

    $student_count = $student_count + $student_count_weinar;

    $skill_count=$courses_count+$webinar_count+$consult_count;


    $comments = comment::where("type", "=", "course")
      ->where("status", "=", 1)
      ->where("comment", "<>", '')
      ->with(array('user' => function ($queryuser) {
        $queryuser->select('id', 'name', 'code', 'image');
      }))
      ->select('id', 'id_target', 'id_user', 'score', 'regist_date', 'comment')
      ->latest()
      ->take(10)
      ->get();

    $nowdate_shamsi = nowDate_Shamsi();
    return view("yalda",compact('courses','webinars','consults','student_count','skill_count','comments','nowdate_shamsi'));
  }


  public function ramezan(){



    $webinars = webinar::where("type", "=", 3)
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->get()
      ->sortBy('webinar_date');

    $webinar_count = $webinars->count();

    $student_count = webinar_register::where('register_date','>','1401/01/18')->count();

    $comments = comment::where("type", "=", "course")
      ->where("status", "=", 1)
      ->where("comment", "<>", '')
      ->with(array('user' => function ($queryuser) {
        $queryuser->select('id', 'name', 'code', 'image');
      }))
      ->select('id', 'id_target', 'id_user', 'score', 'regist_date', 'comment')
      ->latest()
      ->take(10)
      ->get();

    $courses_query = course::where('status', '=', 1)->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))->with(array('teacher' => function ($query) {
        $query->select('id', 'fullname');
      }))
        ->select('id', 'title', 'slug', 'image', 'price', 'hour', 'minutes', 'video_minutes', 'id_category', 'cloud_url', 'cloud_json_url', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'abstractMemo', 'view_count');

    $courses_video = $courses_query->whereNotNull('cloud_url')->limit(8)->get()->sortByDesc('id');


    $nowdate_shamsi = nowDate_Shamsi();
    return view("ramezan",compact('webinars','student_count','comments','nowdate_shamsi','courses_video'));
  }

  public function fatherDay()
  {


    $courses = course::where('status', '=', 1)->where("type","course")
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->with(array('teacher' => function ($query) {
        $query->select('id', 'fullname');
      }))
      ->select('id', 'title', 'image', 'price', 'abstractMemo', 'hour', 'minutes', 'video_minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'view_count')
      ->get()
      ->sortByDesc('id');

    $dblcourses = course::where('status', '=', 1)->where("type","duble")
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->with(array('teacher' => function ($query) {
        $query->select('id', 'fullname');
      }))
      ->select('id', 'title', 'image', 'price', 'abstractMemo', 'hour', 'minutes', 'video_minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'view_count')
      ->get()
      ->sortByDesc('id');

    $webinars = webinar::where("status", "=", 1)->where("have_video", 0)
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->get()
      ->sortBy('webinar_date');

    $nowdate_shamsi = nowDate_Shamsi();

    $comments = comment::where("type", "=", "course")
      ->where("status", 1)
      ->where("comment", "<>", '')
      ->with(array('user' => function ($queryuser) {
        $queryuser->select('id', 'name', 'code', 'image');
      }))
      ->select('id', 'id_target', 'id_user', 'score', 'regist_date', 'comment')
      ->latest()
      ->take(20)
      ->get();

    return view("fatherDay", compact('courses', 'webinars',  'comments', 'nowdate_shamsi','dblcourses'));
  }

 public function ramezan1403()
  {


    $courses = course::where('status', '=', 1)->where("type","course")
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->with(array('teacher' => function ($query) {
        $query->select('id', 'fullname');
      }))
      ->select('id', 'title', 'image', 'price', 'abstractMemo', 'hour', 'minutes', 'video_minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'view_count')
      ->get()
      ->sortByDesc('id');

    $dblcourses = course::where('status', '=', 1)->where("type","duble")
      ->with(array('category' => function ($query) {
        $query->select('id', 'title');
      }))
      ->with(array('teacher' => function ($query) {
        $query->select('id', 'fullname');
      }))
      ->select('id', 'title', 'image', 'price', 'abstractMemo', 'hour', 'minutes', 'video_minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'score', 'discount', 'old_price', 'img_slider', 'img_slider_mobile', 'img_mini_banner', 'have_certificate', 'view_count')
      ->get()
      ->sortByDesc('id');

    $nowdate_shamsi = nowDate_Shamsi();

    $comments = comment::where("type", "=", "course")
      ->where("status", 1)
      ->where("comment", "<>", '')
      ->with(array('user' => function ($queryuser) {
        $queryuser->select('id', 'name', 'code', 'image');
      }))
      ->select('id', 'id_target', 'id_user', 'score', 'regist_date', 'comment')
      ->latest()
      ->take(20)
      ->get();

    return view("ramezan_new", compact('courses',  'comments', 'nowdate_shamsi','dblcourses'));
  }

}
