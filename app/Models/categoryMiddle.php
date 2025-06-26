<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categoryMiddle extends Model
{
    protected $table = 'category_middle';

    public function blogs() {
      return $this->hasMany('App\blog', 'id_cat_middle');
    }

}
