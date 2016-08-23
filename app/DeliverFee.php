<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverFee extends Model
{
    public $timestamps = false;
    protected $fillable =  ['value', 'type_id', 'city_id'];
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
