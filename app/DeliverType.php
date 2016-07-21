<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverType extends Model
{
    public $timestamps = false;
    public function fees()
    {
        return $this->hasMany('App\DeliverFee');
    }
}
