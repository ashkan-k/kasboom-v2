<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Notify;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\CalendarUtils;

class WebPanelUserController extends Controller
{
    public function dashboard()
    {
        Auth::loginUsingId(1);

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
}
