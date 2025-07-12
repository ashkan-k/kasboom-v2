<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_quiz extends Model
{
    protected $table = 'user_quizs';


    public function questions()
    {
//        return $this->hasMany('App\chatroom', 'id_course');
        return $this->belongsTo('App\quiz_question', 'id_quize_questions');
    }


}
