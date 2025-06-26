<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'categories';

    public function courses()
    {
        return $this->hasMany('App\Models\course', 'id_category');
    }

    public function getImage()
    {
        return "/assets-v2/images/small-category/".$this->image;
    }
    public function wikiidea()
    {
        return $this->hasMany('App\Models\wikiidea', 'id_category');
    }

    public function path()
    {
        return url("product/search?cat_id=$this->id");
    }
}
