<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'skill_messages';

    public function user() {
        return $this->belongsTo(User::class, 'id_owner');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'id_target');
    }

}
