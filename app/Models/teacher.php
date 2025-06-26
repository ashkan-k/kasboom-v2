<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class teacher extends Model
{
    protected $table = 'teachers';

    public function comments()
    {
        return $this->hasMany('App\comment', 'id_teacher');
    }

    public function courses()
    {
        return $this->hasMany('App\course', 'id_teacher');
    }
}
