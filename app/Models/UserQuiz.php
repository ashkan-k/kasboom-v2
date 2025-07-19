<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuiz extends Model
{
    use HasFactory;
    protected $table = 'user_quizs';

    public function questions()
    {
        return $this->belongsTo(QuizQuestion::class, 'id_quize_questions');
    }

}
