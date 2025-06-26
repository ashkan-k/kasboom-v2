<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categorySub extends Model
{
    protected $table = 'category_sub';

    public function blogs() {
      return $this->hasMany('App\blog', 'id_cat_sub');
    }

}
