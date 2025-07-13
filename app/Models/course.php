<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class course extends Model
{
    protected $table = 'skill_courses';

    public function getSlug()
    {
        return $this->slug ?: '---';
    }

    //

    public function category() {
        return $this->belongsTo('App\Models\categoryMega', 'id_mega');
    }

  public function categoryMiddle() {
    return $this->belongsTo('App\Models\categoryMiddle', 'id_middle');
  }
  public function categorySub() {
    return $this->belongsTo('App\Models\categorySub', 'id_sub');
  }

    public function teacher() {
        return $this->belongsTo('App\Models\teacher', 'id_teacher');
    }

    public function lessons()
    {
        return $this->hasMany('App\Models\lesson', 'id_course');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\comment', 'id_course');
    }

    public function chatroom()
    {
//        return $this->hasMany('App\Models\chatroom', 'id_course');
        return $this->belongsTo('App\Models\chatroom', 'id_course');
    }

    public function classroom()
    {
        return $this->hasMany('App\Models\classroom', 'id_course');
    }



    public function questions()
    {
        return $this->hasMany('App\Models\quiz_question', 'id_course');
    }

    public function getCategoryTitle()
    {
        if($this->id_category != null and $this->id_category >0) {
            $info=category::where('type','=','course')->where('id','=',$this->id_category)->first();
            if($info != null)
                return $info->title;
            else
                return "-----";
        }
        else return '-----';
    }

    public function getMobileSlider()
    {
        return "_upload_/_courses_/".$this->code ."/".$this->img_slider_mobile;
    }

    public function getSlider()
    {
        return "_upload_/_courses_/".$this->code ."/".$this->img_slider;
    }

    public function getThumbnail()
    {
        if($this->type == "course")
            return "_upload_/_courses_/".$this->code."/medium_".$this->image;
        else
            return "_upload_/_courses_/".$this->code."/".$this->image;
    }

    public function getTecherName()
    {
        if($this->id_teacher != null and $this->id_teacher >0) {
            $info=teacher::where('id','=',$this->id_teacher)->first();
            if($info != null)
                return $info->fullname;
            else
                return "-----";
        }
        else return '-----';

   }

    public function complete(){
        return $this->hasMany(UserLesson::class, 'id_course');
    }
}


