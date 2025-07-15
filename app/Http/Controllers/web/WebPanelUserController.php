<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonAttach;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Notify;
use App\Models\Payment;
use App\Models\UserLesson;
use App\Models\Webinar;
use App\Models\WebinarRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\CalendarUtils;

class WebPanelUserController extends Controller
{
    public function dashboard()
    {
        $courseCount = null;
        $messageCount = null;
        $blogCount = null;
        $wallet = null;
        $notifications = null;
        $webinars = null;
        $courses = null;
        $subsid = null;
        $user = null;

        if (Auth::check()){
            $user = auth()->user();
            $courseCount = Classroom::where("id_user", $user->id)->count();
            $messageCount = Message::where("type", "user")->where("id_target", $user->id)->count();
            $blogCount = Message::where("type", "blog")->where("id_target", $user->id)->count();
            $notifications = Notification::where('status', 1)->latest('sort')->limit(5)->get();

            $webinars = Webinar::where([['type', '=', 3]])
                ->latest()->limit(30)->select('id', 'title', 'price')->get();

            $courses = Course::where('status', 1)->select('id', 'title', 'price')->latest()->get();

            $courseCount = Classroom::where("id_user", $user->id)->count();

            $certificationsCount = Classroom::where("id_user", $user->id)->where('certificate_status', 'صدور مدرک')->count();

            $subsid = $user->subsid;
            $wallet = $user->wallet;
        }

        return view('web/dashboard', compact('courseCount', 'certificationsCount', 'messageCount', 'blogCount', 'wallet', 'notifications', 'webinars', 'courses', 'subsid', 'user'));
//        return view('web/dashboard', compact('courseCount', 'messageCount', 'blogCount', 'wallet', 'notifications', 'webinars', 'courses', 'subsid', 'vendor', 'course', 'products', 'cities', 'notify', 'user'));
    }

    public function myCourses()
    {
        $limit = 10;
        $search = arToFa(request()->search);
        $order_by = request()->order_by;
        $userId = auth()->user()->id;

        $allowedColumns = ['view_count', 'created_at'];

        $query = Classroom::where('id_user', $userId)
            ->select('id', 'id_course', 'id_user', 'result', 'regist_date')
            ->with('course');

        if ($search) {
            $query->whereHas('course', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        }

        if ($order_by && in_array($order_by, $allowedColumns)) {
            $query->orderByDesc(
                course::select($order_by)
                    ->whereColumn('skill_courses.id', 'skill_class_room.id_course')
                    ->take(1)
            );
        } else {
            $query->orderByDesc('regist_date');
        }

        $courses = $query->paginate($limit);

        return view('web.courses', compact('courses'));
    }

    public function myWebinars()
    {
        $limit = 10;
        $search = arToFa(request()->search);
        $query = WebinarRegister::where("id_user", auth()->user()->id)->with('webinar');
        if ($search)
            $query->whereHas('webinar', function($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });

        $webinars = $query->paginate($limit);

        return view('web.webinars', compact('webinars'));
    }

    public function getCertificate()
    {
        $limit = 10;
        $search = arToFa(request()->search);
        $type = request()->type;

        if (!$type){
            $type = 'دوره';
        }

        if ($type === 'دوره') {
            $query = Classroom::where([
                ['id_user', auth()->user()->id],
                ['take_quiz', 1],
                ['certificate_status', 'صدور مدرک']
            ])->with('course');
            if ($search)
                $query->whereHas('course', function($q) use ($search) {
                    $q->where('title', 'like', "%$search%");
                });
        } elseif ($type === 'وبینار') {
            $query = WebinarRegister::where([
                ['id_user', auth()->user()->id],
                ['presence', 1],
                ['status', 1]
            ])->with('webinar');
            if ($search)
                $query->whereHas('webinar', function($q) use ($search) {
                    $q->where('title', 'like', "%$search%");
                });
        }

       $certificates = $query->paginate($limit);

        return view('web.certificates', compact('certificates', 'type'));
    }

    public function payments()
    {
        $limit = 10;
        $search = arToFa(request()->search);
//        $order_by = request()->order_by;
//        $allowedColumns = ['view_count', 'created_at'];

        $query = Payment::where([["id_user", auth()->user()->id],["status", 1]]);
        if ($search)
            $query->where(function($q) use ($search) {
                $q->where('factor_id', $search)
                    ->orWhere('refID', $search)
                    ->orWhere('payment_for', 'like', "%$search%");
            });

//        if ($order_by && in_array($order_by, $allowedColumns)) {
//            $query->orderByDesc($order_by);
//        } else {
//            $query->latest();
//        }

        $payments = $query->paginate($limit);

        return view('web.transactions', compact('payments'));
    }

    public function paymentsDetails($transactionId)
    {
        $transaction = Payment::where([
            ['id_user', auth()->user()->id],['status', 1], ['id', $transactionId]
        ])->firstOrFail();

        return view('web.transaction-detail', compact('transaction'));
    }

    public function transactionRef()
    {
        $limit = 10;
        $search = request()->search;
        $query = Payment::where([['referral_user', auth()->user()->id],['status', 1]])
            ->with('user:id,name')
            ->select(
                'referral_price', 'referral_user', 'status', 'id_user',
                'factor_id', 'payment_for', 'product_course_title', 'regist_date', 'refID'
            );

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('factor_id', 'LIKE' , "%$search%");
            });
        }

        $transactions = $query->paginate($limit);

        $data = Payment::where([['referral_user', auth()->user()->id], ['status', 1]])
            ->select(DB::raw("SUM(referral_price) as refPrice"), DB::raw("count(*) as refCount"))
            ->get();

        $refCount = $data[0]['refCount'];
        $refPrice = $data[0]['refPrice'];

        return view('web.transaction-ref', compact('transactions', 'refCount', 'refPrice'));
    }

    public function CourseDetail($courseId){
        $course = Course::findOrFail($courseId);

        $query = Classroom::where([['id_user', auth()->user()->id], ['id_course', $courseId]]);
        if ($course->price >= 0) {
            $query->with(['course' => function ($q) {
                $q->with([
                    'lessons' => function ($q) {
                        $q->select('id', 'lesson_number', 'id_course', 'title', 'cloud_url', 'poster_url',
                            'cloud_json_url','cloud_mp4_url', 'hour', 'minutes', 'video', 'size', 'memo', 'isFree', 'status',
                            'created_at', 'updated_at')
                            ->oldest('season')
                            ->orderby('lesson_number')
                            ->with(['lesson_attachments', 'note' => function ($q) {
                                $q->where('id_user', auth()->user()->id);
                            }]);
                    },
                    'complete' => function ($q) {
                        $q->where('id_user', auth()->user()->id);
                    }
                ]);
            }]);
        } else {
            $query->with(['course' => function ($q) {
                $q->with([
                    'lessons' => function ($q) {
                        $q->oldest('lesson_number')
                            ->with(['lesson_attachments', 'note' => function ($q) {
                                $q->where('id_user', auth()->user()->id);
                            }]);

                    },
                    'complete' => function ($q) {
                        $q->where('id_user', auth()->user()->id);
                    }]);
            }]);
        }

        $object = $query->firstOrFail();

        $attachs = LessonAttach::where([['id_course', $courseId], ['id_lesson', 0]])
            ->orderBy('category', 'asc')->get();

        $attachDic = [];
        foreach ($attachs as $attach)
            $attachDic[$attach->category][] = $attach;

        dd($attachs);

        $notes = [];
        foreach ($object?->course?->lessons as $lesson){
            $temp_arr = $lesson->note?->all();
            if ($temp_arr){
                $notes = array_merge($notes, $temp_arr);
            }
        }

        return view('web.course-detail', compact('object', 'course', 'attachDic', 'notes'));
    }

    public function completeLesson()
    {
        $idCourse = request()->idCourse;
        $userId = auth()->user()->id;
        $classroom = Classroom::where([['id_course', $idCourse], ['id_user', $userId]])->first();
        if(!$classroom)
            return ['success' => false, 'message' => 'دوره ای یافت نشد'];

        $idLesson = request()->idLesson;
        $nowdateshamsi = nowDateShamsi();
        UserLesson::updateOrInsert([
            'id_user' => $userId,
            'id_course' => $idCourse,
            'id_lesson' => $idLesson,
            'regist_date' => $nowdateshamsi,
            'status' => 1
        ]);

        $user_lessons = UserLesson::where([['id_user', $userId], ['id_course', $idCourse]])
            ->select('id', 'id_lesson')
            ->get()
            ->toArray();

        $course_lessons = Lesson::where('id_course', $idCourse)
            ->select('id', 'lesson_number')
            ->get()
            ->toArray();

        $array1 = [];
        $array2 = [];

        foreach ($user_lessons as $user_lesson)
            array_push($array1, $user_lesson['id_lesson']);
        foreach ($course_lessons as $course_lesson)
            array_push($array2, $course_lesson['id']);

        $result = 'learning';
        if (array_diff($array2, $array1) === []) {
            classroom::where([['id_user', $userId], ['id_course', $idCourse]])
                ->update(['result' => "finish"]);
            $result = 'finish';
        }

        $userLesson = UserLesson::where([['id_user', $userId], ['id_course', $idCourse]])->get();
        return ['success' => true, 'message' => 'تکمیل درس دوره آموزشی انجام شد', 'data' => $userLesson, 'result' => $result];
    }
}
