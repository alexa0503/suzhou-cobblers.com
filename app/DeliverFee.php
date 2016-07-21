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
}
