<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lesson extends Model
{
    protected $table = 'skill_lessons';

    public function userlesson()
    {
        return $this->hasMany('App\Models\userlesson', 'id_lesson');
    }

    public function lesson_attachments()
    {
        return $this->hasMany('App\Models\lesson_attach', 'id_lesson');
    }

}
