<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    use HasFactory;
    protected $table = 'kasboom_bugs';

    public function lesson () {
        return $this->belongsTo(Lesson::class, 'id_target');
    }

    public function getCreatedAtAttribute($date){
        return
            [
                'time' => jdate($date)->format('H:i'),
                'date' => jdate($date)->format('Y/m/d')
            ];
    }

    public function getResponseDateAttribute($date){
        return
            [
                'isNull' => $date ? false : true,
                'time' => jdate($date)->format('H:i'),
                'date' => jdate($date)->format('Y/m/d')
            ];
    }

}
