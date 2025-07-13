<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $table = 'payments';

    public function getCreatedAtAttribute ($date) {
        return jdate($date)->format('H:i Y/m/d');
    }

    public function getUserName()
    {
        if($this->id_user != null and $this->id_user >0){
            $item=User::where('id','=',$this->id_user)->first();
            if ($item != null)
                return $item->name;
            else
                return "-----";
        }
        else return '-----';
    }

    public function getConsultName()
    {
        if($this->id_consult != null and $this->id_consult >0){
            $item=consult::where('id','=',$this->id_consult)->first();
            if ($item != null)
                return $item->fullname;
            else
                return "-----";
        }
        else return '-----';
    }

    public function user () {
        return $this->belongsTo(User::class, 'id_user');
    }
}
