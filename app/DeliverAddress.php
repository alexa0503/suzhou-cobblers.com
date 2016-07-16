<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverAddress extends Model
{
    protected $fillable = [
        'country',
        'province',
        'city',
        'detailed_address',
        'zip_code',
        'first_name',
        'last_name',
        'phone_district',
        'phone_number',
        'user_id',
        'locale',
        'is_default',
    ];
    public function getPhoneDistrictAttribute($value)
    {
        $arr = explode(' ',$value);
        return $arr[0];
    }
    public function getPhoneNumberAttribute($value)
    {
        $arr = explode(' ',$value);
        return $arr[1];
    }
}
