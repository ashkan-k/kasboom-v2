<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;
    protected $table = 'quiz_questions';

    public function course(){
        return $this->belongsTo(Course::class, 'id_course');
    }

}
