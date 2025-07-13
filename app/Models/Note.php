<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $table = 'skill_notes';

    public function lessons(){
        return $this->belongsTo(Lesson::class, 'id_lesson');
    }

    public function getCreatedAtAttribute($date){
        if ($date === '' || $date === null) return '';
        return jdate($date)->format('Y/n/j');
    }

}
