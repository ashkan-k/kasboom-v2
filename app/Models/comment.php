<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    protected $table = 'comments';

    public function user() {
        return $this->belongsTo('App\Models\User', 'id_user');
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
    public function getUserImage()
    {
        if($this->id_user != null and $this->id_user >0){
            $item=User::where('id','=',$this->id_user)->first();
            if ($item != null)
                return $item->image;
            else
                return "-----";
        }
        else return '-----';
    }

    public function getCourseName()
    {
        if($this->id_target != null and $this->id_target >0){
            $item= course::where('id','=',$this->id_target)->first();
            if ($item != null)
                return $item->title;
            else
                return "-----";
        }
        else return '-----';
    }

    public function getConsultName()
    {
        if($this->id_target != null and $this->id_target >0){
            $item= consult::where('id','=',$this->id_target)->first();
            if ($item != null)
                return $item->fullname;
            else
                return "-----";
        }
        else return '-----';
    }

    public function getWorkshopTitle()
    {
        if($this->id_target != null and $this->id_target >0){
            $item= workshop::where('id','=',$this->id_target)->first();
            if ($item != null)
                return $item->title;
            else
                return "-----";
        }
        else return '-';
    }

    public function getBlogTitle()
    {
        if($this->id_target != null and $this->id_target >0){
            $item= blog::where('id','=',$this->id_target)->first();
            if ($item != null)
                return $item->title;
            else
                return "-----";
        }
        else return '-----';
    }

    public function getNewsTitle()
    {
        if($this->id_target != null and $this->id_target >0) {
            $item=news::where('id', '=', $this->id_target)->first();
            if($item != null)
                return $item->title;
            else
                return "-----";
        }
        else return '-----';
    }

    public function getHireTitle()
    {
        if($this->id_target != null and $this->id_target >0) {
            $item = hire::where('id', '=', $this->id_target)->first();
            if ($item != null)
                return $item->title;
            else
                return "-----";
        }
        else
            return '-----';
    }

    public function getTeacherName()
    {
        if($this->id_target != null and $this->id_target >0){
            $item=teacher::where('id','=',$this->id_target)->first();
            if ($item != null)
                return $item->fullname;
            else
                return "-----";
        }
        else return '-----';
    }

    public function getWikiName()
    {
        if($this->id_target != null and $this->id_target >0){
            $item= wikiidea::where('id','=',$this->id_target)->first();
            if ($item != null)
                return $item->title;
            else
                return "-----";
        }
        else return '-----';
    }

    public function getProductName()
    {
        if($this->id_target != null and $this->id_target >0){
            return product::where('id','=',$this->id_target)->first();
            if ($item != null)
                return $item->title;
            else
                return "-----";
        }
        else return '-----';
    }

  public function course() {
    return $this->belongsTo(course::class, 'id_target');
  }

  public function webinar() {
    return $this->belongsTo(webinar::class, 'id_target');
  }

  public function teacher() {
    return $this->belongsTo(teacher::class, 'id_target');
  }

}
