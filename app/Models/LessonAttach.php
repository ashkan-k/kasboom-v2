<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonAttach extends Model
{
    use HasFactory;
    protected $table = 'skill_lesson_attachments';

    public function lessons(){
        return $this->belongsTo(Lesson::class, 'id_lesson');
    }

}
