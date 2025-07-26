<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Bug;
use App\Models\Category;
use App\Models\City;
use App\Models\Classroom;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Invite;
use App\Models\KasboomCoupon;
use App\Models\Lesson;
use App\Models\LessonAttach;
use App\Models\Message;
use App\Models\Note;
use App\Models\Notification;
use App\Models\Notify;
use App\Models\Payment;
use App\Models\QuizQuestion;
use App\Models\Sms;
use App\Models\State;
use App\Models\Survey;
use App\Models\SurveyField;
use App\Models\UserFavorite;
use App\Models\UserLesson;
use App\Models\UserQuiz;
use App\Models\Webinar;
use App\Models\WebinarRegister;
use App\Models\Wikiidea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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

        $attachs = LessonAttach::where([['id_course', $courseId]])
            ->orderBy('category', 'asc')->get();

        $attachDic = [];
        foreach ($attachs as $attach)
            $attachDic[$attach->category][] = $attach;

        $notes = [];
        foreach ($object?->course?->lessons as $lesson){
            $temp_arr = $lesson->note?->all();
            if ($temp_arr){
                $notes = array_merge($notes, $temp_arr);
            }
        }

        $survey = SurveyField::where('type', 'course')->get();
        $surveyId = [];
        foreach ($survey as $row) {
            array_push($surveyId, $row->id);
        }
        $surveyMy = Survey::where([
            ['id_user', auth()->user()->id],
            ['id_target', $courseId]
        ])->whereIn('survey_field_id', $surveyId)->get();

        return view('web.course-detail', compact('object', 'course', 'attachDic', 'notes', 'surveyMy', 'surveyId'));
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

    //    bugs
    public function bugStore() {
        $validator = Validator::make(request()->all(), [
            'feddbackGroup' => 'required|max:30',
            'feddbacktype' => 'required|in:course,skill,consult,shop,blog,landuse,idea,lesson',
            'feddbackContent' => 'required|max:500'
        ]);
        if($validator->fails())
            return ['success' => false,'message' => $validator->errors()->first()];

        $type = request()->feddbacktype;
        $targetId = request()->targetId;
        $userId = auth()->user()->id;

        if ($type === 'course' || $type === 'lesson') {
            if ($type === 'course') {
                $cours = Course::find(request()->targetId);
                if(!$cours) return ['success' => false,'message' => 'متاسفانه دوره ای یافت نشد'];
                $courseId = request()->targetId;
            }
            else if ($type === 'lesson') {
                $lesson = Lesson::find(request()->targetId);
                if(!$lesson) return ['success' => false,'message' => 'متاسفانه کلاسی یافت نشد'];
                $courseId = $lesson->id_course;
            }

            $classroom = Classroom::where([['id_course', $courseId], ['id_user', $userId]])->first();
            if (!$classroom)
                return ['success' => false,'message' => 'شما عضو این دوره نیستید'];
        }

        $store = new Bug;
        $store->id_user = $userId;
        $store->type = $type;
        $store->id_target = $targetId;
        $store->subject = request()->feddbackGroup;
        $store->memo = request()->feddbackContent;
        $store->save();

        return ['success' => true,'message' => 'گزارش شما با موفقیت ثبت شد . از گزارشتان متشکریم :)'];
    }

    //    notes
    public function storeCourseNote(){
        $validator = Validator::make(request()->all(), [
            'questionSubject' => 'required|max:300',
            'noteMessage' => 'required'
        ]);
        if($validator->fails())
            return ['success' => false,'message' => $validator->errors()->first()];

        $userId = auth()->user()->id;
        $idCourse = request()->idCourse;
        $idLesson = request()->idLesson;

        $classroom = Classroom::where([['id_user', $userId], ['id_course', $idCourse]])->first();
        if(!$classroom)
            return ['success' => false,'message' => 'شما در این دوره ثبت نام نکرده اید'];

        $lesson = Lesson::where([['id', $idLesson], ['id_course', $idCourse]])->first();
        if(!$lesson)
            return ['success' => false,'message' => 'درس مورد نظر یافت نشد'];

        if (request()->id > 0) {
            $note = Note::where([
                ['id', request()->id],
                ['id_course', $idCourse],
                ['id_lesson', $idLesson],
                ['id_user', $userId]
            ])->first();
            if (!$note)
                return ['success' => false, 'message' => 'یادداشتی جهت ویرایش یافت نشد'];
        }
        else {
            $note = new Note;
            $note->id_course = $idCourse;
            $note->id_lesson = $idLesson;
            $note->id_user = $userId;
        }
        $note->note_title = request()->questionSubject;
        $note->note = request()->noteMessage;
        $note->save();

        $notes = Note::where([['id_course', $idCourse], ['id_lesson', $idLesson], ['id_user', $userId]])
            ->get();
        return ['success' => true, 'message' => 'ثبت یادداشت انجام شد', 'data' => $notes];
    }

    public function deleteCourseNote(){
        $userId = auth()->user()->id;
        $idCourse = request()->idCourse;
        $idLesson = request()->idLesson;

        Note::where([
            ['id', request()->id],
            ['id_course', $idCourse],
            ['id_lesson', $idLesson],
            ['id_user', $userId]
        ])->delete();

        $notes = Note::where([
            ['id_course', $idCourse],
            ['id_lesson', $idLesson],
            ['id_user', $userId]
        ])->get();

        return ['success' => true, 'message' => 'یادداشت با موفقیت حذف شد', 'data' => $notes];
    }

    // survey
    public function CourseSurvey($courseId){
        Classroom::where([
            ['id_user', auth()->user()->id], ['id_course', $courseId]
        ])->firstOrFail();

        $survey = SurveyField::where('type', 'course')->get();
        $surveyId = [];
        foreach ($survey as $row) {
            array_push($surveyId, $row->id);
        }

        return view('web.course-survey', compact('survey', 'courseId'));
    }

    public function CourseSurveyStore(Request $request, $courseId){
        $request->validate([
            'ratings' => 'required|array', // اطمینان از وجود آرایه ratings
            'ratings.*' => 'integer|min:1|max:5', // هر امتیاز باید بین 1 تا 5 باشد
            'message' => 'required|string|max:1000', // متن نظرات اجباری و حداکثر 1000 کاراکتر
        ]);

        $userId = auth()->user()->id;

        Classroom::where([['id_user', $userId], ['id_course', $courseId]])->firstOrFail();

        $survey = SurveyField::where('type', 'course')->get();
        $surveyId = [];
        foreach ($survey as $row) {
            array_push($surveyId, $row->id);
        }

//        $datas = json_decode(request()->datas,true);
        $ratings = $request->input('ratings');
        $surveyMy = [];
        $storeSurveyMy = [];

        foreach ($ratings as $itemId => $rating) {
            array_push($surveyMy, $itemId);
//            if ($rating === 0)
//                $datas[$index]['score'] = 1;

            array_push($storeSurveyMy, [
                'id_user' => $userId,
                'id_target' => $courseId,
                'survey_field_id' => $itemId,
                'score' => $rating
            ]);
        }

        if (count(array_diff($surveyId, $surveyMy)) !== 0 || count(array_diff($surveyMy, $surveyId)) !== 0)
            return back()->with('survey_submit_error', 'خطایی هنگام ارسال نظر سنجی رخ داده , لطفا صفحه را رفرش کرده و دوباره در نظر سنجی شرکت کنید');

        Survey::where([['id_user', $userId], ['id_target', $courseId]])->delete();
        DB::table('kasboom_survey')->insert($storeSurveyMy);

        $comment = Comment::where([
            ['id_user', $userId],
            ['id_target', $courseId],
            ['type', 'course']
        ])->first();

        if (!$comment){
            $comment = new Comment;
            $comment->id_user = $userId;
            $comment->id_target = $courseId;
            $comment->type = 'course';
        }
        $comment->regist_date = nowDateShamsi();
        $comment->comment = request()->message;
        $comment->status = 1;
        $comment->read_status = 1;
        $comment->save();

        $fields = SurveyField::where('type','course')->pluck('id')->toArray();
        $surveys = Survey::where('id_target', $courseId)
            ->whereIn('survey_field_id', $fields)->get();

        $surveyCount = $surveys->count();
        $surveySum = $surveys->sum('score');
        $score = $surveySum / $surveyCount;
        $allScore = substr($score, 0, 3);

        $course = Course::find($courseId);
        $course->score = $allScore;
        $course->save();

        session()->flash('survey_store_success_message', 'نظر سنجی با موفقیت ثبت شد');
        return redirect(route('web.my-course-detail', $courseId));
    }

    // quiz

    public function CourseQuiz($courseId){
        $nowDate = date("Y-m-d");
        $nowdateshamsi = nowDateShamsi();
        $userId = auth()->user()->id;
        $classroom = Classroom::where([['id_user', $userId], ['id_course', $courseId]])->firstOrFail();

        $survey = Survey::where([['id_user', $userId], ['id_target', $courseId]])->first();
        if (!$survey)
            return back()->with('quiz_errors', 'کاربر عزیز لطفا در نظر سنجی شرکت کنید , سپس در آزمون شرکت کنید');

        $course = Course::where('id', $courseId)->first();
        if ((int)$course->have_certificate === 0)
            return back()->with('quiz_errors', 'این دوره آزمون آنلاین ندارد و  گواهینامه ای برای این دوره صادر نمی شود');

        if($classroom->result !== 'finish') {
            if($classroom->result === 'learning')
                return back()->with('quiz_errors', 'برای شرکت در آزمون حتما باید تمامی درس های دوره ی آموزشی را مشاهده نمائید');
            elseif($classroom->result === 'certificate')
                return back()->with('quiz_errors', 'قبلا در آزمون این دوره شرکت کرده اید و گواهی پایان دوره برا شما صادر شده است');
        }

        $last_date_take_quize_miladi = $classroom->last_date_take_quize_miladi;
        if ($last_date_take_quize_miladi === null) {
            $quiz = QuizQuestion::where('id_course', $courseId)->inRandomOrder()->take(20)->get();
            $course = Course::where('id', $courseId)->select('id', 'code', 'title')->first();
            $classroom->last_date_take_quize = $nowdateshamsi;
            $classroom->last_date_take_quize_miladi = $nowDate;
            $classroom->take_quiz = 1;
            $classroom->answer_status = 0;
            $classroom->save();

            return view('web.course-quiz', compact('course', 'quiz'));
        }
        else {
            $now = time();
            $your_date = strtotime($last_date_take_quize_miladi);
            $datediff = $now - $your_date;
            $diff_days = (int) (abs((int)round($datediff / (60 * 60 * 24))));
            if ($diff_days >= 3) {
                $quiz = QuizQuestion::where('id_course', $courseId)->inRandomOrder()->take(20)->get();
                $course = Course::where('id', $courseId)->select('id', 'code', 'title')->first();
                $classroom->last_date_take_quize = $nowdateshamsi;
                $classroom->last_date_take_quize_miladi = $nowDate;
                $classroom->take_quiz = 1;
                $classroom->answer_status = 0;
                $classroom->save();

                return view('web.course-quiz', compact('course', 'quiz'));
            }
            else {
                $message = "شما بعد از " . ( 3 - $diff_days ) . " روز می توانید مجددا در آزمون شرکت کنید ";
                return back()->with('quiz_errors', $message);
            }
        }
    }

    public function correctionQuiz(){
        request()->validate([
            'courseId' => 'required|integer',
            'answer' => 'required|array',
            'answer.*.id' => 'required|integer|exists:quiz_questions,id',
            'answer.*.value' => 'required|in:1,2,3,4',
        ]);

        $nowDate = date("Y-m-d");
        $nowdateshamsi = nowDateShamsi();
        $id_course = request()->courseId;
        $user = auth()->user();
        $classroom = Classroom::where([['id_user', $user->id], ['id_course', $id_course]])->firstOrFail();

        if ($classroom->certificate_status === 'صدور مدرک')
            return redirect(route('web.my-course-detail', $id_course))->with('quiz_errors', 'شما قبلا در آزمون این دوره شرکت کرده اید و گواهی پایان دوره نیز برای شما ارسال شده است');

        if ($classroom->result !== 'finish')
            return redirect(route('web.my-course-detail', $id_course))->with('quiz_errors', 'ابتدا دروس دوره را به پایان برسانید سپس در آزمون شرکت کنید');

        $answer = request()->answer;
        $answerCount = count($answer) === 0 ? 20 : count($answer);
        $validTime = (($answerCount * 60) + 60) + strtotime($classroom->updated_at);

        if($classroom->answer_status === 1 || ($classroom->answer_status === 0 && $validTime < time())){
            $classroom->answer_status = 1;
            $classroom->save();
            return redirect(route('web.my-course-detail', $id_course))->with('quiz_errors', 'زمان آزمون تمام شد . شما نمی توانید در آزمون شرکت کنید');
        }

        $cnt_quest = 20;
        $cnt_true_answer = 0;
        UserQuiz::where([['id_course', $id_course], ['id_user', $user->id]])->delete();
        foreach ($answer as $row) {
            if(!$row['value'])
                continue;
            $ques_user_answer = (int) $row['value'];
            $ques = QuizQuestion::where('id', $row['id'])->select('id', 'question', 'answer')->first();
            if ($ques_user_answer == (int)$ques->answer) {
                $this->addUserQuesResult($user->id, $id_course, $row['id'], $ques_user_answer, 1);
                $cnt_true_answer = $cnt_true_answer + 1;
            } else
                $this->addUserQuesResult($user->id, $id_course, $row['id'], $ques_user_answer, 0);
        }

        if ($cnt_quest > 0) $score = ($cnt_true_answer / $cnt_quest) * 100;
        else $score = 0;
        $score = (int)round($score);

        if ($score < 70) $quiz_result = 0;
        else {
            $quiz_result = 1;
            $classroom->certificate_status = "صدور مدرک";
        }

        $classroom->last_date_take_quize_miladi = $nowDate;
        $classroom->last_date_take_quize = $nowdateshamsi;
        $classroom->take_quiz = 1;
        $classroom->answer_status = 1;
        $classroom->quiz_score = $score;
        $classroom->quiz_result = $quiz_result;
        $classroom->save();

        $course = Course::where('id', $id_course)->select('id', 'code', 'title')->first();
        $userQuizs = UserQuiz::where([['id_user', $user->id], ['id_course', $id_course]])
            ->with(array('questions' => function ($query) {
                $query->select('id', 'question');
            }))->get();

        $text = $user->name . " ارجمند " . "\n"."امتیاز کسب شده شما در آزمون دوره ( " . $course->title ." ) ". $score ." از 100 می باشد. "."\n"."تاریخ آزمون: ". $nowdateshamsi ."\n\n". "سامانه کسب بوم"."\n"."kasboom.ir";
        Sms::send($user->phonenumber, $text);

        session()->flash('quiz_correction_success_message', 'آزمون شما با موفقیت ثبت شد');
        return redirect(route('web.my-course-detail', $id_course));
    }

    function addUserQuesResult($id_user, $id_course, $id_ques, $user_answer, $answer){
        UserQuiz::updateOrInsert([
            'id_user' => $id_user,
            'id_course' => $id_course,
            'id_quize_questions' => $id_ques,
            'user_answer' => $user_answer,
            'answer' => $answer
        ]);
    }

    //    discount - new version kasboom-coupon
    public function discounts () {
        $search = arToFa(request()->search);

        $query = KasboomCoupon::where([['status', 1], ['end_date', '>=', jdate()->format('Y/m/d')]])
            ->where(function ($q) {
                $q->whereJsonContains('users', auth()->user()->id)
                    ->orWhereNull('users');
            });

        if ($search)
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });

        if (\request('status') == 'new'){
            $query = $query->where('status', 0);
        }
        elseif (\request('status') == 'expired'){
            $query = $query->where('status', 1);
        }

        $discounts = $query->paginate(8);

        return view('web.discount', compact('discounts'));
    }

    public function wishlist()
    {
        $limit = 10;
        $search = arToFa(request()->search);
        $query = UserFavorite::where("id_user", auth()->user()->id);
        if ($search)
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });

        $type = request()->type ?: 'product';
        if ($type)
            $query->where('type', $type);

        $wishlists = $query->with(['product', 'webinar', 'idea', 'course'])->paginate($limit);

        return view('web.wishlist', compact('wishlists'));
    }

    public function wikiList(){
        $allowedColumns = ['view_count', 'created_at', 'total_score'];

        $limit = 10;
        $search = arToFa(request()->search);
        $order_by = request()->order_by;

        $query = Wikiidea::where('id_user', auth()->user()->id)->with('category:id,title');
        if ($search)
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('abstractMemo', 'like', "%$search%");
            });

        if ($order_by && in_array($order_by, $allowedColumns)) {
            $query = $query->orderByDesc($order_by);
        } else {
            $query = $query->orderByDesc('created_at');
        }

        $ideas = $query->paginate($limit);

        return view('web.ideas', compact('ideas'));
    }

    public function wikiCreate(){
        $cats = Category::where([
            ['status', 1],
            ['type', 'idea'],
            ['count', '>', 0]
        ])->select('id', 'title')->get();

        $states = getState();
        $id = request()->id;

        return view('web.ideas-form', compact('cats', 'states'));
    }

    public function wikiStore()
    {
        if (auth()->user()->can('create-wiki'))
            return back()->with('error', 'چیزی یافت نشد');

        $data = request()->all();
        Validator::validate($data, [
            'title' => 'required|max:100',
            'minimal_fund' => 'required|max:100',
            'risk' => 'required|in:خیلی زیاد,زیاد,پایین,متوسط',
            'profitability' => 'required|in:بلند مدت,میان مدت,کوتاه مدت',
            'ispublish' => 'required|in:1,0',
            'profitability_memo' => 'required|max:100',
            'manpower' => 'required|max:30',
            'scale' => 'required|max:50',
            'abstractMemo' => 'required|max:50',
            'memo' => 'required',
            'id_category' => 'required|exists:categories,id',
            'id_state' => 'required|exists:kasboom_state,id',
        ]);

       Category::where([
            ['status', 1],
            ['type', 'idea'],
            ['id', $data['id_category']],
            ['count', '>', 0]
        ])->firstOrFail();

        $user = auth()->user();
        $id = request()->id;
        if ($id > 0) {
            $idea = Wikiidea::where([
                ['id_user', $user->id],
                ['id', $id]
            ])->firstOrFail();

            $code = $idea->code;
        }
        else {
            $code = generateIdeaCode();
            $idea = new Wikiidea;
            $idea->code = $code;
            $idea->id_user = $user->id;
            $idea->publisher_name = $user->name;
            $idea->registe_date = nowDateShamsi();
            $idea->like_count = 0;
            $idea->view_count = 0;
        }

        if (request()->file('ideaImage')) {
            Validator::validate(request()->file(), [
                'ideaImage' => 'mimes:jpg,jpeg,png|max:5000'
            ]);

            if (checkValidIP(request()->header('x-forwarded-for'))) {
                $slash = DIRECTORY_SEPARATOR;
//                $folderPath = '.'.$slash.'..'.$slash.'..'.$slash.'_upload_'.$slash.'_wikiideas_'.$slash.$code;
                $folderPath = '_upload_'.$slash.'_wikiideas_'.$slash.$code;
                if($id > 0 && $idea->image) {
                    File::delete($folderPath . $slash . $idea->image);
                    File::delete($folderPath . $slash . 'medium_' . $idea->image);
                    File::delete($folderPath . $slash . 'small_' . $idea->image);
                }
                $idea->image = uploadImageFile(request()->file('ideaImage'), $folderPath);
            } else
                return ['message' => 'دسترسی غیر مجاز از شبکه', 'success' => false];
        }

        $idea->title = arToFa($data['title']);
        $idea->id_category = $data['id_category'];
        $idea->minimal_fund = $data['minimal_fund'];
        $idea->risk = $data['risk'];
        $idea->profitability = $data['profitability'];
        $idea->profitability_memo = $data['profitability_memo'];
        $idea->manpower = $data['manpower'];
        $idea->scale = $data['scale'];
        $idea->memo = arToFa($data['memo']);
        $idea->abstractMemo = arToFa($data['abstractMemo']);
        $idea->id_state = $data['id_state'];
        $idea->status = 0;
        $idea->ispublish = $data['ispublish'];
        $idea->save();

        $cat = Category::where([['type', 'idea'], ['id', $data['id_category']]])->first();
        $cat->increment('count');

        return redirect(route('web.my-ideas'))->with('idea_submit_success', 'ثبت ایده با موفقیت انجام شد , پس از تایید مدیر انتشار خواهد یافت');
    }

    public function wikiEdit($id){
        $object = Wikiidea::where([['id_user', auth()->user()->id], ['id', $id]])
            ->with('category:id,title')->firstOrFail();

        $cats = Category::where([
            ['status', 1],
            ['type', 'idea'],
            ['count', '>', 0]
        ])->select('id', 'title')->get();

        $states = getState();

        return view('web.ideas-form', compact('object', 'cats', 'states'));
    }

    public function wikiDelete($id) {
        $wiki = Wikiidea::where([['id', $id], ['id_user', auth()->user()->id]])->firstOrFail();

        $slash = DIRECTORY_SEPARATOR;
        $folderPath = '_upload_'.$slash.'_wikiideas_'.$slash.$wiki->code;

        deleteDirectory($folderPath);
        $wiki->delete();

        return redirect(route('web.my-ideas'))->with('idea_submit_success', 'ایده با موفقیت حذف شد');
    }

    //

    public function InviteTeacher(){
        $states = getState();

        return view('web.invite-teacher-form', compact('states'));
    }

    public function storeInviteTeacher () {

        $data = request()->all();
        Validator::validate($data, [
            'fullname' => 'required|max:50',
            'tel' => 'required|max:15',
            'phonenumber' => 'required|max:15',
            'madrak' => 'required|in:دانشجوی کارشناسی,فارغ‌ التحصیل کارشناسی,دانشجوی کارشناسی ارشد,فارغ‌ التحصیل کارشناسی ارشد,دانشجوی دکترا,فارغ‌ التحصیل دکترا,فارغ‌ التحصیل کاردانی,دانشجوی کاردانی,دیپلم',
            'reshte' => 'required|max:100',
            'daneshgah' => 'required|max:100',
            'birthdate' => 'required|date',
            'company_name_1' => 'max:200',
            'company_name_2' => 'max:200',
            'company_type_work_1' => 'max:200',
            'company_type_work_2' => 'max:200',
            'history_title_1' => 'max:200',
            'history_title_2' => 'max:200',
            'history_link_1' => 'max:200',
            'history_link_2' => 'max:200',
            'memo' => 'required|max:500',
            'id_state' => 'required|exists:kasboom_state,id',
            'id_city' => 'required|exists:kasboom_city,id',
            'history_type_1' => 'required|in:نوشته آنلاین,کتاب فارسی,مقاله انگلیسی,مقاله فارسی,آموزش ویدئویی',
            'history_type_2' => 'required|in:نوشته آنلاین,کتاب فارسی,مقاله انگلیسی,مقاله فارسی,آموزش ویدئویی',
        ]);

//        if (
//            (!isset($data['id_cat_mega_1']) && !isset($data['id_cat_mega_2'])) ||
//            (!isset($data['id_cat_middle_1']) && !isset($data['id_cat_middle_2'])) ||
//            (!isset($data['id_cat_sub_1']) && !isset($data['id_cat_sub_2']))
//        ){
//            throw ValidationException::withMessages(['category_error' => 'حتما یک مرحله از بخش تخصص را کامل پر کنید']);
//        }

        $code = generateIdeaCode();
        $slash = DIRECTORY_SEPARATOR;
        $folderPath = '_upload_'.$slash.'_inviteTeacher_'.$slash.$code;
        $invite = new Invite;

//        image resum
        if (request()->file('inviteImage')) {
            Validator::validate(request()->all(), ['inviteImage' => 'max:5000|mimes:jpg,jpeg,png']);
            $invite->attach_rezoume = uploadImageOneFile(request()->file('inviteImage'), $folderPath);
        }

//        film
        if (request()->file('inviteFile')) {
            Validator::validate(request()->all(), ['inviteFile' => 'max:55000|mimes:mp4,mkv']);
            $invite->attach_sample = uploadFile(request()->file('inviteFile'), $folderPath);
        }

        $invite->type = 'teacher';
        $invite->code = $code;
        $invite->fullname = $data['fullname'];
        $invite->phonenumber = $data['phonenumber'];
        $invite->tel = $data['tel'];
        $invite->birthdate = $data['birthdate'];
        $invite->id_state = $data['id_state'];
        $invite->id_city = $data['id_city'];
        $invite->memo = $data['memo'];
        $invite->madrak = $data['madrak'];
        $invite->reshte = $data['reshte'];
        $invite->daneshgah = $data['daneshgah'];
        $invite->company_name_1 = $data['company_name_1'];
        $invite->company_name_2 = $data['company_name_2'];
        $invite->company_type_work_1 = $data['company_type_work_1'];
        $invite->company_type_work_2 = $data['company_type_work_2'];
        $invite->history_title_1 = $data['history_title_1'];
        $invite->history_title_2 = $data['history_title_2'];
        $invite->history_type_1 = $data['history_type_1'];
        $invite->history_type_2 = $data['history_type_2'];
        $invite->history_link_1 = $data['history_link_1'];
        $invite->history_link_2 = $data['history_link_2'];

//        if ($data['id_cat_mega_1'] !== '') $invite->id_cat_mega_1 = $data['id_cat_mega_1'];
//        if ($data['id_cat_mega_2'] !== '') $invite->id_cat_mega_2 = $data['id_cat_mega_2'];
//        if ($data['id_cat_middle_1'] !== '') $invite->id_cat_middle_1 = $data['id_cat_middle_1'];
//        if ($data['id_cat_middle_2'] !== '') $invite->id_cat_middle_2 = $data['id_cat_middle_2'];
//        if ($data['id_cat_sub_1'] !== '') $invite->id_cat_sub_1 = $data['id_cat_sub_1'];
//        if ($data['id_cat_sub_2'] !== '') $invite->id_cat_sub_2 = $data['id_cat_sub_2'];

        $invite->regist_date = nowDateShamsi();
        $invite->status = 0;
        $invite->save();

        sendSMSInviteTeacher($data['phonenumber'], $data['fullname']);

        return redirect(route('web.invite-teacher'))->with('store_invite_teacher_success', 'اطلاعات با موفقیت ثبت شد');
    }
}
