<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categoryMega extends Model
{
    protected $table = 'category_mega';

  public function blogs() {
    return $this->hasMany('App\blog', 'id_cat_mega');
  }

  public function courses() {
    return $this->hasMany('App\course', 'id_mega');
  }

  public function consults() {
    return $this->hasMany('App\consult', 'id_mega');
  }

  public function webinars() {
    return $this->hasMany('App\webinar', 'id_cat_mega');
  }

  public function idea() {
    return $this->hasMany('App\wikiidea', 'id_mega');
  }

}
