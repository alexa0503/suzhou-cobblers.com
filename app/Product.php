<?php

namespace App;
use App;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getStatusTitleAttribute($value)
    {
        return $this->is_active == 1 ? '正常' : '禁用';
    }
    public function getPreviewImageAttribute($value)
    {
        return isset($this->thumb) ? $this->thumb->image_path : null;
    }
    public function getSizesAttribute($value)
    {
        return isset($this->sizeType) ? unserialize($this->sizeType->value) : [];
    }
    public function getTitleAttribute($value)
    {
        return isset($this->localeTitle) ? $this->localeTitle->value : null;
    }
    public function getDescAttribute($value)
    {
        return isset($this->localeDesc) ? $this->localeDesc->value : null;
    }
    public function getReturnDescAttribute($value)
    {
        return isset($this->localeReturnDesc) ? $this->localeReturnDesc->value : null;

    }
    public function getCleanDescAttribute($value)
    {
        return isset($this->localeCleanDesc) ? $this->localeCleanDesc->value : null;

    }
    public function getPriceAttribute($value)
    {
        return isset($this->localePrice) ? $this->localePrice->value : 0;
    }
    public function properties()
    {
        return $this->hasMany('App\ProductProperty');
    }
    public function localeProperties()
    {
        return $this->hasMany('App\ProductProperty')->where('locale', App::getLocale());
    }
    public function localeTitle()
    {
        return $this->hasOne('App\ProductProperty')
            ->where('locale', App::getLocale())
            ->where('name', 'title');
    }
    public function localeDesc()
    {
        return $this->hasOne('App\ProductProperty')
            ->where('locale', App::getLocale())
            ->where('name', 'desc');
    }
    public function localeReturnDesc()
    {
        return $this->hasOne('App\ProductProperty')
            ->where('locale', App::getLocale())
            ->where('name', 'return_desc');
    }
    public function localeCleanDesc()
    {
        return $this->hasOne('App\ProductProperty')
            ->where('locale', App::getLocale())
            ->where('name', 'clean_desc');
    }
    public function sizeType()
    {
        return $this->belongsTo('App\ProductSizeType','size_type_id');
    }
    public function prices()
    {
        return $this->hasMany('App\ProductPrice');
    }
    public function localePrice()
    {
        return $this->hasOne('App\ProductPrice')->where('locale', App::getLocale());
    }
    public function type()
    {
        return $this->belongsTo('App\ProductType');
    }
    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }
    public function thumb()
    {
        return $this->hasOne('App\ProductImage');
    }
}
