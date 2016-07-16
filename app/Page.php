<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
class Page extends Model
{
    public $timestamps = false;
    public function getContentAttribute($value)
    {
        return isset($this->localeProperty) ? $this->localeProperty->desc : '';
    }
    public function properties()
    {
        return $this->hasMany('App\PageProperty');
    }
    public function localeProperty()
    {
        return $this->hasOne('App\PageProperty')->where('locale', App::getLocale());
    }
}
