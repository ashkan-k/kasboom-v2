<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'kasboom_notifications';

    public function getCreatedAtAttribute($date){
        return
            [
                'jalali' => jdate($date)->format('H:i - Y/m/d')
            ];
    }

    public function getUpdatedAtAttribute($date){
        return
            [
                'jalali' => jdate($date)->format('H:i - Y/m/d')
            ];
    }

}
