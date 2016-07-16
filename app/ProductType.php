<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use App;

class ProductType extends Model
{
    public $timestamps = false;
    public function getTitleAttribute($value)
    {
        return isset($this->localeProperty) ? $this->localeProperty->name : $this->title;
    }
    public function getDescAttribute($value)
    {
        return isset($this->localeProperty) ? $this->localeProperty->desc : '';
    }
    public function properties()
    {
        return $this->hasMany('App\ProductTypeProperty');
    }
    public function localeProperty()
    {
        return $this->hasOne('App\ProductTypeProperty')->where('locale', App::getLocale());
    }
}
