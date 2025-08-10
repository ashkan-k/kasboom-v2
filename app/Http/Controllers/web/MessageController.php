<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\classroom;
use App\Models\Course;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function allMessages(Request $request)
    {
        $user = auth()->user();
        $limit = 10;
        $search = arToFa(request()->search);

        if ($user->getLevelUrl() === "teacher") {
            $courses = Course::where("id_teacher", $user->id_teacher)->select("id")->get();
            $query = Message::where("type", "course")->whereIn("id_target", $courses);
        }
        else $query = Message::where('id_owner', $user->id);

        if ($search)
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%$search%");
            });

        if (\request('read_status') == 'new'){
            $query = $query->where('read_status', 0);
        }
        elseif (\request('read_status') == 'expired'){
            $query = $query->where('read_status', 1);
        }

//        $query->orderBy(request()->sortBy, request()->descending === 'false' ? 'asc' : 'desc')->with('user:id,name');
        $query->with('user:id,name');
        $messages = $query->paginate($limit);

        return view('web.messages', compact('messages'));
    }

    public function storeReplayMessage()
    {
        $data = json_decode(request()->message,true);
        $id = $data['id'];
        $message = Message::where("id", $id)->first();
        $replay_message = arToFa($data['replay_message']);

        if(empty($replay_message))
            return ['success' => false, 'message' => 'پاسخ پیام نباید خالی باشد'];

        if(!$message) return ['success' => false, 'message' => 'چیزی یافت نشد'];

        $courses = Course::where([['id', $message->id_target], ["id_teacher", auth()->user()->id_teacher]])->first();
        if (!$courses && $message->type === 'course')
            return ['success' => false, 'message' => 'چیزی یافت نشد'];

//        set ticket_date_to
        $classroom = classroom::where([['id_user', $message->id_owner], ['id_course', $message->id_target]])->first();
        if (!$classroom->ticket_date_to) {
            $nowDate = date('Y-m-d', strtotime('+1 month'));
            $classroom->ticket_date_to = jdate($nowDate)->format('%Y/%m/%d');
            $classroom->save();
        }

        $message->replay_message = $replay_message;
        $message->replay_date = nowDateShamsi();
        $message->read_status = 1;
        $message->is_publish = $data['is_publish'];
        $message->save();

        return ['success' => true, 'message' => 'ارسال پاسخ پیام با موفقیت ثبت شد'];
    }

}
