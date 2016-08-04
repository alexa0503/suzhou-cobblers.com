<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverFee extends Model
{
    public $timestamps = false;
    public function getValueAttribute($value)
    {
        return json_decode($value,true);
    }
    public function type()
    {
        return $this->belongsTo('App\DeliverType','type_id');
    }
    public function city()
    {
        return $this->belongsTo('App\WorldCity','city_id');
    }
}
