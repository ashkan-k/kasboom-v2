<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KasboomCoupon extends Model
{
  use SoftDeletes;
  protected $table = 'kasboom_coupons';
  protected $casts = ['courses' => 'array', 'webinars' => 'array', 'users' => 'array', 'users_use' => 'array'];

}
