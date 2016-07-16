<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
class Press extends Model
{
    public function getTitleAttribute($value)
    {
        return isset($this->localeTitle) ? $this->localeTitle->value : null;
    }
    public function getTitleCnAttribute($value)
    {
        return isset($this->localeTitleCn) ? $this->localeTitleCn->value : null;
    }
    public function getTitleEnAttribute($value)
    {
        return isset($this->localeTitleEn) ? $this->localeTitleEn->value : null;
    }
    public function localeTitle()
    {
        return $this->hasOne('App\PressProperty')
            ->where('locale', App::getLocale())
            ->where('name', 'title');
    }
    public function localeTitleCn()
    {
        return $this->hasOne('App\PressProperty')
            ->where('locale', 'zh-cn')
            ->where('name', 'title');
    }
    public function localeTitleEn()
    {
        return $this->hasOne('App\PressProperty')
            ->where('locale', 'en')
            ->where('name', 'title');
    }
    public function properties()
    {
        return $this->hasMany('App\PressProperty');
    }
    public function localeProperties()
    {
        return $this->hasMany('App\PressProperty')->where('locale', App::getLocale());
    }
    public function parent()
    {
        return $this->belongsTo('App\Press', 'parent_id');
    }
    public function subPresses()
    {
        return $this->hasMany('App\Press', 'parent_id');
    }
}
