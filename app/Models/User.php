<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use KasboomShop\Model\ChamberProductCart;

class User extends Authenticatable
{

    // Constants
    const PERMISSION_LEVEL_NONE = 0b0000000000000000;
    const PERMISSION_LEVEL_VIEW = 0b0000000000000001;
    const PERMISSION_LEVEL_CREATE = 0b0000000000000010;
    const PERMISSION_LEVEL_UPDATE = 0b0000000000000100;
    const PERMISSION_LEVEL_DELETE = 0b0000000000001000;
    const PERMISSION_LEVEL_COMMENT = 0b0000000000010000;
    const PERMISSION_LEVEL_ALL_OPERATIONS = 0b0000000000011111;

    const PERMISSION_LEVEL_ADMIN_LISTING = 0b0000000000100000;
    const PERMISSION_LEVEL_ADMIN_ALL_OPERATIONS = 0b0000000000111111;
    const referral_price = 5000;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function teacher() {
        return $this->belongsTo('App\Models\teacher', 'id_teacher');
    }


    public function saller() {
        return $this->belongsTo('App\Models\saller', 'id_saller');
    }

    public function isManager()
    {

        return ($this->level == 'manager' || $this->level == 'modirKol');
    }

    public function isWriter()
    {
        return $this->level == 'writer';
    }

    public function consult() {
        return $this->belongsTo('App\Models\consult', 'id_consult');
    }
    public function isSupervisor()
    {
        return $this->level == 'supervisor';
    }

    public function isUser()
    {
        return $this->level == 'user';
    }

    public function isTeacher()
    {
        return $this->level == 'teacher';
    }

    public function isConsult()
    {
        return $this->level == 'consult';
    }

    public function isModirMarkaz()
    {
        return $this->level == 'modirMarkaz';
    }

    public function isModirKol()
    {
        return $this->level == 'modirKol';
    }

    public function isSaller()
    {
        return $this->level == 'saller';
    }

    public function getLevelTitle()
    {
        if($this->level == 'manager')
            return "مدیر کل";
        elseif($this->level == 'supervisor')
            return "ناظر";
        elseif($this->level == 'admin')
            return "مدیر مرکز خدمات";
        elseif($this->level == 'teacher')
            return "مدرس";
        elseif($this->level == 'Seller')
            return "فروشگاه";
        elseif($this->level == 'user')
            return "مهارت آموز";
        return $this->level;
    }

    public function getLevelUrl()
    {
        if($this->level == 'manager')
            return "_manager";
        elseif($this->level == 'modirMarkaz')
          return "admin";
        elseif($this->level == 'modirKol')
          return "admin";
        else
          return "web";

    }

    public function getImageFolder()
    {
        if($this->level == 'manager')
            return "_users_";
        elseif($this->level == 'admin')
            return "_markaz_";
        elseif($this->level == 'supervisor')
            return "_supervisor_";
        elseif($this->level == 'teacher')
            return "teachers_";
        elseif($this->level == 'seller')
            return "_sallers_";
        elseif($this->level == 'user')
            return "_users_";
        elseif($this->level == 'modirMarkaz')
            return "_users_";
        elseif($this->level == 'modirKol')
          return "_users_";
        else
          return "_users_";
    }

    public function hasPermission($permission, $permission_level)
    {
        return (($permission & $permission_level) == $permission_level)?true:false;
    }

    public function state()
    {
      return $this->hasOne(state::class, 'id', 'id_state');
    }

    public function city()
    {
      return $this->hasOne(city::class, 'id', 'id_city');
    }
}
