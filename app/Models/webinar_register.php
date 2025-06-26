<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class webinar_register extends Model
{
    protected $table = 'webinar_registers';

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

  public function user() {
    return $this->belongsTo('App\Models\User', 'id_user');
  }

}
