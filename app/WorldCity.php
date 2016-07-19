<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class WorldCity extends Model
{
    public $timestamps = false;
    public function getNameAttribute($value)
    {
        return App::getLocale() == 'zh-cn' ? $this->name_cn : $this->name_en;
    }
    public function sub()
    {
        return $this->hasMany('App\WorldCity', 'parent_id');
    }
}
