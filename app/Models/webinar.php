<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class webinar extends Model
{
    protected $table = 'webinars';

    protected  $accessdenide_response = [
        'error' => true,
        'data' => '',
        'message' => 'شما مجوز این عملیات را ندارید',
        'type' => 'error'
    ];

    public function category() {
        return $this->belongsTo('App\Models\category', 'id_category');
    }

    public function getCategoryTitle()
    {
        if($this->id_category != null and $this->id_category >0) {
            $info=category::where('type','=','webinar')->where('id','=',$this->id_category)->first();
            if($info != null)
                return $info->title;
            else
                return "-----";
        }
        else return '-----';
    }

}
