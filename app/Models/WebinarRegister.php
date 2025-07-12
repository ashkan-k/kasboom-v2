<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarRegister extends Model
{
    use HasFactory;
    protected $table = 'webinar_registers';

    public function webinar(){
        return $this->belongsTo(Webinar::class, 'id_webinar');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

}
