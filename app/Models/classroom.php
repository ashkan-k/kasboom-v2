<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class classroom extends Model
{
    protected $table = 'skill_class_room';

    public function user() {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function user_quizs()
    {
        return $this->hasMany('App\Models\user_quiz', 'id_class_room');
    }

    public function course(){
        return $this->belongsTo(course::class, 'id_course');
    }

    public function courses()
    {
        return $this->hasMany('App\Models\user_quiz', 'id_class_room');
    }

    public function getUserName()
    {
        if($this->id_user != null and $this->id_user >0) {
            $info= User::where('id','=',$this->id_user)->first();
            if($info != null)
                return $info->name;
            else
                return "-----";
        }
        else return '-----';

    }

    public function getUserImage()
    {
        if($this->id_user != null and $this->id_user >0) {
            $info=User::where('id','=',$this->id_user)->first();
            if($info != null)
                return $info->image;
            else
                return "-----";
        }
        else return '-----';
    }

    public function getCourseName()
    {
        if($this->id_course != null and $this->id_course >0) {
            $info=course::where('id','=',$this->id_course)->first();
            if($info != null)
                return $info->title;
            else
                return "-----";
        }
        else return '-----';

    }

}
