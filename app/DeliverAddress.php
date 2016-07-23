<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverAddress extends Model
{
    protected $fillable = [
        'country_id',
        'province_id',
        'city_id',
        'detailed_address',
        'zip_code',
        'first_name',
        'last_name',
        //'phone_district',
        'phone_number',
        'user_id',
        'locale',
        'is_default',
    ];
    public function country()
    {
        return $this->hasOne('App\WorldCity','id','country_id');
    }
    public function city()
    {
        return $this->hasOne('App\WorldCity','id','city_id');
    }
    public function province()
    {
        return $this->hasOne('App\WorldCity','id','province_id');
    }
}
