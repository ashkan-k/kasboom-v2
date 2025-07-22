<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    use HasFactory;
    protected $table = 'user_favorites';

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'id_target');
    }

    public function webinar()
    {
        return $this->belongsTo(webinar::class, 'id_target');
    }

    public function idea()
    {
        return $this->belongsTo(wikiidea::class, 'id_target');
    }

    public function course()
    {
        return $this->belongsTo(course::class, 'id_target');
    }
}
