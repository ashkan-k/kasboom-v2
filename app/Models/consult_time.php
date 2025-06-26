<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class consult_time extends Model
{
    protected $table = 'consult_times';

    public function getUserName()
    {
        if($this->id_user != null and $this->id_user >0) {
            $info=User::where('id','=',$this->id_user)->first();
            if($info != null)
                return $info->name;
            else
                return "-----";
        }
        else return '-----';
    }

    public function getConsultName()
    {
        if($this->id_consult != null and $this->id_consult >0) {
            $info=consult::where('id','=',$this->id_consult)->first();
            if($info != null)
                return $info->fullname;
            else
                return "-----";
        }
        else return '-----';
    }

}
