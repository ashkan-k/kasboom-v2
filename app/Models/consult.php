<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class consult extends Model
{
    protected $table = 'consults';

    public function comments()
    {
        return $this->hasMany('App\Models\comment', 'id_consult');
    }

    public function category() {
        return $this->belongsTo('App\Models\category', 'id_category');
    }


    public function getCategoryTitle()
    {

        if($this->id_category != null and $this->id_category >0) {
            $info= category::where('type','=','consult')->where('id','=',$this->id_category)->first();
            if($info != null)
                return $info->title;
            else
                return "-----";
        }
        else return '-----';
    }




}
