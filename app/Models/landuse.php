<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class landuse extends Model
{
    protected $table = 'blog_landuses';

    public function getStateName()
    {
        if($this->id_state != null and $this->id_state >0) {
            $item = state::where('id', '=', $this->id_state)->first();
            if ($item != null)
                return $item->name;
            else
                return "-----";
        }
        else
            return '-----';
    }

    public function getCityName()
    {
        if($this->id_city >0) {
            $item = city::where('id', '=', $this->id_city)->first();
            if ($item != null)
                return $item->name;
            else
                return "-----";
        }
        elseif($this->id_city == 0) {
            if($this->id_state != null and $this->id_state >0) {
                $item = state::where('id', '=', $this->id_state)->first();
                if ($item != null)
                    return $item->name;
                else
                    return "-----";
            }
            else
                return '-----';
        }
    }



}
