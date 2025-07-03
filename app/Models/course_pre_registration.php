<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class course_pre_registration extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'is_notification_sent',
    ];

    //

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(course::class, 'course::class_id');
    }
}
